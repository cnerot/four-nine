<?php
session_start();
require_once __DIR__ . '/../media/vendor/autoload.php';

//TODO:: test FB object;
class FBApp
{
    private $fb;
    private $permissions;
    private $loginhelper;
    private $callback;

    public function __construct()
    {
        $this->fb = new Facebook\Facebook([
            'app_id' => Config::FB_ID,
            'app_secret' => Config::FB_SECRET,
            'default_graph_version' => 'v2.5',
        ]);
        $this->loginhelper = $this->fb->getRedirectLoginHelper();

        if (isset($_SESSION['facebook_access_token'])){
            $this->fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }
    }

    public function printFBLogin($callback, $permissions = [], $login_text = 'Log in with Facebook!', $logged_text = 'Logged in with FB!!')
    {
        if (!isset($_SESSION['facebook_access_token'])){
            $this->loginhelper = $this->fb->getRedirectLoginHelper();
            $loginUrl = $this->loginhelper->getLoginUrl($callback, $permissions);
            echo '<a href="' . $loginUrl . '">' . $login_text . '</a>';
        } else {
            echo '<p>' .$logged_text. '</p>';
        }
    }

    public function fbCallback()
    {
        try {
            $accessToken = $this->loginhelper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            Logger::logExeption($e);
            return false;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            Logger::logExeption($e);
            return false;
        }
        if (! isset($accessToken)) {
            if ($this->loginhelper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                $error = "Error: " . $this->loginhelper->getError() . "\n";
                $error .= "Error Code: " . $this->loginhelper->getErrorCode() . "\n";
                $error .= "Error Reason: " . $this->loginhelper->getErrorReason() . "\n";
                $error .= "Error Description: " . $this->loginhelper->getErrorDescription() . "\n";
                Logger::log($error);
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
        } else {
            $SESSION['facebook_access_token'] = (string)$accessToken;
            $this->fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            return true;
        }
        return false;


    }

    public function getFBData($fb_query)
    {
        return $this->fb->get($fb_query);
    }

}