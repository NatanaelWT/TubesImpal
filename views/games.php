<?php
require "views/partials/head.php";
?>

<body>
   <?php
   require "views/partials/header.php";
   require "views/partials/sidebar.php";
   ?>

   <section class="courses">
      <h1 class="heading">our games</h1>
      <div class="box-container">
         <div class="box" style="background-color: none;">
            <div class="thumb">
               <img src="views/games/gambar/ctw.jpg" alt="">
            </div>
            <h3 class="title">Complete The Word</h3>
            <a href="selectcompletetheword" class="inline-btn">Play Game</a>
         </div>
         <div class="box" style="background-color: none;">
            <div class="thumb">
               <img src="views/games/gambar/cw.png" alt="">
            </div>
            <h3 class="title">Construct Word</h3>
            <a href="selectconstructword" class="inline-btn">Play Game</a>
         </div>
         <div class="box" style="background-color: none;">
            <div class="thumb">
               <img src="views/games/gambar/counting.jpg" alt="">
            </div>
            <h3 class="title">Counting</h3>
            <a href="counting" class="inline-btn">Play Game</a>
         </div>
      </div>


   </section>

   <?php
   require "views/partials/foot.php";
   ?>
</body>

</html>