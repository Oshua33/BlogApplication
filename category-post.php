<?php
include 'partials/header.php';

// fetch post if id is set
if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM post WHERE category_id=$id ORDER BY date_time DESC";
    $posts = mysqli_query($connection, $query);
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}

?>

<!--======== SECTION CATEGORY TITLE ==========-->
<header class="category_title">
    <h2>
<?php
            // fetch category from categories table using category_id of post to show the id in featured post
            $category_id =  $id;
            $category_query = "SELECT * FROM categories WHERE id=$id";
            $category_result = mysqli_query($connection, $category_query);
            $category = mysqli_fetch_assoc($category_result);
            echo $category['title']

            ?>
    </h2>
</header>
<!--======== END OF CATEGORY TITLE ==========-->


<!--======== SECTION POST STARTS ==========-->
<!-- if there is a category post show it else dont -->
<?php if (mysqli_num_rows($posts) > 0) : ?>
<section class="posts">
    <div class="container posts_container">
    <?php while($post = mysqli_fetch_assoc($posts)) : ?>
        <article class="post">
            <div class="post_thumbnail">
                <img src="./images/<?= $post['thumbnail'] ?>">
            </div>
            <div class="post_info">
           
                <h3 class="post_title">
                    <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>  
                </h3>
                <p class="post_body">
                <!-- to show some characters not all d writeup. to get only 300 charatcers -->
                <?= substr($post['boby'], 0, 150) ?>... 
                </p>
                <div class="post_author">
                <?php
                // fetch the author from the users table using author_id in d bd
                $author_id = $post['author_id'];
                $author_query = "SELECT * FROM users WHERE id=$author_id";
                $author_result = mysqli_query($connection, $author_query);
                $author = mysqli_fetch_assoc($author_result);
                ?>
                    <div class="post_author-avatar">
                    <img src="./images/<?= $author['avatar'] ?>">
                    </div>
                    <div class="post_author-info">
                    <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?> </h5>
                        <small><!-- show time,date and year and hour and min of when the post was made -->
                         <?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                    </div>
                </div>
            </div>
        </article>
        <?php endwhile ?>
<!--article tages helps group content-->
     </div>
</section>
<?php else : ?>
<div class="alert_message error lg">
    <p>No posts found for this category</p>
</div>
    <?php endif ?>
<!--======== SECTION POST ENDS ==========-->


<!--======== SECTION CATEGORY_BUTTONS STARTS ==========-->
<section class="category_buttons">
  <div class="container category_button-container">
  <?php  
        $all_categories_query = "SELECT * FROM categories";
        $all_categories = mysqli_query($connection, $all_categories_query);
    ?>
    <?php while($category = mysqli_fetch_assoc($all_categories)) : ?>
        <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>" class="category_button"><?= $category['title'] ?></a>
    <?php endwhile ?>
  </div>    
</section>
<!--======== SECTION CATEGORY_BUTTONS ENDS==========-->


<?php
include './partials/footer.php';
?>

