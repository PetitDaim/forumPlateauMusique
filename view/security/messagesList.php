<?php
     /**
     * VUE DE LA LISTE DES MAILS A L'ADMIN
     */
    if( isset( $result["data"]['messages'] ) ) $messages = $result["data"]['messages'];
?>

<h2>liste des Messages pour l'administrateur</h2>
<div class="flex-row">

<?php
    // Si on est admin
    if( App\Session::isAdmin() ) 
    {
        // Si il y a bien des messages
        if( isset($messages) ) 
        {
            // On boucle sur les messages
            foreach($messages as $message )
            {
?>
    <div class="card width-500">
        <h3>
            <?= $message->getObject() ?>
        </h3>
        <form action="./?ctrl=security&action=messageDetail&id=<?= $message->getId() ?>" method="POST">
            <button type="submit">
                Voir le message
            </button>
        </form>
        <form action="./?ctrl=security&action=messageDelete&id=<?= $message->getId() ?>" method="POST">
            <button type="submit" class="error">Supprimer le message</button>
        </form>
    </div>
<?php
            }
        }
    }
?>
</div>