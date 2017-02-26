<div class="container">
    <div class="row">
        <div class="col s12 p_pageStat <?php echo $themeApplicated->getPageStat(); ?>">
			<?php if(!empty($contestCurrent)) : ?>
				<p>Photos des participants au concours <?php echo $contestCurrent->name; ?></p>
				<p>(concours valable du <span class="dateFR"><?php echo $contestCurrent->start; ?></span> au <span class="dateFR"><?php echo $contestCurrent->end; ?></span>
					)</p>
			<?php endif; ?>
			
			<?php $dontDispErrListPhotos = false; ?>
			
			<?php foreach($err as $error) : ?>
				<div class="header col s12 white-text light">
					<?php echo $error; ?>
				</div>
				<?php $dontDispErrListPhotos = true; ?>
			<?php endforeach; ?>
        </div>
        <?php if (empty($listPhotos)) : ?>
			<?php if($dontDispErrListPhotos == false) : ?>
				<div style="margin-bottom: 10px" class="center">
					<p class="<?php echo $themeApplicated->getTextColor(); ?>">Aucune photo n'a encore été uploadée</p>
				</div>
			<?php endif; ?>
        <?php else : ?>
            <div class=" col s12 panelGalerie p_pageStat">

                <?php foreach ($listPhotos as $photo) : ?>
                    <div class="col s3" name="image_div" data-grade="<?php echo $photo['grade']; ?>" data-user="<?php echo $photo['user']; ?>" data-source="<?php echo $photo['source']; ?>" data-link="<?php echo $photo['link_id']; ?>">
                        <div id="imageGallery">
                            <div class="bordered">
                                <a id="<?php echo $photo['id']; ?>">
                                    <img src="<?php echo $photo['source']; ?>" width="150" alt="hhhhh" class="margin-top-10" title="hhhh">
                                </a>
                                <div><span>note : </span></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>
        <div class="col s12">
            <input type="hidden" id="nbPhotosToDisp" value="8">
            <?php if (!empty($listPhotos)) : ?>
                <input type="button" id="seeMorePhotos" value="Voir +" class="btn right top-5 <?php echo $themeApplicated->getBtnColor(); ?>">
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
        <div id="photo_user"></div>
        <div id="photo_grade"></div>
        <div id="rating">
            <?php $voteform->display('', '', 1); ?>
        </div>
        </p>
    </div>
