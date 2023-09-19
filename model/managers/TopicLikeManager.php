<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class TopicLikeManager extends Manager{

        protected $className = "Model\Entities\TopicLike";
        protected $tableName = "topiclike";


        public function __construct()
        {
            parent::connect();
        }

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

            // Renvoie la liste des topivLikes ayant pour liker : user_id = $id
            return $this->getMultipleResults(
                DAO::select($sql, [':id' => $id]), 
                $this->className
            );
        }

        /**
         * Méthode qui renvoie le nombre de likes de topic
         */
        public function findAllWhereTopic( $id, $order = null){
            // Set order by query in $order givven
            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            // Crée la requete sql avec la recherche par topic_id, (et avec l'order by) (en se premunissant de l'injection sql)
            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.topic_id = :id
                    ".$orderQuery;

             // Renvoie la liste des topicLikes du topic $id
             return $this->getMultipleResults(
                DAO::select($sql, [':id' => $id]), 
                $this->className
            );
        }

        /**
         * Méthode qui renvoie le nombre de likes de topic
         */
        public function countWhereTopic( $id ) : int
        {
            // Crée la requete sql avec la recherche par topic_id (en se premunissant de l'injection sql)
            $sql = "SELECT COUNT(a.id_topiclike) AS c
                    FROM ".$this->tableName." a
                    WHERE a.topic_id = :id
                    ";

            // renvoie le nombre de like du topic
            return intval( $this->getSingleScalarResult( DAO::select($sql, [':id' => $id], false ) ) );
        }

        /**
         * Méthode qui renvoie un like de topic (s'il existe) par utilisateur et topic
         */
        public function findOneWhereUserAndTopic( $userId, $topicId ){
            // Crée la requete sql avec la recherche par topic_id  et user_id (en se premunissant de l'injection sql)
            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.user_id = :userId
                    AND a.topic_id = :topicId
                    ";

            // renvoie le like (s'il existe) de l'utilisateur et du topic
            return $this->getOneOrNullResult(
                DAO::select($sql, [':userId' => $userId, ':topicId' => $topicId ], false ), 
                $this->className
            );
        }

    }