<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class PostLikeManager extends Manager{

        protected $className = "Model\Entities\PostLike";
        protected $tableName = "postlike";


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

        public function findAllWherePost( $postId, $order = null){

            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.post_id = :postId
                    ".$orderQuery;

            return $this->getMultipleResults(
                DAO::select($sql, [':postId' => $postId]), 
                $this->className
            );
        }

        public function countWherePost( $postId ){


            $sql = "SELECT COUNT(a.id_postlike) AS c
                    FROM ".$this->tableName." a
                    WHERE a.post_id = :postId
                    ";

            return intval( $this->getSingleScalarResult( DAO::select($sql, [':postId' => $postId] ) )['c'] );
        }

        /**
         * Méthode qui renvoie un like de post par utilisateur
         */
        public function findOneWhereUserAndPost( $userId, $postId ){

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.user_id = :userId
                    AND a.post_id = :postId
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, [':userId' => $userId, ':postId' => $postId ], false ), 
                $this->className
            );
        }

    }