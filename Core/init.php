<?php
  session_start();

  //server and db confegirations

  $GLOBALS['config'] = array(
    'mysql' => array(
      'host' => '127.0.0.1',
      'username' => 'root',
      'password' =>  '',
      'dbname' =>   'budge'
    ),
    'session' => array (
      'session_name' => 'user',
      'session_name_gender' => 'gender',
      'token_name' => 'token'
    ),
     'gallery' => array (
        'location' => 'imgs/upload'
    )
  );

  //autoloading classes
  spl_autoload_register(function($class){
    require_once "Classes/" . $class . ".php";
  });

  //require the functions
  require_once "Functions/escape.php";
  require_once "Functions/IDtoName.php";

  //get an instance of the db connection
  DB::getInstance();
