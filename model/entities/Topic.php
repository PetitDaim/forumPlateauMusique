<?php
    // Rangé sur l'étagère Model \ Entities
    namespace Model\Entities;

    // Utilise la classe Entity rangé sur le namespace App
    use App\Entity;
    use App\Session;
    use Model\Managers\TopicLikeManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;

    // final => la class Topic ne peut pas avoir d'enfants et elle hérite de laz classe Entity
    final class Topic extends Entity{

        // liste des propriétés de la classe Topic selons le principe d'encapsulation mes propriétés sont privées, 
        // c'est à dire qu'elles ne seront accessible que depuis la classe
        // ou bien par des setters getters
        private $id;
        private $title;
        private $user;
        private $category;
        private $media;
        private $creationDate;
        private $closed;

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
         * Get the value of title
         */ 
        public function getTitle()
        {
                return $this->title;
        }

        /**
         * Set the value of title
         *
         * @return  self
         */ 
        public function setTitle($title)
        {
                $this->title = $title;

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
         * Get the value of category
         */ 
        public function getCategory()
        {
                return $this->category;
        }

        /**
         * Set the value of category
         *
         * @return  self
         */ 
        public function setCategory($category)
        {
                $this->category = $category;

                return $this;
        }

        /**
         * Get the value of media
         */ 
        public function getMedia()
        {
                return $this->media;
        }

        /**
         * Set the value of media
         *
         * @return  self
         */ 
        public function setMedia($media)
        {
                $this->media = $media;

                return $this;
        }

        public function getCreationDate(){
            $formattedDate = $this->creationDate->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setCreationDate($date){
            $this->creationDate = new \DateTime($date);
            return $this;
        }

        /**
         * Get the value of closed
         */ 
        public function getClosed()
        {
                return $this->closed;
        }

        /**
         * Set the value of closed
         *
         * @return  self
         */ 
        public function setClosed($closed)
        {
                $this->closed = $closed;

                return $this;
        }

        /**
         * Returns the count of likes
         */
        public function likesCount(){
                return (new TopicLikeManager())->countWhereTopic( $this->getId() );
        }

        /**
         * Fonction pour supprimer en base de données (cascade)
         */
        public function delete()
        {
                // Vérifie qu'on a bien le droit de supprimer le topic
                if( ! Session::isAdmin() ) return;
                // Instancie le manager de post
                $postManager = new PostManager();
                // Récupère la liste des post du topic à supprimer
                $posts = $postManager->findAllWhereTopic( $this->getId() );
                if( $posts ) {
                        // Supprime les posts un à un
                        foreach( $posts as $post ) {
                                $post->delete();
                        }
                }
                // Instancie le manager de like de topic
                $topicLikeManager = new TopicLikeManager();
                // Récupère la liste des likes de topic du topic à supprimer
                $topicLikes = $topicLikeManager->findAllWhereTopic( $this->getId(), false );
                if( $topicLikes ) {
                        // Supprime les likes de topic un à un
                        foreach( $topicLikes as $topicLike ) {
                                $topicLike->delete();
                        }
                }
                // Instancie le manager de topic
                $topicManager = new TopicManager();
                // Supprime le topic
                $topicManager->delete( $this->getId() );
        }

        /**
         * Fonction qui renvoie la liste des likes de ce topic
         */
        public function getTopicLikes()
        {
                $topicLikeManager = new TopicLikeManager();

                return $topicLikeManager->findAllWhereTopic( $this->getId(), false );
        }

        /**
         * Fonction qui renvoie les likers
         */
        public function getLikers() 
        {
                $retval = "";
                $topicLikes = $this->getTopicLikes();
                if( $topicLikes ) {
                        $count = 0;
                        foreach( $topicLikes as $topicLike )
                        {
                                $retval .= ($count?"\r\n":"").$topicLike->getUser()->getPseudo();
                                $count++;
                        }
                }
                return $retval;
        }

        /**
         * Returns the title
         */
        public function __toString() : string
        {
                return $this->title;
        }
    }
