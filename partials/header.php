<?php
require 'config/database.php';

if (!isset($_SESSION['user_id'])) {
  header('location: ' . ROOT_URL . 'signin.php');
  die();
} elseif (isset($_SESSION['user_id'])) {

  $id = filter_var($_SESSION['user_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $query = "SELECT * FROM users WHERE id=$id";
  $results = mysqli_query($connection, $query);
  $avatar = mysqli_fetch_assoc($results);
}
#fetching user profile picture

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
  <link rel="stylesheet" href="<?= ROOT_URL ?>css/all.min.css">
  <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">



</head>

<body>

  <!--
    header and navbar
  -->
  <nav>
    <div class="container nav__container">
      <a target="_self" title="home" href="<?= ROOT_URL ?>index.php" class="nav__logo">AICL Inc.</a>
      <ul class="nav__items">
        <li><a href="<?= ROOT_URL ?>blog.php">blog</a></li>
        <li><a href="<?= ROOT_URL ?>about.php">about</a></li>
        <li><a href="<?= ROOT_URL ?>service.php">services</a></li>
        <li><a href="<?= ROOT_URL ?>contact.php">contact</a></li>
        <?php if (isset($_SESSION['user_id'])) : ?>
          <li class="nav__profile">
            <div class="avatar"><img src="<?= ROOT_URL . 'image/' . $avatar['avatar'] ?>"></div>
            <ul>
              <li><a href="<?= ROOT_URL ?>admin/index.php">dashboard</a></li>
              <li><a href="<?= ROOT_URL ?>logout.php">logout</a></li>
            </ul>
          </li>
        <?php else : ?>
          <li><a href="<?= ROOT_URL ?>signin.php">signin</a></li>
        <?php endif ?>
      </ul>
      <button class="open__nav-btn"><i class="fas fa-bars"></i></button>
      <button class="close__nav-btn"><i class="fas fa-times"></i></button>
    </div>
  </nav>