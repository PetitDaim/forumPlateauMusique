<?php
/**
 * Fonction pour afficher un message d'erreur
 */
    function printErrorMessage( $param ){
        if( ( $errMess = App\Session::getErrors( $param ) ) !== "" ) {
?>
        <h3 class="message-erreur"><?= $errMess ?></h3>
<?php
        }
    }