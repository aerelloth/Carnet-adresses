<h1>Carnet d'adresses</h1>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php if ($contacts !== false): ?>
				<p>Sélectionnez un contact dans la liste pour l'éditer.</p>
			<?php endif; ?>
		</div>
		<div class="col-md-6">
			<div class="table-top">
				<h2>Contacts</h2>
				<button class="btn add">Créer</a>
			</div>
			<table class="table list">
				<?php if ($contacts !== false): ?>
					<?php foreach($contacts as $contact): ?>
						<tr data-id="<?= $contact['id']?>">
							<td><?= $contact['name']?> <?= $contact['firstName']?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</table>
		</div>
		<div class="col-md-6">
			<div class="table-top row">
				<div class="col-xs-12 col-sm-5 col-md-12 col-lg-5"><h2>Coordonnées</h2></div>
				<div class="buttons col-xs-12 col-sm-7 col-md-12 col-lg-7">
					<button class="btn update" data-id="" style="display: none;">Editer</button>
					<button class="btn delete" data-id="" style="display: none;">Supprimer</button>
				</div>
			</div>
			<table class="table data">
				<tr>
					<td>Nom</td>
					<td contenteditable="true" class="name"></td>
				</tr>
				<tr>
					<td>Prénom</td>
					<td contenteditable="true" class="firstName"></td>
				</tr>
				<tr>
					<td>E-mail</td>
					<td contenteditable="true" class="mail"></td>
				</tr>
				<tr>
					<td>Téléphone</td>
					<td contenteditable="true" class="phone"></td>
				</tr>
				<tr>
					<td>Ville</td>
					<td>
						<select name="city" id="city" class="city">
							<option value="" selected></option>
							<option value="Lyon">Lyon</option>
							<option value="Marseille">Marseille</option>
							<option value="Paris">Paris</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>