<?php
#including header file
include_once './partials/header.php';

#fetching categories
$query = " SELECT * FROM category ORDER BY title";
$categories = mysqli_query($connection, $query);


?>


<!--
    manage catgeory
  -->
<section class="dashboard">
  <?php if (isset($_SESSION['addCategory-success'])) : ?>
    <div class="alert__message success container">
      <p>
        <?php
        echo $_SESSION['addCategory-success'];
        unset($_SESSION['addCategory-success']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['updateCat'])) : ?>
    <div class="alert__message error container">
      <p>
        <?php
        echo $_SESSION['updateCat'];
        unset($_SESSION['updateCat']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['updateCat-success'])) : ?>
    <div class="alert__message success container">
      <p>
        <?php
        echo $_SESSION['updateCat-success'];
        unset($_SESSION['updateCat-success']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['deleteCat'])) : ?>
    <div class="alert__message error container">
      <p>
        <?php
        echo $_SESSION['deleteCat'];
        unset($_SESSION['deleteCat']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['deleteCat-success'])) : ?>
    <div class="alert__message success container">
      <p>
        <?php
        echo $_SESSION['deleteCat-success'];
        unset($_SESSION['deleteCat-success']);
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
            <a href="<?= ROOT_URL ?>admin/manage-user.php"><span class="icon"><i class="fas fa-users"></i></span>
              <h5>manage users</h5>
            </a>
          </li>
          <li>
            <a href="<?= ROOT_URL ?>admin/add-category.php"><span class="icon"><i class="fas fa-list"></i></span>
              <h5>add category</h5>
            </a>
          </li>
          <li>
            <a href="<?= ROOT_URL ?>admin/manage-category.php" class="active"><span class="icon"><i class="fas fa-clipboard"></i></span>
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
      <h2>manage categories</h2>
      <?php if (mysqli_num_rows($categories) > 0) : ?>
        <table>
          <thead>
            <tr>
              <th>title</th>
              <th>edit</th>
              <th>delete</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
              <tr>
                <td><?= $category['title'] ?></td>
                <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?= $category['id'] ?>" class="btn sm yellow"> edit</a></td>
                <td><a href="<?= ROOT_URL ?>admin/delete-category.php?id=<?= $category['id'] ?>" class="btn sm danger"> delete</a></td>
              </tr>
            <?php endwhile ?>
          </tbody>
        </table>
      <?php else : ?>
        <div class="alert__message error">
          <p><?= "No category found!"  ?></p>
        </div>
      <?php endif ?>
    </main>
  </div>
</section>


<?php
#including footer file
include_once './partials/footer.php';
?>