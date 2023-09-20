<?php
    /**
     * VUE DU FORMULAIRE D'ENREGISTREMENT
     */
    $user = App\Session::getUser();
    if( isset($result["data"]['password']) ) $password = $result["data"]['password'];
    if( isset($result["data"]['passwordNew']) ) $passwordNew = $result["data"]['passwordNew'];
    if( isset($result["data"]['passwordConfirm']) ) $passwordConfirm = $result["data"]['passwordConfirm'];
    require_once( BASE_DIR."view/utils/printErrorMessage.php" );
?>

    <!-- Titre -->
    <h2>Modifier votre mot de passe :</h2>

    <!-- Formulaire d'inscription -->
    <form action="./?ctrl=security&action=passwordModify" method="POST" class="card">

        <!-- Demander le Mot de passe -->
<?php
    printErrorMessage('password');
?>
        <label for="password">Veuillez saisir votre mot de passe actuel : </label>
        <input type="password" name="password" id="password" value="<?= isset($password)?$password:"" ?>">

        <!-- Demander le nouveau Mot de passe -->
<?php
    printErrorMessage('passwordNew');
?>
        <label for="passwordNew">Merci de saisir le nouveau mot de passe : </label>
        <input type="password" name="passwordNew" id="passwordNew" value="<?= isset($passwordNew)?$passwordNew:"" ?>">

        <!-- Demander le Mot de passe de confirmation-->
<?php
    printErrorMessage('passwordConfirm');
?>
        <label for="passwordConfirm">Merci de confirmer votre nouveau mot de passe : </label>
        <input type="password" name="passwordConfirm" id="passwordConfirm" value="<?= isset($passwordConfirm)?$passwordConfirm:"" ?>">

        <!-- Bouton d'envoi du formulaire -->
        <button type="submit">Modifier</button>

    </form>