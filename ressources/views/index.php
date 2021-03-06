<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTRANET INFORMATIQUE | ALPHA</title>

    <meta http-equiv="refresh" content="300">

    <link rel="stylesheet" href="<?= assets('css/bootstrap/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/index.css') ?>">
    <link rel="stylesheet" href="<?= assets('FontAwesome/css/all.css') ?> ">

    <script src="<?= assets('js/jquery.min.js') ?>"></script>
    <script src="<?= assets('js/bootstrap/bootstrap.min.js') ?>"></script>
    <script src="<?= assets('FontAwesome/js/all.js') ?> "></script>
</head>

<body>
    <header class="header">
        <h1 class="m-3 ml-4">
            <a href="<?= route('index') ?>" class="text-decoration-none text-white">
                <img src="<?= assets('images/logo_white.png') ?>" height="32" width="35" class="header-logo" alt="" />
                INTRANET INFORMATIQUE | ALPHA
            </a>
        </h1>
    </header>

    <?php if ($success == 1) { ?>
    <div class="alert alert-success ml-5 mr-5">Votre demande a bien été prise en compte! </div>
    <?php } ?>
    <div class="d-flex flex-wrap mt-5 ml-5 mr-5 mb-0">
        <div class=" mr-2" style=" max-width: 32rem;" id="applis">
            <h3 class="block-title ml-3">Applications métiers</h3>

            <div class="d-flex h-25 flex-wrap">
                <div class="app-icon">
                    <a href="https://mail.ville-saint-louis.fr/" target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-outlook.jpg') ?>" />
                    </a>
                </div>

                <div class="app-icon ">
                    <a href="https://exc-mairie/owa/" target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-outlook.jpg') ?>" />
                        <p class="app-text">
                            Si la
                            messagerie au-dessus ne marche pas cliquez ici</p>
                    </a>
                </div>

                <div class="app-icon">
                    <a href="http://fichiers.ville-saint-louis.fr/" target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-partages.jpg')?>" />
                    </a>
                </div>

                <div class="app-icon">
                    <a href="http://alpha/manif/login.php" target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-manif.jpg"')?>" />
                    </a>
                </div>

                <div class="app-icon">
                    <a href="https://sig.agglo-saint-louis.fr/" target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-SIG.jpg')?>" />
                    </a>
                </div>

                <div class="app-icon">
                    <a href="http://octime/WD210AWP/WD210AWP.EXE/CONNECT/weoctime92?INI=STLOUIS&" target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-octime-new.jpg')?>" />
                    </a>
                </div>

                <div class="app-icon">
                    <a href="http://alpha/espace_rh/" target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-rh.jpg"')?>" />
                    </a>
                </div>
                <!-- Changement pour keepeek -->
                <div class="app-icon">
                    <a href="http://cloud.ville-saint-louis.fr/" target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-keepeek.jpg') ?>" />
                    </a>
                </div>

                <div class="app-icon">
                    <a href="http://10.1.0.31:8080/kolok/login.php" target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-kolok.jpg')?>" />
                    </a>
                </div>

                <div class="app-icon">
                    <a href="http://10.1.0.9/" target="_blank">
                        <img class="app-image " src="<?= assets('images/applis/o-ciril.jpg')?>" />
                    </a>
                </div>

                <div class="app-icon">
                    <a href="http://mainti/MaintiWeb/Account/Login/" target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-mainti4.jpg') ?>" />
                    </a>
                </div>


                <div class="app-icon">
                    <a href="http://10.1.0.31:15400/poi/Login.jsp" target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-postoffice.jpg')?>" />
                    </a>
                </div>

                <div class="app-icon">
                    <a href="http://alpha/olympe/Authentification.php" target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-olympe.jpg')?>" />
                    </a>
                </div>

                <div class="app-icon">
                    <a href="https://www.achatpublic.com/snglogin/do/snglogin?urlprim=https%3A%2F%2Fwww.achatpublic.com%3A443%2Fsnglogin%2Fdo%2Fback%2Faccueil&error=3"
                        target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-achatpublic.jpg')?>" />
                    </a>
                </div>


                <div class="app-icon">
                    <a href="http://alpha/velo/" target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-velo.jpg') ?>" />
                    </a>
                </div>

                <div class="app-icon">
                    <a href="http://alpha/espace_finances" target="_blank">
                        <img class="app-image" src="<?= assets('images/applis/o-finance.jpg') ?>" />
                    </a>
                </div>

                <div class="app-icon">
                    <a data-toggle="modal" data-target="#ModalLiens">
                        <img class="app-image" src="<?= assets('images/applis/o-autres.jpg') ?>" />
                    </a>
                </div>
            </div>
        </div>
        <div class=" w-25" style="min-width: 25rem;" id="alerts">
            <h3 class="ml-2" style="margin-bottom: 1rem;">Alertes et informations</h3>
            <div class="overflow-auto w-100 bg-dark rounded m-2 p-3 text-justify" style="height: 75vh;">
                <h3 class="mb-5 text-light">Le service Informatique vous informe</h3>

                <?php 
                    foreach ($infos as $info) {
                        echo $info->Description;
                        echo '<div class="line mb-2"></div>';
                    }
                 ?>
            </div>
        </div>
        <div class="ml-4" id="demandes">
            <h3 style="margin-bottom: 1rem;">Demandes</h3>
            <a href="http://10.1.0.37/Nouvel_Agent" target="_blank" class="m-1">
                <div class="rounded w-100 ask-tile reveal-parent" style="width: 15rem; height: 7.7rem;">
                    <i class="fa fa-user mt-2 w-50 h-50" aria-hidden="true">
                    </i>
                    <p class="text-left m-1">Nouvel Agent</p>
                    <div class="reveal text-justify bg-white text-dark rounded h6 p-1">
                        <span class="text-medium h5">Nouvel Agent</span><br /><br />
                        Cliquez ici pour faire la déclaration d'un nouvel agent ou d'une nouvelle affectation.
                    </div>
                </div>
            </a>
            <a href="<?= route('support') ?>">
                <div class="rounded w-100 ask-tile reveal-parent" style="width: 15rem; height: 7.7rem;">
                    <i class="fa fa-cogs mt-2 w-50 h-50" aria-hidden="true">
                    </i>
                    <p class="text-left m-1">Dépannage/Assistance</p>
                    <div class="reveal text-justify bg-white text-dark rounded h6 p-1">
                        <span class="text-medium h5">Dépannage/Assistance</span><br /><br />
                        Cliquez ici pour faire une demande de dépannage ou d'assistance technique sur votre
                        équipement bureautique ou téléphonique.
                    </div>
                </div>
            </a>
            <a href="http://pret.ville-saint-louis.fr/" target="_blank" class="m-1">
                <div class="rounded w-100 ask-tile reveal-parent" style="width: 15rem; height: 7.7em;">
                    <i class="fa fa-calendar mt-2 w-50 h-50" aria-hidden="true">
                    </i>
                    <p class="text-left m-1">Agenda Prêt de matériel / Interventions</p>
                    <div class="reveal text-justify bg-white text-dark rounded h6 p-1">
                        <span class="text-medium h5">Prêt de matériel</span><br /><br />
                        Cliquez ici déclarer un prêt de matériel ou une intervention planifiée.
                    </div>
                </div>
            </a>
        </div>
        <div class="pl-4" id="aide">
            <h3 class="" style="margin-bottom: 1rem;">Aide et Documents</h3>
            <div class="d-flex flex-wrap justify-content-around text-center">
                <a href="<?= route('annuaire') ?>" type="link" class="helpTile" id="share">
                    <i class="fa fa-address-book" aria-hidden="true"></i>
                    <p class="h6">Annuaire</p>
                </a>
                <a href="<?= route('tutoriels.index') ?>" class="helpTile" id="docs">
                    <i class="fas fa-file-alt"></i>
                    <p class="h6">Documentation IT</p>
                </a>
                <a href="softwarecenter:" target="_blank" class="helpTile" id="appCenter">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    <p class="h6">Centre Logiciel</p>
                </a>
            </div>
        </div>

    </div>

</body>

</html>
