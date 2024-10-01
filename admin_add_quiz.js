document.addEventListener('DOMContentLoaded', function () {
    const addQuizForm = document.getElementById('add-quiz-form');
    const uploadQuizForm = document.getElementById('upload-quiz-form');
    
    // Handling form submissions for adding quizzes manually
    addQuizForm.addEventListener('submit', async function (event) {
        event.preventDefault();
        const formData = new FormData(addQuizForm);

        try {
            const response = await fetch('php/add_quiz.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.text();
            alert(data);
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to add quiz. Please check your input and try again.');
        }
    });

    // Handling form submissions for file uploads
    uploadQuizForm.addEventListener('submit', async function (event) {
        event.preventDefault();
        const formData = new FormData(uploadQuizForm);

        try {
            const response = await fetch('php/upload_file.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.text();
            alert(data);
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to upload quiz file. Please try again.');
        }
    });
});
