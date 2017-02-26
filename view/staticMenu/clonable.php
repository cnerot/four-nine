<?php 
$themeApplicated = (new Theme())->getOneWhere(['applicated'=>true]);
$darkTab = array('brown darken-2',
                 'brown darken-4',
                 'grey darken-4',
                 'grey darken-3',
                 'grey darken-2',
                 'indigo darken-4',
                 'deep-orange darken-4',
                 'grey',
                 'black',);
if(in_array($themeApplicated->getCollapsibleHeader(),$darkTab)){
    $colorText = "white-text";
}else{
    $colorText = "black-text"; 
}

?>
<li>
    <div class="collapsible-header <?php echo $themeApplicated->getCollapsibleHeader() . ' '. $colorText; ?>">
        <i class="material-icons">description</i>
        <?php echo (isset($page)) ? $page->getTitle() : "New Page"; ?>
    </div>
    <div class="collapsible-body <?php echo $themeApplicated->getCollapsibleBody(); ?>">
        <div class="container">
            <div class="right">
<?php if (isset($page)): ?>
                <a href="<?php echo Router::getUrl('Pages','delete', ["id"=> $page->getID()])?>" class="btn-floating btn-small waves-effect waves-light red">
                    <i class="material-icons center-align">delete</i>
                </a>
<?php endif; ?>
            </div>
            <?php
            if (isset($page)) {
                $data = [
                    'title' => $page->getTitle(),
                    'content' => $page->getContent()
                ];
                $form->display($page->getId(), $data);
            } else {
                $form->display();
            }
            ?>
            <!--
            <input type="text" id="input_text_stat" class="" placeholder="Titre de la page" value="<?php echo (isset($page)) ? $page->getTitle() : ""; ?>">
            <textarea class="textarea_stat" rows="10" id="comment" placeholder="Contenur de la page"><?php echo (isset($page)) ? $page->getContent() : ""; ?></textarea>
            -->
        </div>
    </div>
</li>
