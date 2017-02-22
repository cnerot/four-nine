<div class="container">
    <div class="row">
        <div class="col s12 p_pageStat <?php echo $themeApplicated->getPageStat(); ?>">
            <p>Photos des participants au concours <?php echo $contestCurrent->name; ?></p>
            <p>(concours valable du <?php echo $contestCurrent->start; ?> au <?php echo $contestCurrent->end; ?>
                )</span></p>
        </div>
        <?php if (empty($listPhotos)) : ?>
            <div style="margin-bottom: 10px" class="center">
                <p class="<?php echo $themeApplicated->getTextColor(); ?>"">Aucune photo n'a encore été uploadée</label>
            </div>
        <?php else : ?>
            <div class=" col s12 panelGalerie p_pageStat">

                <?php foreach ($listPhotos as $photo) : ?>
                    <div class="col s3" name="image_div" data-source="<?php echo $photo['source']; ?>" data-link="<?php echo $photo['link_id']; ?>">
                        <div id="imageGallery">
                            <a id="<?php echo $photo['id']; ?>">
                                <img src="<?php echo $photo['source']; ?>" width="100" alt="" class="top-5" title="">
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>
        <div class="col s12">
            <input type="hidden" id="nbPhotosToDisp" value="8">
            <?php if (!empty($listPhotos)) : ?>
                <input type="button" id="seeMorePhotos" value="Voir +" class="btn right top-5">
            <?php endif; ?>
        </div>

    </div>
    <div id="overlay" style="display: none;">
        <div id="closeLightbox" onclick="hideoverlay()"></div>
        <div style="clear:both"></div>
        <div id="leftArrow" onclick="previousImage()"></div>
        <img id="overlay_image">
        <div id="rightArrow" onclick="nextImage()"></div>
        <p>
        <div id="rating">
            <?php $voteform->display('', '', 1); ?>
        </div>
        </p>
    </div>
