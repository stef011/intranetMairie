<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Intranet Informatique</title>

    <!-- css -->
    <link rel="stylesheet" href="<?php echo assets('css/bootstrap/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo assets('css/login.css') ?>">

    <!-- js -->
    <script src="<?php echo assets('js/jquery.min.js') ?> "></script>
    <script src="<?php echo assets('js/bootstrap/bootstrap.min.js') ?> "></script>

</head>

<body>

    <header class="m-3">
        <div class="float-left mt-2 mx-4"><img src="<?php echo assets('images/logo_white.png') ?> " alt="Logo"></div>
        <div class="ml-4">
            <h1>Bienvenue sur l'interface d'administration de l'intranet de la mairie de Saint-Louis</h1>
            <p class="h3">Veuillez vous connecter</p>
        </div>
    </header>

    <form class="mx-auto" style="max-width: 30rem; margin-top: 10rem;" action="<?php echo route('admin.login') ?> "
        method="POST">
        <input class="form-control form-control-lg m-3 rounder" type="text" name="login" id="login"
            placeholder="Identifiant">
        <input class="form-control form-control-lg m-3 rounder" type="password" name="password" id="password"
            placeholder="Mot de passe">
        <button class="btn btn-lg btn-primary m-3 rounder" type="submit">Valider</button>
    </form>


</body>

</html>
