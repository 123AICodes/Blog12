<?php
require_once './config/database.php';

#checking if button is clicked
if (isset($_POST['addCategory'])) {

  #variables
  $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  #validations
  if (empty($title)) {
    $_SESSION['addCategory'] = "provide category title!";
  } elseif (empty($description)) {
    $_SESSION['addCategory'] = "give a description!";
  }
  if (isset($_SESSION['addCategory'])) {
    $_SESSION['addCategory-data'] = $_POST;
    header('location: ' . ROOT_URL . '/admin/add-category.php ');
    die();
  } else {
    #inserting category
    $query = mysqli_query($connection, " INSERT INTO category(title,description)VALUES('{$title}','{$description}') ");
    if (mysqli_errno($connection)) {
      $_SESSION['addCategory-success'] = "sorry! something went wrong!";
      header('location: ' . ROOT_URL . '/admin/manage-category.php ');
      die();
    } else {
      $_SESSION['addCategory-success'] = "new category of $title added successfully!";
      header('location: ' . ROOT_URL . '/admin/manage-category.php ');
      die();
    }
  }
} else {
  header('location: ' . ROOT_URL . '/admin/manage-category.php ');
  die();
}
