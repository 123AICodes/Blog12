<?php
require_once './config/constants.php';

#preventing data lose
$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);




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
      <h2>sign in</h2>
      <?php
      if (isset($_SESSION['signin'])) : ?>
        <div class="alert__message error">
          <p>
            <?php
            echo $_SESSION['signin'];
            unset($_SESSION['signin']);
            ?>
          </p>
        </div>
      <?php elseif (isset($_SESSION['signup-success'])) : ?>
        <div class="alert__message success">
          <p>
            <?php
            echo $_SESSION['signup-success'];
            unset($_SESSION['signup-success']);
            ?>
          </p>
        </div>
      <?php elseif (isset($_SESSION['signin-success'])) : ?>
        <div class="alert__message success">
          <p>
            <?php
            echo $_SESSION['signin-success'];
            unset($_SESSION['signin-success']);
            ?>
          </p>
        </div>
      <?php endif ?>

      <form action="<?= ROOT_URL ?>signin-logic.php" autocomplete="off" method="POST">

        <input name="username_email" type="text" value="<?= $username_email ?>" placeholder=" username or email">
        <input name="password" type="password" value="<?= $password ?>" placeholder=" password">

        <button type="submit" class="btn" name="signin">sign in</button>
        <small>don't have an account? <a href="signup.php">sign up</a></small>
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