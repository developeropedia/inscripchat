<?php
  class Chats extends Controller {
    private $chatModel;

    public function __construct(){
        $this->chatModel = $this->model("Chat");
    }

    public function index()
    {
        
    }

    public function pageNotFound() {
        $this->view("pages/404.php", ["title" => "404 | Page not found"]);
    }

}

?>