-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2026 at 06:21 AM
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
-- Database: `association_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_achievements`
--

CREATE TABLE `academic_achievements` (
  `id` int(11) NOT NULL,
  `date_duration` varchar(255) DEFAULT NULL,
  `student` varchar(1000) DEFAULT NULL,
  `year_department` varchar(255) DEFAULT NULL,
  `activity_event` varchar(1000) DEFAULT NULL,
  `achievement_role` varchar(1000) DEFAULT NULL,
  `organization_venue` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `academic_year` varchar(20) NOT NULL DEFAULT '2024-2025'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_achievements`
--

INSERT INTO `academic_achievements` (`id`, `date_duration`, `student`, `year_department`, `activity_event`, `achievement_role`, `organization_venue`, `created_at`, `academic_year`) VALUES
(1, '08/03/2025', 'Shanmugapriya N, Pavithra M', 'I IT', 'Women’s Day Tableau Event', 'II Prize (₹3000)', 'Collector Office, Theni', '2026-09-23 09:34:45', '2024-2025'),
(2, 'Oct-2025', 'B. Sujitha', 'II IT', 'Data Visualization with Power BI', 'Completed', 'Great Learning', '2026-09-23 09:34:45', '2024-2025'),
(3, '14/10/2025', 'T. Safrin', 'II IT', 'Software Development', 'Completed', 'Skill Up', '2026-09-23 09:34:45', '2024-2025'),
(4, '26/01/2025', 'S. Logeswari', 'II IT', 'BootCamp', 'Completed', 'NoviTech', '2026-09-23 09:34:45', '2024-2025'),
(5, '26/12/2025–02/02/2025', 'R. Vaitheeshwari', 'II IT', 'Master Class', 'Completed', 'NoviTech', '2026-09-23 09:34:45', '2024-2025'),
(6, '01/01/2025–28/02/2025', 'S. Vigneshwar', 'II IT', 'Internship (offline)', 'Completed', 'Bluestock Fintech', '2026-09-23 09:34:45', '2024-2025'),
(7, '25/10/2025', 'A. Suryaprakash', 'III IT', 'Data Science Foundation; Android App Development', 'Completed', 'Great Learning', '2026-09-23 09:34:45', '2024-2025'),
(8, '02/01/2025–05/02/2025', 'K. Pravin', 'III IT', 'Data Visualization Internship (online)', 'Completed', 'Forage', '2026-09-23 09:34:45', '2024-2025'),
(9, '03/02/2025–15/02/2025', 'M. Sarvaji', 'III IT', 'Internship (offline)', 'Completed', 'Blankspace Technologies LLP, Bengaluru', '2026-09-23 09:34:45', '2024-2025'),
(10, '03/03/2025–05/03/2025', 'M. Sarvaji', 'III IT', 'Git & GitHub Bootcamp', 'Completed', 'Lets Upgrade', '2026-09-23 09:34:45', '2024-2025'),
(11, '07/03/2025', 'M. Sarvaji', 'III IT', 'Quantitative Research Job Simulation', 'Completed', 'Forage', '2026-09-23 09:34:45', '2024-2025'),
(12, '02/02/2025', 'P. Swathi', 'III IT', 'Machine Learning Online Course', 'Completed', 'Fair Forward', '2026-09-23 09:34:45', '2024-2025'),
(13, '05/11/2025', 'R. Yohith Kumar', 'III IT', 'Artificial Intelligence', 'Completed', 'NoviTech R&D Pvt. Ltd.', '2026-09-23 09:34:45', '2024-2025'),
(14, '02/02/2025', 'S. Yamini', 'III IT', 'AI for Beginners; Selling Online', 'Completed', 'HP Life', '2026-09-23 09:34:45', '2024-2025'),
(15, '03/02/2025', 'Sathya Seelan', 'III IT', 'Bootcamp', 'Completed', 'Lets Upgrade', '2026-09-23 09:34:45', '2024-2025'),
(16, '15/03/2025–16/03/2025', 'Sathya Seelan M', 'III IT', 'Netflix clone using HTML & CSS (online)', 'Completed', 'Lets Upgrade', '2026-09-23 09:34:45', '2024-2025'),
(21, '26/06/2025', 'SAHANA G', 'III / IT', 'Prompt Engineering for ChatGPT', 'Achievement', 'Great Learning', '2026-09-24 05:38:18', '2024-2025'),
(22, '19/06/2025', 'SAHANA G', 'III / IT', 'C for Beginners', 'Achievement', 'Great Learning', '2026-09-24 05:38:18', '2024-2025'),
(23, '15/06/2025', 'Yohithkumar R', 'Final Year / IT', 'MERN STACK', 'Achievement', 'Navitech R&D Private Limited', '2026-09-24 05:38:18', '2024-2025'),
(24, '12/06/2025', 'Mohamed Irfan Sheik', 'Final Year / IT', 'Generative AI for all', 'Achievement', 'Infosys Springboard', '2026-09-24 05:38:18', '2024-2025'),
(26, '25/06/2025', 'SAHANA V', 'III / IT', 'Java Servlets Case Study – Email Marketing Tool', 'Java Servlets Case Study', 'Infosys Springboard', '2026-09-24 05:41:37', '2024-2025'),
(27, '26/06/2025', 'SAHANA V', 'III / IT', 'Block chain for Enterprises', 'Blockchain Training', 'Infosys Springboard', '2026-09-24 05:41:37', '2024-2025'),
(28, '26/06/2025', 'Sathya Seelan M', 'Final Year / IT', 'UI / UX Design with Sketch: Travel Booking App', 'UI/UX Design Project', 'Coursera Project Network', '2026-09-24 05:41:37', '2024-2025'),
(29, '10/07/2025', 'SAHANA V', 'III / IT', 'Fundamentals of cryptography', 'Cryptography Training', 'Infosys', '2026-09-24 05:41:37', '2024-2025'),
(30, '17/07/2025', 'SAHANA V', 'III / IT', 'Fundamentals of Information security', 'Information Security Training', 'Infosys', '2026-09-24 05:44:41', '2024-2025'),
(31, '20/07/2025', 'SAHANA V', 'III / IT', 'Identity and access management', 'Identity & Access Management Training', 'Infosys', '2026-09-24 05:44:41', '2024-2025'),
(32, '24/07/2025', 'SAHANA V', 'III / IT', 'Identity governance and administration', 'Identity Governance Training', 'Infosys', '2026-09-24 05:44:41', '2024-2025'),
(33, '01-07-2025 to 18-07-2025', 'VANI SRI M', 'III IT', 'Web Development', 'Completed', 'Hazzino Technologies', '2026-09-24 06:16:27', '2024-2025'),
(34, '01-07-2025 to 18-07-2025', 'ARCHANA DEVI C', 'III IT', 'Web Development', 'Completed', 'Hazzino Technologies', '2026-09-24 06:16:27', '2024-2025'),
(35, '01-07-2025 to 18-07-2025', 'SINDHU S', 'III IT', 'Web Development', 'Completed', 'Hazzino Technologies', '2026-09-24 06:16:27', '2024-2025'),
(36, '30-06-2025 to 16-07-2025', 'SHAHANA V', 'III IT', 'Cyber Security', 'Completed', 'Yaash Technology', '2026-09-24 06:16:27', '2024-2025'),
(37, '30-06-2025 to 14-07-2025', 'DHIVYA DHARSHINI S', 'III IT', 'Full Stack Web Development', 'Completed', 'Phoenix Softech', '2026-09-24 06:16:27', '2024-2025'),
(38, '30-06-2025 to 14-07-2025', 'ISMATH FATHIMA J', 'III IT', 'Full Stack Web Development', 'Completed', 'Phoenix Softech', '2026-09-24 06:16:27', '2024-2025'),
(39, '30-06-2025 to 26-07-2025', 'ANUDARSHNI A', 'III IT', 'Javascript', 'Completed', 'Nxdeep Connectz LLP, Madurai', '2026-09-24 06:16:27', '2024-2025'),
(40, '30-06-2025 to 26-07-2025', 'DHIVYA DHARSHINI', 'III IT', 'Javascript', 'Completed', 'Nxdeep Connectz LLP, Madurai', '2026-09-24 06:16:27', '2024-2025'),
(41, '04-07-2025 to 18-07-2025', 'SONI P', 'III IT', 'App Development', 'Completed', 'Notasco Technologies, Madurai', '2026-09-24 06:16:27', '2024-2025'),
(42, '04-07-2025 to 18-07-2025', 'SOWMIYA K', 'III IT', 'App Development', 'Completed', 'Notasco Technologies, Madurai', '2026-09-24 06:16:27', '2024-2025'),
(43, '04-07-2025 to 18-07-2025', 'NAVEENA G', 'III IT', 'App Development', 'Completed', 'Notasco Technologies, Madurai', '2026-09-24 06:16:27', '2024-2025'),
(44, '01-07-2025 to 31-07-2025', 'LOGESHWARI S', 'III IT', 'Web Development', 'Completed', 'Prodigy Infotech, Mumbai', '2026-09-24 06:18:13', '2024-2025'),
(45, '05-07-2025 to 25-07-2025', 'DIVYASRI P', 'III IT', 'Web Development', 'Completed', 'Rezilyens Systems Software India Pvt. Ltd.', '2026-09-24 06:18:13', '2024-2025'),
(46, '05-07-2025 to 25-07-2025', 'JEBANIKITHA N', 'III IT', 'Web Development', 'Completed', 'Rezilyens Systems Software India Pvt. Ltd.', '2026-09-24 06:18:13', '2024-2025'),
(47, '05-07-2025 to 25-07-2025', 'SIVAYOGGA K', 'III IT', 'Web Development', 'Completed', 'Rezilyens Systems Software India Pvt. Ltd.', '2026-09-24 06:18:13', '2024-2025'),
(48, '12-05-2025 to 12-08-2025', 'NAVEEN', 'IV IT', 'Software Development (Full Stack)', 'Completed', 'WG TECH, NSCET, Theni', '2026-09-24 06:18:13', '2024-2025'),
(49, '12-05-2025 to 12-08-2025', 'BHARATHI B', 'IV IT', 'Software Development (Full Stack)', 'Completed', 'WG TECH, NSCET, Theni', '2026-09-24 06:18:13', '2024-2025'),
(50, '12-05-2025 to 12-08-2025', 'PRAVIN K', 'IV IT', 'Software Development (Full Stack)', 'Completed', 'WG TECH, NSCET, Theni', '2026-09-24 06:18:13', '2024-2025'),
(51, '26-06-2025 to 25-07-2025', 'NAGAJOTHI M', 'IV IT', 'Web Development (Django)', 'Completed', 'QTL Agri Tech, Ramanathapuram', '2026-09-24 06:18:13', '2024-2025'),
(52, '26-06-2025 to 25-07-2025', 'NANDHINI S', 'IV IT', 'Web Development (Django)', 'Completed', 'QTL Agri Tech, Ramanathapuram', '2026-09-24 06:18:13', '2024-2025'),
(53, '26-06-2025 to 25-07-2025', 'NIHILAA K', 'IV IT', 'Web Development (Django)', 'Completed', 'QTL Agri Tech, Ramanathapuram', '2026-09-24 06:18:13', '2024-2025'),
(54, '26-06-2025 to 25-07-2025', 'NATHIYA P', 'IV IT', 'Web Development (Django)', 'Completed', 'QTL Agri Tech, Ramanathapuram', '2026-09-24 06:23:44', '2024-2025'),
(55, '26-06-2025 to 25-07-2025', 'RAMYA PRIYA J', 'IV IT', 'Web Development (Django)', 'Completed', 'QTL Agri Tech, Ramanathapuram', '2026-09-24 06:23:44', '2024-2025'),
(56, '25-06-2025 to 25-07-2025', 'YAMINI S', 'IV IT', 'Web Design and Development', 'Completed', 'Phoenix Softech, Madurai', '2026-09-24 06:23:44', '2024-2025'),
(57, '25-06-2025 to 25-07-2025', 'NAAFIYA SHIRIN A', 'IV IT', 'Web Design and Development', 'Completed', 'Phoenix Softech, Madurai', '2026-09-24 06:23:44', '2024-2025'),
(58, '25-06-2025 to 25-07-2025', 'SWATHI P', 'IV IT', 'Web Design and Development', 'Completed', 'Phoenix Softech, Madurai', '2026-09-24 06:23:44', '2024-2025'),
(59, '25-06-2025 to 25-07-2025', 'RANA SUSMITHA R', 'IV IT', 'Web Design and Development', 'Completed', 'Phoenix Softech, Madurai', '2026-09-24 06:23:44', '2024-2025'),
(60, '01-07-2025 to 01-08-2025', 'SIVASRI V', 'IV IT', 'Full Stack development', 'Completed', 'Diya Robotics, Chennai', '2026-09-24 06:23:44', '2024-2025'),
(61, '26-09-2025 to 27-09-2025', 'SHAHANA V', 'III IT', 'Building D-Apps using Blockchain', 'Completed', 'KPR Institute of Engineering and Technology', '2026-09-24 06:23:44', '2024-2025'),
(62, '24-10-2025 to 27-11-2025', 'Divyasri P', 'III IT', '30 days master class in UI/UX Design', 'Completed', 'NoviTech R&D Private Limited', '2026-09-24 06:23:44', '2024-2025'),
(63, '15-11-2025', 'Abi Gayathri P', 'IV IT', 'Course Completion in GenAI Powered Data Analytics Job Simulation', 'Completed', 'Forage', '2026-09-24 06:23:44', '2024-2025'),
(64, '26-11-2025', 'Abi Gayathri P', 'IV IT', 'Course Completion in Solutions Architecture Job Simulation', 'Completed', 'Forage', '2026-09-24 06:24:56', '2024-2025'),
(65, '28-11-2025', 'Abi Gayathri P', 'IV IT', 'Course Completion in Data Visualization: Empowering Business with Effective Insights', 'Completed', 'Forage', '2026-09-24 06:24:56', '2024-2025'),
(66, '09-12-2025', 'Abi S', 'III IT', 'Build your own Static Website', 'Completed', 'CCBP 4.0 Academy', '2026-09-24 06:24:56', '2024-2025'),
(67, '18-01-2026', 'A.Anudarshni', 'III IT', 'Data science intern', 'Completed', 'Cognifyz Technologies', '2026-09-24 06:24:56', '2024-2025'),
(68, '31-03-2026', 'SONI P', 'III IT', 'Course Completion in Digital Skills: Artificial Intelligence', 'Completed', 'Accenture Future Learn', '2026-09-24 06:24:56', '2024-2025'),
(69, '07-03-2026', 'SONI P', 'III IT', 'Course Completion in What is Generative AI?', 'Completed', 'LinkedIn Learning', '2026-09-24 06:24:56', '2024-2025'),
(70, '09-03-2026', 'SONI P', 'III IT', 'Course Completion in Machine Learning with Python – Level 1', 'Completed', 'IBM', '2026-09-24 06:24:56', '2024-2025'),
(71, '16-03-2026', 'SONI P', 'III IT', 'AI Unlocked: From Basics to Everyday Productivity', 'Completed', 'NSCET, Theni', '2026-09-24 06:24:56', '2024-2025'),
(72, '16-03-2026', 'Thanga Raja Varshini S', 'II IT', 'AI Unlocked: From Basics to Everyday Productivity', 'Completed', 'NSCET, Theni', '2026-09-24 06:24:56', '2024-2025'),
(73, '16-03-2026', 'Lakshmi Priya G', 'II IT', 'AI Unlocked: From Basics to Everyday Productivity', 'Completed', 'NSCET, Theni', '2026-09-24 06:24:56', '2024-2025'),
(84, '26-03-2026', 'Vaitheeshwari R', 'III IT', 'Course Completed in “Introduction to Data Science”', '-', 'Infosys Springboard', '2026-09-24 08:34:29', '2024-2025'),
(85, '13-06-2026', 'Soni P', 'III IT', 'Course completion in “AI Fluency: Framework & Foundations”', '-', 'Higher Education Authority', '2026-09-24 08:34:29', '2024-2025'),
(86, '24-06-2026', 'Yokesh Kumar R', 'III IT', 'Course Completion in “Basics of Python”', '-', 'Cambridge International Qualifications, UK', '2026-09-24 08:34:29', '2024-2025'),
(87, '22-06-2026', 'Yokesh Kumar R', 'III IT', 'Completed in AI-Powered Performance Ads Certification', '-', 'Google Ads AI-Powered Performance', '2026-09-24 08:34:29', '2024-2025'),
(88, '04-06-2026', 'Aishwarya S', 'II IT', 'Course completed in Data Science & Analytics', '-', 'HP Foundation', '2026-09-24 08:34:29', '2024-2025'),
(89, '09-06-2026', 'Aishwarya S', 'II IT', 'Course completed in Introduction to Digital Business Skills', '-', 'HP Foundation', '2026-09-24 08:34:29', '2024-2025'),
(90, '12-06-2026', 'Priyadharshini M', 'III IT', 'Course Completed in Yuva AI for All – Tamil', '-', 'Nasscom', '2026-09-24 08:34:29', '2024-2025'),
(91, '05-07-2026', 'Niroshkumar R', 'II IT', 'Course Completed in “Introduction to Cloud Job Simulation”', '-', 'Forage', '2026-09-24 08:34:29', '2024-2025'),
(92, '05-07-2026', 'Niroshkumar R', 'II IT', 'Course Completed in “Software Engineering Job Simulation”', '-', 'Forage', '2026-09-24 08:34:29', '2024-2025'),
(93, '04-07-2026', 'Niroshkumar R', 'II IT', 'Course Completed in “Technology Software Development Job Simulation”', '-', 'Forage', '2026-09-24 08:34:29', '2024-2025'),
(94, '04-07-2026', 'Niroshkumar R', 'II IT', 'Course Completed in “Generative AI Mastermind”', '-', 'Outskill', '2026-09-24 08:34:29', '2024-2025'),
(95, '01-07-2026', 'Noorul Nafeela A', 'IV IT', 'Course Completed in “Introduction to JIRA”', '-', 'Simplilearn', '2026-09-24 08:34:29', '2024-2025'),
(96, '15-07-2026', 'Sowmiya K', 'IV IT', 'Course Completed in “ChatGPT for Search Engine Optimization”', '-', 'Simplilearn', '2026-09-24 08:34:29', '2024-2025'),
(101, '10-07-2026', 'Niroshkumar R', 'II IT', 'Course Completed in “AI – Data Engineering Analyst”', '-', 'Skill India Digital Hub', '2026-09-24 08:34:29', '2024-2025'),
(102, '17-07-2026', 'Niroshkumar R', 'II IT', 'Course Completed in “Network Security Engineer”', '-', 'Skill India Digital Hub', '2026-09-24 08:34:29', '2024-2025'),
(103, '17-07-2026', 'Niroshkumar R', 'II IT', 'Course Completed in “IoT Security Analyst”', '-', 'Skill India Digital Hub', '2026-09-24 08:34:29', '2024-2025'),
(104, '31-07-2026', 'Niroshkumar R', 'II IT', 'Course Completed in “Video Editing”', '-', 'National Skill Development Corporation', '2026-09-24 08:34:29', '2024-2025'),
(105, '02-07-2026', 'Niroshkumar R', 'II IT', 'Course Completed in “GenAI Powered Data Analytics Job Simulation”', '-', 'Forage', '2026-09-24 08:34:29', '2024-2025'),
(106, '15-08-2026', 'Dhanalakshmi R', 'II IT', 'Course Completed in “Data Science”', '-', 'AURASHELL', '2026-09-24 08:34:29', '2024-2025'),
(107, '15-08-2026', 'Dhanalakshmi R', 'II IT', 'Participated in Master Data Science Demo Class', '-', 'Aurashell', '2026-09-24 08:34:29', '2024-2025'),
(108, '09-08-2026', 'Nirosh Kumar R', 'II IT', 'Completed course in “Get Started with SQL Analytics and BI on Databricks”', '-', 'Simplilearn', '2026-09-24 08:34:29', '2024-2025'),
(109, '20-6-2025', 'Pravin.K', 'IV ', 'Participating in workshop meta ADS 101', 'Participator', 'HCL', '2026-09-24 08:58:39', '2024-2025'),
(110, '20-6-2025', 'Pravin.K', 'IV ', 'Participating in workshop meta ADS 101', 'Participator', 'HCL', '2026-09-24 08:58:56', '2024-2025'),
(111, '21-9-2025', 'Shanmuga priya.N', 'II', 'Interactive Success Bootcamp', 'participator ', 'Anapty codeemy Technologies ', '2026-09-24 09:01:51', '2024-2025'),
(112, '21-9-2025', 'Shanmuga priya.N', 'II', 'Interactive Success Bootcamp', 'participator ', 'Anapty codeemy Technologies ', '2026-09-24 09:02:05', '2024-2025'),
(113, '17-01-2026', 'V SHAHANA', 'III IT', 'Kalaiyum Kannaum Pongalum', 'Participated', 'Dindigul District Administration and Tourism department', '2026-09-24 09:28:03', '2024-2025'),
(114, '17-01-2026', 'V SHAHANA', 'III IT', 'Kalaiyum Kaanum Pongalum', 'Participated', 'OSCAR Book Records', '2026-09-24 09:28:03', '2024-2025'),
(115, '05-01-2026', 'SOWMIYA K', 'III IT', 'Installation & Servicing of CCTV camera, security alarm & smoke detector', 'Training Program Completed', 'Canara Bank Rural Self Employment Training Institute', '2026-09-24 09:28:03', '2024-2025'),
(116, '07-03-2026', 'Pavithra M', 'III IT', 'Google’s ADK', 'Participated in Workshop', 'Coimbatore Institute of Technology, Coimbatore', '2026-09-24 09:28:03', '2024-2025'),
(117, '07-03-2026', 'Siva Sandhya K', 'III IT', 'Google’s ADK', 'Participated in Workshop', 'Coimbatore Institute of Technology, Coimbatore', '2026-09-24 09:28:03', '2024-2025'),
(118, '07-03-2026', 'Vishalini V', 'III IT', 'Google’s ADK', 'Participated in Workshop', 'Coimbatore Institute of Technology, Coimbatore', '2026-09-24 09:28:03', '2024-2025'),
(119, '16-03-2026', 'Monika B', 'III IT', 'AI Unlocked From Basics to Daily Productivity', 'Webinar', 'NSCET, Theni', '2026-09-24 09:28:03', '2024-2025'),
(120, '16-03-2026', 'Shanmugapriya N', 'II IT', 'AI Unlocked From Basics to Daily Productivity', 'Webinar', 'NSCET, Theni', '2026-09-24 09:28:03', '2024-2025'),
(121, '16-03-2026', 'Sindhu S', 'III IT', 'AI Unlocked From Basics to Daily Productivity', 'Webinar', 'NSCET, Theni', '2026-09-24 09:28:03', '2024-2025'),
(122, '30-04-2026', 'Vaitheeshwari R', 'III IT', 'MetaCode: COMPOSIT 31st Edition', 'Webinar', 'Society of Metallurgical Engineers, IIT Kharagpur', '2026-09-24 09:29:54', '2024-2025'),
(123, '01-07-2026', 'Maheswari M', 'III IT', 'Corporate Training Test', 'Completed', 'CodeBind Technologies, Coimbatore', '2026-09-24 09:29:54', '2024-2025'),
(124, '01-07-2026', 'Maheswari M', 'III IT', 'Embedded Systems', 'Attended One day Workshop', 'CodeBind Technologies, Coimbatore', '2026-09-24 09:29:54', '2024-2025'),
(125, '26-03-2026 to 27-03-2026', 'Keerthana S', 'III IT', 'AI SUMMIT 2026: a Keynote Session Series on Emerging AI Trends and Industry Applications', 'Participated', 'Thiagarajar College of Engineering', '2026-09-24 09:29:54', '2024-2025'),
(126, '01-07-2026', 'Anitha S', 'III IT', 'Corporate Training Test', 'Completed', 'CodeBind Technologies, Coimbatore', '2026-09-24 09:29:54', '2024-2025'),
(127, '01-07-2026', 'Anitha S', 'III IT', 'Embedded Systems', 'Attended One day Workshop', 'CodeBind Technologies, Coimbatore', '2026-09-24 09:29:54', '2024-2025'),
(128, '06-07-2026', 'Dhanalakshmi R', 'II IT', 'UI/UX', 'Participated in Webinar', 'National Skill Development Corporation', '2026-09-24 09:29:54', '2024-2025'),
(129, '06-07-2026', 'Nishanthini R', 'II IT', 'UI/UX', 'Participated in Webinar', 'National Skill Development Corporation', '2026-09-24 09:29:54', '2024-2025'),
(130, '06-07-2026', 'Shanmugavalli K', 'II IT', 'UI/UX', 'Participated in Webinar', 'National Skill Development Corporation', '2026-09-24 09:29:54', '2024-2025'),
(131, '13-03-2026', 'Dhanalakshmi R', 'II IT', 'Level up your Career with Generative AI Skills', 'Participated in Workshop', 'GUVI', '2026-09-24 09:29:54', '2024-2025'),
(132, '12-03-2026', 'Dhanalakshmi R', 'II IT', 'Design Faster with Figma - Real Time UI Design & Collaboration', 'Participated in Workshop', 'GUVI', '2026-09-24 09:29:54', '2024-2025'),
(133, '09-07-2026', 'Dhanalakshmi R', 'II IT', 'Digital Marketing', 'Participated webinar', 'National Skill Development Corporation', '2026-09-24 09:29:54', '2024-2025'),
(134, '12-07-2026', 'Dhanalakshmi R', 'II IT', 'Agentic AI', 'Participated webinar', 'National Skill Development Corporation', '2026-09-24 09:29:54', '2024-2025'),
(135, '16-07-2026', 'Dhanalakshmi R', 'II IT', 'Video Editing', 'Participated webinar', 'National Skill Development Corporation', '2026-09-24 09:29:54', '2024-2025'),
(136, '17-07-2026', 'Dhanalakshmi R', 'II IT', 'Data Analytics', 'Participated webinar', 'National Skill Development Corporation', '2026-09-24 09:29:54', '2024-2025'),
(137, '16-07-2026', 'Aishwarya S', 'III IT', 'Agentic AI Foundations – Course Introduction', 'Course Completed', 'AWS Training & Certification', '2026-09-24 09:29:54', '2024-2025'),
(138, '12-07-2026', 'Nishanthini R', 'II IT', 'AI tools and ChatGPT', 'Participated in Workshop', 'Be10X', '2026-09-24 09:29:54', '2024-2025'),
(139, '25-07-2026', 'Prathibha Sivaranjani P', 'II IT', 'Kannadhasan Centenary Ceremony Competitions', 'Participated', 'Hajee Karutha Routhar Kowthiya College, Uthamapalayam', '2026-09-24 09:29:54', '2024-2025'),
(140, '25-07-2026', 'Sabana Banu K', 'II IT', 'Kannadhasan Centenary Ceremony Competitions', 'Participated', 'Hajee Karutha Routhar Kowthiya College, Uthamapalayam', '2026-09-24 09:29:54', '2024-2025'),
(141, '25-07-2026', 'Veerujothi P', 'II IT', 'Kannadhasan Centenary Ceremony Competitions', 'Participated', 'Hajee Karutha Routhar Kowthiya College, Uthamapalayam', '2026-09-24 09:29:54', '2024-2025'),
(142, '25-07-2026', 'Shoba M', 'II IT', 'Kannadhasan Centenary Ceremony Competitions', 'Participated', 'Hajee Karutha Routhar Kowthiya College, Uthamapalayam', '2026-09-24 09:29:54', '2024-2025'),
(143, '25-07-2026', 'Pavithra R', 'II IT', 'Kannadhasan Centenary Ceremony Competitions', 'Participated', 'Hajee Karutha Routhar Kowthiya College, Uthamapalayam', '2026-09-24 09:29:54', '2024-2025'),
(144, '25-07-2026', 'Abirami R', 'II IT', 'Kannadhasan Centenary Ceremony Competitions', 'Participated', 'Hajee Karutha Routhar Kowthiya College, Uthamapalayam', '2026-09-24 09:29:54', '2024-2025'),
(145, '25-07-2026', 'Muthu Vetha', 'II IT', 'Kannadhasan Centenary Ceremony Competitions', 'Participated', 'Hajee Karutha Routhar Kowthiya College, Uthamapalayam', '2026-09-24 09:29:54', '2024-2025'),
(146, '25-07-2026', 'Varshini M', 'II IT', 'Kannadhasan Centenary Ceremony Competitions', 'Participated', 'Hajee Karutha Routhar Kowthiya College, Uthamapalayam', '2026-09-24 09:29:54', '2024-2025'),
(147, '20-08-2026', 'Nirosh Kumar R', 'II IT', 'Viksit Bharat Young Leaders Dialogue (VBYLD) 2027', 'Participated in Online quiz', 'MyBharat', '2026-09-24 09:29:54', '2024-2025'),
(148, '20-08-2026', 'Nirosh Kumar R', 'II IT', 'TB Mukt Bharat Abhiyan', 'Participated in Online quiz', 'MyBharat', '2026-09-24 09:29:54', '2024-2025'),
(149, '20-08-2026', 'Nirosh Kumar R', 'II IT', 'National Space Day - 2026', 'Participated in Online quiz', 'MyBharat', '2026-09-24 09:29:54', '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `achievement_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `achievement_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `achievement_date` date NOT NULL,
  `position` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`achievement_id`, `student_id`, `achievement_name`, `description`, `achievement_date`, `position`, `created_at`) VALUES
(1, 1, 'Hackathon Winner', 'Secured 1st place in a National Level Hackathon organized by IIT.', '2024-03-15', '1st Place', '2025-08-22 05:14:59'),
(2, 1, 'Paper Presentation', 'Presented a research paper on Blockchain Security at Anna University.', '2023-12-10', 'Participant', '2025-08-22 05:14:59'),
(3, 2, 'Coding Contest', 'Won 2nd place in a CodeChef Long Challenge.', '2024-02-05', '2nd Place', '2025-08-22 05:14:59'),
(4, 2, 'App Development', 'Developed a Flutter-based Quiz App for the department fest.', '2023-11-20', 'Best Project', '2025-08-22 05:14:59'),
(5, 3, 'Sports Achievement', 'Represented college in Inter-college Football Tournament.', '2024-01-18', 'Semi-Finalist', '2025-08-22 05:14:59'),
(6, 3, 'Quiz Competition', 'Participated in a National Level IT Quiz.', '2023-09-12', 'Finalist', '2025-08-22 05:14:59'),
(7, 4, 'Workshop on AI/ML', 'Attended a 3-day workshop on Artificial Intelligence & Machine Learning.', '2024-04-02', 'Certificate of Participation', '2025-08-22 05:14:59'),
(8, 4, 'Poster Presentation', 'Presented a poster on Cybersecurity Awareness.', '2023-08-28', '3rd Place', '2025-08-22 05:14:59'),
(9, 5, 'Internship', 'Completed internship at TCS in Web Development domain.', '2023-12-01', 'Completion Certificate', '2025-08-22 05:14:59'),
(10, 5, 'Hackathon', 'Participated in SIH 2023 Hackathon with the college team.', '2023-10-15', 'Finalist', '2025-08-22 05:14:59');

-- --------------------------------------------------------

--
-- Table structure for table `department_activities`
--

CREATE TABLE `department_activities` (
  `id` int(11) NOT NULL,
  `date_duration` varchar(255) DEFAULT NULL,
  `activity_event` varchar(1000) DEFAULT NULL,
  `department_joint` varchar(255) DEFAULT NULL,
  `guest_resource` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `academic_year` varchar(20) NOT NULL DEFAULT '2024-2025'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_activities`
--

INSERT INTO `department_activities` (`id`, `date_duration`, `activity_event`, `department_joint`, `guest_resource`, `created_at`, `academic_year`) VALUES
(1, '25/10/2025', 'Webinar: Text Web Social Media Analytics', 'IT', 'Dr. R. Lokesh Kumar (VIT Chennai)', '2026-09-23 09:56:38', '2024-2025'),
(2, '09/11/2025', 'Association Inauguration of AIM & NEXUS', 'AI&DS + IT', 'NSCET Management & Principal', '2026-09-23 09:56:38', '2024-2025'),
(3, '08/02/2025–14/02/2025', '5-Day VAC: Laravel – Building Modern Web Applications', 'AI&DS + IT', 'Mr. K. Anandraj, CEO, TM Innovations', '2026-09-23 09:56:38', '2024-2025'),
(4, '15/02/2025–20/02/2025', '5-Day VAC: Django and its Frameworks', 'AI&DS + IT', 'Mr. K. Anandraj, CEO, TM Innovations', '2026-09-23 09:56:38', '2024-2025'),
(5, '09/11/2025', 'Seminar: Mastering the job hunt – interview preparation', 'IT', 'Mr. Arasakumar S, Senior Software Engineer, Infosys', '2026-09-23 09:56:38', '2024-2025'),
(6, '14-10-2025', 'industrial visit - lulu twin tower, cochi', 'FINAL YEAR IT', NULL, '2026-09-24 08:38:32', '2024-2025'),
(7, '15-10-2025', 'One Day District Level YRC Study Camp', 'Second year IT (4)', '-', '2026-09-24 08:52:37', '2024-2025'),
(8, '9-10-2025', 'TNGS2025 – Industrial Visit, Codissia Trade Fair Complex, Coimbatore', 'II IT', '-', '2026-09-24 09:12:26', '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `hackathons_expos_conferences`
--

CREATE TABLE `hackathons_expos_conferences` (
  `id` int(11) NOT NULL,
  `date_duration` varchar(255) DEFAULT NULL,
  `event` varchar(1000) DEFAULT NULL,
  `students` varchar(1000) DEFAULT NULL,
  `venue_organization` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `academic_year` varchar(20) NOT NULL DEFAULT '2024-2025'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hackathons_expos_conferences`
--

INSERT INTO `hackathons_expos_conferences` (`id`, `date_duration`, `event`, `students`, `venue_organization`, `created_at`, `academic_year`) VALUES
(1, '20/02/2025–21/02/2025', 'Hack Fest 2025', 'A. Sri Hari Prasath, B. Naveen Bharathi', 'M. Kumarasamy College, Karur', '2026-09-23 09:58:06', '2024-2025'),
(2, '28/02/2025', 'Product Expo 2025', 'Naveen Bharathi B', 'Jerusalem College of Engineering', '2026-09-23 09:58:06', '2024-2025'),
(3, '02/03/2025', 'Ocean Academy Tech Fest (Conference)', 'B. Naveen Bharathi', 'Pondicherry Technological University', '2026-09-23 09:58:06', '2024-2025'),
(4, '03/03/2025–12/03/2025', 'Intel Internship (All III-Year IT Girl Students)', 'III-Year IT Girls', 'Intel', '2026-09-23 09:58:06', '2024-2025'),
(5, '17-04-2026', 'Conference & paper: “TripEase AI: Design and Development of an Agentic Artificial Intelligence platform for Personalized Travel Recommendation and Trip Planning”', 'Sathya Seelan M; Mohamad Irfan Sheik K; Pravin K; Sarvaji M', 'NSCET, Theni', '2026-09-24 06:31:37', '2024-2025'),
(6, '17-04-2026', 'Conference & paper: “A Hybrid Deep Learning Approach for Fake Review System”', 'Preethi V; Abinaya P; Nagajothi M; Nanthini S', 'NSCET, Theni', '2026-09-24 06:31:37', '2024-2025'),
(7, '17-04-2026', 'Conference & paper: “Echo shield-Long range offline Women’s Safety Alert with Audio capture”', 'Yamini S; Naafiya Sherin A; Swathi P; Rana Susmitha R', 'NSCET, Theni', '2026-09-24 06:31:37', '2024-2025'),
(8, '17-04-2026', 'Conference & paper: “High Accurate Blood cancer detection model with Deep Learning”', 'Ramya Priya J; Siva Sri V; Nathiya P; Nihilaa K', 'NSCET, Theni', '2026-09-24 06:31:37', '2024-2025'),
(9, '18-04-2026', 'Conference & paper: “LLM Inference”', 'Vigneshwar S; Naveen; Bharathi B', 'Er. Perumal Manimekalai College of Engineering, Chennai', '2026-09-24 06:31:37', '2024-2025'),
(10, '17-04-2026', 'Conference & paper: “A Robust Network Intrusion Detection System using Optimized XG Boost with Automated preprocessing Pipelines”', 'Gowsik P', 'NSCET, Theni', '2026-09-24 06:31:37', '2024-2025'),
(14, '28-02-2026', 'International Level Hackathon 360 – 3.0', 'Shanmugapriya N', 'KPR Institute of Engineering and Technology & ECLearnix EdTech Private Limited', '2026-09-24 06:31:37', '2024-2025'),
(15, '17-04-2026', 'Conference & paper: “Echo shield-Long range offline Women’s Safety Alert with Audio capture”', 'Yamini S; Naafiya Sherin A; Swathi P; Rana Susmitha R', 'NSCET, Theni', '2026-09-24 06:33:17', '2024-2025'),
(16, '17-04-2026', 'Conference & paper: “High Accurate Blood cancer detection model with Deep Learning”', 'Ramya Priya J; Siva Sri V; Nathiya P; Nihilaa K', 'NSCET, Theni', '2026-09-24 06:33:17', '2024-2025'),
(17, '18-04-2026', 'Conference & paper: “LLM Inference”', 'VIGNESWAR S; NAVEEN; BHARATHI B', 'Er. Perumal Manimekalai College of Engineering, Chennai', '2026-09-24 06:33:17', '2024-2025'),
(18, '17-04-2026', 'Conference & paper: “A Robust Network Intrusion Detection System using Optimized XG Boost with Automated preprocessing Pipelines”', 'Parameswar N S; Surya Prakash A; Yohith Kumar R; Gowsik P', 'NSCET, Theni', '2026-09-24 06:33:17', '2024-2025'),
(21, '17-04-2026', 'Conference & paper: “TripEase AI: Design and Development of an Agentic Artificial Intelligence platform for Personalized Travel Recommendation and Trip Planning”', 'Sathya Seelan M; Mohamad Irfan Sheik K; Pravin K; Sarvaji M', 'NSCET, Theni', '2026-09-24 06:37:05', '2024-2025'),
(22, '17-04-2026', 'Conference & paper: “A Hybrid Deep Learning Approach for Fake Review System”', 'Preethi V; Abinaya P; Nagajothi M; Nanthini S', 'NSCET, Theni', '2026-09-24 06:37:05', '2024-2025'),
(23, '17-04-2026', 'Conference & paper: “Echo shield-Long range offline Women’s Safety Alert with Audio capture”', 'Yamini S; Naafiya Sherin A; Swathi P; Rana Susmitha R', 'NSCET, Theni', '2026-09-24 06:37:05', '2024-2025'),
(24, '17-04-2026', 'Conference & paper: “High Accurate Blood cancer detection model with Deep Learning”', 'Ramya Priya J; Siva Sri V; Nathiya P; Nihilaa K', 'NSCET, Theni', '2026-09-24 06:37:05', '2024-2025'),
(25, '18-04-2026', 'Conference & paper: “LLM Inference”', 'Vigneshwar S; Naveen; Bharathi B', 'Er. Perumal Manimekalai College of Engineering, Chennai', '2026-09-24 06:37:05', '2024-2025'),
(26, '17-04-2026', 'Conference & paper: “A Robust Network Intrusion Detection System using Optimized XG Boost with Automated preprocessing Pipelines”', 'Gowsik P', 'NSCET, Theni', '2026-09-24 06:37:05', '2024-2025'),
(27, '16-03-2026', 'Webinar: “AI Unlocked From Basics to Daily Productivity”', 'Monika B', 'NSCET, Theni', '2026-09-24 06:37:05', '2024-2025'),
(28, '18-03-2026', 'Course Completed in Data Analytics Job simulation', 'Monika B', 'Deloitte', '2026-09-24 06:37:05', '2024-2025'),
(29, '23-02-2026 to 31-03-2026', 'Course Completed in Data Analytics', 'Monika B', 'NoviTech R&D Private Limited', '2026-09-24 06:37:05', '2024-2025'),
(30, '28-02-2026', 'International Level Hackathon 360 – 3.0', 'Shanmugapriya N', 'KPR Institute of Engineering and Technology & ECLearnix EdTech Private Limited', '2026-09-24 06:37:05', '2024-2025'),
(31, '26-09-2025', 'PenmAI 2025 – Empowering Women through AI Innovation', 'Abinaya S', 'Thiagarajar School of Management, Madurai', '2026-09-24 08:44:27', '2024-2025'),
(32, '26-09-2025', 'PenmAI 2025 – Empowering Women through AI Innovation', 'Manjula S', 'Thiagarajar School of Management, Madurai', '2026-09-24 08:44:27', '2024-2025'),
(33, '26-09-2025', 'PenmAI 2025 – Empowering Women through AI Innovation', 'Karunyashri M', 'Thiagarajar School of Management, Madurai', '2026-09-24 08:44:27', '2024-2025'),
(34, '26-09-2025', 'PenmAI 2025 – Empowering Women through AI Innovation', 'Dharshini K', 'Thiagarajar School of Management, Madurai', '2026-09-24 08:44:27', '2024-2025'),
(35, '26-09-2025', 'PenmAI 2025 – Empowering Women through AI Innovation', 'Akshara M', 'Thiagarajar School of Management, Madurai', '2026-09-24 08:44:27', '2024-2025'),
(36, '26-09-2025', 'PenmAI 2025 – Empowering Women through AI Innovation', 'Lakshmipriya G', 'Thiagarajar School of Management, Madurai', '2026-09-24 08:44:27', '2024-2025'),
(37, '26-09-2025', 'PenmAI 2025 – Empowering Women through AI Innovation', 'Anudharshini A', 'Thiagarajar School of Management, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(38, '26-09-2025', 'PenmAI 2025 – Empowering Women through AI Innovation', 'Monika B', 'Thiagarajar School of Management, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(39, '26-09-2025', 'PenmAI 2025 – Empowering Women through AI Innovation', 'Nithyasri M', 'Thiagarajar School of Management, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(40, '26-09-2025', 'PenmAI 2025 – Empowering Women through AI Innovation', 'Divyasri P', 'Thiagarajar School of Management, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(41, '26-09-2025', 'PenmAI 2025 – Empowering Women through AI Innovation', 'Naafiya Shirin A', 'Thiagarajar School of Management, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(42, '26-09-2025', 'PenmAI 2025 – Empowering Women through AI Innovation', 'Yamini S', 'Thiagarajar School of Management, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(43, '26-09-2025', 'PenmAI 2025 – Empowering Women through AI Innovation', 'Swathi P', 'Thiagarajar School of Management, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(44, '26-09-2025', 'PenmAI 2025 – Empowering Women through AI Innovation', 'Rana Susmitha R', 'Thiagarajar School of Management, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(45, '25-09-2025', 'Young Achiever Awards', 'A SRIHARI PRASATH', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(46, '25-09-2025', 'Young Achiever Awards', 'NAVEEN BHARATHI', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(47, '25-09-2025', 'Young Achiever Awards', 'AASWIN P', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(48, '25-09-2025', 'Young Achiever Awards', 'NATHIYA K', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(49, '25-09-2025', 'Young Achiever Awards', 'NIHILAA', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(50, '25-09-2025', 'Young Achiever Awards', 'SIVASRI P', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(51, '25-09-2025', 'Young Achiever Awards', 'ABI GAYATHRI S', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(52, '25-09-2025', 'Young Achiever Awards', 'VIGNESHWAR', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(53, '25-09-2025', 'Young Achiever Awards', 'SATHYA SEELAN M', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(54, '25-09-2025', 'Young Achiever Awards', 'SARVAJI A', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(55, '25-09-2025', 'Young Achiever Awards', 'SURYA PRAKASH', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(56, '25-09-2025', 'Young Achiever Awards', 'RISHIKESH P', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(57, '25-09-2025', 'Young Achiever Awards', 'THANUSH KUMAR', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(58, '25-09-2025', 'Young Achiever Awards', 'PANDIYARAJAN R', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(59, '25-09-2025', 'Young Achiever Awards', 'YOKESH KUMAR', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(60, '25-09-2025', 'Young Achiever Awards', 'KARUNYA SHRI M', 'World Youth Federation, Madurai', '2026-09-24 10:08:30', '2024-2025'),
(65, '13-02-2026', 'NSCET Hackathon', 'MONIKA B', 'NSCET, Theni', '2026-09-24 10:08:30', '2024-2025'),
(70, '12-03-2026 to 14-03-2026', 'Hackathon (Event of Kalam 2026)', 'V SHAHANA', 'Sri Sakthi Institute of Technology, Coimbatore', '2026-09-24 10:08:30', '2024-2025'),
(71, '12-03-2026 to 14-03-2026', 'Hackathon (Event of Kalam 2026)', 'SONI P', 'Sri Sakthi Institute of Technology, Coimbatore', '2026-09-24 10:08:30', '2024-2025'),
(72, '12-03-2026 to 14-03-2026', 'Hackathon (Event of Kalam 2026)', 'NAVEENA G', 'Sri Sakthi Institute of Technology, Coimbatore', '2026-09-24 10:08:30', '2024-2025'),
(73, '12-03-2026 to 14-03-2026', 'Hackathon (Event of Kalam 2026)', 'SOWMIYA P', 'Sri Sakthi Institute of Technology, Coimbatore', '2026-09-24 10:08:30', '2024-2025'),
(74, '28-02-2026', 'International Level Hackathon 360 – 3.0', 'Shanmugapriya N', 'KPR Institute of Engineering and Technology & ECLearnix EdTech Private Limited', '2026-09-24 10:08:30', '2024-2025'),
(75, '22-08-2026', 'Startup Hackathon', 'Soni P', 'AICCI Startup Hackathon, Thoothukudi', '2026-09-24 10:08:30', '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `internships_company_projects`
--

CREATE TABLE `internships_company_projects` (
  `id` int(11) NOT NULL,
  `company_organization` varchar(1000) DEFAULT NULL,
  `project_role` varchar(1000) DEFAULT NULL,
  `students` varchar(1000) DEFAULT NULL,
  `staff_mentor` varchar(500) DEFAULT NULL,
  `duration_notes` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `academic_year` varchar(20) NOT NULL DEFAULT '2024-2025'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internships_company_projects`
--

INSERT INTO `internships_company_projects` (`id`, `company_organization`, `project_role`, `students`, `staff_mentor`, `duration_notes`, `created_at`, `academic_year`) VALUES
(1, 'Apex Planet Software, Bihar', 'Student Achievement Management System (Web Dev Program)', 'AASWIN JS, SARVAJI M, MOHAMED IRFAN SHEIK K, SURYAPARAKASH A', 'B. Sai', 'AICTE Sponsored Internship', '2026-09-23 10:06:39', '2024-2025'),
(2, 'Apex Planet Software, Bihar', 'Secure Blog Management System', 'GOWSIK P, PARAMESWARAN S N, YOHITHKUMAR R, SATHYASEELAN M', 'M. Bhavani', 'AICTE Sponsored Internship', '2026-09-23 10:06:39', '2024-2025'),
(3, 'WG TECH, NSCET, Theni', 'Number Plate Recognition with Real-Time Vehicle Detection', 'NAVEEN BHARATHI B, PRAVIN K', 'R. Yogeswari', 'Software Development (Full Stack)', '2026-09-23 10:06:39', '2024-2025'),
(4, 'QTL Agri Tech', 'Students Management System using Django REST Framework', 'NAGAJOTHI M, NANDHINI S, NIHILAA K, NATHIYA P, RAMYA PRIYA J', 'S. Mahalakshmi', 'Web Development (Django)', '2026-09-23 10:06:39', '2024-2025'),
(5, 'Phoenix Softech, Madurai', 'Gmail Clone using MERN Stack', 'YAMINI S, NAAFIYA SHIRIN A, SWATHI P, RANA SUSMITHA R', 'R. Udhaya Kumar', 'Web Design & Development', '2026-09-23 10:06:39', '2024-2025'),
(6, 'Intel Intelligence', 'Movie API', 'V. PREETHI, P. ABINAYA, P. ABI GAYATHRI', 'R. Udhaya Kumar', 'Java Development', '2026-09-23 10:06:39', '2024-2025'),
(7, 'Diya Robotics, Chennai', 'Health Monitoring', 'SIVASRI V', 'N. Kesavamoorthy', 'Full Stack Development', '2026-09-23 10:06:39', '2024-2025'),
(8, 'InLighnX Global Internship Program', 'Data Analyst (Project not yet confirmed)', 'VIGNESHWAR S', 'S. Arul Jothi', '–', '2026-09-23 10:06:39', '2024-2025'),
(9, 'Unified Mentor, Haryana', 'WiFi Honeypot Detector', 'SRIHARI PRASATH A', 'P. Jasmine Jose', 'Full Stack Development', '2026-09-23 10:06:39', '2024-2025'),
(10, 'Phoenix Softech', 'Tourism Design', 'ABI S', 'P. Jasmine Jose', 'MERN Full Stack', '2026-09-23 10:06:39', '2024-2025'),
(11, 'Phoenix Softech', 'Mark Logger using MERN', 'VAITHEESHWARI R', 'R. Yogeswari', 'MERN Full Stack', '2026-09-23 10:06:39', '2024-2025'),
(12, 'Phoenix Softech', 'Project Not Yet Confirmed', 'DHIVYA DHARSHINI S, ISMATH FATHIMA J', 'S. Mahalakshmi', 'MERN Full Stack', '2026-09-23 10:06:39', '2024-2025'),
(13, 'Hazzino Technologies', 'Portfolio Webpage', 'VANI SRI M, ARCHANA DEVI C, SINDHU S', 'M. Bhavani', 'Web Development', '2026-09-23 10:06:39', '2024-2025'),
(14, 'Yaash Technology', 'CyberSecurity (Project Not Yet Confirmed)', 'SHAHANA V', 'S. Arul Jothi', '–', '2026-09-23 10:06:39', '2024-2025'),
(15, 'Nxdeep Connectz LLP, Madurai', 'Resume Builder (JavaScript)', 'ANUDARSHNI A, DHIVYA DHARSHINI S, MONIKA B, HARINI P', 'R. Udhaya Kumar', '–', '2026-09-23 10:06:39', '2024-2025'),
(16, 'Notasco Technologies, Madurai', 'Responsive Flower Shop (App Development)', 'SONI P, SOWMIYA K, NAVEENA G', 'N. Kesavamoorthy', '–', '2026-09-23 10:06:39', '2024-2025'),
(17, 'Prodigy Infotech, Mumbai', 'Stop-watch Web Application', 'LOGESHWARI S', 'B. Sai', 'Web Development', '2026-09-23 10:06:39', '2024-2025'),
(18, 'Rezilyens Systems Software India Pvt. Ltd., Coimbatore', 'Anon E-Commerce Website', 'JEBANIKITHA N', 'B. Sai', 'Web Development', '2026-09-23 10:06:39', '2024-2025'),
(19, 'Rezilyens Systems Software India Pvt. Ltd., Coimbatore', 'Grilli – Amazing and Delicious Food', 'DIVYASRI P', 'Not Specified', 'Web Development', '2026-09-23 10:06:39', '2024-2025'),
(20, 'Rezilyens Systems Software India Pvt. Ltd., Coimbatore', 'FilmLane – Best Movie Collection', 'SIVAYOGGA K', 'B. Sai', 'Web Development', '2026-09-23 10:06:39', '2024-2025'),
(23, 'Phoenix Softech', 'Internship – Full Stack Development', 'ABI S', NULL, '23-06-2025 to 07-07-2025', '2026-09-24 10:17:28', '2024-2025'),
(24, 'Phoenix Softech', 'Internship – Full Stack Development (MERN)', 'VAITHEESHWARI R', NULL, '23-06-2025 to 07-07-2025', '2026-09-24 10:17:28', '2024-2025'),
(25, 'AICTE', 'AICTE Sponsored Internship – Apex Planet Software', 'AASWIN JS', NULL, '21-06-2025 to 05-08-2025', '2026-09-24 10:17:28', '2024-2025'),
(26, 'AICTE', 'AICTE Sponsored Internship – Apex Planet Software', 'SATHYASEELAN M', NULL, '21-06-2025 to 05-08-2025', '2026-09-24 10:17:28', '2024-2025'),
(27, 'AICTE', 'AICTE Sponsored Internship – Apex Planet Software', 'MOHAMED IRFAN SHEIK K', NULL, '21-06-2025 to 05-08-2025', '2026-09-24 10:17:28', '2024-2025'),
(28, 'AICTE', 'AICTE Sponsored Internship – Apex Planet Software', 'YOHITHKUMAR R', NULL, '21-06-2025 to 05-08-2025', '2026-09-24 10:17:28', '2024-2025'),
(29, 'AICTE', 'AICTE Sponsored Internship – Apex Planet Software', 'GOWSIK P', NULL, '21-06-2025 to 05-08-2025', '2026-09-24 10:17:28', '2024-2025'),
(30, 'AICTE', 'AICTE Sponsored Internship – Apex Planet Software', 'SURYA PARAKASH A', NULL, '21-06-2025 to 05-08-2025', '2026-09-24 10:17:28', '2024-2025'),
(31, 'AICTE', 'AICTE Sponsored Internship – Apex Planet Software', 'PARAMESWARAN S N', NULL, '21-06-2025 to 05-08-2025', '2026-09-24 10:17:28', '2024-2025'),
(32, 'AICTE', 'AICTE Sponsored Internship – Apex Planet Software', 'SARVAJI M', NULL, '21-06-2025 to 05-08-2025', '2026-09-24 10:17:28', '2024-2025'),
(33, 'InLighnX Global Internship Program', 'Data Analyst', 'VIGNESHWAR S', NULL, '01-07-2025 to 01-08-2025', '2026-09-24 10:17:28', '2024-2025'),
(34, 'CodSoft', 'Virtual Internship Program in Data Science', 'A.Anudarshni', NULL, '15-12-2025 to 15-01-2026', '2026-09-24 10:17:28', '2024-2025'),
(35, 'NSCET, Theni', 'Participated in Internship “Software Testing & Automation”', 'Vishalini V', NULL, '08-06-2026 to 18-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(36, 'NSCET, Theni', 'Participated in Internship “Software Testing & Automation”', 'Aishwarya S', NULL, '08-06-2026 to 18-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(37, 'NSCET, Theni', 'Participated in Internship “Software Testing & Automation”', 'Sivasandhya K', NULL, '08-06-2026 to 18-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(38, 'NSCET, Theni', 'Participated in Internship “Software Testing & Automation”', 'Reshma S', NULL, '08-06-2026 to 18-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(39, 'NSCET, Theni', 'Participated in Internship “Software Testing & Automation”', 'Nivetha J', NULL, '08-06-2026 to 18-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(40, 'NSCET, Theni', 'Participated in Internship “Software Testing & Automation”', 'Manjula S', NULL, '08-06-2026 to 18-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(41, 'SK TECHFORGE LLP, Madurai', 'Completed Internship in “Cloud Computing”', 'Praveena N', NULL, '08-06-2026 to 13-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(42, 'SK TECHFORGE LLP, Madurai', 'Completed Internship in “Cloud Computing”', 'Rajeshwari V', NULL, '08-06-2026 to 13-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(43, 'SK TECHFORGE LLP, Madurai', 'Completed Internship in “Cloud Computing”', 'Sathyabama G', NULL, '08-06-2026 to 13-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(44, 'SK TECHFORGE LLP, Madurai', 'Completed Internship in “Cloud Computing”', 'Shanmugapriya N', NULL, '08-06-2026 to 13-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(45, 'SK TECHFORGE LLP, Madurai', 'Completed Internship in “Cloud Computing”', 'Akshara M', NULL, '08-06-2026 to 13-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(46, 'CodeBind Technologies, Coimbatore', 'Completed Internship in “Web Development”', 'Maheswari M', NULL, '22-06-2026 to 01-07-2026', '2026-09-24 10:17:28', '2024-2025'),
(47, 'CodeBind Technologies, Coimbatore', 'Completed project titled “Online Art Gallery Using HTML,CSS,PHP and MySQL”', 'Maheswari M', NULL, '22-06-2026 to 01-07-2026', '2026-09-24 10:17:28', '2024-2025'),
(48, 'TwikiBOT Technologies, Theni', 'Completed Internship in “Mobile App Development”', 'Abinaya V', NULL, '08-06-2026 to 22-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(49, 'TECHVOLT Software Pvt. Ltd., Coimbatore', 'Completed Internship in “Data Science with Machine Learning”', 'Karunya Shri M', NULL, '10-06-2026 to 27-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(50, 'TECHVOLT Software Pvt. Ltd., Coimbatore', 'Completed Internship in “Data Science with Machine Learning”', 'Lakshmipriya G', NULL, '10-06-2026 to 27-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(51, 'ADHOC Software, Coimbatore', 'Completed Internship in “Data Science”', 'Sharveswaran S P', NULL, '10-06-2026 to 27-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(52, 'ADHOC Software, Coimbatore', 'Completed Internship in “Data Science”', 'Gobinath G', NULL, '10-06-2026 to 27-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(53, 'ADHOC Software, Coimbatore', 'Completed Internship in “Data Science”', 'Sivapradeep M', NULL, '10-06-2026 to 27-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(54, 'ADHOC Software, Coimbatore', 'Completed Internship in “Data Science”', 'Manishvarma S', NULL, '10-06-2026 to 27-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(55, 'ADHOC Software, Coimbatore', 'Completed Internship in “Data Science”', 'Dhinesh Kumar V', NULL, '10-06-2026 to 27-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(56, 'Zhahi Info Tech, Theni', 'Completed Internship in “Python for Data Analytics”', 'Priyadharshini M', NULL, '11-06-2026 to 30-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(57, 'CodeBind Technologies, Coimbatore', 'Completed Internship in “Web Development”', 'Anitha S', NULL, '22-06-2026 to 01-07-2026', '2026-09-24 10:17:28', '2024-2025'),
(58, 'CodeBind Technologies, Coimbatore', 'Completed project titled “Online Art Gallery Using HTML,CSS,PHP and MySQL”', 'Anitha S', NULL, '22-06-2026 to 01-07-2026', '2026-09-24 10:17:28', '2024-2025'),
(59, 'TwikiBOT Technologies, Theni', 'Completed Internship in “Mobile App Development”', 'Thanga Raja Varshini S', NULL, '08-06-2026 to 22-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(60, 'TwikiBOT Technologies, Theni', 'Completed Internship in “Mobile App Development”', 'Gayathri P', NULL, '08-06-2026 to 22-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(61, 'TwikiBOT Technologies, Theni', 'Completed Internship in “Mobile App Development”', 'Dharshini K', NULL, '08-06-2026 to 22-06-2026', '2026-09-24 10:17:28', '2024-2025'),
(62, 'NoviTech R&D Private Limited', 'Internship Completed in Full Stack Development', 'Vishalini V', NULL, '18-07-2026 to 22-07-2026', '2026-09-24 10:17:28', '2024-2025'),
(63, 'NoviTech R&D Private Limited', 'Internship Completed in Full Stack Development', 'Reshma S', NULL, '18-07-2026 to 22-07-2026', '2026-09-24 10:17:28', '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `sports_achievements`
--

CREATE TABLE `sports_achievements` (
  `id` int(11) NOT NULL,
  `date_duration` varchar(255) DEFAULT NULL,
  `sport_event` varchar(1000) DEFAULT NULL,
  `students` varchar(1000) DEFAULT NULL,
  `achievement_position` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `academic_year` varchar(20) NOT NULL DEFAULT '2024-2025'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports_achievements`
--

INSERT INTO `sports_achievements` (`id`, `date_duration`, `sport_event`, `students`, `achievement_position`, `created_at`, `academic_year`) VALUES
(1, '07/10/2025–08/10/2025', 'Volleyball (Women), Anna University Zone-17', 'M. Vani Sri', 'IV Position', '2026-09-23 09:59:28', '2024-2025'),
(2, '18/09/2025–19/09/2025', 'Basketball (Women), Anna University Zone-17', 'S. Nandhini', 'II Position', '2026-09-23 09:59:28', '2024-2025'),
(3, '17/09/2025–19/09/2025', 'Basketball (Women), CM Trophy', 'S. Nandhini', 'III Position; Cash Award ₹10,000', '2026-09-23 09:59:28', '2024-2025'),
(4, '08/10/2025–09/10/2025', 'Volleyball (Men), Anna University Zone-17', 'A. Surya Prakash', 'Participated', '2026-09-23 09:59:28', '2024-2025'),
(5, '15/10/2025–16/10/2025', 'Chess (Women), Zone-17', 'M. Priyadharshini', 'Participated', '2026-09-23 09:59:28', '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `department` varchar(50) NOT NULL,
  `year` enum('1','2','3','4') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `name`, `reg_no`, `email`, `photo`, `department`, `year`, `created_at`) VALUES
(1, 'Arjun Kumar', 'IT2023001', 'arjun.kumar@nscet.edu', 'photos/arjun.jpg', 'IT', '3', '2025-08-22 05:12:59'),
(2, 'Meera Nair', 'IT2023002', 'meera.nair@nscet.edu', 'photos/meera.jpg', 'IT', '2', '2025-08-22 05:12:59'),
(3, 'Vikram Singh', 'IT2023003', 'vikram.singh@nscet.edu', 'photos/vikram.jpg', 'IT', '4', '2025-08-22 05:12:59'),
(4, 'Ananya Reddy', 'IT2023004', 'ananya.reddy@nscet.edu', 'photos/ananya.jpg', 'IT', '1', '2025-08-22 05:12:59'),
(5, 'Rahul Menon', 'IT2023005', 'rahul.menon@nscet.edu', 'photos/rahul.jpg', 'IT', '3', '2025-08-22 05:12:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_achievements`
--
ALTER TABLE `academic_achievements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`achievement_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `department_activities`
--
ALTER TABLE `department_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hackathons_expos_conferences`
--
ALTER TABLE `hackathons_expos_conferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `internships_company_projects`
--
ALTER TABLE `internships_company_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports_achievements`
--
ALTER TABLE `sports_achievements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `reg_no` (`reg_no`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_achievements`
--
ALTER TABLE `academic_achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `department_activities`
--
ALTER TABLE `department_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hackathons_expos_conferences`
--
ALTER TABLE `hackathons_expos_conferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `internships_company_projects`
--
ALTER TABLE `internships_company_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `sports_achievements`
--
ALTER TABLE `sports_achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
