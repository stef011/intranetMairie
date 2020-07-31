<!DOCTYPE html>
<html lang="fr" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tutoriel->NOM_TUTORIEL ?> | ALPHA</title>

    <link rel="stylesheet" href="<?= assets('css/bootstrap/bootstrap.min.css')  ?> ">
    <link rel="stylesheet" href="<?= assets('Fontawesome/css/all.min.css')  ?> ">

    <!-- js -->
    <script src="<?= assets('js/jquery.min.js') ?> "></script>
    <script src="<?= assets('js/bootstrap/bootstrap.bundle.min.js') ?> "></script>
    <script src="<?= assets('Fontawesome/js/all.min.js') ?> "></script>
</head>

<body class="bg-dark text-light d-flex flex-column h-100">
    <header class="bg-white text-dark p-2 d-sm-flex ">
        <a href="<?= route('tutoriels.index') ?>"
            class="h4 align-self-center  ml-3 mr-5 text-dark text-decoration-none"><i class="fa fa-arrow-left"
                aria-hidden="true"></i>
            Retour</a>
        <h1 class="h2 mt-2 ml-3 ml-sm-0 mt-sm-0"><?= $tutoriel->NOM_TUTORIEL ?> <span class="d-md-inline d-none">
                | <a href="<?= route('index') ?>" class="text-dark text-decoration-none">Intranet Alpha</a>
            </span></h1>
    </header>
    <div class="m-5">
        <?= $tutoriel->DESCRIPTION_TUTORIEL ?>
    </div>
    <footer class="py-4 px-4 mt-auto h5 font-weight-bold footer">
        Rédigé par : <?= $admin->NOM_ADMIN ?? 'n/a' ?>
        <div class="float-right">Le <?= $tutoriel->DATE_TUTORIEL ?></div>
    </footer>
</body>

</html>
