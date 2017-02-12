<?php

class Cron
{
	
	public function cron_init(){
	}

	public function cron_update(){
		//read xml;
		$xmlstr = file_get_contents(Config::PATH."/cronjob/cron.xml");

		$jobs = new SimpleXMLElement($xmlstr);
		$times = array("minute","hour","day_of_month","month","day_of_week");

		$job_string = "";
		foreach ($jobs->job as $job) {
			foreach ($times as $time) {
				echo '<pre>';
				var_dump((string)$job->time->$time);
				echo '</pre>';
				if (((string)$job->time->$time) != ''){
					$job_string .= ((string)$job->time->$time) . " ";
				} else {
					$job_string .= "* ";
				}
			}
			$job_string .= $job->cmd . PHP_EOL;
		}
		var_dump($job_string);

		$output = shell_exec('crontab -l');
		file_put_contents('/tmp/crontab.txt', $output.$job_string);
		echo exec('crontab /tmp/crontab.txt');
	}

}