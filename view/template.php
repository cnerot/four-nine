<!DOCTYPE html>
<html lang="fr">
<?php
const DEFAULT_TITLE = 'TechFinder';

$params = array_merge([
    'connected' => isset($connected) ? $connected : false,
    'title' => isset($title) ? $title : DEFAULT_TITLE,
    'styles' => isset($styles) ? $styles : []
], (isset($params) ? $params : []));

$params['styles'] = array_merge(['reset', 'style'], $params['styles']);
if ($params['title'] != DEFAULT_TITLE) {
    $params['title'] .= ' - ' . DEFAULT_TITLE;
}
?>
<head>
    <title><?php echo $params['title']; ?></title>

    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="/media/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/media/css/style.css" />
    <?php foreach ($params['styles'] as $style): ?>
        <link rel="stylesheet" href="/media/css/<?php echo $style; ?>.css">
    <?php endforeach; ?>
</head>
<body class="body">
<div class="container">
    <div class="row">
        <div class="col-xs-8 col-sm-offset-2">
            <header>
                <div>
                    <h3>Pardon-Maman</h3>
                    <a href="">Admin</a>
                </div>
                <div class="panel-over"></div>
                <img class="img_header" src="/media/images/header.png" alt="l'entete de la page"></img>
                <nav class="navbar navbar-inverse">
                    <ul class="nav navbar-nav ">
                        <li class="active"><a href="index.php">Accueil<span class="sr-only">(current)</span></a></li>
                    </ul>
                </nav>

            </header>
            <?php include $this->view; ?>
            <footer class="panel-footer">
                <p class="footer"> CGU - POLITIQUE DE CONFIDENTUALITE - Condition d'utilisation - contactez nous &copy;</p>
            </footer>
        </div>
    </div>
</div>
<script src="../media/js/jquery-3.1.1.min.js"></script>
<script src="../media/js/bootstrap.js"></script>
</body>
</html>
