<?php

class FacebookController
{
    public function LoginFailedAction($args){

    }
    public function callbackAction($args)
    {
        $fb = new FBApp();
        if ($fb->fbCallback()){
			$session = $fb->getFBUserData("/me")['id'];
            $User = new User();
			$userExists = $User->getWhere(['id_user'=>$session]);
			if(empty($userExists)){
				$User->setIdUser($session);
				$User->setToken($_SESSION['facebook_access_token']);
				$User->setName($fb->getFBUserData("/me")['name']);
				$User->save();
			}
            $_SESSION['idUser'] = $session;
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