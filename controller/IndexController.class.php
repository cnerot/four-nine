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

        Logger::log("this is an other error");
        $view = new View();
        $view->setView('indexIndex');
        $view->putData('name', 'moi');
        $view->putData('styles', ['home']);

    }
}