<?php
    /**
     * VUE DU DÉTAIL DE MAIL A L'ADMIN
     */
    if( isset( $result["data"]['message'] ) ) $message = $result["data"]['message'];
?>

<h2>Détail d'un Message pour l'administrateur</h2>
<div class="flex-row">

<?php
    // Si on est administrateur
    if( App\Session::isAdmin() ) 
    {
        // Si il y a bien un message à afficher
        if( isset($message) ) 
        {
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