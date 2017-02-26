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
                'method'    => 'POST',
                'action'    => '#',
                'submit'    => 'Valider',
                'name'      => 'postform',
                'class'     => '',
                'enctype'   => "multipart/form-data",
                'id'        => 'static_form'
            ],
            'data' => [
                "title" => [
                    "type" => "text",
                    "validation" => "text",
                    "value" => '',
                    "class" => 'validate',
                    "div_class" => 'input-field no-margin'
                ],
                "content" => [
                    "type" => "textarea",
                    "validation" => "wysiwyg",
                    "value" => '',
                    "class" => 'materialize-textarea',
                    "div_class" => 'input-field',
                    "id" => 'textarea1',
                ],
            ]
        ]);
    }

    /**
     * Static pages main
     */
    public function indexAction($args)
    {
        if (!(new FBApp())->isAdmin()) {
            Router::redirect();
        }
        $page = new Staticpages();
        $data = $this->form->validate();

        if ($data && !$data['error']['error']) {
            if (isset($_POST['seperator'])) {
                $pages = $page->getWhere(['id' => $_POST['seperator']]);
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
        if ($data) {
            $page = new Staticpages();
            $page->fromArray($data);
            $page->save();
        }
        $view = new View();
        $view->setView('staticMenu/clonable', 'no_layout');
        $view->putData('form', $this->form);
    }

    public function deleteAction($args){
        $page = (new Staticpages())->getOneWhere(['id'=>$args['id']]);
        $page->delete();
        Router::redirect('Pages','index');
    }
    public function showAction($args)
    {
        $content = (new Staticpages())->getOneWhere(['id'=>$args['id']])->getContent();

        $view = new View();
        $view->setView('pageShow');
        $view->putData('content', $content);
    }
}
