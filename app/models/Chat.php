<?php
  class Chat {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getChats()
    {
      $query = "SELECT
      c.sender_id,
      c.receiver_id,
      c.message,
      c.timestamp,
      u.id AS user_id,
      u.name AS user_name,
      u.username AS user_username,
      u.img as user_img
      FROM chats c
      INNER JOIN (
          SELECT 
              CASE
                  WHEN sender_id = :user_id THEN receiver_id
                  WHEN receiver_id = :user_id THEN sender_id
              END AS chat_user,
              MAX(timestamp) AS latest_timestamp
          FROM chats
          WHERE sender_id = :user_id OR receiver_id = :user_id
          GROUP BY chat_user
      ) latest_chats ON (
          (c.sender_id = :user_id AND c.receiver_id = latest_chats.chat_user)
          OR (c.sender_id = latest_chats.chat_user AND c.receiver_id = :user_id)
      )
      AND c.timestamp = latest_chats.latest_timestamp
      INNER JOIN users u ON u.id = latest_chats.chat_user
      ORDER BY c.timestamp DESC;";
      $this->db->query($query);
      $this->db->bind(':user_id', $_SESSION['user_id']);
      return $this->db->resultSet();
    }

    // Fetch chat with peer
    public function fetchChat($peer_id)
    {
      $query = "SELECT
      c.id,
      c.sender_id,
      c.receiver_id,
      c.message,
      c.timestamp,
      me.id AS user_id,
      me.name AS user_name,
      me.username AS user_username,
      me.img AS user_img,
      peer.id AS peer_id,
      peer.name AS peer_name,
      peer.username AS peer_username,
      peer.img AS peer_img
      FROM
          chats c
      INNER JOIN
          users me ON me.id = 
          CASE WHEN c.sender_id = :user_id THEN c.sender_id
          WHEN c.sender_id = :peer_id THEN c.receiver_id END
      INNER JOIN
          users peer ON peer.id = 
          CASE WHEN c.sender_id = :peer_id THEN c.sender_id
          WHEN c.sender_id = :user_id THEN c.receiver_id END
      WHERE
          ((c.sender_id = :user_id AND c.receiver_id = :peer_id)
          OR (c.sender_id = :peer_id AND c.receiver_id = :user_id))
      ORDER BY
      c.timestamp;";

      $this->db->query($query);
      $this->db->bind(':user_id', $_SESSION['user_id']);
      $this->db->bind(':peer_id', $peer_id);
      $messages = $this->db->resultSet();

      // Update the chats to mark them as read
      $updateQuery = "UPDATE chats SET status = 1 WHERE
      (sender_id = :peer_id AND receiver_id = :user_id) AND status = 0";
      $this->db->query($updateQuery);
      $this->db->bind(':peer_id', $peer_id);
      $this->db->bind(':user_id', $_SESSION['user_id']);
      $this->db->execute();

      return $messages;
    }

    public function sendChat($peer_id, $msg)
    {
      $query = "INSERT INTO chats (sender_id, receiver_id, message)
      VALUES (:user_id, :peer_id, :msg)";
      $this->db->query($query);
      $this->db->bind(':user_id', $_SESSION['user_id']);
      $this->db->bind(':peer_id', $peer_id);
      $this->db->bind(':msg', $msg);
      return $this->db->execute();
    }

    public function totalUnreadMessages($peer_id)
    {
      $query = "SELECT COUNT(id) AS totalUnread FROM chats
      WHERE (sender_id = :peer_id AND receiver_id = :user_id)
      AND status = 0";
      $this->db->query($query);
      $this->db->bind(':user_id', $_SESSION['user_id']);
      $this->db->bind(':peer_id', $peer_id);
      $res = $this->db->single();
      if($res) {
        return $res->totalUnread;
      } else {
        return 0;
      }
    }

    public function newMsgs($peer_id)
    {
      // Query the database to fetch new messages
      $query = "SELECT *, users.name AS peer_name, users.img AS peer_img FROM chats 
      INNER JOIN users ON users.id = chats.sender_id
      WHERE (sender_id = :peer_id AND receiver_id = :user_id) 
      AND status = 0";
      $this->db->query($query);
      $this->db->bind(':peer_id', $peer_id);
      $this->db->bind(':user_id', $_SESSION['user_id']);
      $messages = $this->db->resultSet();

      // Update the messages' status to mark them as read
      $updateQuery = "UPDATE chats SET status = 1 WHERE 
      (sender_id = :peer_id AND receiver_id = :user_id) AND status = 0";
      $this->db->query($updateQuery);
      $this->db->bind(':peer_id', $peer_id);
      $this->db->bind(':user_id', $_SESSION['user_id']);
      $this->db->execute();

      // Return the new messages
      return $messages;
    }

  public function newMsgsAll() {
    $query = "SELECT 
    c.sender_id, 
    c.message, 
    latest_msgs.total_new_msgs, 
    latest_msgs.max_timestamp AS timestamp,
    users.name AS peer_name,
    users.img AS peer_img
    FROM chats c
    INNER JOIN (
      SELECT sender_id, MAX(timestamp) AS max_timestamp, COUNT(*) AS total_new_msgs
      FROM chats
      WHERE receiver_id = :user_id AND status = 0
      GROUP BY sender_id
    ) latest_msgs ON c.sender_id = latest_msgs.sender_id AND c.timestamp = latest_msgs.max_timestamp
    INNER JOIN users ON users.id = c.sender_id
    WHERE c.receiver_id = :user_id AND c.status = 0
    GROUP BY sender_id
    ORDER BY c.timestamp DESC";
    $this->db->query($query);
    $this->db->bind(':user_id', $_SESSION['user_id']);
    return $this->db->resultSet();
  }

}