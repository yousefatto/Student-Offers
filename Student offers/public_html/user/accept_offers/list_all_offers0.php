<?php require_once('../../../private/initialize.php');
is_logged_in();
?>

<?php $page_title = 'All Offers'; ?>

<?php

//For finding lists of all offers in DB
$offers = find_all_posted_offers();
$user_id = $_SESSION['userID'];
$proposals = find_proposal_by_id($user_id);
?>


<?php include(SHARED_PATH . '/user_header.php'); ?>

  <h3>All Offers</h3>

  <h3 style="text-align:left">Posted Offers</h3>


    <?php while($offer = mysqli_fetch_assoc($offers)) { ?>
      <div class="list" style="overflow-x:auto;">
        <table>
          <tr>

            <th style="width:40%"><?php echo $offer['headline']; ?></th>
            <th>&nbsp;</th>


          </tr>
          <tr><td>Subject:</td> <td><?php echo $offer['subject'] ; ?></td></tr>
          <tr><td>Price:</td> <td>$<?php echo $offer['price']; ?></td> </tr>
          <tr>
            <td></td>
            <td>
              <a class="button" href="<?php echo url_for('user/accept_offers/display_posted_offer.php?id=' .$offer['OfferID']);?>">View</a>
              <div class="<?php if($user_id == $offer['userID']) { echo 'favorite'; } ?>">
                <a class= "button1" href="<?php echo url_for('/user/pages/edit_offer.php?id=' . h(u($offer['OfferID']))); ?>">Edit</a>
              </div>
              </td>
            </tr>
          </table>
  </div>
    <?php } ?>

</div>


                      </li>


    <!-- .Footer -->
<?php include(SHARED_PATH . '/user_footer.php'); ?>
