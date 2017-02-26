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
        if (!(new FBApp())->isAdmin()) {
            Router::redirect();
        }
        $theme = new Theme();
        $themes = $theme->getWhere();

        $colors = array(
            'pink darken-1',
            'pink lighten-2',
            'red darken-4',
            'red accent-4',
            'red darken-1',
            'purple accent-1',
            'purple darken-1',
            'purple darken-3',
            'indigo darken-4',
            'indigo darken-1',
            'blue darken-4',
            'blue accent-1',
            'light-blue darken-3',
            'teal darken-1',
            'teal accent-4',
            'teal',
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
            'brown lighten-2',
            'brown darken-1',
            'brown darken-2',
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
                'action' => '/Theme/new',
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
                    "class" => 'black-text',
                    'div_class' => 'input'
                ],
                "bgColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur d\'arriere plan :',
                    "class" => 'black-text',
                    "div_class" => 'theme',
                    "div_color" => $colors
                ],
                "bgImage" => [
                    "type" => "file",
                    "validation" => "file",
                    "value" => '',
                    "placeholder" => 'Image d\'arriere plan pour la page d\'accueil',
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
                    "label" => 'Couleur de header/footer(menu) :',
                    "class"=> '',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                    
                ],
                "textNavColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "text" =>'1',
                    "label" => 'couleur du texte de la bare de navigation :',
                    "class"=> '',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "iconHomeColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "text" => '1',
                    "value" => '',
                    "label" => 'Couleur de l\'icon home :',
                    "class" => '',
                    "div_class" => 'theme',
                    "div_color" => $colors

                ],
                "iconOffColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "text" => '1',
                    "value" => '',
                    "label" => 'Couleur de l\'icon se deconnecter :',
                    "class" => '',
                    "div_class" => 'theme',
                    "div_color" => $colors
                ],
                "nameColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur de "pardon maman" :',
                    "class" => '',
                    "div_class" => 'theme',
                    "div_color" => $colors
                ],
                "titleColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "text" =>'1',
                    "label" => 'Couleur du titre de la page d\'accueil :',
                    "class"=> '',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "textColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "text" =>'1',
                    "label" => 'Couleur du texte de site :',
                    "class"=> 'black-text',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "btnColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur des buttons "je participe/je vote" : ',
                    "class"=> '',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "textBtnColor" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "text" =>'1',
                    "label" => 'couleur du text des buttons "je participe/je vote" : ',
                    "class"=> '',
                    "div_class"=> 'theme',
                    "div_color"=> $colors
                ],
                "collapsibleHeader" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur des header des pages static : ',
                    "class" => '',
                    "div_class" => 'theme',
                    "div_color" => $colors
                ],
                "collapsibleBody" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "label" => 'Couleur des conteneur des static :',
                    "class" => '',
                    "div_class" => 'theme',
                    "div_color" => $colors
                ],
                "pageStat" => [
                    "type" => "radio",
                    "validation" => "radio",
                    "value" => '',
                    "text" => '1',
                    "label" => 'Couleur des titres des pages : ',
                    "class" => '',
                    "div_class" => 'theme',
                    "div_color" => $colors
                ],

            ]
        ]);
        $this->themeChoice = new Form([
            'options' => [
                'method' => 'POST',
                'action' => '/Theme/edit',
                'submit' => 'Appliquer',
                'name' => 'postform',
                'class' => '',
                "id" => 'test',
                'enctype' => "multipart/form-data"
            ],
            'data' => [
                "select" => [
                    "type" => "select",
                    "validation" => "select",
                    "themes" => $themes,
                    "label" => 'choisir le théme à appliquer :',
                    "class" => 'browser-default black-text',
                    'div_class' => ''
                ]
            ]
        ]);


    }

    public function indexAction($args)
    {

        $view = new View();
        $view->setView('gestionTheme');
        $view->putData('styles', ['home']);
        $view->putData('themeChoice', $this->themeChoice);
        $view->putData('theme', $this->theme);
    }

    public function deleteAction($args)
    {

    }

    public function newAction($args)
    {
        //a faire
        $data = $this->theme->validate();
        if ($data && !$data['error']['error']) {
            $theme = new Theme();
            if (isset($_FILES['bgImage'])) {
                if (file_exists(Config::UPLOAD_FOLDER . "/" . $_FILES['bgImage']['name'])) {
                    $error[] = "Il exist deja une image de ce nom";
                    $err = true;
                }
                if ($_FILES['bgImage']['type'] != "image/png" && $_FILES['bgImage']['type'] != "image/jpeg") {
                    $error[] = "Veuillez sélectionner une image de type png ou jpg";
                    $err = true;
                }
                if ($_FILES['bgImage']['size'] > 10000000) {
                    $error[] = "Veuillez sélectionner un fichier de 10 mo maximum";
                    $err = true;
                }
                $path = $_FILES['bgImage']['tmp_name'];
                if (!$err) {
                    if (move_uploaded_file($path, Config::UPLOAD_FOLDER . "/" . $_FILES['bgImage']['name'])) {
                        $data['bgImage'] = Config::UPLOAD_FOLDER . "/" . $_FILES['bgImage']['name'];
                    } else {
                        $error[] = "Veuillez sélectionner un fichier de 10 mo maximum";
                    }
                }
            }
            //**** on bouge l'image
            $theme_data = [
                "name" => $data['name'],
                "bgColor" => $data['bgColor'],
                "bgImage" => $data['bgImage'],
                "bgNavColor" => $data['bgNavColor'],
                "iconHomeColor" => $data['iconHomeColor'],
                "iconOffColor" => $data['iconOffColor'],
                "nameColor" => $data['nameColor'],
                "titleColor" => $data['titleColor'],
                "textNavColor" => $data['textNavColor'],
                "textColor" => $data['textColor'],
                "btnColor" => $data['btnColor'],
                "textBtnColor" => $data['textBtnColor'],
                "collapsibleHeader" => $data['collapsibleHeader'],
                "collapsibleBody" => $data['collapsibleBody'],
                "pageStat" => $data['pageStat'],
                "applicated" => false,
            ];
            //Logger::debug($data);
            $theme->fromArray($theme_data);
            $theme->save();
            if (isset($error)) {
                foreach ($error as $err) {
                    Alert::addAlert($err);
                }
            }
        } else {
            if ($data['error']['error']) {
                foreach ($data["error"]['fields'] as $form_error) {
                    Alert::addAlert('champs invalide: ' . $form_error);
                }

            }
        }
        $view = new View();
        $view->setView('gestionTheme');
        $view->putData('styles', ['home']);
        $view->putData('themeChoice', $this->themeChoice);
        $view->putData('theme', $this->theme);
    }

    public function editAction()
    {
        $theme = (new Theme())->getOneWhere(['id' => $_POST["select"]]);
        if (empty($theme)) {
            echo '<script>Le thème n\'exite plus.</script>';
        }
        $themeApplicated = (new Theme())->getWhere(['applicated' => true]);
        if (isset($themeApplicated)) {
            foreach ($themeApplicated as $themeApp) {
                $themeApp->setApplicated(false);
                $themeApp->save();
            }
        }
        $theme->setApplicated(true);
        $theme->save();

        $view = new View();
        $view->setView('gestionTheme');
        $view->putData('themeChoice', $this->themeChoice);
        $view->putData('theme', $this->theme);

    }
}
  
