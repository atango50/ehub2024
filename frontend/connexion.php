<?php 
 require_once "head.php";
 require_once "menu.php";
 ?>

 <section id="login" class="login section-bg">
      <div class="container" data-aos="fade-up">
        </br>
        </br>
        <div class="section-title">
          <h2>Connexion</h2>
          <p>Accédez à votre compte</p>
        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="row">
              <div class="col-md-12">
                <div class="info-box">
                  <!-- Remplacez l'image par l'iframe YouTube -->
                  <div >
                  <img src="assets/img/Accedez.png" alt="Description" class="image-ratio" >
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <form id="loginForm" method="post" role="form" class="php-email-form">
              <div class="form-group mt-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
              </div>
              <div class="form-group mt-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe" required>
              </div>
              <div class="my-3">
                <div id="message" style="display: none;"></div>
              </div>
              <div class="text-center"><button type="submit">Se connecter</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Login Section -->

    <script src="js/ajax-script.js"></script>

    <?php 
    require_once "foot.php";
    ?>

<style>
.video-container {
  position: relative;
  padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
  height: 0;
  overflow: hidden;
}

.video-container iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
</style>
