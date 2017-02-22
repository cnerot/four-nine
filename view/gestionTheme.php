    <div class="container">
        <div class="row">    
            <div class="col s12 p_pageStat <?php echo $themeApplicated->getPageStat(); ?>">
                <p>Créer un nouveau théme</p>
            </div>
                <div class="top-5 margin-top">
                   <?php  
                        $themeChoice->display('', '', 2);
                    ?>
                </div>
                <div class="top-5 margin-top">
                   <?php  
                        $theme->display();
                    ?>

                </div>
        </div>         
    </div>

 