<?php
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
$token = JWT::decode($jwt, $secretKey, ['HS512']);
$now = new DateTimeImmutable();
$serverName = "momomotus.ddns.net";

if ($token->iss !== $serverName ||
    $token->nbf > $now->getTimestamp() ||
    $token->exp < $now->getTimestamp())
{
    header('HTTP/1.1 401 Unauthorized');
    exit;
}

// Show the page
