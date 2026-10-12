-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2026 at 06:35 PM
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
-- Database: `placement_manage`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_id`, `name`, `username`, `password`, `created_at`, `profile_image`) VALUES
(1, 'ADMIN001', 'Administrator', 'admin', '$2y$10$vscvb6mpEz3Oqu2FXwDcf.vo9bMYkDXA37mLmHg/jU39HvW80zmbC', '2026-09-12 09:10:29', '1789225753_2614.png');

-- Username : admin
-- Password : admin123

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` enum('Applied','Shortlisted','Rejected','Selected') DEFAULT 'Applied',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `student_id`, `status`, `applied_at`) VALUES
(1, 2, 1, 'Applied', '2026-09-12 11:35:08'),
(3, 1, 1, 'Applied', '2026-09-12 11:45:02'),
(5, 3, 1, 'Applied', '2026-09-12 12:52:57');

-- --------------------------------------------------------

--
-- Table structure for table `cms_drives`
--

CREATE TABLE `cms_drives` (
  `id` int(11) NOT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `job_title` varchar(150) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `package` varchar(50) DEFAULT NULL,
  `deadline` varchar(50) DEFAULT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `status_text` varchar(30) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_drives`
--

INSERT INTO `cms_drives` (`id`, `company_name`, `job_title`, `location`, `package`, `deadline`, `button_text`, `button_link`, `status_text`, `logo`, `sort_order`, `status`) VALUES
(1, 'TCS', 'Software Engineer', 'Bengaluru', '7 LPA', '30 Sept 2026', 'Apply Now', 'jobs.php', '', 'tcs-logo.png', 1, 1),
(2, 'Infosys', 'System Engineer', 'Pune', '6 LPA', '28 Sept 2026', 'Apply Now', 'jobs.php', '', 'Infosys-logo.webp', 2, 1),
(3, 'Accenture', 'Associate Software Engineer', 'Hyderabad', '6.5 LPA', '05 Oct 2026', 'Apply Now', 'jobs.php', '', 'accenture-logo.png', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cms_about`
--

CREATE TABLE `cms_about` (
  `id` int(11) NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_about`
--

INSERT INTO `cms_about` (`id`, `heading`, `description`, `image`) VALUES
(1, 'About Our Placement Cell', 'The Training and Placement Cell acts as a bridge between students and recruiters by organizing campus placement drives, career guidance sessions, aptitude training and interview preparation activities.', 'hero.png');

-- --------------------------------------------------------

--
-- Table structure for table `cms_hero`
--

CREATE TABLE `cms_hero` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `highlight_text` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_hero`
--

INSERT INTO `cms_hero` (`id`, `title`, `subtitle`, `highlight_text`, `description`, `image`) VALUES
(1, 'Build Your Career with Top Companies', 'Connect with leading companies, explore exciting job opportunities, and begin your professional journey.', '', '', 'hero.png');

-- --------------------------------------------------------

--
-- Table structure for table `cms_recruiters`
--

CREATE TABLE `cms_recruiters` (
  `id` int(11) NOT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_recruiters`
--

INSERT INTO `cms_recruiters` (`id`, `company_name`, `logo`, `sort_order`, `status`) VALUES
(1, 'TCS', 'tcs-logo.png', 1, 1),
(2, 'Infosys', 'Infosys-logo.webp', 2, 1),
(3, 'Wipro', 'wipro-logo.webp', 3, 1),
(4, 'HCL', 'hcl-logo.png', 4, 1),
(5, 'Accenture', 'accenture-logo.png', 5, 1),
(6, 'Cognizant', 'cognizant-logo.svg', 6, 1),
(7, 'Capgemini', 'capgemini-logo.png', 7, 1),
(8, 'IBM', 'ibm-logo.webp', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cms_settings`
--

CREATE TABLE `cms_settings` (
  `id` int(11) NOT NULL,
  `website_name` varchar(150) DEFAULT NULL,
  `organization_name` varchar(150) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `alternate_phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `google_map` text DEFAULT NULL,
  `footer_about` text DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_settings`
--

INSERT INTO `cms_settings` (`id`, `website_name`, `organization_name`, `logo`, `favicon`, `email`, `phone`, `alternate_phone`, `address`, `google_map`, `footer_about`, `copyright`, `facebook`, `instagram`, `linkedin`, `youtube`) VALUES
(1, 'Placement Management System', NULL, NULL, NULL, 'placement@agc.ac.in', '+91 98765 43210', NULL, 'Amritsar Group of Colleges, Amritsar, Punjab', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3366.0223254704633!2d74.99064137872298!3d31.578766301911664!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391bd7be1ad9dad7%3A0x49b928cd50a5cbb3!2sAmritsar%20College%20of%20Engineering%20and%20Technology!5e0!3m2!1sen!2sin!4v1788272553789!5m2!1sen!2sin', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_team`
--

CREATE TABLE `cms_team` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `designation` varchar(150) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_team`
--

INSERT INTO `cms_team` (`id`, `name`, `designation`, `sort_order`, `image`) VALUES
(1, 'Shruti Parashar', 'Dean - Training & Placement', 1, 'dean.jpg'),
(2, 'Avlin Randhawa', 'Placement Officer', 2, 'officer.png'),
(3, 'Mr. Aman Prasad', 'Placement Coordinator', 3, 'coordinator.png');

-- --------------------------------------------------------

--
-- Table structure for table `cms_social_links`
--

CREATE TABLE `cms_social_links` (
  `id` int(11) NOT NULL,
  `platform` varchar(100) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_statistics`
--

CREATE TABLE `cms_statistics` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `number` varchar(30) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_statistics`
--

INSERT INTO `cms_statistics` (`id`, `title`, `number`, `sort_order`, `status`) VALUES
(1, 'Students Placed', '500+', 1, 1),
(2, 'Recruiting Companies', '100+', 2, 1),
(3, 'Job Opportunities', '250+', 3, 1),
(4, 'Placement Rate', '95%', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cms_testimonials`
--

CREATE TABLE `cms_testimonials` (
  `id` int(11) NOT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `company` varchar(150) DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_testimonials`
--

INSERT INTO `cms_testimonials` (`id`, `student_name`, `course`, `company`, `rating`, `message`, `photo`, `sort_order`, `status`) VALUES
(1, 'Rahul Sharma', 'BCA • Batch 2025', 'Placed at TCS', 5, 'The placement process was smooth and well organized. I received excellent guidance and successfully secured my first job.', 'student1.jpg', 1, 1),
(2, 'Priya Singh', 'BCA • Batch 2025', 'Placed at Infosys', 5, 'This platform made job applications simple and helped me connect with leading recruiters.', 'student2.jpg', 2, 1),
(3, 'Aman Verma', 'BCA • Batch 2025', 'Placed at Accenture', 5, 'I received timely placement updates and got selected in my dream company through campus recruitment.', 'student3.jpg', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cms_why_choose_us`
--

CREATE TABLE `cms_why_choose_us` (
  `id` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_why_choose_us`
--

INSERT INTO `cms_why_choose_us` (`id`, `title`, `description`, `icon`, `sort_order`, `status`) VALUES
(1, 'Top Recruiters', 'Connect with leading companies from different industries offering exciting career opportunities.', 'bi-building', 1, 1),
(2, 'Placement Opportunities', 'Explore internship and full-time job opportunities based on your skills and qualifications.', 'bi-briefcase', 2, 1),
(3, 'Easy Application', 'Apply for jobs online, upload your resume and track your application status with ease.', 'bi-person-check', 3, 1),
(4, 'Career Growth', 'Enhance your career by participating in placement drives and recruitment activities.', 'bi-award', 4, 1),
(5, 'Trusted Platform', 'A secure and reliable platform connecting students, recruiters and the placement cell.', 'bi-shield-check', 5, 1),
(6, 'Better Career Outcomes', 'Stay informed about placement drives, company updates and career opportunities in one place.', 'bi-graph-up-arrow', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `company_code` varchar(20) DEFAULT NULL,
  `company_name` varchar(150) NOT NULL,
  `hr_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_code`, `company_name`, `hr_name`, `email`, `phone`, `address`, `website`, `logo`, `password`, `status`, `created_at`) VALUES
(1, 'COMP0001', 'Infosys', 'Rahul Sharma', 'hr@infosys.com', '9876543210', 'Bangalore, Karnataka', 'https://www.infosys.com', '', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Approved', '2026-09-12 11:26:08'),
(2, 'COMP0002', 'Career Sankalp', 'Sanny Singh', 'career@gmail.com', '9128086913', 'Patna, Bihar', 'https://www.careersankalp.com/', '1789219944_Career-Sankalp-Logo.png', '$2y$10$EmambokULG4brKUWrTtNXua7WryQaWlmkKCQSx8FcILzUdOiEPqZO', 'Approved', '2026-09-12 12:37:22');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `package` varchar(50) DEFAULT NULL,
  `vacancies` int(11) DEFAULT NULL,
  `eligibility` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `last_date` date DEFAULT NULL,
  `status` enum('Open','Closed') DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `company_id`, `title`, `location`, `package`, `vacancies`, `eligibility`, `description`, `last_date`, `status`, `created_at`) VALUES
(1, 1, 'PHP Developer Intern', 'Amritsar', '3.5 LPA', 10, 'BCA / MCA students with basic knowledge of PHP and MySQL.', 'Selected candidates will work on web application development, bug fixing and database management.', '2026-10-15', 'Open', '2026-09-12 11:26:37'),
(2, 1, 'Software Developer Trainee', 'Mohali', '4.2 LPA', 8, 'BCA, B.Tech (CSE/IT), MCA students with basic programming knowledge.', 'The selected candidates will undergo training in software development, database management, and web application development. Successful trainees may receive a full-time offer based on performance.', '2026-10-25', 'Open', '2026-09-12 11:28:36'),
(3, 2, 'Software Engineer', 'Delhi', '10 LPA', 50, 'B.Tech CSE', 'HTML', '2026-09-24', 'Open', '2026-09-12 12:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_type` enum('Admin','Student','Company') DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_type`, `user_id`, `title`, `message`, `is_read`, `created_at`) VALUES
(1, 'Student', 1, 'Application Submitted', 'Your job application has been submitted successfully.', 1, '2026-09-12 11:35:08'),
(2, 'Student', 1, 'Application Submitted', 'Your job application has been submitted successfully.', 1, '2026-09-12 11:42:16'),
(3, 'Student', 1, 'Application Submitted', 'Your job application has been submitted successfully.', 1, '2026-09-12 11:45:02'),
(4, 'Student', 2, 'Application Submitted', 'Your job application has been submitted successfully.', 0, '2026-09-12 12:07:21'),
(5, 'Student', 1, 'Application Submitted', 'Your job application has been submitted successfully.', 1, '2026-09-12 12:52:57'),
(6, 'Student', 1, 'Application Status Update', 'Your application status for Software Engineer has been updated to: Shortlisted', 1, '2026-09-12 12:53:21'),
(7, 'Student', 1, 'Application Status Update', 'Your application status for Software Engineer has been updated to: Selected', 1, '2026-09-12 13:22:18'),
(8, 'Student', 1, 'Application Status Update', 'Your application status for Software Engineer has been updated to: Applied', 0, '2026-09-16 06:15:30');

-- --------------------------------------------------------

--
-- Table structure for table `selected_students`
--

CREATE TABLE `selected_students` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `package` varchar(50) DEFAULT NULL,
  `selection_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `selected_students`
--

INSERT INTO `selected_students` (`id`, `student_id`, `company_id`, `job_id`, `package`, `selection_date`) VALUES
(1, 1, 2, 3, '10 LPA', '2026-09-12');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `registration_id` varchar(20) DEFAULT NULL,
  `roll_no` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `course` varchar(50) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `cgpa` decimal(3,2) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_completed` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `registration_id`, `roll_no`, `name`, `email`, `phone`, `gender`, `dob`, `course`, `semester`, `cgpa`, `skills`, `resume`, `profile_photo`, `password`, `profile_completed`, `created_at`) VALUES
(1, 'STU00001', '2412190', 'Anshu Kumar', 'anshuku539@gmail.com', '9128086913', 'Male', '2005-02-25', 'BCA', 'Semester 5', 8.00, 'MERN, JAVA, Git &amp; Git-Hub', '1789209347_Subhi Marksheet.pdf', '1789209921_Profile IMG.png', '$2y$10$3E8to7kgrRlLGecJhVrYEeobLOUHN5dcNJikOhCSbpssdndOkd732', 1, '2026-09-12 09:19:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_id` (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `cms_about`
--
ALTER TABLE `cms_about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_drives`
--
ALTER TABLE `cms_drives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_hero`
--
ALTER TABLE `cms_hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_recruiters`
--
ALTER TABLE `cms_recruiters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_settings`
--
ALTER TABLE `cms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_team`
--
ALTER TABLE `cms_team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_social_links`
--
ALTER TABLE `cms_social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_statistics`
--
ALTER TABLE `cms_statistics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_testimonials`
--
ALTER TABLE `cms_testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_why_choose_us`
--
ALTER TABLE `cms_why_choose_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_code` (`company_code`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selected_students`
--
ALTER TABLE `selected_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roll_no` (`roll_no`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `registration_id` (`registration_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cms_about`
--
ALTER TABLE `cms_about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms_drives`
--
ALTER TABLE `cms_drives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms_hero`
--
ALTER TABLE `cms_hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms_recruiters`
--
ALTER TABLE `cms_recruiters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_settings`
--
ALTER TABLE `cms_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms_team`
--
ALTER TABLE `cms_team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cms_social_links`
--
ALTER TABLE `cms_social_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_statistics`
--
ALTER TABLE `cms_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_testimonials`
--
ALTER TABLE `cms_testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_why_choose_us`
--
ALTER TABLE `cms_why_choose_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `selected_students`
--
ALTER TABLE `selected_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `selected_students`
--
ALTER TABLE `selected_students`
  ADD CONSTRAINT `selected_students_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `selected_students_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `selected_students_ibfk_3` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
