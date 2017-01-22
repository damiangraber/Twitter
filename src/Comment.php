<?php

class Comment {

    private $id;
    private $userId;
    private $tweetId;
    private $creationDate;
    private $text;

    public function __construct() {
        $this->id = - 1;
        $this->userId = '';
        $this->tweetId = '';
        $this->creationDate = date("Y-m-d H:i:s");
        $this->text = '';
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getTweetId() {
        return $this->tweetId;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getText() {
        return $this->text;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setTweetId($tweetId) {
        $this->tweetId = $tweetId;
    }

    public function setText($text) {
        if (is_string($text) && strlen(trim($text)) > 0) {
            $this->text = trim($text);
        }
    }

    static public function loadAllCommentsByTweetId(mysqli $connection, $tweetId) {
        $query = "SELECT * FROM Comments WHERE tweet_id = " . $connection->real_escape_string($tweetId) . " ORDER BY creation_date DESC ";

        $comments = [];
        $res = $connection->query($query);
        if ($res) {
            foreach ($res as $row) {
                $comment = new Comment();
                $comment->id = $row['id'];
                $comment->setUserId($row['user_id']);
                $comment->setTweetId($row['tweet_id']);
                $comment->creationDate = $row['creation_date'];
                $comment->setText($row['text']);

                $comments[] = $comment;
            }
        }
        return $comments;
    }

    static public function loadCommentById(mysqli $connection, $id) {
        $query = "SELECT * FROM Comment WHERE id =" . $connection->real_escape_string($id);
        $res = $connection->query($query);
        if ($res && $res->num_rows == 1) {
            $row = $res->fetch_assoc(); //pobranie wynikow zapytania do zmiennej
            $comment = new Comment();
            $comment->id = $row['id'];
            $comment->setUserId($row['user_id']);
            $comment->setTweetId($row['tweet_id']);
            $comment->creationDate = $row['creation_date'];
            $comment->setText($row['text']);


            return $comment;
        }

        return null;
    }


    public function saveToDB(mysqli $connection) {
        if ($this->id == - 1) {
            $query = "INSERT INTO Comments (user_id, tweet_id, creation_date, text)
                      VALUES ('$this->userId ', '$this->tweetId', '$this->creationDate', '$this->text')";

            if ($connection->query($query)) {
                $this->id = $connection->insert_id;

                return true;
            } else
                return false;
        } else {
            $query = "UPDATE Comments
                      SET text = $this->text
                      WHERE id = $this->id";

            if ($connection->query($query)) {
                return true;
            } else {
                return false;
            }
        }
    }


}