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
            <h3>add video</h3>
            <p>video title<span>*</span></p>
            <input type="text" name="video_title" placeholder="enter your name" required maxlength="50" class="box">
            <p>select thumbnail<span>*</span></p>
            <input type="file" accept="image/*" name="video_thumbnail" required class="box">
            <p>select video<span>*</span></p>
            <input type="file" accept="video/*" name="video" required class="box">
            <input type="submit" value="add Video" name="addvideo" class="btn">
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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addvideo'])) {
    $video_title = $_POST['video_title'];
    $thumbnail = $_FILES['video_thumbnail'];
    $video = $_FILES['video'];

    // Handle thumbnail upload
    $thumbnail_dir = "images/video/";
    $thumbnailFileType = strtolower(pathinfo($thumbnail["name"], PATHINFO_EXTENSION));
    $unique_thumbnail_name = uniqid('thumb_', true) . '.' . $thumbnailFileType;
    $thumbnail_file = $thumbnail_dir . $unique_thumbnail_name;

    // Handle video upload
    $video_dir = "videos/watch/";
    $videoFileType = strtolower(pathinfo($video["name"], PATHINFO_EXTENSION));
    $unique_video_name = uniqid('video_', true) . '.' . $videoFileType;
    $video_file = $video_dir . $unique_video_name;

    $uploadOk = 1;

    // Check thumbnail file size
    if ($thumbnail["size"] > 5000000) { // 5MB limit
        echo "Sorry, your thumbnail file is too large.";
        $uploadOk = 0;
    }

    // Check video file size
    if ($video["size"] > 50000000) { // 50MB limit
        echo "Sorry, your video file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats for thumbnail
    if (!in_array($thumbnailFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed for thumbnail.";
        $uploadOk = 0;
    }

    // Allow certain file formats for video
    if (!in_array($videoFileType, ['mp4', 'avi', 'mkv', 'mov', 'wmv'])) {
        echo "Sorry, only MP4, AVI, MKV, MOV & WMV files are allowed for video.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Attempt to move the uploaded thumbnail file to the server
        if (move_uploaded_file($thumbnail["tmp_name"], $thumbnail_file)) {
            // Attempt to move the uploaded video file to the server
            if (move_uploaded_file($video["tmp_name"], $video_file)) {
                // Prepare SQL and bind parameters
                $stmt = $conn->prepare("INSERT INTO videos (id_playlist, video_title, video_thumbnail, video) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("isss", $link[3], $video_title, $unique_thumbnail_name, $unique_video_name);

                if ($stmt->execute()) {
                    // echo "The video has been uploaded successfully.";
                    echo "<script>window.location.href = '../playlist/$link[3]';</script>";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your video file.";
            }
        } else {
            echo "Sorry, there was an error uploading your thumbnail file.";
        }
    }
}

$conn->close();
?>



</html>