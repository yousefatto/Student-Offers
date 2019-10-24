<?php require_once('../../private/initialize.php');
is_logged_in();

$errors = [];
$username = '';
$password = '';

if(is_post_request() && isset($_POST['login'])) {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validations
  if(is_blank($username)) {
    $errors[] = "Username cannot be blank.";
  }
  if(is_blank($password)) {
    $errors[] = "Password cannot be blank.";
  }

  // if there were no errors, try to login
  if(empty($errors)) {
    // Using one variable ensures that msg is the same
    $login_failure_msg = "Log in was unsuccessful.";

    $admin = find_user_by_username($username);
    if($admin) {

      if(password_verify($password, $admin['hashed_password'])) {
        // password matches
        log_in_admin($admin);
        redirect_to(url_for('/user/pages/index.php'));
      } else {
        // username found, but password does not match
        $errors[] = $login_failure_msg;
      }

    } else {
      // no username found
      $errors[] = $login_failure_msg;
    }

  }

}
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Page</title>
    <link href="https://fonts.googleapis.com/css?family=PT+Serif:400,400i,700,700i|Source+Sans+Pro:400,400i,600,600i" rel="stylesheet">
    <link rel="stylesheet" href="../stylesheets/style-main.css" type="text/css" media="all">
</head>

<body class="site">
    <a class="skip-link screen-reader-text" href="#content">Skip to content</a>
    <!-- .header -->
      <header class="masthead">
          <!-- <div class="logo">Logo</div> -->
             <h2 class="site-title"><strong>Study Portal</strong></h2>
            <section class="login">
	         <form  action="<?php echo url_for('/user/login.php'); ?>" method="post">
              <ul>
             <li><input type="text" placeholder="Username" id="username" name="username" value="<?php echo h($username); ?>"></li>
             <li><div class="forgotsub">
             <input type="password" placeholder="password" id="password" name="password" value="">
             <a href="#" class="forgot">forgot password?</a>
           </div></li>
                       <li><input type="submit" value="Sign In" name="login"></li>
                     </ul>
                   </form>
              </section>


      </header><!-- .masthead -->


    <main id="content" class="main-area">

        <section class="buckets">
            <ul>
              <!-- .How it works -->
                <li>

                    <div class="bucket">
                        <h2 class="bucket-title">How it Works</h2>

                          <h3>Ask for assistance in subject.</h3>
                          <h3> Get an offer for assistance.</h3>
                          <h3> Pay the fee. </h3>
                          <h3>Meet and colloborate .</h3>

                    </div><!-- .bucket -->
                    <img src="images/nerve.jpg" alt="The leaves of a Nerve Plant.">
                </li>
                      <!-- Form for signup -->
                <li>
                      <!-- Form for signup -->
                      <h2>Sign-Up Today</h2>
                        <?php echo display_errors($errors); ?>
                        <?php echo display_session_message(); ?>
                        <div class="container">


            </div>
                </li>
            </ul>
        </section><!-- .buckets -->


    </main>


    <!-- .Footer -->
    <footer class="colophon">
		<aside>All photos: <a href=" " target="_blank" rel="nofollow"> All rights reserved </a>.</aside>
        <aside>For more information, visit <a href="" target="_blank" rel="nofollow">Study Portal</a>.</aside>
        <aside>All pages <a href="index.html">Home Page</a>.
          <a href="users/personal_data.html">Personal Data</a>.
          <a href="users/post_offer.html">Post an offer</a>.
          <a href="users/accept_offer.html">Accept an offer</a>.
          <a href="users/history.html">History</a>.
        </aside>
    </footer>

</body>

</html>
