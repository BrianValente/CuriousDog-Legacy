<?php

/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 6/1/17
 * Time: 14:10
 */

namespace Ask\Users;

use Ask\Database\Database;
use Ask\Utils;

class UsersManager {

    /**
     * @var User
     */
    private static $loggedUser = null;
    private static $loggedUserChecked = false;

    /**
     * @param int $userId
     * @return String
     */
    public static function setLoggedUser($userId): String {
        $database = Database::getConnection();
        $ip = $_SERVER['REMOTE_ADDR'];
        $userAgent = $database->escape_string($_SERVER['HTTP_USER_AGENT']);
        $sessionId = md5($userId + Utils::currentTime());
        $expiry = (Utils::currentTime() + Utils::session_expiry) / 1000; // seconds, not milliseconds

        $database->query("INSERT INTO sessions (session, user_id, expiry, ip, useragent) VALUES ('$sessionId', '$userId', '$expiry', '$ip', '$userAgent')");
        setcookie("session", $sessionId, $expiry, '/');
        return $sessionId;
    }

    /**
     * @return null|User
     */
    public static function getLoggedUser(): ?User {
        if (self::$loggedUserChecked)
            return self::$loggedUser;

        if (isset($_COOKIE['session'])) {
            $session = $_COOKIE['session'];
            $query = Utils::getDatabase()->query("SELECT * FROM sessions WHERE session='$session'");

            if ($query->num_rows == 1) {
                // TODO: Check the session expiry

                $row = $query->fetch_assoc();

                if ($row['revoked'])
                    return null;

                $userId = $row['user_id'];
                self::$loggedUser = self::getUserById($userId);
                self::$loggedUserChecked = true;
                return self::$loggedUser;
            }
        }
        return null;
    }

    /**
     * @return bool
     */
    public static function isLogged(): bool {
        return self::getLoggedUser() != null;
    }

    /**
     * @param $username
     * @return null|User
     */
    public static function getUserByUsername($username): ?User {
        $query = Utils::getDatabase()->query("SELECT * FROM users WHERE username='$username'");
        if ($query->num_rows == 1)
            return new User($query);
        else
            return null;
    }

    /**
     * @param int $twitterId
     * @return User|null
     */
    public static function getUserByTwitterId(int $twitterId): ?User {
        $query = Utils::getDatabase()->query("SELECT * FROM users WHERE twitter_id=$twitterId");
        if ($query->num_rows == 1)
            return new User($query);
        else
            return null;
    }

    /**
     * @param $id
     * @return null|User
     */
    public static function getUserById($id): ?User {
        $query = Utils::getDatabase()->query("SELECT * FROM users WHERE id='$id'");
        if ($query->num_rows == 1)
            return new User($query);
        else
            return null;
    }

    /**
     * @param int $id
     * @return bool
     */
    public static function checkIfUserExistsById($id): bool {
        $result = Utils::getDatabase()->query("SELECT id FROM users WHERE id='$id'");
        return $result->num_rows == 1;
    }

    /**
     * @param int $id
     * @return String
     */
    public static function getUserProfilePictureUrl($id): String {
        return Utils::uploads_url . 'profile/picture/' . $id . '.jpg';
    }

    /**
     * @param int $id
     * @return String
     */
    public static function getUserProfileHeaderUrl($id): String {
        return Utils::uploads_url . 'profile/header/' . $id . '.jpg';
    }

    /**
     * @param String $session
     */
    public static function logout($session): void {
        Utils::getDatabase()->query("UPDATE sessions SET revoked = TRUE WHERE session='$session'");
    }

    /**
     * @return null|String
     */
    public static function getSessionId(): ?String {
        if (isset($_COOKIE['session']))
            return $_COOKIE['session'];
        else
            return null;
    }

    public static function setUserGroup(int $userId, int $groupId) {
        Database::getConnection()->query("UPDATE users SET group='$groupId' WHERE id=$userId");
    }
}