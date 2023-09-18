<?php
    if( isset( $result["data"]['topic'] ) ) $topic = $result["data"]['topic'];
    if( isset( $result["data"]['posts'] ) ) $posts = $result["data"]['posts'];
    if( isset( $result["data"]['topicLike'] ) ) $topicLike = $result["data"]['topicLike'];
?>


<?php
    if( isset($topic) && $topic ) {
?>
    <h2>Détail du sujet : <?= $topic->getTitle() ?></h2>

    <div class="flex-row">
        <div class="card">
            <?php ($topic->getMedia())->showMedia('medium'); ?>
<?php
        if( isset( $posts ) ) {
            $count=0;
            foreach( $posts as $post ) {
                if( ! $post->getUser()->getBanned() ) {
                    if( $count ) {
?>
        <div class="card">
<?php
                    }
?>
            <p class="width-300 center">
                <?= $post->getMessage() ?>
                <figure>
                    <a href="./?ctrl=security&action=userDetail&id=<?= $post->getUser()->getId() ?>">
                        <img src="<?= $post->getUser()->getAvatar() ?>" alt="Avatar de <?= $post->getUser()->getPseudo() ?>" class="signature"/>
                    </a>
                    <figcaption><?= $post->getUser()->getPseudo() ?></figcaption>
                </figure>
<?php
                    if( App\Session::isAdmin() ) {
?>
                                    <form action="./?ctrl=security&action=userBann&id=<?= $post->getUser()->getId() ?>" method="POST">
                                        <button type="submit" class="error">Bannir le posteur du message</button>
                                    </form>
<?php
                    }
?>
            </p>
<?php
                    if( $count ) {
                        if( App\Session::getUser() ) {
?>
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
                if( ! $count ) {
                    if( App\Session::getUser() ) {
?>
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
                    if( ( ! $topic->getClosed() ) && App\Session::getUser() && ( ! App\Session::getUser()->getBanned() ) ) {
?>
            <form action="./?ctrl=forum&action=postForm&id=<?= $topic->getId() ?>" method="POST">
                <button type="submit">Commenter le sujet</button>
            </form>
<?php
                    }
                    if( ( App\Session::isAdmin() || ( App\Session::getUser() == $topic->getUser() ) ) ) {
?>
            <form action="./?ctrl=forum&action=topicLock&id=<?= $topic->getId() ?>" method="POST">
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