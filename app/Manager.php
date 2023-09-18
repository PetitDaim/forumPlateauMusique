<?php
    namespace App;

    abstract class Manager{

        protected function connect(){
            DAO::connect();
        }

        /**
         * get all the records of a table, sorted by optionnal field and order
         * 
         * @param array $order an array with field and order option
         * @return Collection a collection of objects hydrated by DAO, which are results of the request sent
         */
        public function findAll($order = null){

            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    ".$orderQuery;

            return $this->getMultipleResults(
                DAO::select($sql), 
                $this->className
            );
        }

        /**
         * get all the (limit first) records of a table, sorted by optionnal field and order
         * 
         * @param array $order an array with field and order option
         * @return Collection a collection of objects hydrated by DAO, which are results of the request sent
         */
        public function findAllLimit($order = null, int $limit = 10 ){

            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    ".$orderQuery." LIMIT ".$limit;

            return $this->getMultipleResults(
                DAO::select($sql), 
                $this->className
            );
        }
       
        public function findOneById($id){

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.id_".$this->tableName." = :id
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['id' => $id], false), 
                $this->className
            );
        }

        //$data = ['username' => 'Squalli', 'password' => 'dfsyfshfbzeifbqefbq', 'email' => 'sql@gmail.com'];

        public function add($data){
            //$keys = ['username' , 'password', 'email']
            $keys = array_keys($data);
            //"username,password,email"
            $sql = "INSERT INTO ".$this->tableName."
                    (".implode(',', $keys).") 
                    VALUES
                    (:".implode(", :",$keys).")";
                    //"'Squalli', 'dfsyfshfbzeifbqefbq', 'sql@gmail.com'"
            /*
                INSERT INTO user (username,password,email) VALUES ('Squalli', 'dfsyfshfbzeifbqefbq', 'sql@gmail.com') 
            */
            try{
                return DAO::insert($sql, $data);
            }
            catch(\PDOException $e){
                if( __DEBUG__ ) echo $e->getMessage();
                else throw( $e );
            }
        }

        public function updateWhereId($data, $id){
            //$keys = ['username' , 'password', 'email']
            $keys = array_keys($data);
            //"username,password,email"
            $sql = "UPDATE ".$this->tableName."
                    SET ";
            $count = 0;
            foreach( $keys as $key ) {
                $sql .= ($count?", ":"")."$key = :$key";
                $count++;
            }
            $sql .= " WHERE id_".$this->tableName." = :id";
            /*
                UPDATE user SET username='Squalli', password='dfsyfshfbzeifbqefbq', email='sql@gmail.com' WHERE user_id=12 
            */
            try{
                $data[":id"] = $id;
                return DAO::update($sql, $data);
            }
            catch(\PDOException $e){
                if( __DEBUG__ ) echo $e->getMessage();
                else throw( $e );
            }
            return false;
        }
        
        public function delete($id){
            $sql = "DELETE FROM ".$this->tableName."
                    WHERE id_".$this->tableName." = :id
                    ";

            return DAO::delete($sql, ['id' => $id]); 
        }

        private function generate($rows, $class){
            foreach($rows as $row){
                yield new $class($row);
            }
        }
        
        protected function getMultipleResults($rows, $class){

            if(is_iterable($rows)){
                return $this->generate($rows, $class);
            }
            else return null;
        }

        protected function getOneOrNullResult($row, $class) {

            if($row != null){
                return new $class($row);
            }
            return false;
        }

        protected function getSingleScalarResult($row){

            if($row != null){
                $value = array_values($row);
                return $value[0];
            }
            return false;
        }
    
    }