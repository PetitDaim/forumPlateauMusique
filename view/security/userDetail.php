<h2>Détail de l'utilisateur</h2>

<?php
    if( isset( $result["data"]['user'] ) ) $user = $result["data"]['user'];
    if( isset( $result["data"]['posts'] ) ) $posts = $result["data"]['posts'];
    if( isset( $result["data"]['topics'] ) ) $topics = $result["data"]['topics'];
    if( isset( $result["data"]['postLikes'] ) ) $postLikes = $result["data"]['postLikes'];
    if( isset( $result["data"]['topicLikes'] ) ) $topicLikes = $result["data"]['topicLikes'];
    if( (isset($user)&&$user) && ( $user == App\Session::getUSer() ) && ($user->getBanned() ) ) {
?>
<p class="error padding-5">
    <a href="./?ctrl=security&action=mailToAdminForm">
        Vous avez été banni, Merci de contacter l'administrateur du Forum de Musique...
    </a>
</p>
<?php
    }
?>
<figure class="card">
    <img src="<?= (isset($user)&&$user)?$user->getAvatar():"./img/Users/undefinedUserImg.jpg" ?>" alt="<?= (isset($user)&&$user)?$user->getPseudo():"" ?>"/>
    <figcaption><?= (isset($user)&&$user)?$user->getPseudo():"" ?><?= ((isset($user)&&$user) && ( $user == App\Session::getUser() ) )? " : &lt;".$user->getEmail()."&gt;" : "" ?></figcaption>
<?php
    if( App\Session::isAdmin() ) {
?>
    <form action="./?ctrl=security&action=user<?= ((isset($user)&&$user)&&$user->getBanned()) ? "Unb":"B" ?>ann&id=<?= (isset($user)&&$user)?$user->getId():0 ?>" method="POST">
        <button type="submit" class="<?= ((isset($user)&&$user)&&$user->getBanned()) ? "success":"error" ?>"><?= ((isset($user)&&$user)&&$user->getBanned()) ? "Unb":"B" ?>ann</button>
    </form>
<?php
    }
?>
</figure>
<?php
    if( isset( $topics ) && $topics ) {
?>
<h3>Liste de sujets créés</h3>
<ul class="card">
<?php
        foreach( $topics as $topic ) {
?>
    <li>
        <a href="./?ctrl=forum&action=topicDetail&id=<?= $topic->getId() ?>"><?= $topic->getTitle() ?><?= $topic->getClosed() ? " <sub><img src='./img/cadenas.webp' alt='Sujet fermé' class='cadenas'/></sub>" : "" ?></a>
    </li>
<?php
        }
?>
</ul>
<?php
    }
    if( isset( $posts ) && $posts ) {
?>
<h3>Liste des posts</h3>
<ul class="card">
<?php
        foreach( $posts as $post ) {
?>
    <li><a href="./?ctrl=forum&action=topicDetail&id=<?= $post->getTopic()->getId() ?>"><?= $post->getMessage() ?><?= $post->getTopic()->getClosed() ? " <sub><img src='./img/cadenas.webp' alt='Sujet fermé' class='cadenas'/></sub>" : "" ?></a></li>
<?php
        }
?>
</ul>
<?php
    }
    if( isset( $topicLikes ) && $topicLikes ) {
?>
<h3>Liste de sujets Likés</h3>
<ul class="card">
<?php
        foreach( $topicLikes as $like ) {
?>
    <li>
        <a href="./?ctrl=forum&action=topicDetail&id=<?= $like->getTopic() ? $like->getTopic()->getId() : 0 ?>"><?= $like->getTopic() ? $like->getTopic()->getTitle() : "" ?><?= ( $like->getTopic() && $like->getTopic()->getClosed() ) ? ' <img src="./img/cadenas.webp" alt="Sujet fermé" class="cadenas"/>' :"" ?></a>
    </li>
<?php
        }
?>
</ul>
<?php
    }
    if( isset( $postLikes )&& $postLikes ) {
?>
<h3>Liste de posts Likés</h3>
<ul class="card">
<?php
        foreach( $postLikes as $like ) {
?>
    <li><a href="./?ctrl=forum&action=topicDetail&id=<?= $like->getPost() ? $like->getPost()->getTopic()->getId() : 0 ?>"><?= $like->getPost() ? $like->getPost()->getMessage() : "" ?><?= $like->getPost()->getTopic()->getClosed() ? " <sub><img src='./img/cadenas.webp' alt='Sujet fermé' class='cadenas'/></sub>" : "" ?></a></li>
<?php
        }
?>
</ul>
<?php
    }