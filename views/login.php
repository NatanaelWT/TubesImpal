<?php
require "views/partials/head.php";
?>

<?php
include 'views/partials/conn.php';
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

$pass = 0;
if (isset($_POST['login'])) {
   $email = $_POST['email'];
   $password = $_POST['password'];

   $sql = "SELECT id, name, password, level, profile_image, email FROM users WHERE email = ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("s", $email);
   $stmt->execute();
   $stmt->store_result();

   if ($stmt->num_rows > 0) {
      $stmt->bind_result($id, $name, $hashed_password, $level, $profile_image, $email);
      $stmt->fetch();

      if (password_verify($password, $hashed_password)) {
         $_SESSION['user_id'] = $id;
         $_SESSION['user_name'] = $name;
         $_SESSION['email'] = $email;
         $_SESSION['level'] = $level;
         $_SESSION['profile_image'] = $profile_image;
         header("Location: courses");
      } else {
         $pass = 1;
         // echo "Invalid password.";
      }
   } else {
      $pass = 1;
      // echo "No user found with that email.";
   }

   $stmt->close();
}

$conn->close();
?>

<body class="active">
   <?php
   require "views/partials/header.php";
   ?>

   <section class="form-container">

      <?php
      if ($pass == 1) {
         echo '<form style="border: solid red;" action="" method="post" enctype="multipart/form-data">';
      }else{
         echo '<form action="" method="post" enctype="multipart/form-data">';
      }
      ?>
         <h3>login now</h3>
         <p>your email <span>*</span></p>
         <input type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
         <p>your password <span>*</span></p>
         <input type="password" name="password" placeholder="enter your password" required maxlength="20" class="box">
         <input type="submit" value="login" name="login" class="btn">
         <?php
         if ($pass == 1) {
            echo "<br><span style='color:red; font-size:medium; text-align: center;'>Username/Password Tidak Sesuai</span>";
         }
         ?>
      </form>
   </section>

   <?php
   require "views/partials/foot.php";
   ?>
</body>




</html>