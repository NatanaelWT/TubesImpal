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
    $stmt = $conn->prepare("SELECT video_title FROM videos WHERE id_video = ?");
    $stmt->bind_param("i", $link[3]);
    $stmt->execute();
    $stmt->bind_result($video_title);
    $stmt->fetch();
    $stmt->close();

    $conn->close();
    ?>

    <section class="form-container">

        <form method="post" enctype="multipart/form-data">
            <h3>edit video</h3>
            <p>video title <span>*</span></p>
            <input value="<?= $video_title ?>" type="text" name="video_title" placeholder="enter your name" required maxlength="50" class="box">
            <p>select thumbnail</p>
            <input type="file" accept="image/*" name="video_thumbnail" class="box">
            <p>select video</p>
            <input type="file" accept="video/*" name="video" class="box">
            <input type="submit" value="edit Video" name="editvideo" class="btn">
        </form>

    </section>

    <?php
    require "views/partials/foot.php";
    ?>
</body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kenosis";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editvideo'])) {
    $video_id = $link[3];
    $video_title = $_POST['video_title'];
    $thumbnail = $_FILES['video_thumbnail'];
    $video = $_FILES['video'];

    $update_fields = [];
    $params = [];
    $param_types = '';

    // Handle thumbnail upload
    if (!empty($thumbnail['name'])) {
        $thumbnail_dir = "images/video/";
        $thumbnailFileType = strtolower(pathinfo($thumbnail["name"], PATHINFO_EXTENSION));
        $unique_thumbnail_name = uniqid('thumb_', true) . '.' . $thumbnailFileType;
        $thumbnail_file = $thumbnail_dir . $unique_thumbnail_name;

        // Check thumbnail file size
        if ($thumbnail["size"] > 5000000) { // 5MB limit
            echo "Sorry, your thumbnail file is too large.";
            exit;
        }

        // Allow certain file formats for thumbnail
        if (!in_array($thumbnailFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed for thumbnail.";
            exit;
        }

        if (move_uploaded_file($thumbnail["tmp_name"], $thumbnail_file)) {
            $update_fields[] = "video_thumbnail = ?";
            $params[] = $unique_thumbnail_name;
            $param_types .= 's';
        } else {
            echo "Sorry, there was an error uploading your thumbnail file.";
            exit;
        }
    }

    // Handle video upload
    if (!empty($video['name'])) {
        $video_dir = "videos/watch/";
        $videoFileType = strtolower(pathinfo($video["name"], PATHINFO_EXTENSION));
        $unique_video_name = uniqid('video_', true) . '.' . $videoFileType;
        $video_file = $video_dir . $unique_video_name;

        // Check video file size
        if ($video["size"] > 50000000) { // 50MB limit
            echo "Sorry, your video file is too large.";
            exit;
        }

        // Allow certain file formats for video
        if (!in_array($videoFileType, ['mp4', 'avi', 'mkv', 'mov', 'wmv'])) {
            echo "Sorry, only MP4, AVI, MKV, MOV & WMV files are allowed for video.";
            exit;
        }

        if (move_uploaded_file($video["tmp_name"], $video_file)) {
            $update_fields[] = "video = ?";
            $params[] = $unique_video_name;
            $param_types .= 's';
        } else {
            echo "Sorry, there was an error uploading your video file.";
            exit;
        }
    }

    // Update video title
    $update_fields[] = "video_title = ?";
    $params[] = $video_title;
    $param_types .= 's';

    // Prepare and execute the SQL update statement
    $params[] = $video_id;
    $param_types .= 'i';

    $sql = "UPDATE videos SET " . implode(', ', $update_fields) . " WHERE id_video = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param($param_types, ...$params);

    if ($stmt->execute()) {
        echo "The video has been updated successfully.";
        header("refresh:0");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

</html>