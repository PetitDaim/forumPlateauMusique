<?php
    $category = $result["data"]['category'];
?>

<?php
    if( isset($category) ) {
?>
    <h2>détail de la catégorie : <?= $category->getCategoryName() ?></h2>
    <p class="card">
        <?= $category->getPresentation() ?>
    </p>
    <form action="./?ctrl=forum&action=topicsList&id=<?= $category->getId() ?>" method="POST">
        <button type="submit">Voir la liste des <?= $category->getCategoryName() ?> <small>(<?= $category->getTopicsCount() ?>)</small></button>
    </form>
<?php
        if( ( App\Session::getUser() ) && ( ! App\Session::getUser()->getBanned() ) ) {
?>
    <form action="./?ctrl=forum&action=topicAddForm&id=<?= $category->getId() ?>" method="POST">
        <button type="submit">Poster <?= $category->getCategoryNameSingulier() ?></button>
    </form>
<?php
        }
    }