<?php


class Message {

    private $id;
    private $userId;
    private $recipientId;
    private $title;
    private $content;
    private $creationDate;
    private $isRead;

    public function __construct() {
        $this->id = - 1;
        $this->userId = '';
        $this->recipientId = '';
        $this->title = '';
        $this->content = '';
        $this->creationDate = date("Y-m-d H:i:s");
        $this->isRead = 0;

    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getRecipientId() {
        return $this->recipientId;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }


    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getIsRead() {
        return $this->isRead;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setContent($content) {
        if (is_string($content) && strlen(trim($content)) > 0) {
            $this->content = trim($content);
        }
    }

    public function setRecipientId($recipientId) {
        $this->recipientId = $recipientId;
    }

    public function setTitle($title) {
        if (is_string($title) && strlen(trim($title)) > 0) {
            $this->title = trim($title);
        }
    }

    static public function loadAllMessagesByUserId(mysqli $connection, $userId) {
        $query = "SELECT T0.*, T1.name AS user_name, T2.name AS foreign_user FROM Messages T0
                  INNER JOIN Users T1 ON T0.user_id = T1.id
                  INNER JOIN Users T2 ON T0.recipient_id = T2.id
                  WHERE user_id = " . $connection->real_escape_string($userId) . " ORDER BY creation_date DESC ";

        $messages = [];
        $res = $connection->query($query);
        if ($res) {
            foreach ($res as $row) {
                $message = new Message();
                $message->id = $row['id'];
                $message->setUserId($row['user_id']);
                $message->setRecipientId($row['recipient_id']);
                $message->setTitle($row['title']);
                $message->setContent($row['content']);
                $message->creationDate = $row['creation_date'];
                $message->isRead = $row['is_read'];

                $message->userName = $row['user_name'];
                $message->foreignUser = $row['foreign_user'];

                $messages[] = $message;
            }
        }

        return $messages;
    }

    static public function loadAllMessagesByRecipientId(mysqli $connection, $userId) {
        $query = "SELECT T0.*, T1.name AS user_name, T2.name AS foreign_user FROM Messages T0
                  INNER JOIN Users T1 ON T0.user_id = T1.id
                  INNER JOIN Users T2 ON T0.recipient_id = T2.id
                  WHERE T2.id = " . $connection->real_escape_string($userId) . " ORDER BY creation_date DESC ";

        $messages = [];
        $res = $connection->query($query);
        if ($res) {
            foreach ($res as $row) {
                $message = new Message();
                $message->id = $row['id'];
                $message->setUserId($row['user_id']);
                $message->setRecipientId($row['recipient_id']);
                $message->setTitle($row['title']);
                $message->setContent($row['content']);
                $message->creationDate = $row['creation_date'];
                $message->isRead = $row['is_read'];

                $message->userName = $row['user_name'];
                $message->foreignUser = $row['foreign_user'];

                $messages[] = $message;
            }
        }

        return $messages;
    }

    static public function loadMessageById(mysqli $connection, $id) {
        $query = "SELECT * FROM Messages WHERE id =" . $connection->real_escape_string($id);
        $res = $connection->query($query);
        if ($res && $res->num_rows == 1) {
            $row = $res->fetch_assoc(); //pobranie wynikow zapytania do zmiennej
            $message = new Message();
            $message->id = $row['id'];
            $message->setUserId($row['user_id']);
            $message->setRecipientId($row['recipient_id']);
            $message->setTitle($row['title']);
            $message->setContent($row['content']);
            $message->creationDate = $row['creation_date'];
            $message->isRead = $row['is_read'];

            return $message;
        }

        return null;
    }


    public function saveToDB(mysqli $connection) {
        if ($this->id == - 1) {
            $query = "INSERT INTO Messages (user_id, recipient_id, title, content, creation_date, is_read)
                      VALUES ('$this->userId ', '$this->recipientId', '$this->title', '$this->content', '$this->creationDate', '$this->isRead')";

            if ($connection->query($query)) {
                $this->id = $connection->insert_id;

                return true;
            } else
                return false;
        } else {
            $query = "UPDATE Messages
                      SET is_read = 1
                      WHERE id = $this->id";

            if ($connection->query($query)) {
                return true;
            } else {
                return false;
            }
        }
    }


}