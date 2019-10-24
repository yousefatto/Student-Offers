<?php require_once('../../private/initialize.php');

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
    <br></br>
    <br></br>
    <h2>Thank You for registration </h2>
    <h3 >We have sent you a verification Email to the provided address</h3>

<?php include(SHARED_PATH . '/user_footer.php'); ?>