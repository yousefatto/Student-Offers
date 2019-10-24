<?php require_once('../../private/initialize.php');
$message="";
if (isset($_GET['vkey'])){
    $vkey = $_GET['vkey'];
    
    if(get_vkey($vkey)== $vkey ){
        if(set_verified($vkey)){
            $message = "Your account has been verified. You may now login";
            
        }
        else { $message = "Error"; }
    }
    else{
            $message = "This account is invalid or already verified";
            
    }
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
    <h2>Thank You </h2>
    <h3 ><?php echo $message;?> <a href='http://studyassistance.de'>Back to login page</a> </h3>
</body>  

<?php include(SHARED_PATH . '/user_footer.php'); ?>


