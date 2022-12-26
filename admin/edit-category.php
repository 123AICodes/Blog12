<?php
#including header file
include_once './partials/header.php';

#fecthing category using cat ID
if (isset($_GET['id'])) {

  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = " SELECT * FROM category WHERE id={$id} ";
  $results = mysqli_query($connection, $query);
  $category = mysqli_fetch_assoc($results);
} else {
  header('location: ' . ROOT_URL . 'admin/manage-category.php');
  die();
}


?>
<!--
  form
 -->

<section class="form__section">
  <div class="container form__section-container">
    <h2>edit category</h2>
    <form action="<?= ROOT_URL ?>admin/edit_category-logic.php" autocomplete="off" method="POST">
      <input type="text" name="id" value="<?= $category['id'] ?>" placeholder="title" hidden>
      <input type="text" name="title" value="<?= $category['title'] ?>" placeholder="title">
      <textarea rows="4" name="description" placeholder="description"><?= $category['description'] ?></textarea>
      <button type="submit" class="btn" name="updateCategory">update category</button>
    </form>
  </div>
</section>






<?php
#including footer file
include_once './partials/footer.php';
?>