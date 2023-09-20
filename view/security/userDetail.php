<h2>Détail de l'utilisateur</h2>

<?php
    /**
     * VUE DU DÉTAIL DE L'UTILISATEUR
     */
    if( isset( $result["data"]['user'] ) ) $user = $result["data"]['user'];
    if( isset( $result["data"]['posts'] ) ) $posts = $result["data"]['posts'];
    if( isset( $result["data"]['topics'] ) ) $topics = $result["data"]['topics'];
    if( isset( $result["data"]['postLikes'] ) ) $postLikes = $result["data"]['postLikes'];
    if( isset( $result["data"]['topicLikes'] ) ) $topicLikes = $result["data"]['topicLikes'];
    if( (isset($user)&&$user) && ( $user == App\Session::getUSer() ) && ($user->getBanned() ) ) 
    {
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
    // Si on est administrateur et qu'on est différent du user dont on affiche le détail
    if( App\Session::isAdmin() && ( ! ((isset($user)&&$user)&&($user==App\Session::getUser())) ) ) 
    {
?>
    <!-- BOUTON pour bannir/débannir -->
    <form action="./?ctrl=security&action=userBannUnbann&id=<?= (isset($user)&&$user)?$user->getId():0 ?>" method="POST">
        <button type="submit" class="<?= ((isset($user)&&$user)&&$user->getBanned()) ? "success":"error" ?>"><?= ((isset($user)&&$user)&&$user->getBanned()) ? "Unb":"B" ?>ann</button>
    </form>
<?php
    }
    // Si on est le user dont on affiche le détail
    if( isset( $user ) && $user && ( $user == App\Session::getUser() ) )
    {
?>
    <!-- BOUTON pour modifier le mot de passe -->
    <form action="./?ctrl=security&action=passwordModifyForm" method="POST">
        <button type="submit">Modifier le mot de passe ...</button>
    </form>
<?php
    }
?>
</figure>
<?php
    // Si il y a bien des topics
    if( isset( $topics ) && $topics ) 
    {
?>
<h3>Liste de sujets créés</h3>
<ul class="card">
<?php
        // On boucle sur les topics
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
    // Si il y a bien des posts
    if( isset( $posts ) && $posts ) 
    {
?>
<h3>Liste des posts</h3>
<ul class="card">
<?php
        // On boucle sur les posts
        foreach( $posts as $post ) {
?>
    <li><a href="./?ctrl=forum&action=topicDetail&id=<?= $post->getTopic()->getId() ?>"><?= $post->getMessage() ?><?= $post->getTopic()->getClosed() ? " <sub><img src='./img/cadenas.webp' alt='Sujet fermé' class='cadenas'/></sub>" : "" ?></a></li>
<?php
        }
?>
</ul>
<?php
    }
    // Si il y a bien des likes de topic
    if( isset( $topicLikes ) && $topicLikes ) 
    {
?>
<h3>Liste de sujets Likés</h3>
<ul class="card">
<?php
        // On boucle sur les likes de topic
        foreach( $topicLikes as $like ) 
        {
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
    // Si il y a bien des likes de post
    if( isset( $postLikes )&& $postLikes ) 
    {
?>
<h3>Liste de posts Likés</h3>
<ul class="card">
<?php
        // On boucle sur les likes de post
        foreach( $postLikes as $like ) {
?>
    <li><a href="./?ctrl=forum&action=topicDetail&id=<?= $like->getPost() ? $like->getPost()->getTopic()->getId() : 0 ?>"><?= $like->getPost() ? $like->getPost()->getMessage() : "" ?><?= $like->getPost()->getTopic()->getClosed() ? " <sub><img src='./img/cadenas.webp' alt='Sujet fermé' class='cadenas'/></sub>" : "" ?></a></li>
<?php
        }
?>
</ul>
<?php
    }