<?php
    namespace App;

    abstract class AbstractController{

        public function index(){}
        
        public function redirectTo($ctrl = null, $action = null, $id = null)
        {
            // Si on est sur le home
            if( ( $ctrl == "home" ) && ( $action == "index" ) ) 
            {
                $url = "./";
            }
            else
            {
                $url = $ctrl ? "./?ctrl=".$ctrl : "";
                $url.= $action ? "&action=".$action : "";
                $url.= $id ? "&id=".$id : "";
            }
            // On redirige la page
            header("Location: $url");
            die();
        }

        public function restrictTo($role)
        {
            // Si on n'est pas connecté ou qu'on n'a pas le role
            if(!Session::getUser() || !Session::getUser()->hasRole($role)){
                // On redirige vers la page de login
                $this->redirectTo("security", "loginForm");
            }
            return;
        }

    }