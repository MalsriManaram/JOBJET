-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2025 at 03:48 PM
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
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `appliers`
--

CREATE TABLE `appliers` (
  `id` int(11) NOT NULL,
  `your_name` varchar(255) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `your_email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `appliers_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--


-- --------------------------------------------------------

--
-- Table structure for table `jobadds`
--

CREATE TABLE `jobadds` (
  `id` int(11) NOT NULL,
  `adds_heading` varchar(255) NOT NULL,
  `ads_position` varchar(255) NOT NULL,
  `ads_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobadds`
--

INSERT INTO `jobadds` (`id`, `adds_heading`, `ads_position`, `ads_img`) VALUES
(1, 'Graphic Designer', 'Junior Graphic Designer/Dreamteam', 'Grapic_Design_01.png'),
(2, 'Software Engineer', 'Senior Software Engineer - .Net', 'Software_Engineer_02.png'),
(3, 'Software Engineer', 'Senior Software Engineer - Java', 'Software_Engineer_03.png'),
(4, 'Graphic Designer', 'Graphic Designer / Photo Enhancer', 'Grapic_Design_03.png'),
(5, 'Full-Stack Developer', 'Senior Software Engineer - Full Stack', 'Full-Stack Developer_01.png'),
(6, 'Web / Mobile Engineer', 'Programmer - Web / Mobile', 'Software_Engineer_04.png'),
(7, 'QA Engineer', 'Software QA Engineers', 'QA_Engineers_01.png'),
(8, 'Mobile App Developer', 'Mobile App Developer - IITC Globle', 'Mobile_App Developer_01.png'),
(9, 'Quality Assurance Engineer', 'Quality Assurance Manager', 'QA_Engineers_02.png'),
(10, 'DevOps Engineer ', 'DevOps Engineer - Social Catfish', 'DevOps_Engineer_01.png'),
(11, 'Web Developer', 'Web Developer (AUS Calendar - SL Shift)', 'Web_Developer_01.png');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `birth_day` date NOT NULL DEFAULT current_timestamp(),
  `gender` enum('Male','Female','Other','') NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `site` varchar(255) NOT NULL,
  `nick_name` varchar(50) NOT NULL,
  `pro_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `topemployers`
--

CREATE TABLE `topemployers` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `employers_img` varchar(255) NOT NULL,
  `employers_url` varchar(255) NOT NULL,
  `employers_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topemployers`
--

INSERT INTO `topemployers` (`id`, `company_name`, `location`, `employers_img`, `employers_url`, `employers_text`) VALUES
(1, 'Virtusa', '752 Dr Danister De Silva Mawatha, Colombo 00900', 'Virtusa.jpg', 'https://www.virtusa.com/', 'At Virtusa, we spark change through our Digital Transformation Studio, delivering deep digital engineering and industry expertise through client-specific and integrated agile scrum teams.\r\n\r\nWe work with Global 2000 companies and leading software vendors in domains like Communications & Technology, Banking & Financial Services, Insurance, Telecommunications, and Media, Information & Entertainment.'),
(2, 'HCLTech', '00200 Glennie St, Colombo 00200', 'HCLTech.jpg', 'https://www.hcltech.com/', 'HCLTech is a global technology company, home to 224,756+ people across 60 countries, delivering industry-leading capabilities centered around digital, engineering, cloud and AI powered by a broad portfolio of'),
(3, 'IFS', 'IFS Sri Lanka, Colombo 06.', 'IFS.png', 'https://www.ifs.com/', 'IFS develops and delivers cloud enterprise software for companies around the world who manufacture and distribute goods, build and maintain assets, and manage service-focused operations. \r\n\r\nWithin our single platform, our industry specific products are innately connected to a single data model and use embedded digital innovation so that our customers can be their best when it really matters to their customers – at the Moment of Service™. '),
(4, 'IBM', 'WV92+G4F, Navam Mawatha, Colombo', 'IBM.png', 'https://in.newsroom.ibm.com/2020-09-08-IBM-strengthens-Cloud-AI-strategy-for-SriLanka', 'IBM works to design, advance, and scale the technologies that define each era. Restlessly reinventing since 1911, we are one of the largest technology, consulting and research companies in the world. \n \nIBMers are agents of change – in this team, you’ll become a part of a historic, prestigious, and global community in which you’ll be respected, and your talents will have a real impact.\n'),
(5, 'Infor', '177 A2, Colombo 00300', 'INFOR.png', 'https://www.infor.com/about/careers', 'Infor is a global leader in business cloud software products for companies in industry-specific markets. Infor builds complete industry suites in the cloud and efficiently deploys technology that puts the user experience first, leverages data science, and integrates easily into existing systems. Over 60,000 organizations worldwide rely on Infor to help overcome market disruptions and achieve business-wide digital transformation.'),
(6, 'Synopsys', 'No. 03, 2/1, Lukshmi Gardens Colombo 08, Sri Lanka', 'SYNOPSYS.png', 'https://www.synopsys.com/company/contact-synopsys/office-locations/south-asia.html', 'Synopsys delivers the most trusted and comprehensive silicon to systems design solutions, accelerating technology innovation. We partner closely with our customers to maximize their R&D capability and productivity, powering innovation today that ignites the ingenuity of tomorrow. Companies trust Synopsys to pioneer new technologies to help them get to market faster without compromise.'),
(7, 'Microsoft', 'Access Tower II, 22nd Floor, 278 Union Pl, Colombo 02000', 'Microsoft.png', 'https://www.microsoft.com/en-lk/contact.aspx', 'Industry: Computer Hardware Development\r\n\r\nSince our founding in 1998, Google has grown by leaps and bounds. Starting from two computer science students in a university dorm room, we now have over a hundred thousand employees and over one hundred\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` text NOT NULL,
  `identify` text NOT NULL,
  `pro_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- --------------------------------------------------------

--
-- Table structure for table `workexp`
--

CREATE TABLE `workexp` (
  `id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `time_period` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workexp`
--

INSERT INTO `workexp` (`id`, `work_id`, `position`, `company_name`, `time_period`) VALUES
(2, 1, 'Software Engineer', 'virtusa', '2022 to 2024'),
(16, 19, 'Software Engineer', 'virtusa', '2022 to 2024'),
(17, 19, 'Software Engineer 2', 'virtusa 2', '2022 to 2026');

-- --------------------------------------------------------

--
-- Table structure for table `workinfo`
--

CREATE TABLE `workinfo` (
  `id` int(11) NOT NULL,
  `w_id` int(11) NOT NULL,
  `filed` varchar(50) NOT NULL,
  `filed2` varchar(50) NOT NULL,
  `skills` text NOT NULL,
  `resume_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workinfo`
--

INSERT INTO `workinfo` (`id`, `w_id`, `filed`, `filed2`, `skills`, `resume_img`) VALUES
(1, 1, 'Software Engineer', 'ICT', 'Technical Proficiency\r\nProblem-solving\r\nCommunication\r\nProject Management\r\nContinuous Learning', 'IMG-6661e8d5ccce05.49113588.jpg'),
(3, 2, 'Software Engineer', '', '', ''),
(4, 3, 'Data Analyst', '', '', ''),
(5, 4, 'UX/UI Designer', '', '', ''),
(6, 5, '', '', '', ''),
(7, 6, 'UX/UI Designer', '', '', ''),
(8, 7, 'Data Engineer', '', '', ''),
(18, 18, 'Cloud Engineer', '', '', 'IMG-66345c26c78647.50103723.jpg'),
(19, 19, 'Software Engineer', '', 'Technical Proficiency\r\nProblem-Solving\r\nAdaptability\r\nCommunication\r\nAttention to Detail\r\nCritical Thinki', 'IMG-66347cd79f7424.70832658.jpg'),
(20, 20, '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appliers`
--
ALTER TABLE `appliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobadds`
--
ALTER TABLE `jobadds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `_id` (`p_id`);

--
-- Indexes for table `topemployers`
--
ALTER TABLE `topemployers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workexp`
--
ALTER TABLE `workexp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_id` (`work_id`);

--
-- Indexes for table `workinfo`
--
ALTER TABLE `workinfo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `w_id` (`w_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appliers`
--
ALTER TABLE `appliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `jobadds`
--
ALTER TABLE `jobadds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `topemployers`
--
ALTER TABLE `topemployers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `workexp`
--
ALTER TABLE `workexp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `workinfo`
--
ALTER TABLE `workinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `workexp`
--
ALTER TABLE `workexp`
  ADD CONSTRAINT `workexp_ibfk_1` FOREIGN KEY (`work_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `workinfo`
--
ALTER TABLE `workinfo`
  ADD CONSTRAINT `workinfo_ibfk_1` FOREIGN KEY (`w_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
