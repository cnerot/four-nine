<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VoteController
{
    private $form;

    public function preDeploy($args)
    {
        $this->form = new Form([
            'options' => [
                'method' => 'POST',
                'action' => Router::getUrl('vote', 'ajax'),
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
                    "values" => array(
                        '1',
                        '2',
                        '3',
                        '4',
                        '5',
                    ),
                    "class" => 'star',
                ],
            ]
        ]);

    }

    public function ajaxAction($args)
    {
        session_start();
        $vote = (new Vote())->getOneWhere(['id_link' => $_POST["link"], 'id_utilisateurs' => $_SESSION['idUser']]);
        if (empty($vote)) {
            $vote = new Vote();
        }
        $vote->setIdLink($_POST['link']);
        $vote->setIdUtilisateurs($_SESSION['idUser']);
        $vote->setGrade($_POST['grade']);
        $vote->save();

    }

    public function voteAction($args)
    {
        $fb = new FBApp();

        $err = [];

        $contestCurrent = (new Contest())->getCurrent();

        if ($contestCurrent) {
            $links = (new Link())->getWhere(['id_contest' => $contestCurrent->getId()]);

            $listPhotosForCurrentContest = array();

            foreach ($links as $link) {
                $photo = (new Photo())->getOneWhere(['id' => $link->getIdPhoto()]);
                $fbPhoto = $fb->getFBPageData($photo->getIdFb() . "?fields=source");
                $fbPhoto = $fbPhoto->getDecodedBody();
                $photo_user = (new User())->getOneWhere(['id_user'=>$photo->getIdUser()]);
                $votes = (new Vote())->getWhere(['id_link'=>$link->getId()]);
                $total_grade = 0;
                foreach ($votes as $vote){
                    $total_grade += $vote->getGrade();
                }

                $listPhotosForCurrentContest[] = [
                    'id' => $photo->getIdFb(),
                    'source' => $fbPhoto['source'],
                    'link_id' => $link->getId(),
                    'grade' => round($total_grade/count($votes),2),
                    'user' => $photo_user->getName(),
                ];
            }
        } else {
            $msg = (new Contest())->getNext();

            $err[] = $msg;

            if ($msg == false) {
                $err[] = "Aucun concours prévu pour le moment";
            }
        }
        $view = new View();
        $view->setView('voteConcours');
        $view->putData('styles', ['gallery', 'stars']);
        $view->putData('voteform', $this->form);
        $view->putData('contestCurrent', $contestCurrent);
        $view->putData('err', $err);
        if (isset($listPhotosForCurrentContest))
            $view->putData('listPhotos', $listPhotosForCurrentContest);
    }
}
  
