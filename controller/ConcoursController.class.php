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
                'submit' => 'Send',
                'name' => 'postform',
                'class' => '',
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
       // $fb = new FBApp();
       // $data = $fb->getFBUserData('app');
      // besoin de user/ link de l'images/ note  
        $data = $this->voteform->validate();
        if ($data) {
            $vote = new Vote();
            $vote->fromArray($data);
            $vote->save();
        }
        $view = new View();
        $view->setView('staticMenu/voter', 'no_layout');
        $view->putData('voteform', $this->voteform);
    }

    public function voteAction($args)
    {
        $vote = new Vote();
        $vote = $vote->getWhere();
        
        $view = new View();
        $view->setView('voteConcours');
        $view->putData('styles', ['gallery','stars']);
        $view->putData('voteform', $this->voteform);
    }
}
  
