<?php
  class Chats extends Controller {
    private $chatModel;
    private $userModel;

    public function __construct(){
        if (!isset($_SESSION['user_id'])) {
            redirect("users/login");
        }

        $this->chatModel = $this->model("Chat");
        $this->userModel = $this->model("User");
    }

    public function index()
    {
        // Fetch chats from chat table
        $chats = $this->chatModel->getChats();
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $admin = $this->userModel->getAdmin();
        $familiar_peers = $this->userModel->getFamiliarPeers();
        $online_users = $this->userModel->getOnlineUsers();
        $peers = $this->userModel->getAddedPeers();
        $this->view("chats/index", ["title" => "Chat", "chats" => $chats, "user" => $user, "admin" => $admin, "familiar_peers" => $familiar_peers, "online_users" => $online_users, "peers" => $peers]);
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

    public function getNewMessages() {
        $msgs = $this->chatModel->getNewMessages();
        echo json_encode(["msgs" => $msgs]);
    }
}

?>