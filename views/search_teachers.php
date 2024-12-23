<?php
include 'partials/conn.php';

// Jika ada parameter pencarian (search_box)
if (isset($_GET['search_box']) && !empty($_GET['search_box'])) {
    $search_query = "%" . $_GET['search_box'] . "%";  // Membuat query pencarian dengan wildcard

    // Menyiapkan query untuk mencari guru berdasarkan nama
    $sql = "SELECT id, name, profile_image FROM users WHERE level = 'Teacher' AND name LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $search_query);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $profile_image);

    $output = '';  // Menampung hasil pencarian

    // Mengambil data guru dan menghitung jumlah playlist dan video per guru
    if ($stmt->num_rows > 0) {  // Jika ada data guru yang ditemukan
        while ($stmt->fetch()) {
            $sql2 =  "SELECT COUNT(id_playlist) AS playlist_count FROM playlists WHERE id_teacher = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param('i', $id);
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($p_count);
            $stmt2->fetch();

            $sql4 = "SELECT id_playlist FROM playlists WHERE id_teacher = ?";
            $stmt4 = $conn->prepare($sql4);
            $stmt4->bind_param('i', $id);
            $stmt4->execute();
            $stmt4->store_result();
            $stmt4->bind_result($id_p);

            $vid = 0;
            while ($stmt4->fetch()) {
                $sql3 = "SELECT COUNT(id_video) FROM videos WHERE id_playlist = ?";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->bind_param('i', $id_p);
                $stmt3->execute();
                $stmt3->store_result();
                $stmt3->bind_result($v_count);
                $stmt3->fetch();
                $vid += $v_count;
                $stmt3->close();
            }
            $stmt4->close();

            // Membuat HTML untuk setiap guru dan data terkait
            $output .= '
                <div class="box">
                    <div class="tutor">
                        <img src="images/profile/' . htmlspecialchars($profile_image) . '" alt="" style="object-fit: cover;">
                        <div>
                            <h3>' . htmlspecialchars($name) . '</h3>
                            <span>Teacher</span>
                        </div>
                    </div>
                    <p>total playlists: <span>' . $p_count . '</span></p>
                    <p>total videos: <span>' . $vid . '</span></p>
                    <a href="teacher/' . htmlspecialchars($id) . '" class="inline-btn">view profile</a>
                </div>';
        }

        // Menutup statement
        $stmt2->close();
        $stmt->close();
        $conn->close();

        // Mengembalikan hasil pencarian sebagai HTML
        echo $output;
    } else {
        // Jika tidak ada guru yang ditemukan
        echo '<div class="box">
        <div class="tutor">
            
            <div>
                <h3>Data Guru Tidak Ditemukan</h3>
                <span>Teacher</span>
            </div>
        </div>
        <p>total playlists: <span>-</span></p>
        <p>total videos: <span>-</span></p>
        <a href="" class="inline-btn">-</a>
    </div>';
    }
} else {
    // Jika tidak ada parameter pencarian, tampilkan semua guru

    $sql = "SELECT id, name, profile_image FROM users WHERE level = 'Teacher'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $profile_image);

    $output = '';  // Menampung hasil untuk semua guru

    if ($stmt->num_rows > 0) {  // Jika ada data guru ditemukan
        while ($stmt->fetch()) {
            // Menghitung jumlah playlist dan video per guru
            $sql2 =  "SELECT COUNT(id_playlist) AS playlist_count FROM playlists WHERE id_teacher = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param('i', $id);
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($p_count);
            $stmt2->fetch();

            $sql4 = "SELECT id_playlist FROM playlists WHERE id_teacher = ?";
            $stmt4 = $conn->prepare($sql4);
            $stmt4->bind_param('i', $id);
            $stmt4->execute();
            $stmt4->store_result();
            $stmt4->bind_result($id_p);

            $vid = 0;
            while ($stmt4->fetch()) {
                $sql3 = "SELECT COUNT(id_video) FROM videos WHERE id_playlist = ?";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->bind_param('i', $id_p);
                $stmt3->execute();
                $stmt3->store_result();
                $stmt3->bind_result($v_count);
                $stmt3->fetch();
                $vid += $v_count;
                $stmt3->close();
            }
            $stmt4->close();

            // Membuat HTML untuk setiap guru dan data terkait
            $output .= '
                <div class="box">
                    <div class="tutor">
                        <img src="images/profile/' . htmlspecialchars($profile_image) . '" alt="" style="object-fit: cover;">
                        <div>
                            <h3>' . htmlspecialchars($name) . '</h3>
                            <span>Teacher</span>
                        </div>
                    </div>
                    <p>total playlists: <span>' . $p_count . '</span></p>
                    <p>total videos: <span>' . $vid . '</span></p>
                    <a href="teacher/' . htmlspecialchars($id) . '" class="inline-btn">view profile</a>
                </div>';
        }

        // Menutup statement
        $stmt2->close();
        $stmt->close();
        $conn->close();

        // Mengembalikan semua data guru sebagai HTML
        echo $output;
    } else {
        // Jika tidak ada guru yang ditemukan
        echo '<div class="box">
        <div class="tutor">
            
            <div>
                <h3>Data Guru Tidak Ditemukan</h3>
                <span>Teacher</span>
            </div>
        </div>
        <p>total playlists: <span>-</span></p>
        <p>total videos: <span>-</span></p>
        <a href="" class="inline-btn">-</a>
    </div>';
    }
}
