<?php
function cmp($a, $b)
{
    return $b['final_grade'] - $a['final_grade'];
}
class IndexController
{
    /**
     * This will execute before every action
     * @param $args
     */
    public function preDeploy($args)
    {


    }

    /**
     * This will execute after every action
     * @param $args
     */
    public function postDeploy($args)
    {

    }

    public function indexAction($args)
    {
        $view = new View();
        $view->setView('indexIndex');
        $view->putData('name', 'moi');
        $view->putData('styles', ['home']);
    }

    public function checkWinnerAction()
    {
        $concours = (new Contest())->getWhere([]);
        $today = getdate();
        foreach ($concours as $concour) {
            $datetime1 = date_create_from_format('Y-m-d', $concour->getEnd());
            $datetime2 = date_create_from_format('Y-m-d', date('Y-m-d'));
            if ($datetime1 == $datetime2) {
                $contest = $concour;
            }
        }

        if (!isset($contest)) {
            return;
        }
        //var_dump($contest);

        $votes = (new Vote())->getWhere([]);
        $vote_count = array();
        foreach ($votes as $vote) {
            $link = (new Link())->getOneWhere(['id' => $vote->getIdLink()]);
            if ($link->getIdContest() != $contest->getId()) {
                continue;
            }
            if (isset($vote_count[$link->getIdPhoto()])) {
                $vote_count[$link->getIdPhoto()]["total"] += $vote->getGrade();
                $vote_count[$link->getIdPhoto()]["count"] += 1;
            } else {
                $vote_count[$link->getIdPhoto()]["total"] = $vote->getGrade();
                $vote_count[$link->getIdPhoto()]["count"] = 1;
            }
        }
        $vote_count_processed = array();
        foreach ($vote_count as $key => $vote) {
            $vote_count_processed[] = array(
                'id'            => $key,
                'final_grade'   => $vote["total"]/$vote['count']
            );
        }
        usort($vote_count_processed, 'cmp');

        $winners = array();
        $firstwinner = array_shift($vote_count_processed);
        $winners[] = $firstwinner;
        $element = array_shift($vote_count_processed);
        while ($firstwinner['final_grade'] == $element['final_grade']){
            $winners[] = $element;
            $element = array_shift($vote_count_processed);
        }

        if (Config::SINGLE_WINNER){
            $single_winner = array();
            $winner_key = array_rand($winners);
            $single_winner[] = $winners[$winner_key];
            $winners = $single_winner;
        }

        foreach ($winners as $winner){
            //TODO: Notify winners & admin
        }
    }
}