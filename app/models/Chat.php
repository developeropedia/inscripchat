<?php
  class Chat {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }
}