<?php require_once('../../private/initialize.php');
is_logged_in();

$userid = $_SESSION['userID'];            /* Get ID sent by history.php or create_offer.php */
$user = find_admin_by_id($userid);      /*Find signle offer from DB*/
// Prevent user from IDRO or accessing DB directly
if(!$user) {
  redirect_to(url_for('user/pages/history.php'));
}

?>

<?php $page_title = 'Personal data'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

                      <!-- Form for signup -->
                      <li class="main-area">
                        <h2>Personal Data</h2>
                        <div class="container">
                          <form action="<?php url_for('user/pages/edit_personal_data.php')?>" method="post">
                            <div class="row">
                              <div class="col-25">
                                <label for="name">Name</label>
                              </div>
                              <div class="col-75">
                                <input id="name" name="name" placeholder="First and last name" required="" tabindex="1" type="text" value="<?php echo $user['first_name']; ?>" >
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-25">
                                <label for="email">Email</label>
                              </div>
                              <div class="col-75">
                                	<input id="email" name="email" placeholder="example@domain.com" required="" type="email" disabled value="<?php echo $user['email'];?>">
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-25">
                                <label for="username">Create a username</label>
                              </div>
                              <div class="col-75">
                                	<input id="username" name="username" placeholder="username" required="" tabindex="2" type="text" value="<?php echo $user['username'];?>" disabled >
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-25">
                                <label for="password">Create a password</label>
                              </div>
                              <div class="col-75">
                                	<input type="password" id="password" name="password" required="" disabled value="<?php echo $user['hashed_password'];?>">
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-25">
                                <label for="phone">Mobile phone</label>
                              </div>
                              <div class="col-75">
                              <input id="phone" name="phone" placeholder="phone number" required="" type="text" disabled>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-25">
                                <label for="gender">Gender</label>
                              </div>
                              <div class="col-75">
                                <select id="gender" name="gender" disabled>
                                  <option value="male">Male</option>
                                  <option value="female">Female</option>
                                </select>
                              </div>
                            </div>
                            <!-- /*<div class="row">
                              <div class="col-25">
                                <label for="subject">Subject</label>
                              </div>
                              <div class="col-75">
                                <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>
                              </div>
                            </div>*/ -->
                            <div class="row">
                              <input type="submit" value="Submit">
                            </div>
                          </form>
                        </div>

                      </li>

    <!-- .Footer -->
  <?php include(SHARED_PATH . '/user_footer.php'); ?>
