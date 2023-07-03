<?php
  class Group {
    private $db;
    private $userModel;

    public function __construct(){
      $this->db = Database::getInstance();
      $this->userModel = new User;
    }

    public function group($id)
    {
        $this->db->query('SELECT * FROM `groups` WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Get groups having recent comments on posts
    public function getRecentGroups() {
        $user_id = $_SESSION['user_id'];
        $query = "SELECT DISTINCT g.id, g.name, pc.comment, pc.created_at, p.content, p.id AS postID
        FROM `groups` g
        LEFT JOIN posts p ON g.id = p.group_id
        LEFT JOIN (
            SELECT pc.post_id, MAX(pc.created_at) AS latest_comment_date
            FROM post_comments pc
            GROUP BY pc.post_id
        ) AS latest_comments ON p.id = latest_comments.post_id
        LEFT JOIN post_comments pc ON p.id = pc.post_id AND latest_comments.latest_comment_date = pc.created_at
        LEFT JOIN group_members gm ON g.id = gm.group_id
        WHERE g.owner_id = :user_id OR gm.user_id = :user_id OR :user_id = :admin_id
        GROUP BY g.id
        ORDER BY latest_comments.latest_comment_date DESC;";

        $this->db->query($query);
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(":admin_id", ADMIN_ID);
        return $this->db->resultSet();
    }



    public function getGroupPosts($group_id, $limit = 0, $offset = 0) {
        $query = "SELECT posts.*, COALESCE(pv.views, 0) AS views, pl.like_dislike FROM posts 
        LEFT JOIN (SELECT post_id, COUNT(*) AS views
        FROM post_views
        GROUP BY post_id) pv ON posts.id = pv.post_id
        INNER JOIN `groups` ON `groups`.id = posts.group_id
        LEFT JOIN post_likes pl ON posts.id = pl.post_id
        WHERE `groups`.id = $group_id ORDER BY `groups`.created_at DESC";
        $query .= $limit !== 0 ? " LIMIT $limit" : "";
        $query .= $offset !== 0 ? " OFFSET $offset" : "";

        $this->db->query($query);
        $posts = $this->db->resultSet();

        return $posts;
    }

    public function create($peer_ids, $group_name)
    {
        $query = "INSERT INTO `groups` (owner_id, name) VALUES (:owner_id, :name)";
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
                return ["group_id" => $group_id, "group_name" => $group_name];
            } catch (PDOException $e) {
                $this->db->rollBack();
                return false;
            }
        } else {
            return false;
        }
    }

    public function isGroupMember($user_id, $group_id)
    {
        if(ADMIN_ID === $user_id) {
            return true;
        }
        if($user_id === $this->group($group_id)->owner_id) {
            return true;
        }
        $query = "SELECT * FROM group_members WHERE user_id = :user_id AND group_id = :group_id";
        $this->db->query($query);
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':group_id', $group_id);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    // Fetch peers present in a group
    public function getGroupPeers($group_id) {
        $query = "SELECT * FROM users WHERE id IN (SELECT user_id FROM group_members WHERE group_id = :group_id)";
        $this->db->query($query);
        $this->db->bind(':group_id', $group_id);
        $this->db->execute();
        return $this->db->resultset();
    }

    // Fetch peers not present in a group
    public function fetchPeersNotInGroup($group_id)
    {
        $query = "SELECT * FROM users WHERE id NOT IN 
        (SELECT user_id FROM group_members WHERE group_id = :group_id)
        AND id IN (SELECT friend_id FROM friends WHERE user_id = :user_id)";
        $this->db->query($query);
        $this->db->bind(':group_id', $group_id);
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $this->db->execute();
        return $this->db->resultset();
    }

    public function addPeers($peer_ids, $group_id) {
        $query = "INSERT INTO group_members (group_id, user_id) VALUES ";
        $params = array();

        foreach ($peer_ids as $key => $user_id) {
            $query .= "(:group_id_$key, :user_id_$key),";
            $params[] = array(':group_id' => $group_id, ':user_id' => $user_id);
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
    }

    public function deletePeers($peer_ids, $group_id) {
        $query = "DELETE FROM group_members WHERE group_id = :group_id AND user_id IN (";
        $params = array();
        foreach ($peer_ids as $key => $user_id) {
            $query .= ":user_id_$key,";
            $params[] = array(':user_id' => $user_id);
        }
        // Remove the trailing comma
        $query = rtrim($query, ',');
        $query .= ")";
        $this->db->beginTransaction();
        try {
            $this->db->query($query);
            // Bind the parameters
            $this->db->bind(':group_id', $group_id);
            foreach ($params as $key => $param) {
                $this->db->bind(':user_id_' . $key, $param[':user_id']);
            }
            $this->db->execute();
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function deleteGroup($group_id)
    {
        $query = "DELETE FROM `groups` WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(":id", $group_id);
        return $this->db->execute();
    }

    public function leaveGroup($group_id) {
        $user_id = $_SESSION['user_id'];
        $query = "DELETE FROM group_members WHERE group_id = :group_id AND user_id = :user_id";
        $this->db->query($query);
        $this->db->bind(":group_id", $group_id);
        $this->db->bind(":user_id", $user_id);
        return $this->db->execute();
    }
  }