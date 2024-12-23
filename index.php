<?php
session_start();
$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';
// var_dump($request);
$link = explode("/", $request);
// var_dump($link[1]);
// var_dump(__DIR__);

switch ($link[2]) {
    case '':
        if (isset($_SESSION['user_name'])) {
            header("location:courses");
        } else {
            require __DIR__ . $viewDir . 'hero.php';
        }
        break;
    // case 'home':
    //     if (isset($_SESSION['user_name'])) {
    //         require __DIR__ . $viewDir . 'home.php';
    //     } else {
    //         header("location:login");
    //     }
    //     break;
        // case 'contact':
        //     require __DIR__ . $viewDir . 'contact.php';
        //     break;
        // case 'about':
        //     require __DIR__ . $viewDir . 'about.php';
        //     break;
    case 'courses':
        if (isset($_SESSION['user_name'])) {
            require __DIR__ . $viewDir . 'courses.php';
        } else {
            header("location:login");
        }
        break;
    case 'games':
        if (isset($_SESSION['user_name'])) {
            require __DIR__ . $viewDir . 'games.php';
        } else {
            header("location:login");
        }
        break;
    case 'completetheword':
        if (isset($_SESSION['user_name'])) {
            require __DIR__ . $viewDir . 'games/completetheword/complete_the_word.php';
        } else {
            header("location:login");
        }
        break;
    case 'constructword':
        if (isset($_SESSION['user_name'])) {
            require __DIR__ . $viewDir . 'games/constructword/construct_word.php';
        } else {
            header("location:login");
        }
        break;
    case 'counting':
        if (isset($_SESSION['user_name'])) {
            require __DIR__ . $viewDir . 'games/counting/counting.php';
        } else {
            header("location:login");
        }
        break;
    case 'selectconstructword':
        if (isset($_SESSION['user_name'])) {
            require __DIR__ . $viewDir . 'games/constructword/select_construct_word.php';
        } else {
            header("location:login");
        }
        break;
    case 'selectcompletetheword':
        if (isset($_SESSION['user_name'])) {
            require __DIR__ . $viewDir . 'games/completetheword/select_complete_the_word.php';
        } else {
            header("location:login");
        }
        break;
    case 'login':
        if (isset($_SESSION['user_name'])) {
            header("location:courses");
        } else {
            require __DIR__ . $viewDir . 'login.php';
        }
        break;
    case 'playlist':
        if (isset($_SESSION['user_name'])) {
            require __DIR__ . $viewDir . 'playlist.php';
        } else {
            header("location:../login");
        }
        break;
    case 'profile':
        if (isset($_SESSION['user_name'])) {
            if ($_SESSION['level'] == "Guest") {
                header("location:courses");
            } else {
                require __DIR__ . $viewDir . 'profile.php';
            }
        } else {
            header("location:login");
        }
        break;
    case 'register':
        if (isset($_SESSION['user_name'])) {
            header("location:courses");
        } else {
            require __DIR__ . $viewDir . 'register.php';
        }
        break;
    case 'teacher':
        if (isset($_SESSION['user_name'])) {
            require __DIR__ . $viewDir . 'teacher_profile.php';
        } else {
            header("location:login");
        }
        break;
    case 'teachers':
        if (isset($_SESSION['user_name'])) {
            require __DIR__ . $viewDir . 'teachers.php';
        } else {
            header("location:login");
        }
        break;
    case 'update':
        if (isset($_SESSION['user_name'])) {
            if ($_SESSION['level'] == "Guest") {
                header("location:courses");
            } else {
                require __DIR__ . $viewDir . 'update.php';
            }
        } else {
            header("location:login");
        }
        break;
    case 'watch':
        if (isset($_SESSION['user_name'])) {
            require __DIR__ . $viewDir . 'watch_video.php';
        } else {
            header("location:login");
        }
        break;
    case 'quiz':
        if (isset($_SESSION['user_name'])) {
            require __DIR__ . $viewDir . 'quiz.php';
        } else {
            header("location:login");
        }
        break;
    case 'score':
        if (isset($_SESSION['user_name'])) {
            require __DIR__ . $viewDir . 'score.php';
        } else {
            header("location:login");
        }
        break;
    case 'highscore':
        if (isset($_SESSION['user_name'])) {
            require __DIR__ . $viewDir . 'high_score.php';
        } else {
            header("location:login");
        }
        break;
    case 'myplaylist':
        if (@$_SESSION['level'] == 'Teacher') {
            require __DIR__ . $viewDir . 'my_playlist.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }
        break;
    case 'addplaylist':
        if ($_SESSION['level'] == 'Teacher') {
            require __DIR__ . $viewDir . 'add_playlist.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }
        break;
    case 'addvideo':
        if ($_SESSION['level'] == 'Teacher') {
            require __DIR__ . $viewDir . 'add_video.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }
        break;
    case 'editvideo':
        if ($_SESSION['level'] == 'Teacher') {
            require __DIR__ . $viewDir . 'edit_video.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }
        break;
    case 'editplaylist':
        if ($_SESSION['level'] == 'Teacher') {
            require __DIR__ . $viewDir . 'edit_playlist.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }
        break;
    case 'editquiz':
        if ($_SESSION['level'] == 'Teacher') {
            require __DIR__ . $viewDir . 'edit_quiz.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }
        break;
    case 'deletequiz':
        if ($_SESSION['level'] == 'Teacher') {
            require __DIR__ . $viewDir . 'delete_quiz.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }
        break;
    case 'deleteplaylist':
        if ($_SESSION['level'] == 'Teacher') {
            require __DIR__ . $viewDir . 'delete_playlist.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }
        break;
    case 'deletevideo':
        if ($_SESSION['level'] == 'Teacher') {
            require __DIR__ . $viewDir . 'delete_video.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }
        break;

    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}
