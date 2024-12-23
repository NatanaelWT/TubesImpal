<?php
include 'views/partials/conn.php';
mysqli_query($conn, "DELETE FROM playlists where id_playlist = $link[3]");
header("location:../myplaylist");