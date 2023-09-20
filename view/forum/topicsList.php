<?php
    /**
     * VUE DE LA LISTE DES TOPICS
     */
    if( isset( $result["data"]['topics'] ) ) $topics = $result["data"]['topics'];
    if( isset( $result["data"]['category'] ) ) $category = $result["data"]['category'];
    if( isset( $result["data"]['title'] ) ) $title = $result["data"]['title'];
?>

<h2>Liste des <?= isset( $category ) ? $category->getCategoryName() : ( isset($title) ? $title : "≤ 10 derniers sujets postés") ?></h2>
<div class="flex-row between">

<?php
    // Si on a bien une catégorie
    if( isset( $category ) ) 
    {
?>
<div class="card max-width-300">
    <?= $category->getPresentation() ?>
<?php
        // Si on est connecté, qu'on est pas banni et qu'on est artiste
        if( ( App\Session::getUser() ) && ( ! App\Session::getUser()->getBanned() ) && App\Session::isArtist() ) 
        {
?>
    <!-- BOUTON pour ajouter un topic -->
    <form action="./?ctrl=forum&action=topicAddForm&id=<?= $category->getId() ?>" method="POST">
        <button type="submit">Poster <?= $category->getCategoryNameSingulier() ?></button>
    </form>
<?php
        }
?>
</div>
<?php
    }

    // Si il y a des topics
    if( isset($topics) ) {
        // On boucle sur les topics
        foreach($topics as $topic ){
?>
    <form action="./?ctrl=forum&action=topicDetail&id=<?= $topic->getID() ?>" method="POST" class="card">
        <!-- On affiche le média du topic -->
        <?=$topic->getTitle()?>, <?php ($topic->getMedia())->showMedia(); ?>
        <!-- BOUTON pour voir le détail du sujet -->
        <button type="submit">Consulter le sujet<?= $topic->getClosed() ? " <sub><img src='./img/cadenas.webp' alt='Sujet fermé' class='cadenas'/></sub>" : "" ?></button>
    </form>
<?php
        }
    }
?>
</div>