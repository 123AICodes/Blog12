<?php
require_once './config/database.php';

#checking if button is clicked
if (isset($_POST['addPost'])) {
  $author_id = $_SESSION['user_id']; #getting user id

  #variables
  $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
  $is_featured = filter_var($_POST['isFeatured'], FILTER_SANITIZE_NUMBER_INT);
  $thumbnail = $_FILES['thumbnail'];

  #set is_featured to 0 if unchecked
  $is_featured = $is_featured == 1 ?: 0;

  #validations
  if (empty($title)) {
    $_SESSION['addPost'] = "enter post title!";
  } elseif (empty($category_id)) {
    $_SESSION['addPost'] = "please select category!";
  } elseif (empty($body)) {
    $_SESSION['addPost'] = "provide description of this post!";
  } elseif (empty($thumbnail['name'])) {
    $_SESSION['addPost'] = "provide a thumbnail for this post!";
  } else {

    #working on image
    $time = time();
    $thumbnail_name = $time . $thumbnail['name'];
    $thumbnail_tmp_name = $thumbnail['tmp_name'];
    $thumbnail_destination_path = '../image/' . $thumbnail_name;

    $allowed__file_ext = ['jpg', 'jpeg', 'png'];
    $extension = explode('.', $thumbnail_name);
    $extension = end($extension);

    #validating image
    if (in_array($extension, $allowed__file_ext)) {
      #checking the size of thumbnail
      if ($thumbnail['size'] > 1000000) {
        $_SESSION['addPost'] = "file size is too big. Maximum size is 1MB!";
        header('location: ' . ROOT_URL . '/admin/add-post.php');
        die();
      } else {
        move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
      }
    } else {
      $_SESSION['addPost'] = "unsupported file extension!";
      header('location: ' . ROOT_URL . '/admin/add-post.php');
      die();
    }
  }
  #redirecting back to add post page if there was an error
  if (isset($_SESSION['addPost'])) {
    $_SESSION['addPost-data'] = $_POST;
    header('location: ' . ROOT_URL . '/admin/add-post.php');
    die();
  } else {
    #set is_featured for all post to 0 if this post is_featured
    if ($is_featured == 1) {
      $update = mysqli_query($connection, " UPDATE post SET is_featured = 0 ");
    }
    #inserting post
    $query = " INSERT INTO `post`(`title`, `body`, `thumbnail`, `date_time`, `category_id`, `author_id`, `is_featured`) 
              VALUES ('$title','$body','$thumbnail_name', default,'$category_id','$author_id','$is_featured')";
    $results = mysqli_query($connection, $query);

    #checking connection error
    if (mysqli_errno($connection)) {
      $_SESSION['addPost'] = "oops!! failed to upload this post! Try again!";
      header('location: ' . ROOT_URL . ' admin/add-post.php');
      die();
    } else {
      $_SESSION['addPost-success'] = "new post added successfully!";
      header('location: ' . ROOT_URL . '/admin/index.php');
      die();
    }
  }
} else {
  header('location: ' . ROOT_URL . '/admin/add-post.php');
  die();
}
