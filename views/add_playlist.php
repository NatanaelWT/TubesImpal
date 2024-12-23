<?php
require "views/partials/head.php";
?>

<body>
    <?php
    require "views/partials/header.php";
    require "views/partials/sidebar.php";
    ?>

    <section class="form-container">

        <form method="post" enctype="multipart/form-data">
            <h3>add playlist</h3>
            <p>playlist name<span>*</span></p>
            <input type="text" name="playlist_name" placeholder="enter your name" required maxlength="50" class="box">
            <p>description<span>*</span></p>
            <textarea placeholder="description" class="box" name="description" id=""></textarea>
            <!-- <input type="text" name="deskripsi" placeholder="enter your email" required maxlength="1" class="box"> -->
            <p>select thumbnail<span>*</span></p>
            <input type="file" accept="image/*" name="thumbnail" required class="box">
            <input type="submit" value="add playlist" name="addplaylist" class="btn">
        </form>

    </section>

    <?php
    require "views/partials/foot.php";
    ?>
</body>

<?php
include 'views/partials/conn.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $playlist_name = $_POST['playlist_name'];
    $description = $_POST['description'];
    $thumbnail = $_FILES['thumbnail'];

    // Handle file upload
    $target_dir = "images/playlist/";
    $imageFileType = strtolower(pathinfo($thumbnail["name"], PATHINFO_EXTENSION));

    // Generate a unique file name
    $unique_file_name = uniqid('', true) . '.' . $imageFileType;
    $target_file = $target_dir . $unique_file_name;

    $uploadOk = 1;

    // Check if image file is an actual image or fake image
    $check = getimagesize($thumbnail["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($thumbnail["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    // if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    //     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    //     $uploadOk = 0;
    // }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($thumbnail["tmp_name"], $target_file)) {
            // Prepare SQL and bind parameters
            $stmt = $conn->prepare("INSERT INTO playlists (id_teacher, playlist_name, description, thumbnail) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $_SESSION['user_id'], $playlist_name, $description, $unique_file_name);

            if ($stmt->execute()) {
                // echo "The playlist has been added successfully.";
                echo "<script>window.location.href = 'myplaylist';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>



</html>