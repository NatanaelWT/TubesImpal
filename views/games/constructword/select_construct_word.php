<?php
require "views/partials/head.php";
?>

<body>
   <?php
   require "views/partials/header.php";
   require "views/partials/sidebar.php";
   ?>

   <section class="courses">
      <h1 class="heading">Construct Word</h1>
      <div class="box-container">

         <div class="box" style="background-color: none;">
            <div class="thumb">
               <img src="views/games/gambar/apel.png" alt="">
            </div>
            <h3 class="title">Nama Buah</h3>
            <a href="constructword/buah" class="inline-btn">Play Game</a>
         </div>
         <div class="box" style="background-color: none;">
            <div class="thumb">
               <img src="views/games/gambar/kucing.png" alt="">
            </div>
            <h3 class="title">Nama Hewan</h3>
            <a href="constructword/hewan" class="inline-btn">Play Game</a>
         </div>
         <div class="box" style="background-color: none;">
            <div class="thumb">
               <img src="views/games/gambar/meja.png" alt="">
            </div>
            <h3 class="title">Nama Benda</h3>
            <a href="constructword/benda" class="inline-btn">Play Game</a>
         </div>
      </div>


   </section>

   <?php
   require "views/partials/foot.php";
   ?>
</body>

</html>