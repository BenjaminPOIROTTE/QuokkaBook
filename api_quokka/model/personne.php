<?php

class personne {
	// Objet PDO servant à la connexion à la base
	private $pdo;

	// Connexion à la base de données
	public function __construct() {
		$config = parse_ini_file("config.ini");
		
		try {
			$this->pdo = new \PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8", $config["user"], $config["password"]);
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function getAll() {
		$sql = "SELECT * FROM accounts";
		
		$req = $this->pdo->prepare($sql);
		$req->execute();
		
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getPersonne($mail,$password) {
		$sql = "SELECT * FROM accounts WHERE mail = :mail and password= :password";
		
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':mail', $mail, PDO::PARAM_STR);
		$req->bindParam(':password', $password, PDO::PARAM_STR);
		$req->execute();
		
		return $req->fetch(PDO::FETCH_ASSOC);
	}
	
	public function ajouterPersonne($mail, $password) {
		$sql = "INSERT INTO accounts (mail, password) VALUES (:mail, :password)";
		
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':mail', $mail, PDO::PARAM_STR);
		$req->bindParam(':password', $password, PDO::PARAM_STR);
		return $req->execute();
	}
	
	public function modifierPersonne($id, $mail = null, $password = null) {
		$sql = "UPDATE accounts SET id = :id";
		
		if($mail != null) {
			$sql .= ", mail = :mail";
		}
		if($password != null) {
			$sql .= ", password = :password";
		}
		
		$sql .= " WHERE id = :id ";
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':matricule', $matricule, PDO::PARAM_STR);
		
		if($nom != null) {
			$req->bindParam(':nom', $nom, PDO::PARAM_STR);
		}
		if($prenom != null) {
			$req->bindParam(':prenom', $prenom, PDO::PARAM_STR);
		}
		
		return $req->execute();
	}
	
	public function supprimerPersonne($id) {
		$sql = "DELETE FROM accounts WHERE id = :id";
		
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':id', $id, PDO::PARAM_STR);
		return $req->execute();
	}
}