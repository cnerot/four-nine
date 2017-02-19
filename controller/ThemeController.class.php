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
        $colors = array(
                      'pink darken-1',
                       'red darken-1',
                       'purple darken-1',
                       'indigo darken-4',
                       'blue darken-4',
                       'blue accent-1',
                       'teal darken-1',
                       'teal accent-4',
                       'light-green darken-4',
                       'green accent-4',
                       'yellow lighten-1',
                       'amber lighten-1',
                       'yellow darken-2',
                       'yellow accent-4',
                       'amber accent-3',
                       'orange accent-3',
                       'orange accent-4',
                       'orange darken-4',
                       'deep-orange darken-4',
                       'brown darken-4',
                       'grey darken-4',
                       'grey darken-3',
                       'grey darken-2',
                       'grey',
                       'black',
                       'white',
                       'transparent',);
        
        $this->theme = new Form([
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
                    "class" => 'center-align',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "bgImage" => [
                    "type" => "file",
                    "validation" => "file",
                    "value" => '',
                    "placeholder" => 'Image d\'arriere plan pour accueil',
                    "class"=> 'radio-border theme',
                    "div_class" =>'btn amber accent-4',
                    "file_class" =>'file-field input-field',
                    "icon_class" =>'material-icons left',
                    "icon_content" =>'add_a_photo',
                    "class_wrapper" =>'file-path-wrapper',
                    "class_inputWrapper" =>'file-path validate',
                    "type_inputWrapper" =>'text',
                ],
                "bgNavColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur de header :',
                    "class"=> 'theme',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                    
                ],
                "iconHomeColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur de l\'icon home :',
                    "class"=> 'theme',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                    
                ],
                "iconOffColor" => [
                    "type" => "radio",
                    "validation" => "date",
                    "value" => '',
                    "label" => 'Couleur de l\'icon se deconnecter',
                    "class"=> 'theme',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "nameColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur de "pardon maman"',
                    "class"=> 'theme',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "titleColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur de titre:',
                    "class"=> '',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "textNavColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'couleur de texte de la bare de navigation :',
                    "class"=> '',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "textColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur du texte :',
                    "class"=> '',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "btnColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur des button home : ',
                    "class"=> '',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "textBtnColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'couleur du text des btn home : ',
                    "class"=> '',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "collapsibleHeader" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur des header des pages static : ',
                    "class"=> '',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "collapsibleBody" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur des conteneur des static :',
                    "class"=> '',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "pageStat" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur de l\'arriere plan des titres : ',
                    "class"=> '',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
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
  
