<?php
use Firebase\JWT\JWT;
require_once("./vendor/autoload.php");
$hasValidCredentials = true;
if($_GET['checker'] != 'GTwKRmbXaUVnYGTKvv8FqpqrwJuSfM2kyH67QazpQKTYVHFy9YVMRLcN7NLmuRD9'){
    $hasValidCredentials = false;
}


if ($hasValidCredentials) {
    $secretKey  = 'y%sdjLX#jd*SWDxPJW85u-rw%=S#A79*hc2&FefV-BPTGy3TRP+AmcJJWDKVETQh';
    $tokenId    = base64_encode(random_bytes(16));
    $issuedAt   = new DateTimeImmutable();
    $expire     = $issuedAt->modify('+60 minutes')->getTimestamp();      // Add 60 seconds
    $serverName = "momomotus.ddns.net";                                         // Retrieved from filtered POST data

    // Create the token as an array
    $data = [
        'iat'  => $issuedAt->getTimestamp(),    // Issued at: time when the token was generated
        'jti'  => $tokenId,                     // Json Token Id: an unique identifier for the token
        'iss'  => $serverName,                  // Issuer
        'nbf'  => $issuedAt->getTimestamp(),    // Not before
        'exp'  => $expire,                      // Expire
        'data' => [                             // Data related to the signer user
        ]
    ];

    // Encode the array to a JWT string.
    echo Firebase\JWT\JWT::encode(
        $data,      //Data to be encoded in the JWT
        $secretKey, // The signing key
        'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
    );
}
?>