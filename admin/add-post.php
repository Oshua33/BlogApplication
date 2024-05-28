<?php
include 'partials/header.php';

// fetch categories for the category session
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

// get form data if form was invalid
$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;

// delete form datat session
unset($_SESSION['add-post-data']);

?>
<!--======== END OF NAV ==========-->

    

<section class="form_section">
    <div class="container form_section-container">
        <h2>Add Post</h2>
        <?php if(isset($_SESSION['add-post'])) : ?>
        <div class="alert_message error">

        <p>
             <?= 
             $_SESSION['add-post'];
            unset($_SESSION['add-post']);
             ?>
        </p>
    </div>
    <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-post-logic.php"  method="POST" enctype="multipart/form-data">
            <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
            <select name="category">
                <!--set the category to shows the category of the user -->
                <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                <?php endwhile ?>
            </select>
            <textarea rows="10" name="body" value="<?= $body ?>" placeholder="Body"></textarea>
            <!--to set the checkbox avaliable for only admin where only admin can see the featured check -->
            <?php if(isset($_SESSION['user_is_admin'])) : ?>  
            <div class="form_control inline">
                <input type="checkbox" value="1" name="is_featured" id="is_featured" checked>
                <label for="is_featured">Featured</label>
            </div>
            <?php endif ?>
            <div class="form_control">
                <label for="thumbnail">Add Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Add Post</button>
        </form>
    </div>
</section>

<!--========  FOOTER STARTS==========-->
<?php
include '../partials/footer.php';
?>