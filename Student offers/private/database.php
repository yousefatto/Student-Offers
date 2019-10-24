<?php
  require_once('db_credentials.php');

// Create a database connection
  function db_connect() {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    return $connection;
  }

// To prevent SQL injection
  function db_escape($connection, $string) {
    return mysqli_real_escape_string($connection, $string);
}

// To confirm that DB has successfully connected
  function confirm_db_connect() {
    if(mysqli_connect_errno()) {
      $msg = "Database connection failed: ";
      $msg .= mysqli_connect_error();
      $msg .= " (" . mysqli_connect_errno() . ")";
      exit($msg);
    }
  }

// Close database connection
  function db_disconnect($connection) {
    if(isset($connection)) {
      mysqli_close($connection);
    }
  }

 // Test if query successful
 function confirm_result_set($result_set) {
  if (!$result_set) {
    exit("Database query failed.");
  }
}
?>
