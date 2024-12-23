<?php
require "views/partials/head.php";
?>

<body>
   <?php
   require "views/partials/header.php";
   require "views/partials/sidebar.php";
   ?>
   <section style="padding:0;">
      <div class="container-quiz">
         <div id="end" class="flex-center flex-column">
            <h1> Congratulation!!</h1>
            <h1 id="finalScore"></h1>
            <form class="score" method="post">
               <input type="hidden" name="score" id="score">
               <!-- <input type="text" name="username" id="username" placeholder="username" /> -->
               <button type="submit" class="btn" id="saveScoreBtn">
                  Save
               </button>
            </form>
            <a class="btn" href="<?= @$link[3] != "" ? "../" : "" ?>quiz/<?= $link[3] ?>">Play Again</a>
            <a class="btn" href="<?= @$link[3] != "" ? "../" : "" ?>playlist/<?= $link[3] ?>">Back To Course</a>
         </div>
      </div>
   </section>

   <?php
   require "views/partials/foot.php";
   ?>
   <script>
      const mostRecentScore = localStorage.getItem('mostRecentScore');
      document.getElementById('finalScore').innerText = mostRecentScore;
      document.getElementById('score').value = mostRecentScore;
   </script>
</body>

</html>

<?php
include 'views/partials/conn.php';
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['score'])) {
   $name = $_SESSION['user_name'];
   $score = $_POST['score'];

   // Fetch the current password from the database
   $sql = "SELECT highscore FROM quizs WHERE id_playlist = ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("i", $link[3]);
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($highscore);
   $stmt->fetch();
   $new_highscore = "";
   $ex = explode("|", $highscore);
   for ($i=0; $i < 5; $i++) { 
      $temp = explode("`", $ex[$i]);
      if ($score >= $temp[1]) {
         $temp2 = $temp[0];
         $temp[0] = $name;
         $name = $temp2;
         $temp2 = $temp[1];
         $temp[1] = $score;
         $score = $temp2;
      }
      $new_highscore = $new_highscore . $temp[0]."`".$temp[1];
      if ($i != 4) {
         $new_highscore = $new_highscore."|";
      }
   }

   // Update the database
   $sql = "UPDATE quizs SET highscore = ? WHERE id_playlist = ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("si", $new_highscore, $link[3]);

   if ($stmt->execute()) {
      echo "Score saved.";
      echo "<script>
         window.location.href = '../highscore/$link[3]';
      </script>";
   } else {
      echo "Error updating profile: " . $stmt->error;
   }

   $stmt->close();
}

$conn->close();
?>