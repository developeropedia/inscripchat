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
  }