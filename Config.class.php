<?php
class Config {

    /* display error */
    const DEV_MODE = true;
    /* die on error */
    const DIE_MODE = true;


    /*Urls & path*/
    //const URL = 'http://four-nine.local.fr/';
    const URL = 'http://localhost/fournine/';
    //const PATH = 'C:\xampp\htdocs\fournine';
    const PATH = 'C:\xampp\htdocs\fournine';

    /*Facebook Data*/
    const FB_ID = '1107373735984316';
    const FB_SECRET = '7591bd0c73ee79d013e714c5b1ca2177';

    /*Base path*/
    const CONTROLLER_PATH = 'controller';
    const CORE_PATH = 'core';
    const VIEW_PATH = 'view';
    const TEMPLATE_PATH = 'view/template';
    const MODEL_PATH = 'model';
    const LOG_DIR = 'media/log';
    const CSS_DIR = 'media/css';

    /*Database data*/
    const DB_HOST = 'localhost';
    const DB_NAME = 'fournine';
    const DB_PASSWORD = '';
    const DB_USER = 'root';
}
