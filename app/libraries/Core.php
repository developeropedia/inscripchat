<?php
  /*
   * App Core Class
   * Creates URL & loads core controller
   * URL FORMAT - /controller/method/params
   */
  class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
      //print_r($this->getUrl());

      $url = $this->getUrl();

      // Look in controllers for first value
      if(isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]). '.php')){
        // If exists, set as controller
        $this->currentController = ucwords($url[0]);
        // Unset 0 Index
        unset($url[0]);
      }

      // Require the controller
      require_once '../app/controllers/'. $this->currentController . '.php';

      // Instantiate controller class
      $this->currentController = new $this->currentController;

      $methodExists = false;
      // Check for second part of url
      if(isset($url[1])){
        // Check to see if method exists in controller
        if(method_exists($this->currentController, $url[1])){
          $this->currentMethod = $url[1];
          // Unset 1 index
          unset($url[1]);
          $methodExists = true;
        } else {
          $this->currentMethod = "pageNotFound";
        }
      }

      // Instantiate controller class
      $reflection = new ReflectionClass($this->currentController);
      $this->currentController = $reflection->newInstanceArgs($this->params);

      // Get params
      $this->params = $url ? array_values($url) : [];

      if($methodExists) {
        $reflectionMethod = new ReflectionMethod($this->currentController, $this->currentMethod);
        $parameters = $reflectionMethod->getParameters();
        if(count($parameters) !== 0) {
          if(empty($this->params)) {
            $this->currentMethod = "pageNotFound";
          }
        }
      }

      // Call a callback with array of params
      call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl(){
      $url = [];
      if(isset($_GET['url'])){
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
      }
      return $url;
    }
  } 
  
  