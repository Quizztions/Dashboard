document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.quizzes-list');
  
    // Fetch the list of quizzes from the backend
    fetch('php/fetch_quizzes2.php')
      .then(response => response.json())
      .then(quizzes => {
        quizzes.forEach(quiz => {
          const quizTitle = document.createElement('div');
          quizTitle.className = 'quiz-title';
          quizTitle.textContent = `${quiz.quiz_title} Scorecard `;
          quizTitle.addEventListener('click', () => toggleQuiz(quiz.id));
  
          const quizTableContainer = document.createElement('div');
          quizTableContainer.className = 'quiz-table-container';
          quizTableContainer.style.display = 'none'; // Initially hidden
  
          // Create the table structure
          quizTableContainer.innerHTML = `
            <table class="quiz-table" id="quiz-table-${quiz.id}">
              <thead>
                <tr>
                  <th>Rank</th>
                  <th>Student Name</th>
                  <th>Roll Number</th>
                  <th>Score</th>
                </tr>
              </thead>
              <tbody id="quiz-body-${quiz.id}"></tbody>
            </table>
            <a href="php/download_leaderboard.php?quiz_id=${quiz.id}" class="download-btn">Download as Excel</a>
          `;
  
          container.appendChild(quizTitle);
          container.appendChild(quizTableContainer);
  
          // Fetch leaderboard data for each quiz
          fetch(`php/fetch_leaderboard.php?quiz_id=${quiz.id}`)
            .then(response => response.json())
            .then(leaderboard => {
              const tableBody = document.querySelector(`#quiz-body-${quiz.id}`);
              if (tableBody) {
                leaderboard.forEach((student, index) => {
                  const row = tableBody.insertRow(); // Correct way to add a row
                  row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${student.name}</td>
                    <td>${student.roll_number}</td>
                    <td>${student.score}%</td>
                  `;
  
                  // Apply score-based coloring
                  if (student.score >= 90) {
                    row.classList.add('high-score');
                  } else if (student.score >= 75) {
                    row.classList.add('medium-high-score');
                  } else if (student.score >= 50) {
                    row.classList.add('medium-score');
                  } else {
                    row.classList.add('low-score');
                  }
                });
              } else {
                console.error(`Table body for quiz ID ${quiz.id} not found.`);
              }
            })
            .catch(err => console.error('Error fetching leaderboard:', err));
        });
      })
      .catch(err => console.error('Error fetching quizzes:', err));
  
    function toggleQuiz(quizId) {
      // Collapse any open quiz tables
      document.querySelectorAll('.quiz-table-container').forEach(table => {
        table.style.display = 'none';
      });
      
      // Show the selected quiz table
      const selectedQuizTable = document.querySelector(`#quiz-table-${quizId}`).parentElement;
      if (selectedQuizTable) {
        selectedQuizTable.style.display = 'block';
      }
    }
  });
  