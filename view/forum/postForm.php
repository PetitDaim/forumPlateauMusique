<?php
    if( isset($result["data"]['topic']) ) $topic = $result["data"]['topic'];
    if( isset($result["data"]['post']) ) $post = $result["data"]['post'];
?>
    <!-- Titre de la page : Ajout de sujet... -->
    <h2>Ajouter un post au sujet : <?= isset($topic)?$topic->getTitle():"" ?></h2>

    <div class="card">
        <!-- Formulaire d'ajout de sujet... -->
        <form action="./?ctrl=forum&action=post&id=<?= isset($topic)?$topic->getId():0 ?>" method="POST">

            <!-- Demande le message du post du sujet -->
            <label for="message">Message : </label>
            <textarea name="message" id="message"><?= isset($post)?$post->getMessage():"" ?></textarea>

            <!-- Bouton d'envoi -->
            <button type="submit">Poster le message</button>
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
?>
    </div>