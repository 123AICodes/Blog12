<?php
require_once './config/database.php';

#checking if button is clicked
if (isset($_POST['updateCategory'])) {

  #variables
  $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
  $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  #validation
  if (empty($title)) {
    $_SESSION['updateCat'] = "failed. provide category title!";
    header('location:' . ROOT_URL . '/admin/manage-category.php');
  } elseif (empty($description)) {
    $_SESSION['updateCat'] = "failed. category description is blank!";
    header('location:' . ROOT_URL . '/admin/manage-category.php');
  } else {
    #updating category
    $query = mysqli_query($connection, " UPDATE category SET title='{$title}', description='{$description}' WHERE id LIKE {$id} LIMIT 1 ");

    #checking if there's was connection error
    if (mysqli_errno($connection)) {
      $_SESSION['updateCat'] = "failed to update category! Try Again!!";
    } else {
      $_SESSION['updateCat-success'] = "category updated succesfully!";
      header('location:' . ROOT_URL . '/admin/manage-category.php');
    }
  }
} else {
  header('location:' . ROOT_URL . 'admin/edit-category.php');
  die();
}
