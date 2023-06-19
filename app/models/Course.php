<?php
  class Course {
    private $db;

    public function __construct(){
      $this->db = Database::getInstance();
    }

    // Find All Courses
    public function getCourses(){
      $this->db->query("SELECT * FROM courses");

      $courses = $this->db->resultSet();

      return $courses;
    }

    public function getCourseById($id) {
      $this->db->query("SELECT * FROM courses WHERE id = :id");

      $this->db->bind(':id', $id);
      $course = $this->db->single();

      return $course;
    }
  }