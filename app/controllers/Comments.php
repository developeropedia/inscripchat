<?php
  class Comments extends Controller {
    private $commentsModel;
    private $groupsModel;

    public function __construct(){
        if (!isset($_SESSION['user_id'])) {
          redirect("users/login");
        }

        $this->commentsModel = $this->model("Comment");
        $this->groupsModel = $this->model("Group");
    }
    
    public function index()
    {
        
    }

    public function pageNotFound() {
      $this->view("pages/404.php", ["title" => "404 | Page not found"]);
    }
    
    public function insert(){     
      $action = $_POST['action'];

      if($action === "add_comment") {

        if(!isset($_POST['post']) && !$this->groupsModel->isGroupMember($_SESSION['user_id'], $_POST['groupID'])) {
          echo "not_member";
          die();
        }

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
            if (!isset($_POST['post']) &&  !$this->groupsModel->isGroupMember($_SESSION['user_id'], $_POST['groupID'])) {
              echo "not_member";
              die();
            }

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

    public function like_dislike() {
      $action = $_POST['action'];

      if ($action === "like_comment") {
        if (!isset($_POST['post']) &&  !$this->groupsModel->isGroupMember($_SESSION['user_id'], $_POST['groupID'])) {
          echo "not_member";
          die();
        }

        $comment_id = $_POST['commentID'];
        $like_dislike = $_POST['like_dislike'];

        $res = $this->commentsModel->like_dislike($comment_id, $like_dislike);

        if ($res) {
          echo json_encode(["result" =>true, "likes" => $res->likes, "dislikes" => $res->dislikes]);
        } else {
          echo json_encode(["result" => false]);
        }
      }
    }

    public function reply_like_dislike() {
      $action = $_POST['action'];

      if ($action === "like_reply") {
        if (!isset($_POST['post']) &&  !$this->groupsModel->isGroupMember($_SESSION['user_id'], $_POST['groupID'])) {
          echo "not_member";
          die();
        }

        $reply_id = $_POST['replyID'];
        $like_dislike = $_POST['like_dislike'];

        $res = $this->commentsModel->reply_like_dislike($reply_id, $like_dislike);

        if ($res) {
          echo json_encode(["result" => true, "likes" => $res->likes, "dislikes" => $res->dislikes]);
        } else {
          echo json_encode(["result" => false]); 
        }
      }
    }

    public function checkNewComments() {
      $group_id = $_POST['groupID'];
      $lastCommentTime = $_POST['lastCommentTime'];
      $res = $this->commentsModel->checkNewComments($group_id, $lastCommentTime);
      if ($res) {
        echo json_encode(["result" => true, "comments" => $res]);
      } else {
        echo json_encode(["result" => false]);
      }
    }

    public function checkNewCommentsPost() {
      $post_id = $_POST['post_id'];
      $lastCommentTime = $_POST['lastCommentTime'];
      $res = $this->commentsModel->checkNewCommentsPost($post_id, $lastCommentTime);
      if ($res) {
        echo json_encode(["result" => true, "comments" => $res]);
      } else {
        echo json_encode(["result" => false]);
      }
    }

    public function checkNewReplies() {
      $group_id = $_POST['groupID'];
      $lastReplyTime = $_POST['lastReplyTime'];
      $res = $this->commentsModel->checkNewReplies($group_id, $lastReplyTime);
      if ($res) {
        echo json_encode(["result" => true, "replies" => $res]);
      } else {
        echo json_encode(["result" => false]);
      }
    }

    public function checkNewRepliesPost() {
      $post_id = $_POST['post_id'];
      $lastReplyTime = $_POST['lastReplyTime'];
      $res = $this->commentsModel->checkNewRepliesPost($post_id, $lastReplyTime);
      if ($res) {
        echo json_encode(["result" => true, "replies" => $res]);
      } else {
        echo json_encode(["result" => false]);
      }
    }
  }