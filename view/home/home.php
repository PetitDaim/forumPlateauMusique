<?php
    if( isset( $result["data"]['categories'] ) ) $categories = $result["data"]['categories'];
?>

<h2>Bienvenue sur le <strong>forum de musique</strong></h2>
<p class="presentation">
    Bonjour, vous trouverez sur ce forum un certain nombre de catégories de publication que nous vous prions de respecter pour vos publications.<br>
    Ainsi, chacun poura trouver les informations que vous publiez, de façon logique, d'après la catégorie dans laquelle vous l'avez placée...
</p>
<h2>liste des catégories</h2>
<div class="flex-row">

<?php
    // Vérifie si il y a bien une liste de catégories
    if( isset($categories) ) 
    {
        // Boucle sur la liste de catégories
        foreach($categories as $category )
        {
?>
    <div class="card width-500">
        <!-- Titre de la catégorie -->
        <h3>
            <strong><?= $category->getCategoryName() ?></strong>
        </h3>
        <!-- BOUTON pour voir la liste des sujets d'une catégorie -->
        <form action="./?ctrl=forum&action=categoryDetail&id=<?= $category->getId() ?>" method="POST">
            <button type="submit">
                Voir la liste des sujets
                <small>
                    (<?= $category->getTopicsCount() ?>)
                </small>
            </button>
        </form>
<?php
            // Vérifie que l'utilisateur connecté est un artiste
            if( App\Session::isArtist() ) 
            {
?>
        <!-- BOUTON pour ajouter un sujet -->
        <form action="./?ctrl=forum&action=topicAddForm&id=<?= $category->getId() ?>" method="POST">
            <button type="submit">Ajouter <?= $category->getCategoryNameSingulier() ?></button>
        </form>
<?php
            }
            if( App\Session::isAdmin() ) 
            {
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
    <form class="card width-500" action="./?ctrl=forum&action=categoryAddForm" method="POST">
        <button type="submit">Ajouter une catégorie</button>
    </form>
<?php
    }
?>
</div>