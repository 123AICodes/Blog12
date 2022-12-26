<?php
#including header file
include_once './partials/header.php';


#fetching categories
$query = " SELECT * FROM category ORDER BY title ";
$categories = mysqli_query($connection, $query);

#fetching post
if (isset($_GET['id'])) {
  $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = " SELECT * FROM post WHERE id LIKE {$post_id} ";
  $results = mysqli_query($connection, $query);
  $post = mysqli_fetch_assoc($results);
} else {
  header('location: ' . ROOT_URL . '/admin/index.php');
  die();
}

?>
<br><br>
<!--
  form
 -->

<section class="form__section">
  <div class="container form__section-container">
    <h2>edit post</h2>
    <form autocomplete="off" enctype="multipart/form-data" action="<?= ROOT_URL ?>admin/edit__post-logic.php" method="POST">
      <input type="text" name="id" value="<?= $post['id'] ?>" hidden>
      <input type="text" name="prev_thumbnail" value="<?= $post['thumbnail'] ?>" hidden>
      <input type="text" name="title" placeholder="title" value="<?= $post['title'] ?>">
      <select name="category">
        <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
          <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
        <?php endwhile ?>
      </select>
      <textarea rows="7" placeholder="description" name="body"><?= $post['body'] ?></textarea>
      <?php if (isset($_SESSION['user_is_admin'])) : ?>
        <div class="form__control inline">
          <input name="isFeatured" value="1" type="checkbox" id="is_featured" checked>
          <label for="is_featured">featured</label>
        </div>
      <?php endif ?>
      <div class="form__control">
        <label for="image">change thumbnail</label>
        <input type="file" id="image" name="thumbnail">
      </div>
      <button type="submit" class="btn" name="updatePost">update post</button>
    </form>
  </div>
</section>


<br><br>





<?php
#including footer file
include_once './partials/footer.php';
?>