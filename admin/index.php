<?php
#including header file
include_once './partials/header.php';

#fetching current user's post
$current_user_id = $_SESSION['user_id'];
$query = " SELECT id, title, category_id FROM post WHERE author_id LIKE {$current_user_id} ORDER BY id DESC ";
$posts = mysqli_query($connection, $query);

?>

<!--
    manage catgeory
  -->
<section class="dashboard">
  <?php if (isset($_SESSION['addPost-success'])) : ?>
    <div class="alert__message success container">
      <p>
        <?php
        echo $_SESSION['addPost-success'];
        unset($_SESSION['addPost-success']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['updatePost'])) : ?>
    <div class="alert__message error container">
      <p>
        <?php
        echo $_SESSION['updatePost'];
        unset($_SESSION['updatePost']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['updatePost-success'])) :  ?>
    <div class="alert__message success container">
      <p>
        <?php
        echo $_SESSION['updatePost-success'];
        unset($_SESSION['updatePost-success']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['deletePost-success'])) : ?>
    <div class="alert__message success container">
      <p>
        <?php
        echo $_SESSION['deletePost-success'];
        unset($_SESSION['deletePost-success']);
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
          <a href="<?= ROOT_URL ?>admin/index.php" class="active"><span class="icon"><i class="fas fa-signs-post"></i></span>
            <h5>manage posts</h5>
          </a>
        </li>
      </ul>
    </aside>
    <main>
      <h2>manage posts</h2>
      <?php if (mysqli_num_rows($posts) > 0) : ?>
        <table>
          <thead>
            <tr>
              <th>title</th>
              <th>category</th>
              <th>edit</th>
              <th>delete</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
              <!-- using category_id to get category name -->
              <?php
              $category_id = $post['category_id'];
              $category_query = mysqli_query($connection, " SELECT title FROM category WHERE id LIKE {$category_id} ");
              $category = mysqli_fetch_assoc($category_query);
              ?>
              <tr>
                <td><?= $post['title'] ?></td>
                <td><?= $category['title'] ?> </td>
                <td><a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $post['id'] ?>" class="btn sm yellow"> edit</a></td>
                <td><a href="<?= ROOT_URL ?>admin/delete-post.php?id=<?= $post['id'] ?>" class="btn sm danger"> delete</a></td>
              </tr>
            <?php endwhile ?>
          </tbody>
        </table>
      <?php else : ?>
        <div class="alert__message error">
          <p><?= "No post available!"  ?></p>
        </div>
      <?php endif ?>
    </main>
  </div>
</section>

<?php
#including footer file
include_once './partials/footer.php';
?>