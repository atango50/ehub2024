<?php
function authenticateUser($conn) {
    $headers = apache_request_headers();
    if (!isset($headers['Authorization'])) {
        return null;
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    
    $query = "SELECT id, username, email, avatar_url FROM users WHERE token = '$token'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    }

    return null;
}
?>