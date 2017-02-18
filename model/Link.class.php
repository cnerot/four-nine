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

    public function getCurrentUserLink($user_id, $contest_id){
        $links = $this->getWhere(['id_contest' =>$contest_id]);
        $photos = (new Photo())->getWhere(['id_user' => $user_id]);
        foreach ($links as $link){
            foreach ($photos as $photo){
                if ($link->getIdPhoto() == $photo->getId()){
                    return $link;
                }
            }
        }
        return false;
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