<?php
  class Groups extends Controller {
    private $postsModel;
    private $commentsModel;
    private $usersModel;
    private $groupsModel;

    public function __construct(){
        if (!isset($_SESSION['user_id'])) {
          redirect("users/login");
        }

        $this->postsModel = $this->model("Post");
        $this->commentsModel = $this->model("Comment");
        $this->usersModel = $this->model("User");
        $this->groupsModel = $this->model("Group");
    }
    
    public function index(){
      
    }

    public function pageNotFound() {
      $this->view("pages/404.php", ["title" => "404 | Page not found"]);
    }

    public function group($id)
    {
      $group = $this->groupsModel->group($id);
      $user = $this->usersModel->getUserById($_SESSION['user_id']);
      
      if(ADMIN_ID !== $user->userID && $group->owner_id !== $user->userID && !$this->groupsModel->isGroupMember($_SESSION['user_id'], $id)) {
        $this->view("pages/404.php", ["title" => "404 | Page not found"]);
        die();
      }
      
      $peersNotInGroup = $this->groupsModel->fetchPeersNotInGroup($id);
      $groupPeers = $this->groupsModel->getGroupPeers($id);

      if (empty($group)) {
        $this->view("/pages/404.php", ["title" => "404 | Page not found"]);
      } else {
        $posts = $this->groupsModel->getGroupPosts($id, POSTS_PER_PAGE, 0);
        $this->view("/groups/group", ["title" => $group->name, "group" => $group, "user" => $user, "posts" => $posts, "peers" => $peersNotInGroup, "groupPeers" => $groupPeers]);
      }
    }

    public function create()
    {
        $peer_ids = $_POST['peers'];
        $group_name = $_POST['groupName'];
        $res = $this->groupsModel->create($peer_ids, $group_name);

        if(!$res) {
          echo json_encode(["error" => true]);
        } else {
          echo json_encode($res);
        }
    }

  // Add peers to group
  public function addPeers() {
    $peer_ids = $_POST['peerIDs'];
    $group_id = $_POST['groupID'];
    echo $this->groupsModel->addPeers($peer_ids, $group_id);
  }

  public function deletePeers() {
    $peer_ids = $_POST['peerIDs'];
    $group_id = $_POST['groupID'];
    echo $this->groupsModel->deletePeers($peer_ids, $group_id);
  }

  public function deleteGroup()
  {
    $group_id = $_POST['groupID'];
    $res = $this->groupsModel->deleteGroup($group_id);
    if($res) {
      flash("group_deleted", "Group has been deleted");
      echo $res;
    } else {
      echo false;
    }
  }

  public function leaveGroup() {
    $group_id = $_POST['groupID'];
    $res = $this->groupsModel->leaveGroup($group_id);
    if ($res) {
      flash("group_left", "You have left the group");
      echo $res;
    } else {
      echo false;
    }
  }
}