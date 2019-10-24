<?php require_once('../../private/initialize.php');

$errors1 = [];
$username = '';
$password = '';

if(isset($_POST['action']) && $_POST['action'] == 'login') {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validations
  if(is_blank($username)) {
    $errors1[] = "Username cannot be blank.";
  }
  if(is_blank($password)) {
    $errors1[] = "Password cannot be blank.";
  }

  // if there were no errors, try to login
  if(empty($errors1)) {
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
        $errors1[] = $login_failure_msg;
      }

    } else {
      // no username found
      $errors1[] = $login_failure_msg;
    }

  }

}

if(isset($_POST['action']) && $_POST['action'] == 'signup') {
  $admin = [];
  $admin['first_name'] = $_POST['first_name'] ?? '';
  $admin['last_name'] = $_POST['last_name'] ?? '';
  $admin['email'] = $_POST['email'] ?? '';
  $admin['username'] = $_POST['username'] ?? '';
  $admin['password'] = $_POST['password'] ?? '';
  $admin['confirm_password'] = $_POST['confirm_password'] ?? '';
  $admin['contact'] = $_POST['contact'] ?? '';
  $admin['vkey'] = md5(time().$_POST['username']);
  $result = insert_user($admin);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'Congratulations!! You have successfully created your account.';
    $_SESSION['username'] = $admin['username'];
    $_SESSION['userID'] = $new_id;
    //redirect_to(url_for('/user/pages/show.php?id=' . $new_id));
    redirect_to(url_for('/user/pages/index.php'));
  } else {
    $errors = $result;
  }

} else {
  // display the blank form
  $admin = [];
  $admin["first_name"] = '';
  $admin["last_name"] = '';
  $admin["email"] = '';
  $admin["username"] = '';
  $admin['password'] = '';
  $admin['confirm_password'] = '';
  $admin['contact'] = '';
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
    <div class="nav-top">
      <h2 class="site-title"><strong>Study Portal</strong></h2>
      <div class="topnav">
        <div class="login-container">
          <form  class="form-inline" action="<?php echo url_for('/user/signup.php'); ?>" method="post">

            <input type="text" placeholder="Username" id="username" name="username" value="<?php echo h($username); ?>">
            <input type="password" placeholder="password" id="password" name="password" value="">

            <input type="hidden" name="action" value="login">
            <input type="submit" value="Sign In" name="login">
            <a href="#" class="forgot">forgot password?</a>
          </form>
        </div>
      </div>
    </div>
  </header><!-- .masthead -->


  <main id="content" class="main-area">

    <section class="buckets">
      <ul>
        <!-- .How it works -->
        <li style="background-color:white">

          <h2 class="bucket-title">How it Works</h2>

          <h3>Ask for assistance in subject.</h3>
          <h3> Get an offer for assistance.</h3>
          <h3> Pay the fee. </h3>
          <h3>Meet and colloborate .</h3>

        </li>
        <!-- Form for signup -->
        <li>
          <!-- Form for signup -->


          <div class="container">
            <h2>Sign-Up Today</h2>
            <?php echo display_errors($errors1); ?>
            <?php echo display_errors($errors); ?>
            <?php echo display_session_message(); ?>
            <form  action="<?php echo url_for('/user/signup.php'); ?>" method="post">
              <p class="contact"><label for="first name">First name</label></p>
              <input id="first_name" name="first_name" placeholder="First name" required="" tabindex="1" type="text" value="<?php echo h($admin['first_name']); ?>">
              <p class="contact"><label for="last name">Last name</label></p>
              <input id="last_name" name="last_name" placeholder="Last name" required="" tabindex="1" type="text" value="<?php echo h($admin['last_name']); ?>">
              <p class="contact"><label for="email">Email</label></p>
              <input id="email" name="email" placeholder="example@domain.com" required="" type="email" value="<?php echo h($admin['email']); ?>">

              <p class="contact"><label for="username">Create a username</label></p>
              <input id="username" name="username" placeholder="username" required="" tabindex="2" type="text" value="<?php echo h($admin['username']); ?>">

              <p class="contact"><label for="password">Create a password</label></p>
              <input type="password" id="password" name="password" value="">
              <p class="contact"><label for="repassword">Confirm your password</label></p>
              <input type="password" id="confirm_password" name="confirm_password" value="">

              <!-- <fieldset>
                <label style="display:block">Birthday</label>
                <label class="month" style="display:inline">
                  <select class="select-style" name="BirthMonth" style="display:inline;width:25%" disabled>
                    <option value="">Month</option>
                    <option  value="01">January</option>
                    <option value="02">February</option>
                    <option value="03" >March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12" >December</option>
                  </label>
                </select>
                <label style="display:inline">Day<input class="birthday" maxlength="2" name="BirthDay"  placeholder="Day" disabled></label>
                <label style="display:inline">Year <input class="birthyear" maxlength="4" name="BirthYear" placeholder="Year"  style="width:20%;" disabled></label>
              </fieldset> -->
              <!--
              <select class="select-style gender" name="gender">
              <option value="select">i am..</option>
              <option value="m">Male</option>
              <option value="f">Female</option>
              <option value="others">Other</option>
            </select><br><br> -->

            <p class="contact"><label for="phone">Contact Number</label></p>
            <input id="phone" name="contact" placeholder="phone number"  type="text" value="<?php echo h($admin['contact']); ?>">
            <input type="hidden" name="action" value="signup">
            <input class="buttom" name="submit" id="submit" tabindex="5" value="Sign me up!" type="submit">
          </form>
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
