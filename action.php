<?php

/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 1/6/17
 * Time: 20:12
 */
namespace Ask;

use Ask\Page\Register;
use Ask\Users\UsersManager;

include_once "class/Utils.php";

header('Content-Type: application/json');

/**
 * Class Action
 * It's the only way to send and receive data from the html client via Ajax
 * If the operation was successful returns HTTP 200
 */
class Action {
    private static $response;

    public static function init(): void {
        $action = "";

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        } else if (isset($_POST['action'])) {
            $action = $_POST['action'];
        } else {
            self::throwException("No action has been determined");
        }

        switch ($action) {
            case 'ask':
                if (isset($_GET['question']) && isset($_GET['user_id'])) {
                    $database  = Utils::getDatabase();

                    $question = $_GET["question"];

                    $question  = $database->escape_string($question);
                    $user_id   = $database->escape_string($_GET['user_id']);
                    $ip        = $database->escape_string($_SERVER['REMOTE_ADDR']);
                    $useragent = $database->escape_string($_SERVER['HTTP_USER_AGENT']);
                    $date     = Utils::currentTime();

                    if (UsersManager::checkIfUserExistsById($user_id)) {
                        $result = Utils::getDatabase()->query("INSERT INTO questions (user_to, ip, question, date, useragent) VALUES ('$user_id', '$ip', '$question', '$date', '$useragent')");
                        if ($result) {
                            self::sendStatus("Done");
                        } else {
                            var_dump($result);
                            self::throwException("idk what happened");
                        }
                    } else {
                        self::throwException("ask failed");
                    }
                }
                break;
            case 'login':
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    $database = Utils::getDatabase();
                    $username = $database->escape_string($_POST['username']);
                    $password = $database->escape_string($_POST['password']);
                    $password_md5 = md5($password);

                    // Remove @ if user added it for the username
                    if (strcmp(substr($username, 0, 1), "@") == 0)
                        $username = substr($username, 1);

                    $query = $database->query("SELECT id FROM users WHERE (username='$username' OR email_address='$username') AND password_md5='$password_md5'");
                    if ($query->num_rows == 1) {
                        $userId = $query->fetch_assoc()["id"];

                        $session = UsersManager::setLoggedUser($userId);

                        self::sendStatus("Done " . $session);
                    } else
                        self::throwException("Username or password incorrect");
                } else
                    self::throwException("Username or password not set");
                break;
            case 'logout':
                $session = UsersManager::getSessionId();
                if ($session != null) {
                    UsersManager::logout($session);
                    self::sendStatus("Done");
                } else
                    self::throwException("User is not logged in!");
                break;
            case 'reply':
                if (!isset($_GET["question"]) || !isset($_GET["answer"]))
                    self::throwException("missing question or answer");

                $answer = $_GET["answer"];

                $database   = Utils::getDatabase();
                $questionId = $database->real_escape_string($_GET["question"]);
                $answer_db     = $database->real_escape_string($answer);

                if (!$answer)
                    self::throwException("type an answer plox");


                $date = round(microtime(true) * 1000);
                $query = $database->query("UPDATE questions SET answer='$answer_db', date_answered=$date WHERE id=$questionId");
                if ($query) {
                    $question_row = $database->query("SELECT * FROM questions WHERE id=$questionId")->fetch_assoc();
                    $asked_user_id = UsersManager::getUserById($question_row['user_to']);
                    $asked_user_username = $asked_user_id->getUsername();
                    $question = $question_row["question"];

                    if (strlen($question) > 100)
                        $question = substr($question, 0, 100) . "...";
                    if (strlen($answer) > 100)
                        $answer = substr($answer, 0, 100) . "...";

                    $string = "$question | $answer " . Utils::url . "$asked_user_username/$questionId";


                    // TODO: Make asynchronous to avoid slow response while tweeting
                    // TODO: Make a better implementation of Twitter (checking if the token exists in the DB looks like a bad idea)
                    if (Utils::getLoggedUser()->getTwitterToken() != null) {
                        $twitter = Utils::getTwitterConnection();
                        $twitter->sendTextTweet($string);
                    }

                    echo $string;
                } else
                    self::throwException('unknown error');
                break;
            case 'update_profile_picture':
                $pictureBase64 = explode(',', $_POST['picture'])[1];
                $picture = base64_decode($pictureBase64);
                $filename = Utils::getLoggedUser()->getUsername() . '_' . Utils::currentTime() . '.jpg';
                $file = fopen(Utils::uploads_folder.'profile/picture/'.$filename, 'w');
                if ($file) {
                    fwrite($file, $picture);
                    fclose($file);
                    $userId = Utils::getLoggedUser()->getId();
                    Utils::getDatabase()->query("UPDATE users SET profile_picture='$filename' WHERE id='$userId'");
                } else {
                    self::throwExceptionWithCode("Internal error opening a file",616);
                }

