<?php

/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 10/02/16
 * Time: 10:19
 */
class Logger
{


    public static function debug($data){

        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
    public static function logExeption(Exception $data){
        Logger::log($data->__toString(), "exeption");
    }

    /**
     * @param $data -> string to be logged
     * @param string $file -> no ending needed
     */
    public static function log($data, $file = "system")
    {
        if (!is_dir(Config::LOG_DIR)) {
            mkdir(Config::LOG_DIR, 0777, true);
        }
        if (!is_string($data)) {
            echo "log data must be string";
            die();
        }
        if (Config::DEV_MODE) {
            echo "$data";
        } else {
            $log_string = date(DATE_ATOM) . PHP_EOL;
            $log_string .= $data . PHP_EOL;
            file_put_contents(Config::LOG_DIR . "/" . $file . ".log",$log_string, FILE_APPEND);
        }
        if (Config::DIE_MODE) {
            die();
        }
    }
}