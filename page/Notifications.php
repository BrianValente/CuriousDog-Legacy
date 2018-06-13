<?php
/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 1/12/17
 * Time: 14:37
 */

namespace Ask\Page;

include_once 'class/Utils.php';

use Ask\Question\QuestionsManager;
use Ask\Users\UsersManager;
use Ask\Utils;

class Notifications {
    public static function init(): void {
        if (!UsersManager::isLogged())
            Utils::redirectHome();

        $smarty = Utils::getSmarty();
        $smarty->assign('siteTitle', Utils::website_name . Utils::separator_w_space . 'Notificaciones');
        $smarty->assign('unansweredQuestions', QuestionsManager::getUnansweredQuestionsByUser(UsersManager::getLoggedUser()));

        $twitter = Utils::getTwitterConnection();
        if ($twitter->isLogged()) {
            $userData = $twitter->getUser();
            $smarty->assign("twitter_account", $userData);
        }

        $smarty->display('notifications.tpl');
    }

    /**
     * @return array|null
     */
    public static function getUnansweredQuestions(): ?array {
        $userid = Utils::getLoggedUser()->getId();
        $query = Utils::getDatabase()->query("SELECT * FROM questions WHERE user_to='$userid' AND answer IS NULL ORDER BY date DESC");
        $rows = null;
        while($row = $query->fetch_assoc()){
            $row['date_ago'] = Utils::getAgoDate($row['date']);

            if ($row['user_from'] != null)
                $row['user_array'] = UsersManager::getUserById($row['user_from'])->getArray();
            else
                $row['user_array'] = null;

            $row['question'] = htmlentities($row['question']);

            $rows[] = $row;
        }
        return $rows;
    }
}