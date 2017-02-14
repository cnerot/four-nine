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
            <?php if($j % 2 == 1 && isset($album['photos']['data'])):  ?>
               <div id="test-swipe-<?php echo $j; ?>" class="col s12 yellow">
                    <div class='row'>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="col s12">
                                <div class="col s10">
                                    <div class="file-field input-field">
                                        <div class="btn">
                                            <i class="material-icons">add_a_photo</i>
                                            <label for="file_img"></label>
                                            <input type="file" placeholder="" value="" class="" name="file_img">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input type="text" class="file-path validate">
                                        </div>
                                    </div>
                                </div>
                                <div class="col s2 top-5">
                                    <div class="top-5">
                                        <button name="submit" id="submit" type="submit" onclick="" class="btn right green accent-4">Envoyer</button>
                                    </div>
                                </div>
                            </div>
                            <?php foreach ($album['photos']['data'] as $photo): ?>
                                <div class="col s3 center-align">
                                    <input style="position: relative; opacity: 1; left: 0;" type="radio" name="idPhotoFbToSend" value="<?php echo $photo['id']; ?>">
                                    <div class="image_upload">
                                        <img class="materialboxed"  src="<?php echo $photo['source']; ?>"width="100px"/>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </form>
                    </div>
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
