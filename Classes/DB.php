<?php

class DB {
  private static $_instance = null;
  private $_pdo,
  $_query,
  $_error = false,
  $results,
  $_count = 0;


  private function __construct() {
    try {
      $host = Config::get("mysql/host");
      $dbname = Config::get("mysql/dbname");
      $username = Config::get("mysql/username");
      $password = Config::get("mysql/password");
      $this->_pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    } catch (PDOException $e) {
      die($e->getMessage());
    }

  }
  /* $sql = "INSERT INTO users(username, password, email) VALUES('test', 'test2', 'test3')";
   $this->_pdo->exec($sql);
   echo "done";*/

  public static function getInstance() {
    if(!isset(self::$_instance)) {
      self::$_instance = new DB();
    } else {
      return self::$_instance;
    }
  }

  public function query($sql, $params = array()) {
    $this->_error = false;
    if($this->_query = $this->_pdo->prepare($sql)){
      $i = 1;
      if(count($params)) {
        foreach($params as $param) {
          $this->_query->bindValue($i, $param);
          $i++;
        }
      }
      if($this->_query->execute()) {
        $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
        //print_r($this->_results);
        $this->_count = $this->_query->rowCount();
      } else {
        $this->_error = true;
      }
    }
    return $this;
  }

  public function action($action, $table, $where = array(), $order = 'ASC'){
    if(count($where) === 3){
      $operators = array('=', '>', '<', '>=', '<=');
      $field = $where[0];
      $operator = $where[1];
      $value = $where[2];

      if(in_array($operator, $operators)){
        $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? ORDER BY id {$order}";
        if(!$this->query($sql, array($value))->error()){
          return $this;
        }
      }
    }
    return false;
  }

  public function get($table, $where, $order = null) {
    return $this->action("SELECT *", $table, $where, $order);
  }

  public function getAID($where) {
	  return $this->action("SELECT [AID]", "[character].[dbo].[charinfo]", $where);
  }

  public function identity($status) {
	$this->query("SET IDENTITY_INSERT".$status);
  }

  public function insertToMSSQL($table = "[nlogin].[dbo].[login]", $data = array()) {
	if(count($data)) {
		$keys = array_keys($data);
		$values = null;
		$i = 1;
		foreach($data as $bit) {
			$values .= '?';
			if($i < count($data)) {
				$values .= ', ';
			}
			$i++;
		}
		$sql = "INSERT INTO {$table} (" . implode (',',$keys) . ") VALUES ({$values})";
		if(!$this->query($sql,$data)->error()) {
			return true;
		}
	}
	return false;
}

  public function delete($table, $where){
    return $this->action("DELETE", $table, $where);
  }

  public function error() {
    return $this->_error;
  }

  public function count() {
    return $this->_count;
  }

  public function results() {
    return $this->_results;
  }

  public function first() {
    return $this->results()[0];
  }

  public function insert($table, $data = array()) {
    if(count($data)){
      $keys = array_keys($data);
      $values = null;
      $i = 1;
      foreach($data as $bit) {
        $values .= '?';
        if($i < count($data)) {
         $values .= ', ';
        }
        $i++;
      }
      $sql = "INSERT INTO {$table} (" . implode (',',$keys) . ") VALUES ({$values})";
      if(!$this->query($sql, $data)->error()){
        return true;
      }
    }
    return false;
  }

  public function update($table, $id, $data = array()) {
    $set = "";
    $i = 1;
    foreach($data as $name => $value) {
      $set .= "{$name} = ?";
      if($i < count($data)) {
        $set .= ',';
      }
      $i++;
    }
    $sql = "UPDATE {$table} SET $set WHERE id = {$id}";
    if(!$this->query($sql, $data)->error()) {
      return true;
    }
    return false;
  }

  public function exists($table, $where = array(), $condition = array()) {
    if($this->get($table, $where)) {
      $key = $condition[0];
      $operator = $condition[1];
      $value = $condition[2];
      foreach($this->_results as $result) {
        if($this->_results->$key.$operator.$value) {
          return true;
        }
      }
      return false;
    } else {
      return false;
    }
  }
}
