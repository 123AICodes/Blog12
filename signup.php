<?php
require_once './config/constants.php';

#preventing data lose
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$password = $_SESSION['signup-data']['password'] ?? null;
$cpassword = $_SESSION['signup-data']['cpassword'] ?? null;
unset($_SESSION['signup-data']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Blog Crud Application</title>

  <!--
    css files link
    fontAwesome minified and custom css
  -->
  <link rel="stylesheet" href="./css/all.min.css">
  <link rel="stylesheet" href="./css/style.css">



</head>

<body>


  <section class="form__section">
    <div class="container form__section-container">
      <h2>sign up</h2>
      <?php
      if (isset($_SESSION['signup'])) : ?>
        <div class="alert__message error">
          <p>
            <?php
            echo $_SESSION['signup'];
            unset($_SESSION['signup']);
            ?>
          </p>
        </div>
      <?php endif ?>

      <form action="<?= ROOT_URL ?>signup-logic.php" method="POST" autocomplete="off" enctype="multipart/form-data">
        <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="first name">
        <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="last name">
        <input type="text" name="username" value="<?= $username ?>" placeholder="username">
        <input type="email" name="email" value="<?= $email ?>" placeholder="email address">
        <input type="password" name="password" value="<?= $password ?>" placeholder="password">
        <input type="password" name="cpassword" value="<?= $cpassword ?>" placeholder="confirm password">
        <div class="form__control">
          <label for="avatar">user profile</label>
          <input type="file" name="avatar" id="avatar">
        </div>
        <button type="submit" name="signup" class="btn">sign up</button>
        <small>already have an account? <a href="signin.php">sign in</a></small>
      </form>
    </div>
  </section>




  <!--
    js files link
    fontAwesome minified and custom js
  -->
  <script src="./js/all.min.js"></script>
  <script src="./js/main.js"></script>


</body>

</html>