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
        public function __construct()
        {
            parent::connect();
        }

        /**
         * Méthode qui renvoie tous les post d'un topic
         */
        public function findAllWhereTopic( $id, $order = null)
        {
            // Set order by query in $order givven
            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            // Crée la requete sql avec la recherche par topic_id, (et avec l'order by) (en se premunissant de l'injection sql)
            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.topic_id = :id
                    ".$orderQuery;

            // Renvoie la liste des posts du topic ($id)
            return $this->getMultipleResults(
                DAO::select($sql, [':id' => $id]), 
                $this->className
            );
        }

        /**
         * Méthode qui renvoie tous les post d'un utilisateur
         */
        public function findAllWhereUser( $id, $order = null)
        {
            // Set order by query in $order givven
            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            // Crée la requete sql avec la recherche par user_id, (et avec l'order by) (en se premunissant de l'injection sql)
            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.user_id = :id
                    ".$orderQuery;

            // Renvoie la liste des posts de l'utilisateur ($id)
            return $this->getMultipleResults(
                DAO::select($sql, [':id' => $id]), 
                $this->className
            );
        }

    }