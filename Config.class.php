<?php
class Config {

    /* display error */
    const DEV_MODE = true;
    /* die on error */
    const DIE_MODE = false;


    /*Urls & path*/
    const URL = 'http://vps323708.ovh.net/';
    //const URL = 'http://localhost/fournine/';
    //const PATH = 'C:\xampp\htdocs\fournine';
    const PATH = '/var/www/html';

    /*Facebook Data*/
   
    /*Facebook Data*/
    const DATA_PAGE_ID = '1250869114948648';
    const FB_ID = '1107373735984316';
    const FB_SECRET = '7591bd0c73ee79d013e714c5b1ca2177';
    const FB_CALLBACK = 'http://vps323708.ovh.net/facebook/callback';
    /*Base path*/
    const CONTROLLER_PATH = 'controller';
    const CORE_PATH = 'core';
    const VIEW_PATH = 'view';
    const TEMPLATE_PATH = 'view/template';
    const MODEL_PATH = 'model';
    const HELPER_PATH = 'helper';
    const LOG_DIR = 'media/log';
    const CSS_DIR = 'media/css';
    const UPLOAD_FOLDER = 'media/imgFiles';

    /*Database data*/
    const DB_HOST = 'localhost';
    const DB_NAME = 'four';
    const DB_PASSWORD = 'fournine'; 
    const DB_USER = 'root';
}
