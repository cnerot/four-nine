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


        $albums = $fb->getFBUserData("/me?fields=albums{name,photos{source}}");
        if (isset($albums['albums'])) {
            $albums = $albums['albums']['data'];
        } else {
            $albums = [];
        }
        $view = new View();
        $view->setView('photoSelect');
        $view->putData('albums', $albums);
		
		
		
		
		
		
		$Photo = new Photo();
        //$data = $this->form->validate();
		
		$data = ["description"=>4, "created"=>1];
		
		$idUser = 1;
		
		$Photo->setDescription("desc");
		$Photo->setIdUser($idUser); // récupérer idUser
		$Photo->setTitle("titre");
		
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
		
		// ":".$contestCurrent->start.":<br>";
		
		$photosUser = $Photo->getWhere(['id_user' => $idUser]);
		
		$Link = new Link();
		
		$links = $Link->getWhere([]);
		
		foreach($links as $linkCurrent){
			foreach($photosUser as $photoUserCurrent){
				if($linkCurrent->id_photo == $photoUserCurrent->id && $linkCurrent->id_contest == $contestCurrent->id){
					$photosAlreadyAddForThisContest[] = $photoUserCurrent;
				}
			}
		}
		
	
		
		//echo "<pre>";
		//	print_r($contests);
		//echo "</pre>";
		
		
		
		$Photo->save();
		
		/*echo "<br>a<pre>b";
			print_r($data);
		echo "c</pre>d";
		
        if ($data && !$data['error']) {
            if (isset($_POST['seperator'])) {
                $pages = $page->getWhere(['id' => $_POST['seperator']]);
                $data['id'] = $_POST['seperator'];
            }
            $page->fromArray($data);
            $page->save();
        }
        $pages = $page->getWhere([]);

        $view = new View();
        $view->setView('staticMenu');
        $view->putData('pages', $pages);
        $view->putData('form', $this->form);*/
    }
    public function testAction($args)
    {
        $fb = new FBApp();
        $data = $fb->getFBUserData('app');
        Logger::debug($data);
    }
}