<?php
require "views/partials/head.php";
?>

<body>
   <?php
   require "views/partials/header.php";
   require "views/partials/sidebar.php";
   include 'views/partials/conn.php';
   if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
   }
   $sql = "SELECT id_playlist, playlist_name, description, thumbnail, time_created FROM playlists WHERE id_teacher ='" . $_SESSION['user_id'] . "'";
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($id_playlist, $playlist_name, $description, $thumbnail, $time_created);
   ?>

   <section class="courses">

      <h1 class="heading">My Playlist <a href="addplaylist" class="inline-btn fa fa-plus"></a></h1>

      <div class="box-container">
         <?php
         while ($stmt->fetch()) {
         ?>
            <div class="box">
               <div class="tutor">
                  <img src="images/profile/<?= $_SESSION['profile_image'] ?>" alt="">
                  <div class="info">
                     <h3><?= $_SESSION['user_name'] ?></h3>
                     <span><?= htmlspecialchars($time_created) ?></span>
                  </div>
                  <a href="editplaylist/<?= htmlspecialchars($id_playlist) ?>" class="inline-btn fa fa-gear"></a>
                  <!-- <a href="deleteplaylist/<?= htmlspecialchars($id_playlist) ?>" class="inline-delete-btn fa fa-trash"></a> -->
                  <a href="deleteplaylist/<?= htmlspecialchars($id_playlist) ?>" class="inline-delete-btn fa fa-trash" onclick="return confirmDelete();"></a>
               </div>
               <div class="thumb">
                  <img src="images/playlist/<?= htmlspecialchars($thumbnail) ?>" alt="">
                  <!-- <span>10 videos</span> -->
               </div>
               <h3 class="title"><?= htmlspecialchars($playlist_name) ?></h3>
               <a href="playlist/<?= htmlspecialchars($id_playlist) ?>" class="inline-btn">view playlist</a>
               <a href="editquiz/<?= htmlspecialchars($id_playlist) ?>" class="inline-option-btn">edit quiz</a>
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
   <script>
      function confirmDelete() {
         return confirm("Are you sure you want to delete this playlist?");
      }
   </script>

</body>

</html>