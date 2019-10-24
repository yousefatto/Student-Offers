<?php require_once('../../../private/initialize.php');
is_logged_in();
?>

<?php $page_title = 'List All Offers'; ?>

<?php

//For finding lists of all offers in DB
//$offers = find_all_posted_offers();
$user_id = $_SESSION['userID'];
$offers = find_all_posted_offers_without_proposals($user_id);

?>


<?php include(SHARED_PATH . '/user_header.php');

 ?>

  <div style="background-color:#2c343c"><h3 style="color:white"><i class="fa fa-fw fa-user"></i>List All Offers</h3></div>


      <div class="list" style="overflow-x:auto;">
        <table>
          <tr><th style="width:30%">Headline</th><th>Subject</th><th>Price</th><th>Actions/Status</th></tr>
          <tr>
          </tr>
          <?php while($offer = mysqli_fetch_assoc($offers)) { ?>
          <?php  $proposal = find_proposal_by_offerid($offer['OfferID']);?>
          <tr><td style="padding:8px"><?php echo $offer['headline']; ?></td>
          <!--<td>userID for offer:</td> <td>< echo $offer['userID']; ?></td> </tr>------>
          <td><?php echo $offer['subject'] ; ?></td>
          <td style="text-align:center">$<?php echo $offer['price']; ?></td>
          <!--<td style="text-align:center"><php /*echo $offer['userID']; */?></td>-->


            <td>


              <?php if($offer['status']=="accept") { ?>
                  <?php echo "<p class= 'button' style='width:150px;background-color:orangered' >Offer Completed</p>" ?>
                <?php }  else { ?>
                  <div class="<?php if($user_id == $offer['userID'] && $offer['status']!=="accept") { echo 'favorite'; }  ?>">
                      <a class= "button1" style='width:150px' href="<?php echo url_for('/user/pages/edit_offer.php?id=' . h(u($offer['OfferID']))); ?>">Edit Offer</a>
                  </div>

                  <div class="<?php if($user_id !== $offer['userID'] && $offer['status']!=="accept") { echo 'favorite'; }  ?>">
                      <a class="button1" style='width:150px' href="<?php echo url_for('user/accept_offers/display_posted_offer.php?id=' .$offer['OfferID']);?>">View Offer</a>
                  </div>
                <?php } ?>
                      <?php  ?>



              </td>
            </tr>
              <?php } ?>
          </table>
  </div>

</div>


                      </li>


    <!-- .Footer -->
<?php include(SHARED_PATH . '/user_footer.php'); ?>
