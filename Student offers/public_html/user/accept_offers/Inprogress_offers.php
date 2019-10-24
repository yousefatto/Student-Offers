<?php require_once('../../../private/initialize.php');
is_logged_in();
?>

<?php $page_title = 'All Offers'; ?>

<?php

//For finding lists of all offers in DB
$user_id = $_SESSION['userID'];           /* Get ID sent by history.php or create_offer.php */
$offers = find_offer_by_user_id($user_id);


?>


<?php include(SHARED_PATH . '/user_header.php');

 ?>

  <div style="background-color:#2c343c"><h3 style="color:white"><i class="fa fa-fw fa-user"></i>Current Offers</h3></div>


      <div class="list" style="overflow-x:auto;">
        <table>
          <tr><th style="width:30%">Headline</th><th>Subject</th><th>Price</th><th>Posted By</th><th>Actions</th></tr>
          <tr>
          </tr>
          <?php while($offer = mysqli_fetch_assoc($offers)) { ?>
          <?php  $proposal = find_proposal_by_offerid($offer['OfferID']);?>
          <tr><td style="padding:8px">Your Offer <?php echo $offer['headline']; ?></td>
          <!--<td>userID for offer:</td> <td>< echo $offer['userID']; ?></td> </tr>------>
          <td style="text-align:center">has been accepted by USER<?php echo $proposal['userID']; ?></td>
          <td style="text-align:center">with status<?php echo $proposal['status']; ?></td>

            <td>
              <div class="<?php if($user_id !== $offer['userID'] && $user_id !== $proposal['userID']) { echo 'favorite'; }  ?>">
              <a class="button1" href="<?php echo url_for('user/accept_offers/display_posted_offer.php?id=' .$offer['OfferID']);?>">View</a>
              </div>
              <div class="<?php if($user_id == $offer['userID']) { echo 'favorite'; }  ?>">
                <a class= "button1" href="<?php echo url_for('/user/pages/edit_offer.php?id=' . h(u($offer['OfferID']))); ?>">Edit</a>
              </div>

              <div class="<?php if($user_id == $proposal['userID']) { echo 'favorite'; } ?>">
                <a class= "button1" href="<?php echo url_for('/user/accept_offers/display_proposals.php?id=' . h(u($offer['OfferID']))); ?>">Cancel</a>
              </div>
              </td>
            </tr>
              <?php } ?>
          </table>
  </div>

</div>


                      </li>


    <!-- .Footer -->
<?php include(SHARED_PATH . '/user_footer.php'); ?>
