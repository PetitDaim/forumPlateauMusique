<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\PostManager;
    
    class HomeController extends AbstractController implements ControllerInterface
    {

        /**
         * Méthode qui renvoie la liste des catégories triées par nom de catégorie croissant
         */
        public function index()
        {
            // instancien le manager des catégories
            $categoryManager = new CategoryManager();
            // Définit le titre de la page
            $title = "Accueil du forum de musique";
            // definit la description de la page
            $description = "Ce forum de musique présente diverses catégorie de publications de sujets permettant à des artistes qui souhapitent émerger, de faire connaître leurs créations musicales";
            // Renvoie la vue de la liste des catégories
            return [
                "view" => VIEW_DIR."home/home.php",
                "data" => [
                    // Passe la liste des catégories triées par nom de catégorie croissant
                    "categories" => $categoryManager->findAll(["categoryName", "ASC"]),
                    "title" => "Liste des catégories",
                    'description' => "Liste des catégories (par ordre alphabétique)"
                ]
            ];
 
        }
  
        /**
         * Méthode qui renvoie vers les règles du forum
         */
        public function forumRules()
        {
            return [
                "view" => VIEW_DIR."home/rules.php",
                "data" => [
                    "title" => "Règles du forum de musique",
                    'description' => "Ce forum de musique possède des règles d'utilisation qu'il convient de respecter sous peine d'être banni du forum"
                ]
            ];
        }

        /**
         * Méthode qui renvoie vers les mentions légales
         */
        public function mentionsLegales()
        {
            return [
                "view" => VIEW_DIR."home/mentionsLegales.php",
                "data" => [
                    "title" => "Mentions légales du forum de musique",
                    'description' => "Les mentions légales présentent principalement l'auteur du forum, les droits d'auteur et l'hébergeur du forum."
                ]
            ];
        }

        /**
         * Méthode appelée par Ajax qui permet d'afficher la liste des topic correspondant à la recherche
         */
        public function search()
        {
            if( isset( $_GET["recherche"] ) ) {
                $recherche = filter_input( INPUT_GET, "recherche", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            }
            // Instanciation du manager des sujets
            $topicManager = new TopicManager();
            // Renvoie la vue de liste des sujets, ainsi que les paramètres associés
            $result = [
                // "view" => VIEW_DIR."forum/topicsList.php",
                "data" => [
                    "topics" => $topicManager->findAllWhereSearch( $recherche, ["creationDate", "DESC"]),
                    "title" => "sujets contenants « $recherche »"
                ]
            ];
         
            include(VIEW_DIR."forum/topicsList.php");
        }

        /**
         * Méthode pour incrémenter un compteur et l'afficher pour une requête ajax
         */
        public function ajax()
        {
            $nb = $_GET['nb'];
            $nb++;
            echo $nb;
        }
    }
