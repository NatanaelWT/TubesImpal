<div class="side-bar">

    <div id="close-btn">
        <i class="fas fa-times"></i>
    </div>

    <div class="profile">
        <img src="<?= @$link[3] != "" ? "../" : "" ?><?= isset($_SESSION['profile_image']) ? "images/profile/" . $_SESSION['profile_image'] : "images/default/pic-1.jpg" ?>" class="image profile-img" alt="">
        <h3 class="name"><?= $_SESSION['user_name'] ?></h3>
        <p class="role"><?= $_SESSION['level'] ?></p>
        <?php if ($_SESSION['level'] != "Guest") { ?>
            <a href="<?= @$link[3] != "" ? "../" : "" ?>profile" class="btn">view profile</a>
        <?php } ?>
    </div>

    <nav class="navbar">
        <!-- <a href="<?= @$link[3] != "" ? "../" : "" ?>home"><i class="fas fa-home"></i><span>Home</span></a> -->
        <!-- <a href="about"><i class="fas fa-question"></i><span>about</span></a> -->
        <a href="<?= @$link[3] != "" ? "../" : "" ?>courses"><i class="fas fa-graduation-cap"></i><span>Courses</span></a>
        <a href="<?= @$link[3] != "" ? "../" : "" ?>teachers"><i class="fas fa-chalkboard-user"></i><span>Teachers</span></a>
        <a href="<?= @$link[3] != "" ? "../" : "" ?>games"><i class="fas fa-gamepad"></i><span>Games</span></a>
        <?php if ($_SESSION['level'] == "Teacher") { ?>
            <a href="<?= @$link[3] != "" ? "../" : "" ?>myplaylist"><i class="fas fa-plus"></i><span>Create Course</span></a>
        <?php } ?>
        <!-- <a href="contact"><i class="fas fa-headset"></i><span>contact us</span></a> -->
    </nav>

</div>