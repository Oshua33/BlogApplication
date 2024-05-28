<?php
include 'partials/header.php';

// fetch users from database but not current login user, note ensure you use dis code wen loggin
$current_admin_id = $_SESSION['user-id'];

$query = "SELECT * FROM users WHERE NOT  id=$current_admin_id";
$users = mysqli_query($connection, $query); 
?>


<section class="dashboard">

<?php if (isset($_SESSION['add-user-success'])):  // shows if add user was successfuly ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['add-user-success'];
                unset($_SESSION['add-user-success']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['edit-user-success'])): // shows if edit user was successfuly  ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['edit-user-success'];
                unset($_SESSION['edit-user-success']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['edit-user'])): // shows if edit user was not successfuly  ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['edit-user'];
                unset($_SESSION['edit-user']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['delete-user'])): // shows if delete user was not successfuly  ?>
        <div class="alert_message error container ">
            <p>
                <?= $_SESSION['delete-user'];
                unset($_SESSION['delete-user']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['delete-user-success'])): // shows if delete user was successfuly  ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['delete-user-success'];
                unset($_SESSION['delete-user-success']);
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
                <li><a href="manage-user.php" ><i class="uil uil-alt"></i>
                    <h5>Manage User</h5>
                    </a>
                </li>
                <li><a href="add-category.php"><i class="uil uil-edit"></i>
                    <h5>Add Category</h5>
                    </a>
                </li>
                <li><a href="manage-category.php"><i class="uil uil-list-ul"></i>
                    <h5>Manage Categories</h5>
                    </a>
                </li>

                  <!-- end the if statment and means it wont show if user is an admin-->
                <?php endif ?>

            </ul>
        </aside>
        <main>
            <h2>Manage Users</h2>
            <!-- check if there is no users give error message no user 
            this means if there is a user( table greater dan 0) show the table
             but if there is no user show error messgae -->
            <?php if(mysqli_num_rows($users) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <!--using a while loop to display the user in d database to the page in arrays-->
                    <?php while ($user = mysqli_fetch_assoc($users)) : ?>
                    <tr>
                        <!-- echo the users dynamically -->
                        <td><?= "{$user['firstname']} {$user['lastname']}"  ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete-user.php?id=<?= $user['id'] ?> " class="btn danger">Delete</a></td>
                        <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                    </tr>    
                    <?php endwhile ?>
                </tbody>
            </table>
            <?php else : ?>
                <div class="alert_message error"> <?= "No users found" ?></div>
                <?php endif ?>
        </main>
    </div>
</section>

<!--========  FOOTER STARTS==========-->
<?php
include '../partials/footer.php';
?>