<?php

/**requiring database config */
require_once './config/database.php';

/**
 * **getting adduser data when button is clicked
 * */
if (isset($_POST['adduser'])) {

  #variables
  $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $cpassword = filter_var($_POST['cpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $is_admin = filter_var($_POST['is-admin'], FILTER_SANITIZE_NUMBER_INT);
  $avatar = $_FILES['avatar'];

  #validations
  if (empty($firstname)) {
    $_SESSION['adduser'] = "enter firstname!";
  } elseif (empty($lastname)) {
    $_SESSION['adduser'] = "enter lastname!";
  } elseif (empty($username)) {
    $_SESSION['adduser'] = "enter username!";
  } elseif (empty($email)) {
    $_SESSION['adduser'] = "enter a valid email!";
  } elseif (empty($password)) {
    $_SESSION['adduser'] = "enter password!";
  } elseif (empty($cpassword)) {
    $_SESSION['adduser'] = "confirm your password!";
  } elseif (empty($avatar['name'])) {
    $_SESSION['adduser'] = "choose a profile picture!";
  } else {

    #validating password
    if ($password !== $cpassword) {
      $_SESSION['adduser'] = "sorry! confirm password don't match!";
    } else {
      #hashing password
      $hash_password = password_hash($password, PASSWORD_DEFAULT);

      #validating if username & email exist
      $check_query = " SELECT * FROM users WHERE username ='$username' OR email='$email' ";
      $check_result = mysqli_query($connection, $check_query);

      if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['adduser'] = "sorry! username or email is taken!";
      } else {

        #working on image
        $time = time();
        $avatar_name = $time . $avatar['name'];
        $avatar_tmp_name = $avatar['tmp_name'];
        $avatar_destination_path = '../image/' . $avatar_name;

        $allowed_files = ["jpg", "png", "jpeg"];
        $extension = explode('.', $avatar_name);
        $extension = end($extension);

        if (in_array($extension, $allowed_files)) {

          if ($avatar['size'] < 1000000) {
            #insert image
            move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
          } else {
            $_SESSION['adduser'] = "file is too big!";
          }
        } else {
          $_SESSION['adduser'] = "file is unsopported. valid extensions jpeg, png, jpg";
        }
      }
    }
  }
  #redirecting back if there`s an error
  if (isset($_SESSION['adduser'])) {
    $_SESSION['adduser-data'] = $_POST;
    header('location: ' . ROOT_URL . '/admin/add-user.php');
    die();
  } else {
    #inserting user data
    $insert_user_query = "INSERT INTO users  (firstname, lastname, username, email, password, avatar, is_admin)
                              VALUES('$firstname', '$lastname', '$username', '$email', '$hash_password', '$avatar_name', '$is_admin')";
    $insert_user = mysqli_query($connection, $insert_user_query);
    if (!mysqli_errno($connection)) {
      $_SESSION['adduser-success'] = "user added successfully";
      header('location: ' . ROOT_URL . '/admin/manage-user.php');
    }
  }
} else {
  header('location: ' . ROOT_URL . '/admin/add-user.php');
  die();
}
