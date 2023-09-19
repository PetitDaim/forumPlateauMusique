<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class PostLikeManager extends Manager{

        protected $className = "Model\Entities\PostLike";
        protected $tableName = "postlike";


        public function __construct()
        {
            parent::connect();
        }

        /**
         * Méthode renvoyant la lste des postLike ayant user_id = $is pour liker
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

            // Renvoie la liste des postLikel ayant pour liker : user_id = $id
            return $this->getMultipleResults(
                DAO::select($sql, [':id' => $id]), 
                $this->className
            );
        }

        /**
         * Méthode renvoyant la liste des likes du post $postId
         */
        public function findAllWherePost( $postId, $order = null)
        {
            // Set order by query in $order givven
            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            // Crée la requete sql avec la recherche par post_id, (et avec l'order by) (en se premunissant de l'injection sql)
            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.post_id = :postId
                    ".$orderQuery;

            // Renvoie la liste des postLikes du post $postId
            return $this->getMultipleResults(
                DAO::select($sql, [':postId' => $postId]), 
                $this->className
            );
        }

        /**
         * Méthode renvoyant le nombre de likes d'un post
         */
        public function countWherePost( $postId ) : int
        {
            // Crée la requete sql avec la recherche par post_id (en se premunissant de l'injection sql)
            $sql = "SELECT COUNT(a.id_postlike) AS c
                    FROM ".$this->tableName." a
                    WHERE a.post_id = :postId
                    ";

            // Renvoie le nombre de postLikes du post $postId
            return intval( $this->getSingleScalarResult( DAO::select($sql, [':postId' => $postId], false ) ) );
        }

        /**
         * Méthode qui renvoie un like de post par utilisateur
         */
        public function findOneWhereUserAndPost( $userId, $postId ){
            // Crée la requete sql avec la recherche par user_id et post_id (en se premunissant de l'injection sql)
            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.user_id = :userId
                    AND a.post_id = :postId
                    ";

            // renvoie le like (s'il existe) de l'utilisateur et du post
            return $this->getOneOrNullResult(
                DAO::select($sql, [':userId' => $userId, ':postId' => $postId ], false ), 
                $this->className
            );
        }

    }