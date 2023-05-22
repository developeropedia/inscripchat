<?php
  class Pages extends Controller {
    public function __construct(){
     
    }
    
    public function index(){
      if(isset($_SESSION['user_id'])) {
        redirect("posts");
      }

      redirect("users/register");
     
    }
  }