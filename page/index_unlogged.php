<?php

/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 1/6/17
 * Time: 19:53
 */

namespace Ask\Page;

include_once 'class/Utils.php';

use Ask\Users\UsersManager;
use Ask\Utils;

class Index_Unlogged {
    public static function init(): void {
        if (UsersManager::isLogged()) {
            Utils::redirectHome();
        }
    }
}