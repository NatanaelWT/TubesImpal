<?php
require "views/partials/head.php";
?>

<body>
    <?php
    require "views/partials/header.php";
    require "views/partials/sidebar.php";
    ?>
    <?php
    include 'views/partials/conn.php';
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT playlist_name, description, thumbnail FROM playlists WHERE id_playlist = ?");
    $stmt->bind_param("i", $link[3]);
    $stmt->execute();
    $stmt->bind_result($playlist_name, $description, $thumbnail);
    $stmt->fetch();
    $stmt->close();

    $conn->close();
    ?>

    <section class="form-container">

        <form method="post" enctype="multipart/form-data">
            <h3>edit playlist</h3>
            <p>playlist name<span>*</span></p>
            <input value="<?= htmlspecialchars($playlist_name); ?>" type="text" name="playlist_name" placeholder="enter your name" required maxlength="50" class="box">
            <p>description<span>*</span></p>
            <textarea required placeholder="description" class="box" name="description" id=""><?= htmlspecialchars($description); ?></textarea>
            <!-- <input type="text" name="deskripsi" placeholder="enter your email" required maxlength="1" class="box"> -->
            <p>select thumbnail</p>
            <input type="file" accept="image/*" name="thumbnail" class="box">
            <input type="submit" value="edit playlist" name="editplaylist" class="btn">
        </form>

    </section>

    <?php
    require "views/partials/foot.php";
    ?>
</body>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kenosis";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['editplaylist'])) {
    $playlist_name = $_POST['playlist_name'];
    $description = $_POST['description'];
    $thumbnail = $_FILES['thumbnail'];
    $user_id = $_SESSION['user_id'];

    // Fetch the current password from the database
    $sql = "SELECT thumbnail FROM playlists WHERE id_playlist = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $link[3]);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($current_thumbnail);
    $stmt->fetch();

    // Handle thumbnail upload
    if (!empty($thumbnail['name'])) {
        $target_dir = "images/playlist/";
        $unique_file_name = uniqid() . "-" . basename($thumbnail["name"]);
        $target_file = $target_dir . $unique_file_name;
        move_uploaded_file($thumbnail["tmp_name"], $target_file);
    } else {
        $unique_file_name = $current_thumbnail;
    }

    // Update the database
    $sql = "UPDATE playlists SET playlist_name = ?, description = ?, thumbnail = ? WHERE id_playlist = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $playlist_name, $description, $unique_file_name, $link[3]);

    if ($stmt->execute()) {
        echo "Playlist updated successfully.";
        echo "<script>window.location.href = '../myplaylist';</script>";
    } else {
        echo "Error updating Playlist: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>


</html>