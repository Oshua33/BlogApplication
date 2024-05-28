<?php
include 'partials/header.php';

//fetch category from database
$query = "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($connection, $query); //this is also the $result dat reflect on the screen


?>


<section class="dashboard">
<?php if (isset($_SESSION['add-category-success'])):  // shows if add category was successfuly ?>
        <div class="alert_message success container ">
            <p>
                <?= $_SESSION['add-category-success'];
                unset($_SESSION['add-category-success']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['add-category'])):  // shows if add category was NOT successfuly ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['add-category'];
                unset($_SESSION['add-category']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['edit-category-success'])):  // shows if edit category was  successfuly ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['edit-category-success'];
                unset($_SESSION['edit-category-success']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['edit-category'])):  // shows if edit category was NOT successfuly ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['edit-category'];
                unset($_SESSION['edit-category']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['delete-category-sucess'])):  // shows if edit category was NOT successfuly ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['delete-category-sucess'];
                unset($_SESSION['delete-category-sucess']);
                ?>
            </p>
        </div>

        <?php endif ?>

    <div class="container dashboard-container">
        <button class="sidebar_toogle" id="show_sidebar-btn"><i class="uil uil-angle-right-b"></i></button>
        <button class="sidebar_toogle" id="hide_sidebar-btn"><i class="uil uil-angle-left-b"></i></button>
        <aside>
            <ul>
                <li><a href="add-post.php"><i class="uil uil-pen"></i>
                <h5>Add Post</h5>
                </a>
            </li>
                <li><a href="./index.php"><i class="uil uil-postcard"></i>
                    <h5>Manage Post</h5>
                    </a>
                </li>

                <!-- to set the page for an admin user -->
                <?php if (isset($_SESSION['user_is_admin'])) : ?>

                <li><a href="add-user.php"><i class="uil uil-plus"></i>
                    <h5>Add User</h5>
                    </a>
                </li>
                <li><a href="manage-user.php"><i class="uil uil-alt"></i>
                    <h5>Manage User</h5>
                    </a>
                </li>
                <li><a href="add-category.php"><i class="uil uil-edit"></i>
                    <h5>Add Category</h5>
                    </a>
                </li>
                <li><a href="manage-category.php" class="active"><i class="uil uil-list-ul"></i>
                    <h5>Manage Categories</h5>
                    </a>
                </li>

                    <!-- end the if statment and means it wont show if user is an admin-->
                <?php endif ?>

            </ul>
        </aside>
        <main>
            <h2>Manage Category</h2>
            <?php if(mysqli_num_rows($categories) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- we loop and shows the categories we have -->
                    <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                    <tr>
                        <td><?= $category['title'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?= $category['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete-category.php?id=<?= $category['id'] ?>" class="btn danger">Delete</a></td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
            <?php else : ?>
                <div class="alert_message error"><?= "No categories found" ?></div>
                <?php endif ?>
        </main>
    </div>
</section>

<!--========  FOOTER STARTS==========-->
<?php
include '../partials/footer.php';
?>