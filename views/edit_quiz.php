<?php
require "views/partials/head.php";
?>

<body>
   <?php
   require "views/partials/header.php";
   require "views/partials/sidebar.php";
   include 'views/partials/conn.php';
   $data = mysqli_fetch_array(mysqli_query($conn, "SELECT quiz FROM quizs WHERE id_playlist=$link[3]"));
   @$soal = explode("|", $data[0]);
   @$soal1 = explode("`", $soal[0]);
   @$soal2 = explode("`", $soal[1]);
   @$soal3 = explode("`", $soal[2]);
   @$soal4 = explode("`", $soal[3]);
   @$soal5 = explode("`", $soal[4]);
   @$soal6 = explode("`", $soal[5]);
   @$soal7 = explode("`", $soal[6]);
   @$soal8 = explode("`", $soal[7]);
   @$soal9 = explode("`", $soal[8]);
   @$soal10 = explode("`", $soal[9]);
   ?>

   <section class="form-container">

      <form method="post" enctype="multipart/form-data">
         <h3>edit quiz <a href="<?= @$link[3] != "" ? "../" : "" ?>deletequiz/<?= $link[3] ?>" class="delete-btn fa fa-trash"> <span>Delete Quiz</span></a></h3>

         <p>question 1 <span>*</span></p>
         <input value="<?= @$soal1[0] ?>" style="border:solid white;" type="text" name="question1" placeholder="question" required class="box">
         <input value="<?= @$soal1[1] ?>" style="border:solid green;" type="text" name="option11" placeholder="correct answer" required class="box">
         <input value="<?= @$soal1[2] ?>" style="border:solid red;" type="text" name="option12" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal1[3] ?>" style="border:solid red;" type="text" name="option13" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal1[4] ?>" style="border:solid red;" type="text" name="option14" placeholder="incorrect answer" required class="box">
         <hr style="border: none; height: 4px; color: #333; background-color: #333;">
         <p>question 2 <span>*</span></p>
         <input value="<?= @$soal2[0] ?>" style="border:solid white;" type="text" name="question2" placeholder="question" required class="box">
         <input value="<?= @$soal2[1] ?>" style="border:solid green;" type="text" name="option21" placeholder="correct answer" required class="box">
         <input value="<?= @$soal2[2] ?>" style="border:solid red;" type="text" name="option22" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal2[3] ?>" style="border:solid red;" type="text" name="option23" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal2[4] ?>" style="border:solid red;" type="text" name="option24" placeholder="incorrect answer" required class="box">
         <hr style="border: none; height: 4px; color: #333; background-color: #333;">
         <p>question 3 <span>*</span></p>
         <input value="<?= @$soal3[0] ?>" style="border:solid white;" type="text" name="question3" placeholder="question" required class="box">
         <input value="<?= @$soal3[1] ?>" style="border:solid green;" type="text" name="option31" placeholder="correct answer" required class="box">
         <input value="<?= @$soal3[2] ?>" style="border:solid red;" type="text" name="option32" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal3[3] ?>" style="border:solid red;" type="text" name="option33" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal3[4] ?>" style="border:solid red;" type="text" name="option34" placeholder="incorrect answer" required class="box">
         <hr style="border: none; height: 4px; color: #333; background-color: #333;">
         <p>question 4 <span>*</span></p>
         <input value="<?= @$soal4[0] ?>" style="border:solid white;" type="text" name="question4" placeholder="question" required class="box">
         <input value="<?= @$soal4[1] ?>" style="border:solid green;" type="text" name="option41" placeholder="correct answer" required class="box">
         <input value="<?= @$soal4[2] ?>" style="border:solid red;" type="text" name="option42" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal4[3] ?>" style="border:solid red;" type="text" name="option43" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal4[4] ?>" style="border:solid red;" type="text" name="option44" placeholder="incorrect answer" required class="box">
         <hr style="border: none; height: 4px; color: #333; background-color: #333;">
         <p>question 5 <span>*</span></p>
         <input value="<?= @$soal5[0] ?>" style="border:solid white;" type="text" name="question5" placeholder="question" required class="box">
         <input value="<?= @$soal5[1] ?>" style="border:solid green;" type="text" name="option51" placeholder="correct answer" required class="box">
         <input value="<?= @$soal5[2] ?>" style="border:solid red;" type="text" name="option52" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal5[3] ?>" style="border:solid red;" type="text" name="option53" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal5[4] ?>" style="border:solid red;" type="text" name="option54" placeholder="incorrect answer" required class="box">
         <hr style="border: none; height: 4px; color: #333; background-color: #333;">
         <p>question 6 <span>*</span></p>
         <input value="<?= @$soal6[0] ?>" style="border:solid white;" type="text" name="question6" placeholder="question" required class="box">
         <input value="<?= @$soal6[1] ?>" style="border:solid green;" type="text" name="option61" placeholder="correct answer" required class="box">
         <input value="<?= @$soal6[2] ?>" style="border:solid red;" type="text" name="option62" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal6[3] ?>" style="border:solid red;" type="text" name="option63" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal6[4] ?>" style="border:solid red;" type="text" name="option64" placeholder="incorrect answer" required class="box">
         <hr style="border: none; height: 4px; color: #333; background-color: #333;">
         <p>question 7 <span>*</span></p>
         <input value="<?= @$soal7[0] ?>" style="border:solid white;" type="text" name="question7" placeholder="question" required class="box">
         <input value="<?= @$soal7[1] ?>" style="border:solid green;" type="text" name="option71" placeholder="correct answer" required class="box">
         <input value="<?= @$soal7[2] ?>" style="border:solid red;" type="text" name="option72" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal7[3] ?>" style="border:solid red;" type="text" name="option73" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal7[4] ?>" style="border:solid red;" type="text" name="option74" placeholder="incorrect answer" required class="box">
         <hr style="border: none; height: 4px; color: #333; background-color: #333;">
         <p>question 8 <span>*</span></p>
         <input value="<?= @$soal8[0] ?>" style="border:solid white;" type="text" name="question8" placeholder="question" required class="box">
         <input value="<?= @$soal8[1] ?>" style="border:solid green;" type="text" name="option81" placeholder="correct answer" required class="box">
         <input value="<?= @$soal8[2] ?>" style="border:solid red;" type="text" name="option82" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal8[3] ?>" style="border:solid red;" type="text" name="option83" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal8[4] ?>" style="border:solid red;" type="text" name="option84" placeholder="incorrect answer" required class="box">
         <hr style="border: none; height: 4px; color: #333; background-color: #333;">
         <p>question 9 <span>*</span></p>
         <input value="<?= @$soal9[0] ?>" style="border:solid white;" type="text" name="question9" placeholder="question" required class="box">
         <input value="<?= @$soal9[1] ?>" style="border:solid green;" type="text" name="option91" placeholder="correct answer" required class="box">
         <input value="<?= @$soal9[2] ?>" style="border:solid red;" type="text" name="option92" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal9[3] ?>" style="border:solid red;" type="text" name="option93" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal9[4] ?>" style="border:solid red;" type="text" name="option94" placeholder="incorrect answer" required class="box">
         <hr style="border: none; height: 4px; color: #333; background-color: #333;">
         <p>question 10 <span>*</span></p>
         <input value="<?= @$soal10[0] ?>" style="border:solid white;" type="text" name="question10" placeholder="question" required class="box">
         <input value="<?= @$soal10[1] ?>" style="border:solid green;" type="text" name="option101" placeholder="correct answer" required class="box">
         <input value="<?= @$soal10[2] ?>" style="border:solid red;" type="text" name="option102" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal10[3] ?>" style="border:solid red;" type="text" name="option103" placeholder="incorrect answer" required class="box">
         <input value="<?= @$soal10[4] ?>" style="border:solid red;" type="text" name="option104" placeholder="incorrect answer" required class="box">


         <input type="submit" value="submit" name="editquiz" class="btn">
      </form>

   </section>

   <?php
   require "views/partials/foot.php";
   ?>
