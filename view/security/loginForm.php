<?php
    if( isset($result["data"]['user']) ) $user = $result["data"]['user'];
    require_once( BASE_DIR."view/utils/printErrorMessage.php" );
?>

    <!-- Titre -->
    <h2>Authentification :</h2>

    <!-- Formulaire d'inscription -->
    <form action="./?ctrl=security&action=login" method="POST" class="card">

        <!-- Demander le Pseudo -->
<?php
    printErrorMessage('pseudo');
?>
        <label for="pseudo">Pseudo : </label>
        <input type="text" name="pseudo" id="pseudo" value="<?= isset($user)?$user->getPseudo():"" ?>">

        <!-- Demander l' EMail' -->
        <label for="email">EMail : </label>
        <input type="text" name="email" id="email" value="<?= isset($user)?$user->getEmail():"" ?>">

        <!-- Demander le Mot de passe -->
<?php
    printErrorMessage('password');
?>
        <label for="password">Password : </label>
        <input type="password" name="password" id="password" value="<?= isset($user)?$user->getPassword():"" ?>">

        <!-- Bouton d'envoi du formulaire -->
        <button type="submit">Me connecter</button>

    </form>