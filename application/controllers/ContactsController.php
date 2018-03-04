<?php 

class ContactsController extends Controller
{
	private $contactsManager;

	public function __construct()
	{
	  $this->contactsManager = new ContactsManager();
	}

/* ---------- PAGE PRINCIPALE ---------- */

	public function contactsAction() 
	{
		//récup des infos des différents contacts
		$this->viewData['contacts'] = $contacts = $this->contactsManager->getAll(); 
		$this->generateView('contacts.php');
	}



/* ---------- Récupération AJAX des infos d'un contact ---------- */

	public function showOneAction() 
	{
		//récup des infos du contact sélectionné
		$contact = $this->contactsManager->getOneById($_POST['id']);
		echo json_encode($contact);
	}



/* ---------- Méthodes CRUD ---------- */

	public function addAction() 
	{
		//vérification des données entrées
		$post = $this->checkPostValues();

		if (isset($post)) {
			//envoi des données
			$enteredData =
			[
				'NOM' => strtoupper($post['name']),
				'PRENOM' => $post['firstName'],
				'EMAIL' => $post['mail'],
				'TEL' => $post['phone'],
				'CITY' => $post['city']
			];
			$this->contactsManager->addOne($enteredData);
		}
	}

	public function updateAction() 
	{
		//vérification des données entrées
		$post = $this->checkPostValues();
		$id = $this->checkId();

		if (isset($post)) {

			$enteredData =
			[
				'NOM' => strtoupper($post['name']),
				'PRENOM' => $post['firstName'],
				'EMAIL' => $post['mail'],
				'TEL' => $post['phone'],
				'CITY' => $post['city'],
				'ID_NUMCONTACT' => $id
			];
			$this->contactsManager->update($enteredData);
		}

	}

	public function deleteAction() {
		//vérification des données entrées
		$id = $this->checkId();
		$this->contactsManager->removeOne($id);
	}



/* ---------- Vérifications des données ---------- */

	private function checkPostValues() {
		if (!isset($_POST) || empty($_POST)) {
			$this->error('Veuillez vérifier les champs entrés.');
		}

		//vérification de la présence des champs
		$fields = array('name', 'firstName', 'mail', 'phone', 'city');
		$check = $this->checkFieldsSet($_POST, $fields);
		if ($check === false) {
			$this->error('Veuillez vérifier les champs entrés.');
		}

		//vérification du remplissage des champs requis
		$fields_required = array('name', 'firstName');
		$check = $this->checkFieldsFilled($_POST, $fields_required);
		if ($check === false) {
			$this->error('Les champs "nom" et "prénom" sont requis.');
		}

		//vérification du format des données
		if (!empty($_POST['mail'])) {
			$check = $this->checkMail($_POST['mail']);
			if ($check === false) {
				$this->error('Veuillez vérifier votre email.');
			}
		}
		if (!empty($_POST['phone'])) {
			$check = $this->checkPhone($_POST['phone']);
			if ($check === false) {
				$this->error('Veuillez vérifier votre numéro de téléphone (10 chiffres, format français).');
			}
			else {
				$_POST['phone'] = $check;
			}
		}
		if (!empty($_POST['city'])) {
			$check = $this->checkCity($_POST['city']);
			if ($check === false) {
				$this->error('Veuillez sélectionner une ville de la liste.');
			}
		}
		return $_POST;
	}

	private function checkId() {
		if (!isset($_POST) || !isset($_POST['id']) || empty($_POST['id']) || !is_numeric($_POST['id'])) {
			$this->error('Erreur lors de la récupération des informations.');
		}
		if ($this->contactsManager -> getOneById($_POST['id']) === false) {
			$this->error('Le contact sélectionné n\'est pas présent en base de données.');
		}
		return $_POST['id'];
	}



/* ---------- Sous-méthodes de vérification des données ---------- */

	private function checkFieldsSet($post, $fields) {
		$check = true;
		foreach ($fields as $field) {
			if (!isset($post[$field])) {
				$check = false;
			}
		}
		return $check;
	}

	private function checkFieldsFilled($post, $required_fields) {
		$check = true;
		foreach ($required_fields as $field) {
			if (empty($post[$field])) {
				$check = false;
			}
		}
		return $check;
	}

	private function checkMail($mail) {
		//vérification du format mail
		if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			return false;
		}
		else {
			return true;
		}
	}

	private function checkPhone($phone) {
		//suppression des caractères de séparation éventuels
		$phone = str_replace('.', '', $phone);
		$phone = str_replace('-', '', $phone);
		$phone = str_replace(' ', '', $phone);

		//vérification du format
		if (!preg_match("/0[1-9][0-9]{8}$/", $phone)) {
			return false;
		}
		return $phone;
	}

	private function checkCity($city) {
		$citiesList = array('Paris', 'Lyon', 'Marseille');
		if (!in_array($city, $citiesList)) {
			return false;
		}
		else {
			return true;
		}
	}



/* ---------- Renvoi d'une erreur pour l'AJAX ---------- */

	private function error($error) {
		echo json_encode($error);
		exit;
	}
}
 ?>