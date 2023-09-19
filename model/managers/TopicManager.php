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
            // Set order by query in $order givven
            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            // Crée la requete sql avec la recherche par category_id, (et avec l'order by) (en se premunissant de l'injection sql)
            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.category_id = :id
                    ".$orderQuery;

            // Renvoie la liste des topics de la catégorie ($id)
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
            // Set order by query in $order givven
            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            // Crée la requete sql avec la recherche par category_id, (et avec l'order by) (sans se prémunir de l'injection sql)
            // Il semblerait qu'il est impossible de se prémunir de l'injection sql dans un like %xxx%
            $sql = "SELECT *
                    FROM ".$this->tableName." t
                    WHERE t.title LIKE '%$recherche%' 
                    ".$orderQuery;

            // Renvoie la liste des topics contenant $recherche dans le titre
            return $this->getMultipleResults(
                DAO::select($sql), 
                $this->className
            );
        }

        /**
         * Méthode qui renvoie le nombre de sujets qui appartiennent à une catégorie
         * id correspont à l'id de la catégorie
         */
        public function countAllWhereCategory($id) : int
        {
            // Crée la requete sql avec la recherche par category_id, (en se premunissant de l'injection sql)
            $sql = "SELECT COUNT(a.id_topic) AS c
                    FROM ".$this->tableName." a
                    WHERE a.category_id = :id";

            // Renvoie la liste des topics contenant $recherche dans le titre
            return intval( $this->getSingleScalarResult( DAO::select($sql, [':id' => $id], false ) ) );
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