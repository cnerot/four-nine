<?php

/**
 * Created by PhpStorm.
 * User: Charles
 */
class Staticpages extends Entity
{
    public $idStaticpages;
    public $title;
    public $content;

    /**
     * @return mixed
     */
    public function getIdStaticpages()
    {
        return $this->idStaticpages;
    }

    /**
     * @param mixed $idStaticpages
     */
    public function setIdStaticpages($idStaticpages)
    {
        $this->idStaticpages = $idStaticpages;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }


}