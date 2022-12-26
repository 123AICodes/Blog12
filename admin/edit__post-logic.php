<?php
require_once './config/database.php';

#checking if button is clicked
if (isset($_POST['updatePost'])) {
  #variables
  $post_id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
  $prev_thumbnail = filter_var($_POST['prev_thumbnail'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
  $is_featured = filter_var($_POST['isFeatured'], FILTER_SANITIZE_NUMBER_INT);
  $thumbnail = $_FILES['thumbnail'];

  #set is_featured to 0 if unchecked
  $is_featured = $is_featured == 1 ?: 0;

  #validations
  if (empty($title)) {
    $_SESSION['updatePost'] = "failed! post title was empty!";
  } elseif (empty($category_id)) {
    $_SESSION['updatePost'] = "failed. category was empty!";
  } elseif (empty($body)) {
    $_SESSION['updatePost'] = "failed! there was no post body!";
  } else {
    #deleting previous thumbnail
    if ($thumbnail['name']) {
      $prev_thumbnail_path = '../image/' . $prev_thumbnail;
      if ($prev_thumbnail_path) {
        unlink($prev_thumbnail_path);
      }

      #working on image
      $time = time();
      $thumbnail_name = $time . $thumbnail['name'];
      $thumbnail_tmp_name = $thumbnail['tmp_name'];
      $thumbnail_destination_path = '../image/' . $thumbnail_name;

      $allowed_file_ext = ['jpg', 'jpeg', 'png'];
      $extension = explode('.', $thumbnail_name);
      $extension = end($extension);

      if (in_array($extension, $allowed_file_ext)) {
        #checking file size
        if ($thumbnail['size'] > 1000000) {
          $_SESSION['updatePost'] = "file size is big. maximum is 1MB";
          header('location: ' . ROOT_URL . '/admin/index.php');
          die();
        } else {
          move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
        }
      } else {
        $_SESSION['updatePost'] = "file extension is not supported.";
        header('location: ' . ROOT_URL . '/admin/index.php');
        die();
      }
    }
  }
  if (isset($_SESSION['updatePost'])) {
    #redirecting back
    header('location: ' . ROOT_URL . 'admin/edit-post.php');
    die();
  } else {
    #set is_featured for all post to 0 if this post is_featured
    if ($is_featured == 1) {
      $update = mysqli_query($connection, " UPDATE post SET is_featured = 0 ");
    }
    #update previous thumbnail else keep
    $insert_thumbnail = $thumbnail_name ?? $prev_thumbnail;

    #updating post
    $query = " UPDATE post SET title='$title', body='$body', thumbnail='$insert_thumbnail', category_id='$category_id', is_featured='$is_featured' WHERE id LIKE {$post_id} LIMIT 1 ";
    $results = mysqli_query($connection, $query);

    #checking if thers was connection error
    if (mysqli_errno($connection)) {
      $_SESSION['updatePost'] = "oops! something  went wrong! Try again!";
      header('location: ' . ROOT_URL . '/admin/index.php');
      die();
    } else {
      $_SESSION['updatePost-success'] = "your post is successfully updated!";
      header('location: ' . ROOT_URL . '/admin/index.php');
      die();
    }
  }
} else {
  header('location: ' . ROOT_URL . '/admin/index.php');
  die();
}
