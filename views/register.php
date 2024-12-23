<?php
require "views/partials/head.php";
?>

<body class="active">
   <?php
   require "views/partials/header.php";
   ?>

   <section class="form-container">

      <form method="post" enctype="multipart/form-data">
         <h3>register now</h3>
         <p>your name <span>*</span></p>
         <input type="text" name="name" placeholder="enter your name" required maxlength="50" class="box">
         <p>your email <span>*</span></p>
         <input type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
         <p>your password <span>*</span></p>
         <input type="password" name="password" placeholder="enter your password" required maxlength="20" class="box">
         <p>confirm password <span>*</span></p>
         <input type="password" name="confirm_password" placeholder="confirm your password" required maxlength="20" class="box">
         <p>select profile <span>*</span></p>
         <input type="file" accept="image/*" name="profile_image" required class="box">
         <input type="submit" value="register" name="register" class="btn">
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

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $profile_image = $_FILES['profile_image']['name'];

    // Generate unique file name
    $unique_id = uniqid();
    $target_dir = "images/profile/";
    $target_file = $target_dir . $unique_id . "-" . basename($profile_image);
    $target_file2 = $unique_id . "-" . basename($profile_image);

    if ($password != $confirm_password) {
        echo "Passwords do not match.";
    } elseif (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password, profile_image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $target_file2);

        if ($stmt->execute()) {
            echo "Registration successful.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}

$conn->close();
?>



</html>