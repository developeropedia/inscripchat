<?php
  class Posts extends Controller {
    private $postsModel;

    public function __construct(){
        $this->postsModel = $this->model("Post");
    }
    
    public function index(){
      $posts = $this->postsModel->getPosts(ADMIN_ID, true, POSTS_PER_PAGE);
     
      $this->view("posts/index", ["title" => "InscripChat", "posts" => $posts]);
    }

    public function post($id)
    {
      $post = $this->postsModel->getPostById($id);
      $posts = $this->postsModel->getPosts();

      $this->view("posts/post", ["title" => "InscripChat", "post" => $post, "posts" => $posts]);
    }

    public function fetch()
    {
      $action = $_POST['action'];

      if($action === "fetch_posts") {
          $page = isset($_POST['page']) ? $_POST['page'] : 2;
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
  }