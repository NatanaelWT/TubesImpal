<?php
include 'views/partials/conn.php';
$playlist = $_POST['deletevideo'];

mysqli_query($conn, "DELETE FROM videos where id_video = $link[3]");
header("location:../playlist/$playlist");