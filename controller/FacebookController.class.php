<?php

class FacebookController
{
    public function LoginFailedAction($args){

    }
    public function callbackAction($args)
    {
        $fb = new FBApp();
        if ($fb->fbCallback()){
			$_SESSION['idUser'] = $fb->getFBUserData("/me")['id'];
			$User = new User();
			$userExists = $User->getWhere(['id_user_fb'=>$_SESSION['idUser']]);
			if(empty($userExists)){
				$User->setIdUserFb($_SESSION['idUser']);
				$User->setToken($_SESSION['facebook_access_token']);
				$User->setName($fb->getFBUserData("/me")['name']);
				
				$User->save();
			}
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