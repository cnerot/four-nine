<?php

/**
 * Created by PhpStorm.
 * User: Charles
 */
class Photo extends Entity
{
    public $id;
    public $description;
    public $created;
    public $id_user;
    public $title;
    public $id_fb;

    public function getCurrentUserPhoto($user_id, $contest_id){
        $links = (new Link())->getWhere(['id_contest' =>$contest_id]);
        $photos = $this->getWhere(['id_user' => $user_id]);
        foreach ($links as $link){
            foreach ($photos as $photo){
                if ($link->getIdPhoto() == $photo->getId()){
                    return $photo;
                }
            }
        }
        return false;
    }
    public function getFbPhotoUrl(){
        $fb = new FBApp();
        $data = $fb->getFBPageData($this->getIdFb() . '?fields=source');
        $decodedBody = $data->getDecodedBody();
        return $decodedBody["source"];
    }

    /**
     * @return mixed
     */
    public function getIdFb()
    {
        return $this->id_fb;
    }

    /**
     * @param mixed $id_fb
     */
    public function setIdFb($id_fb)
    {
        $this->id_fb = $id_fb;
    }

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
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
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

}