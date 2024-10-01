document.addEventListener('DOMContentLoaded', () => {
    let questions = [];
    let currentQuestionIndex = 0;
    let selectedChoices = {};
    let totalTime;
    let quizTitle = '';  // Variable to store the quiz title
    const timerElement = document.getElementById('time-left');
    const resultsSection = document.getElementById('results-section');
    const nextButton = document.getElementById('next-button');
    const previousButton = document.getElementById('previous-button');
    const submitButton = document.getElementById('submit-quiz');
    const startQuizButton = document.getElementById('start-quiz-button');
    const quizStartModal = document.getElementById('quiz-start-modal');

    // Start Full-Screen Mode
    function enableFullScreen() {
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) { // Firefox
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari, Opera
            document.documentElement.webkitRequestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
            document.documentElement.msRequestFullscreen();
        }
    }

    enableFullScreen();

    // Monitor if user exits full-screen or switches tabs
    document.addEventListener('fullscreenchange', () => {
        if (!document.fullscreenElement) {
            alert('You should not exit full-screen mode during the quiz.');
            // Redirect to a different page if they exit full-screen
            window.location.href = 'student_dash.php'; // Replace with your exit URL
        }
    });

    window.addEventListener('blur', () => {
        alert('You switched tabs or exited full-screen mode. Please stay on the quiz page!');
    });

    window.addEventListener('focus', () => {
        console.log('User is back on the quiz page.');
    });

    // Disable Right-click
    document.addEventListener('contextmenu', (event) => {
        event.preventDefault();
    });

    // Disable Print (using print key events)
    window.addEventListener('keydown', (event) => {
        if ((event.ctrlKey && event.key === 'p') || (event.metaKey && event.key === 'p')) {
            event.preventDefault();
            alert('Printing is disabled during the quiz.');
        }
        // Handle Escape key to exit quiz
        if (event.key === 'Escape') {
            alert('Exiting the quiz.');
            window.location.href = 'student_dash.php'; // Replace with your exit URL
        }
    });

    // Start Timer
    function startTimer() {
        const timerInterval = setInterval(() => {
            let minutes = Math.floor(totalTime / 60);
            let seconds = totalTime % 60;
            seconds = seconds < 10 ? '0' + seconds : seconds;
            timerElement.textContent = `${minutes}:${seconds}`;

            if (totalTime <= 0) {
                clearInterval(timerInterval);
                submitQuiz(); // Automatically submit when time is up
            }

            totalTime--;
        }, 1000);
    }

    // Fetch Quiz Data
    function fetchQuizData() {
        const urlParams = new URLSearchParams(window.location.search);
        const quizId = urlParams.get('quiz_id'); // Fetch the quiz ID from URL parameters

        fetch(`get_quiz_data.php?quiz_id=${quizId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    throw new Error(`Server error: ${data.error}`);
                }
                totalTime = data.quiz.time_allotted * 60; // Convert minutes to seconds
                timerElement.textContent = formatTime(totalTime);
                questions = data.questions;
                quizTitle = data.quiz.quiz_title; // Update with the actual quiz title from the response
                loadQuestion();
                startTimer();
            })
            .catch(error => {
                console.error('Error fetching quiz data:', error);
            });
    }

    // Format Time
    function formatTime(seconds) {
        let minutes = Math.floor(seconds / 60);
        seconds = seconds % 60;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        return `${minutes}:${seconds}`;
    }

    // Load Question
    function loadQuestion() {
        if (questions.length === 0) return;

        const currentQuestion = questions[currentQuestionIndex];
        document.getElementById('question-title').textContent = currentQuestion.question_text;

        const choicesList = document.getElementById('choices-list');
        choicesList.innerHTML = '';

        currentQuestion.options.forEach((option, index) => {
            const choiceElement = document.createElement('li');
            choiceElement.classList.add('choice');
            choiceElement.textContent = option;
            choiceElement.setAttribute('data-choice', index); // Store option index for comparison

            if (selectedChoices[currentQuestionIndex] === index) {
                choiceElement.classList.add('selected');
            }

            choiceElement.addEventListener('click', () => {
                document.querySelectorAll('.choice').forEach(c => c.classList.remove('selected'));
                choiceElement.classList.add('selected');
                selectedChoices[currentQuestionIndex] = index;  // Store selected option index
            });

            choicesList.appendChild(choiceElement);
        });

        document.getElementById('question-count').textContent = `Question ${currentQuestionIndex + 1} of ${questions.length}`;
        document.querySelector('.question-container').classList.remove('hidden');
    }

    // Next Question Logic
    if (nextButton) {
        nextButton.addEventListener('click', () => {
            currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) {
                loadQuestion();
            } 
        });
    }

    // Previous Question Logic
    if (previousButton) {
        previousButton.addEventListener('click', () => {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                loadQuestion();
            } 
        });
    }

    // Submit Quiz
    function submitQuiz() {
        let correctAnswers = 0;
        let wrongAnswers = 0;
        let notAttempted = 0;

        questions.forEach((question, index) => {
            const correctOptionZeroIndexed = question.correct_option - 1;

            // Check if the question was attended (i.e., has a selected choice)
            if (selectedChoices.hasOwnProperty(index)) {
                if (selectedChoices[index] === correctOptionZeroIndexed) {
                    correctAnswers++;  // Increment correct answers if the choice is correct
                } else {
                    wrongAnswers++;    // Increment wrong answers if the choice is incorrect
                }
            } else {
                notAttempted++;  // Increment not attempted if no choice was selected for this question
            }
        });

        const attendedQuestions = Object.keys(selectedChoices).length;

        const quizResults = {
            score: correctAnswers,
            attended_questions: attendedQuestions,
            correct_answers: correctAnswers,
            wrong_answers: wrongAnswers,
            not_attempted: notAttempted,
            quiz_title: quizTitle
        };

        console.log('Submitting quiz results:', quizResults);

        fetch('submit.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(quizResults)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const resultBox = document.createElement('div');
                resultBox.className = 'result-container';

                const resultMessage = `
                    <p style="color: green;">You scored ${correctAnswers} out of ${questions.length}</p>
                    <p>Questions Attempted: ${attendedQuestions}</p>
                    <p style="color: blue;">Correct Answers: ${correctAnswers}</p>
                    <p style="color: red;">Wrong Answers: ${wrongAnswers}</p>
                    <p style="color: gray;">Not Attempted: ${notAttempted}</p>
                `;

                resultBox.innerHTML = resultMessage;

                // Create chart container and set explicit width and height
                const chartCanvas = document.createElement('canvas');
                resultBox.appendChild(chartCanvas);

                // Set custom dimensions for the canvas
                chartCanvas.width = 50;  // Adjust width as needed
                chartCanvas.height = 50; // Adjust height as needed

                new Chart(chartCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: ['Correct', 'Wrong', 'Not Attempted'],
                        datasets: [{
                            data: [correctAnswers, wrongAnswers, notAttempted],
                            backgroundColor: ['#28a745', '#dc3545', '#6c757d'],
                        }]
                    },
                    options: {
                        responsive: false,  // Disable responsiveness for custom size control
                        maintainAspectRatio: false,  // Disable aspect ratio to allow resizing
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return `${tooltipItem.label}: ${tooltipItem.raw}`;
                                    }
                                }
                            }
                        }
                    }
                });

                const backButton = document.createElement('a');
                backButton.href = 'student_dash.php';
                backButton.className = 'home-button';
                backButton.textContent = 'Back to Home';
                resultBox.appendChild(backButton);

                document.querySelector('.quiz-container').innerHTML = '';
                document.querySelector('.quiz-container').appendChild(resultBox);
                resultsSection.classList.remove('hidden');
            } else {
                console.error('Error submitting quiz:', data.message);
            }
        })
        .catch(error => {
            console.error('Error submitting quiz:', error);
        });
    }


    if (submitButton) {
        submitButton.addEventListener('click', () => {
            submitQuiz();
        });
    }

    // Start the quiz when the button is clicked
    if (startQuizButton) {
        startQuizButton.addEventListener('click', () => {
            enableFullScreen();
            quizStartModal.style.display = 'none'; // Hide modal
            fetchQuizData(); // Fetch quiz data and start the quiz
        });
    }

    // Show the quiz start modal on page load
    quizStartModal.style.display = 'block';
});
