<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $verification_code = mysqli_real_escape_string($conn, $data['verification_code']);

    $sql = "SELECT id FROM users WHERE email = '$email' AND verification_code = '$verification_code' AND is_verified = 0";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){
        $update_sql = "UPDATE users SET is_verified = 1, verification_code = NULL WHERE email = '$email'";
        if(mysqli_query($conn, $update_sql)){
            echo json_encode(array("success" => true, "message" => "Votre compte a été vérifié avec succès. Vous pouvez maintenant vous connecter."));
        } else {
            echo json_encode(array("success" => false, "message" => "Erreur lors de la vérification du compte."));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Code de vérification invalide ou compte déjà vérifié."));
    }
}

mysqli_close($conn);
?>
