<?php
    if( isset( $result["data"]['message'] ) ) $message = $result["data"]['message'];
?>

<h2>Détail d'un Message pour l'administrateur</h2>
<div class="flex-row">

<?php
    if( App\Session::isAdmin() ) {
        if( isset($message) ) {
?>
    <div class="card width-600">
        <h3>
            <?= $message->getObject() ?>
        </h3>
        <p class="width-500">
            <?= $message->getMessage() ?>
        </p>
        <form action="./?ctrl=security&action=messageDelete&id=<?= $message->getId() ?>" method="POST">
            <button type="submit" class="error">Supprimer le message</button>
        </form>
    </div>
<?php
        }
    }
?>
</div>