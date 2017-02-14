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
        $fb = new FBApp();		
		
		$error = false;

        $albums = $fb->getFBUserData("/me?fields=albums{name,photos{source}}");
        if (isset($albums['albums'])) {
            $albums = $albums['albums']['data'];
        } else {
            $albums = [];
        }
        $view = new View();
        $view->setView('photoSelect');        
		
		$Photo = new Photo();
		
		$data = ["description"=>4, "created"=>1];
		
		$_SESSION['idUser'] = $fb->getFBUserData("/me")['id'];				
		
		$Contest = new Contest();		
		$today = date('Y-m-d');		
		$contestsStart = $Contest->getWhere(['start' => ['operator' => 'less_equal', "value" => $today]]); // récupère contests quand date début du concours commencée		
		$contestsEnd = $Contest->getWhere(['end' => ['operator' => 'greater_equal', "value" => $today]]); // récupère contests quand date fin du concours non atteinte
		
		// récupère le concours en cours
		
		foreach($contestsStart as $contestStartCurrent){
			foreach($contestsEnd as $contestEndCurrent){
				if($contestStartCurrent->id == $contestEndCurrent->id){
					$contestCurrent = $contestStartCurrent;
				}
			}
		}
		
		if(empty($contestCurrent)){
			$nextContestsStart = $Contest->getWhere(['start' => ['operator' => 'greater_equal', "value" => $today]]);
			
			if(!empty($nextContestsStart)){
				$nextDate = $nextContestsStart[0]->start;
				foreach($nextContestsStart as $nextContestStartCurrent){
					if( strtotime($nextContestStartCurrent->start) < strtotime($nextDate) ){
						$nextDate = $nextContestStartCurrent->start;
					}
				}
				
				$nextDate = explode(" ", $nextDate)[0];
				$view->putData('Error', 'Aucun concours photo pour le moment, le prochain concours démarrera le <span class="dateFR">'.$nextDate.'</span>');
			}else{
				$view->putData('Error', 'Aucun concours photo de prévu pour le moment');
			}				
				$view->putData('albums', []);				
		}else{
			$_SESSION['idContest'] = $contestCurrent->id;
			
			$view->putData('albums', $albums);				
			
			$photosUser = $Photo->getWhere(['id_user' => $_SESSION['idUser']]);
			
			$Link = new Link();
			
			$links = $Link->getWhere([]);
			
			$photosAlreadyAddForThisContest = [];
			
			foreach($links as $linkCurrent){
				foreach($photosUser as $photoUserCurrent){
					if($linkCurrent->id_photo == $photoUserCurrent->id && $linkCurrent->id_contest == $contestCurrent->id){
						$photosAlreadyAddForThisContest[] = $photoUserCurrent;
					}
				}
			}
			
			if( empty($photosAlreadyAddForThisContest) && ( (isset($_POST['typeSubmit']) && $_POST['typeSubmit'] == "fb") || (isset($_POST['typeSubmit']) && $_POST['typeSubmit'] == "file") ) ){ // si pas encore participé
				if($_POST['typeSubmit'] == "fb" && isset($_POST['idPhotoFbToSend']))
					$Photo->setIdFb($_POST['idPhotoFbToSend']);
				$Photo->setDescription($_POST['description']);
				$Photo->setIdUser($_SESSION['idUser']); // récupérer idUser
				$Photo->setTitle($_POST['title']);
				$Photo->save();
				
				// récupère l'id photo créé
				
				$photoAddForThisContest = $Photo->getWhere(['id_user' => $_SESSION['idUser']]);
				
				$lastIdPhoto = 1;
				foreach($photoAddForThisContest as $photoAddCurrent){
					if($photoAddCurrent->id > $lastIdPhoto){
						$lastIdPhoto = $photoAddCurrent->id;
					}
				}
							
				$Link->setIdContest($contestCurrent->id);
				$Link->setIdPhoto($lastIdPhoto);
				
				$Link->save();			
				
				if(isset($_POST['typeSubmit']) && $_POST['typeSubmit'] == "fb"){	
					foreach($albums as $album_){
						if(!empty($album_['photos'])){
							foreach($album_['photos']['data'] as $album){				
								if(isset($_POST['idPhotoFbToSend']) && $album['id'] == $_POST['idPhotoFbToSend']){
									$view->putData('photoChosen', ['source'=>$album['source'], 'id'=>$album['id'], 'typeId'=>"idFb"]);
								}
							}
						}
					}
				}else if(isset($_POST['typeSubmit']) && $_POST['typeSubmit'] == "file"){
					if($_FILES['file_img']['type'] != "image/png" && $_FILES['file_img']['type'] != "image/jpeg"){
						echo "Veuillez sélectionner une image de type png ou jpg";
						$error = true;
					}else if($_FILES['file_img']['size'] > 10000000){
						echo "Veuillez sélectionner un fichier de 10 mo maximum";
						$error = true;
					}else{
						if($_FILES['file_img']['type'] == "image/jpeg"){ // png dans tous les cas
							$ext = ".png";
						}else{
							$ext = ".png";
						}
						
						move_uploaded_file($_FILES['file_img']['tmp_name'], "media/imgFiles/".$_SESSION['idUser']."_".$_SESSION['idContest'].$ext);
						
						$view->putData('photoChosen', ['source'=>"media/imgFiles/".$_SESSION['idUser']."_".$_SESSION['idContest'].".png", 'id'=>$lastIdPhoto, 'typeId'=>"idPhoto"]);
					}
				}else{
					$error = true;
				}
				
				if($error == false)
					echo "Ajout de la photo pour le concours réussi";
				
			}else{ // montre la photo choisie pour le concours
				if( !empty($photosAlreadyAddForThisContest) && ( (isset($_POST['typeSubmit']) && $_POST['typeSubmit'] == "fb") || (isset($_POST['typeSubmit']) && $_POST['typeSubmit'] == "file") ) )
					echo "Vous avez déjà participé au concours";
				
				if(!empty($photosAlreadyAddForThisContest) && $photosAlreadyAddForThisContest[0]->id_fb == NULL){
					$view->putData('photoChosen', ['source'=>"media/imgFiles/".$_SESSION['idUser']."_".$_SESSION['idContest'].".png", 'id'=>$photosAlreadyAddForThisContest[0]->id, 'typeId'=>"idPhoto"]);
				}else if(!empty($photosAlreadyAddForThisContest)){
					foreach($albums as $album_){
						if(!empty($album_['photos'])){
							foreach($album_['photos']['data'] as $album){				
								if($album['id'] == $photosAlreadyAddForThisContest[0]->id_fb){
									$view->putData('photoChosen', ['source'=>$album['source'], 'id'=>$album['id'], 'typeId'=>"idFb"]);
								}
							}
						}
					}
				}				
			}
		}
    }
	
	public function deleteImgFbAction($args)
    {
		session_start();
		
		$Photo = new Photo();	
		
		if(isset($_GET['idPhoto'])){
			$photoToDelete = $Photo->getWhere(['id' => $_GET['idPhoto']]);
		}else if(isset($_GET['idFb'])){
			$photoToDelete = $Photo->getWhere(['id_fb' => $_GET['idFb']]);
		}	
		
		
			// vérifie que la photo appartient à l'utilisateur			
		if($photoToDelete[0]->id_user == $_SESSION['idUser']){		
			// suppression de la photo dans la table "photo"
			
			// suppression du link dans la table "link"
			$Link = new Link();		
			$linkToDelete = $Link->getWhere(['id_photo' => $photoToDelete[0]->id]);
			
			$exit = false;
			foreach($linkToDelete as $linkToDeleteCurrent){
				if($exit == false){
					if($linkToDeleteCurrent->id_contest == $_SESSION['idContest']){ // si link correspond avec id_photo et id_contest
						$Link->setId($linkToDeleteCurrent->id);
						
						if(count($linkToDelete) == 1){ // si la photo fb n'était liée qu'à un seul concours
							$Photo->setId($photoToDelete[0]->id);	
							$Photo->delete();
						}
						$Link->delete();
						$exit = true;
					}
				}
			}			
		}
		
		// suppression du fichier sur serveur
		unlink("media/imgFiles/".$_SESSION['idUser']."_".$_SESSION['idContest'].".png");
		
		header('Location: /Photo');		
    }
	
    public function testAction($args)
    {
        $fb = new FBApp();
        $data = $fb->getFBUserData('app');
        Logger::debug($data);
    }
}