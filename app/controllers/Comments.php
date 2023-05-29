<?php
  class Comments extends Controller {
    private $commentsModel;

    public function __construct(){
        $this->commentsModel = $this->model("Comment");
    }
    
    public function index()
    {
        
    }
    
    public function insert(){     
      $action = $_POST['action'];

      if($action === "add_comment") {
        $post_id = $_POST['postID'];
        $comment = $_POST['comment'];

        $res = $this->commentsModel->insert($post_id, $comment);

        if(!$res) {
            echo json_encode(["result" => "error"]);
        } else {
            echo json_encode(["result" => $res]);
        }
      }
    }

    public function reply() {
        $action = $_POST['action'];

        if ($action === "add_reply") {
            $post_id = $_POST['postID'];
            $comment_id = $_POST['commentID'];
            $reply = $_POST['reply'];

            $res = $this->commentsModel->reply($post_id, $comment_id, $reply);

            if (!$res) {
                echo json_encode(["result" => "error"]);
            } else {
                echo json_encode(["result" => $res]);
            }
        }
    }
  }