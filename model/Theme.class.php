<?php

/**
 * Created by PhpStorm.
 * User: Charles
 */
class Theme extends Entity
{
    public $id;
    public $name;
    public $bgColor;
    public $bgImage;
    public $bgNavColor;
    public $textColor;
    public $btnColor;
    public $iconHomeColor; 
    public $iconOffColor;
    public $nameColor;
    public $titleColor; 
    public $textNavColor;
    public $textBtnColor;
    public $collapsibleHeader;
    public $collapsibleBody;
    public $pageStat;
    public $applicated;


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
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @param mixed $bgImage
     */
    public function setBgImage($bgImage)
    {
        $this->bgImage = $bgImage;
    }
	
	/**
     * @return mixed
     */
    public function getBgImage()
    {
        return $this->bgImage;
    }


	
	/**
     * @return mixed
     */
    public function getBgNavColor()
    {
        return $this->bgNavColor;
    }

    /**
     * @param mixed $navColor
     */
    public function setNavColor($bgNavColor)
    {
        $this->bgNavColor = $bgNavColor;
    }

    /**
     * @return mixed
     */
    public function getTextColor()
    {
        return $this->textColor;
    }

    /**
     * @param mixed $textColor
     */
    public function setTextColor($textColor)
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
    /**
     * @return mixed
     */
    public function getIconHomeColor()
    {
        return $this->iconHomeColor;
    }

    /**
     * @param mixed setIconHomeColor
     */
    public function setIconHomeColor($iconHomeColor)
    {
        $this->iconHomeColor = $iconHomeColor;
    }
    /**
     * @return mixed
     */
    public function getIconOffColor()
    {
        return $this->iconOffColor;
    }

    /**
     * @param mixed $iconOffColor
     */
    public function setIconOffColor($iconOffColor)
    {
        $this->iconOffColor = $iconOffColor;
    }
    /**
     * @return mixed
     */
    public function getNameColor()
    {
        return $this->nameColor;
    }

    /**
     * @param mixed $nameColor
     */
    public function setNameColor($nameColor)
    {
        $this->nameColor = $nameColor;
    }
    /**
     * @return mixed
     */
    public function getTitleColor()
    {
        return $this->titleColor;
    }

    /**
     * @param mixed $titleColor
     */
    public function setTitleColor($titleColor)
    {
        $this->titleColor = $titleColor;
    }
    /**
     * @return mixed
     */
    public function getTextNavColor()
    {
        return $this->textNavColor;
    }

    /**
     * @param mixed $textNavColor
     */
    public function setTextNavColor($textNavColor)
    {
        $this->textNavColor = $textNavColor;
    }
    /**
     * @return mixed
     */
    public function getTextBtnColor()
    {
        return $this->textBtnColor;
    }

    /**
     * @param mixed $textBtnColor
     */
    public function setTextBtnColor($textBtnColor)
    {
        $this->textBtnColor = $textBtnColor;
    }
    /**
     * @return mixed
     */
    public function getCollapsibleHeader()
    {
        return $this->collapsibleHeader;
    }

    /**
     * @param mixed $collapsibleHeader
     */
    public function setCollapsibleHeader($collapsibleHeader)
    {
        $this->collapsibleHeader = $collapsibleHeader;
    }
    /**
     * @return mixed
     */
    public function getCollapsibleBody()
    {
        return $this->collapsibleBody;
    }

    /**
     * @param mixed $collapsibleBody
     */
    public function setCollapsibleBody($collapsibleBody)
    {
        $this->collapsibleBody = $collapsibleBody;
    }
    /**
     * @return mixed
     */
    public function getPageStat()
    {
        return $this->pageStat;
    }

    /**
     * @param mixed $pageStat
     */
    public function setPageStat($pageStat)
    {
        $this->pageStat = $pageStat;
    }
    /**
     * @return mixed
     */
    public function getApplicated()
    {
        return $this->applicated;
    }

    /**
     * @param mixed $applicated
     */
    public function setApplicated($applicated)
    {
        $this->applicated = $applicated;
    }
   
}