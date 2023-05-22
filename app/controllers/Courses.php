<?php
  class Courses extends Controller {
    public function __construct(){
     
    }
    
    public function index(){
      if(isset($_SESSION['user_id'])) {
        redirect("posts/home");
      }
     
      $this->view("users/register", ["title" => "Registeration", "error" => ""]);
    }

    public function about(){
      $data = [
        'title' => 'About Us'
      ];

      $this->view('pages/about', $data);
    }
  }