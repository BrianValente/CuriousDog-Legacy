<?php
/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 5/31/17
 * Time: 01:22
 */

namespace Ask\Question;

use Ask\Database\Database;
use Ask\Database\Query;
use Ask\Users\User;
use Ask\Utils;

class QuestionsManager {
    /**
     * @param User $user
     * @return array|null
     */
    public static function getUnansweredQuestionsByUser(User $user): array {
        $userid = $user->getId();
        $query = Utils::getDatabase()->query("SELECT * FROM questions WHERE user_to='$userid' AND answer IS NULL ORDER BY date DESC");
        $rows = [];

        while($row = $query->fetch_assoc()) {
            $rows[] = Question::getQuestionBySqlRow($row);
        }

        return $rows;
    }

    /**
     * @param User $user
     * @return array|null
     */
    public static function getAnsweredQuestionsByUser(User $user): array {
        $userid = $user->getId();
        $query = Utils::getDatabase()->query("SELECT * FROM questions WHERE user_to='$userid' AND answer IS NOT NULL ORDER BY date_answered DESC");
        $rows = [];

        while($row = $query->fetch_assoc()) {
            $rows[] = Question::getQuestionBySqlRow($row);
        }

        return $rows;
    }

    public static function getLatestPosts(int $limit): array {
        $query = Utils::getDatabase()->query("SELECT * FROM questions WHERE answer IS NOT NULL ORDER BY date_answered DESC LIMIT $limit");
        $rows = [];

        while($row = $query->fetch_assoc()) {
            $rows[] = Question::getQuestionBySqlRow($row);
        }

        return $rows;
    }
}