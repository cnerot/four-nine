<?php
session_start();
require_once __DIR__ . '/../lib/vendor/autoload.php';

//TODO:: test FB object;
class FBApp
{
    private $fbCallback;
    private $fbPermissions;

    public $fb;
    private $permissions;
    private $loginhelper;
    private $callback;
    private $logoutUrl;

	private $fbAppToken;

    /***
     * FBApp constructor.
     *
     * Initilises FB app / Get login helper / set token if need be
     */
    public function __construct()
    {
		$this->fbCallback = Config::URL . 'facebook/callback';
		$this->logoutUrl = Config::URL . 'facebook/logout';
		$this->fbPermissions = ['user_photos','publish_actions', 'manage_pages'];
        $this->fb = new Facebook\Facebook([
            'app_id' => Config::FB_ID,
            'app_secret' => Config::FB_SECRET,
            'default_graph_version' => 'v2.5',
            'fileUpload' => true
        ]);
        $this->loginhelper = $this->fb->getRedirectLoginHelper();

        if (isset($_SESSION['facebook_access_token'])) {
            $this->fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }
		$this->fbAppToken = "1107373735984316|5bfq0Cjm7ydfn5k6YFJ445N0a1U";
    }


    /**
     * Print login button or login success
     *
     * @param string $login_text
     * @param string $logged_text
     */

    public function getLoginUrl(){
        $this->loginhelper = $this->fb->getRedirectLoginHelper();
        return $this->loginhelper->getLoginUrl($this->fbCallback, $this->fbPermissions);
    }
    public function getLogoutUrl(){
        return $this->logoutUrl;
    }
    /**
     * Only used on FB callback page
     *
     * @return bool
     */
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
        if (!isset($accessToken)) {
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
            $_SESSION['facebook_access_token'] = (string)$accessToken;
            $this->fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            return true;
        }
        return false;


    }
    /**
     * Check if user is logged in with fb
     *
     * @return bool
     */
    public function isLogged()
    {
        if (isset($_SESSION['facebook_access_token'])) {
            return true;
        }
        return false;
    }
    public function logout()
    {
        unset($_SESSION['facebook_access_token']);
    }


    /**
     * Get data from App or User
     *
     * @param $fb_query -> check graph API
     * @return \Facebook\FacebookResponse
     */
    public function getFBUserData($fb_query)
    {
        return $this->fb->get($fb_query)->getDecodedBody();
    }

    public function getFBAppData($fb_query)
    {
        return $this->fb->get($fb_query, $this->fbAppToken)->getDecodedBody();
    }

	/**
     * @param $fb_query
     * @return \Facebook\FacebookResponse
     */
    public function postFBData($fb_query, $object)
    {
        return $this->fb->post($fb_query, $object);
    }
    public function getFBPageData($fb_query, $object)
    {
        $token = $this->getFBUserData(Config::DATA_PAGE_ID.'?fields=access_token');
        return $this->fb->get($fb_query, $token['access_token']);
    }
    public function postFBPageData($fb_query, $object)
    {
        $token = $this->getFBUserData(Config::DATA_PAGE_ID.'?fields=access_token');
        return $this->fb->post($fb_query, $object, $token['access_token']);
    }
    public function isAdmin()
    {
        $idUser = $this->getFBUserData('/me?fields=id')["id"];
        $app_roles = $this->getFBAppData('/app/roles')['data'];

        foreach($app_roles as $value){
            // cherche le rôle de l'utilisateur connecté
            if($value["user"] == $idUser
                && $value["role"] == "administrators"){
                return true;
            }
        }

        return false;
    }
}