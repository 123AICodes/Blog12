<?php
require_once 'config/database.php';

#checking if updateUser button is clicked
if (isset($_GET['id'])) {

  #variables
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

  $query = mysqli_query($connection, " SELECT * FROM users WHERE id LIKE {$id} ");
  $user = mysqli_fetch_assoc($query);
  if (mysqli_num_rows($query) > 0) {
    $avatar_name = $user['avatar'];
    $avatar_path = '../image/' . $avatar_name;

    #delete user image if it exist in the dir
    if ($avatar_path) {
      unlink($avatar_path);
    }
  }
  /*
  ***LATER DELETE ALL THUMBNAILS THAT BELONGS TO THE USER***
  */
  $thumbnails_query = " SELECT thumbnail FROM post WHERE author_id={$id} ";
  $results = mysqli_query($connection, $thumbnails_query);
  if (mysqli_num_rows($results) > 0) {
    while ($thumbnail = mysqli_fetch_assoc($results)) {
      $thumbnail_path = '../image/' . $thumbnail['name'];
      #deleting thumbnail
      if ($thumbnail_path) {
        unlink($thumbnail_path);
      }
    }
  }

  #deleting user
  $delete_user = mysqli_query($connection, " DELETE FROM users WHERE id={$id} LIMIT 1");
  if (mysqli_errno($connection)) {
    $_SESSION['delete_user'] = "failed to delete user!";
    header('location: ' . ROOT_URL . '/admin/manage-user.php ');
    die();
  } else {
    $_SESSION['delete_user-success'] = "user deleted successfully!";
    header('location: ' . ROOT_URL . '/admin/manage-user.php ');
    die();
  }
} else {
  header('location: ' . ROOT_URL . '/admin/index.php ');
  die();
}
