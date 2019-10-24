<?php require_once('../private/initialize.php');

if ($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}

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
        $login_failure_msg = "username or password is incorrect.";

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
    $vkey = md5(time().$_POST['username']);
    $admin['first_name'] = $_POST['first_name'] ?? '';
    $admin['last_name'] = $_POST['last_name'] ?? '';
    $admin['email'] = $_POST['email'] ?? '';
    $admin['username'] = $_POST['username'] ?? '';
    $admin['password'] = $_POST['password'] ?? '';
    $admin['confirm_password'] = $_POST['confirm_password'] ?? '';
    $admin['contact'] = $_POST['contact'] ?? '';
    $admin['vkey'] = $vkey ?? '';
    $result = insert_user($admin);
    if($result === true) {$to = $admin['email'];
	$subject = "Email Verification";
	
    $message = "<body><h1>Studyassistance Account</h1><h2>your account has been created successfully </h2>";
	$message .= "<aside><h3>please <a href='http://studyassistance.de/user/verification.php?vkey=$vkey'>click here</a> to verify your account</h3><br></br></body>";
	
	$headers = "From: info@studyassistance.de" . "\r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	 
	
	mail($to,$subject, $message, $headers);
	
	
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'Congratulations!! You have successfully created your accout.';
    $_SESSION['username'] = $admin['username'];
    $_SESSION['userID'] = $new_id;
    //redirect_to(url_for('/user/pages/show.php?id=' . $new_id));
    redirect_to(url_for('/user/thankyou.php'));
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
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
</head>

<body class="site">
<a class="skip-link screen-reader-text" href="#content">Skip to content</a>
<!-- .header -->
<header class="masthead">
    <!-- <div class="logo">Logo</div> -->
    <div class="nav-top">
        <h2 class="site-title"><strong>StudyAssistance</strong></h2>
        <div class="topnav">
            <div class="login-container">
                <form  class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <input type="text" placeholder="Username" id="username" name="username" value="<?php echo h($username); ?>">
                    <input type="password" placeholder="password" id="password" name="password" value="">

                    <input type="hidden" name="action" value="login">
                    <input type="submit" value="Sign In" name="login" style="padding: 8px">
                    <a href="http://studyassistance.de/user/forget_password.php" class="forgot">forgot password?</a>
                </form>
            </div>
        </div>
    </div>
</header><!-- .masthead -->


<main id="content" class="main-area">

    <section class="buckets">
        <ul>
            <!-- .How it works -->
            <li style="background-color:white;padding: 20px">

                <h2 class="bucket-title">How it Works</h2>

                <h3><i class="fa fa-question-circle" style="font-size:25px;color:#ff7330"></i>Ask for assistance in subject</h3>
                <h3> <i class='fas fa-bullhorn' style='font-size:25px;color:#02ff32'></i>Get an offer for assistance</h3>
                <p></p><h3><i class='fas fa-money-bill-wave' style='font-size:25px;color:rgba(137,147,255,0.58)'></i> Pay the offering amount</h3>
                <h3><i class='fas fa-handshake' style='font-size:25px;color:#6297ff'></i>Meet and colloborate </h3>

            </li>
            <!-- Form for signup -->
            <li style="background-color:#f2f2f2;">
                <!-- Form for signup -->


                <div class="container">
                    <h2>Sign-Up Today</h2>
                    <?php echo display_errors($errors1); ?>
                    <?php echo display_errors($errors); ?>
                    <?php echo display_session_message(); ?>
                    <form  action="<?php echo h($_SERVER["PHP_SELF"]); ?>" method="post">
                        <p class="contact"><label for="first name">First name</label></p>
                        <input id="first_name" name="first_name" placeholder="First name" required="" tabindex="1" type="text" value="<?php echo h($admin['first_name']); ?>">
                        <p class="contact"><label for="last name">Last name</label></p>
                        <input id="last_name" name="last_name" placeholder="Last name" required="" tabindex="2" type="text" value="<?php echo h($admin['last_name']); ?>">
                        <p class="contact"><label for="email">Email</label></p>
                        <input id="email" name="email" placeholder=" example@domain.com" required="" tabindex="3" type="email" value="<?php echo h($admin['email']); ?>">

                        <p class="contact"><label for="username">Create a username</label></p>
                        <input id="username" name="username" placeholder="More than 2 characters" required="" tabindex="4" type="text" value="<?php echo h($admin['username']); ?>">

                        <p class="contact"><label for="password">Create a password</label></p>
                        <input type="password" id="password" placeholder=" Min 6 characters, containing 1 capital letter,a number & symbol" tabindex="5" name="password" value="">
                        <p class="contact"><label for="repassword">Confirm your password</label></p>
                        <input type="password" id="confirm_password" name="confirm_password" tabindex="6" value="">


                        <p class="contact"><label for="phone">Contact Number</label></p>
                        <input id="phone" name="contact" placeholder="Valid contact number e.g. +49xxxxxxxxxxx" tabindex="7" type="text" value="<?php echo h($admin['contact']); ?>">
                        <input type="hidden" name="action" value="signup">
                        <input class="buttom" name="submit" id="submit" tabindex="8" value="Sign me up!" type="submit" style="margin-right: 0px">
                    </form>
                </div>
            </li>
        </ul>
    </section><!-- .buckets -->


</main>


<!-- .Footer -->
<footer class="colophon">
    <aside> All rights reserved</aside>
    <aside> Study Portal &copy; <?php echo date('Y');?></aside>
    <aside>For suggestions & more information, <a href="<?php echo url_for('user/contact_us.php'); ?>" target="_blank" rel="nofollow">Contact us</a>.</aside>


    </aside>
</footer>

</body>

</html>
