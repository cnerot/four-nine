<?php

/**
 * Created by PhpStorm.
 * User: Charles
 */
class Link extends Entity
{
    public $id;
    public $id_photo;
    public $id_contest;

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
    public function getIdContest()
    {
        return $this->id_contest;
    }

    /**
     * @param mixed $id_contest
     */
    public function setIdContest($id_contest)
    {
        $this->id_contest = $id_contest;
    }

}