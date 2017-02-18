<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ThemeController
{
    private $theme;

    public function preDeploy($args)
    {
        if (!(new FBApp())->isAdmin()){
            Router::redirect();
        }
        $this->theme = new FormTheme([
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
                "name" => [
                    "type" => "text",
                    "validation" => "text",
                    "value" => '',
                    "label" => 'Nom du theme :',
                    "class"=> 'input-field'
                ],
                "bgColor" => [
                    "type" => "radio",
                    "validation" => "date",
                    "value" => '',
                    "label" => '',
                    "class"=> ''
                ],
                "bgImage" => [
                    "type" => "radio",
                    "validation" => "date",
                    "value" => '',
                    "label" => '',
                    "class"=> ''
                ],
                "bgNavColor" => [
                    "type" => "radio",
                    "validation" => "date",
                    "value" => '',
                    "label" => '',
                    "class"=> ''
                ],
                "iconHomeColor" => [
                    "type" => "radio",
                    "validation" => "date",
                    "value" => '',
                    "label" => '',
                    "class"=> ''
                ],
                "bgColor" => [
                    "type" => "radio",
                    "validation" => "date",
                    "value" => '',
                    "label" => '',
                    "class"=> ''
                ],
                "bgColor" => [
                    "type" => "radio",
                    "validation" => "date",
                    "value" => '',
                    "label" => '',
                    "class"=> ''
                ],
               
            ]
        ]);
            
    
    }
    public function indexAction($args)
    {

        $view = new View();
        $view->setView('gestionTheme');
        $view->putData('styles', ['home']);
        $view->putData('theme', $this->theme);
    }

    public function deleteAction($args){
     
    }
    public function newAction($args)
    {
       //a faire 

        $view = new View();
        $view->setView('gestionTheme');
        $view->putData('styles', ['home']);
        $view->putData('theme', $this->theme);
    }

    public  function editAction()
    {
        //a faire
        
        $view = new View();
        $view->setView('gestionTheme');
        $view->putData('theme', $this->theme);

    }
}
  
