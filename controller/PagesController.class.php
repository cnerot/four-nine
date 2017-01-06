<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PagesController
{
    public $form;

    public function preDeploy($args)
    {
        $this->form = new Form([
            'options' => [
                'method' => 'POST',
                'action' => '#',
                'submit' => 'Send',
                'name' => 'postform',
                'class' => '',
                'enctype' => "multipart/form-data"
            ],
            'data' => [
                "title" => [
                    "type" => "text",
                    "validation" => "text",
                    "value" => ''
                ],
                "content" => [
                    "type" => "textarea",
                    "validation" => "text",
                    "value" => ''
                ],
            ]
        ]);
    }

    /**
     * Static pages main
     */
    public function indexAction($args)
    {
        $page = new Staticpages();
        $data = $this->form->validate();
        if ($data){
            if (isset($_POST['seperator'])){
                $pages = $page->getWhere(['id'=>$_POST['seperator']]);
                $data['id'] = $_POST['seperator'];
            }
            $page->fromArray($data);
            $page->save();
        }
        $pages = $page->getWhere([]);

        $view = new View();
        $view->setView('staticMenu');
        $view->putData('pages', $pages);
        $view->putData('form', $this->form);

    }

    /**
     * Needed for clonable element
     */
    public function ajaxAction($args)
    {
        $data = $this->form->validate();
        if ($data){
            $page = new Staticpages();
            $page->fromArray($data);
            $page->save();
        }
        $view = new View();
        $view->setView('staticMenu/clonable', 'no_layout');
        $view->putData('form', $this->form);
    }
}