<?php
    namespace App;

    include_once( "../controller/utils/nePasUploader.php" );

    class Session{

        private static $categories = ['error', 'success'];

        /**
        *   ajoute un message en session, dans la catégorie $categ
        */
        public static function addFlash($categ, $msg){
            if( ! in_array( $categ, Session::$categories ) ) return;
            $_SESSION[$categ] = $msg;
        }

        /**
        *   renvoie un message de la catégorie $categ, s'il y en a !
        */
        public static function getFlash($categ)
        {
            if( ! in_array( $categ, Session::$categories ) ) return "";
            if(isset($_SESSION[$categ])){
                $msg = $_SESSION[$categ];  
                unset($_SESSION[$categ]);
            }
            else $msg = "";
            
            return $msg;
        }

        /**
        *   ajoute un message en session, dans la catégorie $categ
        */
        public static function addErrors($categ, $msg){
            $_SESSION['local_errors'][$categ] = $msg;
        }

        /**
        *   renvoie un message de la catégorie $categ, s'il y en a !
        */
        public static function getErrors($categ){
            
            if(isset($_SESSION['local_errors'][$categ])){
                $msg = $_SESSION['local_errors'][$categ];  
                unset($_SESSION['local_errors'][$categ]);
            }
            else $msg = "";
            
            return $msg;
        }

        public static function currentPageURL() {
            $pageURL=".";
            if( IsProd ) {
                $pageURL = 'http';
                if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
                $pageURL .= "://";
                $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
            }
            else {
                $subDir=(true)?'ForumMusique/forumPlateau/':"forumMusique/";
                $pageURL = str_replace( "/ElanFormation/exercices/".$subDir."public", ".", $_SERVER["REQUEST_URI"] );
            }
            return $pageURL;
        }

        /**
        *   ajoute l'url en session
        */
        public static function saveUrl(){
            if( IsProd ) {
                $srv = 'http';
                if ($_SERVER["HTTPS"] == "on") {$srv .= "s";}
                $srv .= "://";
                $srv .= $_SERVER["SERVER_NAME"]."/public";
            }
            else {
                $srv = '.';
            }
            $url = Session::currentPageUrl();
            if( ( $url != "$srv/?ctrl=security&action=connexionForm" ) &&
            ( $url != "$srv/?ctrl=security&action=connexion" ) &&
            ( $url != "$srv/?ctrl=security&action=logout" ) &&
            ( $url != "$srv/?ctrl=security&action=registerForm") &&
            ( $url != "$srv/?ctrl=security&action=register") ) {
                $_SESSION['savedUrl'] = $url;
            }
        }

        /**
        *   renvoie l'url sauvegardée en session, s'il y en a !
        */
        public static function restoreUrl(){
            if(isset($_SESSION['savedUrl'])){
                $savedUrl = $_SESSION['savedUrl'];
            }
            else $savedUrl = "./";
            header( "location: $savedUrl" );
        }

        /**
        *   met un user dans la session (pour le maintenir connecté)
        */
        public static function setUser($user){
            $_SESSION["user"] = $user;
        }

        public static function getUser(){
            return (isset($_SESSION['user'])) ? $_SESSION['user'] : false;
        }

        public static function isAdmin(){
            if(self::getUser() && self::getUser()->hasRole("ROLE_ADMIN")){
                return true;
            }
            return false;
        }

    }