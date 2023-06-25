<?php
  class Pages extends Controller {
    public function __construct(){
      if (!isset($_SESSION['user_id'])) {
        redirect("users/login");
      }
    }
    
    public function index(){
      if(isset($_SESSION['user_id'])) {
        redirect("posts");
      }

      redirect("users/register");
     
    }

    public function pageNotFound() {
      $this->view("pages/404.php", ["title" => "404 | Page not found"]);
    }

    public function privacyPolicy() {
      $this->view("pages/privacy-policy", ["title" => "Privacy Policy"]);
    }

  public function terms() {
    $this->view("pages/terms", ["title" => "Terms and Conditions"]);
  }
  }