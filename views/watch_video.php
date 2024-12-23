<?php
require "views/partials/head.php";
?>

<body>
   <?php
   require "views/partials/header.php";
   require "views/partials/sidebar.php";
   include 'views/partials/conn.php';
   // Check connection
   if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
   }
   $stmt = $conn->prepare("SELECT id_playlist, video_title, video, video_like, video_thumbnail, timestamp FROM videos WHERE id_video = ?");
   $stmt->bind_param("i", $link[3]);
   $stmt->execute();
   $stmt->bind_result($id_playlist, $video_title, $video, $like, $thumbnail, $timestamp);
   $stmt->fetch();
   $stmt->close();
   $query = mysqli_query($conn, "SELECT description, id_teacher FROM playlists WHERE id_playlist = '" . $id_playlist . "'");
   $data = mysqli_fetch_array($query);
   $query2 = mysqli_query($conn, "SELECT name, profile_image FROM users WHERE id = '" . $data['id_teacher'] . "'");
   $data2 = mysqli_fetch_array($query2);
   $conn->close();
   ?>

   <section class="watch-video">

      <div class="video-container">
         <div class="video">
            <video src="<?= @$link[3] != "" ? "../" : "" ?>videos/watch/<?= $video ?>" controls poster="<?= @$link[3] != "" ? "../" : "" ?>images/video/<?= $thumbnail ?>" id="video"></video>
         </div>
         <h3 class="title"><?= $video_title ?>
            <?php if ($_SESSION['level'] == "Teacher") { ?>
               <form action="<?= @$link[3] != "" ? "../" : "" ?>deletevideo/<?= $link[3] ?>" method="post">
                  <a href="<?= @$link[3] != "" ? "../" : "" ?>editvideo/<?= $link[3] ?>" class="inline-btn fa fa-gear"></a>
                  <button onclick="return confirmDelete();" name="deletevideo" value="<?= $id_playlist ?>" class="inline-delete-btn fa fa-trash"></button>
               </form>
            <?php } ?>
         </h3>
         <div class="info">
            <p class="date"><i class="fas fa-calendar"></i><span><?= $timestamp ?></span></p>
            <!-- <p class="date"><i class="fas fa-heart"></i><span><?= $like ?> likes</span></p> -->
         </div>
         <div class="tutor">
            <img src="<?= @$link[3] != "" ? "../" : "" ?>images/profile/<?= $data2['profile_image'] ?>" alt="">
            <div>
               <h3><?= $data2['name'] ?></h3>
               <span>Teacher</span>
            </div>
         </div>
         <form action="" method="post" class="flex">
            <a href="<?= @$link[3] != "" ? "../" : "" ?>playlist/<?= $id_playlist ?>" class="inline-btn">view playlist</a>
            <!-- <a href="playlist.html" class="inline-btn">Quiz</a> -->
            <!-- <button><i class="far fa-heart"></i><span>like</span></button> -->
         </form>
         <p class="description"><?= $data['description'] ?></p>
         <!-- <a href="playlist.html" class="inline-btn">view playlist</a> -->
      </div>

   </section>

   <!-- <section class="comments">

      <h1 class="heading">5 comments</h1>

      <form action="" class="add-comment">
         <h3>add comments</h3>
         <textarea name="comment_box" placeholder="enter your comment" required maxlength="1000" cols="30" rows="10"></textarea>
         <input type="submit" value="add comment" class="inline-btn" name="add_comment">
      </form>

      <h1 class="heading">user comments</h1>

      <div class="box-container">

         <div class="box">
            <div class="user">
               <img src="images/pic-1.jpg" alt="">
               <div>
                  <h3>shaikh anas</h3>
                  <span>22-10-2022</span>
               </div>
            </div>
            <div class="comment-box">this is a comment form shaikh anas</div>
            <form action="" class="flex-btn">
               <input type="submit" value="edit comment" name="edit_comment" class="inline-option-btn">
               <input type="submit" value="delete comment" name="delete_comment" class="inline-delete-btn">
            </form>
         </div>

         <div class="box">
            <div class="user">
               <img src="images/pic-2.jpg" alt="">
               <div>
                  <h3>john deo</h3>
                  <span>22-10-2022</span>
               </div>
            </div>
            <div class="comment-box">awesome tutorial!
               keep going!</div>
         </div>

         <div class="box">
            <div class="user">
               <img src="images/pic-3.jpg" alt="">
               <div>
                  <h3>john deo</h3>
                  <span>22-10-2022</span>
               </div>
            </div>
            <div class="comment-box">amazing way of teaching!
               thank you so much!
            </div>
         </div>

         <div class="box">
            <div class="user">
               <img src="images/pic-4.jpg" alt="">
               <div>
                  <h3>john deo</h3>
                  <span>22-10-2022</span>
               </div>
            </div>
            <div class="comment-box">loved it, thanks for the tutorial!</div>
         </div>

         <div class="box">
            <div class="user">
               <img src="images/pic-5.jpg" alt="">
               <div>
                  <h3>john deo</h3>
                  <span>22-10-2022</span>
               </div>
            </div>
            <div class="comment-box">this is what I have been looking for! thank you so much!</div>
         </div>

         <div class="box">
            <div class="user">
               <img src="images/pic-2.jpg" alt="">
               <div>
                  <h3>john deo</h3>
                  <span>22-10-2022</span>
               </div>
            </div>
            <div class="comment-box">thanks for the tutorial!

               how to download source code file?
            </div>
         </div>

      </div>

   </section> -->
   <?php
   require "views/partials/foot.php";
   ?>
   <script>
      function confirmDelete() {
         return confirm("Are you sure you want to delete this video?");
      }
   </script>
</body>

</html>