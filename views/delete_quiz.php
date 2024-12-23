<?php
include 'views/partials/conn.php';
mysqli_query($conn, "DELETE FROM quizs where id_playlist = $link[3]");
header("location:../editquiz/$link[3]");