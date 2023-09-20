<!DOCTYPE html>
<html lang="en">
    <!-- Head du fichier html de sortie -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?= isset($result["data"]['description']) ? $result["data"]['description'] : "Forum de musique ayant pour but de présenter des artistes souhaitant émerger" ?>">
        <meta name="title" content="<?= isset( $result["data"]['title'] ) ? $result["data"]['title'] : "Forum de Musique" ?>">
        <meta name="robots" content="<?= isset( $result["data"]['noIndex'] ) ? "noindex, nofollow" : "index, follow" ?>">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="shortcut icon" href="./img/logo.jpg" type="image/x-icon">
        <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
        <link rel="stylesheet" href="<?= PUBLIC_DIR ?>css/style.css">
        <title>Forum de Musique</title>
    </head>
    <!-- Corps du fichier html de sortie -->
    <body>
        <div id="wrapper"> 
<?php
    if( isset( $_GET["recherche"] ) ) {
        $recherche = filter_input( INPUT_GET, "recherche", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    }
?>       
            <div id="mainpage">
                <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
                <h3 class="message error"><?= App\Session::getFlash("error") ?></h3>
                <h3 class="message success"><?= App\Session::getFlash("success") ?></h3>
                <!-- Header du fichier html de sortie -->
                <header>
                    <div class="flex-row between">
                        <figure class="logo">
                            <img src="./img/logo.jpg" alt="Logo clef de sol" class="logo">
                        </figure>
                        <h1>Forum de Musique</h1>
                        <figure class="login">
                            <img src="<?= (App\Session::getUser()) ? App\Session::getUser()->getAvatar() : "./img/logo.jpg" ?>" alt="Logo clef de sol" class="login">
                        </figure>
                    </div>
                    <!-- MENU -->
                    <div id="burger-menu">
                            <img src="./img/burgerMenu.png" alt="Burger menu" class="burger-menu" width="50px"/>
                    </div>
                    <nav id="nav-bar">
                        <div id="nav-left">
                            <a href="./">Accueil</a>
                            <a href="./?ctrl=forum&action=topicsList">Dix derniers sujets</a>
                            <form action="./" method="get" class="center">
                                <input type="text" name="recherche" id="recherche" placeholder="Rechercher dans les sujets" value="<?=isset( $recherche ) ? $recherche : "" ?>">
                            </form>
<?php
    // Si l'utilisateur connecté est admin
    if(App\Session::isAdmin()){
?>
                            <a href="./?ctrl=security&action=usersList">liste des utilisateurs</a>
                            
<?php
    }
?>
                        </div>
                        <img src="./img/close.png" alt="Close Menu" id="close-menu-boutton"/>
                        <div id="nav-right">
<?php
    // Si l'utilisateur connecté est admin et qu'il y a des messages pour l'admin
    if(App\Session::isAdmin() && (new Model\Managers\MessageManager)->findAll() ) {
?>
                                <a href="./?ctrl=security&action=messagesList"><sub><img src="./img/mail.png" alt="Messages" class="mail"/></sub>&nbsp;Messages</a>
<?php
    }
    // Si un utilisateur est connecté
    if(App\Session::getUser()){
?>
                                <a href="./?ctrl=security&action=userDetail&id=<?= App\Session::getUser()->getId() ?>"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser()?></a>
                                <a href="./?ctrl=security&action=logout">déconnection</a>
<?php
    }
    // Sinon
    else{
?>
                                <a href="./?ctrl=security&action=loginForm">connection</a>
                                <a href="./?ctrl=security&action=registerForm">Inscription</a>
<?php
    }
?>
                        </div>
                    </nav>
                </header>
                
                <!-- Main du fichier html de sortie (page) -->
                <main id="forum">
                    <?= $page ?>
                </main>
            </div>
            <!-- Footer du fichier html de sortie -->
            <footer>
                &copy; 2023 - Forum Musique  <a href="./?ctrl=home&action=forumRules">Règlement du forum</a> <a href="./?ctrl=home&action=mentionsLegales">Mentions légales</a>
                <!-- <button id="ajaxbtn">Surprise en Ajax !</button> -> cliqué <span id="nbajax">0</span> fois -->
            </footer>
        </div>
        <script src="./js/script.js">
        </script>
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
        </script>
        <script>

            $(document).ready(function(){
                $(".message").each(function(){
                    if($(this).text().length > 0){
                        $(this).slideDown(500, function(){
                            $(this).delay(3000).slideUp(500)
                        })
                    }
                })
                $(".delete-btn").on("click", function(){
                    return confirm("Etes-vous sûr de vouloir supprimer?")
                })
                tinymce.init({
                    selector: '.post',
                    menubar: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                    content_css: '//www.tiny.cloud/css/codepen.min.css'
                });
            })


            // on teste les click sur la bouton ajaxbtn
            $("#ajaxbtn").on("click", function(){
                $.get(
                    "./?action=ajax",
                    {
                        // On récupère la vaeur de nb
                        nb : $("#nbajax").text()
                    },
                    function(result){
                        $("#nbajax").html(result)
                    }
                )
            })

            // on teste les key up sur la barre de recherche
            $("#recherche").on("keyup", function(){
                $.get(
                    "./?action=search",
                    {
                        // On récupère la valeur de recherche
                        recherche : $("#recherche").val()
                    },
                    function(result){
                        $("#forum").html(result)
                    }
                )
            })
        </script>
    </body>
</html>