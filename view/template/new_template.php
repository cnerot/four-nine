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
?>
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="<?php echo Config::CSS_DIR; ?>/reset.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Config::CSS_DIR; ?>/new_style.css"/>
    <?php foreach ($params['styles'] as $style): ?>
        <link rel="stylesheet" href="/media/css/<?php echo $style; ?>.css">
    <?php endforeach; ?>
</head>
<body>
<div class="body">
    <header>
        <div class="header-top">
            <div class="logo">
                <p>Pardon Maman</p>
            </div>
            <div class="admin">
                <div class="admin-main"><a href="">Admin</a></div>
                <div class="admin-dropdown">
                    <div class="admin-dropdown-link">Link</div>
                    <div class="admin-dropdown-link">Link</div>
                </div>
            </div>
        </div>
        <div class="header-center"></div>
        <div class="header-bottom">
            <nav>
                <ul>
                    <li><a href="">Accueil</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="content">
        <?php include $this->view; ?>
    </div>
</div>
<footer>
    <div class="footer">
        <div class="footer-links">
            <div class="footer-link">
                <a>bfkjbv eofv</a>
            </div>
            <div class="footer-link">
                <a>bfkjbv eofv </a>
            </div>
            <div class="footer-link">
                <a>bfkjbv eofv </a>
            </div>
            <div class="footer-link">
                <a>bfkjbv eofv </a>
            </div>
            <div class="footer-link">
                <a>bfkjbv eofv </a>
            </div>
            <div class="footer-link">
                <a>bfkjbv eofv </a>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
