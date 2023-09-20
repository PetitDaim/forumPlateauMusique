<?php
    namespace App;
    if( ! defined ( "__DEBUG__" ) ) define ( "__DEBUG__", false );
    /**
     * Classe d'accès aux données de la BDD, abstraite
     * 
     * @property static $bdd l'instance de PDO que la classe stockera lorsque connect() sera appelé
     *
     * @method static connect() login à la BDD
     * @method static insert() requètes d'insertion dans la BDD
     * @method static select() requètes de sélection
     */
    abstract class DAO{

        private static string $host   = 'mysql:host=127.0.0.1;port=3306';
        private static string $dbname = 'forum_dv';
        private static string $dbuser = 'root';
        private static string $dbpass = '';

        private static \PDO $bdd;

        /**
         * cette méthode permet de créer l'unique instance de PDO de l'application
         */
        public static function connect() : void
        {
            self::$bdd = new \PDO(
                self::$host.';dbname='.self::$dbname,
                self::$dbuser,
                self::$dbpass,
                array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                )   
            );
        }

        /**
         * cette méthode permet de faire une insertion en BDD
         */
        public static function insert( string $sql, array $params){
            try{
                $stmt = self::$bdd->prepare($sql);
                $stmt->execute($params);
                //on renvoie l'id de l'enregistrement qui vient d'être ajouté en base, 
                //pour s'en servir aussitôt dans le controleur
                return self::$bdd->lastInsertId();
                
            }
            catch(\Exception $e){
                if( __DEBUG__ ) echo $e->getMessage();
                else throw( $e );
            }
        }

        /**
         * cette méthode permet de faire un update en BDD
         */
        public static function update( string $sql, array $params){
            try{
                $stmt = self::$bdd->prepare($sql);
                
                //on renvoie l'état du statement après exécution (true ou false)
                return $stmt->execute($params);
                
            }
            catch(\Exception $e){
                
                if( __DEBUG__ ) echo $e->getMessage();
                else throw( $e );
            }
        }
        
        /**
         * cette méthode permet de faire un delete dans la BDD
         */
        public static function delete( string $sql, array $params )
        {
            try{
                $stmt = self::$bdd->prepare($sql);
                
                //on renvoie l'état du statement après exécution (true ou false)
                return $stmt->execute($params);
                
            }
            catch(\Exception $e){
                if( __DEBUG__ ) echo $e->getMessage();
                else throw( $e );
            }
        }

        /**
         * Cette méthode permet les requêtes de type SELECT
         * 
         * @param string $sql la chaine de caractère contenant la requête elle-même
         * @param mixed $params=null les paramètres de la requête
         * @param bool $multiple=true vrai si le résultat est composé de plusieurs enregistrements (défaut), false si un seul résultat doit être récupéré
         * 
         * @return array|null les enregistrements en FETCH_ASSOC ou null si aucun résultat
         */
        public static function select($sql, $params = null, bool $multiple = true):?array
        {
            try{
                $stmt = self::$bdd->prepare($sql);
                $stmt->execute($params);
              
                $results = ($multiple) ? $stmt->fetchAll() : $stmt->fetch();

                $stmt->closeCursor();
                return ($results == false) ? null : $results;
            }
            catch(\Exception $e){
                if( __DEBUG__ ) echo $e->getMessage();
                else throw( $e );
            }
        }
    }