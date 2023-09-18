<?php
    if( isset($result["data"]['user']) ) $user = $result["data"]['user'];
    if( isset($result["data"]['password']) ) $password = $result["data"]['password'];
    if( isset($result["data"]['passwordConfirm']) ) $passwordConfirm = $result["data"]['passwordConfirm'];
    require_once( BASE_DIR."view/utils/printErrorMessage.php" );
?>

    <!-- Titre -->
    <h2>Ajouter un utilisateur :</h2>

    <!-- Formulaire d'inscription -->
    <form action="./?ctrl=security&action=register" method="POST" class="card">

        <!-- Demander le Pseudo -->
<?php
    printErrorMessage('pseudo');
?>
        <label for="pseudo">Pseudo : </label>
        <input type="text" name="pseudo" id="pseudo" value="<?= isset($user)?$user->getPseudo():"" ?>">

        <!-- Demander l' EMail' -->
<?php
    printErrorMessage('email');
?>
        <label for="email">EMail : </label>
        <input type="text" name="email" id="email" value="<?= isset($user)?$user->getEmail():"" ?>">

        <!-- Demander le Mot de passe -->
        <?php
    printErrorMessage('password');
?>
        <label for="password">Password : </label>
        <input type="password" name="password" id="password" value="<?= isset($password)?$password:"" ?>">

        <!-- Demander le Mot de passe -->
        <label for="passwordConfirm">Comfirm password : </label>
        <input type="password" name="passwordConfirm" id="passwordConfirm" value="<?= isset($passwordConfirm)?$passwordConfirm:"" ?>">

        <!-- Bouton d'envoi du formulaire -->
        <button type="submit">M'inscrire</button>

    </form>