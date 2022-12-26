<?php
#including header file
include_once './partials/header.php';

$firstname = $_SESSION['adduser-data']['firstname'] ?? null;
$lastname = $_SESSION['adduser-data']['lastname'] ?? null;
$username = $_SESSION['adduser-data']['username'] ?? null;
$email = $_SESSION['adduser-data']['email'] ?? null;
$password = $_SESSION['adduser-data']['password'] ?? null;
$password = $_SESSION['adduser-data']['password'] ?? null;
$cpassword = $_SESSION['adduser-data']['cpassword'] ?? null;
unset($_SESSION['adduser-data']);

?>

<!--
  form
 --><br><br>

<section class="form__section">
  <div class="container form__section-container">
    <h2>add user</h2>
    <?php
    if (isset($_SESSION['adduser'])) : ?>
      <div class="alert__message error">
        <p>
          <?php
          echo $_SESSION['adduser'];
          unset($_SESSION['adduser']);
          ?>
        </p>
      </div>
    <?php endif ?>
    <form action="<?= ROOT_URL ?>admin/add__user-logic.php" autocomplete="off" enctype="multipart/form-data" method="POST">
      <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="first name">
      <input type="text" name="lastname" value="<?= $lastname ?>" placeholder=" last name">
      <input type="text" name="username" value="<?= $username ?>" placeholder=" username">
      <input type="email" name="email" value="<?= $email ?>" placeholder=" email address">
      <input type="password" name="password" value="<?= $password ?>" placeholder=" password">
      <input type="password" name="cpassword" value="<?= $cpassword ?>" placeholder=" confirm password">
      <select name="is-admin">
        <option>select user role</option>
        <option value="0">author</option>
        <option value="1">admin</option>
      </select>

      <div class="form__control">
        <label for="avatar">profile picture</label>
        <input type="file" id="avatar" name="avatar">
      </div>
      <button type="submit" class="btn" name="adduser">add user</button>
    </form>
  </div>
</section>




<br><br>


<?php
#including footer file
include_once './partials/footer.php';
?>