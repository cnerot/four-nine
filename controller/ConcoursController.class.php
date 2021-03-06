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
        Router::redirect('Concours', 'index');
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
                $message = str_replace('{title}', $data['name'],$message);
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
                "name" => $data['name'],
                "description" => $data['description'],
                "start" => DateTime::createFromFormat("d/m/Y",$data['start']),
                "end" => DateTime::createFromFormat("d/m/Y",$data['end']),
                "photo" => $newFbId,
            ];
            //Logger::debug($data);
            $contest->fromArray($contest_data);
            
            $contests = $contest->getWhere([]);
            $dateStart = DateTime::createFromFormat("d/m/Y",$data['start'])->format('Y-m-d');
            //$dateStart = explode("/", $data['start']);
            //$dateStart = $dateStart[2]."-".$dateStart[1]."-".$dateStart[0]; // transformation de la date du format français vers le format anglo saxon
            $dateEnd = DateTime::createFromFormat("d/m/Y",$data['start'])->format('Y-m-d');
            //$dateEnd = explode("/", $data['end']);
            //$dateEnd = $dateEnd[2]."-".$dateEnd[1]."-".$dateEnd[0]; // transformation de la date du format français vers le format anglo saxon
                        
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
                Alert::addAlert('Concours ajouté');
            } else {
                foreach ($err as $item) {
                    Alert::addAlert($item);
                }
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

}
  
