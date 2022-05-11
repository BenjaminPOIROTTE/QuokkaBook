<?php
class controleur
{
	public function erreur404()
	{
		(new vue)->erreur404();
	}

	public function connexion()
	{
		$corpsRequete = file_get_contents('php://input');
		if ($json = json_decode($corpsRequete, true)) {
			if (isset($json["mail"]) && isset($json["password"])) {
				$view = (new personne)->getPersonne($json["mail"], $json["password"]);
				if (count($view) > 0) {
					(new vue)->afficherObjetEnJSON($view);
				} else {
					(new vue)->erreur404();
				}
			}
		}
	}

	public function ajouterPersonne()
	{
		$corpsRequete = file_get_contents('php://input');
		if ($json = json_decode($corpsRequete, true)) {
			if (isset($json["mail"]) && isset($json["password"])) {
				$ajout = (new personne)->ajouterPersonne($json["mail"], $json["password"]);

				if ($ajout === true) {
					http_response_code(201);
					$json = '{ "code":201, "message": "Compte avec le mail ' . $json["mail"] . ' ajoutée." }';
					(new vue)->afficherJSON($json);
				} else {
					http_response_code(500);

					$json = '{ "code":500, "message": "Erreur lors de l\'insertion." }';
					(new vue)->afficherJSON($json);
				}
			} else {
				http_response_code(400);

				$json = '{ "code":400, "message": "Données manquantes." }';
				(new vue)->afficherJSON($json);
			}
		} else {
			http_response_code(400);

			$json = '{ "code":400, "message": "Le corps de la requête est invalide." }';
			(new vue)->afficherJSON($json);
		}
	}

	public function modifierPersonne()
	{
		$corpsRequete = file_get_contents('php://input');

		if ($json = json_decode($corpsRequete, true)) {
			if (isset($json["matricule_personne"]) && count($json) >= 2) {
				$nom = null;
				$prenom = null;
				$dateN = null;
				$codeN = null;
				$photo = null;

				if (isset($json["nom_personne"])) {
					$nom = $json["nom_personne"];
				}
				if (isset($json["prenom_personne"])) {
					$prenom = $json["prenom_personne"];
				}
				if (isset($json["date_naissance_personne"])) {
					$dateN = $json["date_naissance_personne"];
				}
				if (isset($json["code_nationnalite"])) {
					$codeN = $json["code_nationnalite"];
				}
				if (isset($json["photo_personne"])) {
					$photo = $json["photo_personne"];
				}

				$modif = (new personne)->modifierPersonne($json["matricule_personne"], $nom, $prenom, $codeN, $dateN, $photo);

				if ($modif === true) {
					http_response_code(200);
					$json = '{ "code":200, "message": "Personne au matricule ' . $json["matricule_personne"] . ' modifiée." }';
					(new vue)->afficherJSON($json);
				} else {
					http_response_code(500);

					$json = '{ "code":500, "message": "Erreur lors de la modification." }';
					(new vue)->afficherJSON($json);
				}
			} else {
				http_response_code(400);

				$json = '{ "code":400, "message": "Données manquantes." }';
				(new vue)->afficherJSON($json);
			}
		} else {
			http_response_code(400);

			$json = '{ "code":400, "message": "Le corps de la requête est invalide." }';
			(new vue)->afficherJSON($json);
		}
	}

