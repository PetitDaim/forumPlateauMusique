<?php
    if( isset( $result["data"]['topics'] ) ) $topics = $result["data"]['topics'];
    if( isset( $result["data"]['category'] ) ) $category = $result["data"]['category'];
    if( isset( $result["data"]['title'] ) ) $title = $result["data"]['title'];
?>

<h2>Liste des <?= isset( $category ) ? $category->getCategoryName() : ( isset($title) ? $title : "≤ 10 derniers sujets postés") ?></h2>
<div class="flex-row between">

<?php
    if( isset( $category ) ) {
?>
<div class="card max-width-300">
    <?= $category->getPresentation() ?>
<?php
        if( ( App\Session::getUser() ) && ( ! App\Session::getUser()->getBanned() ) && App\Session::isArtist() ) {
?>
    <form action="./?ctrl=forum&action=topicAddForm&id=<?= $category->getId() ?>" method="POST">
        <button type="submit">Poster <?= $category->getCategoryNameSingulier() ?></button>
    </form>
<?php
        }
?>
</div>
<?php
    }

    if( isset($topics) ) {
        foreach($topics as $topic ){
?>
    <form action="./?ctrl=forum&action=topicDetail&id=<?= $topic->getID() ?>" method="POST" class="card">
        <?=$topic->getTitle()?>, <?php ($topic->getMedia())->showMedia(); ?>
        <button type="submit">Consulter le sujet<?= $topic->getClosed() ? " <sub><img src='./img/cadenas.webp' alt='Sujet fermé' class='cadenas'/></sub>" : "" ?></button>
    </form>
<?php
        }
    }
?>
</div>