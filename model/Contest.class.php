<?php

/**
 * Created by PhpStorm.
 * User: Charles
 */
class Contest extends Entity
{
    public $id;
    public $start;
    public $end;
    public $name;
    public $description;

    /**
     * @return mixed
     */
    public function getCurrent()
    {
        $today = date('Y-m-d');
        $contestsStart = $this->getWhere(['start' => ['operator' => 'less_equal', "value" => $today]]); // récupère contests quand date début du concours commencée
        $contestsEnd = $this->getWhere(['end' => ['operator' => 'greater_equal', "value" => $today]]); // récupère contests quand date fin du concours non atteinte

        // récupère le concours en cours

        foreach ($contestsStart as $contestStartCurrent) {
            foreach ($contestsEnd as $contestEndCurrent) {
                if ($contestStartCurrent->id == $contestEndCurrent->id) {
                    $contestCurrent = $contestStartCurrent;
                }
            }
        }
        if (!empty($contestCurrent)){
            return $contestCurrent;
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
     * @param mixed $concoursId
     */
    public function setId($concoursId)
    {
        $this->concoursId = $concoursId;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
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