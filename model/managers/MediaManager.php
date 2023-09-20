<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class MediaManager extends Manager
    {

        protected $className = "Model\Entities\Media";
        protected $tableName = "media";


        /**
         * Constructeur
         */
        public function __construct()
        {
            parent::connect();
        }


    }
