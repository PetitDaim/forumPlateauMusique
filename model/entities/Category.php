<?php
    // Rangé sur l'étagère Model \ Entities
    namespace Model\Entities;

    // Utilise la classe Entity rangé sur le namespace App
    use App\Entity;
    use App\Session;
    use Model\Managers\TopicManager;
    use Model\Managers\CategoryManager;

    // final => la class Topic ne peut pas avoir d'enfants et elle hérite de laz classe Entity
    final class Category extends Entity{

        // liste des propriétés de la classe Topic selons le principe d'encapsulation mes propriétés sont privées, 
        // c'est à dire qu'elles ne seront accessible que depuis la classe
        // ou bien par des setters getters
        private $id;
        private $categoryName;
        private $categoryNameSingulier;
        private $presentation;

        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of categoryName 
         */ 
        public function getCategoryName()
        {
                return $this->categoryName;
        }

        /**
         * Set the value of categoryName
         *
         * @return  self
         */ 
        public function setCategoryName($categoryName)
        {
                $this->categoryName = $categoryName;

                return $this;
        }

        /**
         * Get the value of categoryNameSingulier 
         */ 
        public function getCategoryNameSingulier()
        {
                return $this->categoryNameSingulier;
        }

        /**
         * Set the value of categoryNameSingulier
         *
         * @return  self
         */ 
        public function setCategoryNameSingulier($categoryNameSingulier)
        {
                $this->categoryNameSingulier = $categoryNameSingulier;

                return $this;
        }

        /**
         * Get the value of presentation
         */ 
        public function getPresentation()
        {
                return $this->presentation;
        }

        /**
         * Set the value of presentation
         *
         * @return  self
         */ 
        public function setPresentation($presentation)
        {
                $this->presentation = $presentation;

                return $this;
        }

        /**
         * Get the number of topics of the category
         */ 
        public function getTopicsCount() : int
        {
                // Intancie le manager de sujet
                $topicManager = new TopicManager();
    
                // Renvoie le COUNT() AS c
                return $topicManager->countAllWhereCategory($this->getId());
        }

        /**
         * Fonction pour supprimer de la base de données (cascade)
         */
        public function delete()
        {
                // Vérifie qu'on a bien le droit de supprimer la catégorie
                if( ! Session::isAdmin() ) return;
                // Instancie le manager de topic
                $topicManager = new TopicManager();
                // Récupère la liste des topic de la catégorie à supprimer
                $topics = $topicManager->findAllWhereCategory( $this->getId() );
                if( $topics ) {
                        // Supprime les topics un à un
                        foreach( $topics as $topic ) {
                                $topic->delete();
                        }
                }
                // Instancie le manager de catégorie
                $categoryManager = new CategoryManager();
                // Supprime la catégorie
                $categoryManager->delete( $this->getId() );
        }

        /**
         * Returns the category name
         */
        public function __toString() : string
        {
                return $this->categoryName;
        }
    }