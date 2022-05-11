<?php

class livre{


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

    public function getAllBook() {
		$sql = "SELECT * FROM `livre` ";
		
		$req = $this->pdo->prepare($sql);
		$req->execute();
		
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}

    public function getBookId($id) {
		$sql = "SELECT * FROM `livre` where id= :id";
			
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':id', $id, PDO::PARAM_STR);
		$req = $this->pdo->prepare($sql);
		$req->execute();
		
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}

    public function GetBookUser($id) {
		$sql = "SELECT * FROM `livre` inner JOIN Note where livre.id=id_livre AND id_user = :id";
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':id', $id, PDO::PARAM_STR);
		$req->execute();
		
		return $req->fetchAll(PDO::FETCH_ASSOC);	
	}

	public function GetBookNonLuUser($id) {
		$sql = "SELECT * FROM `livre` where id NOT IN (SELECT id_livre FROM Note WHERE id_user = :id)";
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':id', $id, PDO::PARAM_STR);
		$req->execute();
		
		return $req->fetchAll(PDO::FETCH_ASSOC);	
	}

    public function ajouterLivreNote($user, $livre, $note) {
		$sql = "INSERT INTO `Note`( `id_livre`, `id_user`,`note`) VALUES (:livre,:user,:note)";
		
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':user', $user, PDO::PARAM_INT);
		$req->bindParam(':livre', $livre, PDO::PARAM_INT);
		$req->bindParam(':note', $note, PDO::PARAM_INT);
		return $req->execute();
	}

    public function modifierNoteLivre($livre,$user,$note)
    {
        $sql = "UPDATE `Note` SET `note`= :note where id_user = :user and id_livre= :livre";
        $req = $this->pdo->prepare($sql);
		$req->bindParam(':user', $user, PDO::PARAM_INT);
		$req->bindParam(':livre', $livre, PDO::PARAM_INT);
        $req->bindParam(':note', $note, PDO::PARAM_INT);
		return $req->execute();
    }

    public function supprimerNote($livre,$user)
    {
        $sql = "DELETE FROM `Note` WHERE id_user = :user and id_livre= :livre";
        $req = $this->pdo->prepare($sql);
		$req->bindParam(':user', $user, PDO::PARAM_STR);
		$req->bindParam(':livre', $livre, PDO::PARAM_STR);
        return $req->execute();
    }



}
