<?php require_once('../../../private/initialize.php');
is_logged_in();
// $id = isset($_GET['id']) ? $_GET['id'] : '1';

$id = $_GET['id'] ?? '1';            /* Get ID sent by history.php or create_offer.php */
$offer = find_posted_offer_by_id($id);
$user = find_user_by_id($offer['userID']);
$user_id = $_SESSION['userID'];
// Prevent user from IDRO or accessing DB directly
if(!$offer) {
  redirect_to(url_for('user/accept_offers/accept_offer.php'));
}
?>

<?php $page_title = 'Offer details'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

<!-- Form for signup -->

<div style="background-color:#2c343c"><h3 style="color:white;display:inline-block;text-align:center;clear:none"><i class="fa fa-fw fa-user"></i>Offer details</h3><a class="button" style="display:inline;float:right;width:90px;margin-top:10px;margin-right:5px" href="<?php echo url_for('/user/accept_offers/my_proposals.php'); ?>">&laquo; Go Back</a></div>

<div class="list" style="overflow-x:auto;">

  <table style="background-color:green">
      <tr>
        <?php echo "<td style='padding:8px'> Your proposal for offer ".$offer['headline']." has been accepted by USER ".$user['username']."</td>" ; ?>
      </tr>
</table>
</div>
<form action="<?php url_for('user/accept_offers/edit_personal_data.php')?>" method="post">


  <div class="list" style="overflow-x:auto;">
    <table>
      <tr>
        <th style="width:30%">Project Details</th>
        <th style="width:70%"></th>

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
        <tr>
            <td>Contact Number:</td>
            <td><?php echo $user['contact']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <?php
        $addr = $offer['street'].$offer['building'];

        ?>
        <tr>
          <td>Address for meeting:</td>
          <td><?php   echo $addr; ?>&nbsp;&nbsp;<?php echo $offer['city']; ?></td>
        </tr>
        <tr>
          <td>Date and  Time:</td>
          <td><?php echo $offer['date']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $offer['time']; ?></td>
        </tr>

      </table>
    </div>

  </style>
</head>
</form>


</li>

<!-- .Footer -->
<?php include(SHARED_PATH . '/user_footer.php'); ?>
