<?php
  class Admins {
    private $db;

    public function __construct(){
      $this->db = Database::getInstance();
    }

    public function registered_users($duration) {
      if ($duration == "daily") {
        $query = "SELECT DATE(created_at) AS day, COUNT(*) AS user_count
          FROM users
          WHERE created_at >= (SELECT MIN(created_at) FROM users)
                AND created_at <= (SELECT MAX(created_at) FROM users)
                AND is_admin = 0
          GROUP BY day
          ORDER BY day;
          ";
      } else if ($duration == "weekly") {
        $query = "SELECT YEAR(created_at) AS year, WEEK(created_at) AS week, COUNT(*) AS user_count
          FROM users
          WHERE created_at >= (SELECT MIN(created_at) FROM users)
                AND created_at <= (SELECT MAX(created_at) FROM users)
                AND is_admin = 0
          GROUP BY year, week
          ORDER BY year, week;
          ";
      } else if ($duration == "monthly") {
        $query = "SELECT YEAR(created_at) AS year, MONTH(created_at) AS month, COUNT(*) AS user_count
          FROM users
          WHERE created_at >= (SELECT MIN(created_at) FROM users)
                AND created_at <= (SELECT MAX(created_at) FROM users)
                AND is_admin = 0
          GROUP BY year, month
          ORDER BY year, month;
          ";
      }

      $this->db->query($query);
      return $this->db->resultSet();
    }
}