<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=10">
    <title>INTRANET INFORMATIQUE | ALPHA | ANNUAIRE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<meta http-equiv="refresh" content="300">-->
    <link rel="icon" href="<?= assets('images/logo_white.png')?>">
    <link rel="stylesheet" href="<?= assets('css/bootstrap/bootstrap.min.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?= assets('FontAwesome/css/all.min.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?= assets('css/annuaire.css')?>" type="text/css" />


    <!-- Javascript -->
    <script defer src="<?= assets('FontAwesome/js/all.min.js')?>"></script>
    <script defer src="<?= assets('js/jquery.min.js')?>"></script>
    <script defer src="<?= assets('js/bootstrap/bootstrap.min.js')?>"></script>




</head>

<body class="p-3">
    <header class="header ml-4 m-2">
        <h1>
            <a href="index.php" class="text-white">
                <img src="<?= assets('images/logo_white.png') ?>" height="32" width="35" class="header-logo" alt=""
                    class="mb-5" />
                <span class="d-none d-md-inline">INTRANET INFORMATIQUE | ALPHA | ANNUAIRE</span>
            </a>
        </h1>
    </header>
    <div id="content" class="d-flex">
        <section class="clearfix section isotope">

            <form action="<?= route('annuaire') ?>" method="get" class="flex-row mt-5 ml-4">
                <div class="input-group">
                    <input type="text" class="col-md-7 col-lg-7 mr-1 rounded" name="search"
                        placeholder="Nom, Prénom, Service, Fonction, etc." value="<?= $search ?>" />
                    <!--<input type="text" value="" id="recherche_annu_prenom" class="search col-md-5 col-lg-5" name="rechercheprenom" placeholder="Prénom"  title="Rechercherprenom" style="font-size: x-large;height: 50px;margin-left: 15px;">-->
                    <input type="submit" value="Rechercher" class="btn btn-primary col-md-2 col-lg-2">
                    <?php if(isset($_GET['search'])){ ?>
                    <a href="<?= route('annuaire') ?> " class="btn btn-danger ml-1 col-md-2 col-lg-2 d-block">Annuler la
                        recherche</a>
                    <?php } ?>
                </div>
            </form>

            <table class="table table-responsive-md mt-3 ml-4 d-block"
                style="width: 75vw; max-height: 75vh; overflow-y: auto;">
                <thead class="position-sticky thead-dark" style="top: 0;">
                    <!-- TODO: Optimiser les conditions ternaires, il y a sûrement moyen de faire plus court.    -->

                    <th> <a class="text-white"
                            href="<?= isset($_GET['sort']) ? ($_GET['sort'] == 'name' ? '?sort=aname' . $searchUri : '?sort=name' . $searchUri) : '?sort=name' . $searchUri ?>">
                            <i class="<?= !isset($_GET['sort']) ? 'fas fa-sort' : ($_GET['sort'] == 'name' ? 'fas fa-sort-down' : ($_GET['sort'] != 'aname' ? 'fas fa-sort' : 'fas fa-sort-up')) ?>"
                                style="color: white"></i> NOM
                        </a>
                    </th>
                    <th>
                        <a class="text-white"
                            href="<?= isset($_GET['sort']) ? ($_GET['sort'] == 'surname' ? '?sort=asurname' . $searchUri : '?sort=surname' . $searchUri) : '?sort=surname' . $searchUri ?>">
                            <i class="<?= !isset($_GET['sort']) ? 'fas fa-sort' : ($_GET['sort'] == 'surname' ? 'fas fa-sort-down' : ($_GET['sort'] != 'asurname' ? 'fas fa-sort' : 'fas fa-sort-up')) ?>"
                                style="color: white"></i> Prénom
                        </a>
                    </th>
                    <th><a class="text-white"
                            href="<?= isset($_GET['sort']) ? $_GET['sort'] == 'function' ? '?sort=afunction' . $searchUri : '?sort=function' . $searchUri : '?sort=function' . $searchUri ?>">
                            <i class="<?= !isset($_GET['sort']) ? 'fas fa-sort' : ($_GET['sort'] == 'function' ? 'fas fa-sort-down' : ($_GET['sort'] != 'afunction' ? 'fas fa-sort' : 'fas fa-sort-up')) ?>"
                                style="color: white"></i> Fonction
                        </a>
                    </th>
                    <th>
                        <a class="text-white"
                            href="<?= isset($_GET['sort']) ? $_GET['sort'] == 'service' ? '?sort=aservice' . $searchUri : '?sort=service' . $searchUri : '?sort=service' . $searchUri ?>">
                            <i class="<?= !isset($_GET['sort']) ? 'fas fa-sort' : ($_GET['sort'] == 'service' ? 'fas fa-sort-down' : ($_GET['sort'] != 'aservice' ? 'fas fa-sort' : 'fas fa-sort-up')) ?>"
                                style="color: white"></i> Service
                        </a>
                    </th>
                    <th>
                        Chef de service
                    </th>
                    <th>
                        Tél interne
                    <th>
                        Tél externe
                    </th>
                    <th>
                        Détails
                    </th>
                </thead>
                <tbody class="overflow-auto text-white">
                    <?php foreach($agents as $agent){ ?>
                    <tr class=" bg-<?= str_replace(' ', '', strtr( $agent->service, $tableau_accents ))?>">
                        <td><?= $agent->nom ?></td>
                        <td><?= $agent->prenom ?></td>
                        <td><?= strlen($agent->fonction) >= 55 ? substr($agent->fonction, 0, 55) . ' ...' : $agent->fonction ?>
                        </td>
                        <td><?= $agent->service ?></td>
                        <td><?= $agent->chef_de_service == true ?'<i class="fa fa-star" aria-hidden="true"></i>' : '' ?>
                        </td>
                        <td><?= $agent->tel_int ?></td>
                        <td><?= $agent->tel_ext ?></td>
                        <td><button type="button" data-toggle="modal" data-target="#Modal<?= $agent->id_u ?>"
                                style="cursor: pointer;" class="btn"><i class="fa fa-plus text-white"
                                    aria-hidden="true"></i></button></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>

        <div class="m-5 text-center">
            <h3 class="text-white">Annexes</h3>

            <div class="annexeTile text-decoration-none"
                style="background: linear-gradient(to bottom right,#0A467E ,#126BB5 );">
                <a type="file" href="<?= assets('download/annuaire-2020.pdf') ?>" download="Annuaire 2020"
                    style="color: white !important;">
                    <i class="fa fa-address-book" style="font-size: 3rem;"></i>
                    <br>
                    <p>Annuaire</p>
                </a>
            </div>

            <div class="annexeTile text-decoration-none"
                style="background: linear-gradient(to bottom right,#029941 ,#13BD5A );">
                <a type="file" href="<?= assets('download/trombinoscope-2020.pdf') ?>" target="_blank"
                    style="color: white !important;">
                    <i class="fa fa-users" style="font-size: 3rem;"></i>
                    <br>
                    <p>Trombinoscope</p>
                </a>
            </div>
        </div>
    </div>

    <?php foreach($agents as $agent){ ?>
    <div class=" modal fade" id="Modal<?= $agent->id_u ?>" tabindex="-1" role="dialog"
        aria-labelledby="Modal<?= $agent->id_u ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Modal<?= $agent->id_u ?>">Fiche détaillée de l'agent :
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex">
                        <img class="rounded"
                            src="<?= assets('images/photoagents/'.($agent->nom_photo ?? 'default.jpg')) ?>"
                            alt="Photo agent" style="width: 5rem;">
                        <h3 class="ml-2 mt-3"><?= $agent->nom . ' ' . $agent->prenom ?></h3>
                    </div>
                    <div class="line"></div>
                    <table class="talbe table-borderless m-3 mr-5" style="width: 100%;">
                        <tbody>
                            <tr>
                                <th>Fonction</th>
                                <td class="p-1"><?= $agent->fonction ?></td>
                            </tr>
                            <tr>
                                <th>Service</th>
                                <td class="p-1"><?= $agent->service ?></td>
                            </tr>
                            <tr>
                                <th>Pôle</th>
                                <td class="p-1"><?= $agent->description ?></td>
                            </tr>
                            <tr>
                                <th>Site (géographique)</th>
                                <td class="p-1"><?= $agent->localisation ?></td>
                            </tr>
                            <tr>
                                <th>Adresse</th>
                                <td class="p-1"><?= $agent->adresse_postal ?></td>
                            </tr>
                            <tr>
                                <th>Bureau</th>
                                <td class="p-1"><?= $agent->num_bureau ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td class="p-1"><?= $agent->adresse_mail ?></td>
                            </tr>
                            <tr>
                                <th>Téléphone Interne</th>
                                <td class="p-1"><?= $agent->tel_int ?></td>
                            </tr>
                            <tr>
                                <th>Telephone Externe</th>
                                <td class="p-1"><?= $agent->tel_ext ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <?php } ?>

    <?php /* <?php echo $modalutilisateur; ?> */ ?>
</body>

</html>
