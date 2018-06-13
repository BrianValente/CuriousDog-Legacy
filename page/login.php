<?php
/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 1/10/17
 * Time: 05:19
 */

namespace Ask\Page;

include_once 'class/Utils.php';

class Login {
    public static function init(): void {
        $smarty = Utils::getSmarty();
        $smarty->display('login.tpl');
    }
}

Login::init();