<h2>Liste des users</h2>

<?php
    if( isset( $result["data"]['users'] ) ) $users = $result["data"]['users'];
    // Si il y a bien des utilisateurs
    if( isset( $users ) ) {
        // On boucle sur les utilisateurs
        foreach( $users as $user ){
?>
<p class="card">
    <a href="./?ctrl=security&action=userDetail&id=<?= $user->getId() ?>"><sub><img src="<?= $user->getAvatar() ?>" alt="<?= $user->getPseudo() ?>" class="mini-signature"/></sub> <?= $user->getPseudo() ?>: &lt;<?= $user->getEmail() ?>&gt;</a>
</p>
<?php
        }
    }
?>
