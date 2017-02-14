<div class="container">
<ul id="tabs-swipe" class="tabs">
    <?php $i= 1; ?>
    <?php foreach ($albums as $album): ?>
        <?php if(isset($album['photos']['data'])): ?> 
            <li class="tab col s3"><a href="#test-swipe-<?php echo $i; ?>"><?php echo $album['name'] ?></a></li>
        <?php endif; ?>
        <?php $i++; ?>
    <?php endforeach; ?>
 </ul>
<?php $j= 1; ?>
<?php foreach ($albums as $album): ?>
            <?php if($j % 2 == 1):  ?>
                <div id="test-swipe-<?php echo $j; ?>" class="col s12">
					<form id="formAddPhoto" method="post" action="" enctype="multipart/form-data">
						<h3 id="titleSourceDAajout">Ajout d'une image depuis Facebook</h1>
							  
						
						<div id="addPhotoFb" class='row'>
							<div class="carousel">
								<?php foreach ($album['photos']['data'] as $photo): ?>
										<a class="carousel-item" href="#one!">
											<input style="position: relative; opacity: 1; left: 0;" type="radio" name="idPhotoFbToSend" value="<?php echo $photo['id']; ?>">
											<img class="image_upload" src="<?php echo $photo['source']; ?>"width="100px">
										</a>
								<?php endforeach; ?>
							</div>
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
						<div class='row'>
							<div class="input-field">
								<i class=""></i>
								<label for="title" class="">Titre :</label>
								<input type="text" class="validate" name="title">
							</div>
						</div>
						<div class='row'>
							<div class="input-field">
								<i class=""></i>
								<label for="description" class="active">Description :</label>
								<textarea id="textarea1" class="materialize-textarea" name="description">                                        </textarea>
							</div>
						</div>
						<div class='row'>
							<input type="hidden" value="" id="typeSubmit" name="typeSubmit"> <!-- envoi photo par fb ou par upload -->
							<input type="reset" class="btn" value="Annuler">
							<input type="button" class="btn" id="ValidFormSendPhotoFromFb" value="VALIDER">
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
            <?php elseif($j % 2 == 0): ?>  
                <div id="test-swipe-<?php echo $j; ?>" class="col s12 green ">
                               <div class='row' id="imageGallery">
                                   <?php foreach ($album['photos']['data'] as $photo): ?>
                                       <div class="col s3">                                           
										   <img class="materialboxed" src="<?php echo $photo['source']; ?>" width="100px">
                                       </div>
                                   <?php endforeach; ?>
                                </div>
                </div>
            <?php endif; ?>
                <?php  $j++ ; ?>
<?php endforeach; ?>
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
