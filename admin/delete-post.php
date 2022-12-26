<?php
require_once 'config/database.php';

#checking if updateUser button is clicked
if (isset($_GET['id'])) {

  #variables
  $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

  $query = mysqli_query($connection, " SELECT * FROM post WHERE id LIKE {$post_id} ");
  if (mysqli_num_rows($query) > 0) {
    $post = mysqli_fetch_assoc($query);
    $thumbnail_name = $post['thumbnail'];
    $thumbnail_path = '../post__thumbnails/' . $thumbnail_name;

    #delete post thumbnail if it exist in the dir
    if ($thumbnail_path) {
      unlink($thumbnail_path);
    }
  }

  #deleting post
  $delete_post = mysqli_query($connection, " DELETE FROM post WHERE id={$post_id} LIMIT 1");
  if (mysqli_errno($connection)) {
    $_SESSION['deletePost'] = "failed to delete post!";
    header('location: ' . ROOT_URL . '/admin/index.php ');
    die();
  } else {
    $_SESSION['deletePost-success'] = "post deleted successfully!";
    header('location: ' . ROOT_URL . '/admin/index.php ');
    die();
  }
} else {
  header('location: ' . ROOT_URL . '/admin/index.php ');
  die();
}
