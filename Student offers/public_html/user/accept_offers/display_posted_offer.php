<?php require_once('../../../private/initialize.php');
is_logged_in();
// $id = isset($_GET['id']) ? $_GET['id'] : '1';

$id = $_GET['id'] ?? '1';/* Get ID sent by history.php or create_offer.php */
$statuses=array();
$offer = find_posted_offer_by_id($id);
$user = find_user_by_id($offer['userID']);
$user_id = $_SESSION['userID'];
$proposal = find_proposal_by_offerid($id, $user_id);      /*Find signle offer from DB*/
// Prevent user from IDRO or accessing DB directly
if(!$offer) {
    redirect_to(url_for('user/accept_offers/accept_offer.php'));
  }
?>

<?php $page_title = 'Offer details'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

                      <!-- Form for signup -->
                      <div style="background-color:#2c343c">
                        <h3 style="color:white;display:inline-block;text-align:center;clear:none"><i class="fa fa-fw fa-user"></i>Offer details</h3>
                        <a class="button" style="display:inline;float:right;width:90px;margin-top:10px;margin-right:5px" href="<?php echo url_for('/user/accept_offers/list_all_offers.php'); ?>">&laquo; Go Back</a>
                      </div>


      <div class="list" style="overflow-x:auto;">
      <table>
        <tr>
          <th style="width:30%">Project Details</th>
          <th style="width:70%"></th>

        </tr>
        <tr>
          <td>Posted by:</td>
          <td><?php echo $user['username']; ?>
          </td>
        </tr>
          <tr>
            <td>Main Headline:</td>
            <td><?php echo $offer['headline']; ?>
            </td>
          </tr>
          <tr>
            <td>Subject Name:</td>
            <td><?php echo $offer['subject'] ; ?></td>
          </tr>
          <tr>
            <td>Price:</td>
            <td>$<?php echo $offer['price']; ?></td>
          </tr>
          <tr>
            <td>Additional Instructions:</td>
            <td><?php echo $offer['comments'] ; ?></td>
          </tr>
          <tr>
            <td><strong>User Contact details:<strong></td>
          </tr>
          <?php
          $cnt = $user['contact'];
          $addr = $offer['street'].$offer['building'];

          ?>
          <tr>
              <td>Contact Number:</td>
              <td><?php   echo '<span class="blurit">' . strtoupper(substr($cnt,0,1)).preg_replace("/[0-9]/", "x",substr($cnt, 1)) . '</span>'; ?>&nbsp;</td>
          </tr>
          <tr>
            <td>Address for meeting:</td>
            <td><?php   echo '<span class="blurit">' . strtoupper(substr($addr,0,1)).preg_replace("/[a-z0-9]/", "x",substr($addr, 1)) . '</span>'; ?>&nbsp;&nbsp;<?php echo $offer['city']; ?></td>
          </tr>
          <tr>
            <td>Date and  Time:</td>
            <td><?php echo $offer['date']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $offer['time']; ?></td>
          </tr>

        </table>
      </div>



    <div class="favorite">
        <a class="button1" style="margin:0.3em;width:90%" href="<?php echo url_for('/user/accept_offers/offer_confirm.php?id=' . h(u($offer['OfferID']))); ?>">Send a proposal for this offer</a>
    </div>

</li>

    <!-- .Footer -->
  <?php include(SHARED_PATH . '/user_footer.php'); ?>
