<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="custom-css.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5 mb-4">Inscription</h1>
        <form id="signupForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="firstName" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Genre</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="">Choisir...</option>
                    <option value="male">Homme</option>
                    <option value="female">Femme</option>
                    <option value="other">Autre</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="projectName" class="form-label">Nom du projet</label>
                <input type="text" class="form-control" id="projectName" name="projectName" required>
            </div>
            <div class="mb-3">
                <label for="projectCreationDate" class="form-label">Date de création du projet</label>
                <input type="date" class="form-control" id="projectCreationDate" name="projectCreationDate" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Catégorie</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Choisir...</option>
                    <option value="technology">Technologie</option>
                    <option value="art">Art</option>
                    <option value="science">Science</option>
                    <option value="other">Autre</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="video" class="form-label">Vidéo de présentation (MP4, max 3Mo)</label>
                <input type="file" class="form-control" id="video" name="video" accept="video/mp4" required>
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
        <div id="message" class="mt-3"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/ajax-script.js"></script>
</body>
</html>
