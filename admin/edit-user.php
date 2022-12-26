<?php
#including header file
include_once './partials/header.php';

#fetching user using the user id
if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = " SELECT * FROM users WHERE id=$id";
  $results = mysqli_query($connection, $query);
  $user = mysqli_fetch_assoc($results);
} else {
  header('location: ' . ROOT_URL . '/admin/manage-user.php ');
  die();
}

?>
<!--
  form
 --><br><br>

<section class="form__section">
  <div class="container form__section-container">
    <h2>edit user</h2>
    <form action="<?= ROOT_URL ?>/admin/edit_user-logic.php" method="POST" autocomplete="off">
      <input type="text" name="id" value="<?php echo $user['id'] ?>" hidden>
      <input type="text" name="firstname" value="<?php echo $user['firstname'] ?>" placeholder="first name">
      <input type="text" name="lastname" value="<?php echo $user['lastname'] ?>" placeholder="last name">
      <select name="is_admin">
        <option value="0">author</option>
        <option value="1">admin</option>
      </select>

      <button type="submit" class="btn" name="updateUser">update user</button>
    </form>
  </div>
</section>




<br><br>


<?php
#including footer file
include_once './partials/footer.php';
?>