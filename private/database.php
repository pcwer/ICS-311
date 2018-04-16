<?php
  require_once('db_info.php');
  
  function db_connect() {
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);
    return $connection;
  }
  
  function db_disconnect($connection) {
    if(isset($connection)) {
      mysqli_close($connection);
    }
  }

?>