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

    public function addCourse($course_data) {
      $name = $course_data['name'];

      $query = "INSERT INTO courses (name) VALUES (:name)";

      $this->db->query($query);
      $this->db->bind(":name", $name);

      return $this->db->execute();
    }
    
    public function editCourse($course_data) {
      $id = $course_data['id'];
      $name = $course_data['name'];

      $query = "UPDATE courses SET name = :name";

      $query .= " WHERE id = :course_id";

      $this->db->query($query);
      $this->db->bind(":course_id", $id);
      $this->db->bind(":name", $name);

      return $this->db->execute();
    }

    public function deleteCourse($id) {
      $query = "DELETE FROM courses WHERE id = :id";
      $this->db->query($query);
      $this->db->bind(":id", $id);
      return $this->db->execute();
    }
  }