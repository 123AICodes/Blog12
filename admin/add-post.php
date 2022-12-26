<?php
#including header
include_once './partials/header.php';


#fetching categories
$query = " SELECT * FROM category ORDER BY title ";
$categories = mysqli_query($connection, $query);

#preveting data loose
$title = $_SESSION['addPost-data']['title'] ?? null;
$body = $_SESSION['addPost-data']['body'] ?? null;
?>


<br><br>
<!--
  form
 -->

<section class="form__section">
  <div class="container form__section-container">
    <h2>add post</h2>
    <?php if (isset($_SESSION['addPost'])) : ?>
      <div class="alert__message error">
        <p>
          <?php
          echo $_SESSION['addPost'];
          unset($_SESSION['addPost']);
          ?>
        </p>
      </div>
    <?php endif ?>
    <form action="<?= ROOT_URL ?>admin/add__post-logic.php" autocomplete="off" enctype="multipart/form-data" method="POST">
      <input name="title" type="text" placeholder="title" value="<?= $title ?>">
      <select name="category">
        <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
          <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
        <?php endwhile ?>
      </select>
      <textarea name="body" rows="7" placeholder="description"><?= $body ?></textarea>
      <?php if (isset($_SESSION['user_is_admin'])) : ?>
        <div class="form__control inline">
          <input name="isFeatured" value="1" type="checkbox" id="is_featured" checked>
          <label for="is_featured">featured</label>
        </div>
      <?php endif ?>
      <div class="form__control">
        <label for="image">upload thumbnail</label>
        <input type="file" id="image" name="thumbnail">
      </div>
      <button type="submit" class="btn" name="addPost">new post</button>
    </form>
  </div>
</section>


<br><br>



<?php
#including footer file
include_once './partials/footer.php';
?>