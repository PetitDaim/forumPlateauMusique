<?php
    namespace Model\Managers;
    
    use Model\Entities\User;
    use App\Manager;
    use App\DAO;


    class UserManager extends Manager
    {

        protected $className = "Model\Entities\User";
        protected $tableName = "user";

        /**
         * Constructeur
         */
        public function __construct(){
            parent::connect();
        }

        /**
         * Méthode qui renvoie l'instance de User qui correspond au pseudo
         */
        public function findWherePseudo( $pseudo ) 
        {
            // Prépare la requete sql en se prémunissant de l'injection SQL
            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.pseudo = :pseudo";
            // renvoie l'objet user qui correspond au pseudo
            return $this->getOneOrNullResult(
                DAO::select($sql, ['pseudo' => $pseudo], false), 
                $this->className
            );
        }

        /**
         * Méthode qui renvoie l'instance de User qui correspond à l'email
         */
        public function findWhereEmail( $email ) 
        {
            // Prépare la requete sql en se prémunissant de l'injection SQL
            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.email = :email";
            // renvoie l'objet user qui correspond à l'email
            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false), 
                $this->className
            );
        }

        /**
         * Méthode qui renvoie l'instance de User qui correspond au pseudo et à l'email
         */
        public function findWherePseudoAndEmail( string $pseudo, string $email )
        {
            // Prépare la requete sql en se prémunissant de l'injection SQL
            $sql = "SELECT *
                    FROM ".$this->tableName." u
                    WHERE u.pseudo = :pseudo
                    AND u.email = :email";
            // renvoie l'objet user qui correspond au pseudo et à l'email
            return $this->getOneOrNullResult(
                DAO::select($sql, ['pseudo' => $pseudo, 'email' => $email], false), 
                $this->className
            );
        }
        
        /**
         * Méthode qui permet d'updater un utilisateur en BDD
         */
        public function update( User $user ) {
            return $this->updateWhereId(
                [
                    "pseudo" => $user->getPseudo(),
                    "password" => $user->getPassword(),
                    "email" => $user->getEmail(),
                    "avatar" => $user->getAvatar(),
                    "banned" => $user->getBanned(),
                    "role" => $user->getRole()
                ],
                $user->getId()
            );
        }

  }