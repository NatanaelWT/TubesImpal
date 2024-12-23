<?php
require "views/partials/head.php";
?>

<body>
    <?php
    require "views/partials/header.php";
    require "views/partials/sidebar.php";
    ?>
    <style>
        .container-counting {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            margin-top: 30px;
        }

        .draggable {
            width: 40px;
            height: 40px;
            background-color: #4CAF50;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
            cursor: move;
        }

        .dropzone {
            width: 270px;
            height: 115px;
            background-color: #d3d3d3;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            grid-auto-rows: 40px;
            gap: 10px;
            justify-content: center;
            align-items: center;
            border: 2px dashed #888;
            padding: 10px;
            box-sizing: border-box;
        }

        .draggables-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            grid-auto-rows: 40px;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }

        .button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #45a049;
        }

        .score-progress {
            display: flex;
            gap: 20px;
            font-size: 18px;
        }

        .hidden {
            display: hidden;
        }
    </style>
    <section class="courses">
        <h1 class="heading">Berhitung</h1>
        <h1 class="" style="text-align:center; color:var(--black);">Pindahkan kotak sesuai dengan jawaban soal dibawah!!</h1>
        <div id="counting" class="container-counting">
            <div class="heading" style="border:none; margin-bottom:0; padding-bottom: 0;" id="question"></div>
            <div class="dropzone" id="dropzone1"></div>
            <button class="button" id="checkAnswer">Check Answer</button>
            <div id="result"></div>
            <div class="draggables-container" id="draggablesContainer">
                <div class="draggable" id="drag1" draggable="true"></div>
                <div class="draggable" id="drag2" draggable="true"></div>
                <div class="draggable" id="drag3" draggable="true"></div>
                <div class="draggable" id="drag4" draggable="true"></div>
                <div class="draggable" id="drag5" draggable="true"></div>
                <div class="draggable" id="drag6" draggable="true"></div>
                <div class="draggable" id="drag7" draggable="true"></div>
                <div class="draggable" id="drag8" draggable="true"></div>
                <div class="draggable" id="drag9" draggable="true"></div>
                <div class="draggable" id="drag10" draggable="true"></div>
            </div>
            <p class="heading" id="score2" style="text-align:center; border:none;">Score: <span id="currentScore">0</span></p>
            <p id="text2" class="heading" style="text-align:center; border:none;">Progress: <span id="currentProgress">1</span>/10</p>
        </div>
        <div id="endgame" class="hidden" style="text-align:center;">
            <h1 class="heading" style="border:none;">Permainan Selesai!</h1>
            <p class="heading" style="border:none;">Skor Akhir Anda: <span id="final-score"></span></p>
            <button class="inline-btn" onclick="window.location.href='counting'">Main Lagi</button>
        </div>
        <audio id="correctSound" src="audio/correct.mp3" preload="auto"></audio>
        <audio id="wrongSound" src="audio/wrong.mp3" preload="auto"></audio>
        <audio id="applauseSound" src="audio/applause.mp3" preload="auto"></audio>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const draggables = document.querySelectorAll('.draggable');
                const dropzone = document.getElementById('dropzone1');
                const checkButton = document.getElementById('checkAnswer');
                const resultDiv = document.getElementById('result');
                const questionDiv = document.getElementById('question');
                const draggablesContainer = document.getElementById('draggablesContainer');
                const currentScoreDiv = document.getElementById('currentScore');
                const currentProgressDiv = document.getElementById('currentProgress');

                let num1, num2, correctAnswer;
                let score = 0;
                let questionsAnswered = 0;
                const totalQuestions = 10;

                function generateQuestion() {
                    num1 = Math.floor(Math.random() * 5) + 1;
                    num2 = Math.floor(Math.random() * 5) + 1;
                    correctAnswer = num1 + num2;
                    questionDiv.textContent = `${num1} + ${num2} = `;
                }

                function resetGame() {
                    dropzone.innerHTML = '';
                    draggables.forEach(draggable => {
                        draggablesContainer.appendChild(draggable);
                    });
                    resultDiv.textContent = '';
                    generateQuestion();
                    updateScoreProgress();
                }

                function checkAnswer() {
                    if (questionsAnswered <= totalQuestions) {
                        if (dropzone.childElementCount === correctAnswer) {
                            document.getElementById("correctSound").play();
                            resultDiv.textContent = 'Correct!';
                            resultDiv.style.color = 'green';
                            score++;
                        } else {
                            document.getElementById("wrongSound").play();
                            resultDiv.textContent = 'Try Again!';
                            resultDiv.style.color = 'red';
                        }

                        questionsAnswered++;
                        updateScoreProgress();
                        setTimeout(resetGame, 1000);
                        if (questionsAnswered == totalQuestions) {
                            setTimeout(() => {
                                endGame();
                            }, 1000);
                        }
                    }
                }

                function updateScoreProgress() {
                    currentScoreDiv.textContent = `${score}`;
                    questionsAnswered2 = questionsAnswered+1;
                    currentProgressDiv.textContent = `${questionsAnswered2}`;
                }

                generateQuestion();

                draggables.forEach(draggable => {
                    draggable.addEventListener('dragstart', dragStart);
                });

                dropzone.addEventListener('dragover', dragOver);
                dropzone.addEventListener('drop', drop);

                checkButton.addEventListener('click', checkAnswer);

                function dragStart(event) {
                    event.dataTransfer.setData('text/plain', event.target.id);
                }

                function dragOver(event) {
                    event.preventDefault();
                }

                function drop(event) {
                    event.preventDefault();
                    const id = event.dataTransfer.getData('text/plain');
                    const draggable = document.getElementById(id);
                    dropzone.appendChild(draggable);
                }

                function endGame() {
                    document.getElementById("draggablesContainer").classList.add("hidden");
                    document.getElementById("dropzone1").classList.add("hidden");
                    document.getElementById("question").classList.add("hidden");
                    document.getElementById("checkAnswer").classList.add("hidden");
                    document.getElementById("applauseSound").play();
                    document.getElementById("endgame").classList.remove("hidden");
                    document.getElementById("final-score").textContent = score;
                    document.getElementById("counting").innerHTML = "";
                }

            });
        </script>
    </section>
    <?php
    require "views/partials/foot.php";
    ?>
</body>

</html>