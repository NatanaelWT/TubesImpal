<?php
require "views/partials/head.php";
?>

<body>
   <?php
   require "views/partials/header.php";
   require "views/partials/sidebar.php";
   ?>

   <section class="user-profile">

      <h1 class="heading">your profile</h1>

      <div class="info">

         <div class="user">
            <img src="<?= isset($_SESSION['profile_image']) ? "images/profile/".$_SESSION['profile_image'] : "images/default/pic-1.jpg" ?>" alt="">
            <h3><?= $_SESSION['user_name'] ?></h3>
            <p><?= $_SESSION['level'] ?></p>
            <a href="update" class="inline-btn">update profile</a>
         </div>

         
      </div>

   </section>

   <?php
   require "views/partials/foot.php";
   ?>
</body>

</html>