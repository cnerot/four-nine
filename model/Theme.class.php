<?php

/**
 * Created by PhpStorm.
 * User: Charles
 */
class Theme extends Entity
{
    public $id;
    public $bgColor;
    public $navColor;
    public $textColor;
    public $btnColor;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @param mixed $bgColor
     */
    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;
    }
	
	/**
     * @return mixed
     */
    public function getBgColor()
    {
        return $this->bgColor;
    }


	
	/**
     * @return mixed
     */
    public function getNavColor()
    {
        return $this->navColor;
    }

    /**
     * @param mixed $navColor
     */
    public function setNavColor($navColor)
    {
        $this->navColor = $navColor;
    }

    /**
     * @return mixed
     */
    public function getTextColor()
    {
        return $this->TextColor;
    }

    /**
     * @param mixed $textColor
     */
    public function setName($textColor)
    {
        $this->textColor = $textColor;
    }

    /**
     * @return mixed
     */
    public function getBtnColor()
    {
        return $this->btnColor;
    }

    /**
     * @param mixed $btnColor
     */
    public function setBtnColor($btnColor)
    {
        $this->btnColor = $btnColor;
    }

}