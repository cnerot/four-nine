<?php

/**
 * Created by PhpStorm.
 * User: Charles
 */
class Photo extends Entity
{
    public $idPhoto;
    public $description;
    public $date_ajout;
    public $id_utilisateur;
    public $titre;

    /**
     * @return mixed
     */
    public function getIdPhoto()
    {
        return $this->idPhoto;
    }

    /**
     * @param mixed $idPhoto
     */
    public function setIdPhoto($idPhoto)
    {
        $this->idPhoto = $idPhoto;
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

    /**
     * @return mixed
     */
    public function getDateAjout()
    {
        return $this->date_ajout;
    }

    /**
     * @param mixed $date_ajout
     */
    public function setDateAjout($date_ajout)
    {
        $this->date_ajout = $date_ajout;
    }

    /**
     * @return mixed
     */
    public function getIdUtilisateur()
    {
        return $this->id_utilisateur;
    }

    /**
     * @param mixed $id_utilisateur
     */
    public function setIdUtilisateur($id_utilisateur)
    {
        $this->id_utilisateur = $id_utilisateur;
    }

    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

}