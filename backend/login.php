<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $password = $data['password'];

    $sql = "SELECT id, username, password, is_verified FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row['password'])){
            if($row['is_verified'] == 1){
                $token = bin2hex(random_bytes(32));
                $user_id = $row['id'];
                
                // Calculer la date d'expiration (1 jour à partir de maintenant)
                $expires_at = date('Y-m-d H:i:s', strtotime('+1 day'));
                
                // Insérer le token dans la table user_tokens
                $insert_token_sql = "INSERT INTO user_tokens (user_id, token, expires_at) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($insert_token_sql);
                $stmt->bind_param("iss", $user_id, $token, $expires_at);
                $stmt->execute();
                
                echo json_encode(array("success" => true, "message" => "Connexion réussie", "token" => $token, "username" => $row['username']));
            } else {
                echo json_encode(array("success" => false, "message" => "Veuillez vérifier votre compte avant de vous connecter."));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Email ou mot de passe incorrect."));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Email ou mot de passe incorrect."));
    }
}

mysqli_close($conn);
?>