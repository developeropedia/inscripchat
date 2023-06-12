<?php
  class Chats extends Controller {
    private $chatModel;
    private $userModel;

    public function __construct(){
        $this->chatModel = $this->model("Chat");
        $this->userModel = $this->model("User");
    }

    public function index()
    {
        // Fetch chats from chat table
        $chats = $this->chatModel->getChats();
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $admin = $this->userModel->getAdmin();
        $this->view("chats/index", ["title" => "Chat", "chats" => $chats, "user" => $user, "admin" => $admin]);
    }

    public function pageNotFound() {
        $this->view("pages/404.php", ["title" => "404 | Page not found"]);
    }

    public function fetchChat()
    {
        $peer_id = $_POST['peerID'];
        $chat = $this->chatModel->fetchChat($peer_id);
        echo json_encode(["chat" => $chat]);
    }

    public function sendChat()
    {
        $peer_id = $_POST['peerID'];
        $message = $_POST['msg'];
        echo $this->chatModel->sendChat($peer_id, $message);
    }

    public function newMsgs()
    {
        $peer_id = $_POST['peerID'];
        $msgs = $this->chatModel->newMsgs($peer_id);
        echo json_encode(["msgs" => $msgs]);
    }

    public function newMsgsAll()
    {
        $msgs = $this->chatModel->newMsgsAll();
        echo json_encode(["msgs" => $msgs]);
    }
}

?>