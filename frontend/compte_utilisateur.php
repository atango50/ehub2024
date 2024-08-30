<?php 
require_once "head.php";
require_once "menu.php";
?>

<section id="user-account" class="user-account section-bg">
    <div class="container" data-aos="fade-up">
        <br>
        <br>
        <div class="section-title">
            <h2>Mon Compte</h2>
            <p>Gérez vos informations personnelles</p>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="info-box">
                    <h3>Informations personnelles</h3>
                    <p id="username">Nom d'utilisateur: Chargement...</p>
                    <p id="email">Email: Chargement...</p>
                </div>
            </div>

            <div class="col-lg-8">
                <form id="updateAccountForm" method="post" role="form" class="php-email-form">
                    <div class="form-group mt-3">
                        <input type="text" class="form-control" name="newUsername" id="newUsername" placeholder="Nouveau nom d'utilisateur">
                    </div>
                    <div class="form-group mt-3">
                        <input type="email" class="form-control" name="newEmail" id="newEmail" placeholder="Nouvel email">
                    </div>
                    <div class="form-group mt-3">
                        <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="Nouveau mot de passe">
                    </div>
                    <div class="form-group mt-3">
                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirmez le nouveau mot de passe">
                    </div>
                    <div class="my-3">
                        <div id="message" style="display: none;"></div>
                    </div>
                    <div class="text-center"><button type="submit">Mettre à jour</button></div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const updateAccountForm = document.getElementById('updateAccountForm');
    const messageDiv = document.getElementById('message');
    const usernameElement = document.getElementById('username');
    const emailElement = document.getElementById('email');

    // Charger les informations de l'utilisateur
    function loadUserInfo() {
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = 'login.php';
            return;
        }

        fetch('../backend/get_user_info.php', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                usernameElement.textContent = `Nom d'utilisateur: ${data.data.username}`;
                emailElement.textContent = `Email: ${data.data.email}`;
            } else {
                messageDiv.textContent = 'Erreur lors du chargement des informations utilisateur.';
                messageDiv.className = 'message error';
                messageDiv.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageDiv.textContent = 'Une erreur s\'est produite. Veuillez réessayer.';
            messageDiv.className = 'message error';
            messageDiv.style.display = 'block';
        });
    }

    loadUserInfo();

    // Le reste du code JavaScript reste inchangé
});
</script>

<?php 
require_once "foot.php";
?>