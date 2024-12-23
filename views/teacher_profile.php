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
   $query = mysqli_query($conn, "SELECT name, profile_image FROM users WHERE id = '" . $link[3] . "'");
   $data = mysqli_fetch_array($query);
   $sql = "SELECT id_playlist, playlist_name, thumbnail, time_created FROM playlists WHERE id_teacher ='" . $link[3] . "'";
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($id_playlist, $playlist_name, $thumbnail, $time_created);

   $sql2 =  "SELECT COUNT(id_playlist) AS playlist_count FROM playlists WHERE id_teacher = " . $link[3];
   $stmt2 = $conn->prepare($sql2);
   $stmt2->execute();
   $stmt2->store_result();
   $stmt2->bind_result($p_count);
   $stmt2->fetch();

   $sql4 = "SELECT id_playlist FROM playlists WHERE id_teacher = " . $link[3];
   $stmt4 = $conn->prepare($sql4);
   $stmt4->execute();
   $stmt4->store_result();
   $stmt4->bind_result($id_p);

   $vid = 0;
   while ($stmt4->fetch()) {
      $sql3 = "SELECT COUNT(id_video) FROM videos WHERE id_playlist = ?";
      $stmt3 = $conn->prepare($sql3);
      $stmt3->bind_param('i', $id_p);
      $stmt3->execute();
      $stmt3->store_result();
      $stmt3->bind_result($v_count);
      $stmt3->fetch();
      $vid += $v_count;
      $stmt3->close();
   }
   ?>

   <section class="teacher-profile">

      <h1 class="heading">profile details</h1>

      <div class="details">
         <div class="tutor">
            <img src="<?= @$link[3] != "" ? "../" : "" ?>images/profile/<?= htmlspecialchars($data['profile_image']) ?>" alt="">
            <h3><?= htmlspecialchars($data['name']) ?></h3>
            <span>Teacher</span>
         </div>
         <div class="flex">
            <p>total playlists : <span><?= $p_count ?></span></p>
            <p>total videos : <span><?= $vid ?></span></p>
         </div>
      </div>

   </section>

   <section class="courses">

      <h1 class="heading">our courses</h1>

      <div class="box-container">

         <?php
         while ($stmt->fetch()) {
            $vid1 = 0;
            $sql3 = "SELECT COUNT(id_video) FROM videos WHERE id_playlist = ?";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bind_param('i', $id_playlist);
            $stmt3->execute();
            $stmt3->store_result();
            $stmt3->bind_result($v_count2);
            $stmt3->fetch();
            $vid1 = $v_count2;
            $stmt3->close();
         ?>
            <div class="box">
               <div class="thumb">
                  <img src="<?= @$link[3] != "" ? "../" : "" ?>images/playlist/<?= htmlspecialchars($thumbnail) ?>" alt="">
                  <span><?= $v_count2 ?> videos</span>
               </div>
               <h3 class="title"><?= htmlspecialchars($playlist_name) ?></h3>
               <a href="<?= @$link[3] != "" ? "../" : "" ?>playlist/<?= htmlspecialchars($id_playlist) ?>" class="inline-btn">view playlist</a>
            </div>
         <?php
         }
         $stmt->close();
         $conn->close();
         ?>
      </div>

   </section>

   <?php
   require "views/partials/foot.php";
   ?>
</body>

</html>