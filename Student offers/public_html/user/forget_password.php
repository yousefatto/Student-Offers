<?php require_once('../../private/initialize.php');

$errors1 = [];
$email = '';
$user = [];
  $user['userID'] = $user_id;
  $user['first_name'] = $_POST['first_name'] ?? '';
  $user['last_name'] = $_POST['last_name'] ?? '';
  $user['email'] = $_POST['email'] ?? '';
  $user['username'] = $_POST['username'] ?? '';
  $user['password'] = $_POST['password'] ?? '';
  $user['confirm_password'] = $_POST['confirm_password'] ?? '';
  $user['contact'] = $_POST['contact'] ?? '';

if(isset($_POST['action']) && $_POST['action'] == 'submit') {

    $email = $_POST['email'] ?? '';
    // check the Email
	
	
	//get the user by email address
    $user = find_user_by_email($email);
    if(!$user) {
        redirect_to(url_for('user/password_approval.php'));
    }
    else {
	
	//generate random password
	$password = str_shuffle($user['email']);
    $password = substr($password,5,6);
    $password .= strval(random_int(1,99999));
    $password .= '$%_';
    $password = str_shuffle($password);
    
    //$hased_password = password_hash($password, PASSWORD_BCRYPT);
    //$user['password'] = $hashed_password;
	
	//set the new generated password as user password
    $user['password'] = $password;
    // send the new password to the cutomer via mail
    $result = set_password($user);
    if($result == true) {
        //redirect_to(url_for('user/pages/index.php'));
		$to = $user['email'];
        $subject = "Studyassistance Account Password";
        $message = "<body><h1>Studyassistance Account</h1><h2>Your password changed</h2><h3>Please use the following username and password to login</h3><h4> Username =";
        $message .= $user['username'];
        $message .= "</h4>";
        $message .= "<h4> Password = ";
        $message .= $password;
        $message .="</h4><br></br></body>";
        $message .= "<a href='http://studyassistance.de'>Back to Home page</a>";
        
        $headers = "From: info@studyassistance.de" . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        mail($to,$subject, $message, $headers);
        
        redirect_to(url_for('user/password_approval.php'));
	}
    }
}
else {
    // display the blank form
    $email = '';
     
}
?>

<?php $page_title = 'Home'; ?>

        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>User menu - <?php echo $page_title; ?></title>
        <link href="https://fonts.googleapis.com/css?family=PT+Serif:400,400i,700,700i|Source+Sans+Pro:400,400i,600,600i" rel="stylesheet">
		
        <link rel="stylesheet" href="<?php echo url_for('/stylesheets/style-main.css'); ?>" type="text/css" media="all">
    </head>

    <!-- .header -->
    <header class="masthead">
        <div class="nav-top">
            <h2 class="site-title"><strong>StudyAssistance </strong><i class="fas fa-handshake" style='font-size:30px;padding:0'></i></h2>
    </header><!-- .masthead -->
    <body>
    <br></br>
    <br></br>
    <h2>Forgot Password </h2>
    <h3 >Please enter your email address</h3>
	

    <form  class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    
            <input   type="text" placeholder="Email" id="email" name="email" value="">
            <input type="hidden" name="action" value="submit">
            <input type="submit" value="Submit" name="submit" style="padding: 8px">
            <br></br>
            <br></br>
    </form>
    
    
    <!-- .Footer -->
<footer class="colophon">
    <aside> All rights reserved</aside>
    <aside> Study Portal &copy; <?php echo date('Y');?></aside>
    <aside>For suggestions & more information, <a href="<?php echo url_for('user/contact_us.php'); ?>" target="_blank" rel="nofollow">Contact us</a>.</aside>


    </aside>
</footer>


    </body>
    