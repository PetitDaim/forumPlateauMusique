<?php
    if( isset($result["data"]['post']) ) $post = $result["data"]['post'];
    if( isset( $post ) ) $category = $post->getTopic()->getCategory();
    else if( isset( $result["data"]["category"] ) ) $category = $result["data"]["category"];
?>
    <!-- Titre de la page : Ajout de sujet... -->
    <h2>Ajouter un sujet à la catégorie : <?= isset($category)?$category->getCategoryName():"" ?></h2>

    <!-- Rappel des règles de la catégorie... -->
    <p class="card">
        <?= isset($category)?$category->getPresentation():"" ?>
    </p>

    <!-- Formulaire d'ajout de sujet... -->
    <form action="./?ctrl=forum&action=topicAdd&id=<?= isset($category)?$category->getId():0 ?>" method="POST" class="card" enctype='multipart/form-data'>

        <!-- Demande le titre du sujet -->
        <label for="title">Titre du sujet : </label>
        <input type="text" name="title" id="title" value="<?= isset($post)?$post->getTopic()->getTitle():"" ?>">

        <!-- Demande le message du premier post du sujet -->
        <label for="message">Message : </label>
        <textarea name="message" id="message"><?= isset($post)?$post->getMessage():"" ?></textarea>

        <!-- Demande la description des médias -->
        <label for="mediaDescription">Description des médias</label>
        <input type="text" name="mediaDescription" id="mediaDescription" value="<?= isset($media)?$media->getMediaDescription():"" ?>">

        <!-- Demande le micro-fichier (visible dans la liste des sujets) -->
        <label for="tinyMediaFile">Micro-Média (visible dans la liste des sujets) : </label>
        <input type="file" name="tinyMediaFile" id="tinyMediaFile" value="<?= isset($media)?$media->getTinyName():"" ?>">

        <!-- Demande le fichier-moyen (visible dans le détail du sujet) -->
        <label for="mediumMediaFile">Médium-Média (visible dans le détail du sujet) : </label>
        <input type="file" name="mediumMediaFile" id="mediumMediaFile" value="<?= isset($media)?$media->getMediumName():"" ?>">

        <!-- Demande le gros-fichier (visible uniquement si achat du média) -->
        <label for="bigMediaFile">Gros-Média (visible uniquement si achat du média) : </label>
        <input type="file" name="bigMediaFile" id="bigMediaFile" value="<?= isset($media)?$media->getBigName():"" ?>">

        <!-- Bouton d'envoi -->
        <button type="submit">Poster le sujet</button>
    </form>
<?php
    if(isset( $topic ) && $topic->getId() ) {
?>
    <form action="./?ctrl=forum&action=topicDetail&id=<?= $topic->getId() ?>" method="post" class="card">
        <!-- Bouton d'envoi -->
        <button type="submit">Voir le détail du sujet</button>
    </form>
<?php
    }