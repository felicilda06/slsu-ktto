-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 03, 2023 at 11:21 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slsu_kttoDb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts`
--

CREATE TABLE `tbl_accounts` (
  `id` int(11) NOT NULL,
  `studentId` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(75) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(20) NOT NULL,
  `technology_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_accounts`
--

INSERT INTO `tbl_accounts` (`id`, `studentId`, `email`, `name`, `password`, `usertype`, `technology_type`) VALUES
(22, '161013101', 'juviecano10@gmail.com', 'Juvie Cano', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'patent drafter', 'chemical'),
(29, '', 'admin@gmail.com', 'IPOPHIL', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', ''),
(31, '1610131-1', 'jheselleabrea@gmail.com', 'Jheselle Abrea', '1f8539ec58cfc972ef11495488a5a4eb198d25b7', 'maker', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_codes`
--

CREATE TABLE `tbl_codes` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `code` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_codes`
--

INSERT INTO `tbl_codes` (`id`, `email`, `code`) VALUES
(16, 'juviecano10@gmail.com', 4267);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_college`
--

CREATE TABLE `tbl_college` (
  `id` int(11) NOT NULL,
  `college` varchar(255) NOT NULL,
  `userId` int(11) NOT NULL,
  `default_item` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_college`
--

INSERT INTO `tbl_college` (`id`, `college`, `userId`, `default_item`) VALUES
(1, 'CCSIT', 0, 1),
(2, 'CET', 0, 1),
(3, 'CAFES', 0, 1),
(4, 'COT', 0, 1),
(5, 'CoE', 0, 1),
(6, 'CAALS', 0, 1),
(7, 'CHTM', 0, 1),
(9, 'New', 31, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `id` int(11) NOT NULL,
  `comments` varchar(10000) NOT NULL,
  `maker_id` int(11) NOT NULL,
  `patent_id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `sender_name` varchar(75) NOT NULL,
  `read` tinyint(1) NOT NULL,
  `created_at` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_comments`
--

INSERT INTO `tbl_comments` (`id`, `comments`, `maker_id`, `patent_id`, `sender`, `receiver`, `sender_name`, `read`, `created_at`) VALUES
(82, 'Juvie Cano uploaded new file.', 41, 22, 22, 31, 'Juvie Cano', 0, 'December 12, 2022 08:22:15'),
(83, 'Juvie Cano uploaded a formality result.', 42, 22, 22, 42, 'Juvie Cano', 0, 'December 12, 2022 08:43:20'),
(84, 'Juvie Cano uploaded a formality result.', 41, 22, 22, 41, 'Juvie Cano', 0, 'December 12, 2022 09:27:13'),
(91, 'Juvie Cano uploaded a new formality result.', 41, 22, 22, 41, 'Juvie Cano', 0, 'December 12, 2022 09:38:26'),
(93, 'Juvie Cano uploaded acknowledgement reciept.', 41, 22, 22, 41, 'Juvie Cano', 0, 'December 12, 2022 09:48:16'),
(94, 'Juvie Cano uploaded acknowledgement reciept.', 41, 22, 22, 41, 'Juvie Cano', 0, 'December 12, 2022 09:49:56'),
(95, 'Juvie Cano uploaded acknowledgement reciept.', 41, 22, 22, 41, 'Juvie Cano', 0, 'December 12, 2022 09:49:56'),
(96, 'Juvie Cano uploaded acknowledgement reciept.', 41, 22, 22, 41, 'Juvie Cano', 0, 'December 12, 2022 09:49:56'),
(97, 'Juvie Cano uploaded notice of withdrawal.', 41, 22, 22, 41, 'Juvie Cano', 0, 'December 12, 2022 09:55:41'),
(98, 'Juvie Cano uploaded notice of withdrawal.', 41, 22, 22, 41, 'Juvie Cano', 0, 'December 12, 2022 09:57:07'),
(99, 'Juvie Cano uploaded notice of publication.', 42, 22, 22, 42, 'Juvie Cano', 0, 'December 12, 2022 10:02:30'),
(100, 'Juvie Cano uploaded a certification.', 42, 22, 22, 42, 'Juvie Cano', 0, 'December 12, 2022 10:05:48'),
(101, 'Juvie Cano uploaded a response.', 42, 22, 22, 42, 'Juvie Cano', 0, 'December 12, 2022 10:09:43'),
(103, 'thanks', 41, 22, 31, 41, 'Jheselle Abrea', 0, 'December 12, 2022 10:19:10'),
(104, 'thanks for the updates', 42, 22, 31, 42, 'Jheselle Abrea', 0, 'December 12, 2022 10:20:18'),
(106, 'welcome', 41, 22, 22, 41, 'Juvie Cano', 0, 'December 12, 2022 10:55:03'),
(107, 'your welcome', 42, 22, 22, 42, 'Juvie Cano', 0, 'December 12, 2022 10:55:34'),
(108, 'keep up the good work :)', 41, 29, 29, 41, 'IPOPHIL', 0, 'December 12, 2022 10:57:52'),
(109, 'Juvie Cano uploaded a response.', 43, 22, 22, 43, 'Juvie Cano', 0, 'December 14, 2022 07:45:08'),
(110, 'undefined uploaded a drafted document.', 43, 29, 29, 43, 'undefined', 0, 'December 14, 2022 08:07:57'),
(111, 'undefined uploaded notice of publication.', 41, 29, 29, 41, 'undefined', 0, 'December 14, 2022 08:09:57'),
(112, 'undefined uploaded notice of publication.', 41, 29, 29, 41, 'undefined', 0, 'December 14, 2022 08:09:57'),
(113, 'undefined uploaded notice of publication.', 41, 29, 29, 41, 'undefined', 0, 'December 14, 2022 08:09:57'),
(114, 'undefined uploaded notice of publication.', 41, 29, 29, 41, 'undefined', 0, 'December 14, 2022 08:13:32'),
(115, 'undefined uploaded a response.', 43, 29, 29, 43, 'undefined', 0, 'December 14, 2022 08:36:09'),
(116, 'undefined uploaded a new formality result.', 43, 29, 29, 43, 'undefined', 0, 'December 14, 2022 08:42:48'),
(117, 'undefined uploaded a new formality result.', 43, 29, 29, 43, 'undefined', 0, 'December 14, 2022 08:42:48'),
(118, 'undefined uploaded a drafted document.', 41, 29, 29, 41, 'undefined', 0, 'December 14, 2022 08:49:30'),
(119, 'undefined uploaded a drafted document.', 41, 29, 29, 41, 'undefined', 0, 'December 14, 2022 08:50:29'),
(120, 'undefined uploaded a drafted document.', 41, 29, 29, 41, 'undefined', 0, 'December 14, 2022 08:50:29'),
(121, 'undefined uploaded a drafted document.', 42, 29, 29, 42, 'undefined', 0, 'December 14, 2022 08:52:29'),
(122, 'undefined uploaded a drafted document.', 42, 29, 29, 42, 'undefined', 0, 'December 14, 2022 08:52:29'),
(123, 'undefined uploaded a new formality result.', 41, 29, 29, 41, 'undefined', 0, 'December 14, 2022 08:53:49'),
(124, 'undefined uploaded a new formality result.', 41, 29, 29, 41, 'undefined', 0, 'December 14, 2022 08:55:27'),
(125, 'undefined uploaded a response.', 43, 29, 29, 43, 'undefined', 0, 'December 14, 2022 08:56:01'),
(126, 'undefined uploaded a response.', 43, 29, 29, 43, 'undefined', 0, 'December 14, 2022 08:56:01'),
(127, 'undefined uploaded a response.', 43, 29, 29, 43, 'undefined', 0, 'December 14, 2022 08:56:01'),
(128, 'Juvie Cano uploaded notice of publication.', 41, 22, 22, 41, 'Juvie Cano', 0, 'December 14, 2022 08:56:39'),
(129, 'Juvie Cano uploaded a certification.', 41, 22, 22, 41, 'Juvie Cano', 0, 'December 15, 2022 10:53:21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_documents`
--

CREATE TABLE `tbl_documents` (
  `id` int(11) NOT NULL,
  `formality_result` varchar(255) NOT NULL,
  `acknowledgement_receipt` varchar(255) NOT NULL,
  `notice_of_withdrawal` varchar(255) NOT NULL,
  `notice_of_publication` varchar(255) NOT NULL,
  `certification` varchar(255) NOT NULL,
  `log_submission_status` varchar(255) NOT NULL,
  `response` varchar(255) NOT NULL,
  `drafted_documents` varchar(255) NOT NULL,
  `patent_id` int(11) NOT NULL,
  `maker_id` int(11) NOT NULL,
  `study_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_documents`
--

INSERT INTO `tbl_documents` (`id`, `formality_result`, `acknowledgement_receipt`, `notice_of_withdrawal`, `notice_of_publication`, `certification`, `log_submission_status`, `response`, `drafted_documents`, `patent_id`, `maker_id`, `study_id`) VALUES
(35, 'formality_result_42_sample (1).pdf', '', '', 'notice_of_publication_42_Screenshot (6).png', 'certification_42_Screenshot (3).png', '', 'response_42_Screenshot (2).png', '', 22, 42, 42),
(36, 'formality_result_41_Layout1 (5) (1).docx', 'acknowledgement_receipt_41_sample (1).pdf', 'notice_of_withdrawal_41_Screenshot (1).png', 'notice_of_publication_41_sample.pdf', 'certification_41_Screenshot (1) (3).png', '', 'response_43_Layout1 (4).docx', 'drafted_documents_41_Screenshot (1) (6).png', 22, 41, 41),
(37, '', '', '', '', '', '', 'response_43_Layout1 (4).docx', 'drafted_documents43_Screenshot (1).png', 22, 43, 43);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_document_types`
--

CREATE TABLE `tbl_document_types` (
  `id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_document_types`
--

INSERT INTO `tbl_document_types` (`id`, `label`, `value`) VALUES
(1, 'Drafted Documents', 'drafted documents'),
(2, 'Formality Exam Result', 'formality exam result');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_log_submission`
--

CREATE TABLE `tbl_log_submission` (
  `id` int(11) NOT NULL,
  `application_no` varchar(50) NOT NULL,
  `title` varchar(75) NOT NULL,
  `creator` varchar(75) NOT NULL,
  `ip_type` varchar(10) NOT NULL,
  `college` varchar(75) NOT NULL,
  `dragon_pay` varchar(75) NOT NULL,
  `application_date` varchar(50) NOT NULL,
  `agent` varchar(50) NOT NULL,
  `drafter` varchar(75) NOT NULL,
  `document_where_about` varchar(75) NOT NULL,
  `publication_date` varchar(50) NOT NULL,
  `publication_vol` varchar(10) NOT NULL,
  `publication_no` varchar(10) NOT NULL,
  `registration_date` varchar(50) NOT NULL,
  `registration_date_vol` varchar(10) NOT NULL,
  `registration_date_no` varchar(10) NOT NULL,
  `examiner` varchar(50) NOT NULL,
  `status` varchar(100) NOT NULL,
  `remark_1` varchar(100) NOT NULL,
  `remark_2` varchar(100) NOT NULL,
  `office_remark` varchar(100) NOT NULL,
  `action_step_1` varchar(75) NOT NULL,
  `action_step_2` varchar(75) NOT NULL,
  `certificate_office` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_log_submission`
--

INSERT INTO `tbl_log_submission` (`id`, `application_no`, `title`, `creator`, `ip_type`, `college`, `dragon_pay`, `application_date`, `agent`, `drafter`, `document_where_about`, `publication_date`, `publication_vol`, `publication_no`, `registration_date`, `registration_date_vol`, `registration_date_no`, `examiner`, `status`, `remark_1`, `remark_2`, `office_remark`, `action_step_1`, `action_step_2`, `certificate_office`) VALUES
(32, '161013101', 'Transformer', 'Jheselle Abrea', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profiles`
--

CREATE TABLE `tbl_profiles` (
  `id` int(11) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `contact_no` varchar(11) NOT NULL,
  `gender` varchar(25) NOT NULL,
  `createdAt` varchar(75) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_profiles`
--

INSERT INTO `tbl_profiles` (`id`, `profile`, `age`, `contact_no`, `gender`, `createdAt`, `userId`) VALUES
(1, 'mahal.jpg', 22, '09557861231', 'female', '', 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_studies`
--

CREATE TABLE `tbl_studies` (
  `id` int(11) NOT NULL,
  `title` varchar(75) NOT NULL,
  `proponent` varchar(75) NOT NULL,
  `technology_type` varchar(25) NOT NULL,
  `contact_information` varchar(11) NOT NULL,
  `file` varchar(100) NOT NULL,
  `authors` varchar(255) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `status` varchar(15) NOT NULL,
  `bg_color` varchar(25) NOT NULL,
  `is_new_uploaded` tinyint(1) NOT NULL,
  `userId` int(11) NOT NULL,
  `has_log_submission` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_studies`
--

INSERT INTO `tbl_studies` (`id`, `title`, `proponent`, `technology_type`, `contact_information`, `file`, `authors`, `created_at`, `status`, `bg_color`, `is_new_uploaded`, `userId`, `has_log_submission`) VALUES
(41, 'Transformer', 'test 11', 'chemical', '08908909808', 'file-sample_100kB.doc', 'jheselleabrea@gmail.com', 'December 12, 2022', 'Accept', 'a5ffc5', 1, 31, 1),
(42, 'Cinderella', 'test 2', 'chemical', '08908997865', 'pexels-mike-b-170811.jpg', 'jheselleabrea@gmail.com', 'December 12, 2022', 'Accept', 'a5ffc5', 0, 31, 0),
(43, 'John Wick', 'test 1', 'chemical', '08908089089', 'Layout1 (5) (1).docx', 'jheselleabrea@gmail.com', 'December 14, 2022', 'Accept', 'a5ffc5', 0, 31, 0),
(44, 'Kong: Skull Island', 'test', 'chemical', '08908908908', 'Guide.docx', 'jheselleabrea@gmail.com', 'December 16, 2022', 'Pending', 'e3e5e6', 0, 31, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_codes`
--
ALTER TABLE `tbl_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_college`
--
ALTER TABLE `tbl_college`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_document_types`
--
ALTER TABLE `tbl_document_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_log_submission`
--
ALTER TABLE `tbl_log_submission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `tbl_studies`
--
ALTER TABLE `tbl_studies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_codes`
--
ALTER TABLE `tbl_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_college`
--
ALTER TABLE `tbl_college`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_document_types`
--
ALTER TABLE `tbl_document_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_log_submission`
--
ALTER TABLE `tbl_log_submission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_studies`
--
ALTER TABLE `tbl_studies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
  ADD CONSTRAINT `tbl_profiles_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `tbl_accounts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
