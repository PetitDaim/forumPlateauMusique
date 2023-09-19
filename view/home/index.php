<?php
    if( isset( $result["data"]['categories'] ) ) $categories = $result["data"]['categories'];
?>

<h2>Bienvenue sur le <strong>forum</strong> de <strong>musique</strong></h2>
<p class="presentation">
    Bonjour, vous trouverez sur ce forum un certain nombre de catégories de publication que nous vous prions de respecter pour vos publications.<br>
    Ainsi, chacun poura trouver les informations que vous publiez, de façon logique, d'après la catégorie dans laquelle vous l'avez placée...
</p>
<h2>liste des catégories</h2>
<div class="flex-row">

<?php
    if( isset($categories) ) {
        foreach($categories as $category ){
?>
    <div class="card width-500">
        <h3>
            <strong><?= $category->getCategoryName() ?></strong>
        </h3>
        <form action="./?ctrl=forum&action=categoryDetail&id=<?= $category->getId() ?>" method="POST">
            <button type="submit">
                Voir la liste des sujets
                <small>
                    (<?= $category->getTopicsCount() ?>)
                </small>
            </button>
        </form>
        <form action="./?ctrl=forum&action=topicAddForm&id=<?= $category->getId() ?>" method="POST">
            <button type="submit">Ajouter <?= $category->getCategoryNameSingulier() ?></button>
        </form>
<?php
            if( App\Session::isAdmin() ) {
?>
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
    <form class="card width-500" action="./?ctrl=forum&action=categoryAddForm" method="POST">
        <button type="submit">Ajouter une catégorie</button>
    </form>
<?php
    }
?>
</div>