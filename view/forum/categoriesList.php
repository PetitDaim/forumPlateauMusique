<?php
    if( isset( $result["data"]['categories'] ) ) $categories = $result["data"]['categories'];
?>

<h2>liste des catégories</h2>
<div class="flex-row">

<?php
    if( isset($categories) ) {
        foreach($categories as $category ){
?>
    <div class="card width-500">
        <h3>
            <?= $category->getCategoryName() ?>
        </h3>
        <!-- BOUTON pour voir le détail de la catégorie -->
        <form action="./?ctrl=forum&action=categoryDetail&id=<?= $category->getId() ?>" method="POST">
            <button type="submit">
                Voir la liste des sujets
                <small>
                    (<?= $category->getTopicsCount() ?>)
                </small>
            </button>
        </form>
        <!-- BOUTON pour ajouter un sujet à la catégorie -->
        <form action="./?ctrl=forum&action=topicAddForm&id=<?= $category->getId() ?>" method="POST">
            <button type="submit">Ajouter <?= $category->getCategoryNameSingulier() ?></button>
        </form>
<?php
            if( App\Session::isAdmin() ) {
?>
        <!-- BOUTON pour supprimer la catégorie -->
        <form action="./?ctrl=forum&action=categoryDelete&id=<?= $category->getId() ?>" method="POST">
            <button type="submit" class="error">Supprimer la catégorie</button>
        </form>
<?php
            }
?>
    </div>
<?php
        }
    }
    if( App\Session::isAdmin() ) {
?>
    <!-- BOUTON pour ajouter une catégorie -->
    <form class="card width-500" action="./?ctrl=forum&action=categoryAddForm" method="POST">
        <button type="submit">Ajouter une catégorie</button>
    </form>
<?php
    }
?>
</div>