<?php
require "views/partials/head.php";
?>

<body>
   <?php
   require "views/partials/header.php";
   require "views/partials/sidebar.php";
   ?>

   <section class="form-container">

      <form action="" method="post" enctype="multipart/form-data">
         <h3>update profile</h3>
         <p>update name <span>*</span></p>
         <input type="text" name="name" placeholder="username" maxlength="50" class="box" required value="<?= $_SESSION['user_name'] ?>">
         <p>update email <span>*</span></p>
         <input type="email" name="email" placeholder="user@gmail.com" maxlength="50" class="box" required value="<?= $_SESSION['email'] ?>">
         <p>previous password <span>*</span></p>
         <input type="password" name="previous_password" placeholder="enter your old password" maxlength="20" class="box" required>
         <p>new password <span>*</span></p>
         <input type="password" name="new_password" placeholder="enter your old password" maxlength="20" class="box">
         <p>confirm password <span>*</span></p>
         <input type="password" name="confirm_password" placeholder="confirm your new password" maxlength="20" class="box">
         <p>update pic</p>
         <input type="file" name="profile_pic" accept="image/*" class="box">
         <input type="submit" value="update" name="update" class="btn">
      </form>

   </section>

   <?php
   require "views/partials/foot.php";
   ?>
</body>

<?php
include 'views/partials/conn.php';
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['update'])) {
   $name = $_POST['name'];
   $email = $_POST['email'];
   $previous_password = $_POST['previous_password'];
   $new_password = $_POST['new_password'];
   $confirm_password = $_POST['confirm_password'];
   $profile_pic = $_FILES['profile_pic'];
   $user_id = $_SESSION['user_id'];

   // Fetch the current password from the database
   $sql = "SELECT password, profile_image FROM users WHERE id = ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("i", $user_id);
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($current_password, $current_profile_pic);
   $stmt->fetch();

   // Verify previous password
   if (!password_verify($previous_password, $current_password)) {
      echo "Previous password is incorrect.";
      exit();
   }

   // Handle password update
   if (!empty($new_password)) {
      if ($new_password !== $confirm_password) {
         echo "New password and confirm password do not match.";
         exit();
      }
      $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
   } else {
      $hashed_password = $current_password;
   }

   // Handle profile picture upload
   if (!empty($profile_pic['name'])) {
      $target_dir = "images/profile/";
      $unique_file_name = uniqid() . "-" . basename($profile_pic["name"]);
      $target_file = $target_dir . $unique_file_name;
      move_uploaded_file($profile_pic["tmp_name"], $target_file);
   } else {
      $unique_file_name = $current_profile_pic;
   }

   // Update the database
   $sql = "UPDATE users SET name = ?, email = ?, password = ?, profile_image = ? WHERE id = ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("ssssi", $name, $email, $hashed_password, $unique_file_name, $user_id);

   if ($stmt->execute()) {
      $_SESSION['profile_image'] = $unique_file_name;
      $_SESSION['user_name'] = $name;
      $_SESSION['email'] = $email;
      echo "Profile updated successfully.";
      echo "<script>
         window.location.href = 'profile';
      </script>";
   } else {
      echo "Error updating profile: " . $stmt->error;
   }

   $stmt->close();
}

$conn->close();
?>

</html>