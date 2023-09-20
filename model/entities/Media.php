<?php
    // Rangé sur l'étagère Model \ Entities
    namespace Model\Entities;

    // Utilise la classe Entity rangé sur le namespace App
    use App\Entity;

    // final => la class Topic ne peut pas avoir d'enfants et elle hérite de laz classe Entity
    final class Media extends Entity
    {

        // liste des propriétés de la classe Topic selons le principe d'encapsulation mes propriétés sont privées, 
        // c'est à dire qu'elles ne seront accessible que depuis la classe
        // ou bien par des setters getters
        private $id;
        private $tinyMediaName;
        private $tinyMediaUrl;
        private $tinyMediaType;
        private $mediumMediaName;
        private $mediumMediaUrl;
        private $mediumMediaType;
        private $bigMediaName;
        private $bigMediaUrl;
        private $bigMediaType;
        private $mediaDescription;
        private $mediaSuppressed;

        /**
         * Constructeur
         */
        public function __construct($data)
        {
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of tinyMediaName
         */ 
        public function getTinyMediaName()
        {
                return $this->tinyMediaName;
        }

        /**
         * Set the value of tinyMediaName
         *
         * @return  self
         */ 
        public function setTinyMediaName($tinyMediaName)
        {
                $this->tinyMediaName = $tinyMediaName;

                return $this;
        }

        /**
         * Get the value of tinyMediaUrl
         */ 
        public function getTinyMediaUrl()
        {
                return $this->tinyMediaUrl;
        }

        /**
         * Set the value of tinyMediaUrl
         *
         * @return  self
         */ 
        public function setTinyMediaUrl($tinyMediaUrl)
        {
                $this->tinyMediaUrl = $tinyMediaUrl;

                return $this;
        }

        /**
         * Load the file givven by $mediaFile = $_FILE["fileName"]
         * And return an array containing:
         * "name" => "C:/images/exemple.jpg" (the name entered by the user)
         * "url" => "./img/fhtke1250srt015.jpg" (the url on the server)
         * "type" => "images/jpeg" (the type of the file)
         */
        public static function loadMediaFile( $mediaFile )
        {
                // définit un id unique
                $uid = uniqid();
                // définit les paramètres de retours par défaut
                $retval['name'] = $mediaFile["name"];
                $retval['url'] = "./img/undefinedImageUrl.jpg";
                $retval['type'] = $mediaFile["type"];
                // En fonction du type de fichier, définit l'url du fichier uploadé
                switch( $retval['type'] ) {
                    case "image/jpeg":
                        $retval['url'] = "./img/".$uid.".jpeg";
                        break;
                    case "image/jpg":
                        $retval['url'] = "./img/".$uid.".jpg";
                        break;
                    case "image/png":
                        $retval['url'] = "./img/".$uid.".png";
                        break;
                    case "image/gif":
                        $retval['url'] = "./img/".$uid.".gif";
                        break;
                    case "image/bmp":
                        $retval['url'] = "./img/".$uid.".bmp";
                        break;
                    case "audio/mp3":
                        $retval['url'] = "./audio/".$uid.".mp3";
                        break;
                    case "audio/ogg":
                        $retval['url'] = "./audio/".$uid.".ogg";
                        break;
                    case "audio/mpeg":
                        $retval['url'] = "./audio/".$uid.".mpeg";
                        break;
                    case "video/webm":
                        $retval['url'] = "./video/".$uid.".webm";
                        break;
                    case "video/mp4":
                        $retval['url'] = "./video/".$uid.".mp4";
                        break;
                    case "app/pdf":
                        $retval['url'] = "./pdf/".$uid.".pdf";
                        break;
                    default:
                        break;
                }
                // si un fichier a bien été défini, le copie à l'adresse de url
                if( $retval['url'] != "./img/undefinedImageUrl.jpg" ) copy( $mediaFile["tmp_name"], $retval['url'] );
                // Renvoie le tableau de résultat
                return $retval;
        }

        /**
         * Méthode pour vérifier la taille du média
         */
        private function verifyMediaSize( $mediaSize ) 
        {
                switch( $mediaSize ) {
                        case 'tiny':
                        case 'medium':
                        case 'big':
                                break;
                        default:
                                $mediaSize = 'tiny';
                                break;
                }
                return $mediaSize;
        }

        /**
         * Méthode pour afficher l'image du média
         */
        private function showPicture( $mediaSize = 'tiny' ) {
                $mediaSize = $this->verifyMediaSize( $mediaSize );
?>
                <figure class="<?= 'figure-'.$mediaSize ?>">
                        <img src="<?= $this->{$mediaSize.'MediaUrl'} ?>" alt="<?= $this->mediaDescription ?>" class="<?= 'img-'.$mediaSize ?>">
                        <figcaption><?= $this->mediaDescription ?></figcaption>
                </figure>
<?php
        }

        /**
         * Méthode pour jouer le son du média
         */
        private function playSound( $mediaSize = 'tiny' ) {
                $mediaSize = $this->verifyMediaSize( $mediaSize );
?>
               <audio controls>
                        <source src="<?= $this->{$mediaSize.'MediaUrl'} ?>" type="<?= $this->{$mediaSize.'MediaType'} ?>">
                        Your browser does not support the audio element.
                </audio>
<?php
        }

        /**
         * Méthode pour afficher la vidéo du média
         */
        private function playVideo( $mediaSize = 'tiny' ) {
                $mediaSize = $this->verifyMediaSize( $mediaSize );
?>
               <video controls class="<?= 'video-'.$mediaSize ?>">
                        <source src="<?= $this->{$mediaSize.'MediaUrl'} ?>" type="<?= $this->{$mediaSize.'MediaType'} ?>">
                        Your browser does not support the audio element.
                </video>
<?php
        }

        /**
         * Méthode pour afficher le PDF du média
         */
        private function showPdf( $mediaSize = 'tiny' ) {
                $mediaSize = $this->verifyMediaSize( $mediaSize );
?>
                <embed src="<?= $this->{$mediaSize.'MediaUrl'} ?>" class="<?= 'pdf-'.$mediaSize ?>" type="application/pdf">
<?php
        }

        /**
         * Méthode pour afficher le media
         */
        public function showMedia( $mediaSize = 'tiny' )
        {
                // Vérifie que la taille du média est référencée
                $mediaSize = $this->verifyMediaSize( $mediaSize );
                // En fonction du type de média de la taille choisie
                switch( $this->{$mediaSize.'MediaType'} ) {
                        case "image/jpg":
                        case "image/jpeg":
                        case "image/png":
                        case "image/gif":
                        case "image/bmp":
                                // Affiche l'image
                                $this->showPicture( $mediaSize );
                                break;
                        case "audio/mp3":
                        case "audio/ogg":
                        case "audio/mpeg":
                                // joue le son
                                $this->playSound( $mediaSize );
                                break;
                        case "video/webm":
                        case "video/mp4":
                                // Affiche la vidéo
                                $this->playVideo( $mediaSize );
                                break;
                        case "app/pdf":
                                // Affiche le pdf
                                $this->showPdf( $mediaSize );
                                break;
                        default:
                                break;
                }
        }

        /**
         * Get the value of tinyMediaType
         */ 
        public function getTinyMediaType()
        {
                return $this->tinyMediaType;
        }

        /**
         * Set the value of tinyMediaType
         *
         * @return  self
         */ 
        public function setTinyMediaType($tinyMediaType)
        {
                $this->tinyMediaType = $tinyMediaType;

                return $this;
        }

        /**
         * Get the value of mediumMediaName
         */ 
        public function getMediumMediaName()
        {
                return $this->mediumMediaName;
        }

        /**
         * Set the value of mediumMediaName
         *
         * @return  self
         */ 
        public function setMediumMediaName($mediumMediaName)
        {
                $this->mediumMediaName = $mediumMediaName;

                return $this;
        }

        /**
         * Get the value of mediumMediaUrl
         */ 
        public function getMediumMediaUrl()
        {
                return $this->mediumMediaUrl;
        }

        /**
         * Set the value of mediumMediaUrl
         *
         * @return  self
         */ 
        public function setMediumMediaUrl($mediumMediaUrl)
        {
                $this->mediumMediaUrl = $mediumMediaUrl;

                return $this;
        }

        /**
         * Get the value of mediumMediaType
         */ 
        public function getMediumMediaType()
        {
                return $this->mediumMediaType;
        }

        /**
         * Set the value of mediumMediaType
         *
         * @return  self
         */ 
        public function setMediumMediaType($mediumMediaType)
        {
                $this->mediumMediaType = $mediumMediaType;

                return $this;
        }

        /**
         * Get the value of bigMediaName
         */ 
        public function getBigMediaName()
        {
                return $this->bigMediaName;
        }

        /**
         * Set the value of bigMediaName
         *
         * @return  self
         */ 
        public function setBigMediaName($bigMediaName)
        {
                $this->bigMediaName = $bigMediaName;

                return $this;
        }

        /**
         * Get the value of bigMediaUrl
         */ 
        public function getBigMediaUrl()
        {
                return $this->bigMediaUrl;
        }

        /**
         * Set the value of bigMediaUrl
         *
         * @return  self
         */ 
        public function setBigMediaUrl($bigMediaUrl)
        {
                $this->bigMediaUrl = $bigMediaUrl;

                return $this;
        }

        /**
         * Get the value of bigMediaType
         */ 
        public function getBigMediaType()
        {
                return $this->bigMediaType;
        }

        /**
         * Set the value of bigMediaType
         *
         * @return  self
         */ 
        public function setBigMediaType($bigMediaType)
        {
                $this->bigMediaType = $bigMediaType;

                return $this;
        }

        /**
         * Get the value of mediaDescription
         */ 
        public function getMdiaDescription()
        {
                return $this->mediaDescription;
        }

        /**
         * Set the value of mediaDescription
         *
         * @return  self
         */ 
        public function setMediaDescription($mediaDescription)
        {
                $this->mediaDescription = $mediaDescription;

                return $this;
        }

        /**
         * Get the value of mediaSuppressed
         */ 
        public function getMediaSuppressed()
        {
                return $this->mediaSuppressed;
        }

        /**
         * Set the value of mediaSuppressed
         *
         * @return  self
         */ 
        public function setMediaSuppressed($mediaSuppressed)
        {
                $this->mediaSuppressed = $mediaSuppressed;

                return $this;
        }

        /**
         * Returns the category name
         */
        public function __toString() : string
        {
                return $this->mediaDescription;
        }
    }
