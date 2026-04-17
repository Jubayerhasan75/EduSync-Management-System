-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2026 at 05:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edusync_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_role` varchar(20) NOT NULL,
  `target_role` varchar(20) NOT NULL,
  `target_class` varchar(50) DEFAULT NULL,
  `target_section` varchar(50) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `target_user_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `sender_id`, `sender_role`, `target_role`, `target_class`, `target_section`, `subject`, `target_user_id`, `message`, `created_at`) VALUES
(1, 1, 'admin', 'specific_student', 'Class 6', 'A', NULL, 5, 'Greetings Jubayer,\r\nYou are requested to come to principal\'s office by tomorrow at 12 PM\r\n\r\nThank You\r\nAdmin', '2026-04-06 20:34:25'),
(2, 2, 'teacher', 'specific_section', 'Class 7', 'B', NULL, NULL, 'No class tomorrow\r\n21.04.2026', '2026-04-06 20:36:00'),
(3, 1, 'admin', 'specific_student', 'Class 6', 'A', NULL, 8, 'Greetings Rohan,\r\nYou are requested to come principal\'s office by tomorrow at 12 PM\r\n\r\nThank You\r\nAdmin\r\n', '2026-04-06 20:39:18'),
(4, 2, 'teacher', 'specific_section', 'Class 10', 'A', NULL, NULL, 'No Class Tomorrow', '2026-04-06 20:40:00'),
(5, 1, 'admin', 'all_teachers', 'Class 6', 'A', NULL, 0, 'Assalamualaikum ', '2026-04-06 20:50:46'),
(6, 1, 'admin', 'specific_student', 'Class 6', 'A', NULL, 7, 'Hi Sakif,\r\nYou are requested to come principal\'s office by tomorrow at 12 pm \r\n\r\nThank You,\r\nAdmin', '2026-04-07 09:24:07'),
(7, 1, 'admin', 'all_teachers', 'Class 6', 'A', NULL, 0, 'Assalamualaikum\r\nAll of you are requested to come principal\'s office for a important meeting by tomorrow at 9 am\r\n\r\nThank You,\r\nAdmin', '2026-04-07 09:25:06'),
(8, 1, 'admin', 'specific_student', 'Class 6', 'A', NULL, 7, 'please meet at the principal office immediately ', '2026-04-07 13:14:04');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `created_at`) VALUES
(1, 0, 'New user registered: md.anis@gmail.com', '2026-04-07 13:09:06'),
(2, 0, 'New user registered: pollob@gmail.com', '2026-04-07 13:17:44');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `section` varchar(50) NOT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `teacher_id`, `title`, `class_name`, `section`, `subject`, `file_path`, `status`, `created_at`) VALUES
(4, 2, 'HTML ', 'Class 10', 'A', 'ICT', '1775498203_Project Report.docx', 'approved', '2026-04-06 17:56:43'),
(5, 2, 'css', 'Class 6', 'A', 'ICT', '1775499137_assignment.docx', 'approved', '2026-04-06 18:12:17'),
(6, 2, 'javascript', 'Class 10', 'A', 'ICT', '1775545532_Project Report.docx', 'approved', '2026-04-07 07:05:32'),
(7, 13, 'Parts of speech', 'Class 7', 'A', 'English', '1775567432_Project Report.docx', 'approved', '2026-04-07 13:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_details`
--

CREATE TABLE `student_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `roll_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_results`
--

CREATE TABLE `student_results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `exam_name` varchar(100) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_results`
--

INSERT INTO `student_results` (`id`, `student_id`, `subject`, `exam_name`, `score`) VALUES
(1, 10, 'Bangla', 'Class Test 1', 85),
(2, 10, 'Bangla', 'Mid Term', 90),
(3, 10, 'Bangla', 'Class Test 2', 66),
(4, 10, 'Bangla', 'Final Exam', 79),
(5, 10, 'Mathematics', 'Class Test 1', 71),
(6, 10, 'Mathematics', 'Mid Term', 87),
(7, 10, 'Mathematics', 'Class Test 2', 74),
(8, 10, 'Mathematics', 'Final Exam', 78),
(9, 11, 'ICT', 'Class Test 1', 68),
(10, 11, 'ICT', 'Mid Term', 66),
(11, 11, 'ICT', 'Class Test 2', 96),
(12, 11, 'ICT', 'Final Exam', 94),
(13, 5, 'ICT', 'Class Test 1', 79),
(14, 5, 'ICT', 'Mid Term', 75),
(15, 5, 'ICT', 'Class Test 2', 91),
(16, 5, 'ICT', 'Final Exam', 98),
(17, 8, 'English', 'Class Test 1', 75),
(18, 8, 'English', 'Mid Term', 65),
(19, 8, 'English', 'Class Test 2', 65),
(20, 8, 'English', 'Final Exam', 75),
(21, 8, 'Bangla', 'Class Test 1', 94),
(22, 8, 'Bangla', 'Mid Term', 69),
(23, 8, 'Bangla', 'Class Test 2', 68),
(24, 8, 'Bangla', 'Final Exam', 95),
(25, 8, 'Biology', 'Class Test 1', 63),
(26, 8, 'Biology', 'Mid Term', 93),
(27, 8, 'Biology', 'Class Test 2', 84),
(28, 8, 'Biology', 'Final Exam', 92),
(29, 7, 'ICT', 'Class Test 1', 80),
(30, 7, 'ICT', 'Mid Term', 83),
(31, 7, 'ICT', 'Class Test 2', 75),
(32, 7, 'ICT', 'Final Exam', 91),
(33, 6, 'Bangla', 'Class Test 1', 84),
(34, 6, 'Bangla', 'Mid Term', 94),
(35, 6, 'Bangla', 'Class Test 2', 78),
(36, 6, 'Bangla', 'Final Exam', 79);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `student_id` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','principal','teacher','student') NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT 'default.png',
  `class_name` varchar(50) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `student_id`, `name`, `email`, `phone`, `password`, `role`, `designation`, `profile_pic`, `class_name`, `section`, `created_at`) VALUES
(1, NULL, 'Super Admin', 'admin@edusync.com', NULL, '0192023a7bbd73250516f069df18b500', 'admin', NULL, 'default.png', NULL, NULL, '2026-04-05 05:12:39'),
(2, NULL, 'Md. Arman Hossain', 'md.arman@gmail.com', '01658788896', '8abbf433aaf34f3a229d703662c78c0c', 'teacher', 'Senior Lecturer', 'default.png', NULL, NULL, '2026-04-05 05:25:36'),
(4, '5705', 'Jubayer Hasan', 'jubayerhasanrohan@gmail.com', '01742256933', '05bb90474bbd439d66abf683527d50cc', 'student', NULL, 'default.png', 'Class 10', 'A', '2026-04-05 05:33:51'),
(5, '6191', 'Jubayer ', 'jubayer@gmail.com', '01709135821', '7d8320b587bef5306f5ba2cce5677eef', 'student', NULL, '1775507108_download (1).jpeg', 'Class 10', 'A', '2026-04-05 06:06:15'),
(6, '3842', 'Johan Hasan Rohan', 'johan@gmail.com', '01718908311', '2d87b36b4f489a92b5032d29b5b5611b', 'student', NULL, 'default.png', 'Class 7', 'B', '2026-04-06 17:03:27'),
(7, '8638', 'Sakif Muhhtasim', 'sakif@gmail.com', '01767134094', 'd2367295fcd294418189d62076e4c73f', 'student', NULL, 'default.png', 'Class 8', 'A', '2026-04-06 17:05:48'),
(8, '3663', 'Rohan Hasan', 'rohan@gmail.com', '01778945542', 'aeae5b2f900e84d784a0f0111e650835', 'student', NULL, '1775508134_download.jpeg', 'Class 10', 'A', '2026-04-06 17:33:06'),
(9, NULL, 'Md.Jubayer Hasan', 'jubayerhasan@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'principal', NULL, 'default.png', NULL, NULL, '2026-04-06 18:13:51'),
(10, '9403', 'Hasanul Fahim', 'fahim@gmail.com', '01793325432', '87570029113d1b73a9f6af4f618767c8', 'student', NULL, 'default.png', 'Class 10', 'A', '2026-04-06 19:08:14'),
(11, '8026', 'Sf Tonmoy', 'tonmoy@gmail.com', '01729790536', 'e10adc3949ba59abbe56e057f20f883e', 'student', NULL, 'default.png', 'Class 10', 'A', '2026-04-06 19:10:48'),
(12, NULL, 'Sarwar Jahan', 'sarwar.jahan@gmail.com', '01565488524', '6c56891e36a6350aa9c6d96cf85404c9', 'teacher', 'Senior Lecturer', 'default.png', '', '', '2026-04-06 19:39:43'),
(13, '', 'Md.Anis ', 'md.anis@gmail.com', '01545655885', '705b3f6cea430265af8147efa4cc495b', 'teacher', 'Senior Lecturer', '1775567346_download (1).jpeg', '', '', '2026-04-07 13:09:06'),
(14, '5010', 'pollob nath', 'pollob@gmail.com', '01532266554', '81e62cac04b33fb17c71002ee961f6f2', 'student', 'Lecturer', '1775567864_download.jpeg', 'Class 7', 'A', '2026-04-07 13:17:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `student_details`
--
ALTER TABLE `student_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `student_results`
--
ALTER TABLE `student_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_details`
--
ALTER TABLE `student_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_results`
--
ALTER TABLE `student_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_details`
--
ALTER TABLE `student_details`
  ADD CONSTRAINT `student_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_details_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `student_details_ibfk_3` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`);

--
-- Constraints for table `student_results`
--
ALTER TABLE `student_results`
  ADD CONSTRAINT `student_results_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
