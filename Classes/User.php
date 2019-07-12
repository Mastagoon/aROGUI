<?php

Class user {
  private $_db,
          $_data,
          $_sessionName,
          $_error = null,
          $_isLoggedIn = false;

  public function __construct($user = null) {
    $this->_db = DB::getInstance();
    $this->_sessionName = Config::get('session/session_name');
    if(!$user) {
      if(Session::exists($this->_sessionName)) {
        $user = Session::get($this->_sessionName);
        if($this->find($user)) {
          $this->_isLoggedIn = true;
        } else {

        }
      }
    } else {
      $this->find($user);
    }
  }

  public function create($data) {
    if(!$this->_db->insert('users', $data)) {
      throw new exception('There was a problem registering this account.');
    }
  }

  public function find($user = null) {
    if($user) {
       $field = is_numeric($user) ? 'id' : 'username';
       $result = $this->_db->get('users',array($field ,'=', $user));
       if($result->count()) {
         $this->_data = $result->first();
         return true;
       }
    }
    return false;
  }

  public function login($username = null, $password = null) {
    $user = $this->find($username);
    if($user) {
      if(password_verify($password,$this->_data->password)) {
        Session::put($this->_sessionName, $this->data()->id);
        $this->_db->update('users',$this->_data->id, array ('logins' => $this->data()->logins+1));
        return true;
      } else {
        $this->_error = "invalid password";
        return false;
      }
    } else {
      $this->_error = "This username does not exist.";
      return false;
    }
  }

  public function logout() {
    Session::delete($this->_sessionName);
  }

  public function data() {
    return $this->_data;
  }

  public function errors() {
    return $this->_error;
  }

  public function isLoggedIn() {
    return $this->_isLoggedIn;
  }

}
