<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ConcourController
{
    /**
     * This will execute before every action
     * @param $args
     */
    public function preDeploy($args){

    }
    /**
    * This will execute after every action
    * @param $args
    */
    public function postDeploy($args){


    }
    public function indexAction($args)
    {
        $view = new View();
        $view->setView('gestionConcour');
        $view->putData('styles', ['home']);
    }
    public function newAction($args)
    {
        $view = new View();
        $view->setView('newConcour');
        $view->putData('styles', ['home']);
    }
    
    public function voteAction($args)
    {
		$view = new View();
        $view->setView('voteConcours');
        $view->putData('styles', ['home']);
        $view->putData('styles', ['gallery']);
	}
}
  
