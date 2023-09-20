<?php
    // Rangé sur l'étagère Model \ Entities
    namespace Model\Entities;

    // Utilise la classe Entity rangé sur le namespace App
    use App\Entity;
    use App\Session;
    use Model\Managers\TopicLikeManager;

    // final => la class TopicLike ne peut pas avoir d'enfants et elle hérite de laz classe Entity
    final class TopicLike extends Entity
    {

        // liste des propriétés de la classe TopicLike selons le principe d'encapsulation mes propriétés sont privées, 
        // c'est à dire qu'elles ne seront accessible que depuis la classe
        // ou bien par des setters getters
        private $id;
        private $topic;
        private $user;
        private $likeDate;

        /**
         * Constructeur
         */ 
        public function __construct($data)
        {
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
         * Get the value of topic
         */ 
        public function getTopic()
        {
                return $this->topic;
        }

        /**
         * Set the value of topic
         *
         * @return  self
         */ 
        public function setTopic($topic)
        {
                $this->topic = $topic;

                return $this;
        }

        /**
         * Get the value of user
         */ 
        public function getUser()
        {
                return $this->user;
        }

        /**
         * Set the value of user
         *
         * @return  self
         */ 
        public function setUser($user)
        {
                $this->user = $user;

                return $this;
        }

        /**
         * Get the value of likeDate
         */ 
        public function getLikeDate()
        {
                return $this->likeDate;
        }

        /**
         * Set the value of likeDate
         *
         * @return  self
         */ 
        public function setLikeDate($likeDate)
        {
                $this->likeDate = $likeDate;

                return $this;
        }

        /**
         * Fonction pour supprimer en base de données
         */
        public function delete()
        {
                if( ! Session::isAdmin() ) return;
                // Instancie le manager de like de topic
                $topicLikeManager = new TopicLikeManager();
                // Supprime le likes de topic à supprimer
                $topicLikeManager->delete( $this->getId() );
        }

        /**
         * Retuns the message
         */
        public function __toString()
        {
            return $this->likeDate;
        }
}