<div class="container">
<?php if(!isset($Error)) : ?>
	<ul id="tabs-swipe" class="tabs">
		<?php $i= 1; ?>
		<?php foreach ($albums as $album): ?>
			<?php if(isset($album['photos']['data'])): ?> 
				<li class="tab col s3"><a name="resetCarrousel" href="#carousel_<?php echo $i; ?>"><?php echo $album['name'] ?></a></li>
			<?php endif; ?>
			<?php $i++; ?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
 
<?php if(isset($Error)) : ?>
	<div class="col s12">
		<h3 id="titleSourceDAajout"><?php echo $Error; ?></h3>
	</div>
<?php endif; ?> 
	<div id="test-swipe-1" class="col s12">
		<form id="formAddPhoto" method="post" action="" enctype="multipart/form-data">
			<h3 id="titleSourceDAajout"><?php if(!empty($albums)) echo "Ajout d'une image depuis Facebook"; ?></h3>
			<h4 id="helpSourceDAajout"><?php if(!empty($albums)) echo "Sélectionnez une image en cochant le bouton radio"; ?></h4>
			
			<input type="hidden" id="hasPhotosFb" value="<?php if(!empty($albums)) echo "1"; else echo "0"; ?>"> <!-- 1 si oui et 0 si non -->
			
			<div id="addPhotoFb" class='row'>
				<?php if(!empty($albums)) : ?>					
					<?php $albumNumber = 1; ?>
					<input type="hidden" value="1" name="manyAlbums">
					<?php foreach($albums as $album_) : ?>
						<?php if(!empty($album_['photos'])) : ?>
							<div class="carousel <?php if($albumNumber > 1) echo "hidden"; ?>" id="carousel_<?php echo $albumNumber; ?>">
								<?php foreach ($album_['photos']['data'] as $photo): ?>
										<a class="carousel-item <?php echo $albumNumber; ?>" href="#">
											<input style="position: relative; opacity: 1; left: 0;" type="radio" name="idPhotoFbToSend" value="<?php echo $photo['id']; ?>">
											<img class="image_upload" src="<?php echo $photo['source']; ?>"width="100px">
										</a>
								<?php endforeach; ?>
								<?php $albumNumber++; ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>	
				<?php else : ?>
					<h3>Vous ne possédez aucune photo Facebook</h3>
				<?php endif; ?>
			</div>
			<div style="display: none;" id="addPhotoFile" class='row'>
				<div class="file-field input-field">
					<div class="btn amber accent-4">
						<i class="material-icons left">add_a_photo</i>
						<label for="file_img"></label>
						<input type="file" placeholder="" value="" class="" name="file_img">
					</div>
					<div class="file-path-wrapper">
						<input type="text" class="file-path validate">
					</div>
				</div>
			</div>
			<div class='row'>
				<input type="button" class="addPhotoFrom btn pointer" id="addPhotoFromFile" value="Ajouter une photo depuis une image de votre ordinateur">
			</div>
			<div class='titlePhoto row'>
				<div class="input-field">
					<i class=""></i>
					<label for="title" class="">Titre :</label>
					<input type="text" class="validate" name="title">
				</div>
			</div>
			<div class='descriptionPhoto row'>
				<div class="input-field">
					<i class=""></i>
					<label for="description" class="active">Description :</label>
					<textarea id="textarea1" class="materialize-textarea" name="description">                                        </textarea>
				</div>
			</div>
			<div class='row'>
				<input type="hidden" value="" id="typeSubmit" name="typeSubmit"> <!-- envoi photo par fb ou par upload -->
				<input type="reset" class="reset btn" value="Annuler">
				<input type="button" class="validate btn" id="ValidFormSendPhotoFromFb" value="VALIDER">
				<input style="display: none;" type="button" class="btn" id="ValidFormSendPhotoFromFile" value="VALIDER">
			</div>
			<div class="row">
				<div class="containerPhotoAdd">
					<?php if(!empty($photoChosen['source'])) : ?>
					   <div class="containerPhotoFbAdd">								
							<img src="<?php echo $photoChosen['source']; ?>" id="<?php echo $photoChosen['id']; ?>">
							<a id="deleteFrom" href="/Photo/deleteImgFb?<?php echo $photoChosen['typeId']; ?>=<?php echo $photoChosen['id']; ?>" class="delete">Supprimer</a>
					   </div>
					<?php endif; ?>
				   <!-- <div class="containerPhotoUploadAdd">
						
				   </div> -->					
				</div>
			</div>
		</form>
	</div>
</div>

<!-- <script>
	$(document).ready(function(){
		$("#ValidFormSendPhotoFromFb").click(function(){
			// valide formulaire
			
			$("#typeSubmit").val("fb"); // envoi par fb			
			$("#formAddPhoto").validate();
		});
	});
</script> -->
