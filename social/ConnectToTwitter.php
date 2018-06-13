<?php
/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 5/3/17
 * Time: 05:16
 */

namespace Ask\Social;

set_include_path("/var/www/curiousdog.tk/");

error_reporting(E_ALL); ini_set('display_errors', 1);


include_once 'class/Utils.php';

use Ask\Users\UsersManager;
use Ask\Utils;
use Exception;

class ConnectToTwitter {
    /**
     * @var Twitter
     */
    private static $twitterApi;

    public static function init() {
        self::$twitterApi = Utils::getTwitterConnection();

        if (isset($_REQUEST['denied'])) {
            echo 'okay :(';
            return;
        }

        if (isset($_REQUEST['oauth_verifier']) && isset($_SESSION["oauth_token"]) && isset($_SESSION["oauth_token_secret"])) {
            self::verifyCredentials();
        } else {
            self::startAuthentication();
        }
    }

    private static function startAuthentication() {
        $_SESSION["oauth_token"] = null;
        $_SESSION["oauth_token_secret"] = null;

        $request_token = self::$twitterApi->getRequestToken();

        if (!$request_token["oauth_callback_confirmed"]) {
            echo "There was an error.";
            return;
        }

        $requestUrl = self::$twitterApi->getRequestTokenUrl($request_token);

        header("Location: $requestUrl");

        $_SESSION["oauth_token"] = $request_token["oauth_token"];
        $_SESSION["oauth_token_secret"] = $request_token["oauth_token_secret"];
    }

    private static function verifyCredentials() {
        self::$twitterApi->setAccessToken($_SESSION["oauth_token"], $_SESSION["oauth_token_secret"]);
        $accessToken = self::$twitterApi->getConnection()->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);
        $user = UsersManager::getUserByTwitterId($accessToken['user_id']);

        $_SESSION["oauth_token"] = null;
        $_SESSION["oauth_token_secret"] = null;

        if (UsersManager::isLogged()) {
            // Connecting account
            if ($user != null && Utils::getLoggedUser()->getTwitterId() != $accessToken['user_id']) {
                echo 'ERROR: esta cuenta ya está enlazada con una cuenta existente, la bardeaste papu';
                return;
            }

            $user = Utils::getLoggedUser();
        } else if ($user != null) {
            // Logging in with Twitter
            UsersManager::setLoggedUser($user->getId());
        } else {
            // Creating a new account with Twitter
            $_SESSION["twitter_oauth_token"] = $accessToken["oauth_token"];
            $_SESSION["twitter_oauth_token_secret"] = $accessToken["oauth_token_secret"];
            $url = Utils::url . 'register';
            header("Location: $url");
            return;
        }

        // Update tokens
        self::$twitterApi->saveUserAccessToken($user, $accessToken);

        $homeUrl = Utils::url;
        header("Location: $homeUrl");
    }
}

ConnectToTwitter::init();
