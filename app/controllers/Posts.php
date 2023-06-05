<?php
  class Posts extends Controller {
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
      $posts = $this->postsModel->getPosts(ADMIN_ID, true, POSTS_PER_PAGE);
      $familiar_peers = $this->usersModel->getFamiliarPeers();
      $peers = $this->usersModel->getAddedPeers();
      $groups = $this->groupsModel->getRecentGroups();
     
      $this->view("posts/index", ["title" => "InscripChat", "posts" => $posts, "familiar_peers" => $familiar_peers, "peers" => $peers, "groups" => $groups]);
    }

    public function post($id)
    {
      $post = $this->postsModel->getPostById($id, true, $_SESSION['user_id']);
      $posts = $this->postsModel->getPosts(0, true, 5);
      $comments = $this->commentsModel->getPostComments($id);

      $this->view("posts/post", ["title" => "InscripChat", "post" => $post, "posts" => $posts, "comments" => $comments]);
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
  }