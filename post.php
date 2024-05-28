<?php
include './partials/header.php';

// fetch post if id is set this is d first step of link page using id
if(isset($_GET['id'])) {
   $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
   $query = "SELECT * FROM post WHERE id=$id";
   $result = mysqli_query($connection, $query);
   $post = mysqli_fetch_assoc($result);
} else {
   header('location: ' . ROOT_URL . 'blog.php');
   die();
}

?>


<!--======== SECTION SINGLEPOST STARTS ==========-->

<section class="singlepost">
    <div class="container singlepost_container">
        <h2><?= $post['title'] ?> </h2>
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
            <h5>By:<?= "{$author['firstname']} {$author['lastname']}" ?> </h5>
                    <small>
                        <!-- show time,date and year and hour and min of when the post was made -->
                         <?= date("M d, Y - H:i", strtotime($post['date_time'])) ?>
                       </small>
            </div>
         </div>
         <div class="singlepost_thumbnail">
            <img src="./images/<?= $post['thumbnail'] ?>">
         </div>
         <p>
            <?= $post['boby'] ?>      
      </p>
        
    </div>
</section>

<!--======== SECTION SINGLEPOST ENDS ==========-->

<?php
include './partials/footer.php';
?>