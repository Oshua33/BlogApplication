<?php
include 'partials/header.php';


// if user enter a search button and submit button are set
// for the query - %$search% * means the input entered* 
// where title is like d input dey want to search for order by date & time from descending order...
// if wat type in d search bar can be found then show the post. ( $query means ).
if(isset($_GET['search']) && isset($_GET['sumbit'])) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT * FROM post WHERE title LIKE '%$search%' ORDER BY date_time DESC";
    $posts = mysqli_query($connection, $query);
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}

?>



<?php if (mysqli_num_rows($posts) > 0) : ?>
    <section class="section_extra-margin">
    <div class="container posts_container">
    <?php while($post = mysqli_fetch_assoc($posts)) : ?>
        <article class="post">
            <div class="post_thumbnail">
                <img src="./images/<?= $post['thumbnail'] ?>">
            </div>
            <div class="post_info">
            <?php
            // fetch category from categories table using category_id of post to show the id in featured post
            $category_id = $post['category_id'];
            $category_query = "SELECT * FROM categories WHERE id=$category_id";
            $category_result = mysqli_query($connection, $category_query);
            $category = mysqli_fetch_assoc($category_result);

            ?>
                <a href="<?= ROOT_URL?>category-post.php?id=<?= $category_id ?>" class="category_button"><?= $category['title'] ?></a>
                <h3 class="post_title">
                    <a href="<?=ROOT_URL ?>post.php?id=<?= $post['id'] ?>post.php"><?= $post['title'] ?></a>  
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
    <div class="alert_message error lg section_extra-margin">
        <p>
            No post found for this search
        </p>
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