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

        <h1 class="heading">Melengkapi Kata Bahasa Inggris</h1>
        <div class="card">
            <h1 class="heading" style="text-align:center; border:none;">Tebak Huruf yang Hilang</h1>
            <div id="image-container" style="text-align:center;">
                <!-- The image will be inserted here by JavaScript -->
            </div>
            <p class="heading" style="text-align:center; border:none;" id="displayWord"></p>
            <p id="text1" class="heading" style="text-align:center; border:none;">Tebak Huruf yang Hilang:</p>
            <h1 id="letter-buttons" style="text-align:center;">
                <!-- Letter buttons will be inserted here by JavaScript -->
            </h1>
            <p class="heading" id="score2" style="text-align:center; border:none;">Score: <span id="score">0</span></p>
            <p id="text2" class="heading" style="text-align:center; border:none;">Progress: <span id="question-number">1</span>/10</p>
            <div id="endgame" class="hidden" style="text-align:center;">
                <h1 class="heading" style="border:none;">Permainan Selesai!</h1>
                <p class="heading" style="border:none;">Skor Akhir Anda: <span id="final-score"></span></p>
                <button class="inline-btn" onclick="window.location.href='../selectcompletetheword'">Main Lagi</button>
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
        const buah = [{
                word: "apple",
                image: "../views/games/gambar/apel.png"
            },
            {
                word: "banana",
                image: "../views/games/gambar/pisang.png"
            },
            {
                word: "orange",
                image: "../views/games/gambar/jeruk.png"
            },
            {
                word: "mango",
                image: "../views/games/gambar/mangga.png"
            },
            {
                word: "watermelon",
                image: "../views/games/gambar/semangka.png"
            },
            {
                word: "durian",
                image: "../views/games/gambar/durian.png"
            },
            {
                word: "rambutan",
                image: "../views/games/gambar/rambutan.png"
            },
            {
                word: "pineapple",
                image: "../views/games/gambar/nanas.png"
            },
            {
                word: "coconut",
                image: "../views/games/gambar/kelapa.png"
            },
            {
                word: "grape",
                image: "../views/games/gambar/anggur.png"
            }
        ];

        const hewan = [{
                word: "lion",
                image: "../views/games/gambar/singa.png"
            },
            {
                word: "snake",
                image: "../views/games/gambar/ular.png"
            },
            {
                word: "horse",
                image: "../views/games/gambar/kuda.png"
            },
            {
                word: "cow",
                image: "../views/games/gambar/sapi.png"
            },
            {
                word: "cat",
                image: "../views/games/gambar/kucing.png"
            },
            {
                word: "dog",
                image: "../views/games/gambar/anjing.png"
            },
            {
                word: "bear",
                image: "../views/games/gambar/beruang.png"
            },
            {
                word: "elephant",
                image: "../views/games/gambar/gajah.png"
            },
            {
                word: "rabbit",
                image: "../views/games/gambar/kelinci.png"
            },
            {
                word: "chicken",
                image: "../views/games/gambar/ayam.png"
            }
        ];

        const benda = [{
                word: "table",
                image: "../views/games/gambar/meja.png"
            },
            {
                word: "clothes",
                image: "../views/games/gambar/baju.png"
            },
            {
                word: "chair",
                image: "../views/games/gambar/kursi.png"
            },
            {
                word: "pencil",
                image: "../views/games/gambar/pensil.png"
            },
            {
                word: "book",
                image: "../views/games/gambar/buku.png"
            },
            {
                word: "lamp",
                image: "../views/games/gambar/lampu.png"
            },
            {
                word: "knife",
                image: "../views/games/gambar/pisau.png"
            },
            {
                word: "spoon",
                image: "../views/games/gambar/sendok.png"
            },
            {
                word: "hat",
                image: "../views/games/gambar/topi.png"
            },
            {
                word: "shoes",
                image: "../views/games/gambar/sepatu.png"
            }
        ];

        // Set the variable to determine the quiz category (buah or hewan)
        const soal = <?= $link[3] ?>; // Change to 'hewan' for animal questions

        let score = 0;
        let currentQuestion = 0;
        const totalQuestions = 10;

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
            let selectedWord = selectedWordObject.word;

            // Display the corresponding image
            let imageContainer = document.getElementById("image-container");
            imageContainer.innerHTML = ''; // Clear previous image
            let imageElement = document.createElement("img");
            imageElement.src = selectedWordObject.image;
            imageElement.alt = selectedWord;
            imageElement.style.width = "200px"; // Set the desired width
            imageContainer.appendChild(imageElement);

            // Remove one random letter from the word
            let missingIndex = Math.floor(Math.random() * selectedWord.length);
            let displayWord = "";
            for (let i = 0; i < selectedWord.length; i++) {
                if (i === missingIndex) {
                    displayWord += "_ ";
                } else {
                    displayWord += selectedWord[i] + " ";
                }
            }
            document.getElementById("displayWord").textContent = displayWord;

            // Generate letter buttons
            const alphabet = "abcdefghijklmnopqrstuvwxyz".split('');
            const correctLetter = selectedWord[missingIndex];

            // Ensure correct letter is included in the options
            let options = [correctLetter];

            // Add 3 more random letters
            while (options.length < 4) {
                let randomLetter = alphabet[Math.floor(Math.random() * alphabet.length)];
                if (!options.includes(randomLetter)) {
                    options.push(randomLetter);
                }
            }

            // Shuffle the options array
            options = options.sort(() => Math.random() - 0.5);

            // Create buttons for each option
            let letterButtons = document.getElementById("letter-buttons");
            letterButtons.innerHTML = ''; // Clear previous buttons
            options.forEach(option => {
                let button = document.createElement("button");
                button.textContent = option.toUpperCase();
                button.className = "inline-btn2";
                button.onclick = function() {
                    guessLetter(button, option, correctLetter);
                };
                letterButtons.appendChild(button);
            });
        }

        // Function to check guessed letter
        function guessLetter(button, letter, correctLetter) {
            // Check if the guessed letter is correct
            if (letter === correctLetter) {
                button.classList.add('correct');
                score++;

                // Play the correct answer sound
                document.getElementById("correctSound").play();
            } else {
                button.classList.add('incorrect');
                score--;

                // Play the correct answer sound
                document.getElementById("wrongSound").play();
            }
            document.getElementById("score").textContent = score;

            // Disable all buttons after a guess
            let buttons = document.querySelectorAll('#letter-buttons button');
            buttons.forEach(btn => {
                btn.disabled = true;
            });

            // Proceed to the next round after a short delay
            setTimeout(newRound, 1000);
        }

        // Function to end the game
        function endGame() {
            document.getElementById("applauseSound").play();
            document.getElementById("image-container").classList.add("hidden");
            document.getElementById("displayWord").classList.add("hidden");
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
            document.getElementById("displayWord").classList.remove("hidden");
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