<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Add User / Register
    public function register($data){
      // Prepare Query
      $this->db->query('INSERT INTO users (name, username, email, password, course, qualification, institution) 
      VALUES (:name, :username, :email, :password, :course, :qualification, :institution)');

      // Bind Values
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':username', $data['username']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', $data['password']);
      $this->db->bind(':course', $data['course']);
      $this->db->bind(':qualification', $data['qualification']);
      $this->db->bind(':institution', $data['institution']);
      
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
      $this->db->query("SELECT *, users.name as userName, courses.name as course FROM users INNER JOIN courses ON courses.id = users.course WHERE users.id = :id");
      $this->db->bind(':id', $id);

      $user = $this->db->single();

      return $user;
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
  }