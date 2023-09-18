<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class TopicLikeManager extends Manager{

        protected $className = "Model\Entities\TopicLike";
        protected $tableName = "topiclike";


        public function __construct(){
            parent::connect();
        }

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

        /**
         * Méthode qui renvoie le nombre de likes de topic
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
         * Méthode qui renvoie le nombre de likes de topic
         */
        public function countWhereTopic( $id ){


            $sql = "SELECT COUNT(a.id_topiclike) AS c
                    FROM ".$this->tableName." a
                    WHERE a.topic_id = :id
                    ";

            return intval( $this->getSingleScalarResult( DAO::select($sql, [':id' => $id], false ) ) );
        }

        /**
         * Méthode qui renvoie un like de topic par utilisateur
         */
        public function findOneWhereUserAndTopic( $userId, $topicId ){

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.user_id = :userId
                    AND a.topic_id = :topicId
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, [':userId' => $userId, ':topicId' => $topicId ], false ), 
                $this->className
            );
        }

    }