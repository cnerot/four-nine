<?php

class IndexController
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
        $view->setView('indexIndex');
        $view->putData('name', 'moi');
        $view->putData('styles', ['home']);
    }
}