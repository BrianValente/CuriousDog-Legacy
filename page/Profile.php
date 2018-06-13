<?php
/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 1/6/17
 * Time: 09:12
 */

namespace Ask\Page;

include_once "class/Utils.php";

use Ask\Question\QuestionsManager;
use Ask\Users\UsersManager;
use Ask\Utils;
use Ask\Users\User;

class Profile {
    /**
     * @var boolean
     */
    private const translucentHeader = true;

    /**
     * @var User
     */
    private static $user;

    /**
     * @var array
     */
    private static $requestedQuestion;

    /**
     * @return null|String
     */
    public static function getProfileTitle(): ?String {
        $userProfileTitle = self::getUser()->getProfileTitle();
        if ($userProfileTitle != null)
            return $userProfileTitle;
        else
            return Utils::default_profile_title;
    }

    /**
     * @return String
     */
    public static function getSiteTitle(): String {
        return self::getUser()->getName() . Utils::separator_w_space . Utils::website_name;
    }

    /**
     * @return String
     */
    public static function getSiteMediaTitle(): String {
        if (self::$requestedQuestion != null)
            return htmlentities(self::$requestedQuestion['question']);
        else
            return self::getUser()->getName() . Utils::separator_w_space . Utils::website_name;
    }

    /**
     * @return String|null
     */
    public static function getSiteMediaDescription(): String {
        if (self::$requestedQuestion != null) {
            $answer = htmlentities(self::$requestedQuestion['answer']);
            return $answer? $answer : "null";
        }
        else
            return 'Pregúntale a ' . self::getUser()->getName() . ' lo que quieras en ' . Utils::website_name;
    }

    /**
     * @return String
     */
    public static function getAnsweredQuestionsHtml(): String {
        $userid = self::getUser()->getId();
        $query = Utils::getDatabase()->query("SELECT * FROM questions WHERE user_to='$userid' AND answer IS NOT NULL ORDER BY date_answered DESC");
        while ($row = mysqli_fetch_assoc($query)) {
            $dateago = Utils::getAgoDate($row['date_answered']);

            echo "\n\t\t\t\t";
            echo '<div class="question" data-id="'.$row['id'].'">';
            echo "\n\t\t\t\t\t";
            echo '<span class="question_title">'.$row['question'].'</span>';
            echo "\n\t\t\t\t\t";
            echo '<img src="../img/me.jpg" class="question_answer_profilepic"/><span class="question_answer">' .$row['answer'].'</span>';
            echo "\n\t\t\t\t\t";
            echo '<span class="question_date">'.$dateago.'</span>';
            echo "\n\t\t\t\t";
            echo '</div>';
        }
        echo "\n";
    }


    /**
     * @return array|null
     */
    public static function getAnsweredQuestionsOld(): ?array {
        $userid = self::getUser()->getId();
        $query = Utils::getDatabase()->query("SELECT * FROM questions WHERE user_to='$userid' AND answer IS NOT NULL AND deleted_at IS NULL ORDER BY date_answered DESC");
        $rows = null;
        while($row = $query->fetch_assoc()){
            $row['dateago'] = Utils::getAgoDate($row['date_answered']);
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * @return User
     */
    public static function getUser(): User {
        return self::$user;
    }

    public static function init(): void {
        self::$user = UsersManager::getUserByUsername(Utils::getArguments()[0]);

        $smarty = Utils::getSmarty();
        if (self::$user == null)
            Utils::throw404();

        $arguments = Utils::getArguments();

        if (isset($arguments[1])) {
            $requestedQuestionId = $arguments[1];
            self::$requestedQuestion = Utils::getQuestionById($requestedQuestionId);
            if ((self::$requestedQuestion['answer'] == null || self::$requestedQuestion['user_to'] != self::$user->getId()) && strcmp($arguments[2], "trucazo") != 0)
                self::$requestedQuestion = null;
        }

        $smarty->assign('siteTitle',                    self::getSiteTitle());
        $smarty->assign('siteMediaTitle',               self::getSiteMediaTitle());
        $smarty->assign('siteMediaDescription',         self::getSiteMediaDescription());
        $smarty->assign('profileUserId',                self::$user->getId());
        $smarty->assign('profileUserName',              self::$user->getName());
        $smarty->assign('profileUserTitle',             self::$user->getProfileTitle());
        $smarty->assign('profileUserDescription',       self::$user->getProfileDescription());
        $smarty->assign('profileUserPictureUrl',        self::$user->getUserProfilePictureUrl());
        $smarty->assign('profileUserHeaderUrl',         self::$user->getUserProfileHeaderUrl());
        $smarty->assign('profileUserAnsweredQuestions', QuestionsManager::getAnsweredQuestionsByUser(self::getUser()));
        $smarty->assign('translucentHeader',      self::translucentHeader);

        $colorAccent = self::getUser()->getProfileColorAccent();
        if ($colorAccent != null) {
            $smarty->assign('colorBrowser', $colorAccent);
            $smarty->assign('colorAccent',  $colorAccent);
        }

        $loggedUser = Utils::getLoggedUser();

        /*if ($loggedUser != null && $loggedUser->getId() == 0) {
            $smarty->display('profile2.tpl');
        } else {*/
            $smarty->display('profile.tpl');
        //}
    }
}
?>