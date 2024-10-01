document.addEventListener('DOMContentLoaded', function() {
    fetchQuizzes();

    document.getElementById('edit-quiz-form').addEventListener('submit', function(event) {
        event.preventDefault();
        updateQuiz();
    });
});

function fetchQuizzes() {
    fetch('php/fetch_quizzes3.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#quizzes-table tbody');
            tbody.innerHTML = '';
            data.forEach(quiz => {
                tbody.innerHTML += `
                    <tr>
                        <td>${quiz.quiz_title}</td>
                        <td>${quiz.time_allotted}</td>
                        <td>${quiz.num_questions}</td>
                        <td>${quiz.participants}</td>
                        <td>
                            <button onclick="openEditModal(${quiz.id}, '${quiz.quiz_title}', ${quiz.time_allotted}, ${quiz.num_questions})">Manage</button>
                            <button onclick="deleteQuiz(${quiz.id})">Delete</button>
                        </td>
                    </tr>
                `;
            });
        });
}

function openEditModal(id, title, time, questions) {
    document.getElementById('quiz-id').value = id;
    document.getElementById('quiz-title').value = title;
    document.getElementById('time-allotted').value = time;
    document.getElementById('num-questions').value = questions;
    document.getElementById('edit-quiz-modal').style.display = 'block';
}

document.querySelector('.close').onclick = function() {
    document.getElementById('edit-quiz-modal').style.display = 'none';
}

function updateQuiz() {
    const id = document.getElementById('quiz-id').value;
    const title = document.getElementById('quiz-title').value;
    const time = document.getElementById('time-allotted').value;
    const questions = document.getElementById('num-questions').value;

    fetch('update_quiz.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id, title, time, questions })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        fetchQuizzes();
        document.getElementById('edit-quiz-modal').style.display = 'none';
    });
}

function deleteQuiz(id) {
    if (confirm('Are you sure you want to delete this quiz?')) {
        fetch('php/delete_quiz.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            fetchQuizzes();
        });
    }
}
