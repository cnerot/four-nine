<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ConcoursController
{
    private $form;
    private $voteform;

    public function preDeploy($args)
    {
        if (!(new FBApp())->isAdmin()){
            Router::redirect();
        }
        $this->form = new Form([
            'options' => [
                'method' => 'POST',
                'action' => '#',
                'submit' => 'Valider',
                'name' => 'postform',
                'class' => '',
                "id" => 'test',
                'enctype' => "multipart/form-data"
            ],
            'data' => [
                "start" => [
                    "type" => "date",
                    "validation" => "date",
                    "value" => '',
                    "label" => 'Date de début :',
                    "class"=> 'datepicker'
                ],
                "end" => [
                    "type" => "date",
                    "validation" => "date",
                    "value" => '',
                    "label" => 'Date de fin',
                    "class"=> 'datepicker'
                ],
                "title" => [
                    "type" => "text",
                    "validation" => "text",
                    "value" => '',
                    "label" => 'Titre de concours :',
                    "class" => 'validate',
                    "div_class" => 'input-field'
                ],
                "prize" => [
                    "type" => "text",
                    "validation" => "text",
                    "value" => '',
                    "label" => 'Lot :',
                    "class" => 'validate',
                    "div_class" => 'input-field'
                ],
                "prize_img" => [
                    "type" => "file",
                    "validation" => "file",
                    "value" => '',
                    "div_class" =>'btn amber accent-4',
                    "file_class" =>'file-field input-field',
                    "icon_class" =>'material-icons left',
                    "icon_content" =>'add_a_photo',
                    "class_wrapper" =>'file-path-wrapper',
                    "class_inputWrapper" =>'file-path validate',
                    "type_inputWrapper" =>'text',
                ],
                "description" => [
                    "type" => "textarea",
                    "validation" => "text",
                    "value" => '',
                    "class" => 'materialize-textarea',
                    "div_class" => 'input-field',
                    "id" => 'textarea1',
                    "label" => 'Description :'
                ],
            ]
        ]);
            
        $this->voteform = new Form([
            'options' => [
                'method' => 'POST',
                'action' => '',
                'submit' => 'Send',
                'name' => 'postform',
                'class' => '',
                'id'    => 'ratingsForm',
                'enctype' => "multipart/form-data"
            ],
            'data' => [
                "star" => [
                    "type" => "radio",
                    "validation" => "star",
                    "div_class" => "stars",
                    "value1" => '1',
                    "value2" => '2',
                    "value3" => '3',
                    "value4" => '4',
                    "value5" => '5',
                    "idClass1"=> 'star-1', //id and class have the same value, i will use it for the both.
                    "idClass2"=> 'star-2',
                    "idClass3"=> 'star-3',
                    "idClass4"=> 'star-4',
                    "idClass5"=> 'star-5',
                ],
            ]
        ]);

    }
    public function indexAction($args)
    {
        $concours = new Contest();
        $concours = $concours->getWhere();

        $view = new View();
        $view->setView('gestionConcours');
        $view->putData('styles', ['home']);
        $view->putData('concours', $concours);
    }

    public function deleteAction($args){
        $concours = new Contest();
        $concours = $concours->getOneWhere(["id"=>$_REQUEST['id']]);
        $concours->delete();
    }
    public function newAction($args)
    {
        $data = $this->form->validate();

        if ($data) {

            $contest = new Contest();

            /* Upload image */
            /* prepare data */
            $contest_data = [
                "name" => $data['name'],
                "description" => $data['description'],
                "start" => $data['start'],
                "end" => $data['end'],
            ];
            //Logger::debug($data);
            $contest->fromArray($contest_data);
            $contest->save();
        }

        $view = new View();
        $view->setView('newConcours');
        $view->putData('styles', ['home']);
        $view->putData('form', $this->form);
    }

    public function tempAction($args)
    {
        $facebook = new FBApp();
		//$facebook->printFBLogin();
	
        $album_details = array(
            'message' => 'Album desc',
            'name' => 'Album name'
        );
        $facebook->isAdmin();


        //$create_album = $facebook->getFBData('/' . Config::DATA_PAGE_ID . '/albums', $album_details);
        //ogger::debug($create_album);

    }
    public  function editAction(){

        $concours = new Contest();
        $concours = $concours->getOneWhere(["id"=>$_REQUEST['id']]);

        $data = $this->form->validate();
        if ($data && !$data['error']) {
            $concours->fromArray($data);
            $concours->save();
        }

        $view = new View();
        $view->setView('newConcours');
        $view->putData('form', $this->form);
        $view->putData('concours', $concours);

    }
    public function ajaxAction($args)
    {
        $fb = new FBApp();
        $usr = $fb->getFBUserData('/me');

        
        if (isset($_POST['star'])) {
            $vote = new Vote();
            $vote->setGrade($_POST['star']);
            $vote->setIdUtilisateurs($usr);
            $vote->setIdLink(1);
            $vote->save();
        }
        $view = new View();
        $view->setView('staticMenu/voter', 'no_layout');
        $view->putData('voteform', $this->voteform);
    }

    public function voteAction($args)
    {
        $fb = new FBApp();		
	$user = new User();
        
        //$nomUser = $user->getWhere();
        //$prenomUser = $user->getWhere();
        
        $vote = new Vote();
        $vote = $vote->getWhere();
        
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
		
		$Link = new Link();
		
		$links = $Link->getWhere([]); // récupère tous les link
		
		$Photo = new Photo();
		
		$photos = $Photo->getWhere();
		
		$listPhotosForCurrentContest = [];
		
		$i = 0;

        foreach($links as $linkCurrent){
			foreach($photos as $photoCurrent){
				if($linkCurrent->id_photo == $photoCurrent->id && $linkCurrent->id_contest == $contestCurrent->id){
					$listPhotosForCurrentContest[] = $photoCurrent;  // liste les photos qui appartiennent au concours courant
					$albums = $fb->getFBUserData(Config::DATA_PAGE_ID."?fields=albums{name,photos{source}}");
					//$albums = $fb->getFBUserData("191380041334779"."?fields=albums{name,photos{source}}");
					if (isset($albums['albums'])) {
						$albums = $albums['albums']['data'];
					} else {
						$albums = [];
					}
					
					foreach($albums as $album_){
						if(!empty($album_['photos'])){
							foreach($album_['photos']['data'] as $album){
								if($photoCurrent->id_fb == $album['id']){
								//if("123063731499744" == $album['id'])
                                                                    $temp_link = (new Link())->getOneWhere(
                                                                                                           ['id_photo'=>$photoCurrent->id_fb,
                                                                                                           // 'id_contest'=>$->getId()
                                                                                                           ]);
                                                                    $temp_user = (new User())->getOneWhere(['id'=>$temp_link->getUserId()]);
                                                                    
                                                                    $listPhotosForCurrentContest[$i]->infosPhotoFb = ['id'=>$album['id'], 'source'=>$album['source'], "name"=>$temp_user->getName(), "surname"=>getSurname()];
									$i++;
								}	
							}
						}												
					}					
				}
			}
		}
		//echo "<pre>";
		//print_r($fb->getFBUserData("191380041334779?fields=albums{name,photos{source}}"));
		//echo "</pre>";
		//echo "<pre>";
		//	print_r($albums);
		//echo "</pre>";
		
		$_SESSION['idContest'] = $contestCurrent->id;
		
        $view = new View();
        $view->setView('voteConcours');
        $view->putData('styles', ['gallery','stars']);
        $view->putData('voteForm', $this->voteform);
		$view->putData('contestCurrent', $contestCurrent);
		$view->putData('listPhotos', $listPhotosForCurrentContest);
    }
}
  
