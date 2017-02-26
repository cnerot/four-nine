<?php

class Alert
{
	public static function addAlert($string_content){
		if (!isset($_SESSION['alert'])){
			$_SESSION['alert'] = array();
		}
		$_SESSION['alert'][] = '"' . $string_content . '"';
	}
}