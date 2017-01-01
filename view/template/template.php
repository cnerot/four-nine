<!DOCTYPE html>
<html lang="fr">
<?php
const DEFAULT_TITLE = 'Pardon Maman';

$params = array_merge([
    'connected' => isset($connected) ? $connected : false,
    'title' => isset($title) ? $title : DEFAULT_TITLE,
    'styles' => isset($styles) ? $styles : []
], (isset($params) ? $params : []));

$params['styles'] = array_merge(['reset', 'style'], $params['styles']);
if ($params['title'] != DEFAULT_TITLE) {
    $params['title'] .= ' - ' . DEFAULT_TITLE;
}

/**
 * Initilise FB object
 */

$fb = new FBApp();
?>
<head>
    <title><?php echo $params['title']; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="/media/css/bootstrap.min.css" />
    <?php foreach ($params['styles'] as $style): ?>
        <link rel="stylesheet" href="/media/css/<?php echo $style; ?>.css">
    <?php endforeach; ?>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body class="body">
<?php $fb->printFBLogin("<div class='login_obligatory'><p>Please click anywhere to log in</p><img src='media/images/téléchargement.png'></div>", "<div class='logged_in'></div>")?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <header>
                <div class="header-top">
                    <div class="col-md-4"><h1 class="title">Pardon Maman</h1></div>
                    <div class="dropdown admin-link">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                          Administration
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                          <li><a href="<?php echo Router::getUrl("Concour","New");?>">Créer un concour</a></li>
                          <li><a href="<?php echo Router::getUrl("Concour","index");?>">Gestion des concours</a></li>
                          <li><a href="<?php echo Router::getUrl("Admin","index");?>">Pages statiques</a></li>
                        </ul>
                    </div>
                </div>
                <img class="img_header" src="/media/images/test.jpg" alt="l'entete de la page"></img>
                <img class="img_header" src="/media/images/test.jpg" alt="l'entete de la page"></img>
                <img class="img_header" src="/media/images/test.jpg" alt="l'entete de la page"></img>
                <div class="panel-over"></div>
               
                <nav class="navbar navbar-inverse">
                    <ul class="nav navbar-nav ">
                        <li class="active"><a href="<?php echo Router::getUrl("Index","Index");?>">Accueil<span class="sr-only">(current)</span></a></li>
                    </ul>
                </nav>
            </header>
            <article>
                <div>
                    <?php include $this->view; ?>
                </div>
            </article>
        </div>
         <div class="col-md-12">
            <footer class="panel-footer">
                <p class="footer">CGU - POLITIQUE DE CONFIDENTUALITE - Condition d'utilisation - contactez-nous &copy;</p>
            </footer>
         </div>
    </div>
</div>
<script src="/media/js/jquery-3.1.1.min.js"></script>
<script src="/media/js/bootstrap.min.js"></script>
<script src="/media/js/imageGallery.js"></script>
<script src="/media/js/script.js"></script>
</body>
</html>
