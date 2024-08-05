<?php
session_start(); // Démarrer la session

// Inclure le fichier de configuration de la base de données
include '../config/db.php'; // Assurez-vous que ce chemin est correct pour votre projet

// Fonction pour nettoyer les données entrantes
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si non connecté, rediriger vers la page de contact avec un message d'erreur
    header("Location: ../../front-end/contact.php?error=not_logged_in");
    exit();
}

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = sanitize_input($_POST["name"]);
    $message = sanitize_input($_POST["message"]);

    // Préparer la requête SQL
    $stmt = $conn->prepare("INSERT INTO quotes (name, message, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $name, $message);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Redirection après l'envoi
        header("Location: ../../front-end/contact.php?success=quote_sent");
        exit();
    } else {
        echo "Erreur lors de l'enregistrement de votre demande.";
    }

    // Fermer la déclaration et la connexion
    $stmt->close();
    $conn->close();
} else {
    echo "Méthode de requête non valide.";
}
?>