	public function supprimerPersonne()
	{
		if (isset($_GET["id"])) {
			$laPersonne = (new personne)->getPersonne($_GET["id"]);
			if (count($laPersonne) > 0) {
				$supprimer = (new personne)->supprimerPersonne($_GET["id"]);

				if ($supprimer === true) {
					http_response_code(200);

					$json = '{ "code":200, "message": "La personne a été suprimée." }';
					(new vue)->afficherJSON($json);
				} else {
					http_response_code(400);

					$json = '{ "code":400, "message": "Impossible de supprimer cette personne." }';
					(new vue)->afficherJSON($json);
				}
			} else {
				(new vue)->erreur404();
			}
		} else {
			http_response_code(400);

			$json = '{ "code":400, "message": "Données manquantes." }';
			(new vue)->afficherJSON($json);
		}
	}
	//LIVRE
	public function afficherLivre()
	{
		if (isset($_GET["id"])) {
			$lesLivres = (new livre)->getBookId($_GET["id"]);
			if (count($lesLivres) > 0) {
				(new vue)->afficherObjetEnJSON($lesLivres);
			} else {
				(new vue)->erreur404();
			}
		} else {
			$lesLivres = (new livre)->getAllBook();
			(new vue)->afficherObjetEnJSON($lesLivres);
		}
	}

	public function afficherLivreUser()
	{
		if (isset($_GET["id"])) {
			$lesLivres = (new livre)->GetBookUser($_GET["id"]);
			if (count($lesLivres) > 0) {
				(new vue)->afficherObjetEnJSON($lesLivres);
			} else {
				(new vue)->erreur404();
			}
		} else {
		}
	}

	public function afficherLivreNonLuUser()
	{
		if (isset($_GET["id"])) {
			$lesLivres = (new livre)->GetBookNonLuUser($_GET["id"]);
			if (count($lesLivres) > 0) {
				(new vue)->afficherObjetEnJSON($lesLivres);
			} else {
				(new vue)->erreur404();
			}
		} else {
		}
	}

	public function ajouterNote()
	{
		$corpsRequete = file_get_contents('php://input');

		if ($json = json_decode($corpsRequete, true)) {
			if (isset($json["user"]) && isset($json["livre"]) && isset($json["note"])) {
				$ajout = (new livre)->ajouterLivreNote($json["user"], $json["livre"], $json["note"]);

				if ($ajout === true) {
					http_response_code(201);
					$json = '{ "code":201, "message": "User ' . $json["user"] . ' a ajoute un livre." }';
					(new vue)->afficherJSON($json);
				} else {
					http_response_code(500);

					$json = '{ "code":500, "message": "Erreur lors de l\'insertion." }';
					(new vue)->afficherJSON($json);
				}
			} else {
				http_response_code(400);

				$json = '{ "code":400, "message": "Données manquantes." }';
				(new vue)->afficherJSON($json);
			}
		} else {
			http_response_code(400);

			$json = '{ "code":400, "message": "Le corps de la requête est invalide." }';
			(new vue)->afficherJSON($json);
		}
	}

	public function modifNote()
	{
		$corpsRequete = file_get_contents('php://input');

		if ($json = json_decode($corpsRequete, true)) {
			if (isset($json["user"]) && isset($json["livre"]) && isset($json["note"])){
				$user = $json["user"];
				$note = $json["note"];
				$livre = $json["livre"];


				$modif = (new livre)->modifierNoteLivre($livre, $user, $note);

				if ($modif === true) {
					http_response_code(200);
					$json = '{ "code":200, "message": "Livre a l\'id ' . $json["livre"] . ' modifiée." }';
					(new vue)->afficherJSON($json);
				} else {
					http_response_code(500);

					$json = '{ "code":500, "message": "Erreur lors de la modification." }';
					(new vue)->afficherJSON($json);
				}
			} else {
				http_response_code(400);

				$json = '{ "code":400, "message": "Données manquantes." }';
				(new vue)->afficherJSON($json);
			}
		} else {
			http_response_code(400);

			$json = '{ "code":400, "message": "Le corps de la requête est invalide." }';
			(new vue)->afficherJSON($json);
		}
	}



	public function supprimerNoteUser()
	{
		if (isset($_GET["livre"]) && isset($_GET["user"])) {
			$lesLivres = (new livre)->supprimerNote($_GET["livre"], $_GET["user"]);
		} else {
			http_response_code(400);

			$json = '{ "code":400, "message": "SUPPRESION DE LA NOTE IMPOSSIBLE" }';
			(new vue)->afficherJSON($json);
		}
	}
}
