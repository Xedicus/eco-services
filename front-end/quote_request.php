<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: services.php?message=login_required");
    exit();
}

// Vérifier si l'ID du service est fourni
if (!isset($_GET['service_id'])) {
    header("Location: services.php?message=invalid_request");
    exit();
}

$service_id = intval($_GET['service_id']);
$username = $_SESSION['username'];
$message = "Demande de devis pour le service ID $service_id"; // Message générique, vous pouvez le personnaliser si nécessaire

// Connexion à la base de données
$servername = "localhost";
$db_username = "root"; // Votre nom d'utilisateur MySQL
$db_password = ""; // Votre mot de passe MySQL
$dbname = "eco_services"; // Nom de votre base de données

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Préparer et exécuter la requête pour insérer la demande de devis
$stmt = $conn->prepare("INSERT INTO quotes (name, message, created_at) VALUES (?, ?, NOW())");
$stmt->bind_param("ss", $username, $message);

if ($stmt->execute()) {
    // Rediriger avec un message de succès
    header("Location: services.php?message=quote_request_success");
} else {
    // Rediriger avec un message d'échec
    header("Location: services.php?message=quote_request_failed");
}

$stmt->close();
$conn->close();
exit();
?>
