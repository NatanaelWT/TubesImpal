<?php
require "views/partials/head.php";
?>

<body>
    <style>
        .inline-btn2 {
            margin: 0 2px;
            padding: 10px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            background-color: var(--main-color);
            display: inline-block;
            border-radius: 0.5rem;
            color: #fff;
            font-size: 1.8rem;
            text-transform: capitalize;
            padding: 1rem 3rem;
            text-align: center;
            margin-top: 1rem;
        }

        .hidden {
            display: none;
        }

        .correct {
            background-color: green;
            color: white;
        }

        .incorrect {
            background-color: red;
            color: white;
        }
    </style>
    <?php
    require "views/partials/header.php";
    require "views/partials/sidebar.php";
    ?>

    <section class="courses">

        <h1 class="heading">Menyusun Kata</h1>
        <div class="card">
            <h1 class="heading" style="text-align:center; border:none;">Susun Huruf Menjadi Kata</h1>
            <div id="image-container" style="text-align:center;">
                <!-- The image will be inserted here by JavaScript -->
            </div>
            <h1 id="letter-buttons-answer" style="text-align:center;">
                <!-- Answer buttons will be inserted here by JavaScript -->
            </h1>
            <p id="text1" class="heading" style="text-align:center; border:none;">Susun Huruf Menjadi Kata:</p>
            <h1 id="letter-buttons" style="text-align:center;">
                <!-- Letter buttons will be inserted here by JavaScript -->
            </h1>
            <p class="heading" id="score2" style="text-align:center; border:none;">Score: <span id="score">0</span></p>
            <p id="text2" class="heading" style="text-align:center; border:none;">Progress: <span id="question-number">1</span>/10</p>
            <div id="endgame" class="hidden" style="text-align:center;">
                <h1 class="heading" style="border:none;">Permainan Selesai!</h1>
                <p class="heading" style="border:none;">Skor Akhir Anda: <span id="final-score"></span></p>
                <button class="inline-btn" onclick="window.location.href='../selectconstructword'">Main Lagi</button>
            </div>
        </div>

        <audio id="correctSound" src="../audio/correct.mp3" preload="auto"></audio>
        <audio id="wrongSound" src="../audio/wrong.mp3" preload="auto"></audio>
        <audio id="applauseSound" src="../audio/applause.mp3" preload="auto"></audio>

    </section>

    <?php
    require "views/partials/foot.php";
    ?>

    <script>
        // Arrays of words with corresponding images
        const buah = [
            { word: "apel", image: "../views/games/gambar/apel.png" },
            { word: "pisang", image: "../views/games/gambar/pisang.png" },
            { word: "jeruk", image: "../views/games/gambar/jeruk.png" },
            { word: "mangga", image: "../views/games/gambar/mangga.png" },
            { word: "semangka", image: "../views/games/gambar/semangka.png" },
            { word: "durian", image: "../views/games/gambar/durian.png" },
            { word: "rambutan", image: "../views/games/gambar/rambutan.png" },
            { word: "nanas", image: "../views/games/gambar/nanas.png" },
            { word: "kelapa", image: "../views/games/gambar/kelapa.png" },
            { word: "anggur", image: "../views/games/gambar/anggur.png" }
        ];

        const hewan = [
            { word: "singa", image: "../views/games/gambar/singa.png" },
            { word: "ular", image: "../views/games/gambar/ular.png" },
            { word: "kuda", image: "../views/games/gambar/kuda.png" },
            { word: "sapi", image: "../views/games/gambar/sapi.png" },
            { word: "kucing", image: "../views/games/gambar/kucing.png" },
            { word: "anjing", image: "../views/games/gambar/anjing.png" },
            { word: "beruang", image: "../views/games/gambar/beruang.png" },
            { word: "gajah", image: "../views/games/gambar/gajah.png" },
            { word: "kelinci", image: "../views/games/gambar/kelinci.png" },
            { word: "ayam", image: "../views/games/gambar/ayam.png" }
        ];
        const benda = [
            { word: "meja", image: "../views/games/gambar/meja.png" },
            { word: "baju", image: "../views/games/gambar/baju.png" },
            { word: "kursi", image: "../views/games/gambar/kursi.png" },
            { word: "pensil", image: "../views/games/gambar/pensil.png" },
            { word: "buku", image: "../views/games/gambar/buku.png" },
            { word: "lampu", image: "../views/games/gambar/lampu.png" },
            { word: "pisau", image: "../views/games/gambar/pisau.png" },
            { word: "sendok", image: "../views/games/gambar/sendok.png" },
            { word: "topi", image: "../views/games/gambar/topi.png" },
            { word: "sepatu", image: "../views/games/gambar/sepatu.png" }
        ];

        // Set the variable to determine the quiz category (buah, hewan, or benda)
        const soal = <?=$link[3]?>; // Change to 'hewan' for animal questions

        let score = 0;
        let currentQuestion = 0;
        const totalQuestions = 10;
        let selectedWord = "";

        // Function to shuffle array
        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        // Function to start a new round
        function newRound() {
            if (currentQuestion >= totalQuestions) {
                endGame();
                return;
            }

            currentQuestion++;
            document.getElementById("question-number").textContent = currentQuestion;

            // Get a random word from the selected category (soal)
            let randomIndex = Math.floor(Math.random() * soal.length);
            let selectedWordObject = soal[randomIndex];
            selectedWord = selectedWordObject.word;

            // Display the corresponding image
            let imageContainer = document.getElementById("image-container");
            imageContainer.innerHTML = ''; // Clear previous image
            let imageElement = document.createElement("img");
            imageElement.src = selectedWordObject.image;
            imageElement.alt = selectedWord;
            imageElement.style.width = "200px"; // Set the desired width
            imageContainer.appendChild(imageElement);

            // Generate letter buttons
            let options = selectedWord.split('');
            options = shuffleArray(options);

            // Create buttons for each option
            let letterButtons = document.getElementById("letter-buttons");
            letterButtons.innerHTML = ''; // Clear previous buttons
            let answerButtons = document.getElementById("letter-buttons-answer");
            answerButtons.innerHTML = ''; // Clear previous answer buttons

            options.forEach(option => {
                let button = document.createElement("button");
                button.textContent = option.toUpperCase();
                button.className = "inline-btn2";
                button.onclick = function() {
                    toggleLetter(button, option);
                };
                letterButtons.appendChild(button);
            });
        }

        // Function to move letter to answer buttons or back to letter buttons
        function toggleLetter(button, letter) {
            let answerButtons = document.getElementById("letter-buttons-answer");
            let letterButtons = document.getElementById("letter-buttons");

            if (button.parentElement.id === "letter-buttons") {
                // Move to answer buttons
                let answerButton = document.createElement("button");
                answerButton.textContent = letter.toUpperCase();
                answerButton.className = "inline-btn2";
                answerButton.onclick = function() {
                    toggleLetter(answerButton, letter);
                };
                answerButtons.appendChild(answerButton);
                button.classList.add('hidden');
            } else {
                // Move back to letter buttons
                let letterButton = Array.from(letterButtons.children).find(btn => btn.textContent === letter.toUpperCase());
                letterButton.classList.remove('hidden');
                answerButtons.removeChild(button);
            }

            // Check if the guessed word is complete
            if (answerButtons.children.length === selectedWord.length) {
                let guessedWord = Array.from(answerButtons.children).map(btn => btn.textContent.toLowerCase()).join('');
                checkAnswer(guessedWord);
            }
        }

        // Function to check the guessed word
        function checkAnswer(guessedWord) {
            let answerButtons = document.getElementById("letter-buttons-answer");

            Array.from(answerButtons.children).forEach((btn, index) => {
                if (selectedWord[index] === btn.textContent.toLowerCase()) {
                    btn.classList.add('correct');
                } else {
                    btn.classList.add('incorrect');
                }
            });

            if (guessedWord === selectedWord) {
                score++;
                document.getElementById("correctSound").play();
            } else {
                score--;
                document.getElementById("wrongSound").play();
            }
            document.getElementById("score").textContent = score;

            // Proceed to the next round after a short delay
            setTimeout(() => {
                Array.from(answerButtons.children).forEach(btn => btn.classList.remove('correct', 'incorrect'));
                newRound();
            }, 1000);
        }

        // Function to end the game
        function endGame() {
            document.getElementById("applauseSound").play();
            document.getElementById("image-container").classList.add("hidden");
            document.getElementById("letter-buttons-answer").classList.add("hidden");
            document.getElementById("letter-buttons").classList.add("hidden");
            document.getElementById("question-number").classList.add("hidden");
            document.getElementById("score2").classList.add("hidden");
            document.getElementById("text1").classList.add("hidden");
            document.getElementById("text2").classList.add("hidden");
            document.getElementById("endgame").classList.remove("hidden");
            document.getElementById("final-score").textContent = score;
        }

        // Function to restart the game
        function restartGame() {
            score = 0;
            currentQuestion = 0;
            document.getElementById("score").textContent = score;
            document.getElementById("image-container").classList.remove("hidden");
            document.getElementById("letter-buttons-answer").classList.remove("hidden");
            document.getElementById("letter-buttons").classList.remove("hidden");
            document.getElementById("question-number").classList.remove("hidden");
            document.getElementById("score2").classList.remove("hidden");
            document.getElementById("text1").classList.remove("hidden");
            document.getElementById("text2").classList.remove("hidden");
            document.getElementById("endgame").classList.add("hidden");
            newRound();
        }

        // Start the first round
        newRound();
    </script>
</body>

</html>
