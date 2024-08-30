<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification du compte</title>
    <link rel="stylesheet" href="verification.css">
</head>
<body>
    <div class="container">
     <h1>Vérification du compte</h1>
     <div id="message" class="message"></div>
     <form id="verifyForm">
         <input type="email" id="email" name="email" required placeholder="Votre email">
         <input type="text" name="verification_code" required placeholder="Code de vérification">
         <button type="submit">Vérifier</button>
     </form>
    </div>
    <script src="js/ajax-script.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var email = localStorage.getItem('verificationEmail');
        if (email) {
            document.getElementById('email').value = email;
        }
    });
    </script>
</body>
</html>