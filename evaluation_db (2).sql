-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2024 at 03:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evaluation.db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessid_tbl`
--

CREATE TABLE `accessid_tbl` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `time` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accessid_tbl`
--

INSERT INTO `accessid_tbl` (`id`, `student_id`, `status`, `time`) VALUES
(28, '11101', 1, '2024-06-03 05:49:50'),
(29, '11102', 1, '2024-06-03 05:49:50'),
(32, '11103', 1, '2024-06-03 06:07:45'),
(33, '11104', 0, ''),
(34, '11105', 1, '2024-06-03 09:22:54'),
(35, '11010', 1, '2024-06-03 06:40:58'),
(36, '11011', 1, '2024-06-03 06:42:00'),
(37, '110011', 1, '2024-06-03 09:25:03');

-- --------------------------------------------------------

--
-- Table structure for table `active_tbl`
--

CREATE TABLE `active_tbl` (
  `id` int(11) NOT NULL,
  `active_id` int(11) NOT NULL,
  `school_year` varchar(11) NOT NULL,
  `semester` varchar(15) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `active_tbl`
--

INSERT INTO `active_tbl` (`id`, `active_id`, `school_year`, `semester`, `status`) VALUES
(2, 1, '2024-2025', '2nd', 'Finished');

-- --------------------------------------------------------

--
-- Table structure for table `course_tbl`
--

CREATE TABLE `course_tbl` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `discription` varchar(100) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_tbl`
--

INSERT INTO `course_tbl` (`course_id`, `course_name`, `discription`, `id`) VALUES
(1001, 'BSIT', 'BACHELOR IN INFORMATION SYSTEM', 65),
(1002, 'BSA', 'BS ACCOUNTANCY', 66),
(1003, 'BSO', 'BS OFFICE ADMINISTRATION', 67),
(1004, 'BSCS', 'BACHELOR IN COMPUTER SCIENCE', 68),
(1005, 'BSCT', 'BACHELOR IN COMPUTER TECHNOLOGY', 69),
(1006, 'HRS', 'HOTEL AND RESTAURANT SERVICES', 70),
(1007, 'ABM', 'ACCOUNTANCY BUSINESS & MANAGEMENT', 72),
(1008, 'GAS', 'GENERAL ACADEMIC STRAND', 73),
(1009, 'HUMSS', 'HUMANITIES & SOCIAL SCIENCES', 74),
(1010, 'TVL', 'HOME ECONOMICS', 75);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_tbl`
--

CREATE TABLE `evaluation_tbl` (
  `evaluation_id` int(11) NOT NULL,
  `rating_avg` varchar(10) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `schoolyear` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `student_id` int(11) NOT NULL,
  `faculty_id` int(50) NOT NULL,
  `subject_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluation_tbl`
--

INSERT INTO `evaluation_tbl` (`evaluation_id`, `rating_avg`, `comment`, `date`, `schoolyear`, `semester`, `student_id`, `faculty_id`, `subject_id`) VALUES
(8, '2.0', 'kalbo', '2024-06-02', '2052-2053', '2nd', 1103, 1002, 103),
(9, '1.1', '12312', '2024-06-03', '2052-2053', '2nd', 11101, 1002, 103);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_tbl`
--

CREATE TABLE `faculty_tbl` (
  `faculty_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(64) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `address` varchar(100) NOT NULL,
  `photo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_tbl`
--

INSERT INTO `faculty_tbl` (`faculty_id`, `firstname`, `lastname`, `email`, `gender`, `contact_no`, `address`, `photo`) VALUES
(1001, 'Benjamin', 'Reynolds', 'benjamin.reynolds@email.com', 'male', '+1 (555) 123-45', 'Dau homesite', '../uploads/boy1.jpg'),
(1002, 'Alexander', 'Clarke', 'alexander.clarke@email.com', 'male', '+1 (555) 234-56', 'Dau homesite', '../uploads/boy2.jpg'),
(1003, 'Marcus', 'Thompson', 'marcus.thompson@email.com', 'male', '+1 (555) 345-67', 'Dau homesite', '../uploads/boy3.jpg'),
(1004, 'Nathan', 'Patel', 'nathan.patel@email.com', 'male', '+1 (555) 456-78', 'Dau homesite', '../uploads/boy4.jpg'),
(1005, 'Christopher', 'Hayes', 'christopher.hayes@email.com', 'male', '+1 (555) 567-89', 'Dau homesite', '../uploads/boy5.jpg'),
(1006, ' Emily', 'Carter', 'emily.carter@email.com', 'male', '+1 (555) 678-90', 'Dau homesite', '../uploads/gr1.jpg'),
(1007, 'Olivia', 'Baker', 'olivia.baker@email.com', 'male', '+1 (555) 789-01', 'Dau homesite', '../uploads/gr2.jpg'),
(1008, 'Sophia', 'Lee', 'sophia.lee@email.com', 'female', '+1 (555) 890-12', 'Dau homesite', '../uploads/gr3.jpg'),
(1009, 'Isabella', 'Garcia', 'isabella.garcia@email.com', 'female', '+1 (555) 901-23', 'Dau homesite', '../uploads/gr4.jpg'),
(1010, 'Amelia', 'Wright', 'amelia.wright@email.com', 'female', '+1 (555) 012-34', 'Dau homesite', '../uploads/gr5.jpg'),
(1011, 'Daniel', 'Mitchell', 'daniel.mitchell@email.com', 'male', '+1 (555) 123-45', 'Dau homesite', '../uploads/boy6.jpg'),
(1012, 'sdad', 'asdas', 'user1@gmail.com', 'male', '13123123', 'mabalcat', '../uploads/442443929_2775999859217603_5744701398569149633_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_tbl`
--

CREATE TABLE `feedback_tbl` (
  `feedback_id` int(50) NOT NULL,
  `answer` int(50) NOT NULL,
  `date` date NOT NULL,
  `question` varchar(200) NOT NULL,
  `question_id` int(50) NOT NULL,
  `student_id` int(50) NOT NULL,
  `faculty_id` int(50) NOT NULL,
  `subject_id` int(50) NOT NULL,
  `evaluation_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback_tbl`
--

INSERT INTO `feedback_tbl` (`feedback_id`, `answer`, `date`, `question`, `question_id`, `student_id`, `faculty_id`, `subject_id`, `evaluation_id`) VALUES
(107, 5, '2024-03-31', 'Shows up on time and is well-prepared for class.', 1, 100132, 1007, 102, 2),
(108, 5, '2024-03-31', 'Lesson plans are clear and well-structured.', 2, 100132, 1007, 102, 2),
(109, 5, '2024-03-31', 'Maintains discipline and manages classroom effectively.\r\n', 3, 100132, 1007, 102, 2),
(110, 5, '2024-03-31', 'Creates a positive learning environment.', 4, 100132, 1007, 102, 2),
(111, 5, '2024-03-31', 'Explains concepts clearly and effectively.', 5, 100132, 1007, 102, 2),
(112, 5, '2024-03-31', ' Uses a variety of teaching methods to accommodate different learning styles.', 6, 100132, 1007, 102, 2),
(113, 5, '2024-03-31', ' Dresses appropriately and maintains a professional demeanor.', 7, 100132, 1007, 102, 2),
(114, 5, '2024-03-31', 'Shows up on time and is well-prepared for class.', 1, 100132, 1001, 101, 3),
(115, 5, '2024-03-31', 'Lesson plans are clear and well-structured.', 2, 100132, 1001, 101, 3),
(116, 5, '2024-03-31', 'Maintains discipline and manages classroom effectively.\r\n', 3, 100132, 1001, 101, 3),
(117, 4, '2024-03-31', 'Creates a positive learning environment.', 4, 100132, 1001, 101, 3),
(118, 4, '2024-03-31', 'Explains concepts clearly and effectively.', 5, 100132, 1001, 101, 3),
(119, 4, '2024-03-31', ' Uses a variety of teaching methods to accommodate different learning styles.', 6, 100132, 1001, 101, 3),
(120, 3, '2024-03-31', ' Dresses appropriately and maintains a professional demeanor.', 7, 100132, 1001, 101, 3),
(121, 1, '2024-03-31', 'Shows up on time and is well-prepared for class.', 1, 100132, 1002, 103, 4),
(122, 5, '2024-03-31', 'Lesson plans are clear and well-structured.', 2, 100132, 1002, 103, 4),
(123, 4, '2024-03-31', 'Maintains discipline and manages classroom effectively.\r\n', 3, 100132, 1002, 103, 4),
(124, 3, '2024-03-31', 'Creates a positive learning environment.', 4, 100132, 1002, 103, 4),
(125, 2, '2024-03-31', 'Explains concepts clearly and effectively.', 5, 100132, 1002, 103, 4),
(126, 1, '2024-03-31', ' Uses a variety of teaching methods to accommodate different learning styles.', 6, 100132, 1002, 103, 4),
(127, 1, '2024-03-31', ' Dresses appropriately and maintains a professional demeanor.', 7, 100132, 1002, 103, 4),
(128, 1, '2024-03-31', 'Shows up on time and is well-prepared for class.', 1, 100132, 1007, 107, 5),
(129, 2, '2024-03-31', 'Lesson plans are clear and well-structured.', 2, 100132, 1007, 107, 5),
(130, 4, '2024-03-31', 'Maintains discipline and manages classroom effectively.\r\n', 3, 100132, 1007, 107, 5),
(131, 5, '2024-03-31', 'Creates a positive learning environment.', 4, 100132, 1007, 107, 5),
(132, 5, '2024-03-31', 'Explains concepts clearly and effectively.', 5, 100132, 1007, 107, 5),
(133, 5, '2024-03-31', ' Uses a variety of teaching methods to accommodate different learning styles.', 6, 100132, 1007, 107, 5),
(134, 5, '2024-03-31', ' Dresses appropriately and maintains a professional demeanor.', 7, 100132, 1007, 107, 5),
(135, 1, '2024-05-12', 'Shows up on time and is well-prepared for class.', 1, 1101, 1001, 101, 6),
(136, 1, '2024-05-12', 'Lesson plans are clear and well-structured.', 2, 1101, 1001, 101, 6),
(137, 1, '2024-05-12', 'Maintains discipline and manages classroom effectively.\r\n', 3, 1101, 1001, 101, 6),
(138, 2, '2024-05-12', 'Creates a positive learning environment.', 4, 1101, 1001, 101, 6),
(139, 2, '2024-05-12', 'Explains concepts clearly and effectively.', 5, 1101, 1001, 101, 6),
(140, 3, '2024-05-12', ' Uses a variety of teaching methods to accommodate different learning styles.', 6, 1101, 1001, 101, 6),
(141, 3, '2024-05-12', ' Dresses appropriately and maintains a professional demeanor.', 7, 1101, 1001, 101, 6),
(142, 1, '2024-05-27', 'Shows up on time and is well-prepared for class.', 1, 2131233, 1001, 101, 7),
(143, 1, '2024-05-27', 'Lesson plans are clear and well-structured.', 2, 2131233, 1001, 101, 7),
(144, 1, '2024-05-27', 'Maintains discipline and manages classroom effectively.\r\n', 3, 2131233, 1001, 101, 7),
(145, 1, '2024-05-27', 'Creates a positive learning environment.', 4, 2131233, 1001, 101, 7),
(146, 1, '2024-05-27', 'Explains concepts clearly and effectively.', 5, 2131233, 1001, 101, 7),
(147, 5, '2024-05-27', ' Uses a variety of teaching methods to accommodate different learning styles.', 6, 2131233, 1001, 101, 7),
(148, 5, '2024-05-27', ' Dresses appropriately and maintains a professional demeanor.', 7, 2131233, 1001, 101, 7),
(149, 5, '2024-06-02', 'Shows up on time and is well-prepared for class.', 1, 1103, 1002, 103, 8),
(150, 3, '2024-06-02', 'Lesson plans are clear and well-structured.', 2, 1103, 1002, 103, 8),
(151, 2, '2024-06-02', 'Maintains discipline and manages classroom effectively.\r\n', 3, 1103, 1002, 103, 8),
(152, 1, '2024-06-02', 'Creates a positive learning environment.', 4, 1103, 1002, 103, 8),
(153, 1, '2024-06-02', 'Explains concepts clearly and effectively.', 5, 1103, 1002, 103, 8),
(154, 1, '2024-06-02', ' Uses a variety of teaching methods to accommodate different learning styles.', 6, 1103, 1002, 103, 8),
(155, 1, '2024-06-02', ' Dresses appropriately and maintains a professional demeanor.', 7, 1103, 1002, 103, 8),
(156, 1, '2024-06-03', 'Shows up on time and is well-prepared for class.', 1, 11101, 1002, 103, 9),
(157, 1, '2024-06-03', 'Lesson plans are clear and well-structured.', 2, 11101, 1002, 103, 9),
(158, 2, '2024-06-03', 'Maintains discipline and manages classroom effectively.\r\n', 3, 11101, 1002, 103, 9),
(159, 1, '2024-06-03', 'Creates a positive learning environment.', 4, 11101, 1002, 103, 9),
(160, 1, '2024-06-03', 'Explains concepts clearly and effectively.', 5, 11101, 1002, 103, 9),
(161, 1, '2024-06-03', ' Uses a variety of teaching methods to accommodate different learning styles.', 6, 11101, 1002, 103, 9),
(162, 1, '2024-06-03', ' Dresses appropriately and maintains a professional demeanor.', 7, 11101, 1002, 103, 9);

-- --------------------------------------------------------

--
-- Table structure for table `login_tbl`
--

CREATE TABLE `login_tbl` (
  `login_id` int(50) NOT NULL,
  `uid` int(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(200) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_tbl`
--

INSERT INTO `login_tbl` (`login_id`, `uid`, `password`, `role`, `status`) VALUES
(8, 1100, 'admin', 'Admin', ''),
(23, 11101, 'user', 'Student', ''),
(24, 11102, 'user', 'Student', ''),
(27, 11103, 'user', 'Student', ''),
(28, 11010, 'user', 'Student', ''),
(29, 11011, 'user', 'Student', ''),
(30, 11105, 'user', 'Student', ''),
(31, 110011, '123', 'Student', '');

-- --------------------------------------------------------

--
-- Table structure for table `questions_tbl`
--

CREATE TABLE `questions_tbl` (
  `question_id` int(50) NOT NULL,
  `question` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions_tbl`
--

INSERT INTO `questions_tbl` (`question_id`, `question`) VALUES
(18, '123213123');

-- --------------------------------------------------------

--
-- Table structure for table `rating_tbl`
--

CREATE TABLE `rating_tbl` (
  `rating_id` int(20) NOT NULL,
  `rating` int(20) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `student_id` int(20) NOT NULL,
  `faculty_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section_tbl`
--

CREATE TABLE `section_tbl` (
  `section_id` int(20) NOT NULL,
  `section_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section_tbl`
--

INSERT INTO `section_tbl` (`section_id`, `section_name`) VALUES
(1, 'AE3AA'),
(2, 'AE1AA'),
(3, 'BA1AA'),
(4, 'BA3AA'),
(5, 'GU2'),
(6, 'AH1AA'),
(7, 'AH3AA'),
(8, 'AH1AB'),
(9, 'GP2'),
(10, 'GC2'),
(11, 'GA2'),
(12, 'GB2');

-- --------------------------------------------------------

--
-- Table structure for table `student_tbl`
--

CREATE TABLE `student_tbl` (
  `id` int(10) NOT NULL,
  `student_id` int(20) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `yearlevel` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_tbl`
--

INSERT INTO `student_tbl` (`id`, `student_id`, `firstname`, `lastname`, `email`, `gender`, `yearlevel`, `status`, `photo`, `course_id`, `section_id`, `password`) VALUES
(56, 11101, 'john terrence', 'garcia', 'johnterrencegarcia01@gmail.com', 'Male', '1st year', '', '../uploads/students/442443929_2775999859217603_5744701398569149633_n.jpg', 1001, 1, 'user'),
(57, 11102, 'john terrence', 'garcia', 'johnterrencegarcia01@gmail.com', 'Male', '1st year', '', '../uploads/students/441873153_457869833423950_5815786262722119163_n.jpg', 1001, 1, 'user'),
(60, 11103, 'faye', 'sheesh', 'fayesheesh@gmail.com', 'Male', '1st year', '', '../uploads/students/441873153_457869833423950_5815786262722119163_n.jpg', 1001, 1, 'user'),
(61, 11010, 'test1', 'user', 'user11@gmail.com', 'Male', '1st year', '', '../uploads/students/ninja-kamui-oni-mask-joe-higan-hd-wallpaper-uhdpaper.com-240@1@o.jpg', 1003, 6, 'user'),
(62, 11011, 'test123', '1231s', 'userako1123@gmail.com', 'Male', '1st year', '', '../uploads/students/2024_05_09_saitama-22522162.png', 1001, 4, 'user'),
(63, 11105, 'kyke ', 'smith', 'kyle@gmail.com', 'Female', '4th year', '', '../uploads/students/441873153_457869833423950_5815786262722119163_n.jpg', 1001, 1, 'user'),
(64, 110011, 'test', 'test', 'user@gmail.com', 'Male', '3rd year', '', '../uploads/students/436656438_1154361935606511_5898086442169245716_n.jpg', 1002, 1, '123');

-- --------------------------------------------------------

--
-- Table structure for table `subject_tbl`
--

CREATE TABLE `subject_tbl` (
  `subject_id` int(50) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `discription` varchar(100) NOT NULL,
  `units` varchar(10) NOT NULL,
  `id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_tbl`
--

INSERT INTO `subject_tbl` (`subject_id`, `subject_name`, `discription`, `units`, `id`) VALUES
(101, 'COS105', 'ADVANCE PROGRAMMING 3', '3', 12),
(102, 'COS106', 'PROJECT MANAGEMENT', '3', 13),
(103, 'COMP105', 'VISUAL GRAPHICS & DESIGN 2 (USING AUTOCAD)', '3', 14),
(104, 'COMP107', 'DESKTOP PUBLISHING', '3', 15),
(105, 'ENG103', 'SPEECH AND ORAL COMMUNICATIONS', '3', 16),
(106, 'PRACTICM', 'PRACTICUM', '3', 17),
(107, 'PE4', 'MARTIAL ARTS', '2', 18),
(108, 'COMP104', 'VISUAL GRAPHICS & DESIGN 1 (USING COREL & PHOTOSHOP)', '3', 19),
(109, 'PE3', 'DANCING & RHYTHMIC ACTIVITIES', '2', 20),
(110, 'HUBORG1', 'HUMAN BEHAVIOUR IN AN ORGANIZATION', '3', 21),
(111, 'CCM101', 'CALL CENTER MODULE', '6', 22);

-- --------------------------------------------------------

--
-- Table structure for table `subsection_tbl`
--

CREATE TABLE `subsection_tbl` (
  `subsec_id` int(50) NOT NULL,
  `section_id` int(50) NOT NULL,
  `subject_id` int(50) NOT NULL,
  `faculty_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subsection_tbl`
--

INSERT INTO `subsection_tbl` (`subsec_id`, `section_id`, `subject_id`, `faculty_id`) VALUES
(63, 1, 103, 1002),
(64, 1, 108, 1008),
(68, 1, 102, 1003);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `uid` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'student',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `student_id`, `uid`, `password`, `role`, `date`) VALUES
(22, 0, 101, '111', 'Student', '2024-01-30 14:34:07'),
(24, 0, 111, '111', 'Admin', '2024-03-29 21:29:51'),
(29, 0, 12221, 'user', 'Student', '2024-05-26 20:29:31'),
(30, 0, 123123, '123', 'Student', '2024-05-26 21:15:51'),
(31, 0, 2011, 'aaa', 'Student', '2024-05-27 01:28:00'),
(32, 0, 2011, 'aaa', 'Student', '2024-05-27 01:28:23'),
(33, 0, 1100, 'admin', 'Student', '2024-05-29 18:04:46'),
(34, 0, 12312, '123', 'Student', '2024-05-30 15:42:37'),
(35, 0, 12345, '12345', 'Student', '2024-05-30 21:04:46');

-- --------------------------------------------------------

--
-- Table structure for table `yearlevel_tbl`
--

CREATE TABLE `yearlevel_tbl` (
  `yearlevel_id` int(50) NOT NULL,
  `yearlevel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `yearlevel_tbl`
--

INSERT INTO `yearlevel_tbl` (`yearlevel_id`, `yearlevel`) VALUES
(5, '1st year'),
(6, '2nd year'),
(7, '3rd year'),
(8, '4th year');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessid_tbl`
--
ALTER TABLE `accessid_tbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `active_tbl`
--
ALTER TABLE `active_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_tbl`
--
ALTER TABLE `course_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation_tbl`
--
ALTER TABLE `evaluation_tbl`
  ADD PRIMARY KEY (`evaluation_id`);

--
-- Indexes for table `feedback_tbl`
--
ALTER TABLE `feedback_tbl`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `login_tbl`
--
ALTER TABLE `login_tbl`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `questions_tbl`
--
ALTER TABLE `questions_tbl`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `student_tbl`
--
ALTER TABLE `student_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_tbl`
--
ALTER TABLE `subject_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subsection_tbl`
--
ALTER TABLE `subsection_tbl`
  ADD PRIMARY KEY (`subsec_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yearlevel_tbl`
--
ALTER TABLE `yearlevel_tbl`
  ADD PRIMARY KEY (`yearlevel_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessid_tbl`
--
ALTER TABLE `accessid_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `active_tbl`
--
ALTER TABLE `active_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_tbl`
--
ALTER TABLE `course_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `evaluation_tbl`
--
ALTER TABLE `evaluation_tbl`
  MODIFY `evaluation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `feedback_tbl`
--
ALTER TABLE `feedback_tbl`
  MODIFY `feedback_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `login_tbl`
--
ALTER TABLE `login_tbl`
  MODIFY `login_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `questions_tbl`
--
ALTER TABLE `questions_tbl`
  MODIFY `question_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `student_tbl`
--
ALTER TABLE `student_tbl`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `subject_tbl`
--
ALTER TABLE `subject_tbl`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `subsection_tbl`
--
ALTER TABLE `subsection_tbl`
  MODIFY `subsec_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `yearlevel_tbl`
--
ALTER TABLE `yearlevel_tbl`
  MODIFY `yearlevel_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
