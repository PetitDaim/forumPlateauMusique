<?php
    // Rangé sur l'étagère Model \ Entities
    namespace Model\Entities;

    // Utilise la classe Entity rangé sur le namespace App
    use App\Entity;
    use App\Session;
    use Model\Managers\MessageManager;

    // final => la class Topic ne peut pas avoir d'enfants et elle hérite de laz classe Entity
    final class Message extends Entity{

        // liste des propriétés de la classe Topic selons le principe d'encapsulation mes propriétés sont privées, 
        // c'est à dire qu'elles ne seront accessible que depuis la classe
        // ou bien par des setters getters
        private $id;
        private $object;
        private $message;

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
        public function getObject()
        {
                return $this->object;
        }

        /**
         * Set the value of categoryName
         *
         * @return  self
         */ 
        public function setObject($object)
        {
                $this->object = $object;

                return $this;
        }

        /**
         * Get the value of categoryNameSingulier 
         */ 
        public function getMessage()
        {
                return $this->message;
        }

        /**
         * Set the value of categoryNameSingulier
         *
         * @return  self
         */ 
        public function setMessage($message)
        {
                $this->message = $message;

                return $this;
        }

        /**
         * Fonction pour supprimer de la base de données (cascade)
         */
        public function delete()
        {
                // Vérifie qu'on a bien le droit de supprimer la catégorie
                if( ! Session::isAdmin() ) return;
                // Instancie le manager de message
                $messageManager = new MessageManager();
                // Supprime le message
                $messageManager->delete( $this->getId() );
        }

        /**
         * Returns the object of the message
         */
        public function __toString() : string
        {
                return $this->object;
        }
    }