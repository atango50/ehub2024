<?php 
 require_once "head.php";
 require_once "menu.php";
 ?>

 <section id="contact" class="contact section-bg">
      <div class="container" data-aos="fade-up">
</br>
</br>
        <div class="section-title">
          <h2>Inscription</h2>
          <p>rejoinds l'aventure</p>
        </div>

        <div class="row">

          <div class="col-lg-6">

            <div class="row">
              <div class="col-md-12">
                <div class="info-box">
                  <img src="assets/img/Rejoins.png" alt="Description" class="image-ratio" >
                </div>
              </div>
            </div>

          </div>

          <div class="col-lg-6">
          <form id="signupForm" method="post" role="form" class="php-email-form" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="username" class="form-control" id="username" placeholder="Nom d'utilisateur" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Prénom" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <select class="form-control" name="gender" id="gender" required>
                  <option value="">Choisir le genre...</option>
                  <option value="male">Homme</option>
                  <option value="female">Femme</option>
                  <option value="other">Autre</option>
                </select>
              </div>
              <div class="form-group mt-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
              </div>
              <div class="form-group mt-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe" required>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="projectName" id="projectName" placeholder="Nom du projet" required>
              </div>
              <div class="form-group mt-3">
                <input type="date" class="form-control" name="projectCreationDate" id="projectCreationDate" required>
              </div>
              <div class="form-group mt-3">
                <select class="form-control" name="category" id="category" required>
                  <option value="">Choisir la catégorie...</option>
                  <option value="technology">Technologie</option>
                  <option value="art">Art</option>
                  <option value="science">Science</option>
                  <option value="other">Autre</option>
                </select>
              </div>
              <div class="form-group mt-3">
                <input type="file" class="form-control" name="video" id="video" accept="video/mp4" required>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Inscription réussie</div>
              </div>
              <div class="text-center"><button type="submit">S'inscrire</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

    <script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('signupForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var loadingDiv = document.querySelector('.loading');
        var errorDiv = document.querySelector('.error-message');
        var successDiv = document.querySelector('.sent-message');
        
        loadingDiv.style.display = 'block';
        errorDiv.style.display = 'none';
        successDiv.style.display = 'none';
        
        fetch('../backend/signup.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
          console.log('Réponse du serveur:', data); // Ajoutez cette ligne
            loadingDiv.style.display = 'none';
            if (data.success) {
                successDiv.textContent = data.message;
                successDiv.style.display = 'block';
                
                if (data.redirect) {
                    localStorage.setItem('verificationEmail', formData.get('email'));
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 2000); // Redirection après 2 secondes
                }
            } else {
                errorDiv.textContent = data.message;
                errorDiv.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loadingDiv.style.display = 'none';
            errorDiv.textContent = 'Une erreur est survenue lors de l\'inscription.';
            errorDiv.style.display = 'block';
        });
    });
});
</script>
    <?php 
 require_once "foot.php";
 ?>