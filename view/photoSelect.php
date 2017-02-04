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
                <div id="test-swipe-<?php echo $j; ?>" class="col s12 yellow">
                    <div class='row'>
                        <?php foreach ($album['photos']['data'] as $photo): ?>
                            <div class="col s3">
                                <img class="materialboxed image_upload" src="<?php echo $photo['source']; ?>"width="100px"/>
                            </div>
                        <?php endforeach; ?>
                     </div>
                </div>
            <?php elseif($j % 2 == 0): ?>  
                <div id="test-swipe-<?php echo $j; ?>" class="col s12 green ">
                               <div class='row' id="imageGallery">
                                   <?php foreach ($album['photos']['data'] as $photo): ?>
                                       <div class="col s3">
                                           <img class="materialboxed" src="<?php echo $photo['source']; ?>" width="100px" />
                                       </div>
                                   <?php endforeach; ?>
                                </div>
                </div>
            <?php endif; ?>
                <?php  $j++ ; ?>
<?php endforeach; ?>
</div>
