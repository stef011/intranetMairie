<?php ob_start() ?>


<div class="bg-secondary flex-fill text-light p-3 pl-5">
    <h2>
        <?= $_GET['subCat'] ?? false ? 'Tickets dans la catégorie ' . $showSub->nom : 'Tous les tickets' ?>
    </h2>
    <div class="mt-5 accordion" id="accordionExample">
        <?php foreach ($showSub ?? false ? $tickets->filter(['sous_category_id'=>$showSub->id]) : $tickets as $ticket) {?>
        <div class="card bg-dark">
            <a class="card-header flex-column" type="button" data-toggle="collapse"
                data-target="#collapseTicket<?= $ticket->id ?>" aria-expanded="true"
                aria-controls="collapseTicket<?= $ticket->id ?>">
                <h2 class="mb-0 h5">
                    <button class="btn btn-link text-white text-decoration-none" type="button" data-toggle="collapse"
                        data-target="#collapseTicket<?= $ticket->id ?>" aria-expanded="true"
                        aria-controls="collapseTicket<?= $ticket->id ?>">
                        <?= $ticket->subject ?>
                    </button>
                    <span class="float-right badge badge-pill badge-<?php switch ($ticket->state()->state) {
                    case 'Nouveau':
                            echo 'danger';
                    break;
                    case 'En cours':
                        echo 'warning';
                    break;
                    case 'Résolu':
                        echo 'success';
                    break;
                } ?>"><?= $ticket->state()->state ?></span>
                </h2>
            </a>

            <div id="collapseTicket<?= $ticket->id ?>" class="collapse bg-light text-dark" aria-labelledby="headingOne"
                data-parent="#accordionExample">
                <div class="card-body" style="white-space: pre-line;">
                    <?= $ticket->description ?>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a
                        href="mailto:<?= $ticket->prenom . '%20' . $ticket->nom ?><<?= $ticket->email ?>>?subject=Re:%20<?= str_replace(' ', '%20', $ticket->subject) ?>"><?= $ticket->nom . ' ' . $ticket->prenom . ' - ' . $ticket->service()->nom_service ?>
                    </a>
                    <div>
                        Marquer comme:
                        <a class="btn btn-danger"
                            href="<?= route('ticket.setState', ['id' => $ticket->id, 'state'=>1]) ?>">Nouveau</a>
                        <a class="btn btn-warning"
                            href="<?= route('ticket.setState', ['id' => $ticket->id, 'state'=>2]) ?>">En cours</a>
                        <a class="btn btn-success"
                            href="<?= route('ticket.setState', ['id' => $ticket->id, 'state'=>3]) ?>">Résolu</a>
                    </div>
                    <p>Le
                        <?= date('d-m-Y à H:i' , strtotime($ticket->date)) ?></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php 
$content = ob_get_clean();
include('ressources/views/layouts/adminLayout.php');
?>
