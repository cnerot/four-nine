<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PhotoController
{
    
    public function preDeploy($args)
    {

    }

    /**
     * Static pages main
     */
    public function indexAction($args)
    {
        /** Get BDD data */
        $fb = new FBApp();
        $_SESSION['idUser'] = $fb->getFBUserData("/me")['id'];

        $contestCurrent = (new Contest())->getCurrent();
        var_dump($_SESSION['idUser']);
        if($contestCurrent!=null){
        $currentUserPhoto = (new Photo())->getCurrentUserPhoto($_SESSION['idUser'], $contestCurrent->getId());
        $currentUserLink = (new Link())->getCurrentUserLink($_SESSION['idUser'], $contestCurrent->getId());
        
        }
        /**Get FB Albums*/
        $albums = $fb->getFBUserData("/me?fields=albums{name,photos{source}}");
        
        if (isset($albums['albums'])) {
            $albums = $albums['albums']['data'];
        } else {
            $albums = array();
        }
        /**Get Current Photo URL*/
        if ($currentUserPhoto) {
            $currentUserPhotoUrl = $currentUserPhoto->getFbPhotoUrl();
        } else {

            $_SESSION['idContest'] = $contestCurrent->id;

            $view->putData('albums', $albums);

            $photosUser = $Photo->getWhere(['id_user' => $_SESSION['idUser']]);

            $Link = new Link();

            $links = $Link->getWhere([]);

            $photosAlreadyAddForThisContest = [];

            foreach ($links as $linkCurrent) {
                foreach ($photosUser as $photoUserCurrent) {
                    if ($linkCurrent->id_photo == $photoUserCurrent->id && $linkCurrent->id_contest == $contestCurrent->id) {
                        $photosAlreadyAddForThisContest[] = $photoUserCurrent;
                    }
                }
            }


            /*treat data and upload nex photo*/
		//var_dump($_POST);
		//var_dump($_FILES);
            if (isset($_POST)&& isset($_POST['idPhotoFbToSend'])) {
        	try{
	        $source = $fb->getFBUserData($_POST['idPhotoFbToSend'] . '?fields=source');
                $source = $source['source'];

	        $args = array('message' => 'Photo Caption',
                   // 'id' => Config::DATA_ALBUM_ID,
                    'url' => $source
                );
	
	                $data = $fb->postFBPageData('1250869114948648/photos', $args);
		}catch (Exception $e){
                    var_dump($e->getMessage());
                }
            }
            if (isset($_FILES)) {
		
                try{
			move_uploaded_file($_FILES["file_img"]["tmp_name"], Config::PATH . '/media/images/tmp/tmp.png');
                }catch (Exception $e){
                        var_dump($e->getMessage());
                }



		//$source = $fb->fb->fileToUpload(Config::PATH.'/media/images/tmp/tmp.png');
                //$fb->fb->setFileUploadSupport(true);
		
                $token = $fb->getFBUserData(Config::DATA_PAGE_ID . '?fields=access_token');

                $args = array('message' => 'Photo Caption',
                    'source' =>$fb->fb->fileToUpload(Config::PATH . '/media/images/tmp/tmp.png')
                );
		try{
 	              	$data = $fb->postFBUserData('1250869114948648/photos', $args);
		}catch(Facebook\Exceptions\FacebookResponseException $e) {
 			 echo 'Graph returned an error: ' . $e->getMessage();
  			exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
 			 echo 'Facebook SDK returned an error: ' . $e->getMessage();
  			exit;
		}catch (Exception $e){
        		//var_dump($e->getMessage());
                }
            }

            if (empty($photosAlreadyAddForThisContest) && ((isset($_POST['typeSubmit']) && $_POST['typeSubmit'] == "fb") || (isset($_POST['typeSubmit']) && $_POST['typeSubmit'] == "file"))) { // si pas encore participé
                if ($_POST['typeSubmit'] == "fb" && isset($_POST['idPhotoFbToSend']))
                    $Photo->setIdFb($data['id']);
                $Photo->setDescription($_POST['description']);
                $Photo->setIdUser($_SESSION['idUser']); // récupérer idUser
                $Photo->setTitle($_POST['title']);
                $Photo->save();

                // récupère l'id photo créé

                $photoAddForThisContest = $Photo->getWhere(['id_user' => $_SESSION['idUser']]);

                $lastIdPhoto = 1;
                foreach ($photoAddForThisContest as $photoAddCurrent) {
                    if ($photoAddCurrent->id > $lastIdPhoto) {
                        $lastIdPhoto = $photoAddCurrent->id;
                    }
                }

                $Link->setIdContest($contestCurrent->id);
                $Link->setIdPhoto($lastIdPhoto);

                $Link->save();

                if (isset($_POST['typeSubmit']) && $_POST['typeSubmit'] == "fb") {
                    foreach ($albums as $album_) {
                        if (!empty($album_['photos'])) {
                            foreach ($album_['photos']['data'] as $album) {
                                if (isset($_POST['idPhotoFbToSend']) && $album['id'] == $_POST['idPhotoFbToSend']) {
                                    $view->putData('photoChosen', ['source' => $album['source'], 'id' => $album['id'], 'typeId' => "idFb"]);
                                }
                            }
                        }
                    }
                } else if (isset($_POST['typeSubmit']) && $_POST['typeSubmit'] == "file") {
                    if ($_FILES['file_img']['type'] != "image/png" && $_FILES['file_img']['type'] != "image/jpeg") {
                        echo "Veuillez sélectionner une image de type png ou jpg";
                        $error = true;
                    } else if ($_FILES['file_img']['size'] > 10000000) {
                        echo "Veuillez sélectionner un fichier de 10 mo maximum";
                        $error = true;
                    } else {
                        if ($_FILES['file_img']['type'] == "image/jpeg") { // png dans tous les cas
                            $ext = ".png";
                        } else {
                            $ext = ".png";
                        }

                        move_uploaded_file($_FILES['file_img']['tmp_name'], "media/imgFiles/" . $_SESSION['idUser'] . "_" . $_SESSION['idContest'] . $ext);

                        $view->putData('photoChosen', ['source' => "media/imgFiles/" . $_SESSION['idUser'] . "_" . $_SESSION['idContest'] . ".png", 'id' => $lastIdPhoto, 'typeId' => "idPhoto"]);
                    }
                } else {
                    $error[] = "Une erreur s'est produite";
                }
            }
            if (isset($newFbId)) {
                $new_photo = new Photo();
                $new_link = new Link();
                if ($currentUserPhoto) {
                    $new_photo = $currentUserPhoto;
                    $new_link = $currentUserLink;
                }
                $new_photo->setIdUser($_SESSION['idUser']);
                $new_photo->setIdFb($newFbId);
                $photo_id = $new_photo->save();
                $new_link->setIdContest($contestCurrent->getId());
                $new_link->setIdPhoto($photo_id);
                $new_link->save();
            } else {
                $error[] = "Une erreur s'est produite";
            }
        }
        /** Compile errors */
        $error = array();
        if (!$contestCurrent)
            $error[] = 'Aucun concours photo de prévu pour le moment';
        /** Set view and add data */
        $view = new View();
        $view->setView('photoSelect');
        $view->putData('Error', $error);
        $view->putData('albums', $albums);
        $view->putData('currentPhoto', $currentUserPhotoUrl);
    
    }
}
