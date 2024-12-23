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
   $query = mysqli_query($conn, "SELECT p.id_teacher, u.name AS teacher_name, u.profile_image, p.id_playlist, p.playlist_name, p.description, p.thumbnail, p.time_created
FROM playlists p
INNER JOIN users u ON p.id_teacher = u.id");
   ?>

   <section class="courses">

      <h1 class="heading">our courses</h1>

      <div class="box-container">

         <?php while ($data = mysqli_fetch_array($query)) { ?>
            <div class="box">
               <div class="tutor">
                  <img src="images/profile/<?= $data['profile_image'] ?>" alt="">
                  <div class="info">
                     <h3><?= $data['teacher_name'] ?></h3>
                     <span><?= $data['time_created'] ?></span>
                  </div>
               </div>
               <div class="thumb">
                  <img src="images/playlist/<?= $data['thumbnail'] ?>" alt="">
                  <!-- <span>10 videos</span> -->
               </div>
               <h3 class="title"><?= $data['playlist_name'] ?></h3>
               <a href="playlist/<?= $data['id_playlist'] ?>" class="inline-btn">view playlist</a>
            </div>
         <?php } ?>
      </div>

   </section>

   <?php
   require "views/partials/foot.php";
   ?>
</body>

</html>