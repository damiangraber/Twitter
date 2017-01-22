<?php

class Tweet {

    private $id;
    private $userId;
    private $tweetContent;
    private $creationDate;

    //nie widzę potrzeby tworzenia settera dla creationDate - chyba, że zakładamy, że tweety można update'ować
    public function __construct() {
        $this->id = - 1;
        $this->userId = '';
        $this->tweetContent = '';
        $this->creationDate = date("Y-m-d H:i:s");
    }

    public function setTweetContent($tweetContent) {
        if (is_string($tweetContent) && strlen(trim($tweetContent)) > 0) {
            $this->tweetContent = trim($tweetContent);
        }
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getTweetContent() {
        return $this->tweetContent;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    static public function loadTweetById(mysqli $connection, $id) {
        $query = "SELECT * FROM Tweet WHERE id = " . $connection->real_escape_string($id);

        $res = $connection->query($query);
        if ($res && $res->num_rows == 1) {
            $row = $res->fetch_assoc(); //pobranie wynikow zapytania do zmiennej
            $tweet = new Tweet();
            $tweet->id = $row['id'];
            $tweet->setUserId($row['user_id']);
            $tweet->setTweetContent($row['content']);
            $tweet->creationDate = $row['creation_date'];

            return $tweet;
        }

        return null;
    }

    static public function loadAllTweetByUserId(mysqli $connection, $userId) {
        $query = "SELECT * FROM Tweet WHERE user_id = " . $connection->real_escape_string($userId);

        $tweets = [];
        $res = $connection->query($query);
        if ($res) {
            foreach ($res as $row) {
                $tweet = new Tweet();
                $tweet->id = $row['id'];
                $tweet->setUserId($row['user_id']);
                $tweet->setTweetContent($row['content']);
                $tweet->creationDate = $row['creation_date'];

                $tweets[] = $tweet;
            }
        }

        return $tweets;
    }

    static public function loadAllTweets(mysqli $connection) {
        $query = "SELECT * FROM Tweet ORDER BY id DESC";
        $tweets = [];
        $res = $connection->query($query);
        if ($res) {
            foreach ($res as $row) {
                $tweet = new Tweet();
                $tweet->id = $row['id'];
                $tweet->setUserId($row['user_id']);
                $tweet->setTweetContent($row['content']);
                $tweet->creationDate = $row['creation_date'];

                $tweets[] = $tweet;
            }
        }

        return $tweets;
    }

    public function saveToDB(mysqli $connection) {
        if ($this->id == - 1) {
            $query = "INSERT INTO Tweet (user_id, content, creation_date)
                      VALUES ('$this->userId ', '$this->tweetContent', '$this->creationDate')";

            if ($connection->query($query)) {
                $this->id = $connection->insert_id;

                return true;
            } else
                return false;
        } else {
            $query = "UPDATE Tweet
                      SET content = $this->tweetContent
                      WHERE id = $this->id";

            if ($connection->query($query)) {
                return true;
            } else {
                return false;
            }
        }
    }

}