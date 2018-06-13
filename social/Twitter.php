<?php
/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 5/2/17
 * Time: 21:51
 */

namespace Ask\Social;

include_once 'class/Utils.php';

use Ask\Users\User;
use Ask\Utils;
use Abraham\TwitterOAuth\TwitterOAuth;
use stdClass;

class Twitter {
    private const OAUTH_CALLBACK = Utils::url . "social/ConnectToTwitter.php";
    private const CONSUMER_KEY = "";
    private const CONSUMER_SECRET = "";
    private $isLogged = false;

    private $connection;

    function __construct() {
        $this->connection = new TwitterOAuth($this::CONSUMER_KEY, $this::CONSUMER_SECRET);
    }

    function setAccessToken($accessToken, $accessTokenSecret) {
        $this->connection = new TwitterOAuth(self::CONSUMER_KEY, self::CONSUMER_SECRET, $accessToken, $accessTokenSecret);
        $this->isLogged = true;
    }

    public function getRequestToken(): array {
        return $this->connection->oauth('oauth/request_token', array('oauth_callback' => self::OAUTH_CALLBACK));
    }

    public function getUser(): stdClass {
        return $this->connection->get("account/verify_credentials");
    }

    public function isLogged(): bool {
        return $this->isLogged;
    }


    /**
     * Returns the Twitter auth URL to redirect the user to log in.
     * @param $request_token array
     * @return String
     */
    public function getRequestTokenUrl($request_token): String {
        $url = $this->connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
        return $url;
    }

    public function sendTextTweet($data) {
        $tweet = $this->connection->post("statuses/update", ["status" => $data]);
    }

    public function getConnection(): TwitterOAuth {
        return $this->connection;
    }

    public function saveUserAccessToken(User $user, $accessToken) {
        $user->setTwitterId($accessToken['user_id']);
        $user->setTwitterAuthToken($accessToken["oauth_token"]);
        $user->setTwitterAuthTokenSecret($accessToken["oauth_token_secret"]);
    }
}