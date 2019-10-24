<?php

require_once('../../../private/initialize.php');
is_logged_in();
if(!isset($_GET['id'])) {
  redirect_to(url_for('/user/accept_offers/list_all_offers.php'));
}
$id = $_GET['id'];  /* Get ID value sent by my_offers.php */
$user_id = $_SESSION['userID'];
if(is_post_request()) {
  $offer = [];
  $offer['userID'] = $user_id ?? '';
  $offer['OfferID'] = $id ?? '';
  $offer['status'] = $_POST['status'] ?? '';

  $result = insert_proposal($offer);  /* Insert new offer in DB */

  if($result == 'true'){
  $new_id = mysqli_insert_id($db); /* Fetch ID of newly inserted offer */
  $_SESSION['message'] = 'The proposal for offer has been confirmed.'; /* Store Success msg in sessions */
  redirect_to(url_for('/user/accept_offers/my_proposals.php'));
  } else {
  $errors = $result;
  }
}
  $offer = find_posted_offer_by_id($id);
  // Prevent user from IDRO or accessing DB directly
  if(!$offer) {
      redirect_to(url_for('user/accept_offers/list_all_offers.php'));
    }
?>

<?php $page_title = 'Delete Offer'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>
<div style="background-color:#2c343c">
  <h3 style="color:white;display:inline-block;text-align:center;clear:none"><i class="fa fa-fw fa-user"></i>Send Proposal</h3>
  <a class="button" style="display:inline;float:right;width:90px;margin-top:10px;margin-right:5px" href="<?php echo url_for('/user/accept_offers/display_posted_offer.php?id=' . $id); ?>">&laquo; Go Back</a>
</div>
<div class="list" style="overflow-x:auto;">
<table>
  <tr>
    <th style="width:100%">Are you sure you want to send proposal for this offer? <?php echo h($offer['headline']); ?></th>
    <th style="width:100%">
      <form action="<?php echo url_for('/user/accept_offers/offer_confirm.php?id=' . h(u($offer['OfferID']))); ?>" method="post">
          <input type="hidden" name="status" value="pending for approval"/>
          <input type="submit" name="confirm" value="confrim" />
      </form>
    </th>

  </tr>
</table>
</div>

</li>

<?php include(SHARED_PATH . '/user_footer.php'); ?>
