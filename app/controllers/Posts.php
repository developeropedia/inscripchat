<?php
  class Posts extends Controller {
    private $postsModel;
    private $commentsModel;
    private $usersModel;
    private $groupsModel;

    public function __construct(){
        if(!isset($_SESSION['user_id'])) {
          redirect("users/login");
        }

        $this->postsModel = $this->model("Post");
        $this->commentsModel = $this->model("Comment");
        $this->usersModel = $this->model("User");
        $this->groupsModel = $this->model("Group");
      }
    
    public function index(){
      $posts = $this->postsModel->getPosts(ADMIN_ID, true, POSTS_PER_PAGE);
      $familiar_peers = $this->usersModel->getFamiliarPeers();
      $peers = $this->usersModel->getAddedPeers();
      $groups = $this->groupsModel->getRecentGroups();
     
      $this->view("posts/index", ["title" => "InscripChat", "posts" => $posts, "familiar_peers" => $familiar_peers, "peers" => $peers, "groups" => $groups]);
    }

    public function pageNotFound()
    {
      $this->view("pages/404.php", ["title" => "404 | Page not found"]);
    }

    public function post($id)
    {
      $post = $this->postsModel->getPostById($id, true, $_SESSION['user_id']);
      $groups = $this->groupsModel->getRecentGroups();

      if(empty($post)) {
        $this->pageNotFound();
        die();
      }

      $posts = $this->postsModel->getPosts(0, true, 5);
      $comments = $this->commentsModel->getPostComments($id);
      $peers = $this->usersModel->getAddedPeers();

      $this->view("posts/post", ["title" => "InscripChat", "post" => $post, "posts" => $posts, "comments" => $comments, "groups" => $groups, "peers" => $peers]);
    }

    public function fetch()
    {
      $action = $_POST['action'];

      if($action === "fetch_posts") {
          $page = isset($_POST['page']) ? $_POST['page'] : 1;
          $author_id = isset($_POST['author_id']) ? $_POST['author_id'] : 0;
          $postsPerPage = POSTS_PER_PAGE;
          $offset = ($page - 1) * $postsPerPage;

          $posts = $this->postsModel->getPosts($author_id, true, $postsPerPage, $offset);

          if(!empty($posts)) {
              echo json_encode(["posts" => $posts]);
          } else {
              echo json_encode(["error" => "No more posts"]);
          }
      }
    }

    public function like_dislike()
    {
      $action = $_POST['action'];

      if ($action === "like_post") {
        $post_id = $_POST['post_id'];
        $like_dislike = $_POST['like_dislike'];

        $res = $this->postsModel->like_dislike($post_id, $like_dislike);

        if ($res) {
          echo json_encode(["result" => true, "likes" => $res->likes, "dislikes" => $res->dislikes]);
        } else {
          echo json_encode(["result" => false]);
        }
      }
    }

    public function upload()
    {
      if($_SESSION['user_is_admin'] == 0) {
        $this->pageNotFound();
        die();
      }

      $this->view("posts/upload", ["title" => "InscripChat"]);
    }

    public function uploadPost()
    {
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $error = '';
        $img = '';
        $file = '';
        $dir = '../public/uploads/';
        $extensions = array("jpeg", "jpg", "png", "pdf", "jfif");
        foreach ($_FILES['img_file']['tmp_name'] as $key => $tmp_name) {
          $file_name = $_FILES['img_file']['name'][$key];
          $file_size = $_FILES['img_file']['size'][$key];
          $file_tmp  = $_FILES['img_file']['tmp_name'][$key];
          $file_type = $_FILES['img_file']['type'][$key];

          $file_ext  = explode('.', $file_name);
          $file_ext  = strtolower(end($file_ext));

          $file_name = uniqid() . "-" . $file_name;
          if (in_array($file_ext, $extensions) === true) {
            if (move_uploaded_file($file_tmp, $dir . $file_name)) {
              if($file_ext == "pdf") {
               $img = "adobe pdf 1.png";
               $file = $file_name;
              } else {
                $img = $file_name;
                $file = $file_name;
              }
            } else
              $error = 'Error in uploading file. File couldn\'t be uploaded.';
          } else {
            $error = 'Error in uploading file. File type is not allowed.';
          }
        }
        echo (json_encode(array('error' => $error, 'img' => $img, 'file' => $file)));
      }
      die();
    }

    public function search($q)
    {
      $results = $this->postsModel->search($q);
      $familiar_peers = $this->usersModel->getFamiliarPeers();
      $peers = $this->usersModel->getAddedPeers();
      $groups = $this->groupsModel->getRecentGroups();
      $this->view("posts/search", ["title" => "Results", "results" => $results, "familiar_peers" => $familiar_peers, "peers" => $peers, "groups" => $groups]);
    }

    public function delete($id)
    {
      $this->postsModel->delete($id);
      redirect("posts");
    }
  }