<?php
include 'partials/header.php';

// fetch featured post from database
$featured_query = "SELECT * FROM post WHERE is_featured=1";
$featured_result = mysqli_query($connection, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);

// fetch 10 post from post table
$query = "SELECT * FROM post ORDER BY date_time DESC LIMIT 10";
$posts = mysqli_query($connection, $query);


?>

<!--======== SECTION FEATURE STARTS  ==========-->
<!-- show feaured post if there's any featured post-->
<?php   if (mysqli_num_rows($featured_result) == 1) :
// to check for featured post
?>
<section class="featured">
    <div class="container featured_container">
        <div class="post_thumbnail">
            <!-- show the images of featured post here -->
            <img src="./images/<?= $featured['thumbnail'] ?>">
        </div>
        <div class="post_info">
            <?php
            // fetch category from categories table using category_id of post to show the id in featured post
            $category_id = $featured['category_id'];
            $category_query = "SELECT * FROM categories WHERE id=$category_id";
            $category_result = mysqli_query($connection, $category_query);
            $category = mysqli_fetch_assoc($category_result);

            ?>
            <!-- show the title and body and the id -->
            <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>" class="category_button"><?= $category['title']; ?></a>
            <h2 class="post_title"><a href="<?=ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= $featured['title']  ?></a></h2>
            <p class="post_body"> 
                <!-- to show some characters not all d writeup. to get only 300 charatcers -->
                <?= substr($featured['boby'], 0, 300) ?>...
            </p>
            <div class="post_author">
             <?php
                // fetch the author from the users table using author_id in d bd
                $author_id = $featured['author_id'];
                $author_query = "SELECT * FROM users WHERE id=$author_id";
                $author_result = mysqli_query($connection, $author_query);
                $author = mysqli_fetch_assoc($author_result);
             ?>
                <div class="post_author-avatar ">
                <img src="./images/<?= $author['avatar'] ?>">
                </div>
                <div class="post_author-info">
                    <h5>By:<?= "{$author['firstname']} {$author['lastname']}" ?> </h5>
                    <small>
                        <!-- show time,date and year and hour and min of when the post was made -->
                         <?= date("M d, Y - H:i", strtotime($featured['date_time'])) ?>
                       </small>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif ?>

<!--======== SECTION FEATURE ENDS ==========-->


<!--======== SECTION POST STARTS ==========-->

<!-- check if dere is a feature post 
if dere is a featured post means true ($featured ? ) - true
('') - means dont add d new class 
else (: 'section_extra-margin') - add d new class
-->

<section class="posts <?= $featured ? '' : 'section_extra-margin' ?> ">
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

