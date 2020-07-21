<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support | Alpha</title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= assets('css/bootstrap/bootstrap.min.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?= assets('FontAwesome/css/all.min.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?= assets('css/supportIndex.css')?>" type="text/css" />

    <!-- Javascript -->
    <script src="<?= assets('FontAwesome/js/all.min.js')?>"></script>
    <script src="<?= assets('js/jquery.min.js')?>" type="text/javascript"></script>
    <script src="<?= assets('js/bootstrap/bootstrap.min.js') ?>"></script>
    <script defer src="<?= assets('js/bootstrap/bootstrap.min.js')?>"></script>
</head>

<body>
    <header>
        <h1 class="m-5"> <img src="<?= assets('Images/logo_white.png') ?>" alt="Logo"
                style="width: 2.5rem; position: relative; bottom: 0.35rem;">
            Demande de Support |
            Site
            Alpha </h1>
    </header>

    <div class="container-fluid mb-4 ml-md-4 ml-2 row">
        <form action="<?= route('support.post') ?>" method="post" class="col-md-7">

            <h3 class="form-row mb-2">Vos Coordonnées: </h3>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <input type="text" name="nom" placeholder="Nom" value="<?= '' ?>" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <input type="text" name="prenom" placeholder="Prénom" value="<?= '' ?>" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <select name="Service" class="form-control">
                        <option value="null" disabled selected hidden>Selectionnez votre Service</option>
                        <?php foreach ($services as $service) {?>
                        <option value="<?= $service->id_service ?>"> <?= $service->nom_service ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <h3 class="form-row">Votre Problème</h3>

            <div class="form-row">
                <div class="col-md-6">
                    <select name="Categorie" id="cat" class="form-control" onselect="selected()" required>
                        <option value="null" disabled selected hidden>Selectionnez une catégorie</option>
                        <?php foreach ($categories as $cat) { ?>
                        <option value="<?= $cat->id ?>"><?= $cat->nom ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        Veuillez choisir une catégorie.
                    </div>
                </div>
                <div class="col-md-6 mt-md-0 mt-1">
                    <select name="subCategorie" id="sub-cat" class="form-control" required>
                        <option value="null" disabled selected hidden>Selectionnez une sous-catégorie</option>
                        <!-- TODO : Ajouter le foreach php et créer la table  -->
                    </select>
                    <div class="invalid-feedback">
                        Veuillez choisir une Sous-catégorie.
                    </div>
                </div>
            </div>

            <div class="form-row mt-2">
                <div class="col-md-12">
                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Sujet" required>
                </div>
            </div>
            <div class="form_row mt-1">
                <div class="col-12 ml-1">
                    <input type="checkbox" name="agree" id="agree" class="form-check-input"> <label for="agree"
                        class="form-check-label">J'ai consulté
                        l'aide rapide mais mon
                        problème n'est pas résolu...</label>
                </div>
            </div>
            <div id="hidden-container" style="visibility: hidden;">
                <div class="form-row">
                    <div class="col-md-12"><textarea name="desc" id="desc" class="form-control mt-3"
                            placeholder="Description rapide du problème" required></textarea></div>
                </div>

                <div class="form-row">
                    <div class="col-md-2 mt-1"><button type="submit" class="btn btn-light">Envoyer</button></div>
                </div>
            </div>
        </form>

        <div id='solution' class="col-md mt-4 mr-4 ml-3 rounded pt-2">
            <h3>À essayer d'abord:</h3>
            <ul id="list" class="h4">
                Commencez à écrire un Sujet.
            </ul>
        </div>
    </div>


    <script type="text/javascript">
    $('#agree').change(function() {
        if ($('#agree').is(':checked')) {
            $('#hidden-container').css('visibility', 'visible');
        } else {
            $('#hidden-container').css('visibility', 'hidden');
        }
    })
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#subject').keyup(function() {
            search = new String;
            search = $(this).val();
            console.log(search.length)
            if (search != '' && search.length > 4) {
                $.ajax({
                    url: "/api/tutorials",
                    method: "post",
                    data: {
                        search: search
                    },
                    dataType: "text",
                    success: function(data) {
                        if (data != '') {
                            $('#list').html(data)

                        } else {
                            $('#list').html('Aucun résultat trouvé!')
                        }

                    }
                })
            } else {
                $('#liste').html('Aucun résultat trouvé');
            }
        })
    })
    </script>
</body>

</html>
