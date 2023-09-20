<?php
    /**
     * VUE DU DÉTAIL DE TOPIC
     */
    if( isset( $result["data"]['topic'] ) ) $topic = $result["data"]['topic'];
    if( isset( $result["data"]['posts'] ) ) $posts = $result["data"]['posts'];
    if( isset( $result["data"]['topicLike'] ) ) $topicLike = $result["data"]['topicLike'];
?>


<?php
    // si il y a bien un topic
    if( isset($topic) && $topic ) 
    {
?>
    <h2>Détail du sujet : <?= $topic->getTitle() ?></h2>

    <div class="flex-row">
        <div class="card">
            <?php ($topic->getMedia())->showMedia('medium'); ?>
<?php
        // si il y a bien des posts
        if( isset( $posts ) ) 
        {
            $count=0;
            // boucle sur les posts
            foreach( $posts as $post ) 
            {
                // Si l'utilisateur n'est pas banni : AFFICHE LE POST
                if( ! $post->getUser()->getBanned() ) 
                {
                    // Si ce n'est pas le premier post du topic
                    if( $count ) 
                    {
?>
        <div class="card">
<?php
                    }
?>
            <p class="width-300 center">
                <?= $post->getMessage() ?>
                <!-- AVATAR de l'auteur du post -->
                <figure>
                    <a href="./?ctrl=security&action=userDetail&id=<?= $post->getUser()->getId() ?>">
                        <img src="<?= $post->getUser()->getAvatar() ?>" alt="<?= $post->getUser()->getPseudo() ?>" class="signature"/>
                    </a>
                    <figcaption><?= $post->getUser()->getPseudo() ?></figcaption>
                </figure>
<?php
                    // Si on est admin et que le post n'est pas de nous :
                    if( App\Session::isAdmin() && ( $post->getUser() != App\Session::getUser() ) ) 
                    {
?>
                                    <!-- Boutton pour bannir l'auteur du post -->
                                    <form action="./?ctrl=security&action=userBannUnbann&id=<?= $post->getUser()->getId() ?>" method="POST">
                                        <button type="submit" class="error">Bannir le posteur du message</button>
                                    </form>
<?php
                    }
?>
            </p>
<?php
                    // Si ce n'est pas le premier post du topic
                    if( $count ) 
                    {
                        // Si on est connecté
                        if( App\Session::getUser() ) 
                        {
?>
            <!-- BOUTTON de like/unlike du post -->
            <form action="./?ctrl=forum&action=likePost&id=<?= $post->getId() ?>" method="POST">
                <button type="submit" class="padding-5">
                    <figure>
                        <img src="./img/liker.jpg" alt="Liker" class="max-height-50" title="<?= $post->getLikers() ?>">
                        <figcaption>Liker le<br>message<br><sup>(<?= $post->likesCount() ?>)</sup><?= ( $post->isLiked( App\Session::getUser() ) ) ? ' <img src="./img/cocheVerte.jpg" alt="Vous likez" title="Vous likez" class="coche-verte"/>' :'' ?></figcaption>
                    </figure>
                </button>
            </form>
<?php
                        }
?>
        </div>
<?php
                    }
                }
                // Si c'est le premier post du topic
                if( ! $count ) 
                {
                    // Si on est connecté
                    if( App\Session::getUser() ) 
                    {
?>
            <!-- BOUTTON de like/unlike du topic -->
            <form action="./?ctrl=forum&action=likeTopic&id=<?= $topic->getId() ?>" method="POST">
                <button type="submit" class="padding-5">
                    <figure>
                        <img src="./img/liker.jpg" alt="Liker" class="max-height-50" title="<?= $topic->getLikers() ?>">
                        <figcaption>Liker le<br>sujet<br><sup>(<?= $topic->likesCount() ?>)</sup><?= ( isset( $topicLike ) && $topicLike ) ? ' <img src="./img/cocheVerte.jpg" alt="Vous likez" title="Vous likez" class="coche-verte"/>' :'' ?></figcaption>
                    </figure>
                </button>
            </form>
<?php
                    }
                    // Si le sujet n'est pas fermé, qu'on est connecté et qu'on est pas banni
                    if( ( ! $topic->getClosed() ) && App\Session::getUser() && ( ! App\Session::getUser()->getBanned() ) ) 
                    {
?>
            <!-- BOUTTON pour commenter le topic -->
            <form action="./?ctrl=forum&action=postForm&id=<?= $topic->getId() ?>" method="POST">
                <button type="submit">Commenter le sujet</button>
            </form>
<?php
                    }
                    // Si on est administrateur ou qu'on est l'auteur du topic
                    if( ( App\Session::isAdmin() || ( App\Session::getUser() == $topic->getUser() ) ) ) 
                    {
?>
            <!-- BOUTTON de lock/unlock -->
            <form action="./?ctrl=forum&action=topicLockUnLock&id=<?= $topic->getId() ?>" method="POST">
                <button type="submit" class="<?= $topic->getClosed()?"success":"error" ?>"><?= $topic->getClosed()?"Réouvrir":"Fermer" ?> le sujet</button>
            </form>
<?php
                    }
?>
        </div>
<?php
                }
                $count++;
            }
        }
?>
    </div>
<?php
    }