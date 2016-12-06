<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AdminController
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
        $view->setView('staticMenu');
        $view->putData('name', 'moi');
        $view->putData('styles', ['home']);

    }
}