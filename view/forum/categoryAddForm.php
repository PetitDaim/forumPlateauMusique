<?php
    if( isset($result["data"]['category']) ) $category = $result["data"]['category'];
?>

    <h2>Ajouter une catégorie :</h2>
    <form action="./?ctrl=forum&action=categoryAdd" method="POST" class="card">
        <label for="categoryName">Nom de la catégorie : </label>
        <input type="text" name="categoryName" id="categoryName" value="<?= isset($category)?$category->getCategoryName():"" ?>">
        <label for="categoryNameSingulier">Nom au singulier de la catégorie : </label>
        <input type="text" name="categoryNameSingulier" id="categoryNameSingulier" value="<?= isset($category)?$category->getCategoryNameSingulier():"" ?>">
        <label for="presentation">Présentation de la catégorie : </label>
        <input type="text" name="presentation" id="presentation" value="<?= isset($category)?$category->getPresentation():"" ?>">
        <button type="submit">Ajouter la catégorie</button>
    </form>