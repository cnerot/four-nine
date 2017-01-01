<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ConcoursController
{
    /**
     * This will execute before every action
     * @param $args
     */
    public function preDeploy($args){

    }
    public function indexAction($args)
    {
        $view = new View();
        $view->setView('gestionConcours');
        $view->putData('styles', ['home']);
    }
    public function newAction($args)
    {
        $view = new View();
        $view->setView('newConcours');
        $view->putData('styles', ['home']);
    }
    
    public function voteAction($args)
    {
	$view = new View();
        $view->setView('voteConcours');
        $view->putData('styles', ['home','gallery']);
        //$view->putData('styles', ['gallery']); ->reecrire surcharge home
 
    }
}
  
