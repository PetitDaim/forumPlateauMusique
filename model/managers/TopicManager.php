<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";


        public function __construct(){
            parent::connect();
        }

        /**
         * Méthode qui renvoie les sujets qui appartiennent à une catégorie
         * id correspont à l'id de la catégorie
         */
        public function findAllWhereCategory($id, $order = null)
        {
            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.category_id = :id
                    ".$orderQuery;

            return $this->getMultipleResults(
                DAO::select($sql, [':id' => $id]), 
                $this->className
            );
        }

        /**
         * Méthode qui renvoie les sujets qui contiennent la recherche
         */
        public function findAllWhereSearch( $recherche, $order = null)
        {
            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            $sql = "SELECT *
                    FROM ".$this->tableName." t
                    WHERE t.title LIKE '%$recherche%' 
                    ".$orderQuery;

            return $this->getMultipleResults(
                DAO::select($sql), 
                $this->className
            );
        }

        /**
         * Méthode qui renvoie le nombre de sujets qui appartiennent à une catégorie
         * id correspont à l'id de la catégorie
         */
        public function countAllWhereCategory($id){

            $sql = "SELECT COUNT(a.id_topic) AS c
                    FROM ".$this->tableName." a
                    WHERE a.category_id = :id";

            return $this->getSingleScalarResult(
                DAO::select($sql, [':id' => $id])
            );
        }

        public function update( $topic ) {
            return $this->updateWhereId(
                [
                    "title" => $topic->getTitle(),
                    "user_id" => $topic->getUSer()->getId(),
                    "category_id" => $topic->getCategory()->getId(),
                    "media_id" => $topic->getMedia()->getId(),
                    "closed" => $topic->getClosed()
                ],
                $topic->getId()
            );
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

    }