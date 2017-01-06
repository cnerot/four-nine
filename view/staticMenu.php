<div class="container">
    <div class="row">
        <div class="col s12 p_pageStat">
            <p>Création des pages statiques</p>
        </div>
        <div class="col s12 margin-top">
            <a class="btn-floating btn-large green lighten-1 right" id='static-container-button'><i class="large material-icons">add</i></a>
        </div>
        <div class="col s12">
            <ul class="collapsible popout" id='static-container' data-collapsible="accordion">
                <?php foreach ($pages as $page) {
                    $this->getChild('clonable', ['page' => $page, 'form' => $form]);
                } ?>

            </ul>
        </div>
    </div>
</div>
