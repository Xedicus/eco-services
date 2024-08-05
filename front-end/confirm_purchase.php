<?php
session_start();

// Inclure le fichier de configuration de la base de données
include '../back-end/config/db.php'; // Assurez-vous que ce chemin est correct pour votre projet

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Inclure l'autoloader de Composer pour PayPal SDK
require '../vendor/autoload.php';

// Configuration de PayPal
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

$clientId = 'AX-DTFbSWzAgxq6cqZca7YswSG4Yir-RM7GmIEKWAV-QVHDi72SrxP1DTXHckkW2WvCsd8TQyok7FTPX'; // Remplacez par votre Client ID
$clientSecret = 'EPJiWt1R7T-OakkY_emSCuv1iVyIX1RJjIcfLpi5_YPoyTqQa2sMPU46MMSABb4ciDTIUhZlqvvILZVS'; // Remplacez par votre Secret

// Créer une instance de PayPalHttpClient
$environment = new SandboxEnvironment($clientId, $clientSecret);
$client = new PayPalHttpClient($environment);

// Préparer les détails du panier
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$products = [];
$total = 0;

if (!empty($cart)) {
    $productIds = implode(',', array_keys($cart));
    $query = "SELECT * FROM products WHERE id IN ($productIds)";
    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $row['quantity'] = $cart[$row['id']];
            $row['total_price'] = $row['quantity'] * $row['price'];
            $total += $row['total_price'];
            $products[] = $row;
        }
    } else {
        die("Erreur de requête : " . $conn->error);
    }
}

// Créer une commande PayPal
$request = new OrdersCreateRequest();
$request->prefer('return=representation');
$request->body = [
    "intent" => "CAPTURE",
    "purchase_units" => [
        [
            "amount" => [
                "currency_code" => "EUR",
                "value" => number_format($total, 2)
            ]
        ]
    ],
    "application_context" => [
        "return_url" => "http://localhost/your-project/success.php", // URL vers laquelle PayPal redirige après paiement réussi
        "cancel_url" => "http://localhost/your-project/cancel.php"  // URL vers laquelle PayPal redirige en cas d'annulation
    ]
];

try {
    $response = $client->execute($request);
    $orderID = $response->result->id;
    header("Location: " . $response->result->links[1]->href); // Rediriger vers PayPal pour le paiement
    exit();
} catch (Exception $e) {
    echo "Erreur lors de la création de la commande PayPal : " . $e->getMessage();
}

// Fermer la connexion
$conn->close();
?>
