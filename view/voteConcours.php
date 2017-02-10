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
                    echo"<script> alert('". $_POST['star'] ."')</script>";
                }
                ?>
        </div>
     </div>
</div>
  </div>
