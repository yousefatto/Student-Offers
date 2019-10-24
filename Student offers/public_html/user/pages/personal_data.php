<?php require_once('../../../private/initialize.php');
is_logged_in();
$user_id = $_SESSION['userID'];
$user = find_user_by_id($user_id);
  // Prevent user from IDRO or accessing DB directly
if(!$user) {
    redirect_to(url_for('user/pages/index.php'));
  }


?>

<?php $page_title = 'Personal Data'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

<!-- Form for signup -->
<div style="background-color:#2c343c">
  <h3 style="color:white;display:block;text-align:center;clear:none"><i class="fa fa-fw fa-user"></i>Personal Details</h3>

</div>
<?php echo display_errors($errors); ?>
<!-- <form action="<hp echo url_for('/user/pages/edit_offer.php?id=' . h(u($id))); ?>" method="post"> -->
  <div class="" style="overflow-x:auto;">
    <table class="post-form" style="background-color:#e4e5e6">

      <tr>
        <th style="width:30%">Profile</th>
        <th style="width:70%"></th>

      </tr>
      <tr>
        <td><label for="fname and lname">First and Last Name</label></td>
        <td>	<input style="width:47%" id="fname" name="fname" placeholder="first name" required="" tabindex="1" type="text" value="<?php echo h($user['first_name']); ?>" disabled>
          <input style="width:47%;display:inline"id="lname" name="lname" placeholder="lname" required="" tabindex="5" type="text" value="<?php echo h($user['last_name']); ?>" disabled>
        </td>
      </tr>
      <tr>
        <td><label for="subject">Username</label></td>
        <td><input style="width:95%" id="username" name="username" placeholder="username" required="" tabindex="2" type="text" value="<?php echo h($user['username']); ?>" disabled>
        </td>
      </tr>
      <tr>
        <td><label for="price">Email</label></td>
        <td><input style="width:95%" id="email" name="email" placeholder="email" required="" tabindex="3" type="text" value="<?php echo h($user['email']); ?>" disabled></td>
      </tr>
      <tr>
        <tr>
          <td><label for="price">Password</label></td>
          <td><input style="width:95%" id="password" name="password" placeholder="" required="" tabindex="3" type="password" value="<?php echo h($_SESSION['password']); ?>" disabled></td>
        </tr>
      </tr>
      <tr>
        <td><label for="mnumer">Contact Number</label></td>
        <td><input style="width:95%" id="mnumer" name="contact" placeholder="mnumer" required="" tabindex="3" type="text" value="<?php echo h($user['contact']); ?>" disabled></td>
      </tr>
      <!-- <tr>
        <td>  <label for="zip">Zip code / City</label></td>
        <td>	<input style="width:40%" id="zip" name="zip" placeholder="Zip Code" required="" tabindex="6" type="text" value="< echo h($offer['zip']); ?>">
          <input style="width:55%" id="city" name="city" placeholder="City Name" required="" type="text" tabindex="7" value="<php echo h($offer['city']); ?>">
        </td>
      </tr>
      <tr>
        <td><label for="time">Date and Time</label></td>
        <td><input style="width:45%" id="date" name="date"  required="" type="date" tabindex="8" value="<php echo h($offer['date']); ?>">
          <input style="width:50%" id="time" name="time" required="" type="time" tabindex="9"  value="<php echo h($offer['time']); ?>">
        </td>
      </tr>
      <tr style="width:100%">
        <td alight="right" valign="top"> <label for="comments">Additional Instructions</label></td>
        <td class="row"><textarea class="col-75"id="comments" name="comments" placeholder="Briefly Explain the requirements about the offer" required="" tabindex="10" style="width:95%;height:100px" value="<?php echo h($offer['comments']); ?>"><?php echo h($offer['comments']); ?></textarea>
        </td>
      </tr> -->
    </table>

  </div>

  <a class= "button" style="margin-top:10px;margin-right:30px;float:right;font-size:16px;width:120px" href="<?php echo url_for('/user/pages/edit_personal_data.php'); ?>">Edit Profile</a>


<!-- </form> -->

</li>
</ul>
</section><!-- .buckets -->


</main>


<!-- .Footer -->
<?php include(SHARED_PATH . '/user_footer.php'); ?>
