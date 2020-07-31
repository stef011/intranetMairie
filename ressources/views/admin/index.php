<?php ob_start() ?>


<div class="mx-auto w-75 mt-5">
    Votre interface de gestion administrateur n'es pas encore sur ce nouveau site, veuillez plutôt vous rendre sur la <a
        href="http://alpha/admin">version 1 du site Alpha</a>.
</div>


<?php 
$content = ob_get_clean();
include("ressources/views/layouts/adminLayout.php");
?>
