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

      $query = "SELECT posts.*, COALESCE(pv.views, 0) AS views, pl.like_dislike FROM posts 
      LEFT JOIN (SELECT post_id, COUNT(*) AS views
      FROM post_views
      GROUP BY post_id) pv ON posts.id = pv.post_id
      LEFT JOIN post_likes pl ON posts.id = pl.post_id AND pl.user_id = :user_id
      WHERE posts.id = :id";

      $this->db->query($query);
      $this->db->bind(':id', $id);
      $this->db->bind(':user_id', $user_id);

      $post = $this->db->single();
      $post->likes = null;
      $post->dislikes = null;

      if(!empty($post)) {
        $likes_dislikes = $this->getPostLikesDislikes($id);
        if(!empty($likes_dislikes)) {
          $post->likes = $likes_dislikes->likes;
          $post->dislikes = $likes_dislikes->dislikes;
        }
      }

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

    public function like_dislike($post_id, $like_dislike)
    {
      $user_id = $_SESSION['user_id'];
      $this->db->query("SELECT * FROM post_likes WHERE post_id = :post_id AND user_id = :user_id");
      $this->db->bind(':post_id', $post_id);
      $this->db->bind(':user_id', $user_id);

      $userLikeExists = $this->db->single();
      $like_dislike_count = new stdClass;
      $result = false;

      if (empty($userLikeExists)) {
        $this->db->query("INSERT INTO post_likes (post_id, user_id, like_dislike) VALUES (:post_id, :user_id, :like_dislike)");
        $this->db->bind(':post_id', $post_id);
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':like_dislike', $like_dislike);
        $result = $this->db->execute();
      } else {
        $this->db->query("UPDATE post_likes SET like_dislike = :like_dislike WHERE post_id = :post_id AND user_id = :user_id");
        $this->db->bind(':like_dislike', $like_dislike);
        $this->db->bind(':post_id', $post_id);
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->execute();
      }

      if (!$result) {
        return false;
      } else {
        $likes_dislikes = $this->getPostLikesDislikes($post_id);
        $like_dislike_count->likes = $likes_dislikes->likes;
        $like_dislike_count->dislikes = $likes_dislikes->dislikes;

        return $like_dislike_count;
      }
    }

    public function getPostLikesDislikes($post_id)
    {
      $query = "SELECT COUNT(CASE WHEN like_dislike = 1 THEN 1 END) AS likes,
                  COUNT(CASE WHEN like_dislike = 0 THEN 1 END) AS dislikes
            FROM post_likes
            WHERE post_id = :post_id";

      $this->db->query($query);
      $this->db->bind(":post_id", $post_id);
      return $this->db->single();
    }
  }