<?php
  function IDtoName($id, $table) {
    $db = DB::getInstance();
    $field = $db->get($table , array('id', '=', $id))->first();
    return $field->name;
}
