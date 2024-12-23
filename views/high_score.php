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
   $stmt = $conn->prepare("SELECT highscore FROM quizs WHERE id_playlist = ?");
   $stmt->bind_param("i", $link[3]);
   $stmt->execute();
   $stmt->bind_result($highscore);
   $stmt->fetch();
   $stmt->close();
   $conn->close();
   $list_highscore = explode("|", $highscore);
   ?>
   <section style="padding:0;">
      <div class="container-quiz">
         <div id="highScores" class="flex-center flex-column">
            <h1 id="finalScore">High Scores</h1>
            <ul id="highScoresList">
               <?php foreach ($list_highscore as $x) {
                  $temp = explode("`", $x);
               ?>
                  <li class="high-score">
                     <?= $temp[0] ?> - <?= $temp[1] ?>
                  </li>
               <?php } ?>
            </ul>
            <a class="btn" href="<?= @$link[3] != "" ? "../" : "" ?>quiz/<?= $link[3] ?>">Play Again</a>
            <a class="btn" href="<?= @$link[3] != "" ? "../" : "" ?>playlist/<?= $link[3] ?>">Back To Course</a>
         </div>
      </div>
   </section>

   <?php
   require "views/partials/foot.php";
   ?>
   <!-- <script src="js/highscores.js"></script> -->
</body>

</html>