                break;
            case 'update_personal_info':
                $sql = "";
                $database = Utils::getDatabase();
                $loggedUserId = Utils::getLoggedUser()->getId();
                if (isset($_POST['name'])) {
                    $name = $_POST['name'];
                    $name = str_replace(array("\n", "\r"), '', $name); // Remove newlines
                    $name = $database->escape_string($name); // Protect database from SQL Injection attacks
                    $name = htmlspecialchars($name); // Convert HTML characters to normal chars

                    if (strlen($name) == 0) {
                        self::throwExceptionWithCode("Name is empty.", 610);
                    }

                    $sql .= "UPDATE users SET name='$name' WHERE id=$loggedUserId; ";
                }
                if (isset($_POST['description'])) {
                    $description = $_POST['description'];
                    $description = str_replace(array("\n", "\r"), '', $description); // Remove newlines
                    $description = $database->escape_string($description); // Protect database from SQL Injection attacks
                    $description = htmlspecialchars($description); // Convert HTML characters to normal chars

                    if (strlen($description) == 0) {
                        self::throwExceptionWithCode("Description is empty.", 611);
                    }

                    $sql .= "UPDATE users SET profile_description='$description' WHERE id=$loggedUserId; ";
                }
                if (isset($_POST['username'])) {
                    $username = htmlspecialchars($database->escape_string($_POST['username']));

                    if (strcmp($username, Utils::getLoggedUser()->getUsername()) != 0) {
                        $allowedChars = array("-", "_");
                        if(!ctype_alnum(str_replace($allowedChars, '', $username)) || !strlen($username) > 0) {
                            self::throwExceptionWithCode('Username is invalid: ' . $username, 612);
                        }

                        $query = $database->query("SELECT username FROM users WHERE username='$username'");
                        if ($query->num_rows > 0) {
                            self::throwExceptionWithCode('Username in use: ' . $username, 613);
                        }

                        $sql .= "UPDATE users SET username='$username' WHERE id=$loggedUserId; ";
                    }
                }
                if (isset($_POST['email'])) {
                    $email = htmlspecialchars($database->escape_string($_POST['email']));

                    if (strcmp($email, Utils::getLoggedUser()->getEmailAddress()) != 0) {
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            self::throwExceptionWithCode('E-mail is invalid: ' . $email, 614);
                        }

                        $query = $database->query("SELECT email_address FROM users WHERE email_address='$email'");
                        if ($query->num_rows > 0) {
                            self::throwExceptionWithCode("There's already an account with the same email address: " . $email, 615);
                        }

                        $sql .= "UPDATE users SET email_address='$email' WHERE id=$loggedUserId; ";
                    }
                }
                if (strlen($sql) > 0) {
                    $database->multi_query($sql);
                    self::sendStatus($database->error);
                }
                break;
            case 'tweet_profile':
                $user = Utils::getLoggedUser();
                if ($user->getTwitterToken() != null) {
                    $twitter = Utils::getTwitterConnection();
                    $message = Utils::url . $user->getUsername();
                    $twitter->sendTextTweet($message);
                } else {
                    self::throwException("Please connect to Twitter.");
                }
                break;
            case 'register_twitter_checkpassword':
                if (!isset($_REQUEST['password']))
                    self::throwException("where's the password faggot?");

                $result = Register::checkPassword($_REQUEST['password']);

                if ($result != null)
                    self::throwException("Check your password and try again. " . $result);
                break;
            default:
                self::throwException("Invalid action");
        }
    }

    /**
     * @param String $error
     */
    public static function throwException($error): void {
        http_response_code(601);
        self::$response['status'] = $error;
        echo json_encode(self::$response);
        exit;
    }

    /**
     * @param String $error
     * @param int $code
     */
    public static function throwExceptionWithCode($error, $code): void {
        http_response_code($code);
        self::$response['status'] = $error;
        echo json_encode(self::$response);
        exit;
    }

    /**
     * @param String $status
     */
    public static function sendStatus($status): void {
        http_response_code(200);
        self::$response['status'] = $status;
        echo json_encode(self::$response);
        exit;
    }
}

Action::init();
