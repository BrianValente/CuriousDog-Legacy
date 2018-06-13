<?php

/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 1/6/17
 * Time: 19:49
 */

namespace Ask\Users;

use Ask\Utils;

class User {
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email_address;

    /**
     * @var int
     */
    private $birth_date;

    /**
     * @var int
     */
    private $registration_date;

    /**
     * @var string
     */
    private $profile_picture;

    /**
     * @var string
     */
    private $profile_header_picture;

    /**
     * @var string
     */
    private $profile_title;

    /**
     * @var string
     */
    private $profile_description;

    /**
     * @var string
     */
    private $profile_color_accent;

    /**
     * @var int
     */
    private $questions_answered_count;

    /**
     * @var int
     */
    private $twitter_id;

    /**
     * @var string
     */
    private $twitter_token;

    /**
     * @var string
     */
    private $twitter_token_secret;

    /**
     * @var int
     */
    private $group;

    /**
     * @var array
     */
    private $array;

    /**
     * User constructor.
     * @param mysqli_result $mysqli_result
     */
    public function __construct($mysqli_result) {
        $row = $mysqli_result->fetch_assoc();

        $this->array                        = $row;
        $this->id                           = $row['id'];
        $this->name                         = $row['name'];
        $this->username                     = $row['username'];
        $this->email_address                = $row['email_address'];
        $this->birth_date                   = $row['birth_date'];
        $this->registration_date            = $row['registration_date'];
        $this->profile_picture              = $row['profile_picture'];
        $this->profile_header_picture       = $row['profile_header_picture'];
        $this->profile_title                = $row['profile_title'];
        $this->profile_description          = $row['profile_description'];
        $this->profile_color_accent         = $row['profile_color_accent'];
        $this->questions_answered_count     = $row['questions_answered'];
        $this->twitter_id                   = $row['twitter_id'];
        $this->twitter_token                = $row['twitter_token'];
        $this->twitter_token_secret         = $row['twitter_token_secret'];
        $this->group                        = $row['group'];

        $this->array['picture_url'] = $this->getUserProfilePictureUrl();
        $this->array['header_url'] = $this->getUserProfileHeaderUrl();
    }

    /**
     * @return array
     */
    public function getArray(): array {
        return $this->array;
    }

    /**
     * @return int
     */
    public function getId(): int{
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUsername(): string {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getEmailAddress(): ?string {
        return $this->email_address;
    }

    /**
     * @return int|null
     */
    public function getBirthDate(): ?int {
        return $this->birth_date;
    }

    /**
     * @return int
     */
    public function getRegistrationDate(): int {
        return $this->registration_date;
    }

    /**
     * @return null|String
     */
    public function getProfileTitle(): ?String {
        return $this->profile_title;
    }

    /**
     * @return null|String
     */
    public function getProfileDescription(): ?String {
        return $this->profile_description;
    }

    /**
     * @return null|String
     */
    public function getProfileColorAccent(): ?String {
        return $this->profile_color_accent;
    }

    /**
     * @return int
     */
    public function getAnsweredQuestionsCount(): int {
        return $this->questions_answered_count;
    }

    /**
     * @return null|String
     */
    public function getUserProfilePictureUrl(): ?String {
        return Utils::uploads_url . 'profile/picture/' . $this->profile_picture;
    }

    /**
     * @return null|String
     */
    public function getUserProfileHeaderUrl(): ?String {
        return Utils::uploads_url . 'profile/header/' . $this->profile_header_picture;
    }

    /**
     * @return null|int
     */
    public function getTwitterId(): ?int {
        return $this->twitter_id;
    }

    /**
     * @return null|String
     */
    public function getTwitterToken(): ?String {
        return $this->twitter_token;
    }

    /**
     * @return null|String
     */
    public function getTwitterTokenSecret(): ?String {
        return $this->twitter_token_secret;
    }




    public function setTwitterId($id) {
        $database = Utils::getDatabase();
        $userId = $this->id;
        $database->query("UPDATE users SET twitter_id=$id WHERE id=$userId");
    }

    public function setTwitterAuthToken($data) {
        $database = Utils::getDatabase();
        $userId = $this->id;
        $database->query("UPDATE users SET twitter_token='$data' WHERE id=$userId");
    }

    public function setTwitterAuthTokenSecret($data) {
        $database = Utils::getDatabase();
        $userId = $this->id;
        $database->query("UPDATE users SET twitter_token_secret='$data' WHERE id=$userId");
    }

    /**
     * @return int
     */
    public function getGroup(): int {
        return $this->group;
    }

    /**
     * @param int $group
     */
    public function setGroup(int $group) {
        UsersManager::setUserGroup($this->id, $group);
        $this->group = $group;
    }
}