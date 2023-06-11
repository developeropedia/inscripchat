<?php
  class Users extends Controller {
    private $userModel;

    public function __construct(){
        $this->userModel = $this->model("User");
    }

    public function index()
    {
        
    }

    public function pageNotFound() {
        $this->view("pages/404.php", ["title" => "404 | Page not found"]);
    }
    
    public function register()
    {
        if($this->isLoggedIn()) {
            redirect("posts");
        }

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $data["username"] = $_POST['username'];
            $data["name"] = $_POST['name'];
            $data["email"] = $_POST['email'];
            $data["password"] = $_POST['password'];
            $data["course"] = $_POST['course'];
            $data["qualification"] = $_POST['qualification'];
            $data["institution"] = $_POST['institution'];
            $data["error"] = "";
            $data["title"] = "Registeration";

            if($this->userModel->findUserByUsername($data["username"])) {
                $data["error"] = "This username is already taken!";
            }

            if($this->userModel->findUserByEmail($data["email"])) {
                $data["error"] = "This email is already registered!";
            }

            if(empty($data["error"])) {
                $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);

                if($this->userModel->register($data)) {
                    flash("register_success", "Registration Successful!");
                    redirect("users/login");
                }
            } else {
                $this->view("users/register", $data);
            }
        } else {
            $data["title"] = "Registration";
            $data["error"] = "";
            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        if($this->isLoggedIn()) {
            redirect("posts");
        }

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $data["username"] = $_POST['username'];
            $data["password"] = $_POST['password'];
            $data["error"] = "";
            $data["title"] = "Login";

            $user = $this->userModel->findUserByUsername($data["username"]);

            if(!empty($user)) {
                $loggedInUser = $this->userModel->login($data);

                if($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                    redirect("posts");
                } else {
                    $data["error"] = "Username or password is incorrect!";
                }
            } else {
                $data["error"] = "Username or password is incorrect!";
            }

            $this->view("users/login", $data);
        } else {
            $data["title"] = "Login";
            $data["error"] = "";
            $this->view('users/login', $data);
        }
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email; 
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_username'] = $user->username;
        $_SESSION['user_is_admin'] = $user->is_admin;
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_username']);
        unset($_SESSION['user_is_admin']);

        redirect("users/login");
    }

    public function getFamiliarPeers()
    {
        return $this->userModel->getFamiliarPeers();
    }

    public function addPeers()
    {
        $peer_ids = $_POST['peerIDs'];
        echo $this->userModel->addPeers($peer_ids);
    }

    public function deletePeers()
    {
        $peer_ids = $_POST['peerIDs'];
        echo $this->userModel->deletePeers($peer_ids);
    }
  }