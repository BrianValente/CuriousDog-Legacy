<?php
/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 5/27/17
 * Time: 20:28
 */

namespace Ask\Page;

use Ask\Social\Twitter;
use Ask\Users\UsersManager;
use Ask\Utils;

include_once "class/Utils.php";

class Register {


    public static function init(): void {
        if (!self::checkData())
            return;

        $twitterApi = Utils::getTwitterConnection();
        $twitterApi->setAccessToken($_SESSION["twitter_oauth_token"], $_SESSION["twitter_oauth_token_secret"]);

        $twitterUser = $twitterApi->getUser();

        $userArray = [
            'name' => $twitterUser->name,
            'username' => $twitterUser->screen_name,
            'registration_date' => Utils::currentTime(),
            'profile_description' => $twitterUser->description,
            'profile_color_accent' => '#' . $twitterUser->profile_background_color,
            'twitter_id' => $twitterUser->id,
            'twitter_token' => $_SESSION["twitter_oauth_token"],
            'twitter_token_secret' => $_SESSION["twitter_oauth_token_secret"],
        ];

        $smarty = Utils::getSmarty();
        $smarty->assign('twitter_user', $userArray);
        $smarty->assign('siteTitle', Utils::website_name . Utils::separator_w_space . 'Registro');
        $smarty->display('register_twitter.tpl');
    }

    public static function checkPassword(string $password): ?String {
        // TODO: this method SUCKSSSSS

        if (!self::checkData())
            return null;

        if (strlen($password) == 0)
            return null;


        $twitterApi = Utils::getTwitterConnection();
        $twitterApi->setAccessToken($_SESSION["twitter_oauth_token"], $_SESSION["twitter_oauth_token_secret"]);

        $twitterUser = $twitterApi->getUser();

        $database = Utils::getDatabase();

        $name = $database->escape_string($twitterUser->name);
        $username = $database->escape_string($twitterUser->screen_name);
        $password = $database->escape_string(md5($password));
        $registration_date = Utils::currentTime();
        $profile_description = $database->escape_string($twitterUser->description);
        $profile_color_accent = $database->escape_string('#' . $twitterUser->profile_link_color);
        $twitter_id = $twitterUser->id;
        $twitter_token = $database->escape_string($_SESSION["twitter_oauth_token"]);
        $twitter_token_secret = $database->escape_string($_SESSION["twitter_oauth_token_secret"]);


        $result = Utils::getDatabase()->query("INSERT INTO users (name, username, password_md5, registration_date, profile_description, profile_color_accent, twitter_id, twitter_token, twitter_token_secret) VALUES ('$name', '$username', '$password', $registration_date, '$profile_description', '$profile_color_accent', $twitter_id, '$twitter_token', '$twitter_token_secret')");

        if ($result)
            UsersManager::setLoggedUser(Utils::getDatabase()->insert_id);
        else
            return Utils::getDatabase()->error;

        return null;
    }

    private static function checkData(): bool {
        if (UsersManager::isLogged()) {
            Utils::redirectHome();
            return false;
        }

        if (!(isset($_SESSION["twitter_oauth_token"]) && isset($_SESSION["twitter_oauth_token_secret"]))) {
            echo 'not implemented';
            return false;
        }

        return true;
    }
}