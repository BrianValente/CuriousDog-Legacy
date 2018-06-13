<?php
/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 12/31/16
 * Time: 14:39
 */

namespace Ask;

include_once "class/Utils.php";

use Ask\Database\Database;
use Ask\Database\Query;
use Ask\Page\Profile;
use Ask\Page\Notifications;
use Ask\Page\Register;
use Ask\Page\Settings;
use Ask\Question\QuestionsManager;

class Index {
    public static function init(): void {
        $argument = Utils::getArgument();
        if ($argument != null) {
            switch ($argument) {
                default:
                    Profile::init();
                    break;
                case 'notifications':
                    Notifications::init();
                    break;
                case 'settings':
                    Settings::init();
                    break;
                case 'register':
                    Register::init();
                    break;
            }
            exit;
        }

        $smarty = Utils::getSmarty();
        $smarty->assign('latestPosts', QuestionsManager::getLatestPosts(150));
        $smarty->assign('siteTitle', Utils::website_name);
        $smarty->display('index.tpl');
    }
}

Index::init();

//echo 'It was fun while it lasted.';
//die;

?>