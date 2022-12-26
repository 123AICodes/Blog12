<?php
#including header file
include_once './partials/header.php';

#fetching user from database
$current_admin_id = $_SESSION['user_id'];
$query = " SELECT * FROM users WHERE NOT id = $current_admin_id";
$users = mysqli_query($connection, $query);

?>

<!--
    manage catgeory
  -->
<section class="dashboard">
  <?php if (isset($_SESSION['adduser-success'])) : ?>
    <div class="alert__message success container">
      <p>
        <?php
        echo $_SESSION['adduser-success'];
        unset($_SESSION['adduser-success']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['editUser-success'])) : ?>
    <div class="alert__message success container">
      <p>
        <?php
        echo $_SESSION['editUser-success'];
        unset($_SESSION['editUser-success']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['editUser'])) :  ?>
    <div class="alert__message error container">
      <p>
        <?php
        echo $_SESSION['editUser'];
        unset($_SESSION['editUser']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['delete_user'])) : ?>
    <div class="alert__message error container">
      <p>
        <?php
        echo $_SESSION['delete_user'];
        unset($_SESSION['delete_user']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['delete_user-success'])) : ?>
    <div class="alert__message success container">
      <p>
        <?php
        echo $_SESSION['delete_user-success'];
        unset($_SESSION['delete_user-success']);
        ?>
      </p>
    </div>
  <?php endif ?>
  <div class="container dashboard__container">
    <button class="toggle__sidebar" id="hide__sidebar-btn"><i class="fas fa-angle-left"></i></button>
    <button class="toggle__sidebar" id="show__sidebar-btn"><i class="fas fa-angle-right"></i></button>
    <aside>
      <ul>
        <?php if (isset($_SESSION['user_is_admin'])) : ?>
          <li>
            <a href="<?= ROOT_URL ?>admin/add-user.php"><span class="icon"><i class="fas fa-user-plus"></i></span>
              <h5>add user</h5>
            </a>
          </li>
          <li>
            <a href="<?= ROOT_URL ?>admin/manage-user.php" class="active"><span class="icon"><i class="fas fa-users"></i></span>
              <h5>manage users</h5>
            </a>
          </li>
          <li>
            <a href="<?= ROOT_URL ?>admin/add-category.php"><span class="icon"><i class="fas fa-list"></i></span>
              <h5>add category</h5>
            </a>
          </li>
          <li>
            <a href="<?= ROOT_URL ?>admin/manage-category.php"><span class="icon"><i class="fas fa-clipboard"></i></span>
              <h5>manage categories</h5>
            </a>
          </li>
        <?php endif ?>
        <li>
          <a href="<?= ROOT_URL ?>admin/add-post.php"><span class="icon"><i class="fas fa-edit"></i></span>
            <h5>add post</h5>
          </a>
        </li>
        <li>
          <a href="<?= ROOT_URL ?>admin/index.php"><span class="icon"><i class="fas fa-signs-post"></i></span>
            <h5>manage posts</h5>
          </a>
        </li>
      </ul>
    </aside>
    <main>
      <h2>manage users</h2>
      <?php if (mysqli_num_rows($users) > 0) : ?>
        <table>
          <thead>
            <tr>
              <th>name</th>
              <th>username</th>
              <th>admin</th>
              <th>edit</th>
              <th>delete</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($user = mysqli_fetch_assoc($users)) : ?>
              <tr>
                <td><?= "{$user['firstname']} {$user['lastname']}" ?></td>
                <td><?= "{$user['username']}" ?></td>
                <td><?= $user['is_admin'] ? 'Yes' : 'NO' ?></td>
                <td><a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>" class="btn sm yellow"> edit</a></td>
                <td><a href="<?= ROOT_URL ?>admin/delete-user.php?id=<?= $user['id'] ?>" class="btn sm danger" name="delete_user"> delete</a></td>
              </tr>
            <?php endwhile ?>
          </tbody>
        </table>
      <?php else : ?>
        <div class="alert__message error">
          <p><?= "No user found!"  ?></p>
        </div>
      <?php endif ?>
    </main>
  </div>
</section>





<?php
#including footer file
include_once './partials/footer.php';
?>