<?php
require_once('../../../private/initialize.php');
$user_id = $_SESSION['userID'];
$result = find_proposals_by_user_offers($user_id);
$statuses = find_proposal_by_innerjoin_status($user_id);
$update = update_proposal_notifications($user_id);
$response = "";
$response1 = "";
echo "<div class='notification-item'><div class='notification-comment'><a style='' href='".url_for('/user/pages/index.php')."'>Welcome ".$_SESSION['username']."</a></div></div>";

while($row=mysqli_fetch_array($result)) {
	$response = $response . "<div class='notification-item'>" .
	"<div class='notification-subject'>A new proposal for your </div>" .
	"<div class='notification-comment'>offer " . $row["headline"]  . "</div>" .
	"</div>";
}

while($status=mysqli_fetch_assoc($statuses)) {
	$response1 = $response1 . "<div class='notification-item'>" .
	"<div style= 'background-color:red' class='notification-subject'>Your proposal for ". $status["headline"] ." </div>" .
	"<div style= 'background-color:red' class='notification-comment'> has been ".$status["status"]."</div>" .
	"</div>";
}

if(!empty($response)) {
	print $response;
}

if(!empty($response1)) {
	print $response1;
}
echo "<div class='notification-item'><div class='notification-comment'><a href='".url_for('/user/logout.php')."'>Logout</a></div></div>";


?>
