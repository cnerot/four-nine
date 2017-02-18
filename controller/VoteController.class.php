<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VoteController
{
    private $voteform;

    public function preDeploy($args)
    {
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
        $vote = new Vote();
        $vote = $vote->getWhere();

        $Contest = new Contest();
        $today = date('Y-m-d');
        $contestsStart = $Contest->getWhere(['start' => ['operator' => 'less_equal', "value" => $today]]); // récupère contests quand date début du concours commencée
        $contestsEnd = $Contest->getWhere(['end' => ['operator' => 'greater_equal', "value" => $today]]); // récupère contests quand date fin du concours non atteinte

        // récupère le concours en cours

        foreach ($contestsStart as $contestStartCurrent) {
            foreach ($contestsEnd as $contestEndCurrent) {
                if ($contestStartCurrent->id == $contestEndCurrent->id) {
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
        foreach ($links as $linkCurrent) {
            foreach ($photos as $photoCurrent) {
                if ($linkCurrent->id_photo == $photoCurrent->id && $linkCurrent->id_contest == $contestCurrent->id) {
                    $listPhotosForCurrentContest[] = $photoCurrent;  // liste les photos qui appartiennent au concours courant
                    $albums = $fb->getFBUserData(Config::DATA_PAGE_ID . "?fields=albums{name,photos{source}}");
                    if (isset($albums['albums'])) {
                        $albums = $albums['albums']['data'];
                    } else {
                        $albums = [];
                    }
                    foreach ($albums as $album_) {
                        if (!empty($album_['photos'])) {
                            foreach ($album_['photos']['data'] as $album) {
                                if ($photoCurrent->id_fb == $album['id']) {

                                    $listPhotosForCurrentContest[$i]->infosPhotoFb = ['id' => $album['id'], 'source' => $album['source']];
                                    $i++;
                                }
                            }
                        }
                    }
                }
            }
        }

        $_SESSION['idContest'] = $contestCurrent->id;
        $view = new View();
        $view->setView('voteConcours');
        $view->putData('styles', ['gallery', 'stars']);
        $view->putData('voteForm', $this->voteform);
        $view->putData('contestCurrent', $contestCurrent);
        $view->putData('listPhotos', $listPhotosForCurrentContest);
    }
}
  
