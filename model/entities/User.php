<?php
    // Rangé sur l'étagère Model \ Entities
    namespace Model\Entities;

    // Utilise la classe Entity rangé sur le namespace App
    use App\Entity;

    // final => la class Topic ne peut pas avoir d'enfants et elle hérite de laz classe Entity
    final class User extends Entity{

        // liste des propriétés de la classe Topic selons le principe d'encapsulation mes propriétés sont privées, 
        // c'est à dire qu'elles ne seront accessible que depuis la classe
        // ou bien par des setters getters
        private $id;
        private $pseudo;
        private $password;
        private $email;
        private $avatar;
        private $registrationDate;
        private $banned;
        private $role;

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
         * Get the value of pseudo
         */ 
        public function getPseudo()
        {
                return $this->pseudo;
        }

        /**
         * Set the value of pseudo
         *
         * @return  self
         */ 
        public function setPseudo($pseudo)
        {
                $this->pseudo = $pseudo;

                return $this;
        }

        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }
        
        /**
         * Get the value of avatar
         */ 
        public function getAvatar()
        {
                return $this->avatar;
        }

        /**
         * Set the value of avatar
         *
         * @return  self
         */ 
        public function setAvatar($avatar)
        {
                $this->avatar = $avatar;

                return $this;
        }

        /**
         * Get the value of registrationDate
         */ 
        public function getRegistrationDate()
        {
                return $this->registrationDate;
        }

        /**
         * Set the value of registrationDate
         *
         * @return  self
         */ 
        public function setRegistrationDate($registrationDate)
        {
                $this->registrationDate = $registrationDate;

                return $this;
        }

        /**
         * Get the value of banned
         */ 
        public function getBanned()
        {
                return $this->banned;
        }

        /**
         * Set the value of banned
         *
         * @return  self
         */ 
        public function setBanned($banned)
        {
                $this->banned = $banned;

                return $this;
        }

        /**
         * Get the value of role
         */ 
        public function getRole( $encode=true )
        {
                return $encode?json_encode($this->role):$this->role;
        }

        /**
         * Set the value of role
         *
         * @return  self
         */ 
        public function setRole( $role, bool $decode=true ) : User
        {
                $this->role = $decode?json_decode( $role ):$role;

                return $this;
        }

        public function hasRole( $role )
        {
                return (in_array( $role, $this->role )?true:false);
        }

        /**
         * Retuns the pseudo
         */
        public function __toString()
        {
            return $this->pseudo;
        }
    }