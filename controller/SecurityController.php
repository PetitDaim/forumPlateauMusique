<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Entities\User;
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\PostManager;
    use Model\Managers\PostLikeManager;
    use Model\Managers\TopicLikeManager;
    use Model\Managers\MessageManager;
    use Throwable;

    class SecurityController extends AbstractController implements ControllerInterface{

        public function index(){
    
            $categoryManager = new CategoryManager();
            // Définition de la description de la page.
            $description = "Ce forum de musique présente diverses catégorie de publications de sujets permettant à des artistes qui souhapitent émerger, de faire connaître leurs créations musicales";
            // Définition du titre de la page.
            $title = "Accueil du forum de musique";
            return [
                "view" => VIEW_DIR."home/index.php",
                "data" => [
                    "categories" => $categoryManager->findAll(["categoryName", "ASC"]),
                    'title' => $title,
                    'description' => $description
                ]
            ];
 
        }

        public function registerForm(){
    
            return [
                "view" => VIEW_DIR."security/registerForm.php",
                "data" => [
                    'title' => "Formulaire d'enregistrement sur le forum de musique'",
                    'description' => "Le Formulaire d'enregistrement sur le forum contient un pseudo, un email et un mot de passe sécurisé (⩾ 12 caractères AlphaNumériques avec caractères spéciaux) à renseigner..."
                ]
            ];
 
        }
            
        /**
         * Méthode qui permet d'enregistrer un utilisateur
         */
        public function register()
        {
            $pseudo = filter_input( INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $password = filter_input( INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $passwordConfirm = filter_input( INPUT_POST, "passwordConfirm", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $email = filter_input( INPUT_POST, "email", FILTER_SANITIZE_EMAIL );
            
            $hasErrors = false;
            if( strlen( $pseudo ) < 3 ) {
                Session::addErrors('pseudo', "Le pseudo doit contenir au moin 3 caractères");
                $hasErrors = true;
            }

            if( strlen( $password ) < 12 ) {
                Session::addErrors('password', "Le mot de passe doit contenir au moins 12 caractères");
                $hasErrors = true;
            }
            else if( ! preg_match( "/^(?:(?=.*\d)(?=.*[A-Z])(?=.*[a-z])|(?=.*\d)(?=.*[^A-Za-z0-9])(?=.*[a-z])|(?=.*[^A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z])|(?=.*\d)(?=.*[A-Z])(?=.*[^A-Za-z0-9]))(?!.*(.)\1{2,})[A-Za-z0-9!~<>,;:_=?*+#.\"&§%°()\|\[\]\-\$\^\@\/]{12,128}$/", $password ) ) {
                Session::addErrors('password', "Le mot de passe doit contenir au moins deux minuscules, deux Majuscules, deux chiffres, deux caractères spéciaux et aucuns caractèrs en double" );
                $hasErrors = true;
            }
            else if( $passwordConfirm != $password ) {
                Session::addErrors('password', "Les deux mots de passes sont différents");
                $hasErrors = true;
            }
            if( strlen( $email ) < 8 ) {
                Session::addErrors('email', "L'EMail' doit contenir au moins 8 caractères");
                $hasErrors = true;
            }

            if( $hasErrors ) {
                Session::addFlash('error', "Erreur de formulaire: Merci de vérifier les messages qui suivent");

                $user = new User(false);
                $user->setPseudo($pseudo);
                $user->setEmail($email);
            }
            else {
                $userManager = new UserManager();
                try{
                    if( $userManager->findWherePseudo( $pseudo ) ) {
                        $hasErrors = true;
                        Session::addErrors('pseudo', "Ce pseudo est déjà utilisé");
                    }
                    if ( $userManager->findWhereEmail( $email ) ) {
                        $hasErrors = true;
                        Session::addErrors('email', "Cet email est déjà utilisé");
                    }
                    if( ! $hasErrors ) {
            
                        $userId = $userManager->add(
                            [
                                "pseudo" => $pseudo, 
                                "password" => password_hash( $password, PASSWORD_DEFAULT ), 
                                "email" => $email,
                                "role" => json_encode( [ "ROLE_USER" ] )
                            ]
                        );
            
                        $user = $userManager->findOneById( $userId );
                            
                    }
                        
                }
                catch( Throwable $_err ) {
                    $hasErrors = true;
                    echo $_err->getMessage();
                    Session::addErrors('email', "Ce pseudo ou cet email sont déjà utilisés");
                }
    
                if( $hasErrors ) {
                    Session::addFlash('error', "Erreur de formulaire: Merci de vérifier les messages qui suivent");
                    $user = new User(false);
                    $user->setPseudo($pseudo);
                    $user->setPassword($password);
                    $user->setEmail($email);
                }
                else {
                    Session::addFlash('success', "Votre utilisateur a bien été inscrit");
                    return $this->loginForm();
                }
            }
            return [
                "view" => VIEW_DIR."security/registerForm.php",
                "data" => [
                    "user" => $user,
                    "password" => $password,
                    "passwordConfirm" => $passwordConfirm,
                    'title' => "Formulaire d'enregistrement sur le forum de musique'",
                    'description' => "Le Formulaire d'enregistrement sur le forum contient un pseudo, un email et un mot de passe sécurisé (⩾ 12 caractères AlphaNumériques avec caractères spéciaux) à renseigner..."
                ]
            ];

        }

        /**
         * Méthode de presentation du formulaire de connection
         */
        public function loginForm(){
    
            return [
                "view" => VIEW_DIR."security/loginForm.php",
                "data" => [
                    'title' => "Formulaire de connection",
                    'description' => "Le Formulaire de connection contient un pseudo, un email et un mot de passe sécurisé (⩾ 12 caractères AlphaNumériques avec caractères spéciaux) à renseigner..."
                ]
            ];
 
        }

        /**
         * Méthode de connection
         */
        public function login()
        {
            // Récupère le Pseudo, le Password et l'Email
            $pseudo = filter_input( INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $password = filter_input( INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $email = filter_input( INPUT_POST, "email", FILTER_SANITIZE_EMAIL );
            // Initialise la variable d'erreurs à false (sera settée à true en cas d'erreur)
            $hasErrors = false;
            // Instancie le manager de l'utilisateur
            $userManager = new UserManager();
            // Vérifie si il y a un user avec ce pseudo et cet email
            if( $user = $userManager->findWherePseudoAndEmail( $pseudo, $email ) ) {
                if( password_verify( $password, $user->getPassword() ) ) {
                    Session::setUser( $user );
                    if( $user->getBanned() ) {
                        Session::addFlash( 'error', "Vous avez été banni, Veuilez contacter un administrateur." );
                    }
                    else{
                        Session::addFlash( 'success', "Vous êtes bien connecté." );
                    }
                    Session::restoreUrl();
                    return;
                }
                else{
                    $hasErrors = true;
                    Session::addErrors('password', "Le mot de passe ne correspond pas !");
                }
            }
            else{
                // Sinon : Le pseudo et le mail ne correspondent pas, on part en erreur
                $hasErrors = true;
                Session::addErrors('pseudo', "Le pseudo ou le mail ne correspondent pas !");
            }
            // Si il n'a toujours pas été possible de se connecter
            if( $hasErrors ){
                // Crée un user sans hydratation pour l'affichage des données entrées
                $user = new User( false );
                $user->setPseudo( $pseudo );
                $user->setEmail( $email );
                Session::addFlash( 'error', "l'autentification a échoué" );
                // Renvoie la vue du formulaire de login
                // ainsi que le paramètre user
                return [
                    "view" => VIEW_DIR."security/loginForm.php",
                    "data" => [
                        "user" => $user,
                        'title' => "Formulaire de connection",
                        'description' => "Le Formulaire de connection contient un pseudo, un email et un mot de passe sécurisé (⩾ 12 caractères AlphaNumériques avec caractères spéciaux) à renseigner..."
                    ]
                ];
            }
        }

        /**
         * 
         */
        public function logout( $id )
        {
            Session::setUser( null );
            unset( $_SESSION );
            // $this->redirectTo( 'home', 'index' );
            header( 'location: ./' );
        }

        /**
         * Méthode qui prépare et renvoie vers la liste des utilisateurs
         */
        public function usersList( $id=null )
        {
            if( Session::isAdmin() ) {
                // Intancie le manager des utilisateurs
                $manager = new UserManager();
                // Définit le titre de la page
                $title = "Liste des utilisateurs du forum de musique";
                // definit la description de la page
                $description = "Présentation d'artistes qui souhapitent émerger et faire connaître leurs créations musicales, plus d'utilisateurs du forum souhaitant encourager ces artistes";
                // définit le fait que la page ne doit pas être indexée par les moteurs de recherche
                $noIndex = true;
                // Récupère la liste de tous les utilisateurs triées par ordre alphabétique du pseudo
                $users = $manager->findAll( ["pseudo", "ASC"] );
                return [
                        "view" => VIEW_DIR."security/usersList.php",
                        "data"=> ["users" => $users]
                ];
            }
            else return $this->index();
        }

        /**
         * Méthode pour préparer le détail d'un utilisateur
         */
        public function userDetail( $id ){
            // Instancie le manager de l'utilisateur
            $userManager = new UserManager();
            // Récupère l'utilisateur dont on vient de récupérer l'id
            $user = $userManager->findOneById( $id );
            // Instancie le manager de like de post
            $postLikeManager = new PostLikeManager();
            // Récupère la liste des likes de post de cet utilisateur
            $postLikes = $postLikeManager->findAllWhereUser( $id, ["likeDate", "ASC"] );
            // Instancie le manager de like de sujet
            $topicLikeManager = new TopicLikeManager();
            // Récupère la liste des likes de topic de cet utilisateur
            $topicLikes = $topicLikeManager->findAllWhereUser( $id, ["likeDate", "ASC"] );
            // Instancie le manager de post
            $postManager = new PostManager();
            // Récupère la liste des posts de cet utilisateur
            $posts = $postManager->findAllWhereUser( $id, ["creationDate", "ASC"] );
            // Instancie le manager de sujet
            $topicManager = new TopicManager();
            // Récupère la liste des topics de cet utilisateur
            $topics = $topicManager->findAllWhereUser( $id, ["creationDate", "ASC"] );
            // Renvoie la vue userDetail
            // Ainsi que les paramètres: user et likes
            return [
                    "view" => VIEW_DIR."security/userDetail.php",
                    "data"=> [
                        "user" => $user,
                        "posts" => $posts,
                        "topics" => $topics,
                        "postLikes" => $postLikes,
                        "topicLikes" => $topicLikes
                    ]
            ];
        }

        public function userBann( $id ){
            $isSuccess = false;

            $userManager = new UserManager();
            // Récupère l'utilisateur
            $user = $userManager->findOneById( $id );

            // Initialisation d'une variable pour le messaged'erreur
            $de = "";
            // Vérifie que l'utilisateur connecté est bien l'administrateur du forum
            if( Session::isAdmin() ) {
                if( $user->getBanned() ) {
                    $user->setBanned( 0 );
                    // Modification d'une variable pour le messaged'erreur
                    $de = "dé";
                }
                else $user->setBanned( 1 );
                try{
                    $userManager->update( $user );
                    $isSuccess = true;
                }
                catch( Throwable $err )
                {
                    echo $err->getMessage();
                }
            }
            if( $isSuccess ) {
                return $this->userDetail( $user->getId() );
            }
            else {
                Session::addFlash( 'error', "Impossible de ".$de."bannir le posteur du message !!!" );
                return $this->index();
            }
        }

        /**
         * Méthode qu
         */
        public function userUnbann( $id ){
            $isSuccess = false;

            $userManager = new UserManager();

            $user = $userManager->findOneById( $id );

            if( Session::isAdmin() ) {
                $user->setBanned( 0 );
                try{
                    $userManager->update( $user );
                    $isSuccess = true;
                }
                catch( Throwable $err )
                {
                    echo $err->getMessage();
                }
            }
            if( $isSuccess ) {
                return $this->userDetail( $user->getId() );
            }
            else {
                Session::addFlash( 'error', "Impossible de débannir le posteur du message !!!" );
                return $this->index();
            }
        }

        /**
         * Méthode pour préparer l'envoi d'un message à l'administrateur
         */
        public function mailToAdmin() 
        {
            $mailSend = false;
            if( ! Session::getUser() ) {
                Session::addFlash( 'error', "Il faut être connecté pour envoyer un message à l'administrateur du forum !" );
                return $this->loginForm();
            }
            $object = filter_input( INPUT_POST, "object", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $objectLength = strlen( $object );
            if( $objectLength < 5 ) {
                Session::addErrors('object', "L'objet du message doit comporter au moins 5 caractères");
            }
            else if( $objectLength > 30 ) {
                Session::addErrors('object', "L'objet du message doit comporter au maximum 30 caractères");
            }
            $message = filter_input( INPUT_POST, "message", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $messageLength = strlen( $message );
            if( $messageLength < 10 ) {
                Session::addErrors('message', "Le message doit comporter au moins 10 caractères (vous pouvez commencer par Bonjour,...)");
            }
            else if( $messageLength > 255 ) {
                Session::addErrors('message', "Le message doit comporter au maximum 255 caractères");
            }
            else {
                $messageManager = new MessageManager();
                $messageManager->add([
                    'object' => $object,
                    'message' => $message
                ]);
                $mailSend = true;
                Session::addFlash( 'success', "Le message a bien été envoyé." );
                return $this->index();
            }
            return [
                "view" => VIEW_DIR."security/mailToAdminForm.php",
                "data" => [ "object" => $object, "message" => $message ]
            ];
        }

        /**
         * Méthode pour préparer l'affichage de l'envoi d'un message à l'administrateur
         */
        public function mailToAdminForm() 
        {
            return [
                "view" => VIEW_DIR."security/mailToAdminForm.php",
                "data" => [ "message" => "" ]
            ];
        }

        public function forumRules(){
            
            return [
                "view" => VIEW_DIR."rules.php"
            ];
        }

        /**
         * Méthode qui prépare l'affichage de la liste des messages
         */
        public function messagesList() 
        {
            $messageManager = new MessageManager();
            $messages = $messageManager->findAll();
            return [
                "view" => VIEW_DIR."security/messagesList.php",
                "data" => [ 'messages' => $messages ]
            ];
        }

        /**
         * Méthode qui prépare l'affichage de la liste des messages
         */
        public function messageDetail( $id ) 
        {
            $messageManager = new MessageManager();
            $message = $messageManager->findOneById( $id );
            return [
                "view" => VIEW_DIR."security/messageDetail.php",
                "data" => [ 'message' => $message ]
            ];
        }

        /**
         * Méthode qui supprime le message et renvoie sur la liste  des messages
         */
        public function messageDelete( $id )
        {
            $messageManager = new MessageManager();
            $messageManager->delete( $id );
            return $this->messagesList();
        }

        /*public function ajax(){
            $nb = $_GET['nb'];
            $nb++;
            include(VIEW_DIR."ajax.php");
        }*/
    }
