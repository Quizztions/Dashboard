document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.quizzes-list');
  
    fetch('fetch_quizzes.php')
      .then(response => response.json())
      .then(quizzes => {
        quizzes.forEach(quiz => {
          const quizTitle = document.createElement('div');
          quizTitle.className = 'quiz-title';
          quizTitle.textContent = `${quiz.quiz_title} Scorecard (${quiz.created_at})`;
          quizTitle.addEventListener('click', () => toggleQuiz(quiz.id));
  
          const quizTable = document.createElement('div');
          quizTable.className = 'quiz-table-container';
          quizTable.style.display = 'none'; // Initially hidden
  
          const tableWrapper = document.createElement('div');
          tableWrapper.innerHTML = `
            <table class="quiz-table" id="quiz-table-${quiz.id}">
              <thead>
                <tr>
                  <th>Rank</th>
                  <th>Student Name</th>
                  <th>Roll Number</th>
                  <th>Score</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <a href="download_leaderboard.php?quiz_id=${quiz.id}" class="download-btn">Download as Excel</a>
          `;
  
          quizTable.appendChild(tableWrapper);
          container.appendChild(quizTitle);
          container.appendChild(quizTable);
  
          // Fetch leaderboard data for each quiz
          fetch(`fetch_leaderboard.php?quiz_id=${quiz.id}`)
            .then(response => response.json())
            .then(leaderboard => {
              const tableBody = document.querySelector(`#quiz-table-${quiz.id} tbody`);
              leaderboard.forEach((student, index) => {
                const row = document.createElement('tr');
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
  
                tableBody.appendChild(row);
              });
            });
        });
      });
  
    function toggleQuiz(quizId) {
      document.querySelectorAll('.quiz-table-container').forEach(table => {
        table.style.display = 'none';
      });
      document.querySelector(`#quiz-table-${quizId}`).parentElement.style.display = 'block';
    }
  });
  