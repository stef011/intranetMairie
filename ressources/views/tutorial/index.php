<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutoriels | ALPHA</title>

    <link rel="stylesheet" href="<?= assets('css/bootstrap/bootstrap.min.css')  ?> ">
    <link rel="stylesheet" href="<?= assets('Fontawesome/css/all.min.css')  ?> ">

    <!-- js -->
    <script src="<?= assets('js/jquery.min.js') ?> "></script>
    <script src="<?= assets('js/bootstrap/bootstrap.bundle.min.js') ?> "></script>
    <script src="<?= assets('Fontawesome/js/all.min.js') ?> "></script>

</head>

<body class="bg-dark text-light">

    <div class="bg-white text-dark p-4">
        <h1>Liste des Tutoriels | <a href="<?= route('index') ?>" class="text-dark text-decoration-none">Intranet
                Alpha</a></h1>
    </div>


    <div class="m-3 m-md-5 ">
        <div class="row align-items-stretch">
            <?php foreach ($tutorials as $tutoriel) { ?>
            <div class="col-sm-6 mb-3">
                <div class="card h-100 bg-secondary">
                    <div class="card-body">
                        <h5 class="card-title"><?= $tutoriel->NOM_TUTORIEL ?></h5>

                        <p class="card-text">
                            <?= substr(strip_tags($tutoriel->DESCRIPTION_TUTORIEL), 0, 200) . '...' ?>
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="<?= route('tutoriels.show', ['id' => $tutoriel->ID_TUTORIEL]) ?>"
                            class="btn btn-primary">Aller au tutoriel</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>
