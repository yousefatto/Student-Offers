<?php

$pg = h(basename(substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],'.')))); // get file name from url and strip extension

$userid = $_SESSION['userID'];
if(!isset($page_title)) { $page_title = 'Profile'; }
$count =  count_new_proposals_for_user_offers($userid);
if(!isset($count)) { $count = 0; }
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User menu - <?php echo $page_title; ?></title>
  <link href="https://fonts.googleapis.com/css?family=PT+Serif:400,400i,700,700i|Source+Sans+Pro:400,400i,600,600i" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo url_for('/stylesheets/style-main.css'); ?>" type="text/css" media="all">
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
  <script src="<?php echo url_for('/javascript/main.js'); ?>" type="text/javascript"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>

	<script type="text/javascript">
  function myFunction() {
    $.ajax({
      url: "<?php echo url_for('user/pages/view_notification.php'); ?>",
      type: "POST",
      processData:false,
      success: function(data){

        $("#notification-count").remove();
        $("#notification-latest").show();$("#notification-latest").html(data);
      },
      error: function(){}
    });
   }

   $(document).ready(function() {
    $('body').click(function(e){
      if ( e.target.id != 'notification-icon'){
        $("#notification-latest").hide();
      }
    });
  });
	</script>
  <script>
  $(document).ready(function(){
  // updating the view with notifications using ajax
  function load_unseen_notification(view = '')
  {
   $.ajax({
    url:"fetch.php",
    method:"POST",
    data:{view:view},
    dataType:"json",
    success:function(data)
    {
     // $('.dropdown-menu').html(data.notification);
     if(data.unseen_notification > 0)
     {
      $('.badge1').html(data.unseen_notification);
     }
    }
   });
  }
  load_unseen_notification();
  // submit form and get new records
  // load new notifications
  $(document).on('click', '.notification1', function(){
   $('.badge1').html('');
   load_unseen_notification('yes');
  });
  setInterval(function(){
   load_unseen_notification();;
  }, 5000);
  });
  </script>
  <script>


// Get the container element
var btnContainer = document.getElementById("main-nav");

// Get all buttons with class="btn" inside the container
var btns = btnContainer.getElementsByClassName("nav");
// Loop through the buttons and add the active class to the current/clicked button
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("active");

    // If there's no active class
    if (current.length > 0) {
      current[0].className = current[0].className.replace(" active", "");
    }

    // Add the active class to the current/clicked button
    this.className += " active";
  });
}
</script>
</head>

<body class="site">
  <a class="skip-link screen-reader-text" href="#content">Skip to content</a>
  <!-- .header -->
  <header class="masthead">
    <div class="nav-top">
      <h2 class="site-title"><strong>StudyAssistance </strong></h2>
    <div id="notification-header">
      <div style="position:relative">
        <div id="notification-icon" name="button" onclick="myFunction()" class="dropbtn"><span id="notification-count"><?php if($count>0) { echo $count; } ?></span><i class="far fa-user-circle" style="font-size:30px;color:white"></i></div>
        <div id="notification-latest"></div>
      </div>
    </div>
    </div>

    </header><!-- .masthead -->
    <main id="content" class="main-area">

      <section class="buckets">
        <ul>
          <!-- .How it works -->
          <li class="sidebar">
            <section class="main-nav">
                <nav>
                  <ul>
                    <li style="" class=""><a style="font-weight:bold;background-color:#f4511e;border-radius:5px" href="<?php echo url_for('user/pages/post_offer.php')?>"><i class="fa fa-fw fa-wrench"></i>Post an Offer</a></li>

                    <li class="<?php if($pg=='list_all_offers'){?>active<?php }?>"><a href="<?php echo url_for('user/accept_offers/list_all_offers.php')?>"><i class="fa fa-fw fa-user"></i>List All Offers</a></li>
                    <li class="<?php if($pg=='my_offers'){?>active<?php }?>"><a href="<?php echo url_for('user/pages/my_offers.php')?>"><i class="fa fa-fw fa-envelope"></i>My Posted Offers</a></li>
                    <!-- <li><a href="<php echo url_for('user/accept_offers/Inprogress_offers.php')?>"><i class="fa fa-fw fa-envelope"></i>Inprogress Offers</a></li> -->
                    <li class="<?php if($pg=='my_proposals'){?>active<?php }?>"><a href="<?php echo url_for('user/accept_offers/my_proposals.php')?>"><i class="fa fa-fw fa-wrench"></i>My Proposals</a></li>
                    <li class="<?php if($pg=='personal_data'){?>active<?php }?>"><a href="<?php echo url_for('user/pages/personal_data.php')?>"><i class="fa fa-fw fa-home"></i>Personal Data</a></li>
             
                  </ul>
                </nav>
              </section><!-- .main-nav -->


          </li>
        <li class="main-area">
        <?php echo display_session_message(); ?>
