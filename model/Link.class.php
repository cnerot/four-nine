<?php

/**
 * Created by PhpStorm.
 * User: Charles
 */
class Link extends Entity
{
    public $idLink;
    public $id_photo;
    public $id_concours;

    /**
     * @return mixed
     */
    public function getIdLink()
    {
        return $this->idLink;
    }

    /**
     * @param mixed $idLink
     */
    public function setIdLink($idLink)
    {
        $this->idLink = $idLink;
    }

    /**
     * @return mixed
     */
    public function getIdPhoto()
    {
        return $this->id_photo;
    }

    /**
     * @param mixed $id_photo
     */
    public function setIdPhoto($id_photo)
    {
        $this->id_photo = $id_photo;
    }

    /**
     * @return mixed
     */
    public function getIdConcours()
    {
        return $this->id_concours;
    }

    /**
     * @param mixed $id_concours
     */
    public function setIdConcours($id_concours)
    {
        $this->id_concours = $id_concours;
    }


}