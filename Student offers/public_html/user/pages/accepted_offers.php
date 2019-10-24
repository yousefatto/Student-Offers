<?php require_once('../../../private/initialize.php');
is_logged_in();
// $id = isset($_GET['id']) ? $_GET['id'] : '1';

$id = $_GET['id'] ?? '1';
$status = "accept";           /* Get ID sent by history.php or create_offer.php */
$offer = find_offer_by_id($id, $_SESSION['userID']);      /*Find signle offer from DB*/
$proposal = find_proposal_by_status($id, $status);

// Prevent user from IDRO or accessing DB directly
if(!$offer) {
  redirect_to(url_for('user/pages/history.php'));
}
?>

<?php $page_title = 'Offer details'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

<!-- Form for signup -->
<div style="background-color:#2c343c">
  <h3 style="color:white;display:inline-block;text-align:center;clear:none"><i class="fa fa-fw fa-user"></i>Offer details</h3>
  <a class="button" style="display:inline;float:right;width:90px;margin-top:10px;margin-right:5px" href="<?php echo url_for('/user/pages/my_offers.php');?>" >&laquo; Go Back</a>
</div>
<form action="<?php url_for('user/pages/edit_personal_data.php')?>" method="post">

  <div class="list" style="overflow-x:auto;">
    <table>
      <tr>
        <th style="width:100%">Project Details</th>


      </tr>
      <tr>
        <td>Main Headline:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <?php echo $offer['headline']; ?></td>
      </tr>
      <tr>
        <td>Subject Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo $offer['subject'] ; ?></td>
      </tr>
      <tr>
        <td>Price:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        $<?php echo $offer['price']; ?></td>
      </tr>
      <td>Street and Building:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <?php echo $offer['street']; ?>&nbsp;&nbsp;<?php echo $offer['building']; ?></td>
    </tr>
  </tr>
  <tr>
    <td>Date and  Time:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php echo $offer['date']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $offer['time']; ?></td>
  </tr>
  <tr>
    <td>Additional Instructions:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php echo $offer['comments'] ; ?></td>
  </tr>
  <tr style="background-color:green">
    <td>This offer has been accepted by user <?php echo $proposal['userID'] ; ?></td>
  </tr>


</table>
</div>
</form>

                      </li>

    <!-- .Footer -->
  <?php include(SHARED_PATH . '/user_footer.php'); ?>
