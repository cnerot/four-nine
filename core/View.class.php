<?php

class View
{
    /**
     * @var string Path to the layout file
     */
    protected $layout;

    /**
     * @var string Path to the view file
     */
    protected $view;

    /**
     * @var array Data we should pass to the view
     */
    protected $data = [];

    /**
     * Sets the current view
     * Generates a 404 error if view of template does not exists
     * @param $view
     * @param string $layout
     */
    public function setView($view, $layout = 'template')
    {
        $viewPath = Config::VIEW_PATH . DIRECTORY_SEPARATOR . $view . '.php';
        $layoutPath = Config::TEMPLATE_PATH . DIRECTORY_SEPARATOR . $layout . '.php';

        if (!file_exists($viewPath)) {
            print_r('La vue n\'existe pas');
            exit;
        }
        if (!file_exists($layoutPath) && $layout != 'no_layout') {
            print_r('Le layout n\'existe pas');
            exit;
        }

        $this->view = $viewPath;
        $this->layout = $layoutPath;
        if ($layout == 'no_layout'){
            $this->layout = "no_layout";
        }
    }
    public function getChild($name, $data){
        extract($data);
        include trim($this->view, '.php'). DIRECTORY_SEPARATOR . $name . '.php';

    }

    /**
     * Put key => value into data
     * @param $key
     * @param $value
     */
    public function putData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Prints the view on destroy
     */
    public function __destruct()
    {
        extract($this->data);
        if ($this->layout == 'no_layout'){
            include $this->view;
        } else {
            include $this->layout;
        }
    }
}