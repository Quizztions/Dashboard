-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2024 at 10:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(4, 'admin', '$2y$10$kI5sxoaxWidB6sZmyHhGf.ah4iZww8IrYt51KKCPFdutuNUNc5AO.');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option_1` varchar(255) NOT NULL,
  `option_2` varchar(255) NOT NULL,
  `option_3` varchar(255) NOT NULL,
  `option_4` varchar(255) NOT NULL,
  `correct_option` enum('1','2','3','4') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `option_1`, `option_2`, `option_3`, `option_4`, `correct_option`) VALUES
(119, 14, 'What is the basis of utility theory?', 'Maximizing expected utility', 'Minimizing losses', 'Risk management', 'Decision networks', '1'),
(120, 14, 'Which of the following is a utility function?', 'A function mapping actions to outcomes', 'A function that assigns a real number to outcomes based on preferences', 'A function that models risk', 'A function for decision-making', '2'),
(121, 14, 'Which is an example of multi-attribute utility function?', 'A function with multiple decision variables', 'A function mapping multiple utilities to one outcome', 'A function aggregating preferences across multiple attributes', 'A function for calculating expected utility', '3'),
(122, 14, 'What is the purpose of decision networks?', 'To visualize decision trees', 'To model uncertainty in decision-making', 'To calculate risk', 'To predict outcomes', '2'),
(123, 14, 'What does \'value of information\' refer to?', 'The cost of acquiring data', 'The benefit gained by acquiring additional information', 'The risk of incorrect information', 'The statistical value of data', '2'),
(124, 14, 'What are unknown preferences in decision-making?', 'Preferences of other decision-makers', 'Preferences not explicitly known by the decision-maker', 'Non-cooperative preferences', 'Collective preferences', '2'),
(125, 14, 'What is a sequential decision problem?', 'A single-step decision-making problem', 'A problem involving decisions made over time', 'A problem with incomplete information', 'A cooperative game problem', '2'),
(126, 14, 'MDP stands for which of the following?', 'Maximum Decision Path', 'Markov Decision Process', 'Multi-agent Decision Problem', 'Marginal Decision Preference', '2'),
(127, 14, 'What is the main challenge in Bandit problems?', 'Balancing exploration and exploitation', 'Finding optimal policies', 'Handling sequential decisions', 'Dealing with multiple agents', '1'),
(128, 14, 'What is a partially observable MDP (POMDP)?', 'A decision-making process with incomplete information', 'A multi-agent decision problem', 'A game theory model', 'A fully observable decision process', '1'),
(129, 14, 'What is a multi-agent environment?', 'A system where multiple agents interact and make decisions', 'A single-agent decision-making process', 'An uncertain decision environment', 'A fully cooperative environment', '1'),
(130, 14, 'Which of the following is part of non-cooperative game theory?', 'Agents work together to achieve a common goal', 'Agents act independently and selfishly', 'Agents negotiate and share information', 'Agents always make collective decisions', '2'),
(131, 14, 'What is the Nash equilibrium in game theory?', 'A state where no player can benefit by changing strategy', 'A state where all players cooperate', 'A state of maximum utility', 'A point of collective decision', '1'),
(132, 14, 'What is cooperative game theory?', 'A study of agents working independently', 'A study of agents working together to achieve shared outcomes', 'A study of sequential decisions', 'A study of Bandit problems', '2'),
(133, 14, 'How are collective decisions made in multi-agent environments?', 'By maximizing individual gains', 'Through voting or consensus', 'By reducing risk', 'Through utility maximization', '2'),
(134, 14, 'What are mixed strategies in game theory?', 'Strategies involving multiple agents', 'Strategies where players randomize over possible actions', 'Strategies with multiple objectives', 'Strategies combining utility functions', '2'),
(135, 14, 'What is the Bellman equation used for?', 'Calculating expected utility in decision networks', 'Finding optimal policies in MDPs', 'Solving cooperative game theory problems', 'Predicting outcomes in multi-agent environments', '2'),
(136, 14, 'What does \'exploration\' mean in Bandit problems?', 'Maximizing known rewards', 'Testing new actions to find potentially better rewards', 'Reducing the impact of uncertainty', 'Following the optimal policy', '2'),
(137, 14, 'How does value iteration work in solving MDPs?', 'It estimates the future value of states over multiple iterations', 'It selects actions based on utility', 'It solves Bandit problems', 'It models the environment', '1'),
(138, 14, 'What is the main goal in making collective decisions?', 'Maximizing the utility of the most powerful agent', 'Maximizing the total utility of all agents', 'Minimizing risk', 'Achieving Nash equilibrium', '2');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `quiz_title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `num_questions` int(11) NOT NULL,
  `time_allotted` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `quiz_title`, `category`, `num_questions`, `time_allotted`, `created_at`) VALUES
(14, 'KEIS UNIT-4 ', '', 20, 30, '2024-09-23 06:13:44');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `roll_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `roll_number`, `password`) VALUES
(18, 'kaushal', '2022PECAI123', '$2y$10$slbex476UtVtB6uucApah.Tqdd2vl952Ezry0b08G7O8IOu2f2mCe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roll_number` (`roll_number`),
  ADD UNIQUE KEY `unique_roll_number` (`roll_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
