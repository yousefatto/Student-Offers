<?php require_once('../../private/initialize.php');
if(is_post_request()) {

  // Handle form values sent by new.php

  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $username = $_POST['username'] ?? '';

  echo "Form parameters<br />";
  echo "Name: " . $name . "<br />";
  echo "Email: " . $email . "<br />";
  echo "Username: " . $username . "<br />";
} else {
  redirect_to(url_for('/staff/subjects/new.php'));
}?>

<?php $page_title = 'Edit Personal data'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

                      <!-- Form for signup -->
                      <li class="main-area">
                        <h2>Edit Personal data</h2>
                        <div class="container">
                          <form action="/action_page.php">
                            <div class="row">
                              <div class="col-25">
                                <label for="name">Name</label>
                              </div>
                              <div class="col-75">
                                <input id="name" name="name" placeholder="First and last name" required="" tabindex="1" type="text" value="<?php echo $name; ?>" disabled>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-25">
                                <label for="email">Email</label>
                              </div>
                              <div class="col-75">
                                	<input id="email" name="email" placeholder="example@domain.com" required="" type="email" disabled value="<?php echo $email;?>">
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-25">
                                <label for="username">Create a username</label>
                              </div>
                              <div class="col-75">
                                	<input id="username" name="username" placeholder="username" required="" tabindex="2" type="text" value="<?php echo $username;?>" disabled >
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-25">
                                <label for="password">Create a password</label>
                              </div>
                              <div class="col-75">
                                	<input type="password" id="password" name="password" required="" disabled>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-25">
                                <label for="repassword">Confirm password</label>
                              </div>
                              <div class="col-75">
                                	<input type="password" id="repassword" name="repassword" required="" disabled>
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
                              <input type="cancel" value="Cancel">
                            </div>
                          </form>
                        </div>

                      </li>

    <!-- .Footer -->
  <?php include(SHARED_PATH . '/user_footer.php'); ?>
