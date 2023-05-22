<?php
  class Post {
    private $db;
    private $userModel;

    public function __construct(){
      $this->db = new Database;
      $this->userModel = new User;
    }

    // Find All Posts
    public function getPosts($author_id = 0, $filtered = false, $limit = 0, $offset = 0){
      $currentUser = $this->userModel->getUserById($_SESSION['user_id']);
      $course = $currentUser->course;
      $qualification = QUALIFICATION[$currentUser->qualification];
      $institution = $currentUser->institution;

      $query = "SELECT * FROM posts";
      if($author_id !== 0) {
        $query .= " WHERE author_id = :author_id";
      }

      if($filtered) {
        $query .= $author_id === 0 ? " WHERE tags LIKE '%$course%' OR tags LIKE '%$qualification%' OR tags LIKE '%$institution%'" : " AND (tags LIKE '%$course%' OR tags LIKE '%$qualification%' OR tags LIKE '%$institution%')";
      }

      $query .= " ORDER BY created_at DESC";
      $query .= $limit !== 0 ? " LIMIT $limit" : "";
      $query .= $offset !== 0 ? " OFFSET $offset" : "";

      $this->db->query($query);
      if($author_id !== 0) {
        $this->db->bind(':author_id', $author_id);
      }

      $posts = $this->db->resultSet();

      return $posts;
    }

    // Get Post By ID 
    public function getPostById($id){
      $this->db->query("SELECT * FROM posts WHERE id = :id");
      $this->db->bind(':id', $id);

      $post = $this->db->single();

      return $post;
    }
  }