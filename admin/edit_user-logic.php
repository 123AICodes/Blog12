<?php
require_once 'config/database.php';

#checking if updateUser button is clicked
if (isset($_POST['updateUser'])) {

  #variables
  $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
  $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $is_admin = filter_var($_POST['is_admin'], FILTER_SANITIZE_NUMBER_INT);

  #validations
  if (empty($firstname)) {
    $_SESSION['editUser'] = "failed. firstname was empty!";
    header('location: ' . ROOT_URL . '/admin/manage-user.php ');
  } elseif (empty($lastname)) {
    $_SESSION['editUser'] = "failed. lastname was empty!";
    header('location: ' . ROOT_URL . '/admin/manage-user.php ');
  } else {
    #updating user
    $query = mysqli_query($connection, " UPDATE users SET firstname='{$firstname}', lastname='{$lastname}', is_admin={$is_admin} WHERE id LIKE {$id} LIMIT 1 ");
    if (mysqli_errno($connection)) {
      $_SESSION['editUser'] = "failed to update user!";
    } else {
      $_SESSION['editUser-success'] = "user updated successfully";
      header('location: ' . ROOT_URL . '/admin/manage-user.php ');
    }
  }
} else {
  header('location: ' . ROOT_URL . '/admin/index.php ');
  die();
}
