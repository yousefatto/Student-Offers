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
    <h2>Your request has been approved </h2>
    <h3 >You will also receive email notifications at your primary email address.</h3>

  <!-- .Footer -->
<footer class="colophon">
    <aside> All rights reserved</aside>
    <aside> Study Portal &copy; <?php echo date('Y');?></aside>
    <aside>For suggestions & more information, <a href= "<?php echo url_for('user/contact_us.php'); ?>" target="_blank" rel="nofollow">Contact us</a>.</aside>


    </aside>
</footer>