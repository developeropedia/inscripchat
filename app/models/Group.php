<?php
  class Group {
    private $db;
    private $userModel;

    public function __construct(){
      $this->db = new Database;
      $this->userModel = new User;
    }

    // Get groups having recent comments on posts
    public function getRecentGroups() {
        $query = "SELECT g.id, g.name, pc.comment, pc.created_at
        FROM groups g
        LEFT JOIN posts p ON g.id = p.group_id
        LEFT JOIN (
            SELECT pc.post_id, MAX(pc.created_at) AS latest_comment_date
            FROM post_comments pc
            GROUP BY pc.post_id
        ) AS latest_comments ON p.id = latest_comments.post_id
        LEFT JOIN post_comments pc ON p.id = pc.post_id AND latest_comments.latest_comment_date = pc.created_at
        WHERE p.group_id != 0
        ORDER BY COALESCE(latest_comments.latest_comment_date, p.created_at, g.created_at) DESC;";

        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function create($peer_ids, $group_name)
    {
        $query = "INSERT INTO groups (owner_id, name) VALUES (:owner_id, :name)";
        $this->db->query($query);
        $this->db->bind(':owner_id', $_SESSION['user_id']);
        $this->db->bind(':name', $group_name);
        $this->db->execute();
        $group_id = $this->db->lastInsertId();
        if(!empty($group_id)) {
            $query = "INSERT INTO group_members (group_id, user_id) VALUES ";
            $params = array();

            foreach ($peer_ids as $key => $peer_id) {
                $query .= "(:group_id_$key, :user_id_$key),";
                $params[] = array(':group_id' => $group_id, ':user_id' => $peer_id);
            }

            // Remove the trailing comma
            $query = rtrim($query, ',');

            $this->db->beginTransaction();

            try {
                $this->db->query($query);

                // Bind the parameters
                foreach ($params as $key => $param) {
                    $this->db->bind(':group_id_' . $key, $param[':group_id']);
                    $this->db->bind(':user_id_' . $key, $param[':user_id']);
                }

                $this->db->execute();

                $this->db->commit();
                return true;
            } catch (PDOException $e) {
                $this->db->rollBack();
                return false;
            }
        } else {
            return false;
        }
    }
  }