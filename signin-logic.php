<?php
require_once 'config/database.php';

if (isset($_POST['signin'])) {

  #varibales
  $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  #validation
  if (empty($username_email)) {
    $_SESSION['signin'] = "enter username or email!";
  } elseif (empty($password)) {
    $_SESSION['signin'] = "password is required!";
  } else {
    #checking if user exist
    $check_query = " SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
    $check_query_results = mysqli_query($connection, $check_query);
    if (mysqli_num_rows($check_query_results) == 1) {
      #converting record into an assoc array if user is found
      $user_record = mysqli_fetch_assoc($check_query_results);
      $db_password = $user_record['password'];
      #comparing password
      if (password_verify($password, $db_password)) {
        $_SESSION['user_id'] = $user_record['id'];
        #set session if user is an admin
        if ($user_record['is_admin'] == 1) {
          $_SESSION['user_is_admin'] = true;
          header('location: ' . ROOT_URL . 'admin/');
        } else {
          header('location: ' . ROOT_URL . 'index.php');
        }
      } else {
        $_SESSION['signin'] = "password is incorrect!";
      }
    } else {
      $_SESSION['signin'] = "user not found";
    }
  }
  #checking if there's was a problem
  if (isset($_SESSION['signin'])) {
    $_SESSION['signin-data'] = $_POST;
    header('location: signin.php');
    die();
  }
} else {
  header('location: signin.php');
  die();
}
