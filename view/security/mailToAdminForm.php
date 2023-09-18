<?php
    if( isset($result["data"]['object']) ) $object = $result["data"]['object'];
    if( isset($result["data"]['message']) ) $message = $result["data"]['message'];
    require_once( BASE_DIR."view/utils/printErrorMessage.php" );
?>

    <!-- Titre -->
    <h2>Envoyer un mail à l'administrateur :</h2>

    <!-- Formulaire d'inscription -->
    <form action="./?ctrl=security&action=mailToAdmin" method="POST" class="card width-500">

        <!-- Demander l'objet du Message -->
        <?php
    printErrorMessage('object');
?>
        <label for="object">Objet du message : </label>
        <input type="texte" name="object" id="object" value="<?= isset($object)?$object:"" ?>">

        <!-- Demander le Message -->
        <?php
    printErrorMessage('message');
?>
        <label for="message">Message : </label>
        <textarea name="message" id="message"><?= isset($message)?$message:"" ?></textarea>

        <!-- Bouton d'envoi du formulaire -->
        <button type="submit">Envoyer le message</button>

    </form>