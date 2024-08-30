<?php
require_once 'config.php'; // Assurez-vous que ce fichier contient la configuration de la base de données

// Désactiver l'affichage des erreurs dans la sortie
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Fonction pour enregistrer les erreurs dans un fichier de log
function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, 'error.log');
}

// Fonction pour envoyer une réponse JSON
function sendJsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Vérification du token
$headers = getallheaders();
$token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : null;

if (!$token) {
    sendJsonResponse(['success' => false, 'message' => 'Token non fourni'], 401);
}

// Vérification de la connexion à la base de données
if (!$conn) {
    logError("Erreur de connexion à la base de données: " . mysqli_connect_error());
    sendJsonResponse(['success' => false, 'message' => 'Erreur de connexion à la base de données'], 500);
}

try {
    // Vérification du token dans la base de données
    $sql = "SELECT user_id FROM user_tokens WHERE token = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Erreur de préparation de la requête: " . $conn->error);
    }
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        sendJsonResponse(['success' => false, 'message' => 'Token invalide'], 401);
    }

    $user_id = $result->fetch_assoc()['user_id'];

    // Récupération des informations de l'utilisateur
    $sql = "SELECT username, email FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Erreur de préparation de la requête: " . $conn->error);
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        sendJsonResponse(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
    }

    $user = $result->fetch_assoc();
    sendJsonResponse(['success' => true, 'data' => $user]);

} catch (Exception $e) {
    logError("Erreur: " . $e->getMessage());
    sendJsonResponse(['success' => false, 'message' => 'Une erreur est survenue'], 500);
} finally {
    if ($conn) {
        $conn->close();
    }
}
?>