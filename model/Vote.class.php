<?php

/**
 * Created by PhpStorm.
 * User: Charles
 */
class Vote extends Entity
{
    public $id;
    public $grade;
    public $id_utilisateurs;
    public $id_link;

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
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param mixed $grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
    }

    /**
     * @return mixed
     */
    public function getIdUtilisateurs()
    {
        return $this->id_utilisateurs;
    }

    /**
     * @param mixed $id_utilisateurs
     */
    public function setIdUtilisateurs($id_utilisateurs)
    {
        $this->id_utilisateurs = $id_utilisateurs;
    }

    /**
     * @return mixed
     */
    public function getIdLink()
    {
        return $this->id_link;
    }

    /**
     * @param mixed $id_link
     */
    public function setIdLink($id_link)
    {
        $this->id_link = $id_link;
    }



}