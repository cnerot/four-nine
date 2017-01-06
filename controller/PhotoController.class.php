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

        $albums = $fb->getFBUserData("/me?fields=albums{name,photos{source}}")['albums']['data'];

        $view = new View();
        $view->setView('photoSelect');
        $view->putData('albums', $albums);
    }
}