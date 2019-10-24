<?php

// For finding all offers in DB
function find_all_posted_offers() {
  global $db;

  $sql = "SELECT * FROM posted_offers ";
  $sql .= "ORDER BY status ASC";
  //echo $sql;
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);/*To check if query successful*/
  return $result;
}

// For finding all offers in DB
function find_offer_by_user_id($user_id) {
  global $db;

  $sql = "SELECT * FROM posted_offers ";
  $sql .= "WHERE userID='" . db_escape($db, $user_id) . "' ";
  $sql .= "ORDER BY status ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

// For finding single offer detail in DB provided with id
function find_posted_offer_by_id($id) {
  global $db;

  $sql = "SELECT * FROM posted_offers ";
  $sql .= "WHERE OfferID='" . db_escape($db, $id) . "'";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $subject = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $subject; // returns an assoc. array
}
// For finding single offer detail in DB provided with id
function find_offer_by_id($id, $user_id) {
  global $db;

  $sql = "SELECT * FROM posted_offers ";
  $sql .= "WHERE OfferID='" . db_escape($db, $id) . "' ";
  $sql .= "AND userID='" . db_escape($db, $user_id) . "'";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $subject = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $subject; // returns an assoc. array
}

// For finding all offers without the offers that user has sent a proposal in DB
function find_all_posted_offers_without_proposals($userid) {
  global $db;
  $sql = "SELECT * FROM posted_offers WHERE OfferID not in (select OfferID from proposals where userID='". db_escape($db, $userid) ."' OR status='accept' ) AND not userID='". db_escape($db, $userid) ."' " ;

  //echo $sql;
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
    return $result;
  }

//For form validation before inserting and updating into DB
function validate_offer($offer) {
  $errors = [];

  // Headline
  if(is_blank($offer['headline'])) {
    $errors[] = "Headline cannot be blank.";
  } elseif(!has_length($offer['headline'], ['min' => 1, 'max' => 255])) {
    $errors[] = "Headline must be between 2 and 255 characters.";
  }

  // Subject
  if(is_blank($offer['subject'])) {
    $errors[] = "Subject cannot be blank.";
  } elseif(!has_length($offer['subject'], ['min' => 1, 'max' => 255])) {
    $errors[] = "Subject must be between 2 and 255 characters.";
  }

  // Price
  // Make sure we are working with an integer

  $raw_price = $offer['price'];
  $price0 = str_replace(' ', '', $raw_price);
  $price = (int) $price0;
  if($price <= 0) {
    $errors[] = "Please insert a valid price.";
  }
  if($price > 999) {
    $errors[] = "Price must be less than 999.";
  }

  //Street
  if(is_blank($offer['street'])) {
    $errors[] = "Street name cannot be blank.";
  } elseif (!has_length($offer['street'], array('min'=>1, 'max' => 20))) {
    $errors[] = "Please enter a valid street name.";
  }

  //Building number
  if(is_blank($offer['building'])) {
    $errors[] = "Building number cannot be blank.";
  } elseif (!has_length($offer['building'], array('min'=>0, 'max' => 6))) {
    $errors[] = "Please enter a valid building number.";
  } elseif (!preg_match('/[0-9]/', $offer['building'])) {
    $errors[] = "Please enter a valid building number.";
  }

  //zipcode
  if ( !preg_match('/^\d{5}$/', $offer['zip'])) {
    $errors[] = "Please enter a valid 5 digits zip code.";
  }

  //City
  if(is_blank($offer['city'])) {
    $errors[] = "Headline cannot be blank.";
  } elseif(!has_length($offer['city'], ['min' => 2, 'max' => 255])) {
    $errors[] = "Enter a valid city name.";
  }
  return $errors;
}

// For inserting offers into DB
  function insert_offer($offer) {
  global $db;

  $errors = validate_offer($offer);
  if(!empty($errors)) {
    return $errors;
  }

  $sql = "INSERT INTO posted_offers ";
  $sql .= "(userID, headline, subject, price,street, building, zip, city, date, time, comments) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db,$offer['userID']) . "',";
  $sql .= "'" . db_escape($db,$offer['headline']) . "',";
  $sql .= "'" . db_escape($db,$offer['subject']) . "',";
  $sql .= "'" . db_escape($db,$offer['price']) . "',";
  $sql .= "'" . db_escape($db,$offer['street']) . "',";
  $sql .= "'" . db_escape($db,$offer['building']) . "',";
  $sql .= "'" . db_escape($db,$offer['zip']) . "',";
  $sql .= "'" . db_escape($db,$offer['city']) . "',";
  $sql .= "'" . db_escape($db,$offer['date']) . "',";
  $sql .= "'" . db_escape($db,$offer['time']) . "',";
  $sql .= "'" . db_escape($db,$offer['comments']) . "'";
  $sql .= ")";
  $result = mysqli_query($db, $sql);
  if($result) { /* For INSERT statements, $result is true/false*/
    return true;
  } else {
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

// For updating the offers in DB
function update_offer($offer) {
  global $db;

  $errors = validate_offer($offer);
  if(!empty($errors)) {
    return $errors;
  }

  $sql = "UPDATE posted_offers SET ";
  $sql .= "userID='" . db_escape($db,$offer['userID']) . "', ";
  $sql .= "headline='" . db_escape($db,$offer['headline']) . "', ";
  $sql .= "subject='" . db_escape($db,$offer['subject']) . "', ";
  $sql .= "price='" . db_escape($db,$offer['price']) . "', ";
  $sql .= "street='" . db_escape($db,$offer['street']) . "', ";
  $sql .= "building='" . db_escape($db,$offer['building']) . "', ";
  $sql .= "zip='" . db_escape($db,$offer['zip']) . "', ";
  $sql .= "city='" . db_escape($db,$offer['city']) . "', ";
  $sql .= "date='" . db_escape($db,$offer['date']) . "', ";
  $sql .= "time='" . db_escape($db,$offer['time']) . "', ";
  $sql .= "comments='" . db_escape($db,$offer['comments']) . "', ";
  $sql .= "status='" . db_escape($db,$offer['status']) . "' ";
  $sql .= "WHERE OfferID='" . db_escape($db,$offer['id']) . "' ";
  $sql .= "LIMIT 1";

  $result = mysqli_query($db, $sql);
  if($result) { /* For UPDATE statements, $result is true/false*/
    return true;
  } else {
    // UPDATE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }

}

// For deleting the offers in DB
function delete_offer($id, $user_id) {
  global $db;

  $sql = "DELETE FROM posted_offers ";
  $sql .= "WHERE OfferID='" . db_escape($db,$id) . "' ";
  $sql .= "AND userID='" . db_escape($db, $user_id) . "' ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db, $sql);

  if($result) {  /*For DELETE statements, $result is true/false*/
    return true;
  } else {
    // DELETE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

/*For finding, inserting and updating users*/

// For finding single user in DB with id
function find_user_by_id($userid) {
  global $db;

  $sql = "SELECT * FROM users ";
  $sql .= "WHERE userID='" . db_escape($db, $userid) . "' ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $user = mysqli_fetch_assoc($result); // find first
  mysqli_free_result($result);
  return $user; // returns an assoc. array
}

// For finding single user in DB with username
function find_user_by_username($username) {
  global $db;

  $sql = "SELECT * FROM users ";
  $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $user = mysqli_fetch_assoc($result); // find first
  mysqli_free_result($result);
  return $user; // returns an assoc. array
}

//For user validation before inserting and updating into DB
function validate_admin($admin, $options=[]) {

  $password_required = $options['password_required'] ?? true;

  $errors = [];
  if(is_blank($admin['first_name'])) {
    $errors[] = "First name cannot be blank.";
  } elseif (!has_length($admin['first_name'], array('min' => 2, 'max' => 255))) {
    $errors[] = "First name must be between 2 and 255 characters.";
  }

  if(is_blank($admin['last_name'])) {
    $errors[] = "Last name cannot be blank.";
  } elseif (!has_length($admin['last_name'], array('min' => 2, 'max' => 255))) {
    $errors[] = "Last name must be between 2 and 255 characters.";
  }

  if(is_blank($admin['email'])) {
    $errors[] = "Email cannot be blank.";
  } elseif (!has_length($admin['email'], array('max' => 255))) {
    $errors[] = "Last name must be less than 255 characters.";
  } elseif (!has_valid_email_format($admin['email'])) {
    $errors[] = "Email must be a valid format.";
  } elseif (!has_unique_email($admin['email'], $admin['userID'] ?? 0)) {
    $errors[] = "Email already exists.";
  }

  if(is_blank($admin['username'])) {
    $errors[] = "Username cannot be blank.";
  } elseif (!has_length($admin['username'], array('min' => 2, 'max' => 255))) {
    $errors[] = "Username must be between 8 and 255 characters.";
  } elseif (!has_unique_username($admin['username'], $admin['userID'] ?? 0)) {
    $errors[] = "Username not allowed. Try another.";
  }

  if($password_required) {
    if(is_blank($admin['password'])) {
      $errors[] = "Password cannot be blank.";
    } elseif (!has_length($admin['password'], array('min' => 6))) {
      $errors[] = "Password must contain 6 or more characters";
    } elseif (!preg_match('/[A-Z]/', $admin['password'])) {
      $errors[] = "Password must contain at least 1 uppercase letter";
    } elseif (!preg_match('/[a-z]/', $admin['password'])) {
      $errors[] = "Password must contain at least 1 lowercase letter";
    } elseif (!preg_match('/[0-9]/', $admin['password'])) {
      $errors[] = "Password must contain at least 1 number";
    } elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
      $errors[] = "Password must contain at least 1 symbol";
    }

    if(is_blank($admin['confirm_password'])) {
      $errors[] = "Confirm password cannot be blank.";
    } elseif ($admin['password'] !== $admin['confirm_password']) {
      $errors[] = "Password and confirm password must match.";
    }

    if(is_blank($admin['contact'])) {
      $errors[] = "Contact Number cannot be blank.";
    } elseif (!has_length($admin['contact'], array('min'=>10, 'max' => 15))) {
      $errors[] = "Please enter a valid contact number.";
    } elseif (!preg_match('/\+[0-9]{2}+[0-9]{11}/s', $admin['contact'])) {
      $errors[] = "For contact number, follow this format +49xxxxxxxxxxx.";
    }

  }

  return $errors;
}

// For inserting Users into DB
  function insert_user($user) {
    global $db;

    $errors = validate_admin($user);
    if (!empty($errors)) {
      return $errors;
    }

    $hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);
    

    $sql = "INSERT INTO users ";
    $sql .= "(first_name, last_name, email, username, hashed_password, contact, vkey) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $user['first_name']) . "',";
    $sql .= "'" . db_escape($db, $user['last_name']) . "',";
    $sql .= "'" . db_escape($db, $user['email']) . "',";
    $sql .= "'" . db_escape($db, $user['username']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "',";
    $sql .= "'" . db_escape($db, $user['contact']) . "',";
    $sql .= "'" . db_escape($db, $user['vkey']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

// For updating the Users in DB
function update_user($user) {
  global $db;



  $password_sent = !is_blank($user['password']);

  $errors = validate_admin($user, ['password_required' => $password_sent]);
  if (!empty($errors)) {
    return $errors;
  }

  $hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);

  $sql = "UPDATE users SET ";
  $sql .= "first_name='" . db_escape($db, $user['first_name']) . "', ";
  $sql .= "last_name='" . db_escape($db, $user['last_name']) . "', ";
  $sql .= "email='" . db_escape($db, $user['email']) . "', ";

  if($password_sent) {
    $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "', ";
  }

  $sql .= "contact='" . db_escape($db, $user['contact']) . "', ";
  $sql .= "username='" . db_escape($db, $user['username']) . "' ";
  $sql .= "WHERE userID='" . db_escape($db, $user['userID']) . "' ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db, $sql);

  // For UPDATE statements, $result is true/false
  if($result) {
    return true;
  } else {
    // UPDATE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function insert_proposal($offer) {
  global $db;

  $sql = "INSERT INTO proposals ";
  $sql .= "(userID, OfferID, status, ready) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $offer['userID']) . "',";
  $sql .= "'" . db_escape($db, $offer['OfferID']) . "',";
  $sql .= "'" . db_escape($db, $offer['status']) . "',";
  $sql .= "0";
  $sql .= ")";
  $result = mysqli_query($db, $sql);

  // For INSERT statements, $result is true/false
  if($result) {
    return true;
  } else {
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function find_proposal_by_id($user_id) {
  global $db;

  $sql = "SELECT * FROM proposals ";
  $sql .= "WHERE userID='" . db_escape($db, $user_id) . "' ";
  $sql .= "ORDER BY OfferID ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result; // returns an assoc. array
}

function find_proposal_by_own_id($id) {
  global $db;

  $sql = "SELECT * FROM proposals ";
  $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
  $sql .= "ORDER BY OfferID ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $subject = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $subject; // returns an assoc. array
}


function find_proposal_by_id_userid($id, $user_id) {
  global $db;

  $sql = "SELECT * FROM proposals ";
  $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
  $sql .= "AND userID='" . db_escape($db, $user_id) . "' ";
  $sql .= "ORDER BY OfferID ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $subject = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $subject; // returns an assoc. array
}

function find_proposal_by_offerid_userid($id, $user_id) {
  global $db;

  $sql = "SELECT * FROM proposals ";
  $sql .= "WHERE OfferID='" . db_escape($db, $id) . "' ";
  $sql .= "AND userID='" . db_escape($db, $user_id) . "' ";
  $sql .= "ORDER BY OfferID ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $subject = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $subject; // returns an assoc. array
}


function find_proposal_by_offerid($Offer_id) {
  global $db;

  $sql = "SELECT * FROM proposals ";
  $sql .= "WHERE OfferID='" . db_escape($db, $Offer_id) . "' ";
  $sql .= "ORDER BY OfferID ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $subject = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $subject; // returns an assoc. array
}

function find_proposal_by_status($Offer_id, $status) {
  global $db;
  $sql = "SELECT * FROM proposals ";
  $sql .= "WHERE OfferID='" . db_escape($db, $Offer_id) . "' ";
  $sql .= "AND status='" . db_escape($db, $status) . "' ";
  $sql .= "ORDER BY status ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $subject = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $subject; // returns an assoc. array
}


function find_all_proposals_by_offerid($Offer_id) {
  global $db;

  $sql = "SELECT * FROM proposals ";
  $sql .= "WHERE OfferID='" . db_escape($db, $Offer_id) . "' ";
  $sql .= "ORDER BY OfferID ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result; // returns an assoc. array
}


function count_proposals_by_offerid($Offer_id) {
  global $db;

  $sql = "SELECT COUNT(id) FROM proposals ";
  $sql .= "WHERE OfferID='" . db_escape($db, $Offer_id) . "'";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $row = mysqli_fetch_row($result);
  mysqli_free_result($result);
  $count = $row[0];
  return $count; // returns an assoc. array
}

function count_proposals_by_read() {
  global $db;
  $sql = "SELECT COUNT(id) FROM proposals ";
  $sql .= "WHERE ready= 0";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $row = mysqli_fetch_row($result);
  mysqli_free_result($result);
  $count = $row[0];
  return $count; // returns an assoc. array
}


function find_proposal_by_innerjoin($id) {
  global $db;

  $sql = "SELECT posted_offers.OfferID, posted_offers.userID, posted_offers.price, posted_offers.headline, proposals.status FROM proposals ";
  $sql .= "INNER JOIN posted_offers ";
  $sql .= "ON proposals.OfferID=posted_offers.OfferID ";
  $sql .= "WHERE proposals.userID='" . db_escape($db, $id) . "' ";
  $sql .= "ORDER BY proposals.status ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result; // returns an assoc. array
}

function find_proposal_by_innerjoin_status($id) {
  global $db;

  $sql = "SELECT posted_offers.OfferID, posted_offers.userID, posted_offers.price, posted_offers.headline, proposals.status FROM proposals ";
  $sql .= "INNER JOIN posted_offers ";
  $sql .= "ON proposals.OfferID=posted_offers.OfferID ";
  $sql .= "WHERE proposals.userID='" . db_escape($db, $id) . "' ";
  $sql .= "AND (proposals.status='accept' ";
  $sql .= "OR proposals.status='decline') ";
  $sql .= "ORDER BY OfferID ASC LIMIT 3";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result; // returns an assoc. array
}

function find_offerID_by_innerjoin($id) {
  global $db;

  $sql = "SELECT posted_offers.OfferID FROM proposals ";
  $sql .= "INNER JOIN posted_offers ";
  $sql .= "ON proposals.OfferID=posted_offers.OfferID ";
  $sql .= "WHERE proposals.userID='" . db_escape($db, $id) . "' ";
  $sql .= "ORDER BY OfferID ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result; // returns an assoc. array
}

function find_proposals_by_user_offers($userid) {
  global $db;

  $sql = "SELECT users.userID AS user, posted_offers.userID, posted_offers.OfferID, posted_offers.headline AS headline, proposals.userID AS proposalusers, proposals.OfferID, proposals.status FROM posted_offers ";
  $sql .= "INNER JOIN users ";
  $sql .= "ON users.userID=posted_offers.userID ";
  $sql .= "INNER JOIN proposals ";
  $sql .= "ON proposals.OfferID=posted_offers.OfferID ";
  $sql .= "WHERE users.userID='" . db_escape($db, $userid) . "' ";
  $sql .= "ORDER BY posted_offers.OfferID ASC LIMIT 3";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result; // returns an assoc. array
}

function count_new_proposals_for_user_offers($userid) {
  global $db;

  $sql = "SELECT COUNT(proposals.id) FROM proposals ";
  $sql .= "INNER JOIN posted_offers ";
  $sql .= "ON posted_offers.OfferID=proposals.OfferID ";
  $sql .= "WHERE proposals.ready=0 ";
  $sql .= "AND posted_offers.userID='" . db_escape($db, $userid) . "'";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $row = mysqli_fetch_row($result);
  mysqli_free_result($result);
  $count = $row[0];
  return $count;
}

function count_new_proposals_for_offers($offerid) {
  global $db;

  $sql = "SELECT COUNT(proposals.id) FROM proposals ";
  $sql .= "INNER JOIN posted_offers ";
  $sql .= "ON posted_offers.OfferID=proposals.OfferID ";
  $sql .= "WHERE proposals.ready=0 ";
  $sql .= "AND posted_offers.OfferID='" . db_escape($db, $offerid) . "'";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $row = mysqli_fetch_row($result);
  mysqli_free_result($result);
  $count = $row[0];
  return $count;
}

function update_proposal($offer) {
  global $db;

  $sql = "UPDATE proposals SET ";
  $sql .= "status='" . db_escape($db,$offer['status']) . "', ";
  $sql .= "ready='" . db_escape($db,$offer['ready']) . "' ";
  $sql .= "WHERE id='" . db_escape($db,$offer['id']) . "' ";
  $sql .= "LIMIT 1";

  $result = mysqli_query($db, $sql);
  if($result) { /* For UPDATE statements, $result is true/false*/
    return true;
  } else {
    // UPDATE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }

}


function update_proposal_notifications($userid) {
  global $db;
  $sql = "UPDATE proposals ";
  $sql .= "INNER JOIN posted_offers ";
  $sql .= "ON posted_offers.OfferID=proposals.OfferID ";
  $sql .= "SET proposals.ready= 1 ";
  $sql .= "WHERE proposals.ready=0 ";
  $sql .= "AND posted_offers.userID='" . db_escape($db, $userid) . "'";

  $result = mysqli_query($db, $sql);
  if($result) { /* For UPDATE statements, $result is true/false*/
    return true;
  } else {
    // UPDATE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }

}

function update_proposal_notifications_for_offers($offerid) {
  global $db;
  $sql = "UPDATE proposals ";
  $sql .= "INNER JOIN posted_offers ";
  $sql .= "ON posted_offers.OfferID=proposals.OfferID ";
  $sql .= "SET proposals.ready= 1 ";
  $sql .= "WHERE proposals.ready=0 ";
  $sql .= "AND posted_offers.OfferID='" . db_escape($db, $offerid) . "'";

  $result = mysqli_query($db, $sql);
  if($result) { /* For UPDATE statements, $result is true/false*/
    return true;
  } else {
    // UPDATE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }

}


// For deleting the offers in DB
function delete_proposal($id, $user_id) {
  global $db;

  $sql = "DELETE FROM proposals ";
  $sql .= "WHERE id='" . db_escape($db,$id) . "' ";
  $sql .= "AND userID='" . db_escape($db, $user_id) . "' ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db, $sql);

  if($result) {  /*For DELETE statements, $result is true/false*/
    return true;
  } else {
    // DELETE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

// For finding single user in DB with Email
function find_user_by_email($email) {
  global $db;

  $sql = "SELECT * FROM users ";
  $sql .= "WHERE email='" . db_escape($db, $email) . "' ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $user = mysqli_fetch_assoc($result); // find first
  mysqli_free_result($result);
  return $user; // returns an assoc. array
}




function get_vkey($vkey) {
  global $db;

  $sql = "select vkey FROM users ";
  $sql .= "WHERE vkey='" . db_escape($db,$vkey) . "' ";
  $sql .= "AND verified= 0 ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $row = mysqli_fetch_row($result);
  mysqli_free_result($result);
  $count = $row[0];
  return $count;
}
function set_verified($vkey) {
  global $db;

  $sql = "UPDATE users SET ";
  $sql .= "verified= 1 ";
  $sql .= "WHERE vkey='" . db_escape($db,$vkey) . "' ";
  echo $sql;
  $result = mysqli_query($db, $sql);
  if($result) {  /*For DELETE statements, $result is true/false*/
    return true;
  } else {
    // DELETE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function set_password($user) {
      global $db;

	$hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);
    
    //$hashed_password = $user['password'];
    
    $sql = "UPDATE users SET ";
    $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "' ";
    $sql .= "WHERE email='" . db_escape($db, $user['email']) . "' ";
	  echo $sql;
	  $result = mysqli_query($db, $sql);
	  if($result) {  /*For DELETE statements, $result is true/false*/
              return true;
            } else {
            // DELETE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
            }
	 }

?>