</body>

</html>

<?php
if (isset($_POST['editquiz'])) {
   $question1 = @$_POST['question1'];
   $question2 = @$_POST['question2'];
   $question3 = @$_POST['question3'];
   $question4 = @$_POST['question4'];
   $question5 = @$_POST['question5'];
   $question6 = @$_POST['question6'];
   $question7 = @$_POST['question7'];
   $question8 = @$_POST['question8'];
   $question9 = @$_POST['question9'];
   $question10 = @$_POST['question10'];
   $option11 = @$_POST['option11'];
   $option12 = @$_POST['option12'];
   $option13 = @$_POST['option13'];
   $option14 = @$_POST['option14'];
   $option21 = @$_POST['option21'];
   $option31 = @$_POST['option31'];
   $option41 = @$_POST['option41'];
   $option51 = @$_POST['option51'];
   $option61 = @$_POST['option61'];
   $option71 = @$_POST['option71'];
   $option81 = @$_POST['option81'];
   $option91 = @$_POST['option91'];
   $option101 = @$_POST['option101'];
   $option22 = @$_POST['option22'];
   $option22 = @$_POST['option22'];
   $option32 = @$_POST['option32'];
   $option32 = @$_POST['option32'];
   $option42 = @$_POST['option42'];
   $option42 = @$_POST['option42'];
   $option52 = @$_POST['option52'];
   $option52 = @$_POST['option52'];
   $option62 = @$_POST['option62'];
   $option62 = @$_POST['option62'];
   $option72 = @$_POST['option72'];
   $option72 = @$_POST['option72'];
   $option82 = @$_POST['option82'];
   $option82 = @$_POST['option82'];
   $option92 = @$_POST['option92'];
   $option92 = @$_POST['option92'];
   $option102 = @$_POST['option102'];
   $option23 = @$_POST['option23'];
   $option23 = @$_POST['option23'];
   $option33 = @$_POST['option33'];
   $option33 = @$_POST['option33'];
   $option43 = @$_POST['option43'];
   $option43 = @$_POST['option43'];
   $option53 = @$_POST['option53'];
   $option53 = @$_POST['option53'];
   $option63 = @$_POST['option63'];
   $option63 = @$_POST['option63'];
   $option73 = @$_POST['option73'];
   $option73 = @$_POST['option73'];
   $option83 = @$_POST['option83'];
   $option83 = @$_POST['option83'];
   $option93 = @$_POST['option93'];
   $option93 = @$_POST['option93'];
   $option103 = @$_POST['option103'];
   $option24 = @$_POST['option24'];
   $option24 = @$_POST['option24'];
   $option34 = @$_POST['option34'];
   $option34 = @$_POST['option34'];
   $option44 = @$_POST['option44'];
   $option44 = @$_POST['option44'];
   $option54 = @$_POST['option54'];
   $option54 = @$_POST['option54'];
   $option64 = @$_POST['option64'];
   $option64 = @$_POST['option64'];
   $option74 = @$_POST['option74'];
   $option74 = @$_POST['option74'];
   $option84 = @$_POST['option84'];
   $option84 = @$_POST['option84'];
   $option94 = @$_POST['option94'];
   $option94 = @$_POST['option94'];
   $option104 = @$_POST['option104'];
   $da = mysqli_query($conn, "SELECT * FROM quizs WHERE id_playlist = $link[3]");
   $data_quiz = $question1 . '`' . $option11 . '`' . $option12 . '`' . $option13 . '`' . $option14 . '|' . $question2 . '`' . $option21 . '`' . $option22 . '`' . $option23 . '`' . $option24 . '|' . $question3 . '`' . $option31 . '`' . $option32 . '`' . $option33 . '`' . $option34 . '|' . $question4 . '`' . $option41 . '`' . $option42 . '`' . $option43 . '`' . $option44 . '|' . $question5 . '`' . $option51 . '`' . $option52 . '`' . $option53 . '`' . $option54 . '|' . $question6 . '`' . $option61 . '`' . $option62 . '`' . $option63 . '`' . $option64 . '|' . $question7 . '`' . $option71 . '`' . $option72 . '`' . $option73 . '`' . $option74 . '|' . $question8 . '`' . $option81 . '`' . $option82 . '`' . $option83 . '`' . $option84 . '|' . $question9 . '`' . $option91 . '`' . $option92 . '`' . $option93 . '`' . $option94 . '|' . $question10 . '`' . $option101 . '`' . $option102 . '`' . $option103 . '`' . $option104;
   if (mysqli_num_rows($da) == 0) {
      mysqli_query($conn, "INSERT INTO quizs (quiz, id_playlist) VALUES ('$data_quiz', $link[3])");
      echo "<script>
         window.location.href = '../editquiz/$link[3]';
      </script>";
   } else {
      mysqli_query($conn, "UPDATE quizs SET quiz = '$data_quiz' WHERE id_playlist = $link[3]");
      echo "<script>
         window.location.href = '../editquiz/$link[3]';
      </script>";
   }
}
?>