<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ConcoursController
{
    private $form;

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
                    "value" => ''
                ],
                "end" => [
                    "type" => "date",
                    "validation" => "date",
                    "value" => ''
                ],
                "title" => [
                    "type" => "text",
                    "validation" => "text",
                    "value" => ''
                ],
                "prize" => [
                    "type" => "text",
                    "validation" => "text",
                    "value" => ''
                ],
                "prize_img" => [
                    "type" => "file",
                    "validation" => "file",
                    "value" => ''
                ],
                "description" => [
                    "type" => "textarea",
                    "validation" => "text",
                    "value" => ''
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
        if ($data) {
            $concours->fromArray($data);
            $concours->save();
        }

        $view = new View();
        $view->setView('newConcours');
        $view->putData('form', $this->form);
        $view->putData('concours', $concours);

    }

    public function voteAction($args)
    {
        $view = new View();
        $view->setView('voteConcours');
        $view->putData('styles', ['gallery']);
    }
}
  
