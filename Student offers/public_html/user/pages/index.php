<?php require_once('../../../private/initialize.php');
is_logged_in();
?>

<?php $page_title = 'Home'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

      <!-- Form for signup -->
 <!-- <php echo $count; ?>


      <a href="#" class="notification1">
        <span>New Proposals</span>
        <span class="badge1"><php echo $count; ?></span>
      </a>

 -->
 <h2>Welcome <?echo $_SESSION['username'] ?></php></h2>

<h3 class="bucket-title">How it Works</h3>

<h3><i class="fa fa-question-circle" style="font-size:25px;color:#ff7330"></i>Ask for assistance in subject</h3>
<h3> <i class='fas fa-bullhorn' style='font-size:25px;color:#02ff32'></i>Get an offer for assistance</h3>
<p></p><h3><i class='fas fa-money-bill-wave' style='font-size:25px;color:rgba(137,147,255,0.58)'></i> Pay the offering amount</h3>
<h3><i class='fas fa-handshake' style='font-size:25px;color:#6297ff'></i>Meet and colloborate </h3>

  </li>
<?php include(SHARED_PATH . '/user_footer.php'); ?>
