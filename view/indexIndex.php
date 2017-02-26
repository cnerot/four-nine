<div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
        <div class="container">
            <br><br>
            <h1 class="header center <?php echo $themeApplicated->getTitleColor(); ?>">concours photo</h1>
            <div class="row center">

                <?php if (!empty($contestCurrent)) : ?>
                    <h5 class="header col s12 <?php echo $themeApplicated->getTextColor(); ?> light">Lot à gagner en
                        participant au concours</h5>

                    <h5 class="header col s12 <?php echo $themeApplicated->getTextColor(); ?> light">Lot à gagner en
                        participant au concours <?php echo $contestCurrent->name; ?></h5>
                    <label class="header col s12 <?php echo $themeApplicated->getTextColor(); ?> light">
                        <?php echo $contestCurrent->description; ?>
                    </label>
                    <p class="header col s12 <?php echo $themeApplicated->getTextColor(); ?> light">
                        Le concours a lieu du <span class="dateFR"><?php echo $contestCurrent->start; ?></span> au <span
                            class="dateFR"><?php echo $contestCurrent->end; ?></span>
                    </p>
                    <img style="width: 20vw;" src="<?php echo (new Photo())->getFbPhotoUrlFromID($contestCurrent->getPhoto()); ?>">

                <?php endif; ?>

                <?php foreach ($err as $error) : ?>
                    <div class="header col s12 <?php echo $themeApplicated->getTextColor(); ?> ">
                        <h2><?php echo $error; ?></h2>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="row center">
                <a href="<?php echo Router::getUrl("Photo", "index"); ?>"
                   id="download-button"
                   class="btn-large waves-effect waves-light <?php
                   echo $themeApplicated->getBtnColor() . ' ' . $themeApplicated->getTextBtnColor(); ?>">Je participe <i
                        class="material-icons right">play_arrow</i></a>
                <a href="<?php echo Router::getUrl("Vote", "vote"); ?>"
                   id="download-button"
                   class="btn-large waves-effect waves-light <?php
                   echo $themeApplicated->getBtnColor() . ' ' . $themeApplicated->getTextBtnColor(); ?>">Je vote <i
                        class="material-icons right">play_arrow</i></a>
            </div>
            <br><br>

        </div>
    </div>
    <div class="parallax"><img src="<?php if ($themeApplicated->getBgImage()) {
            echo $themeApplicated->getBgImage();
        } else {
            echo "/media/images/test1.jpg";
        }
        ?>"
                               alt="Unsplashed background img 1">
    </div>
</div>
