<h2>Liste des users</h2>

<?php
    $users = $result["data"]['users'];
    foreach( $users as $user ){
?>
    <p class="card">
        <a href="./?ctrl=security&action=userDetail&id=<?= $user->getId() ?>"><sub><img src="<?= $user->getAvatar() ?>" alt="<?= $user->getPseudo() ?>" class="mini-signature"/></sub> <?= $user->getPseudo() ?>: &lt;<?= $user->getEmail() ?>&gt;</a>
    </p>
<?php
    }
?>
