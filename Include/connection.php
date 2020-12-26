<?php
  function connect() {
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "fitness-tracker";
    
    // Create Connection
    $conn = new mysqli($server, $username, $password, $database);
    $conn->set_charset("utf8");
    
    // Check Connection
    if($conn->connect_error) {
      die("Connection Failed: " . $conn->connect_error);
    }
  
    return $conn;
  }
?>
