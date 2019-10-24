<?php require_once('../../../private/initialize.php');
is_logged_in();

$page_title = 'My Posted Offers';
//For finding lists of all offers in DB
$user_id = $_SESSION['userID'];           /* Get ID sent by history.php or create_offer.php */
$offers = find_offer_by_user_id($user_id);     /*Find signle offer from DB*/

// Prevent user from IDRO or accessing DB directly


include(SHARED_PATH . '/user_header.php');

?>

<div style="background-color:#2c343c"><h3 style="color:white"><i class="fa fa-fw fa-user"></i>My Posted Offers</h3></div>
<div class="list" style="overflow-x:auto;">
  <table>
    <tr>
      <!-- <th>ID</th> -->
      <th>Headline</th>
      <th>Subject</th>
      <th>Price</th>
  
      <th>Action</th>
    </tr>

    <?php while($offer = mysqli_fetch_assoc($offers)) { ?>
      <?php  $proposal = find_proposal_by_offerid($offer['OfferID']);?>
        <?php  $count = count_new_proposals_for_offers($offer['OfferID']);?>
      <tr>
        <!-- <td>< echo $offer['OfferID']; ?></td> -->
        <td style="padding:8px"><?php echo $offer['headline']; ?></td>
        <td style="padding:8px"><?php echo $offer['subject'] ; ?></td>
        <td style="padding:8px">$<?php echo $offer['price']; ?></td>




          <?php if($offer['status']=="accept") { ?>
              <?php echo "<td style='background-color:orangered'><a class= 'button' style='width:90px;background-color:orangered' href='".url_for('user/pages/accepted_offers.php?id=' .$offer['OfferID'])."'>Accepted</a></td>";?>
          <?php } elseif ($count>0) {?>
              <td><a class="button" style='width:90px;background-color:red' href="<?php echo url_for('user/pages/show_user_offers.php?id=' .$offer['OfferID']);?>">Take Action</a></td>

          <?php } else{ ?>
              <td><a class= 'button' style='width:90px;background-color:green' href="<?php echo url_for('user/pages/show_user_offers.php?id=' .$offer['OfferID']);?>">View</a></td>
          <?php } ?>

      </tr>
    <?php } ?>
  </table>
</div>

</form>


</li>


<!-- .Footer -->
<?php include(SHARED_PATH . '/user_footer.php'); ?>
