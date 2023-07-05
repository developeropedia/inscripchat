<?php
  class Users extends Controller {
    private $userModel;
    private $courseModel;

    public function __construct(){

        $this->userModel = $this->model("User");
        $this->courseModel = $this->model("Course");
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
            $data["title"] = "Registration";

            if($this->userModel->findUserByUsername($data["username"])) {
                $data["error"] = "This username is already taken!";
            }

            if($this->userModel->findUserByEmail($data["email"])) {
                $data["error"] = "This email is already registered!";
            }

            if(empty($data["error"])) {
                $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);

                if($this->userModel->register($data, $_FILES)) {
                    flash("register_success", "Check your mailbox for confirmation email!");

                    $token = md5(uniqid() . $data['email']);
                    $body = "Thank you for registering. Please click the link below to confirm your email address:<br><br>";
                    $body .= "<a href='". URLROOT ."/users/confirm/$token'>Confirm Email</a>";

                    $this->userModel->updateToken($token, $data['email']);

                    sendMail($data['email'], $data['name'], "Confirmation", $body);
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

    public function profile()
    {
        if(!$this->isLoggedIn()) {
            redirect("users/login");
        }
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $courses = $this->courseModel->getCourses();

        $this->view('users/profile', ["title" => "Profile", "user" => $user, "courses" => $courses]);
    }

    public function editProfile()
    {
        if (!$this->isLoggedIn()) {
            redirect("users/login");
        }

        $user_data = $_POST;
        $file = $_FILES;

        $res = $this->userModel->editProfile($user_data, $file);
        if($res) {
            $_SESSION['user_name'] = $user_data['name'];
            $_SESSION['user_email'] = $user_data['email']; 
            redirect("users/profile");
        }
    }

    public function getOnlineUsers()
    {
        $res = $this->userModel->getOnlineUsers();
        echo json_encode(["onlineUsers" => $res]);
    }

    public function confirm($token) {
        $res = $this->userModel->confirmEmail($token);
        if(!empty($res)) {
            $this->userModel->updateConfirmed($res->id);
            flash("email_confirmed", "Email confirmed successfully!");
            redirect("users/login");
        } else {
            flash("email_not_confirmed", "Email could not be confirmed!", "errorMsg");
            redirect("users/login");
        }
    }

    public function forgot() {
        if(isset($_POST['submit'])) {
            $email = $_POST['email'];
            $res = $this->userModel->getUserByEmail($email);
            if(!empty($res)) {
                $token = md5(uniqid() . $email);
                $this->userModel->updatePassToken($res->id, $token);
                $body = "You have requested to reset your password. Please click the link below to reset password:<br><br>";
                $body .= "<a href='" . URLROOT . "/users/reset/$token'>Reset password</a>";
                sendMail($email, $res->name, "Reset password", $body);
                flash("email_sent", "Please check your mailbox!");
                redirect("users/login");
            } else {
                flash("email_not_found", "Email not found!", "errorMsg");
                redirect("users/forgot");
                }
        } else {
            $this->view("users/forgot", ["title" => "Forgot Password"]);
        }
    }

    public function reset($token) {
        if (isset($_POST['submit'])) {
            $password = $_POST['password'];
            $password = password_hash($password, PASSWORD_BCRYPT);
            $res = $this->userModel->getUserByToken($token);
            if (!empty($res)) {
                $this->userModel->updatePassword($res->id, $password);
                flash("password_reset", "Password has been reset!");
                redirect("users/login");
            } else {
                flash("token_not_found", "Invalid token", "errorMsg");
                redirect("users/login");
            }
        } else {
            $this->view("users/reset", ["title" => "Reset Password"]);
        }
    }
  }
