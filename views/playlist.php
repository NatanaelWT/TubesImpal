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
   $stmt = $conn->prepare("SELECT id_teacher, playlist_name, description, thumbnail, time_created FROM playlists WHERE id_playlist = ?");
   $stmt->bind_param("i", $link[3]);
   $stmt->execute();
   $stmt->bind_result($id_teacher, $playlist_name, $description, $thumbnail, $time_created);
   $stmt->fetch();
   $stmt->close();

   $query = mysqli_query($conn, "SELECT name, profile_image FROM users WHERE id = '" . $id_teacher . "'");
   $data = mysqli_fetch_array($query);
   $query2 = mysqli_query($conn, "SELECT * FROM videos WHERE id_playlist = '" . $link[3] . "'");
   ?>

   <section class="playlist-details">

      <h1 class="heading">playlist details</h1>

      <div class="row">

         <div class="column">

            <div class="thumb">
               <img src="<?= @$link[3] != "" ? "../" : "" ?>images/playlist/<?= htmlspecialchars($thumbnail) ?>" alt="">
               <!-- <span>10 videos</span> -->
            </div>
         </div>
         <div class="column">
            <div class="tutor">
               <img src="<?= @$link[3] != "" ? "../" : "" ?>images/profile/<?= htmlspecialchars($data['profile_image']) ?>" alt="">
               <div>
                  <h3><?= htmlspecialchars($data['name']) ?></h3>
                  <span><?= htmlspecialchars($time_created) ?></span>
               </div>
            </div>

            <div class="details">
               <h3><?= htmlspecialchars($playlist_name) ?></h3>
               <p><?= htmlspecialchars($description) ?></p>
               <a href="<?= @$link[3] != "" ? "../" : "" ?>teacher/<?= htmlspecialchars($id_teacher) ?>" class="inline-btn">view Teacher</a>
               <?php
               $da = mysqli_query($conn, "SELECT * FROM quizs WHERE id_playlist = $link[3]");
               if (mysqli_num_rows($da) == 0) {
               ?>
                  <a class="delete-btn">No Quiz</a>
               <?php } else { ?>
                  <a href="<?= @$link[3] != "" ? "../" : "" ?>quiz/<?= $link[3] ?>" class="btn">Play Quiz</a>
               <?php } $conn->close();?>
            </div>
         </div>
      </div>

   </section>

   <section class="playlist-videos">

      <h1 class="heading">playlist videos <?php if (@$_SESSION['user_id'] == $id_teacher) { ?><a href="<?= @$link[3] != "" ? "../" : "" ?>addvideo/<?= $link[3] ?>" class="inline-btn fa fa-plus"></a> <?php } ?></h1>

      <div class="box-container">
         <?php while ($data2 = mysqli_fetch_array($query2)) { ?>
            <a class="box" href="<?= @$link[3] != "" ? "../" : "" ?>watch/<?= $data2['id_video']; ?>">
               <i class="fas fa-play"></i>
               <img src="<?= @$link[3] != "" ? "../" : "" ?>images/video/<?= $data2['video_thumbnail']; ?>" alt="">
               <h3><?= $data2['video_title']; ?></h3>
            </a>
         <?php } ?>
      </div>

   </section>

   <?php
   require "views/partials/foot.php";
   ?>
</body>

</html>