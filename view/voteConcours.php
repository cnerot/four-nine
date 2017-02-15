  <div class="container">
    <div class="row">
        <div class="col s12 p_pageStat">
            <p>Photos des participants au concours <?php echo $contestCurrent->name; ?></p>
            <p>(concours valable du <?php echo $contestCurrent->start; ?> au <?php echo $contestCurrent->end; ?>)</span></p>
        </div>
            <?php if(empty($listPhotos)) : ?>
				<div style="margin-bottom: 10px" class="center">
					<label>Aucune photo n'a encore été uploadée</label>
				</div>
	   <?php else : ?>
            <input type="hidden" value="<?php count($listPhotos); ?>" id="nbAllPhotos">
            <div class=" col s12 panelGalerie p_pageStat">
                <?php for($i = 0; $i<count($listPhotos); $i++) : ?>
                            <?php foreach($listPhotos as $photo) : ?>
                            <div class="col s3 <?php echo $i+1; ?> <?php if($i>=8) echo "hidden"; ?>">
                                <div id="imageGallery">
                                   <a id="<?php echo $photo->infosPhotoFb['id']; ?>" href="<?php echo $photo->infosPhotoFb['source']; ?>">
                                       <img src="<?php echo $photo->infosPhotoFb['source']; ?>" width="100" alt="<?php echo $photo->infosPhotoFb['name'] .' '. $photo->infosPhotoFb['surname']; ?>" class="top-5" title="<?php echo $photo->infosPhotoFb['name'] .' '. $photo->infosPhotoFb['surname']; ?>">
                                   </a>
                               </div>
                            </div>
                           <?php endforeach; ?> 
                <?php endfor; ?>
            </div>
        <?php endif; ?>
			<div class="col s12">
				<input type="hidden" id="nbPhotosToDisp" value="8">
				<?php if(!empty($listPhotos)) : ?>
					<input type="button" id="seeMorePhotos" value="Voir +" class="btn right top-5">
				<?php endif; ?>
			</div>

  </div>
