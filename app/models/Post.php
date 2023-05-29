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

      $query = "SELECT posts.*, COALESCE(pv.views, 0) AS views FROM posts 
      LEFT JOIN (SELECT post_id, COUNT(*) AS views
      FROM post_views
      GROUP BY post_id) pv ON posts.id = pv.post_id";
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
    public function getPostById($id, $view = false, $user_id = 0){

      if($view && $user_id !== 0) {
        $this->incrementPostViews($id, $user_id);
      }

      $query = "SELECT posts.*, COALESCE(pv.views, 0) AS views FROM posts 
      LEFT JOIN (SELECT post_id, COUNT(*) AS views
      FROM post_views
      GROUP BY post_id) pv ON posts.id = pv.post_id WHERE posts.id = :id";

      $this->db->query($query);
      $this->db->bind(':id', $id);

      $post = $this->db->single();

      return $post;
    }

    public function incrementPostViews($post_id, $user_id)
    {
      $this->db->query("SELECT * FROM post_views WHERE post_id = :post_id AND user_id = :user_id");
      $this->db->bind(':post_id', $post_id);
      $this->db->bind(':user_id', $user_id);

      $userViewExists = $this->db->single();

      if(empty($userViewExists)) {
        $this->db->query("INSERT INTO post_views (post_id, user_id) VALUES (:post_id, :user_id)");
        $this->db->bind(':post_id', $post_id);
        $this->db->bind(':user_id', $user_id);
        $this->db->execute();
      }
    }
  }