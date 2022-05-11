<?php
ini_set("display_errors", 1);
session_start();
use Firebase\JWT\JWT;
require_once("./vendor/autoload.php");

if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
    header('HTTP/1.0 400 Bad Request');
    echo 'Token not found in request';
    exit;
}

$jwt = $matches[1];
if (! $jwt) {
    // No token was able to be extracted from the authorization header
    header('HTTP/1.0 400 Bad Request');
    exit;
}

$secretKey  = 'y%sdjLX#jd*SWDxPJW85u-rw%=S#A79*hc2&FefV-BPTGy3TRP+AmcJJWDKVETQh';
$token = JWT::decode((string)$jwt, $secretKey, ['HS512']);
$now = new DateTimeImmutable();
$serverName = "momomotus.ddns.net";

if ($token->iss !== $serverName ||
    $token->nbf > $now->getTimestamp() ||
    $token->exp < $now->getTimestamp())
{
    header('HTTP/1.1 401 Unauthorized');
    exit;
}

// Test de connexion à la base
$config = parse_ini_file("config.ini");
try {
	$pdo = new \PDO("mysql:host=" . $config["host"] . ";dbname=" . $config["database"] . ";charset=utf8", $config["user"], $config["password"]);
} catch (Exception $e) {
	echo "<h1>Erreur de connexion à la base de données :</h1>";
	echo $e->getMessage();
	exit;
}

// Chargement des fichiers MVC
require("control/controleur.php");
require("view/vue.php");
require("model/personne.php");
require("model/livre.php");

// Routes
if (isset($_GET["action"])) {

	switch ($_GET["action"]) {
		case "personne":
			switch ($_SERVER["REQUEST_METHOD"]) {
				case "GET":
					//(new controleur)->connexion();
					break;
				case "POST":
					(new controleur)->ajouterPersonne();
					break;
				case "PUT":
					(new controleur)->modifierPersonne();
					break;
				case "DELETE":
					(new controleur)->supprimerPersonne();
					break;
			}
			break;
		case "login":
			switch ($_SERVER["REQUEST_METHOD"]) {
				case "POST":
					(new controleur)->connexion();
					break;
			}
			break;

		case "livreUser":
			switch ($_SERVER["REQUEST_METHOD"]) {
				case "GET":
					(new controleur)->afficherLivreUser();
					break;
				case "POST":
					(new controleur)->ajouterPersonne();
					break;
				case "PUT":
					(new controleur)->modifierPersonne();
					break;
				case "DELETE":
					(new controleur)->supprimerPersonne();
					break;
			}
			break;

		case "livreNonLu":
			switch ($_SERVER["REQUEST_METHOD"]) {
				case "GET":
					(new controleur)->afficherLivreNonLuUser();
					break;
				case "POST":
					(new controleur)->ajouterPersonne();
					break;
				case "PUT":
					(new controleur)->modifierPersonne();
					break;
				case "DELETE":
					(new controleur)->supprimerPersonne();
					break;
			}
			break;

		case "ajoutNote":
			switch ($_SERVER["REQUEST_METHOD"]) {
				case "POST":
					(new controleur)->ajouterNote();
					break;
			}
			break;

		case "updateNote":
			switch ($_SERVER["REQUEST_METHOD"]) {
				case "POST":
					(new controleur)->modifNote();
					break;
			}
			break;
			// Route par défaut : erreur 404
		default:
			(new controleur)->erreur404();
			break;
	}
} else {
	// Pas d'action précisée = afficher l'accueil
	$json = '{ "code":200, "message": "Bienvenue dans l\'API !" }';
	(new vue)->afficherJSON($json);
}
