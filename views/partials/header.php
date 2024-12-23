<header class="header">

    <section class="flex">

        <a href="/<?= $link[1] ?>" class="logo">BrainyB</a>
        <?php if ($link[2] != '' && $link[2] != 'login' && $link[2] != 'register') { ?>
            <!-- <form action="search" method="post" class="search-form">
                <input type="text" name="search_box" required placeholder="search courses..." maxlength="100">
                <button type="submit" class="fas fa-search"></button>
            </form> -->
        <?php } ?>
        <div class="icons">
            <?php if ($link[2] != '' && $link[2] != 'login' && $link[2] != 'register') { ?>
                <div id="menu-btn" class="fas fa-bars"></div>
            <?php } ?>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
        </div>

        <div class="profile">
            <?php if ($link[2] != '' && $link[2] != 'login' && $link[2] != 'register') { ?>
                <img src="<?= @$link[3] != "" ? "../" : "" ?><?= isset($_SESSION['profile_image']) ? "images/profile/" . $_SESSION['profile_image'] : "images/default/pic-1.jpg" ?>" class="image profile-img" alt="">
                <h3 class="name"><?= $_SESSION['user_name'] ?></h3>
                <p class="role"><?= $_SESSION['level'] ?></p>
                <!-- <a href="profile" class="btn">view profile</a> -->
            <?php } ?>
            <?php if (!isset($_SESSION['user_name'])) { ?>
                <form method="post">
                    <input type="text" name="guest_username" placeholder="enter your username" required maxlength="50" class="box login-guest">
                    <button href="login" name="login-guest" value="loginguest" class="btn">Login as a Guest</button>
                </form>
            <?php } ?>
            <div class="flex-btn" style="padding-top:20px;">

                <?php if (isset($_SESSION['user_name'])) { ?>
                    <?php if ($_SESSION['level'] != "Guest") { ?>
                        <a href="<?= @$link[3] != "" ? "../" : "" ?>profile" class="option-btn">Profile</a>
                    <?php } ?>
                    <form method="post" style="margin:auto;"><button value="logout" name="logout" type="submit" class="delete-btn">logout</button></form>
                <?php } else {
                ?>

                    <a href="login" class="option-btn">login</a>
                    <a href="register" class="option-btn">register</a>
                <?php
                } ?>

            </div>
        </div>

    </section>

</header>

<?php
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
?>
    <script>
        window.location.href = '<?= @$link[3] != "" ? "../" : "" ?>login';
    </script>
<?php
}
if (isset($_POST['login-guest'])) {
    $_SESSION['user_name'] = $_POST['guest_username'];
    $_SESSION['level'] = "Guest";
    header("Refresh:0");
}
?>