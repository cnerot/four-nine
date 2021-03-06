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

/**
 * Get Static pages
 */
$pages = (new Staticpages())->getWhere([]);

$themeApplicated = (new Theme())->getOneWhere(['applicated' => true]);
if (empty($themeApplicated)) {
    $themeApplicated = (new Theme())->getWhere(['name' => 'default']);
}
//a tester ici
?>
<head>
    <title><?php echo $params['title']; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/media/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <?php foreach ($params['styles'] as $style): ?>
        <link rel="stylesheet" href="/media/css/<?php echo $style; ?>.css">
    <?php endforeach; ?>
    <link href="/media/css/stars.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/media/css/gallery.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body class="<?php echo $themeApplicated->getBgColor(); ?>">
<?php //$fb->printFBLogin("<div class='login_obligatory'><p>Please click anywhere to log in</p><img src='media/images/téléchargement.png'></div>","<div class='logged_in'>LogOut</div>") ?>
<?php if (!$fb->isLogged()): ?>
    <a href="<?php echo $fb->getLoginUrl() ?>">
        <div class='login_obligatory'><p>Please click anywhere to log in</p><img src='media/images/téléchargement.png'>
        </div>
    </a>
<?php endif; ?>
<ul id="dropdown1" class="dropdown-content <?php echo $themeApplicated->getBgNavColor(); ?>">
    <li>
        <a href="<?php echo Router::getUrl("Concours", "New"); ?>">
            <span class="<?php echo $themeApplicated->getTextNavColor(); ?>">Créer un concours</span>
        </a>
    </li>
    <li>
        <a href="<?php echo Router::getUrl("Concours", "index"); ?>">
            <span class="<?php echo $themeApplicated->getTextNavColor(); ?>">Gestion des concours</span>
        </a>
    </li>
    <li class="divider"><span class="yellow-text text-darken-2"></span></li>
    <li>
        <a href="<?php echo Router::getUrl("Pages", "index"); ?>">
            <span class="<?php echo $themeApplicated->getTextNavColor(); ?>">Pages statiques</span>
        </a>
    <li>
        <a href="<?php echo Router::getUrl("Theme", "index"); ?>">
            <span class="<?php echo $themeApplicated->getTextNavColor(); ?>">Modifier le théme</span>
        </a>
    </li>
</ul>
<ul id="dropdown2" class="dropdown-content <?php echo $themeApplicated->getBgNavColor(); ?>">
    <li>
        <a href="<?php echo Router::getUrl("Concours", "New"); ?>">
            <span class="<?php echo $themeApplicated->getTextNavColor(); ?>">Créer un concours</span>
        </a>
    </li>
    <li>
        <a href="<?php echo Router::getUrl("Concours", "index"); ?>">
            <span class="<?php echo $themeApplicated->getTextNavColor(); ?>">Gestion des concours</span>
        </a>
    </li>
    <li class="divider"><span class="<?php echo $themeApplicated->getTextNavColor(); ?>"></span></li>
    <li>
        <a href="<?php echo Router::getUrl("Pages", "index"); ?>">
            <span class="<?php echo $themeApplicated->getTextNavColor(); ?>">Pages statiques</span>
        </a>
    </li>
    <li>
        <a href="<?php echo Router::getUrl("Theme", "index"); ?>">
            <span class="<?php echo $themeApplicated->getTextNavColor(); ?>">Modifier le théme</span>
        </a>
    </li>
</ul>
<nav class="<?php echo $themeApplicated->getBgNavColor(); ?>" role="navigation">
    <div class="nav-wrapper <?php echo $themeApplicated->getBgNavColor(); ?>">
        <div class="nav-wrapper container">
            <a id="logo-container" href="<?php echo Router::getUrl("Index", "Index"); ?>" class="brand-logo">
                <i class="material-icons left <?php echo $themeApplicated->getIconHomeColor(); ?>">home</i><span
                    class="<?php echo $themeApplicated->getNameColor(); ?> knockout">Pardon maman</span>
            </a>

            <?php if ($fb->isLogged()): ?>
                <div class="right">
                    <a href="<?php echo $fb->getLogoutUrl() ?>"><i
                            class="material-icons  <?php echo $themeApplicated->getIconOffColor(); ?>">power_settings_new</i></a>
                </div>
            <?php endif; ?>
            <?php if ($fb->isAdmin()): ?>
                <ul class="right hide-on-med-and-down">
                    <li><a class="dropdown-button" href="#!" data-activates="dropdown1"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Administrateur<span><i
                                        class="material-icons right">arrow_drop_down</i></a></li>
                </ul>
                <ul id="nav-mobile" class="side-nav">
                    <li><a class="dropdown-button" href="#!" data-activates="dropdown2">Admin<i
                                class="material-icons right">arrow_drop_down</i></a></li>
                </ul>
                <a href="#" data-activates="nav-mobile" class="button-collapse">
                    <i class="material-icons">menu</i>
                </a>
            <?php endif; ?>
        </div>
    </div>

</nav>
<article>
    <div>
        <?php include $this->view; ?>
    </div>
</article>
<footer class="page-footer <?php echo $themeApplicated->getBgNavColor(); ?>">
    <div class="container">
        <div class="row">
            <div class="col s10 ">
            </div>
            <div class="col s4 right">
                <ul>
                    <?php foreach ($pages as $page): ?>
                        <li><a class="<?php echo $themeApplicated->getTextNavColor(); ?>"
                               href="<?php echo Router::getUrl("pages", "show", ['id' => $page->getId()]) ?>"><?php echo strtoupper($page->getTitle()); ?></a>
                        </li>
                    <?php endforeach; ?>
                    <!--
                    <li><a class="yellow-text text-lighten-1" href="#!">CGU </a></li>
                    <li><a class="yellow-text text-lighten-1" href="#!">POLITIQUE DE CONFIDENTUALITE</a></li>
                    <li><a class="yellow-text text-lighten-1" href="#!">Condition d'utilisation</a></li>
                    <li><a class="yellow-text text-lighten-1" href="#!">Régles générales</a></li>
                    -->
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2017 Copyright Text
            <a class="right <?php echo $themeApplicated->getTextNavColor(); ?>" href="#!">Contactez-nous</a>
        </div>
    </div>
</footer>
<script>
    var alerts = [<?php
        if (isset($_SESSION['alert'])) {
            echo implode(',', $_SESSION['alert']);
            unset($_SESSION['alert']);
        }
    ?>];
</script>
<script type="text/javascript" src="/media/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="/media/js/materialize.js"></script>
<script src="/media/js/init.js"></script>
<script src="/media/js/script.js"></script>
<script src="/media/js/imageGallery.js"></script>
</body>
</html>
