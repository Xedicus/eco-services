<?php
// Mot de passe à hacher
$password = 'admin'; // Mot de passe que vous voulez hacher

// Créez le hash
$hash = password_hash($password, PASSWORD_BCRYPT);

// Affichez le hash
echo $hash;
?>
