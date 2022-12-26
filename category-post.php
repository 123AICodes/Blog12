<?php
#including header file
include_once './partials/header.php';

#fetching related posts 
if (isset($_GET['id'])) {
  $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = " SELECT * FROM post WHERE category_id=$post_id ORDER BY date_time DESC";
  $posts = mysqli_query($connection, $query);
} else {
  header('location: ' . ROOT_URL . '/blog.php');
  die();
}

?>

<!--
    category title
  -->
<header class="category__title">
  <?php
  $category_id = $post_id;
  $category_query = " SELECT * FROM category WHERE id LIKE {$post_id} ";
  $results = mysqli_query($connection, $category_query);
  $categories = mysqli_fetch_assoc($results);
  echo '<h2>' . $categories['title'] . '</h2>';
  ?>
</header>



<!--
    posts
  -->
<?php if (mysqli_num_rows($posts) > 0) : ?>
  <section class="posts">
    <div class="container posts__container">
      <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
        <article class="post">
          <div class="post__thumbnail"><img src="./image/<?= $post['thumbnail'] ?>"></div>
          <div class="post__info">
            <a href="<?= ROOT_URL ?>category-post.php?id=<?= $categories['id'] ?>" class="category__button"><?= $categories['title'] ?></a>
            <h3 class="post__title">
              <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, atque.</a>
            </h3>
            <p class="post__body"><?= substr($post['body'], 0, 150) ?>...</p>
            <div class="post__author">
              <?php
              $user_id = $post['author_id'];
              $user_query = " SELECT * FROM users WHERE id LIKE {$user_id} ";
              $results = mysqli_query($connection, $user_query);
              $users = mysqli_fetch_assoc($results);
              ?>
              <div class="post__author-avatar"><img src="./image/<?= $users['avatar'] ?>"></div>
              <div class="post__author-info">
                <h5>By: <?= $users['firstname'] . " " . $users['lastname'] ?></h5>
                <small><?= date('M d y - H:i', strtotime($post['date_time'])) ?></small>
              </div>
            </div>
          </div>
        </article>
      <?php endwhile ?>
      <?php if (mysqli_num_rows($posts) > 6) : ?>
        <button class="load__more-btn">load more</button>
      <?php endif ?>
    </div>
  </section>
<?php else : ?>
  <div class="alert__message error lg">
    <p><?= "No post related to this category!"  ?></p>
  </div>
<?php endif ?>

<!--
    category button
  -->
<section class="category__buttons">
  <div class="container category__btns-container">
    <?php
    #fetching categories
    $query = " SELECT * FROM category ";
    $all_categories = mysqli_query($connection, $query);
    ?>
    <?php while ($category = mysqli_fetch_assoc($all_categories)) : ?>
      <a href="<?= ROOT_URL ?>/category-post.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
    <?php endwhile ?>
  </div>
</section>


<?php
#including footer file
include_once './partials/footer.php';
?>