<?php
  class Admin extends Controller {
    private $userModel;
    private $adminModel;
    private $courseModel;
    private $groupModel;
    private $chatModel;

    public function __construct(){
      if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_is_admin']) || empty($_SESSION['user_is_admin'])) {
        redirect("users/login");
      }

      $this->userModel = $this->model("User");
      $this->adminModel = $this->model("Admins");
      $this->courseModel = $this->model("Course");
      $this->groupModel = $this->model("Group");
      $this->chatModel = $this->model("Chat");
    }
    
    public function index(){
      $totalUsers = $this->userModel->getTotalUsers();
      $totalDailyUsers = $this->userModel->totalDailyUsers();
      $totalWeeklyUsers = $this->userModel->totalWeeklyUsers();
      $totalMonthlyUsers = $this->userModel->totalMonthlyUsers();

      $this->view("admin/index", ["title" => "Dashboard", "totalUsers" => $totalUsers, "totalDailyUsers" =>$totalDailyUsers, "totalWeeklyUsers" =>$totalWeeklyUsers, "totalMonthlyUsers" => $totalMonthlyUsers, "active" => "dashboard"]);
    }

    public function pageNotFound() {
      $this->view("pages/404.php", ["title" => "404 | Page not found"]);
    }

    public function about(){
      $data = [
        'title' => 'About Us'
      ];

      $this->view('pages/about', $data);
    }

    public function users() {
      $users = $this->userModel->getUsers();
      $this->view("admin/users", ["title" => "Dashboard", "users" => $users, "active" => "users"]);
    }

    public function deleted() {
      $users = $this->userModel->deletedUsers();
      $this->view("admin/deleted", ["title" => "Dashboard", "users" => $users, "active" => "deleted_users"]);
    }
    
    public function registered_users($duration) {
      $users = $this->adminModel->registered_users($duration);
      $this->view("admin/registered_users", ["title" => "Dashboard", "duration" => $duration, "users" => $users, "active" => "registered_users"]);
    }

    public function delete($id) {
      $this->userModel->deleteUser($id);
      flash("delete_user", "User has been deleted");
      redirect("admin/users");
    }

  public function restore($id) {
    $this->userModel->restoreUser($id);
    flash("restore_user", "User has been restored");
    redirect("admin/users");
  }

  public function edit($id) {
    $user = $this->userModel->getUserById($id);
    $courses = $this->courseModel->getCourses();
    $this->view("admin/edit", ["title" => "Dashboard", "user" => $user, "courses" => $courses, "active" => "users"]);
  }

  public function editUser() {
    $user_data = $_POST;

    $res = $this->userModel->editUser($user_data);
    flash("user_edited", "User profile has been updated!");
    redirect("admin/edit/" . $user_data['id']);
  }

  public function upload() {
    $this->view("admin/upload", ["title" => "Dashboard", "active" => "upload"]);
  }

  public function groups() {
    $admin = $this->userModel->getAdmin();
    $groups = $this->groupModel->getRecentGroups();
    $this->view("admin/groups", ["title" => "Dashboard", "admin" => $admin, "groups" => $groups, "active" => "groups"]);
  }

  public function chats() {
    $admin = $this->userModel->getAdmin();
    $chats = $this->chatModel->getChatsForAdmin();
    $this->view("admin/chats", ["title" => "Dashboard", "admin" => $admin, "chats" => $chats, "active" => "peers"]);
  }

  public function chat() {
    if(!isset($_GET['s']) || !isset($_GET['r'])) {
      redirect("admin/chats");
    }

    $chat = $this->chatModel->getChat($_GET['s'], $_GET['r']);
    $this->view("admin/chat", ["title" => "Dashboard", "chat" => $chat, "active" => "peers"]);
  }

  public function courses() {
    $courses = $this->courseModel->getCourses();
    $this->view("admin/courses", ["title" => "Dashboard", "courses" => $courses, "active" => "courses"]);
  }

  public function add_course() {
    $this->view("admin/add_course", ["title" => "Dashboard", "active" => "courses"]);
  }

  public function edit_course($id) {
    $course = $this->courseModel->getCourseById($id);
    $this->view("admin/edit_course", ["title" => "Dashboard", "course" => $course, "active" => "courses"]);
  }

  public function addCourse() {
    $course_data = $_POST;

    $res = $this->courseModel->addCourse($course_data);
    flash("course_added", "Course has been added!");
    redirect("admin/courses");
  }

  public function editCourse() {
    $course_data = $_POST;

    $res = $this->courseModel->editCourse($course_data);
    flash("course_edited", "Course has been updated!");
    redirect("admin/edit_course/" . $course_data['id']);
  }

  public function delete_course($id) {
    $this->courseModel->deleteCourse($id);
    flash("delete_course", "Course has been deleted");
    redirect("admin/courses");
  }
}