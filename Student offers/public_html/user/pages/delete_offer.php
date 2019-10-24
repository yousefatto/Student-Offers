<?php

require_once('../../../private/initialize.php');
is_logged_in();
if(!isset($_GET['id'])) {
  redirect_to(url_for('/user/pages/my_offers.php'));
}
$id = $_GET['id'];  /* Get ID value sent by my_offers.php */
$user_id = $_SESSION['userID'];
if(is_post_request()) {

  $result = delete_offer($id, $user_id); /* Delete offer from DB by post method */
  $_SESSION['message'] = 'The offer was deleted successfully.'; /* Store Success msg in sessions */
  redirect_to(url_for('/user/pages/my_offers.php'));

} else {
  $offer = find_offer_by_id($id, $user_id);
  // Prevent user from IDRO or accessing DB directly
  if(!$offer) {
      redirect_to(url_for('user/pages/my_offers.php'));
    }
}

?>

<?php $page_title = 'Delete Offer'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>
<div style="background-color:#2c343c">
  <h3 style="color:white;display:inline-block;text-align:center;clear:none"><i class="fa fa-fw fa-user"></i>Delete Offer</h3>
  <a class="button" style="display:inline;float:right;width:90px;margin-top:10px;margin-right:5px" href="<?php echo url_for('/user/pages/show_user_offers.php?id='. h(u($offer['OfferID']))); ?>">&laquo; Go Back</a>
</div>
<div class="list" style="overflow-x:auto;">
<table>
  <tr>
    <th style="width:100%">Are you sure you want to delete this offer?</th>
    <th style="width:100%">
      <form action="<?php echo url_for('/user/pages/delete_offer.php?id=' . h(u($offer['OfferID']))); ?>" method="post">
          <input class=".button" type="submit" name="confirm" value="delete" />
      </form>
    </th>

  </tr>
</table>
</div>

</li>

<?php include(SHARED_PATH . '/user_footer.php'); ?>
