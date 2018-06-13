<?php
/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 1/2/17
 * Time: 11:30
 */

namespace Ask;

set_include_path("/var/www/curiousdog.tk/");

include_once "class/LocalConfig.php";
include_once 'page/Notifications.php';
include_once 'page/Profile.php';
include_once 'page/Settings.php';
include_once 'page/Register.php';
include_once 'social/Twitter.php';
include_once 'library/twitteroauth/autoload.php';
require_once "library/Smarty/Smarty.class.php";
include_once 'Questions/QuestionsManager.php';
include_once 'Questions/Question.php';
include_once 'Users/UsersManager.php';
include_once 'Users/User.php';
include_once 'Database/Database.php';
include_once 'Database/Query.php';

use Ask\Users\User;
use Ask\Users\UsersManager;
use mysqli;
use Smarty;
use Ask\Social\Twitter;

if (LocalConfig::DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

class Utils {
    public const url = "https://curiousdog.tk/";
    public const website_name = "Curious Dog";
    public const website_description = "Pregúntale a otros acerca de su vida";
    public const website_description_long = "En " . Utils::website_name . " puedes preguntar a cualquiera lo que quieras, incluso de forma anónima, comentar, y compartir posts. ¿Que esperas para unirte?";
    public const website_full_title = self::website_name . self::separator_w_space . self::website_description;
    public const separator = "|";
    public const separator_w_space = " | ";
    public const uploads_url = "https://curiousdog.tk/uploads/";
    public const default_profile_title = "";

    public const color_accent = "#222222";
    public const color_browser = "#222222";

    public const session_expiry = 31556952000;

    public const uploads_folder = "/var/www/curiousdog.tk/uploads/";



    /**
     * @var Smarty
     */
    private static $smarty;

    /**
     * @var mysqli
     */
    private static $database;






    /* DATE AND TIME */

    /**
     * @param int $timestamp
     * @return String
     */
    public static function getAgoDate($timestamp): String {
        $date = Utils::currentTime();
        $dateago = $date - $timestamp;

        if ($dateago < 60000)      // less than a minute
            return "Hace instantes";
        else if ($dateago < 120000)     // less than 2 minutes
            return "Hace un minuto";
        else if ($dateago < 3600000)    // less than an hour
            return "Hace " . floor($dateago / 60000) . " minutos";
        else if ($dateago < 7200000)   // less than two hours
            return "Hace una hora";
        else if ($dateago < 86399904)   // less than a day
            return "Hace " . floor($dateago / 3600000) . " horas";
        else if ($dateago < 172800000)  // less than two days
            return "Hace un día";
        else if ($dateago < 2628000000) // less than a month
            return "Hace " . floor($dateago / 86400000) . " dias";
        else if ($dateago < 5256006000)// less than a year
            return "Hace un mes";
        else if ($dateago < 31540000000)// less than a year
            return "Hace " . floor($dateago / 2628000000) . " meses";
        else if ($dateago < 63080000000)// less than two years
            return "Hace un año";
        else
            return "Hace " . floor($dateago / 31540000000) . " años";
    }

    /**
     * @return int
     */
    public static function currentTime(): int {
        return round(microtime(true) * 1000);
    }










    /* DATABASE */

    /**
     * @return mysqli
     * @deprecated xd
     */
    public static function getDatabase(): mysqli {
        if (!self::$database) {
            self::$database = mysqli_connect(LocalConfig::DB_HOST, LocalConfig::DB_USER, LocalConfig::DB_PASSWORD, LocalConfig::DB_NAME);
            self::$database->set_charset("utf8mb4");
        }

        return self::$database;
    }










    /* USER */

    /**
     * @return null|User
     */
    public static function getLoggedUser(): ?User {
        return UsersManager::getLoggedUser();
    }


    /* Questions */

    /**
     * @param $id
     * @return null|array
     */
    public static function getQuestionById($id): ?array {
        return self::getDatabase()->query("SELECT * FROM questions WHERE id='$id'")->fetch_assoc();
    }








    /* Miscellaneous */

    public static function init(): void {
        session_start();
    }

    /**
     * @return Smarty
     */
    public static function getSmarty(): Smarty {
        if (self::$smarty == null) {
            self::$smarty = new Smarty();

            self::$smarty->setTemplateDir('smarty/templates');
            self::$smarty->setCompileDir('smarty/templates_c');
            self::$smarty->setCacheDir('smarty/cache');
            self::$smarty->setConfigDir('smarty/configs');
            self::$smarty->setPluginsDir('smarty/plugins');

            self::$smarty->assign('isLogged',              UsersManager::isLogged());
            self::$smarty->assign('translucentHeader',     false);
            self::$smarty->assign('siteTitle',             self::website_full_title);
            self::$smarty->assign('siteMediaTitle',        self::website_name);
            self::$smarty->assign('siteMediaDescription',  self::website_description);
            self::$smarty->assign('siteDescriptionLong',   self::website_description_long);
            self::$smarty->assign('siteUrl',               self::url);
            self::$smarty->assign('colorBrowser',          self::color_browser);
            self::$smarty->assign('colorAccent',           self::color_accent);

            if (UsersManager::isLogged()) {
                self::$smarty->assign('username', self::getLoggedUser()->getUsername());
                self::$smarty->assign('userName', self::getLoggedUser()->getName());
                self::$smarty->assign('userDescription', self::getLoggedUser()->getProfileDescription());
                self::$smarty->assign('userPictureUrl', self::getLoggedUser()->getUserProfilePictureUrl());
                self::$smarty->assign('userHeaderUrl', self::getLoggedUser()->getUserProfileHeaderUrl());
                self::$smarty->assign('colorAccent', self::getLoggedUser()->getProfileColorAccent());
                self::$smarty->assign('loggedUser', self::getLoggedUser());
            }
        }

        return self::$smarty;
    }

    /**
     * @return null|String
     */
    public static function getArgument(): ?String {
        return self::getArguments()[0];
    }

    public static function getArguments(): ?array {
        if (isset($_GET['argument'])) {
            $arguments = $_GET['argument'];
            if (strcmp(substr($arguments, 0, 1), "/") == 0)
                $arguments = substr($arguments, 1);
            $arguments = explode("/", $arguments);
            return $arguments;
        } else
            return null;
    }

    public static function redirectHome(): void {
        header('Location: ' . self::url);
    }

    public static function throw404() {
        self::getSmarty()->display('404.tpl');
        exit;
    }

    public static function getTwitterConnection(): Twitter {
        $twitter = new Twitter();

        if (UsersManager::isLogged() && self::getLoggedUser()->getTwitterToken() != null) {
            $twitter->setAccessToken(self::getLoggedUser()->getTwitterToken(), self::getLoggedUser()->getTwitterTokenSecret());
        }

        return $twitter;
    }
}


Utils::init();
