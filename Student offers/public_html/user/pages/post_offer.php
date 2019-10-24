<?php require_once('../../../private/initialize.php');
is_logged_in();
?>
<?php
if(is_post_request()) {

  // Handle form values sent by post_offer.php

  $offer = [];
  $offer['userID'] = $_SESSION['userID'] ?? '';
  $offer['headline'] = $_POST['headline'] ?? '';
  $offer['subject'] = $_POST['subject'] ?? '';
  $offer['price'] = $_POST['price'] ?? '';
  $offer['street'] = $_POST['street'] ?? '';
  $offer['building'] = $_POST['building'] ?? '';
  $offer['zip'] = $_POST['zip'] ?? '';
  $offer['city'] = $_POST['city'] ?? '';
  $offer['date'] = $_POST['date'] ?? '';
  $offer['time'] = $_POST['time'] ?? '';
  $offer['comments'] = $_POST['comments'] ?? '';

  $result = insert_offer($offer);  /* Insert new offer in DB */

  if($result == 'true'){
    $new_id = mysqli_insert_id($db); /* Fetch ID of newly inserted offer */
    $_SESSION['message'] = 'The offer was created successfully.'; /* Store Success msg in sessions */
    redirect_to(url_for('/user/pages/show_user_offers.php?id=' . $new_id));
  } else {
    $errors = $result;
  }

} else {
  // Display form blank
  $offer = [];
  $offer['headline'] = $_POST['headline'] ?? '';
  $offer['subject'] = $_POST['subject'] ?? '';
  $offer['price'] = $_POST['price'] ?? '';
  $offer['street'] = $_POST['street'] ?? '';
  $offer['building'] = $_POST['building'] ?? '';
  $offer['zip'] = $_POST['zip'] ?? '';
  $offer['city'] = $_POST['city'] ?? '';
  $offer['date'] = $_POST['date'] ?? '';
  $offer['time'] = $_POST['time'] ?? '';
  $offer['comments'] = $_POST['comments'] ?? '';
}

?>

<?php $page_title = 'Post an Offer'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

<!-- Form for signup -->

<div style="background-color:#2c343c">
  <h3 style="color:white;display:block;text-align:center;clear:none"><i class="fa fa-fw fa-user"></i>Post an Offer</h3>

</div>
<?php echo display_errors($errors); ?>
<form action="<?php echo url_for('/user/pages/post_offer.php'); ?>" method="post">
  <div class="" style="overflow-x:auto;">
    <table class="post-form" style="background-color:#e4e5e6">

      <tr>
        <th style="width:30%">Project Details</th>
        <th style="width:70%"></th>

      </tr>
      <tr>
        <td><label for="headline">Brief headline</label></td>
        <td>
          <input style="width:95%" id="headline" name="headline" placeholder="Enter a brief offer headline" required="" tabindex="1" type="text" value="<?php echo h($offer['headline']); ?>">
        </td>
      </tr>
      <tr>
        <td><label for="subject">Subject</label></td>
        <td><input style="width:95%" id="subject" name="subject" placeholder="subject name" required="" tabindex="2" type="text" value="<?php echo h($offer['subject']); ?>">
        </td>
      </tr>
      <tr>
        <td><label for="price">Offering Price $</label></td>
        <td><input style="width:95%" id="price" name="price" placeholder="Range between 0 and 999" required="" tabindex="3" type="text" value="<?php echo h($offer['price']); ?>"></td>
      </tr>
      <tr>
        <td><label for="street">Street and Building</label></td>
        <td>	<input style="width:60%" id="street" name="street" placeholder="Street name e.g. Am Steingarten" required="" tabindex="4" type="text" value="<?php echo h($offer['street']); ?>">
          <input style="width:35%;display:inline"id="building" name="building" placeholder="Building Number" required="" tabindex="5" type="text" value="<?php echo h($offer['building']); ?>">
        </td>
      </tr>
      <tr>
        <td>  <label for="zip">Zip code / City</label></td>
        <td>	<input style="width:40%" id="zip" name="zip" placeholder="Enter a valid 6 digits zip code" required="" tabindex="6" type="text" value="<?php echo h($offer['zip']); ?>">
          <input style="width:55%" id="city" name="city" placeholder="City Name" required="" type="text" tabindex="7" value="<?php echo h($offer['city']); ?>">
        </td>
      </tr>
      <tr>
        <td><label for="time">Date and Time</label></td>
        <td><input style="width:45%" id="date" name="date"  required="" type="date" tabindex="8" value="<?php echo h($offer['date']); ?>">
          <input style="width:50%" id="time" name="time" required="" type="time" tabindex="9"  value="<?php echo h($offer['time']); ?>">
        </td>
      </tr>
      <tr style="width:100%">
        <td alight="right" valign="top"> <label for="comments">Additional Instructions</label></td>
        <td class="row"><textarea class="col-75"id="comments" name="comments" placeholder="Briefly Explain the requirements about the offer" required="" tabindex="10" style="width:95%;height:100px" value="<?php echo h($offer['comments']); ?>"></textarea>
        </td>
        </tr>
    </table>

  </div>



  <input type="submit" style="width:90px" value="Submit">
</form>
    <a class="button" style="display:inline;float:right;width:90px;margin-top:5px;margin-right:5px;font-size:14px" href="<?php echo url_for('/user/pages/index.php');?>" >Cancel</a>



</li>
</ul>
</section><!-- .buckets -->


</main>


    <!-- .Footer -->
<?php include(SHARED_PATH . '/user_footer.php'); ?>
