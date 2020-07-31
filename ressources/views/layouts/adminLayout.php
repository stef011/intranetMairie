<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Aministration' ?> | Alpha </title>

    <link rel="stylesheet" href="<?= assets('css/bootstrap/bootstrap.min.css')  ?> ">
    <link rel="stylesheet" href="<?= assets('Fontawesome/css/all.min.css')  ?> ">
    <link rel="stylesheet" href="<?= assets('css/adminLayout.css') ?>">

    <!-- js -->
    <script src="<?= assets('js/jquery.min.js') ?> "></script>
    <script src="<?= assets('js/bootstrap/bootstrap.bundle.min.js') ?> "></script>
    <script src="<?= assets('Fontawesome/js/all.min.js') ?> "></script>
</head>

<body class="d-flex">
    <div class="navbar-light flex-column float-left bg-dark p-1 text-white position-sticky sticky-top"
        style="height: 100vh;">
        <h1 id="title" class="h3 m-3"> <img src="<?= assets('images/logo_white.png') ?>" alt="Logo"
                style="width: 2rem; margin-bottom: 1rem;">
            Administration</h1>
        <div class="line m-3"></div>
        <div class="d-flex justify-content-around">
            <div>
                <img src="<?= assets('images/logo_white.png') ?>" alt="pic" class="rounded-circle border border-light"
                    style="border-width: 3px !important; width: 4rem;">
            </div>
            <p class="mr-3"><span class="text-muted h5">Bienvenue,</span> <br> <span
                    class="h5"><?= $admin->NOM_ADMIN ?></span></p>
        </div>
        <div class="line m-3"></div>
        <nav class="nav flex-column m-3 ml-4">
            <?php if(in_array($admin->LOGIN_ADMIN, ['admin', 'informatique'])){ ?>
            <div>
                <a href="<?= route('admin.tickets') ?>" class="text-light">Tickets</a>
                <?php if(preg_match("/\/admin\/tickets*/", $_SERVER['REQUEST_URI'])){ ?>
                <i class="fa fa-chevron-down" aria-hidden="true"></i>
            </div>
            <div class="ml-3 mt-2 flex-column nav">
                <a class="text-white" href="<?= route('admin.tickets') ?>">Toutes les catégories</a>
                <?php foreach ($cats as $cat) { ?>
                <a class="text-white text-decoration-none" data-toggle="collapse" href="#collapse<?= $cat->id ?>"
                    role="button" aria-expanded="false" aria-controls="collapse<?= $cat->id ?>">
                    <?= $cat->nom ?>
                </a>
                <div class="collapse ml-3 mt-2 mb-2 text-light" id="collapse<?= $cat->id ?>">
                    <?php foreach ($subCats->filter_nondestructive(['category_id' => $cat->id]) as $subCat) {?>
                    <a href="?subCat=<?= $subCat->id ?>" class="text-white"><?= $subCat->nom ?></a>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>

            <?php } else{ echo '<i class="fa fa-chevron-right" aria-hidden="true"></i></div>';} ?>
            <?php } ?>
        </nav>
    </div>

    <?= $content ?? '' ?>
</body>

</html>
