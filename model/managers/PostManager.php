<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class PostManager extends Manager{

        protected $className = "Model\Entities\Post";
        protected $tableName = "post";


        /**
         * Constructeur
         */
        public function __construct(){
            parent::connect();
        }

        /**
         * Méthode qui renvoie tous les post d'un topic
         */
        public function findAllWhereTopic( $id, $order = null){

            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.topic_id = :id
                    ".$orderQuery;

            return $this->getMultipleResults(
                DAO::select($sql, [':id' => $id]), 
                $this->className
            );
        }

        /**
         * Méthode qui renvoie tous les post d'un utilisateur
         */
        public function findAllWhereUser( $id, $order = null){

            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.user_id = :id
                    ".$orderQuery;

            return $this->getMultipleResults(
                DAO::select($sql, [':id' => $id]), 
                $this->className
            );
        }

    }