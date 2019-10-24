<?php

require_once('../../../private/initialize.php');
is_logged_in();
if(!isset($_GET['id'])) {
  redirect_to(url_for('/user/accept_offers/list_all_offers.php'));
}
$id = $_GET['id'];  /* Get ID value sent by my_offers.php */
$offer = find_proposal_by_own_id($id);
$offerid = $offer['OfferID'];
$user_id = $_SESSION['userID'];
if(is_post_request()) {

    // Handle form values sent by history.php

    $offer = [];
    $offer['id'] = $id;
    $offer['status'] = $_POST['confirm'] ?? '';
    $offer['ready'] = 0;
    $result = update_proposal($offer);  /*updating offer in DB*/

    if ($offer['status'] =="accept") {
        $sql = "UPDATE posted_offers SET ";
        $sql .= "status='" . db_escape($db, $offer['status']) . "' ";
        $sql .= "WHERE OfferID='" . db_escape($db, $offerid) . "' ";
        $sql .= "LIMIT 1";
        $result0 = mysqli_query($db, $sql);
        
        $sql = "UPDATE proposals SET ";
        $sql .= "status='" . db_escape($db, "decline") . "' ";
        $sql .= "WHERE OfferID='" . db_escape($db, $offerid) . "' AND not id='". db_escape($db, $id) . "' ";
        $result0 = mysqli_query($db, $sql);
    }
    $_SESSION['message'] = 'The owner of this proposal has been duely informed.'; /* Store Success msg in sessions */
    redirect_to(url_for('user/pages/my_offers.php'));

}

  // Prevent user from IDRO or accessing DB directly
  if(!$offer) {
      redirect_to(url_for('user/accept_offers/list_all_offers.php'));
    }

?>

<?php $page_title = 'Delete Offer'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>
<div style="background-color:#2c343c">
  <h3 style="color:white;display:inline-block;text-align:center;clear:none"><i class="fa fa-fw fa-user"></i>Accept or Decline Proposal</h3>
  <a class="button" style="display:inline;float:right;width:90px;margin-top:10px;margin-right:5px" href="<?php echo url_for('/user/pages/show_user_offers.php?id=' . $offerid); ?>">&laquo; Go Back</a>
</div>
<div class="list" style="overflow-x:auto;">
<table>
  <tr>
    <th style="width:100%">Do you want to accept or decline this proposal? by User<?php echo h($offer['userID']); ?></th>
    <th style="width:100%">
      <form action="<?php echo url_for('/user/accept_offers/proposal_confirm.php?id=' . h(u($id))); ?>" method="post">
          <input type="hidden" name="status" value="accepted"/>
          <input type="submit" name="confirm" value="accept" />
      </form>

      <form action="<?php echo url_for('/user/accept_offers/proposal_confirm.php?id=' . h(u($id))); ?>" method="post">
          <input type="hidden" name="status" value="declined"/>
          <input type="submit" name="confirm" value="decline" />
      </form>
    </th>

  </tr>
</table>
</div>

</li>

<?php include(SHARED_PATH . '/user_footer.php'); ?>
