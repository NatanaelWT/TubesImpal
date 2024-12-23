<?php
require "views/partials/head.php";
?>

<body>
   <?php
   require "views/partials/header.php";
   require "views/partials/sidebar.php";
   include 'views/partials/conn.php';
   if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
   }
   ?>

   <section class="teachers">

      <h1 class="heading">expert teachers</h1>

      <!-- Form pencarian -->
      <form action="" method="post" class="search-tutor" id="search-form">
         <input type="text" name="search_box" id="search-box" placeholder="search tutors..." required maxlength="100">
         <button type="submit" class="fas fa-search" name="search_tutor" style="display:none;"></button>
      </form>

      <!-- Tempat menampilkan hasil pencarian -->
      <div class="box-container" id="teachers-list">
         <!-- Hasil pencarian akan dimasukkan di sini -->
      </div>

   </section>

   <?php
   require "views/partials/foot.php";
   ?>
</body>

<script>
   // Fungsi untuk memuat semua data guru saat halaman pertama kali dimuat
   function loadAllTeachers() {
      fetch('views/search_teachers.php')  // Memanggil search_teachers.php tanpa parameter untuk memuat semua data
         .then(response => response.text())  // Ambil respons dalam bentuk teks
         .then(data => {
            document.getElementById('teachers-list').innerHTML = data;  // Tampilkan hasil di div dengan id "teachers-list"
         })
         .catch(error => console.error('Error:', error)); // Tangani error jika ada
   }

   // Menambahkan event listener pada input pencarian
   document.getElementById('search-box').addEventListener('input', function(event) {
      let query = event.target.value; // Menangkap input pengguna

      // Pastikan hanya melakukan permintaan jika input ada
      if (query.length > 0) {
         fetchTeachers(query); // Panggil fungsi untuk melakukan pencarian
      } else {
         // Jika pencarian kosong, tampilkan semua data guru lagi
         loadAllTeachers();
      }
   });

   // Fungsi untuk melakukan pencarian dengan fetch API
   function fetchTeachers(query) {
      fetch('views/search_teachers.php?search_box=' + encodeURIComponent(query))  // Kirim request GET ke server
         .then(response => response.text())  // Ambil respons dalam bentuk teks
         .then(data => {
            document.getElementById('teachers-list').innerHTML = data;  // Tampilkan hasil di div dengan id "teachers-list"
         })
         .catch(error => console.error('Error:', error)); // Tangani error jika ada
   }

   // Memuat semua data guru saat halaman pertama kali dimuat
   window.onload = loadAllTeachers;
</script>

</html>
