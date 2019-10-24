<?php require_once('../../../private/initialize.php');
is_logged_in();

$page_title = 'My Proposals';
//For finding lists of all offers in DB
$user_id = $_SESSION['userID'];           /* Get ID sent by history.php or create_offer.php */
$proposals = find_proposal_by_id($user_id);
$innerjoins = find_proposal_by_innerjoin($user_id);
$pstatus = find_proposal_by_innerjoin_status($user_id);
/*Find signle offer from DB*/

// Prevent user from IDRO or accessing DB directly


include(SHARED_PATH . '/user_header.php');

?>
<div style="background-color:#2c343c"><h3 style="color:white"><i class="fa fa-fw fa-user"></i>My Proposals</h3></div>
<div class="list" style="overflow-x:auto;">
  <table>
    <tr>
      <!-- <th>OfferID</th> -->
      <th>Headline</th>
      <th>Price</th>
      <th>Actions/Status</th>
    </tr>

    <?php while( $innerjoin = mysqli_fetch_assoc( $innerjoins)) { ?>
      <tr>
        <!-- <td><echo $innerjoin['OfferID']; ?></td> -->
        <td style="padding:8px"><?php echo  $innerjoin['headline']; ?></td>
        <td style=""><?php echo  $innerjoin['price']; ?></td>
        <?php if($innerjoin['status']=="accept") { ?>
          <?php echo "<td><a class= 'button' style='width:90px;background-color:orangered' href='".url_for('user/accept_offers/accepted_proposals.php?id=' .$innerjoin['OfferID'])."'>Accepted</a></td>";?>
        <?php } elseif ($innerjoin['status']=="decline") {?>
        <?php echo "<td><a class= 'button' style='width:90px;background-color:red' href='".url_for('user/accept_offers/declined_proposals.php?id=' .$innerjoin['OfferID'])."'>Declined</a></td>";?>
        <?php } else{ ?>
          <td><a class="button" href="<?php echo url_for('user/accept_offers/display_proposals.php?id=' .$innerjoin['OfferID']);?>">View</a></td>
        <?php } ?>

      </tr>
    <?php } ?>
  </table>
</div>


</form>


</li>


<!-- .Footer -->
<?php include(SHARED_PATH . '/user_footer.php'); ?>
