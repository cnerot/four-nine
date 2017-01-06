<?php
class Config {

    /* display error */
    const DEV_MODE = true;
    /* die on error */
    const DIE_MODE = true;


    /*Urls & path*/
    const URL = 'http://www.fournine.dev/';
    //const URL = 'http://localhost/fournine/';
    //const PATH = 'C:\xampp\htdocs\fournine';
    const PATH = 'C:\xampp\htdocs\fournine';

    /*Facebook Data*/
    const DATA_PAGE_TOKEN = 'EAACEdEose0cBAMZAZANWB0xjy8G1AMwErsVEJmXGODr9nBxalndsohIMmpGvdVa0wjETnVDYvuiddXoZBuY4CYIl3qUoCZBgZCKsV8lJZB7cgArGKlr8lGLN9PxCCSsvs4KqkDLWx19sUwlsb2HsDufbCd75Izzr1bCO2ZB6ZBU3zQZDZD';
    const DATA_PAGE_ID = '218906198517590';
    const FB_ID = '1107373735984316';
    const FB_SECRET = '7591bd0c73ee79d013e714c5b1ca2177';
    const FB_CALLBACK = 'http://www.fournine.dev/facebook/callback';
    //const FB_APP_TOKEN = "1107373735984316|5bfq0Cjm7ydfn5k6YFJ445N0a1U";
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
    const DB_PASSWORD = 'doudou';
    const DB_USER = 'root';
}
