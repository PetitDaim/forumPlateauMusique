<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class MessageManager extends Manager
    {

        protected $className = "Model\Entities\Message";
        protected $tableName = "message";


        /**
         * Constructeur
         */
        public function __construct()
        {
            parent::connect();
        }


    }