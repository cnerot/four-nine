  <div class="container">
    <div class="row">
	<h1>Photos des participants au concours <?php echo $contestCurrent->name; ?> 
	<br><span style="font-size: 20px;">(concours valable du <?php echo $contestCurrent->start; ?> au <?php echo $contestCurrent->end; ?>)</span></h1>
        <div id="imageGallery">
			<?php for($i = 0; $i<count($listPhotos); $i++) : ?>
				<div class="col s3 <?php echo $i+1; ?> <?php if($i>=8) echo "hidden"; ?>">
					<?php foreach($listPhotos as $photo) : ?>
						<a id="<?php echo $photo->infosPhotoFb['id']; ?>" href="<?php echo $photo->infosPhotoFb['source']; ?>">
							<img src="<?php echo $photo->infosPhotoFb['source']; ?>" width="100" alt="photo" title="nom prenom">
						</a>
					<?php endforeach; ?>               
					<?php
					if (isset($_POST['star'])){
						var_dump($_POST['star']);
					}
					?>
				</div>
			<?php endfor; ?>
			
			<div class="col s12">
				<input type="hidden" id="nbPhotosToDisp" value="8">
				<input type="button" id="seeMorePhotos" value="Voir +" class="btn">
			</div>
     </div>
</div>
  </div>
