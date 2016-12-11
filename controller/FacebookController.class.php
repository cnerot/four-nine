<?php

class FacebookController
{
    public function callbackAction($args)
    {
        $fb = new FBApp();
        if ($fb->fbCallback()){
            echo "login success";
        } else {
            echo "login failed";
        }
    }
}