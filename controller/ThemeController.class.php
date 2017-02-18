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
                    "validation" => "radio",
                    "value" => 'jj',
                    "label" => 'Couleur d\'arriere plan',
                    "class" => '',
                    "div_class"=> 'theme',
                    "div_color1"=> 'pink darken-1',
                    "div_color2"=> 'red darken-1',
                    "div_color3"=> 'purple darken-1',
                    "div_color4"=> 'indigo darken-4',
                    "div_color5"=> 'blue darken-4',
                    "div_color6"=> 'blue accent-1',
                    "div_color7"=> 'teal darken-1',
                    "div_color8"=> 'teal accent-4',
                    "div_color9"=> 'light-green darken-4',
                    "div_color10"=> 'green accent-4',
                    "div_color11"=> 'yellow lighten-1',
                    "div_color12"=> 'amber lighten-1',
                    "div_color13"=> 'yellow darken-2',
                    "div_color14"=> 'yellow accent-4',
                    "div_color15"=> 'amber accent-3',
                    "div_color16"=> 'orange accent-3',
                    "div_color17"=> 'orange accent-4',
                    "div_color18"=> 'orange darken-4',
                    "div_color19"=> 'deep-orange darken-4',
                    "div_color20"=> 'brown darken-4',
                    "div_color21"=> 'grey darken-4',
                    "div_color22"=> 'grey darken-3',
                    "div_color23"=> 'grey darken-2',
                    "div_color24"=> 'grey',
                    "div_color25"=> 'black',
                    "div_color26"=> 'white',
                    "div_color27"=> 'transparent',
                ],
                "bgImage" => [
                    "type" => "file",
                    "validation" => "file",
                    "value" => '',
                    "label" => 'Image d\'arriere plan pour accueil',
                    "class"=> 'radio-border theme'
                ],
                "bgNavColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur de header :',
                    "class"=> 'black radio-border theme',
                    "div_class"=> 'theme'
                ],
                "iconHomeColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur de l\'icon home :',
                    "class"=> 'black radio-border theme',
                    "div_class"=> 'theme'
                ],
                "iconOffColor" => [
                    "type" => "radio",
                    "validation" => "date",
                    "value" => '',
                    "label" => 'Couleur de l\'icon se deconnecter',
                    "class"=> 'black radio-border theme',
                    "div_class"=> 'theme'
                ],
                "nameColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur de "pardon maman"',
                    "class"=> 'black radio-border theme',
                    "div_class"=> 'theme'
                ],
                "titleColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur de titre:',
                    "class"=> '',
                    "div_class"=> 'theme'
                ],
                "textNavColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'couleur de texte de la bare de navigation :',
                    "class"=> '',
                    "div_class"=> 'theme'
                ],
                "textColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur du texte :',
                    "class"=> '',
                    "div_class"=> 'theme'
                ],
                "btnColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur des button home : ',
                    "class"=> '',
                    "div_class"=> 'theme'
                ],
                "textBtnColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'couleur du text des btn home : ',
                    "class"=> '',
                    "div_class"=> 'theme'
                ],
                "collapsibleHeader" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur des header des pages static : ',
                    "class"=> '',
                    "div_class"=> 'theme'
                ],
                "collapsibleBody" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur des conteneur des static :',
                    "class"=> '',
                    "div_class"=> 'theme'
                ],
                "pageStat" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur de l\'arriere plan des titres : ',
                    "class"=> 'yellow',
                    "div_class"=> 'theme yellow'
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
  
