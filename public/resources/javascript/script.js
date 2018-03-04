//au chargement du DOM
$(function()
{
	//mode ajout
	addMode();

	//ajout des gestionnaires d'événements
	$('.list tr').on('click', showDetails);
	$('.add').on('click', addContact);
	$('.update').on('click', updateContact);
	$('.delete').on('click', deleteContact);
});


/* ---------- Modes ajout / édition ---------- */

//affiche les boutons du mode "ajout" et vide les champs d'édition
function addMode() {
	$(".list tr").removeClass('selected');

	$(".add").show();
	$(".update").hide();
	$(".delete").hide();

	$(".update").attr("data-id", "");
	$(".delete").attr("data-id", "");

	$(".data td[contenteditable='true']").text("");
	$('.city option[value=""]').prop('selected', true);
}

//affiche les boutons du mode "édition" et passe l'id du contact édité
function editMode(tr) {
	$(".list tr").removeClass('selected');
	tr.addClass("selected");

	$(".add").hide();
	$(".update").show();
	$(".delete").show();

	id = tr.attr("data-id");
	$(".update").attr("data-id", id);
	$(".delete").attr("data-id", id);
}


/* ---------- Fonctions AJAX ---------- */

//récupère et affiche les données d'un contact dans le tableau d'édition
function showDetails() {
	if ($(this).hasClass('selected')) {
		//mode ajout
		addMode();
	}
	else {
		//mode édition
		editMode($(this));
		var root = $('base').attr('href');

		//requête XHR
		$.ajax({
			method:'post',
			url:root+'contacts/showOne',
			data: 
			{
				id: id
			},
			success: function(contact)
			{
				if (contact !== false) {
					//affichage des infos récupérées
					contact = JSON.parse(contact); 
					$(".name").text(contact.name);
					$(".firstName").text(contact.firstName);
					$(".mail").text(contact.mail);
					$(".phone").text(contact.phone);
					$('.city option[value="'+contact.city+'"]').prop('selected', true);
				}
				else {
					alert('Erreur lors de l\'affichage des données.')
				}
			}
		});
	}
}

//ajout d'un contact
function addContact() {
	var root = $('base').attr('href');

	//récupération des informations saisies
	var name = $(".name").text();
	var firstName = $(".firstName").text();
	var mail = $('.mail').text();
	var phone = $('.phone').text();
	var city = $('.city').val();

	//requête XHR
	$.ajax({
		method:'post',
		url:root+'contacts/add',
		data: 
		{
			name: name,
			firstName: firstName,
			mail: mail,
			phone: phone,
			city: city
		},
		success: function(info)
		{
			//si on a des erreurs à afficher
			if (info.length > 0) {
				erreur = JSON.parse(info); 
				alert(erreur);
			}
			//si l'ajout s'est bien passé
			else {
				alert('Le contact a bien été ajouté.');
				location.reload();
			}
		}
	});
}

//mise à jour d'un contact
function updateContact() {
	var id = $(this).data('id');
	var root = $('base').attr('href');
	
	//récupération des informations saisies
	var name = $(".name").text();
	var firstName = $(".firstName").text();
	var mail = $('.mail').text();
	var phone = $('.phone').text();
	var city = $('.city').val();	

	//requête XHR
	$.ajax({
		method:'post',
		url:root+'contacts/update',
		data: 
		{
			id: id, 
			name: name,
			firstName: firstName,
			mail: mail,
			phone: phone,
			city: city
		},
		success: function(info)
		{
			//si on a des erreurs à afficher
			if (info.length > 0) {
				erreur = JSON.parse(info); 
				alert(erreur);
			}
			//si l'ajout s'est bien passé
			else {
				alert('Le contact a bien été modifié.');
				location.reload();
			}
		}
	});
}

//suppression d'un contact
function deleteContact() {
	var id = $(this).data('id');
	var root = $('base').attr('href');

	//requête XHR
	$.ajax({
		method:'post',
		url:root+'contacts/delete',
		data: 
		{
			id: id
		},
		success: function(info)
		{
			//si on a des erreurs à afficher
			if (info.length > 0) {
				erreur = JSON.parse(info); 
				alert(erreur);
			}
			//si l'ajout s'est bien passé
			else {
				alert('Le contact a bien été supprimé.');
				location.reload();
			}
		}
	});
}
