<?php
session_start();
require_once __DIR__ . '/../lib/vendor/autoload.php';

//TODO:: test FB object;
class FBApp
{
    private $fbCallback;
    private $fbPermissions;


    private $fb;
    private $permissions;
    private $loginhelper;
    private $callback;

    /***
     * FBApp constructor.
     *
     * Initilises FB app / Get login helper / set token if need be
     */
    public function __construct()
    {
		$this->fbCallback = Config::URL . 'facebook/callback';
		$this->fbPermissions = ['user_photos'];
        $this->fb = new Facebook\Facebook([
            'app_id' => Config::FB_ID,
            'app_secret' => Config::FB_SECRET,
            'default_graph_version' => 'v2.5',
        ]);
        $this->loginhelper = $this->fb->getRedirectLoginHelper();

        if (isset($_SESSION['facebook_access_token'])) {
            $this->fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }
    }


    /**
     * Print login button or login success
     *
     * @param string $login_text
     * @param string $logged_text
     */
    //TODO: update for better more options
    public function printFBLogin($login_text = 'Log in with Facebook!', $logged_text = 'Logged in with FB!!')
    {
        if (!isset($_SESSION['facebook_access_token'])) {
            $this->loginhelper = $this->fb->getRedirectLoginHelper();
            $loginUrl = $this->loginhelper->getLoginUrl($this->fbCallback, $this->fbPermissions);
            echo '<a href="' . $loginUrl . '">' . $login_text . '</a>';
        } else {
            echo '<p>' . $logged_text . '</p>';
        }
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


    /**
     * Get data from App or User
     *
     * @param $fb_query -> check graph API
     * @return \Facebook\FacebookResponse
     */
    public function getFBData($fb_query)
    {
        return $this->fb->get($fb_query);
    }

    /**
     * @param $fb_query
     * @return \Facebook\FacebookResponse
     */
    public function postFBData($fb_query, $object)
    {
        return $this->fb->post($fb_query, $object);

    }

    /**
     * @param $file -> Path of file to upload
     * @param $fbpath -> Where to put it in Fb -> check graph api
     * @param $name -> File name
     * @param string $message -> Upload message or msg to attach to pic => needs to be verified
     * @return true on success
     */
    //TODO:: test upload
    public function upload($file, $fbpath, $name, $message = "Uploaded with fournine")
    {
        $batch = [
            $name => $this->fb->request('POST', $fbpath, [
                'message' => $message,
                'source' => $this->fb->fileToUpload('$file'),
            ])
        ];
        try {
            $responses = $this->fb->sendBatchRequest($batch);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            Logger::logExeption($e);
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            Logger::logExeption($e);
            exit;
        }
        $return_status = true;
        foreach ($responses as $key => $response) {
            if ($response->isError()) {
                $e = $response->getThrownException();
                Logger::logExeption($e);
                $return_status = true;
            }
        }
        return $return_status;
    }

}