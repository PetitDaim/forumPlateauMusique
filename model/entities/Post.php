<?php
    // Rangé sur l'étagère Model \ Entities
    namespace Model\Entities;

    // Utilise la classe Entity rangé sur le namespace App
    use App\Entity;
    use App\Session;
    use Model\Managers\PostLikeManager;
    use Model\Managers\PostManager;

    // final => la class Topic ne peut pas avoir d'enfants et elle hérite de laz classe Entity
    final class Post extends Entity{

        // liste des propriétés de la classe Topic selons le principe d'encapsulation mes propriétés sont privées, 
        // c'est à dire qu'elles ne seront accessible que depuis la classe
       // ou bien par des setters getters
       private $id;
        private $user;
        private $topic;
        private $message;
        private $creationDate;

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
         * Get the value of message
         */ 
        public function getMessage()
        {
                return $this->message;
        }

        /**
         * Set the value of message
         *
         * @return  self
         */ 
        public function setMessage($message)
        {
                $this->message = $message;

                return $this;
        }

        /**
         * Get the value of creationDate
         */ 
        public function getCreationDate()
        {
                return $this->creationDate;
        }

        /**
         * Set the value of creationDate
         *
         * @return  self
         */ 
        public function setCreationDate($creationDate)
        {
                $this->creationDate = $creationDate;

                return $this;
        }

        /**
         * Retuns true if the post is liked py the user
         */
        public function isLiked( User $user ) : bool
        {
                return (new PostLikeManager())->findOneWhereUserAndPost( $user ? $user->getId() : 0, $this->id ) ? true : false;
        }

        /**
         * Returns the count of likes
         */
        public function likesCount(){
                return (new postLikeManager())->countWherePost( $this->getId() );
        }

        /**
         * Fonction pour supprimer de la base de données (cascade)
         */
        public function delete()
        {
                // Vérifie qu'on a bien le droit de supprimer le post
                if( ! Session::isAdmin() ) return;
                // Instancie le manager de like de topic
                $postLikeManager = new PostLikeManager();
                // Récupère la liste des likes de post du post à supprimer
                $postLikes = $postLikeManager->findAllWherePost( $this->getId(), false );
                if( $postLikes ) {
                        // Supprime les likes de post un à un
                        foreach( $postLikes as $postLike ) {
                                $postLike->delete();
                        }
                }
                // Instancie le manager de post
                $postManager = new PostManager();
                // Supprime dans la base de données
                $postManager->delete( $this->getId() );
        }

        /**
         * Fonction qui renvoie la liste des likes de ce post
         */
        public function getPostLikes()
        {
                $postLikeManager = new PostLikeManager();

                return $postLikeManager->findAllWherePost( $this->getId(), false );
        }

        /**
         * Fonction qui renvoie les likers
         */
        public function getLikers() 
        {
                $retval = "";
                $postLikes = $this->getPostLikes();
                if( $postLikes ) {
                        $count = 0;
                        foreach( $postLikes as $postLike )
                        {
                                $retval .= ($count?"\r\n":"").$postLike->getUser()->getPseudo();
                                $count++;
                        }
                }
                return $retval;
        }

        /**
         * Retuns the message
         */
        public function __toString()
        {
            return $this->message;
        }
}