  <div class="container">
    <div class="row">
	<h1>photggos participants au concours</h1>
        <div id="imageGallery">
            <div class="col s3 ">
                <a href="http://img0.gtsstatic.com/tatouage/un-tatouage-d-inspiration-steam-punk_165510_w250.jpg">
                    <img src="http://img0.gtsstatic.com/tatouage/un-tatouage-d-inspiration-steam-punk_165510_w250.jpg" width="100" alt="nom prenom" title="nom prenom">
                </a>
                <?php
                if (isset($_POST['star'])){
                    var_dump($_POST['star']);
                }
                ?>
            </div>
            <div class="col s3 ">
                <a href="http://www.jqueryscript.net/images/Simplest-Responsive-jQuery-Image-Lightbox-Plugin-simple-lightbox.jpg">
                    <img src="http://www.jqueryscript.net/images/Simplest-Responsive-jQuery-Image-Lightbox-Plugin-simple-lightbox.jpg" width="100" alt="nom2 prenom" title="nom2 prenom">
                </a>
                <?php
                if (isset($_POST['star'])){
                     var_dump($_POST['star']);
                }
                ?>
        </div>
     </div>
</div>
  </div>
