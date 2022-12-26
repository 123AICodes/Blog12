<?php
#including header file
include_once './partials/header.php';

#getting single post on click
if (isset($_GET['id'])) {
  $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = " SELECT * FROM post WHERE id=$post_id ";
  $results = mysqli_query($connection, $query);
  $posts = mysqli_fetch_assoc($results);
} else {
  header('location: ' . ROOT_URL . '/index.php');
  die();
}


?>


<!--
    single post
  -->
<section class="singlepost">
  <div class="container singlepost__container">
    <h2><?= $posts['title'] ?></h2>
    <div class="post__author">
      <?php
      #fetch user avatar
      $user_id = $posts['author_id'];
      $query = mysqli_query($connection, " SELECT * FROM users WHERE id LIKE {$user_id}");
      $user = mysqli_fetch_assoc($query);
      ?>
      <div class="post__author-avatar"><img src="./image/<?= $user['avatar'] ?>"></div>
      <div class="post__author-info">
        <h5>By: <?= $user['firstname'] . " " . $user['lastname'] ?></h5>
        <small><?= date("M d y - H:i", strtotime($posts['date_time'])) ?></small>
      </div>
    </div>
    <div class="singlepost__thumbnail"><img src="./image/<?= $posts['thumbnail'] ?>"></div>
    <p><?= $posts['body'] ?></p>
  </div>
</section>


<?php
#including footer file
include_once './partials/footer.php';
?>