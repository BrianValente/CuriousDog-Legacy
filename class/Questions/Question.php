<?php
/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 5/31/17
 * Time: 01:22
 */

namespace Ask\Question;

use Ask\Database\Query;
use Ask\Users\User;
use Ask\Users\UsersManager;
use Ask\Utils;

class Question {
    /**
     * @var int
     */
    private $id;

    /**
     * @var User
     */
    private $user_from;

    /**
     * @var User
     */
    private $user_to;

    /**
     * @var int
     */
    private $user_from_id;

    /**
     * @var int
     */
    private $user_to_id;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $question;

    /**
     * @var string
     */
    private $answer;

    /**
     * @var int
     */
    private $date;

    /**
     * @var int
     */
    private $date_answered;

    /**
     * @var string
     */
    private $useragent;

    /**
     * @var bool
     */
    private $anonymous;



    /**
     * Question constructor.
     */
    private function __construct() {

    }


    public static function getQuestionBySqlRow(array $row): Question {
        $question = new Question();

        $question->id            = $row['id'];
        $question->user_from_id  = $row['user_from'];
        $question->user_to_id    = $row['user_to'];
        $question->ip            = $row['ip'];
        $question->question      = $row['question'];
        $question->answer        = $row['answer'];
        $question->date          = $row['date'];
        $question->date_answered = $row['date_answered'];
        $question->useragent     = $row['useragent'];
        $question->anonymous     = $row['anonymous'];

        return $question;
    }


    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id) {
        $this->id = $id;
    }

    /**
     * @return User|null
     */
    public function getUserFrom(): ?User {
        if ($this->user_from == null && $this->user_from_id != null)
            $this->user_from = UsersManager::getUserById($this->user_from_id);

        return $this->user_from;
    }

    /**
     * @param User $user_from
     */
    public function setUserFrom(User $user_from) {
        $this->user_from = $user_from;
    }

    /**
     * @return int|null
     */
    public function getUserFromId(): ?int {
        return $this->user_from_id;
    }

    /**
     * @param int $user_from_id
     */
    public function setUserFromId(int $user_from_id) {
        $this->user_from_id = $user_from_id;
    }

    /**
     * @return User
     */
    public function getUserTo(): User {
        if ($this->user_to == null)
            $this->user_to = UsersManager::getUserById($this->user_to_id);

        return $this->user_to;
    }

    /**
     * @param User $user_to
     */
    public function setUserTo(User $user_to) {
        $this->user_to = $user_to;
    }

    /**
     * @return int
     */
    public function getUserToId(): int {
        return $this->user_to_id;
    }

    /**
     * @param int $user_to_id
     */
    public function setUserToId(int $user_to_id) {
        $this->user_to_id = $user_to_id;
    }

    /**
     * @return string
     */
    public function getIp(): string {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip) {
        $this->ip = $ip;
    }

    /**
     * @return string
     */
    public function getQuestion(): string {
        return $this->question;
    }

    /**
     * @return string
     */
    public function getQuestionHtml(): string {
        return htmlentities($this->question);
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question) {
        $this->question = $question;
    }

    /**
     * @return string
     */
    public function getAnswer(): string {
        return $this->answer;
    }

    /**
     * @return string|null
     */
    public function getAnswerHtml(): ?string {
        return htmlentities($this->answer);
    }

    /**
     * @param string $answer
     */
    public function setAnswer(string $answer) {
        $this->answer = $answer;
    }

    /**
     * @return int
     */
    public function getDate(): int {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getDateReadable(): string {
        return Utils::getAgoDate($this->date);
    }

    /**
     * @param int $date
     */
    public function setDate(int $date) {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getDateAnswered(): int {
        return $this->date_answered;
    }

    /**
     * @param int $date_answered
     */
    public function setDateAnswered(int $date_answered) {
        $this->date_answered = $date_answered;
    }

    /**
     * @return string|null
     */
    public function getDateAnsweredReadable(): ?string {
        return Utils::getAgoDate($this->date_answered);
    }

    /**
     * @return string
     */
    public function getUseragent(): string {
        if ($this->useragent == null)
            $this->useragent = "";
        return $this->useragent;
    }

    /**
     * @param string $useragent
     */
    public function setUseragent(string $useragent) {
        $this->useragent = $useragent;
    }

    /**
     * @return bool
     */
    public function isAnonymous(): bool {
        return $this->anonymous;
    }

    /**
     * @param bool $anonymous
     */
    public function setAnonymous(bool $anonymous) {
        $this->anonymous = $anonymous;
    }
}