<?php
include '../partials/header.php';
if (!isset($_SESSION['user_id'])) {
  header('location: ' . ROOT_URL . 'signin.php');
  die();
}
