document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('student-table-body');

    // Fetch student statistics from the server
    fetch('php/fetch_student_statistics.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                data.students.forEach(student => {
                    const row = document.createElement('tr');

                    const nameCell = document.createElement('td');
                    nameCell.textContent = student.name;

                    const rollNumberCell = document.createElement('td');
                    rollNumberCell.textContent = student.roll_number;

                    const performanceCell = document.createElement('td');
                    const viewButton = document.createElement('button');
                    viewButton.textContent = 'View Performance';
                    viewButton.classList.add('view-button');
                    viewButton.addEventListener('click', function() {
                        window.location.href = `php/student_performance.php?student_id=${student.id}`;
                    });

                    performanceCell.appendChild(viewButton);
                    row.appendChild(nameCell);
                    row.appendChild(rollNumberCell);
                    row.appendChild(performanceCell);

                    tableBody.appendChild(row);
                });
            } else {
                alert('No students found.');
            }
        })
        .catch(error => console.error('Error:', error));
});
