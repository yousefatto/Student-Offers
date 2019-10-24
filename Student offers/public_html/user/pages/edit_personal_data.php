<?php require_once('../../../private/initialize.php');
is_logged_in();
$user_id = $_SESSION['userID'];

if(is_post_request()) {

  // Handle form values sent by history.php
  $user = [];
  $user['userID'] = $user_id;
  $user['first_name'] = $_POST['first_name'] ?? '';
  $user['last_name'] = $_POST['last_name'] ?? '';
  $user['email'] = $_POST['email'] ?? '';
  $user['username'] = $_POST['username'] ?? '';
  $user['password'] = $_POST['password'] ?? '';
  $user['confirm_password'] = $_POST['confirm_password'] ?? '';
  $user['contact'] = $_POST['contact'] ?? '';


  $result = update_user($user);  /*updating offer in DB*/

 if($result === true) {
  $_SESSION['message'] = 'The user has been updated successfully.';
  redirect_to(url_for('/user/pages/personal_data.php'));
} else {
  $errors = $result;
}

} else {

  $user = find_user_by_id($user_id);
  // Prevent user from IDRO or accessing DB directly
  if(!$user) {
    redirect_to(url_for('user/pages/index.php'));
  }
}

?>

<?php $page_title = 'Edit Personal Data'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

<!-- Form for signup -->
<div style="background-color:#2c343c">
  <a class="button" style="display:inline;float:right;width:90px;margin-top:10px;margin-right:5px" href="<?php echo url_for('/user/pages/personal_data.php');?>" >&laquo; Go Back</a>
  <h3 style="color:white;display:block;text-align:center;clear:none"><i class="fa fa-fw fa-user"></i>Edit Personal Data</h3>

</div>
<?php echo display_errors($errors); ?>
<form action="<?php echo url_for('/user/pages/edit_personal_data.php?id=' . h(u($user_id))); ?>" method="post">
  <div class="" style="overflow-x:auto;">
    <table class="post-form" style="background-color:#e4e5e6">

      <tr>
        <th style="width:30%">Profile</th>
        <th style="width:70%"></th>

      </tr>
      <tr>
        <td><label for="fname and lname">First and Last Name</label></td>
        <td>	<input style="width:47%" id="fname" name="first_name" placeholder="first name" required="" tabindex="1" type="text" value="<?php echo h($user['first_name']); ?>" >
          <input style="width:47%;display:inline"id="lname" name="last_name" placeholder="lname" required="" tabindex="5" type="text" value="<?php echo h($user['last_name']); ?>" >
        </td>
      </tr>
      <tr>
        <td><label for="subject">Username</label></td>
        <td><input style="width:95%" id="username" name="username" placeholder="username" required="" tabindex="2" type="text" value="<?php echo h($user['username']); ?>" >
        </td>
      </tr>
      <tr>
        <td><label for="price">Email</label></td>
        <td><input style="width:95%" id="email" name="email" placeholder="email" required="" tabindex="3" type="text" value="<?php echo h($user['email']); ?>" ></td>
      </tr>
      <tr>
        <tr>
          <td><label for="price">Password</label></td>
          <td><input style="width:95%" id="password" name="password"  tabindex="3" type="password" value="" ></td>
        </tr>
      </tr>
      <tr>
        <tr>
          <td><label for="price">Confirm Password</label></td>
          <td><input style="width:95%" id="cpassword" name="confirm_password"  tabindex="3" type="password" value="" ></td>
        </tr>
      </tr>
      <tr>
        <td><label for="mnumer">Mobile Number</label></td>
        <td><input style="width:95%" id="mnumer" name="contact" placeholder="mnumer" required="" tabindex="3" type="text" value="<?php echo h($user['contact']); ?>" ></td>
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

  <input  style="width:90px" type="submit" value="Save" name="submit">

</form>

  <a class="button" style="display:inline;float:right;width:90px;margin-top:5px;margin-right:5px;font-size:14px" href="<?php echo url_for('/user/pages/personal_data.php');?>" >Cancel</a>
</li>
</ul>
</section><!-- .buckets -->


</main>


<!-- .Footer -->
<?php include(SHARED_PATH . '/user_footer.php'); ?>
