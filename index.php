<?php
#including header file
include_once './partials/header.php';

#fetching featured post
$featured_query = mysqli_query($connection, " SELECT * FROM post WHERE is_featured=1");
$featured = mysqli_fetch_assoc($featured_query);

#fetching posts
$query = " SELECT * FROM post ORDER BY date_time DESC LIMIT 9 ";
$posts = mysqli_query($connection, $query);
?>
<!--
    featured post
  -->
<?php if (mysqli_num_rows($featured_query) > 0) : ?>
  <section class="featured">
    <div class="container featured__container">
      <div class="post__thumbnail"><img src="./image/<?= $featured['thumbnail'] ?>"></div>
      <div class="post__info">
        <?php
        #fetch category name
        $category_id = $featured['category_id'];
        $query = mysqli_query($connection, " SELECT title FROM category WHERE id LIKE {$category_id}");
        $category = mysqli_fetch_assoc($query);
        ?>
        <a href="<?= ROOT_URL ?>category-post.php?id=<?= $featured['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
        <h2 class="post__title">
          <a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a>
        </h2>
        <p class="post__body"><?= substr($featured['body'], 0, 250) ?>...</p>
        <div class="post__author">
          <?php
          #fetch user avatar
          $user_id = $featured['author_id'];
          $query = mysqli_query($connection, " SELECT * FROM users WHERE id LIKE {$user_id}");
          $user = mysqli_fetch_assoc($query);
          ?>
          <div class="post__author-avatar"><img src="./image/<?= $user['avatar'] ?>"></div>
          <div class="post__author-info">
            <h5>By: <?= $user['firstname'] . " " . $user['lastname'] ?></h5>
            <small><?= date("M d y - H:i", strtotime($featured['date_time'])) ?></small>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif ?>

<!--
    posts
  -->
<section class="posts <?= $featured ? '' : 'section__extra-margin' ?>">
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