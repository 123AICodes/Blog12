<?php
require_once './config/database.php';

#checking if button is clicked
if (isset($_GET['id'])) {

  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

  /*
  ***setting deleted category to be uncategorized
  */
  $update_query = mysqli_query($connection, " UPDATE post SET category_id=7 WHERE category_id=$id");
  #checking connection if there was an error
  if (mysqli_errno($connection)) {
    #deleting
    $query = mysqli_query($connection, " DELETE FROM category WHERE id LIKE {$id} LIMIT 1 ");
    $_SESSION['deleteCat'] = "sorry! couldn't delete category!";
    header('location:' . ROOT_URL . 'admin/manage-category.php');
    die();
  } else {
    $_SESSION['deleteCat-success'] = "category deleted successfully!";
    header('location:' . ROOT_URL . 'admin/manage-category.php');
    die();
  }
} else {
  header('location: ' . ROOT_URL . 'admin/manage-category.php');
  die();
}
