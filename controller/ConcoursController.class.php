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
        if (!(new FBApp())->isAdmin()) {
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
                    "labelClass" => '',
                    "label" => 'Date de début :',
                    "class" => 'datepicker'
                ],
                "end" => [
                    "type" => "date",
                    "validation" => "date",
                    "value" => '',
                    "labelClass" => '',
                    "label" => 'Date de fin',
                    "class" => 'datepicker'
                ],
                "upload_msg" => [
                    "type" => "text",
                    "validation" => "text",
                    "value" => '',
                    "label" => 'Post message :',
                    "Placeholder" => "replace values ({title}, {start}, {end})",
                    "class" => 'validate',
                    "div_class" => 'input-field'
                ],
                "name" => [
                    "type" => "text",
                    "validation" => "text",
                    "value" => '',
                    "label" => 'Titre de concours :',
                    "labelClass" => '',
                    "class" => 'validate',
                    "div_class" => 'input-field'
                ],
                "prize" => [
                    "type" => "text",
                    "validation" => "text",
                    "value" => '',
                    "label" => 'Lot :',
                    "labelClass" => '',
                    "class" => 'validate',
                    "div_class" => 'input-field'
                ],
                "prize_img" => [
                    "type" => "file",
                    "validation" => "file",
                    "value" => '',
                    "div_class" => 'btn amber accent-4',
                    "file_class" => 'file-field input-field',
                    "icon_class" => 'material-icons left',
                    "icon_content" => 'add_a_photo',
                    "class_wrapper" => 'file-path-wrapper',
                    "class_inputWrapper" => 'file-path validate',
                    "type_inputWrapper" => 'text',
                ],
                "description" => [
                    "type" => "textarea",
                    "validation" => "text",
                    "value" => '',
                    "labelClass" => '',
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
                'id' => 'ratingsForm',
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
                    "idClass1" => 'star-1', //id and class have the same value, i will use it for the both.
                    "idClass2" => 'star-2',
                    "idClass3" => 'star-3',
                    "idClass4" => 'star-4',
                    "idClass5" => 'star-5',
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

    public function deleteAction($args)
    {
        $concours = new Contest();
        $concours = $concours->getOneWhere(["id" => $_REQUEST['id']]);
        $concours->delete();
    }

    public function newAction($args)
    {
		$err = [];
		
        $data = $this->form->validate();

        if ($data) {
            $contest = new Contest();
            $fb = new FBApp();
            /* Upload image */
            $prize_img = new File("prize_img");
            if ($prize_img->check_size(10,'mo') && $prize_img->check_extention(['png', 'jpg'])){
                $message = $data['upload_msg'];
                $message = str_replace('{title}', $data['title'],$message);
                $message = str_replace('{start}', $data['start'],$message);
                $message = str_replace('{end}', $data['end'],$message);
                $args = array(
                    'message'       => $message,
                    'source'        => $fb->fb->fileToUpload($prize_img->getTmpName()),
                );
                $fb_response = $fb->postFBPageData(Config::DATA_PAGE_ID . '/photos', $args);
                $newFb = $fb_response->getDecodedBody();
                $newFbId = $newFb['id'];
            } else {
                $newFbId = "";
            }

            /* prepare data */
            $contest_data = [
                "name" => $data['title'],
                "description" => $data['description'],
                "start" => $data['start'],
                "end" => $data['end'],
                "photo" => $newFbId,
            ];
            //Logger::debug($data);
            $contest->fromArray($contest_data);
			
			$contests = $contest->getWhere([]);
						
			$dateStart = explode("/", $data['start']);
			$dateStart = $dateStart[2]."-".$dateStart[1]."-".$dateStart[0]; // transformation de la date du format français vers le format anglo saxon
			$dateEnd = explode("/", $data['end']);
			$dateEnd = $dateEnd[2]."-".$dateEnd[1]."-".$dateEnd[0]; // transformation de la date du format français vers le format anglo saxon
						
			$contest->setStart($dateStart);
			$contest->setEnd($dateEnd);
			
			foreach($contests as $contest_recup){
				$today = date('Y-m-d');
				
				if(strtotime($dateEnd) < strtotime($today)){
					$err[] = "Les dates de concours sont fausses";
					break;
				}else if(strtotime($dateStart) > strtotime($dateEnd)){
					$err[] = "Les dates de fin et de début du concours sont fausses";
					break;
				}else if(strtotime($dateEnd) > strtotime($contest_recup->start) && strtotime($dateStart) < strtotime($contest_recup->end)){
					$err[] = "Le concours ".$contest_recup->name." chevauche déjà cette période";
					break;
				}
			}
			
			if(empty($err)){
				$contest->save();
			}            
        }

        $view = new View();
        $view->setView('newConcours');
        $view->putData('styles', ['home']);
        $view->putData('form', $this->form);
        $view->putData('err', $err);
    }

    public function editAction()
    {

        $concours = new Contest();
        $concours = $concours->getOneWhere(["id" => $_REQUEST['id']]);

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

        foreach($links as $linkCurrent){
			foreach($photos as $photoCurrent){
				if($linkCurrent->id_photo == $photoCurrent->id && $linkCurrent->id_contest == $contestCurrent->id){
					$listPhotosForCurrentContest[] = $photoCurrent;  // liste les photos qui appartiennent au concours courant
					$albums = $fb->getFBUserData("1250869114948648?fields=albums{name,photos{source}}");
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

