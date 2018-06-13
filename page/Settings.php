<?php
/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 1/14/17
 * Time: 10:04
 */

namespace Ask\Page;

include_once 'class/Utils.php';

use Ask\Users\UsersManager;
use Ask\Utils;

class Settings {
    public static function init(): void {
        $smarty = Utils::getSmarty();

        $smarty->assign('siteTitle', Utils::website_name . Utils::separator_w_space . 'Configuración');

        if (!UsersManager::isLogged()) {
            $smarty->assign("userPictureUrl", "https://ask.brianvalente.tk/uploads/profile/picture/0.jpg");
            $guest['name'] = "Guest";
            $guest['profile_description'] = "Description";
            $guest['email_address'] = "guest@brianvalente.tk";
            $guest['birth_date'] = "01/03/1999";
            $guest['username'] = "guest";
            $smarty->assign('loggedUser', $guest);
            $smarty->assign('colorAccent', '#168EBA');
        }

        $twitter = Utils::getTwitterConnection();
        if ($twitter->isLogged()) {
            $userData = $twitter->getUser();
            /*$profilePictureUrl = $userData->profile_image_url;
            $profileName = $userData->name;
            $profileScreenName = $userData->screen_name;
            echo $profilePictureUrl . " " . $profileName . " " . $profileScreenName;*/
            $smarty->assign("twitter_account", $userData);
        }

        $smarty->display('settings.tpl');
    }
}