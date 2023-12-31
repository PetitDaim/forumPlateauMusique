<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicLikeManager;
    use Model\Managers\PostLikeManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\MediaManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Entities\Category;
    use Model\Entities\Media;
    use Model\Entities\Post;
    use Throwable;

    class ForumController extends AbstractController implements ControllerInterface
    {
        /**
         * Méthode appelée par défaut lorsqu'aucune action n'est spécifiée
         * Renvoie la liste de tous les sujets postés
         */ 
        public function index()
        {
            // Instanciation du manager des sujets
            $topicManager = new TopicManager();
            // Définit le titre de la page
            $title = "Liste des sujets postés";
            // definit la description de la page
            $description = "Les sujets postés font partie de différentes catégorie et sont présentés, ici pèle-mêle...";
            // Renvoie la vue de liste des sujets, ainsi que les paramètres associés
            return [
                "view" => VIEW_DIR."forum/topicsList.php",
                "data" => [
                    "topics" => $topicManager->findAll(["creationDate", "DESC"]),
                    'title' => $title,
                    'description' => $description
                ]
            ];
         
        }

        /**
         * Méthode appelée pour présenter le détail d' un sujet
         * id étant l'id du sujet
         */
        public function topicDetail( $id )
        {
            // Récupère l'id de l'utilisateur connecté
            $userId = Session::getUser() ? Session::getUser()->getId() : 0;
            // Instancie le manager de post
            $postManager = new PostManager();
            // Récupère les post du topic dont on vient de récupérer l'id
            $posts = $postManager->findAllWhereTopic( $id, ["creationDate", "ASC"]  );
            // Instancie le manager de sujet
            $topicManager = new TopicManager();
            // Récupère le topic dont on vient de récupérer l'id
            $topic = $topicManager->findOneById( $id );
            if( $topic ) 
            {
                // Définit le titre de la page
                $title = "Détail du sujet : ".$topic->getTitle();
                // definit la description de la page
                $description = "Ce sujet présente : ".$topic->getTitle();
            }
            else
            {
                // Définit le titre de la page
                $title = "Détail d'un sujet non trouvé";
                // definit la description de la page
                $description = "Détail d'un sujet non trouvé (renvoie vers la liste des sujets)";
            }
            // Instancie le manager de like de topic
            $topicLikeManager = new TopicLikeManager();
            // Récupère le nombre de likes de ce topic
            $topicLike = $topicLikeManager->findOneWhereUserAndTopic( $userId, $id );
            // Renvoie la vue topicDetail
            // Ainsi que les paramètres: user et likes
            return [
                    "view" => VIEW_DIR."forum/topicDetail.php",
                    "data"=> [
                        "topicLike" => $topicLike,
                        "topic" => $topic,
                        "posts" => $posts,
                        'title' => $title,
                        'description' => $description
                    ]
            ];
        }

        /**
         * Méthode appelée pour présenter le formulaire d'ajout de sujet
         * id étant l'id de la catégorie
         */
        public function topicAddForm( $id )
        {
            // Intancie le manager de catégorie
            $categoryManager = new CategoryManager();
            // Définit le titre de la page
            $title = "Ajout de sujet";
            // definit la description de la page
            $description = "Formulaire d'ajout de sujet";
            // Renvoie la catégorie dont on a récupéré l'id dans l'url
            return [
                "view" => VIEW_DIR."forum/topicAddForm.php",
                "data" => [
                    "category" => $categoryManager->findOneById( $id ),
                    'title' => $title,
                    'description' => $description
                ]
            ];
        }

        /**
         * Méthode appelée pour effectuer l'ajout de sujet
         * id étant l'id de la catégorie
         */
        public function topicAdd( $id )
        {
            if( ! Session::getUser() ) 
            {
                Session::addFlash("error", "Il n'est pas possible d'ajouter un sujet tant que l'on n'est pas connecté !");
                $this->redirectTo( "security", "loginForm" );
            }
            else if( Session::getUser()->getBanned() ) 
            {
                Session::addFlash( "error", "Vous avez été banni et ne pouvez plus ajouter de sujets." );
                $this->redirectTo( "forum", "categoriesList" );
            }
            // Intancie le manager de catégorie
            $categoryManager = new CategoryManager();
            // Intancie le manager de média
            $mediaManager = new MediaManager();
            // Intancie le manager de sujet
            $topicManager = new TopicManager();
            // Instancie le manager de post
            $postManager = new PostManager();
            // Définit le titre de la page
            $title = "Ajout de sujet";
            // definit la description de la page
            $description = "Ajout d'un sujet";
            // Récupération des fichiers média
            // Initialisation du media tiny (pour les listes de sujets)
            if( isset( $_FILES[ "tinyMediaFile" ] ) ) 
            {
                $tinyMediaFile = $_FILES[ "tinyMediaFile" ];
                $tinyMediaFile = Media::loadMediaFile( $tinyMediaFile );
                $tinyMediaName = isset( $tinyMediaFile['name'] )?$tinyMediaFile['name']:"./img/undefinedImageUrl.jpg";
                $tinyMediaUrl = isset( $tinyMediaFile['url'] )?$tinyMediaFile['url']:"./img/undefinedImageUrl.jpg";
                $tinyMediaType = isset( $tinyMediaFile['type'] )?$tinyMediaFile['type']:"images/jpeg";
            }
            // Initialisation du media medium (pour le détail des sujets)
            if( isset( $_FILES[ "mediumMediaFile" ] ) ) 
            {
                $mediumMediaFile = $_FILES[ "mediumMediaFile" ];
                $mediumMediaFile = Media::loadMediaFile( $mediumMediaFile );
                $mediumMediaName = isset( $mediumMediaFile['name'] )?$mediumMediaFile['name']:"./img/undefinedImageUrl.jpg";
                $mediumMediaUrl = isset( $mediumMediaFile['url'] )?$mediumMediaFile['url']:"./img/undefinedImageUrl.jpg";
                $mediumMediaType = isset( $mediumMediaFile['type'] )?$mediumMediaFile['type']:"images/jpeg";
            }
            // Initialisation du media big (pour l'achat du média complêt)
            if( isset( $_FILES[ "bigMediaFile" ] ) ) 
            {
                $bigMediaFile = $_FILES[ "bigMediaFile" ];
                $bigMediaFile = Media::loadMediaFile( $bigMediaFile );
                $bigMediaName = isset( $bigMediaFile['name'] )?$bigMediaFile['name']:"./img/undefinedImageUrl.jpg";
                $bigMediaUrl = isset( $bigMediaFile['url'] )?$bigMediaFile['url']:"./img/undefinedImageUrl.jpg";
                $bigMediaType = isset( $bigMediaFile['type'] )?$bigMediaFile['type']:"images/jpeg";
            }
            // Récupération de la description des médias
            $mediaDescription = filter_input( INPUT_POST, "mediaDescription", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            // Ajoût des médias et récupération de l'id des médias
            $mediaId = $mediaManager->add(
                [
                    "tinyMediaName" => $tinyMediaName,
                    "tinyMediaUrl" => $tinyMediaUrl,
                    "tinyMediaType" => $tinyMediaType,
                    "mediumMediaName" => $mediumMediaName,
                    "mediumMediaUrl" => $mediumMediaUrl,
                    "mediumMediaType" => $mediumMediaType,
                    "bigMediaName" => $bigMediaName,
                    "bigMediaUrl" => $bigMediaUrl,
                    "bigMediaType" => $bigMediaType,
                    "mediaDescription" => $mediaDescription
                ]
            );
            // Récupération du média à partir de l'id
            $media = $mediaManager->findOneById( $mediaId );
            // Récupération du titre du sujet
            $title = filter_input( INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            // Récupération de l'id de l'utilisateur connecté
            $userId = Session::getUser()->getId();
            // Ajoute le topic et en récupère l'Id
            $topicId = $topicManager->add( 
                [
                    "title" => $title,
                    "user_id" => $userId,
                    "category_id" => $id,
                    "media_id" => $mediaId,
                ]
            );
            // Récupère le message du premier post
            $message = filter_input( INPUT_POST, "message", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            // Ajoute le post et en récupère l'Id
            $postId = $postManager->add( 
                [
                    "user_id" => $userId,
                    "topic_id" => $topicId,
                    "message" => $message
                ]
            );
            // Renvoie la vue 'topicAddForm'
            // Ainsi que les paramètres : 'category', 'media', 'topic' et 'post'
            return [
                "view" => VIEW_DIR."forum/topicAddForm.php",
                "data" => [
                    "category" => $categoryManager->findOneById( $id ),
                    "media" => $media,
                    "post" => $postManager->findOneById( $postId ),
                    'title' => $title,
                    'description' => $description
                ]
            ];
         
        }

        /**
         * Méthode qui prépare l'affichage du formulaire pour l'ajout de catégorie
         * id ne sert à rien
         */
        public function categoryAddForm( $id=null )
        {
            // Définit le titre de la page
            $title = "Ajout de categorie";
            // definit la description de la page
            $description = "Formulaire d'ajout de categorie";
            // definit la la variable qui assure que la page ne sera pas indexée par les moteurs de recherche
            $noIndex = true;
            // renvoie la vue 'categoryAddForm' sans data
            return [
                "view" => VIEW_DIR."forum/categoryAddForm.php",
                "data" => [
                    'title' => $title,
                    'description' => $description
                 ]
            ];
        }
 
        /**
         * Méthode qui prépare l'ajout de catégorie
         * id ne sert à rien
         */
        public function categoryAdd( $id=null )
        {
            // Interdit aux non admin de créer une catégorie
            if( ! Session::isAdmin() ) 
            {
                Session::addFlash( "error", "Il faut être admin pour ajouter une catégorie ." );
                return $this->categoriesList();
            }
            // Définit le titre de la page
            $title = "Ajout de categorie";
            // definit la description de la page
            $description = "Formulaire d'ajout de categorie";
            // definit la la variable qui assure que la page ne sera pas indexée par les moteurs de recherche
            $noIndex = true;
            // Récupère le nom de la catégorie
            $categoryName = filter_input(INPUT_POST, "categoryName", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            // Récupère le nom au singulier de la catégorie
            $categoryNameSingulier = filter_input(INPUT_POST, "categoryNameSingulier", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            // Récupère la présentation de la catégorie
            $presentation = filter_input(INPUT_POST, "presentation", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            // Instancie le manager de catégorie
            $categoryManager = new CategoryManager();
            // Essaye d'ajouter la catégorie
            try
            {
                $id = $categoryManager->add( [
                    "categoryName" => $categoryName,
                    "categoryNameSingulier" => $categoryNameSingulier,
                    "presentation" => $presentation
                ] );
                // Si la catégorie a bien été ajoutée
                if( $id ) 
                {
                    // Affiche un message de succes
                    Session::addFlash( "success", "La catégorie a bien été ajoutée." );
                    // Renvoie la liste des catégories
                    $this->redirectTo( "forum", "categoriesList" );
                }
            }
            catch( Throwable $err ) 
            {
                // Crée une catégorie pour l'affichage du formulaire
                $category = new Category( false );
                $category->setCategoryName( $categoryName );
                $category->setCategoryNameSingulier( $categoryNameSingulier );
                $category->setPresentation( $presentation );
                // Affiche un message d'erreur
                Session::addFlash( "error", "Cette catégorie existe déjà" );
                // Revoie la vue 'categoryAddForm' avec le paramètre 'category' pour l'affichage
                return [
                    "view" => VIEW_DIR."forum/categoryAddForm.php",
                    "data" => [
                        "category" => $category,
                        'title' => $title,
                        'description' => $description,
                        'noIndex' => $noIndex
                    ]
                ];
            }
         
        }

        /**
         * Méthode qui prépare la liste des catégories
         * id n'est pas utilisé
         */
        public function categoriesList( $id=null )
        {
            // Définit le titre de la page
            $title = "Liste des categories";
            // definit la description de la page
            $description = "Liste de toutes les catégories du forum de musique";
            // Instancie le manager de catégorie
            $categoryManager = new CategoryManager();
            // Renvoie la vue ''
            return [
                "view" => VIEW_DIR."forum/categoriesList.php",
                "data" => [
                    "categories" => $categoryManager->findAll(["categoryName", "ASC"]),
                    'title' => $title,
                    'description' => $description
                ]
            ];
 
        }

        /**
         * Méthode qui permet de supprimer la catégorie
         * id étant l'Id de la catégorie à supprimer (deleter)
         */
        public function categoryDelete( $id )
        {
            // Interdit aux non admin de supprimer une catégorie
            if( ! Session::isAdmin() ) 
            {
                Session::addFlash( "error", "Il faut être admin pour supprimer une catégorie ." );
                $this->redirectTo( "forum", "categoriesList" );
            }
            // Instancie le manager de catégorie
            $categoryManager = new CategoryManager();
            // Récupère la catégorie à supprimer
            $category = $categoryManager->findOneById( $id );
            // Supprime la categorie si il y en a bien une
            if( $category ) $category->delete();
            // Renvoie la vue ''
            $this->redirectTo( "forum", "categoriesList" );
        }

        /**
         * Méthode qui prépare le détail d'une catégorie, (soit la liste des topics)
         * id représente l'id de la catégorie
         */
        public function categoryDetail( $id ){
            $this->redirectTo( "forum", "topicsList", $id );
        }

        /**
         * Méthode qui prépare la liste des topics
         * id représente l'id de la catégorie
         */
        public function topicsList( $id = false ) 
        {
            // Instancie le manager de topic
            $topicManager = new TopicManager();
            // Instancie le manager de catégorie
            $categoryManager = new CategoryManager();
            // Vérifie qu'une catégorie est bien sélectionnée
            if( $id ) 
            {
                try
                {
                    // récupère la catégorie sélectionnée
                    $category = $categoryManager->findOneById( $id );
                    // Renvoie vers la vue topicsList
                    // avec les paramètres qui vont bien
                    return [
                        "view" => VIEW_DIR."forum/topicsList.php",
                        "data" => [
                            "topics" => $topicManager->findAllWhereCategory( $id ),
                            "category" => $category,
                            'title' => "Liste des sujet de la categorie : ".$category->getCategoryName(),
                            'description' => "Liste de tous les sujets de la catégorie : ".$category->getCategoryName()
                        ]
                    ];
                }
                catch( Throwable $err )
                {
                }
            }
            // Renvoie vers la vue topicsList
            // avec les paramètres qui vont bien (pour avoir les dix derniers sujets (toutes catégories confondues))
            return [
                "view" => VIEW_DIR."forum/topicsList.php",
                "data" => [
                    "topics" => $topicManager->findAllLimit(["creationdate", "DESC"], 10 ),
                    'title' => "Liste des dix derniers sujets",
                    'description' => "Liste des dix derniers sujets (toutes catégories confondues)"
                ]
            ];
 
        }

        /**
         * Méthode permettant de préparer la présentation du formulaire de post
         * id étant l'id du topic (sujet)
         */
        public function postForm( $id )
        {
            // Vérifie qu'on est connecté
            if( ! Session::getUser() ) 
            {
                // Sinon : Affiche une erreur et redirige vers la page de login
                Session::addFlash( "error", "Il faut se connecter pour poster des messages." );
                $this->redirectTo( "security", "loginForm" );
            }
            // Vérifie qu'on n'est pas banni
            else if( Session::getUser()->getBanned() ) 
            {
                // Sinon : Affiche une erreur et redirige vers la page de la liste des catégories
                Session::addFlash( "error", "Vous avez été banni et ne pouvez plus poster de messages." );
                $this->redirectTo( "forum", "categoriesList" );
            }
            // Vérifie que le post correspond à un topic ($id)
            if( $id )
            {
                try
                {
                    // Instancie le manager de topic
                    $topicManager = new TopicManager();
                    // Cherche le topic concerné
                    $topic = $topicManager->findOneById( $id );
                    // Si il y a bien un topic et qu'il n'est pas clos
                    if( $topic && ( ! $topic->getClosed() ) ) 
                    {
                        $this->redirectTo( "forum", "topicDetail", $id );
                    }
                }
                catch( Throwable $err )
                {
                }
            }
            // Affiche un message d'erreur
            Session::addFlash( "error", "Impossible de poster un message sur un sujet clos." );
            $this->redirectTo( "forum", "index" );
        }

        /**
         * Méthode permettant de préparer un ajout de post
         * id étant l'id du topic (sujet)
         */
        public function post( $id )
        {
            // Vérifie que l'utilisateur est bien connecté
            if( ! Session::getUser() ) {

                Session::addFlash( "error", "Il faut se connecter pour poster des messages." );
                $this->redirectTo( "security", "loginForm" );
            }
            // Vérifie que l'utilisateur connecté n'est pas banni
            else if( Session::getUser()->getBanned() ) {

                Session::addFlash( "error", "Vous avez été banni et ne pouvez plus poster de messages." );
                $this->redirectTo( "forum", "categoriesList" );
            }

            // Récupère le message en se premunissant de la faille xss
            $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            // Instancie le manager de post
            $postManager = new PostManager();
            // Instancie le manager de topic
            $topicManager = new TopicManager();
 
            try
            {
                // Cherche le topic auquel on veut répondre
                $topic = $topicManager->findOneById( $id );
                // Vérifie que le topic existe et n'est pas clos
                if( $topic && ( ! $topic->getClosed() ) )
                {
                    // Ajoute le mesage en BDD
                    $postId = $postManager->add( [
                        "user_id" => (Session::getUser()) ? Session::getUser()->getId() : 0,
                        "topic_id" => $id,
                        "message" => $message
                    ] );
                    // Vérifie que le message a bien été ajouté en BDD
                    if( $postId ) 
                    {
                        Session::addFlash( "success", "Le message a été ajouté." );
                        // renvoie vèrs le détail du topic
                        $this->redirectTo( 'forum', 'topicDetail', $id );
                    }
                }         
            }
            catch( \Exception $err ) {
            }
            Session::addFlash( "error", "Impossible de poster un message sur un sujet clos." );
            // renvoie vèrs la liste de tout les topics
            $this->redirectTo( "forum", "index", 0 );
    }

        /**
         * Méthode qui permet de liker un sujet (topic)
         * id représente l'id du topic 
         */
        public function likeTopic( $id )
        {
            // Récupère l'id de l'utilisateur connecté
            $userId = Session::getUser() ? Session::getUser()->getId() : 0;
            // si un sujet (topic) a été liké par un utilisateur connecté
            if( $id && $userId ) 
            {
                // Instancie le manager de like de topic (sujet)
                $topicLikeManager = new TopicLikeManager();
                try
                {
                    // Vérifie si l'utilisateur aime déjà le sujet ou non
                    if( $topicLike = $topicLikeManager->findOneWhereUserAndTopic( $userId, $id ) ) 
                    {
                        // Supprime le like de l'utilisateur connecté
                        $topicLikeManager->delete( $topicLike->getId() );
                    }
                    else{
                        // Ajoute un like pour l'utilisateur connecté
                        $topicLikeManager->add(
                            [
                                "topic_id" => $id,
                                "user_id" => $userId
                            ]
                        );
                    }
                    // Redirige vers le détail du topic
                    $this->redirectTo( "forum", "topicDetail", $id );
                }
                catch( \Exception $err )
                {
                    // Affiche un message d'erreur et Redirige vers la liste des topics
                    Session::addFlash( "Error", "Ce sujet n'existe pas !" );
                    $this->redirectTo( "forum", "topicsList", 0 );
                }
            }
            else if( $userId ) 
            {
                // Affiche un message d'erreur et Redirige vers la liste des topics
                Session::addFlash( "Error", "Ce sujet n'existe pas !" );
                $this->redirectTo( "forum", "topicsList", 0 );
            }
            else 
            {
                // Affiche un message d'erreur et Redirige vers la page de login
                Session::addFlash( "Error", "Vous devez être connecté pour pouvoir liker un sujet !" );
                $this->redirectTo( "security", "loginForm" );
            }
        }

        /**
         * Méthode qui permet de liker un post
         * id représente l'id du post
         */
        public function likePost( $id )
        {
            // Récupère l'id de l'utilisateur connecté
            $userId = Session::getUser() ? Session::getUser()->getId() : 0;
            // si un message (post) a été liké par un utilisateur connecté
            if( $id && $userId ) 
            {
                // Instancie le manager de like de post (message)
                $postLikeManager = new PostLikeManager();
                try
                {
                    // Initialise le topicId à null
                    $topicId = null;
                    // Vérifie si l'utilisateur aime déjà le sujet ou non
                    if( $postLike = $postLikeManager->findOneWhereUserAndPost( $userId, $id ) )
                    {
                        // récupère le post pour avoir l'id du topic
                        $topicId = $postLike->getPost()->getTopic()->GetId();
                        // Supprime le like de l'utilisateur connecté
                        $postLike->delete();
                    }
                    else
                    {
                        // Ajoute un like pour l'utilisateur connecté
                        $postLikeId = $postLikeManager->add(
                            [
                                "post_id" => $id,
                                "user_id" => $userId
                            ]
                        );
                        $postLike = $postLikeManager->findOneById( $postLikeId );
                        // récupère le post pour avoir l'id du topic
                        $topicId = $postLike->getPost()->getTopic()->GetId();
                    }
                    // Redirige vers le détail du topic
                    $this->redirectTo( "forum", "topicDetail", $topicId );
                }
                catch( \Exception $err )
                {
                    // Affiche un message d'erreur et Redirige vers la liste des 10 derniers topics
                    Session::addFlash( "Error", "Ce post n'existe pas !" );
                    $this->redirectTo( "forum", "topicsList" );
                }
            }
            else if( $userId ) 
            {
                // Affiche un message d'erreur et Redirige vers la liste des 10 derniers topics
                Session::addFlash( "Error", "Ce post n'existe pas !" );
                $this->redirectTo( "forum", "topicsList" );
            }
            else 
            {
                // Affiche un message d'erreur et Redirige vers la page de login
                Session::addFlash( "Error", "Vous devez être connecté pour pouvoir liker un message !" );
                $this->redirectTo( "security", "loginForm" );
            }
        }

        /**
         * Méthode qui permet de locker et d'unlocker un sujet (topic)
         * L'id représente l'id tu topic
         */
        public function topicLockUnlock( $id )
        {
            // Initialise la variable de succes ou d'échec de la méthode
            $isSuccess = false;
            // Instancie le manager de topic
            $topicManager = new TopicManager();
            // Récupère le topic à locker
            $topic = $topicManager->findOneById( $id );
            // Vérifie que l'utilisateur connecté est bien celui qui a créé le topic, ou bien qu'il est administrateur
            if( $topic && ( $topic->getUser() == Session::getUser() ) || Session::isAdmin() ) 
            {
                // Si le topic est fermé, le réouvre
                if( $topic->getClosed() ) $topic->setClosed( 0 );
                // Sinon, le ferme
                else $topic->setClosed( 1 );
                // Essaie d'enregistrer les modifs en BDD
                try
                {
                    $topicManager->update( $topic );
                    $isSuccess = true;
                }
                catch( Throwable $err )
                {
                }
            }
            // Affiche un message d'erreur approprié en cas d'erreur
            if( ! $isSuccess ) Session::addFlash( "error", "Impossible de ".($topic && $topic->getClosed()?"dé":"")."locker le sujet !!!" );
            // Redirige vers le détail du topic
            $this->redirectTo( "forum", "topicDetail", $id );
        }

    }
