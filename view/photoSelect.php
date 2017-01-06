<?php foreach ($albums as $album): ?>
    <h3><?php echo $album['name'] ?></h3>
    <?php foreach ($album['photos']['data'] as $photo): ?>
        <img src="<?php echo $photo['source']; ?>" style="height: 100px"/>
    <?php endforeach; ?>
<?php endforeach; ?>
