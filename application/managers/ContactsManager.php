<?php 

class ContactsManager extends DBManager
{
	//récupération des infos de tous les contacts 
	public function getAll() 
	{
		$query = 
		'SELECT
			ID_NUMCONTACT AS id, NOM AS name, PRENOM AS firstName, EMAIL AS mail, TEL AS phone, CITY AS city
		FROM
			carnet_adresses
		ORDER BY
			NOM, PRENOM
		';
		$resultSet = $this -> getDBConnection() -> query($query);
		$contacts = $resultSet -> fetchAll();
		return $contacts;
	}

	//récupération des infos d'un contact
	public function getOneById($id) 
	{
		$query =
			'SELECT
				ID_NUMCONTACT AS id, NOM AS name, PRENOM AS firstName, EMAIL AS mail, TEL AS phone, CITY AS city
			FROM
				carnet_adresses
			WHERE
				ID_NUMCONTACT = ?
			';
		$resultSet = $this -> getDBConnection() -> prepare($query);
		$resultSet -> execute([$id]);
		$product = $resultSet -> fetch();
		return $product;
	}

	//ajout d'un contact
	public function addOne($requiredData)
	{
		$query =
			'INSERT INTO
				carnet_adresses(NOM, PRENOM, EMAIL, TEL, CITY)
			VALUES
				(?, ?, ?, ?, ?)
			';
		$resultSet = $this -> getDBConnection() -> prepare($query);
		$resultSet -> execute(array_values($requiredData));
		$contactAdded = ($resultSet->rowCount() == 1);
		return $contactAdded;
	}

	//suppression d'un contact
	public function removeOne($id)
	{
		$query =
			'DELETE FROM
				carnet_adresses
			WHERE
				ID_NUMCONTACT = ?
			';
		$resultSet = $this -> getDBConnection() -> prepare($query);
		$resultSet -> execute([$id]);
		$contactRemoved = ($resultSet->rowCount() == 1);
		return $contactRemoved;
	}

	//mise à jour d'un contact
	public function update($requiredData) 
	{
		$query =
			'UPDATE
				carnet_adresses
			SET
				NOM = ?, PRENOM = ?, EMAIL = ?, TEL = ?, CITY = ?
			WHERE
				ID_NUMCONTACT = ?
			';
		$resultSet = $this -> getDBConnection() -> prepare($query);
		$resultSet -> execute(array_values($requiredData));
		$contactUpdated = ($resultSet->rowCount() == 1 OR $resultSet->rowCount() == 0);
		return $contactUpdated;
	}
}
 ?>