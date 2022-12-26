<?php
require_once './partials/header.php';

#checking user input
if (isset($_GET['search']) && isset($_GET['searchBtn'])) {
  $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $query = " SELECT * FROM post WHERE title LIKE '%$search%' ORDER BY date_time DESC";
  $posts = mysqli_query($connection, $query);
} else {
  header('location: ' . ROOT_URL . '/blog.php');
  die();
}
?>

<!--
    posts
  -->

<?php if (mysqli_num_rows($posts) > 0) : ?>
  <section class="posts section__extra-margin">
    <div class="container posts__container">
      <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
        <article class="post">
          <div class="post__thumbnail"><img src="./image/<?= $post['thumbnail'] ?>"></div>
          <div class="post__info">
            <?php
            #fetch category name
            $category_id = $post['category_id'];
            $query = mysqli_query($connection, " SELECT title FROM category WHERE id LIKE {$category_id}");
            $category = mysqli_fetch_assoc($query);
            ?>
            <a href="<?= ROOT_URL ?>category-post.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
            <h3 class="post__title">
              <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
            </h3>
            <p class="post__body"><?= substr($post['body'], 0, 150) ?>...</p>
            <div class="post__author">
              <?php
              #fetch user avatar
              $user_id = $post['author_id'];
              $query = mysqli_query($connection, " SELECT * FROM users WHERE id LIKE {$user_id}");
              $user = mysqli_fetch_assoc($query);
              ?>
              <div class="post__author-avatar"><img src="./image/<?= $user['avatar'] ?>"></div>
              <div class="post__author-info">
                <h5>By: <?= $user['firstname'] . " " . $user['lastname'] ?></h5>
                <small><?= date("M d y - H:i", strtotime($post['date_time'])) ?></small>
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
  <div class="alert__message error lg section__extra-margin">
    <p><?= "No post found!"  ?></p>
  </div>
<?php endif ?>
<br>


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