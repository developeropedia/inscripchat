<?php
  class Groups extends Controller {
    private $postsModel;
    private $commentsModel;
    private $usersModel;
    private $groupsModel;

    public function __construct(){
        $this->postsModel = $this->model("Post");
        $this->commentsModel = $this->model("Comment");
        $this->usersModel = $this->model("User");
        $this->groupsModel = $this->model("Group");
    }
    
    public function index(){
      
    }

    public function create()
    {
        $peer_ids = $_POST['peers'];
        $group_name = $_POST['groupName'];
        return $this->groupsModel->create($peer_ids, $group_name);
    }
  }