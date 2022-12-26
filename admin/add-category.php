<?php
#including header file
include_once './partials/header.php';

#preventing data lose in input fields
$title = $_SESSION['addCategory-data']['title'] ?? null;
$description = $_SESSION['addCategory-data']['description'] ?? null;
unset($_SESSION['addCategory-data']);


?>
<!--
  form
 -->
<section class="form__section">
  <div class="container form__section-container">
    <h2>add new category</h2>
    <?php if (isset($_SESSION['addCategory'])) : ?>
      <div class="alert__message error">
        <p>
          <?php
          echo $_SESSION['addCategory'];
          unset($_SESSION['addCategory']);
          ?>
        </p>
      </div>
    <?php endif ?>
    <form autocomplete="off" action="<?= ROOT_URL ?>/admin/add-category-logic.php" method="POST">
      <input type="text" value="<?= $title ?>" name="title" placeholder="title">
      <textarea rows="4" name="description" placeholder="description"></textarea>
      <button type="submit" class="btn" name="addCategory">add category</button>
    </form>
  </div>
</section>




<?php
#including footer file
include_once './partials/footer.php';
?>