<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = Database::getInstance();
    }

    // Add User / Register
    public function register($data, $file){
      // Prepare Query
      $query = "INSERT INTO users (name, username, email, password, course, qualification, institution";

      $filename = "";
      if (!empty($file['image']["name"])) {
        $filename = $file['image']['name'];
        $filename = uniqid() . "-" . $filename;
        $dir = "../public/images/";
        if (move_uploaded_file($file["image"]["tmp_name"], $dir . $filename)) {
          $query .= ", img)";
        }
      }

      $query .= " VALUES (:name, :username, :email, :password, :course, :qualification, :institution";

      if(!empty($filename)) {
        $query .= ", :img)";
      }

      $this->db->query($query);

      // Bind Values
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':username', $data['username']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', $data['password']);
      $this->db->bind(':course', $data['course']);
      $this->db->bind(':qualification', $data['qualification']);
      $this->db->bind(':institution', $data['institution']);

      if (!empty($filename)) {
        $this->db->bind(":img", $filename);
      }
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Find USer BY Email
    public function findUserByUsername($username){
        $this->db->query("SELECT *, courses.name as course FROM users INNER JOIN courses ON courses.id = users.course WHERE username = :username");
        $this->db->bind(':username', $username);
  
        $row = $this->db->single();
  
        //Check Rows
        if($this->db->rowCount() > 0){
          return true;
        } else {
          return false;
        }
      }

    // Find USer BY Email
    public function findUserByEmail($email){
      $this->db->query("SELECT * FROM users WHERE email = :email");
      $this->db->bind(':email', $email);

      $row = $this->db->single();

      //Check Rows
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    // Login / Authenticate User
    public function login($data){
      $this->db->query("SELECT * FROM users WHERE username = :username");
      $this->db->bind(':username', $data["username"]);

      $row = $this->db->single();
      
      $hashed_password = $row->password;
      if(password_verify($data["password"], $hashed_password)){
        return $row;
      } else {
        return false;
      }
    }

    // Find User By ID
    public function getUserById($id){
      $this->db->query("SELECT *, users.course AS courseID, users.id as userID, users.name as userName, courses.name as course FROM users INNER JOIN courses ON courses.id = users.course WHERE users.id = :id");
      $this->db->bind(':id', $id);

      $user = $this->db->single();

      return $user;
    }

    public function getAdmin()
    {
      $this->db->query("SELECT * FROM users WHERE is_admin = 1 LIMIT 1");

      $admin = $this->db->single();

      return $admin;
    }

    public function getFamiliarPeers()
    {
      $current_user = $this->getUserById($_SESSION['user_id']);
      $this->db->query("SELECT * FROM users WHERE id != :id AND institution = :institution
      AND id NOT IN (SELECT friend_id FROM friends WHERE user_id = :user_id)");
      $this->db->bind(":id", $_SESSION['user_id']);
      $this->db->bind(":user_id", $_SESSION['user_id']);
      $this->db->bind(":institution", $current_user->institution);
      
      return $this->db->resultSet();
    }

  public function getAddedPeers() {
    $current_user = $this->getUserById($_SESSION['user_id']);
    $this->db->query("SELECT *, friends.friend_id as peerID FROM friends 
    INNER JOIN users ON friends.friend_id = users.id 
    WHERE friends.user_id = :user_id");
    $this->db->bind(":user_id", $_SESSION['user_id']);

    return $this->db->resultSet();
  }

  public function getTotalUsers()  {
    $query = "SELECT COUNT(*) AS totalUsers FROM users WHERE is_admin = 0";
    $this->db->query($query);
    
    return $this->db->single();
  }

  public function getUsers() {
    $query = "SELECT * FROM users WHERE is_admin = 0 AND status = 1";
    $this->db->query($query);
    return $this->db->resultSet();
  }

  public function deletedUsers() {
    $query = "SELECT * FROM users WHERE is_admin = 0 AND status = 0";
    $this->db->query($query);
    return $this->db->resultSet();
  }
  
  public function totalDailyUsers()  {
    $query = "SELECT COALESCE(AVG(user_count), 0) AS totalDailyUsers
    FROM (
        SELECT DATE(created_at) AS day, COUNT(*) AS user_count
        FROM users
        WHERE created_at >= (SELECT MIN(created_at) FROM users)
              AND created_at <= (SELECT MAX(created_at) FROM users)
              AND is_admin = 0
        GROUP BY day
    ) AS daily_counts;
    ";

    $this->db->query($query);
    return $this->db->single();
  }
  
  public function totalWeeklyUsers() {
    $query = "SELECT COALESCE(AVG(user_count), 0) AS totalWeeklyUsers
    FROM (
        SELECT YEAR(created_at) AS year, WEEK(created_at) AS week, COUNT(*) AS user_count
        FROM users
        WHERE created_at >= (SELECT MIN(created_at) FROM users)
              AND created_at <= (SELECT MAX(created_at) FROM users)
              AND is_admin = 0
        GROUP BY year, week
    ) AS weekly_counts;
    ";

    $this->db->query($query);
    return $this->db->single();
  }

  public function totalMonthlyUsers() {
    $query = "SELECT AVG(user_count) AS totalMonthlyUsers
    FROM (
        SELECT YEAR(created_at) AS year, MONTH(created_at) AS month, COUNT(*) AS user_count
        FROM users
        WHERE created_at >= (SELECT MIN(created_at) FROM users)
              AND created_at <= (SELECT MAX(created_at) FROM users)
              AND is_admin = 0
        GROUP BY year, month
    ) AS monthly_counts;
    ";

    $this->db->query($query);
    return $this->db->single();
  }

    public function addPeers($peer_ids)
    {
      $user_id = $_SESSION['user_id'];

      $query = "INSERT INTO friends (user_id, friend_id) VALUES ";
      $params = array();

      foreach ($peer_ids as $key => $friend_id) {
        $query .= "(:user_id_$key, :friend_id_$key),";
        $params[] = array(':user_id' => $user_id, ':friend_id' => $friend_id);
      }

      // Remove the trailing comma
      $query = rtrim($query, ',');

      $this->db->beginTransaction();

      try {
        $this->db->query($query);

        // Bind the parameters
        foreach ($params as $key => $param) {
          $this->db->bind(':user_id_' . $key, $param[':user_id']);
          $this->db->bind(':friend_id_' . $key, $param[':friend_id']);
        }

        $this->db->execute();

        $this->db->commit();
        return true;
      } catch (PDOException $e) {
        $this->db->rollBack();
        return false;
      }
    }

    public function deletePeers($peer_ids)
    {
      $user_id = $_SESSION['user_id'];
      $query = "DELETE FROM friends WHERE user_id = :user_id AND friend_id IN (";
      $params = array();
      foreach ($peer_ids as $key => $friend_id) {
        $query .= ":friend_id_$key,";
        $params[] = array(':friend_id' => $friend_id);
      }
      // Remove the trailing comma
      $query = rtrim($query, ',');
      $query .= ")";
      $this->db->beginTransaction();
      try {
        $this->db->query($query);
      // Bind the parameters
        $this->db->bind(':user_id', $user_id);
        foreach ($params as $key => $param) {
          $this->db->bind(':friend_id_'. $key, $param[':friend_id']);
        }
        $this->db->execute();
        $this->db->commit();
        return true;
      } catch (PDOException $e) {
        $this->db->rollBack();
        return false;
      }
            
    }

    public function editProfile($user_data, $file)
    {
      $name = $user_data['name'];
      $email = $user_data['email'];
      $password = $user_data['password'];
      $course = $user_data['course'];
      $qualification = $user_data['qualification'];
      $institution = $user_data['institution'];
      
      $query = "UPDATE users SET name = :name, email = :email, course = :course,
      qualification = :qualification, institution = :institution";

      if (!empty($password)) {
        $query .= ", password = :password";
      }

      $filename = "";
      if(!empty($file['image']["name"])){
        $filename = $file['image']['name'];
        $filename = uniqid() . "-" . $filename;
        $dir = "../public/images/";
        if(move_uploaded_file($file["image"]["tmp_name"], $dir . $filename)) {
          $query.= ", img = :img";
        }
      }

      $query .= " WHERE id = :user_id";

      $this->db->query($query);
      $this->db->bind(":user_id", $_SESSION['user_id']);
      $this->db->bind(":name", $name);
      $this->db->bind(":email", $email);
      $this->db->bind(":course", $course);
      $this->db->bind(":qualification", $qualification);
      $this->db->bind(":institution", $institution);

      if (!empty($password)) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $this->db->bind(":password", $password);
      }
      
      if(!empty($filename)){
        $this->db->bind(":img", $filename);
      }
      
      return $this->db->execute();
    }

    public function getOnlineUsers()
    {
      $query = "SELECT u.id AS userID, u.username, u.name, u.img
      FROM online_users AS o
      JOIN users AS u ON o.user_id = u.id
      JOIN friends AS f ON (f.user_id = o.user_id AND f.friend_id = :user_id) OR (f.friend_id = o.user_id AND f.user_id = :user_id)
      WHERE o.last_activity >= (CURRENT_TIMESTAMP - INTERVAL 1 MINUTE)";
      $this->db->query($query);
      $this->db->bind(":user_id", $_SESSION['user_id']);
      return $this->db->resultSet();
    }

    public function updateOnlineUsers()
    {
      if(isset($_SESSION['user_id'])) {
        $query = "INSERT INTO online_users (user_id) 
        VALUES (:user_id) ON DUPLICATE KEY UPDATE last_activity = CURRENT_TIMESTAMP";
        $this->db->query($query);
        $this->db->bind(":user_id", $_SESSION['user_id']);
        $this->db->execute();
      }
    }

    public function deleteOfflineUsers()
    {
      $query = "DELETE FROM online_users WHERE last_activity < DATE_SUB(NOW(), INTERVAL 1 MINUTE)";
      $this->db->query($query);
      $this->db->execute();
    }

    public function deleteUser($id) {
      $query = "UPDATE users SET status = 0 WHERE id = :id";
      $this->db->query($query);
      $this->db->bind(":id", $id);
      return $this->db->execute();
    }

    public function restoreUser($id) {
      $query = "UPDATE users SET status = 1 WHERE id = :id";
      $this->db->query($query);
      $this->db->bind(":id", $id);
      return $this->db->execute();
    }

    public function editUser($user_data) {
      $id = $user_data['id'];
      $name = $user_data['name'];
      $email = $user_data['email'];
      $course = $user_data['course'];
      $qualification = $user_data['qualification'];
      $institution = $user_data['institution'];

      $query = "UPDATE users SET name = :name, email = :email, course = :course,
        qualification = :qualification, institution = :institution";

      $query .= " WHERE id = :user_id";

      $this->db->query($query);
      $this->db->bind(":user_id", $id);
      $this->db->bind(":name", $name);
      $this->db->bind(":email", $email);
      $this->db->bind(":course", $course);
      $this->db->bind(":qualification", $qualification);
      $this->db->bind(":institution", $institution);

      return $this->db->execute();
    }
}