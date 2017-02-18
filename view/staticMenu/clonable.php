<li>
    <div class="collapsible-header yellow">
        <i class="material-icons">description</i>
        <?php echo (isset($page)) ? $page->getTitle() : "New Page"; ?>
    </div>
    <div class="collapsible-body yellow">
        <div class="container">
            <div class="right">
                <a href="<?php echo Router::getUrl('Pages','delete', ["id"=> $page->getID()])?>" class="btn-floating btn-small waves-effect waves-light red">
                    <i class="material-icons center-align">delete</i>
                </a>
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