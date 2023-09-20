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

    class SecurityController extends AbstractController implements ControllerInterface
    {

        /**
         * Méthode appelée par défaut : Renvoie la liste des catégories
         */
        public function index()
        {
            // Instancie le manager de catégorie et renvoie la liste des catégories par ordre alphabétique
            $categoryManager = new CategoryManager();
            $categories = $categoryManager->findAll(["categoryName", "ASC"]);
            // Redirige vers la home page
            return [
                "view" => VIEW_DIR."home/home.php",
                "data" => [
                    "categories" => $categories,
                    'title' => "Accueil du forum de musique",
                    'description' => "Ce forum de musique présente diverses catégorie de publications de sujets permettant à des artistes qui souhapitent émerger, de faire connaître leurs créations musicales"
                ]
            ];
 
        }

        /**
         * Méthode qui prépare la page d'enregistrement d'utilisateur
         */
        public function registerForm()
        {
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
            // Récupère les données du formulaire en se prémunissant de la faille xss
            $pseudo = filter_input( INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $password = filter_input( INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $passwordConfirm = filter_input( INPUT_POST, "passwordConfirm", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $email = filter_input( INPUT_POST, "email", FILTER_SANITIZE_EMAIL );
            // Initialise la variable définissant s'il y a des erreurs ou non dans le formulaire.
            $hasErrors = false;
            // Si le pseudo a une longuer inférieure à 3 : Affiche une erreur
            if( strlen( $pseudo ) < 3 ) 
            {
                Session::addErrors('pseudo', "Le pseudo doit contenir au moin 3 caractères");
                $hasErrors = true;
            }

            // Si le mot de passe a une longuer inférieure à 12 : Affiche une erreur
            if( strlen( $password ) < 12 ) 
            {
                Session::addErrors('password', "Le mot de passe doit contenir au moins 12 caractères");
                $hasErrors = true;
            }
            // Si le mot de passe ne correspond pas aux standards de sécurilté : Affiche une erreur
            else if( ! preg_match( '/^(?:(?=.*\d)(?=.*[A-Z])(?=.*[a-z])|(?=.*\d)(?=.*[^A-Za-z0-9])(?=.*[a-z])|(?=.*[^A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z])|(?=.*\d)(?=.*[A-Z])(?=.*[^A-Za-z0-9]))(?!.*(.)\1{2,})[A-Za-z0-9!~<>,;:_=?*+#."&§%°()\|\[\]\-\$\^\@\/]{12,128}$/', $password ) ) 
            {
                Session::addErrors('password', "Le mot de passe doit contenir au moins deux minuscules, deux Majuscules, deux chiffres, deux caractères spéciaux et aucuns caractèrs en double" );
                $hasErrors = true;
            }
            // Si les deux mots de passe ne correspondent pas : Affiche une erreur
            if( $passwordConfirm != $password ) 
            {
                Session::addErrors('passwordConfirm', "Les deux mots de passes sont différents");
                $hasErrors = true;
            }
            // Si l'EMail' a une longuer inférieure à 8 : Affiche une erreur
            if( strlen( $email ) < 8 ) 
            {
                Session::addErrors('email', "L'EMail' doit contenir au moins 8 caractères");
                $hasErrors = true;
            }

            // Si il y a des erreurs dans les données du formulaire, Affiche une erreur flash
            if( ! $hasErrors ) 
            {
                $userManager = new UserManager();
                try
                {
                    // Si ce pseudo est déja utilisé : Affiche une erreur
                    if( $userManager->findWherePseudo( $pseudo ) ) 
                    {
                        $hasErrors = true;
                        Session::addErrors('pseudo', "Ce pseudo est déjà utilisé");
                    }
                    // Si cet email est déja utilisé : Affiche une erreur
                    if ( $userManager->findWhereEmail( $email ) ) 
                    {
                        $hasErrors = true;
                        Session::addErrors('email', "Cet email est déjà utilisé");
                    }
                    // S'il n'y a toujours pas d'erreur
                    if( ! $hasErrors ) 
                    {
                        // Ajoute le user en BDD en hashant le mot de passe
                        $userId = $userManager->add(
                            [
                                "pseudo" => $pseudo, 
                                "password" => password_hash( $password, PASSWORD_DEFAULT ), 
                                "email" => $email,
                                "role" => json_encode( [ "ROLE_USER" ] )
                            ]
                        );
                        // Affiche un message de succes et redirige sur la page de login
                        Session::addFlash('success', "Votre utilisateur a bien été inscrit");
                        $this->redirectTo( "security", "loginForm" );
                    }
                        
                }
                catch( Throwable $_err ) 
                {
                    $hasErrors = true;
                    echo $_err->getMessage();
                    Session::addErrors('email', "Ce pseudo ou cet email sont déjà utilisés");
                }
            }
            // Affiche un message d'erreur
            Session::addFlash('error', "Erreur de formulaire: Merci de vérifier les messages qui suivent");
            // Instancie un user et l'initialise avec les données du formulaire
            $user = new User(false);
            $user->setPseudo($pseudo);
            $user->setEmail($email);
            // renvoie vers le formulaire
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
        public function loginForm()
        {
            // Renvoie vers le formulaire de login
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
            if( $user = $userManager->findWherePseudoAndEmail( $pseudo, $email ) ) 
            {
                // Vérifie si le mot de passe correspond
                if( password_verify( $password, $user->getPassword() ) ) 
                {
                    // Connecte l'utilisateur
                    Session::setUser( $user );
                    // Si l'utilisateur a été banni
                    if( $user->getBanned() ) 
                    {
                        // Affiche un message d'erreur
                        Session::addFlash( 'error', "Vous avez été banni, Veuilez contacter un administrateur." );
                        // Redirige vers la page de détail de l'utilisateur
                        $this->redirectTo( "security", "userDetail", $user->getId() );
                    }
                    // Affiche un message de succes
                    Session::addFlash( 'success', "Vous êtes bien connecté." );
                    // Redirige sur l'URL sauvegardée en session (différente des pages de login et de registration)
                    Session::restoreUrl();
                }
                // Affiche un message d'erreur
                Session::addErrors('password', "Le mot de passe ne correspond pas !");
            }
            else
            {
                // Sinon : Le pseudo et le mail ne correspondent pas, on part en erreur
                $hasErrors = true;
                Session::addErrors('pseudo', "Le pseudo ou le mail ne correspondent pas !");
            }
            // Si il n'a toujours pas été possible de se connecter
            // Crée un user sans hydratation pour l'affichage des données entrées dans le formulaire
            $user = new User( false );
            $user->setPseudo( $pseudo );
            $user->setPassword( $password );
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

        /**
         * Méthode de logout
         */
        public function logout( $id )
        {
            // Annule la session
            Session::setUser( null );
            unset( $_SESSION );
            // Redirige vers la page d'accueil du forum
            $this->redirectTo( 'home', 'index' );
            // header( 'location: ./' );
        }

        /**
         * Méthode qui prépare et renvoie vers la liste des utilisateurs
         */
        public function usersList( $id=null )
        {
            if( Session::isAdmin() ) 
            {
                // Intancie le manager des utilisateurs
                $manager = new UserManager();
                // Récupère la liste de tous les utilisateurs triées par ordre alphabétique du pseudo
                $users = $manager->findAll( ["pseudo", "ASC"] );
                // Redirige vers la liste des utilisateurs
                return [
                        "view" => VIEW_DIR."security/usersList.php",
                        "data"=> [
                            "users" => $users,
                            "title" => "Liste des utilisateurs du forum de musique",
                            "description" => "Présentation d'artistes qui souhapitent émerger et faire connaître leurs créations musicales, plus d'utilisateurs du forum souhaitant encourager ces artistes",
                            "noIndex" => true
                        ]
                ];
            }
            // Redirige vers la home page
            $this->redirectTo( "security", "index" );
        }

        /**
         * Méthode pour préparer le détail d'un utilisateur
         */
        public function userDetail( $id )
        {
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

        public function userBannUnbann( $id )
        {
            $userManager = new UserManager();
            // Récupère l'utilisateur
            $user = $userManager->findOneById( $id );

            // Initialisation d'une variable pour le messaged'erreur
            $de = "";
            // Vérifie que l'utilisateur connecté est bien l'administrateur du forum
            if( Session::isAdmin() && ( ! ( ( isset( $user ) && $user) && ( $user == Session::getUser() ) ) ) ) 
            {
                // Si l'utilisateur était banni
                if( $user->getBanned() ) 
                {
                    // Débanni l'utilisateur
                    $user->setBanned( 0 );
                    // Modification d'une variable pour le messaged'erreur
                    $de = "dé";
                }
                // Sinon, Banni l'utilisateur
                else $user->setBanned( 1 );
                try
                {
                    // Update en BDD
                    $userManager->update( $user );
                    // Redirige vers la page de détail de l'utilisateur (pour pouvoir revenir en arrière si on pense avoir fait une fausse manip)
                    $this->redirectTo( "security", "userDetail", $user->getId() );
                }
                catch( Throwable $err )
                {
                    // echo $err->getMessage();
                }
            }
            // Affiche un message d'erreur
            Session::addFlash( 'error', "Impossible de ".$de."bannir le posteur du message !!!" );
            // Redirige vers la home page
            $this->redirectTo( "security", "index" );
        }

        /**
         * Méthode pour préparer l'envoi d'un message à l'administrateur
         */
        public function mailToAdmin() 
        {
            $hasErrors = false;
            //  Vérifie que l'utilisateur est bien connecté
            if( ! Session::getUser() ) 
            {
                // Sinon : Affiche un message d'erreur
                Session::addFlash( 'error', "Il faut être connecté pour envoyer un message à l'administrateur du forum !" );
                // Redirige vers la page de login
                $this->redirectTo( "security", "loginForm" );
            }
            // Récupère les données du formulaire en se prémunissant de la faille xss
            $object = filter_input( INPUT_POST, "object", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $message = filter_input( INPUT_POST, "message", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            // Si la longueur de l'objet est inférieure à 5 : Affiche un message d'erreur
            $objectLength = strlen( $object );
            if( $objectLength < 5 ) 
            {
                $hasErrors = true;
                Session::addErrors('object', "L'objet du message doit comporter au moins 5 caractères");
            }
            // Si la longueur de l'objet est supérieure à 30 : Affiche un message d'erreur
            else if( $objectLength > 30 ) 
            {
                $hasErrors = true;
                Session::addErrors('object', "L'objet du message doit comporter au maximum 30 caractères");
            }
            // Si la longueur du message est inférieure à 10 : Affiche un message d'erreur
            $messageLength = strlen( $message );
            if( $messageLength < 10 ) 
            {
                $hasErrors = true;
                Session::addErrors('message', "Le message doit comporter au moins 10 caractères (vous pouvez commencer par Bonjour,...)");
            }
            // Si la longueur du message est supérieure à 30 : Affiche un message d'erreur
            else if( $messageLength > 255 ) 
            {
                $hasErrors = true;
                Session::addErrors('message', "Le message doit comporter au maximum 255 caractères");
            }
            if( ! $hasErrors ) 
            {
                // Instancie le manager de message
                $messageManager = new MessageManager();
                // Ajoute le message en BDD
                $messageManager->add([
                    'object' => $object,
                    'message' => $message
                ]);
                // Affiche un message de succes
                Session::addFlash( 'success', "Le message a bien été envoyé." );
                // Redirige vers la home page
                $this->redirectTo( "security", "index" );
            }
            // Revoie vers le formulaire de mail
            return [
                "view" => VIEW_DIR."security/mailToAdminForm.php",
                "data" => [ 
                    "object" => $object, 
                    "message" => $message,
                    "title" => "Envoyer un message à l'administrateur du forum",
                    "description" => "Envoyer un message à l'administrateur du forum de Musique"
                ]
            ];
        }

        /**
         * Méthode pour préparer l'affichage de l'envoi d'un message à l'administrateur
         */
        public function mailToAdminForm() 
        {
            return [
                "view" => VIEW_DIR."security/mailToAdminForm.php",
                "data" => [ 
                    "message" => "",
                    "title" => "Envoyer un message à l'administrateur du forum",
                    "description" => "Envoyer un message à l'administrateur du forum de Musique"
                ]
            ];
        }

        public function forumRules(){
            
            return [
                "view" => VIEW_DIR."rules.php",
                "data" => [ 
                    "title" => "Règles du forum",
                    "description" => "Règles du forum de Musique"
                ]
            ];
        }

        /**
         * Méthode qui prépare l'affichage de la liste des messages
         */
        public function messagesList() 
        {
            // Vérifie qu'on est bien administrateur
            if( ! Session::isAdmin() ) 
            {                
                Session::addFlash( 'error', "Vous n'avez pas le droit de voir les messages de l'administrateur du forum !" );
                $this->redirectTo( "security", "index" );
            }
            // Intancie le manager de message
            $messageManager = new MessageManager();
            // Récupère tous les messages
            $messages = $messageManager->findAll();
            // Renvoie la vue liste des messages
            return [
                "view" => VIEW_DIR."security/messagesList.php",
                "data" => [ 
                    'messages' => $messages,
                    "title" => "Liste des messages de l'administrateur du forum",
                    "description" => "Envoyer un message à l'administrateur du forum de Musique",
                    "noIndex" => true
                ]
            ];
        }

        /**
         * Méthode qui prépare l'affichage de la liste des messages
         */
        public function messageDetail( $id ) 
        {
            // Vérifie qu'on est bien administrateur
            if( ! Session::isAdmin() ) 
            {                
                Session::addFlash( 'error', "Vous n'avez pas le droit de voir les messages de l'administrateur du forum !" );
                $this->redirectTo( "security", "index" );
            }
            // Intancie le manager de message
            $messageManager = new MessageManager();
            // Récupère le message sélectionné par $id
            $message = $messageManager->findOneById( $id );
            // Renvoie la vue Détail de message
            return [
                "view" => VIEW_DIR."security/messageDetail.php",
                "data" => [ 
                    'message' => $message,
                    "title" => "Détail d'un message de l'administrateur du forum",
                    "description" => "Détail d'un message de l'administrateur du forum de Musique",
                    "noIndex" => true
                ]
            ];
        }

        /**
         * Méthode qui supprime le message et renvoie sur la liste  des messages
         */
        public function messageDelete( $id )
        {
            // Vérifie qu'on est bien administrateur
            if( ! Session::isAdmin() ) 
            {                
                Session::addFlash( 'error', "Vous n'avez pas le droit de voir les messages de l'administrateur du forum !" );
                $this->redirectTo( "security", "index" );
            }
            // Intancie le manager de message
            $messageManager = new MessageManager();
            // Supprime le message sélectionné par $id
            $messageManager->delete( $id );
            // Redirige vers la liste des messages
            $this->redirectTo( "security", "messagesList" );
        }

        /**
         * Methode pour la modification du mot de passe
         */
        public function passwordModifyForm()
        {
            return [
                "view" => VIEW_DIR."security/passwordModifyForm.php",
                "data" => [ 
                    'password' => "",
                    'passwordModify' => "",
                    'passwordConfirm' => "",
                    "title" => "Modification du mot de passe",
                    "description" => "Modification du mot de passe",
                    "noIndex" => true
                ]
            ];
        }

        /**
         * Methode pour la modification du mot de passe
         */
        public function passwordModify()
        {
            $hasErrors = false;
            $password = filter_input( INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $passwordNew = filter_input( INPUT_POST, "passwordNew", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $passwordConfirm = filter_input( INPUT_POST, "passwordConfirm", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            // Si le mot de passe a une longuer inférieure à 12 : Affiche une erreur
            if( strlen( $passwordNew ) < 12 ) 
            {
                Session::addErrors('passwordNew', "Le mot de passe doit contenir au moins 12 caractères");
                $hasErrors = true;
            }
            // Si le mot de passe ne correspond pas aux standards de sécurilté : Affiche une erreur
            else if( ! preg_match( '/^(?:(?=.*\d)(?=.*[A-Z])(?=.*[a-z])|(?=.*\d)(?=.*[^A-Za-z0-9])(?=.*[a-z])|(?=.*[^A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z])|(?=.*\d)(?=.*[A-Z])(?=.*[^A-Za-z0-9]))(?!.*(.)\1{2,})[A-Za-z0-9!~<>,;:_=?*+#."&§%°()\|\[\]\-\$\^\@\/]{12,128}$/', $passwordNew ) ) 
            {
                Session::addErrors('passwordNew', "Le mot de passe doit contenir au moins deux minuscules, deux Majuscules, deux chiffres, deux caractères spéciaux et aucuns caractèrs en double" );
                $hasErrors = true;
            }
            // Si les deux mots de passe ne correspondent pas : Affiche une erreur
            if( $passwordConfirm != $passwordNew )
            {
                Session::addErrors('passwordConfirm', "Les deux mots de passes sont différents");
                $hasErrors = true;
            }
            // Récupère le user connecté
            $user = Session::getUser();
            // Vérifie si le mot de passe correspond
            if( ! password_verify( $password, $user->getPassword() ) ) 
            {
                Session::addErrors('password', "Votre mot de passe ne correspond pas");
                $hasErrors = true;
            }
            // S'il n'y a toujours pas d'erreur
            if( ! $hasErrors ) 
            {
                // Update le user en BDD en hashant le mot de passe
                return (new UserManager() )->updateWhereId(
                    [
                        "pseudo" => $user->getPseudo(),
                        "password" => password_hash( $password, PASSWORD_DEFAULT ), 
                        "email" => $user->getEmail(),
                        "avatar" => $user->getAvatar(),
                        "banned" => $user->getBanned(),
                        "role" => $user->getRole()
                    ],
                    $user->getId()
                );
                // Affiche un message de succes et redirige sur la page de login
                Session::addFlash('success', "Votre mot de passe a bien été modifié");
                $this->redirectTo( "security", "loginForm" );
            }
            return [
                "view" => VIEW_DIR."security/passwordModifyForm.php",
                "data" => [ 
                    'password' => $password,
                    'passwordNew' => $passwordNew,
                    'passwordConfirm' => $passwordConfirm,
                    "title" => "Modification du mot de passe",
                    "description" => "Modification du mot de passe",
                    "noIndex" => true
                ]
            ];
        }
        /*public function ajax(){
            $nb = $_GET['nb'];
            $nb++;
            include(VIEW_DIR."ajax.php");
        }*/
    }
