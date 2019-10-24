<?php

  // Performs all actions necessary to log in an admin
  function log_in_admin($admin) {
  // Renerating the ID protects the admin from session fixation.
    session_regenerate_id();
    $_SESSION['userID'] = $admin['userID'];
    $_SESSION['last_login'] = time();
    $_SESSION['username'] = $admin['username'];
    $_SESSION['password'] = $admin['password'];
    return true;
  }

  // Performs all actions necessary to log out an admin
  function log_out_admin() {
    unset($_SESSION['userID']);
    unset($_SESSION['last_login']);
    unset($_SESSION['username']);
    // session_destroy(); // optional: destroys the whole session
    return true;
  }


  // is_logged_in() contains all the logic for determining if a
  // request should be considered a "logged in" request or not.
  // It is the core of require_login() but it can also be called
  // on its own in other contexts (e.g. display one link if an admin
  // is logged in and display another link if they are not)
  function is_logged_in() {
      
      //Session Expiration
 
 $expire_after = 15;
 
 if (isset ($_SESSION['userID'] ))
 {
     if (isset ($_SESSION['last_action']))
        {
            $secondsInactive = time() - $_SESSION['last_action'];
            $expire_seconds = $expire_after * 60;
            if ($secondsInactive >= $expire_seconds)
            {
                session_unset();
                session_destroy();
				header("location: ../../signup.php");
            
            }
        }     
     $_SESSION['last_action'] = time();
 }
 else {
     session_unset();
     session_destroy();
     header("location: ../../signup.php");
 }

    // Having a admin_id in the session serves a dual-purpose:
    // - Its presence indicates the admin is logged in.
    // - Its value tells which admin for looking up their record.
    return isset($_SESSION['userID']);
  }

  // Call require_login() at the top of any page which needs to
  // require a valid login before granting acccess to the page.
  function require_login() {
    if(!is_logged_in()) {
      redirect_to(url_for('/user/login.php'));
    } else {
      // Do nothing, let the rest of the page proceed
    }
  }

?>
