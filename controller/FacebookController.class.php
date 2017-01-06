<?php

class FacebookController
{
    public function LoginFailedAction($args){

    }
    public function callbackAction($args)
    {
        $fb = new FBApp();
        if ($fb->fbCallback()){
            Router::redirect();
        } else {
            echo "login failed";
        }
    }
    public function logoutAction($args)
    {
        $fb = new FBApp();
        $fb->logout();
        Router::redirect();
    }
}