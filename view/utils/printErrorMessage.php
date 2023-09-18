<?php
    function printErrorMessage( $param ){
        if( ( $errMess = App\Session::getErrors( $param ) ) !== "" ) {
?>
        <h3 class="message1" style="background-color: #f00; color:var(--color-gold);"><?= $errMess ?></h3>
<?php
        }
    }