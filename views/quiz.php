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
    $stmt = $conn->prepare("SELECT quiz FROM quizs WHERE id_playlist = ?");
    $stmt->bind_param("i", $link[3]);
    $stmt->execute();
    $stmt->bind_result($quiz);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    $list_quiz = explode("|", $quiz);
    ?>
    <section style="padding:0;">
        <!-- <div style="position: relative; overflow: hidden; width: 100%; padding-top: 56.25%;">
            <iframe style="position: absolute; top: 0; left: 0; bottom: 0; right: 0; width: 100%; height: 100%;" class="embed-responsive-item" src="quizframe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div> -->
        <div class="container-quiz">
            <div id="loader"></div>
            <div id="game" class="justify-center flex-column hidden">
                <div id="hud">
                    <div id="hud-item">
                        <p id="progressText" class="hud-prefix">
                            Question
                        </p>
                        <div id="progressBar">
                            <div id="progressBarFull"></div>
                        </div>
                    </div>
                    <div id="hud-item">
                        <p class="hud-prefix">
                            Score
                        </p>
                        <h1 class="hud-main-text" id="score">
                            0
                        </h1>
                    </div>
                </div>
                <h2 id="question"></h2>
                <div class="choice-container">
                    <p class="choice-prefix">A</p>
                    <p class="choice-text" data-number="1"></p>
                </div>
                <div class="choice-container">
                    <p class="choice-prefix">B</p>
                    <p class="choice-text" data-number="2"></p>
                </div>
                <div class="choice-container">
                    <p class="choice-prefix">C</p>
                    <p class="choice-text" data-number="3"></p>
                </div>
                <div class="choice-container">
                    <p class="choice-prefix">D</p>
                    <p class="choice-text" data-number="4"></p>
                </div>
            </div>
        </div>

        <audio id="correctSound" src="../audio/correct.mp3" preload="auto"></audio>
        <audio id="wrongSound" src="../audio/wrong.mp3" preload="auto"></audio>
    </section>

    <?php
    require "views/partials/foot.php";
    ?>
    <script>
        const question = document.getElementById('question');
        const choices = Array.from(document.getElementsByClassName('choice-text'));
        const progressText = document.getElementById('progressText');
        const scoreText = document.getElementById('score');
        const progressBarFull = document.getElementById('progressBarFull');
        const loader = document.getElementById('loader');
        const game = document.getElementById('game');
        let currentQuestion = {};
        let acceptingAnswers = false;
        let score = 0;
        let questionCounter = 0;
        let availableQuestions = [];

        // Definisi pertanyaan dalam objek JavaScript
        let questions = [
            <?php foreach ($list_quiz as $x) {
                $temp = explode("`", $x);
            ?> {
                    question: "<?= $temp['0'] ?>",
                    choice1: "<?= $temp['1'] ?>",
                    choice2: "<?= $temp['2'] ?>",
                    choice3: "<?= $temp['3'] ?>",
                    choice4: "<?= $temp['4'] ?>",
                    answer: 1
                },
            <?php } ?>
        ];

        // Fungsi untuk mengacak array
        function shuffle(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        // Fungsi untuk memulai permainan
        startGame = () => {
            questionCounter = 0;
            score = 0;
            availableQuestions = [...questions];
            getNewQuestion();
            game.classList.remove('hidden');
            loader.classList.add('hidden');
        };

        // Fungsi untuk mendapatkan pertanyaan baru
        getNewQuestion = () => {
            if (availableQuestions.length === 0 || questionCounter >= MAX_QUESTIONS) {
                localStorage.setItem('mostRecentScore', score);
                return window.location.assign('<?= @$link[3] != "" ? "../" : "" ?>score/<?= $link[3] ?>');
            }
            questionCounter++;
            progressText.innerText = `Question ${questionCounter}/${MAX_QUESTIONS}`;
            progressBarFull.style.width = `${(questionCounter / MAX_QUESTIONS) * 100}%`;

            const questionIndex = Math.floor(Math.random() * availableQuestions.length);
            currentQuestion = availableQuestions[questionIndex];
            question.innerHTML = currentQuestion.question;

            // Buat array pilihan
            const choicesArray = [{
                    text: currentQuestion.choice1,
                    number: 1
                },
                {
                    text: currentQuestion.choice2,
                    number: 2
                },
                {
                    text: currentQuestion.choice3,
                    number: 3
                },
                {
                    text: currentQuestion.choice4,
                    number: 4
                }
            ];

            // Acak urutan pilihan
            const shuffledChoices = shuffle(choicesArray);

            choices.forEach((choice, index) => {
                const number = shuffledChoices[index].number;
                choice.innerHTML = shuffledChoices[index].text;
                choice.dataset['number'] = number;
            });

            availableQuestions.splice(questionIndex, 1);
            acceptingAnswers = true;
        };

        // Event listener untuk pilihan jawaban
        choices.forEach((choice) => {
            choice.addEventListener('click', (e) => {
                if (!acceptingAnswers) return;

                acceptingAnswers = false;
                const selectedChoice = e.target;
                const selectedAnswer = selectedChoice.dataset['number'];

                const classToApply = selectedAnswer == currentQuestion.answer ? 'correct' : 'incorrect';

                if (classToApply === 'incorrect') {
                    document.getElementById("wrongSound").play();
                }
                if (classToApply === 'correct') {
                    document.getElementById("correctSound").play();
                    incrementScore(CORRECT_BONUS);
                }

                selectedChoice.parentElement.classList.add(classToApply);

                setTimeout(() => {
                    selectedChoice.parentElement.classList.remove(classToApply);
                    getNewQuestion();
                }, 1000);
            });
        });

        // Fungsi untuk menambah skor
        incrementScore = (num) => {
            score += num;
            scoreText.innerText = score;
        };

        // Konstanta
        const CORRECT_BONUS = 10;
        const MAX_QUESTIONS = 10;

        // Memulai permainan
        startGame();
    </script>
</body>

</html>