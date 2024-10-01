/assets/: For all static files like images and icons.
/css/: Contains all styles, separated by functionality (homepage, student, admin).
/js/: Contains all JavaScript logic for interactions, dashboards, and quiz navigation.
/php/: Backend PHP scripts for handling login, quiz management, and fetching questions.
/db/: Database-related files, like the initial SQL schema.
/uploads/: For storing uploaded files (if quizzes are uploaded as files).
--------------------------------------

1. Student Dashboard
Purpose:

Provides students with an overview of their quizzes, history, and progress.
Key Components:

Header:
Site logo/name.
Navigation links: Home, Profile, Logout.
Quiz List Section:
List of available quizzes (category, quiz name, status).
A “Start Quiz” button for each available quiz.
Categories filter (optional).
Progress Section:
A bar showing progress on attempted quizzes (completed vs pending).
Recent results (e.g., last quiz score).
History Section:
List of past quizzes and scores with review links.
Option to download or view results in detail.
Profile Section (optional):
View and edit student profile information.
Profile picture, personal info, and quiz statistics.


---------------------------------------

2. Admin Dashboard
Purpose:

Allows admins to manage quizzes, students, and view quiz statistics.
Key Components:

Header:
Site logo/name.
Navigation links: Home, Add Quiz, View Quiz History, Logout.
Quiz Management Section:
Add a new quiz: form with inputs for quiz title, category, questions, and answers.
Option to upload a quiz file (PDF, Word).
List of existing quizzes with options to edit or delete.
Leaderboard Section:
View top student performers across different quizzes.
Filters for date, quiz category, and performance.
Quiz History Section:
Overview of all quizzes (quiz title, number of participants, average score).
Download detailed reports (PDF/CSV).
Student Management Section (optional):
List of all registered students, quiz results, and performance analysis.

---------------------------------------
