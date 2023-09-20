<?php
    namespace App;

    abstract class Entity
    {

        /**
         * Méthode qui permet d'hydrater la classe à partir de la BDD
         */
        protected function hydrate($data)
        {
            // vérifie qu'il y a bien des datas à hydrater
            if( $data ) {
                foreach($data as $field => $value){

                    //field = marque_id
                    //fieldarray = ['marque','id']
                    $fieldArray = explode("_", $field);
    
                    if(isset($fieldArray[1]) && $fieldArray[1] == "id"){
                        $manName = ucfirst($fieldArray[0])."Manager";
                        $FQCName = "Model\Managers".DS.$manName;
                        
                        $man = new $FQCName();
                        $value = $man->findOneById($value);
                    }
                    //fabrication du nom du setter à appeler (ex: setMarque)
                    $method = "set".ucfirst($fieldArray[0]);
                   
                    if(method_exists($this, $method)){
                        $this->$method($value);
                    }
    
                }
   
            }
        }

        /**
         * Méthode qui renvoie la Classe du $this
         */
        public function getClass()
        {
            return get_class($this);
        }

    }