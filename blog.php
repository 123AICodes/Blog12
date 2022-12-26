<?php
#including header file
include_once './partials/header.php';

#fetching post
$post_query = " SELECT * FROM post ORDER BY date_time DESC";
$posts = mysqli_query($connection, $post_query);

?>


<!--
    search
  -->
<section class="search__bar">
  <form action="<?= ROOT_URL ?>search.php" autocomplete="off" class="container search__bar-container" method="GET">
    <div>
      <button class="search__icon"><i class="fas fa-search"></i></button>
      <input type="search" name="search" placeholder="search here...">
    </div>
    <button type="submit" name="searchBtn" class="btn">go</button>
  </form>
</section>

<!--
    posts
  -->
<section class="posts">
  <div class="container posts__container">

    <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
      <article class="post">
        <div class="post__thumbnail"><img src="./image/<?= $post['thumbnail'] ?>"></div>
        <div class="post__info">
          <?php
          $category_id = $post['category_id'];
          $query = " SELECT * FROM category WHERE id LIKE {$category_id}";
          $results = mysqli_query($connection, $query);
          $categories = mysqli_fetch_assoc($results);
          ?>
          <a href="<?= ROOT_URL ?>category-post.php?id=<?= $categories['id'] ?>" class="category__button"><?= $categories['title'] ?></a>
          <h3 class="post__title">
            <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
          </h3>
          <p class="post__body"><?= substr($post['body'], 0, 150) ?></p>
          <div class="post__author">
            <?php
            $user_id = $post['author_id'];
            $query = " SELECT * FROM users WHERE id LIKE {$user_id} ";
            $results = mysqli_query($connection, $query);
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