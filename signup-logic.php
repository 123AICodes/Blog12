<?php

/**requiring database config */
require_once './config/database.php';

/**
 * **getting signup data when button is clicked
 * */
if (isset($_POST['signup'])) {

  #variables
  $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $cpassword = filter_var($_POST['cpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $avatar = $_FILES['avatar'];

  #validations
  if (empty($firstname)) {
    $_SESSION['signup'] = "enter firstname!";
  } elseif (empty($lastname)) {
    $_SESSION['signup'] = "enter lastname!";
  } elseif (empty($username)) {
    $_SESSION['signup'] = "enter username!";
  } elseif (empty($email)) {
    $_SESSION['signup'] = "enter a valid email!";
  } elseif (empty($password)) {
    $_SESSION['signup'] = "enter password!";
  } elseif (empty($cpassword)) {
    $_SESSION['signup'] = "confirm your password!";
  } elseif (empty($avatar['name'])) {
    $_SESSION['signup'] = "choose a profile picture!";
  } else {

    #validating password
    if ($password !== $cpassword) {
      $_SESSION['signup'] = "sorry! confirm password don't match!";
    } else {
      #hashing password
      $hash_password = password_hash($password, PASSWORD_DEFAULT);

      #validating if username & email exist
      $check_query = "SELECT * FROM users WHERE username ='$username' OR email='$email' ";
      $check_result = mysqli_query($connection, $check_query);

      if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['signup'] = "sorry! username or email is taken!";
      } else {

        #working on image
        $time = time();
        $avatar_name = $time . $avatar['name'];
        $avatar_tmp_name = $avatar['tmp_name'];
        $avatar_destination_path = 'image/' . $avatar_name;

        $allowed_files = ["jpg", "png", "jpeg"];
        $extension = explode('.', $avatar_name);
        $extension = end($extension);

        if (in_array($extension, $allowed_files)) {

          if ($avatar['size'] < 1000000) {
            #insert image
            move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
          } else {
            $_SESSION['signup'] = "file is too big!";
          }
        } else {
          $_SESSION['signup'] = "file is unsopported - jpeg, png, jpg!";
        }
      }
    }
  }
  #redirecting back if there`s an error
  if (isset($_SESSION['signup'])) {
    $_SESSION['signup-data'] = $_POST;
    header('location: ' . ROOT_URL . 'signup.php');
    die();
  } else {
    #inserting user data
    $insert_user_query = "INSERT INTO `users` (firstname, lastname, username, email, password, avatar)
                              VALUES('$firstname', '$lastname', '$username', '$email', '$hash_password', '$avatar_name')";
    $insert_user = mysqli_query($connection, $insert_user_query);
    if (!mysqli_errno($connection)) {
      $_SESSION['signup-success'] = "Registration Successfull";
      header('location: ' . ROOT_URL . 'signin.php');
    }
  }
} else {
  header('location: ' . ROOT_URL . 'signup.php');
  die();
}
