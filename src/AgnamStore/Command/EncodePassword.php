<?php

if ($argc < 2) {
    echo "Usage: php EncodePassword.php <password>\n";
    exit(1);
}

$password = $argv[1];
$salt = substr(md5(uniqid()), 0, 23);

$hash = hash('sha512', $password . $salt, true);
$encoded = base64_encode($hash);

echo "Mot de passe: $password\n";
echo "Salt: $salt\n";
echo "Encodé: $encoded\n";
