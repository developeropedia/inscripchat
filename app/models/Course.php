<?php
  class Course {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Find All Courses
    public function getCourses(){
      $this->db->query("SELECT * FROM courses");

      $courses = $this->db->resultSet();

      return $courses;
    }
  }