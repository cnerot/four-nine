<?php

/**
 * Created by PhpStorm.
 * User: Charles
 */
class Concours extends Entity
{
    public $concoursId;
    public $date_debut;
    public $date_fin;
    public $nom;
    public $description;

    /**
     * @return mixed
     */
    public function getConcoursId()
    {
        return $this->concoursId;
    }

    /**
     * @param mixed $concoursId
     */
    public function setConcoursId($concoursId)
    {
        $this->concoursId = $concoursId;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->date_debut;
    }

    /**
     * @param mixed $date_debut
     */
    public function setDateDebut($date_debut)
    {
        $this->date_debut = $date_debut;
    }

    /**
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->date_fin;
    }

    /**
     * @param mixed $date_fin
     */
    public function setDateFin($date_fin)
    {
        $this->date_fin = $date_fin;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


}