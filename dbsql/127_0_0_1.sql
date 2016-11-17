-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2016 at 01:04 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ans`
--
CREATE DATABASE IF NOT EXISTS `db_ans` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_ans`;
--
-- Database: `db_main`
--
CREATE DATABASE IF NOT EXISTS `db_main` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_main`;

-- --------------------------------------------------------

--
-- Table structure for table `contestant`
--

CREATE TABLE `contestant` (
  `name_code` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `school` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contestant`
--

INSERT INTO `contestant` (`name_code`, `name`, `school`) VALUES
(1, 'blashh21', 'UNTAR'),
(2, 'Azure Dragon 77', 'UNTAR'),
(3, 'TeamTam', 'NUS'),
(4, 'NightRain', 'UNTAR'),
(5, 'Awrakin', 'UI'),
(6, 'Ainge WF', 'ITB');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `idx` int(11) NOT NULL,
  `username` varchar(5) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `problem`
--

CREATE TABLE `problem` (
  `prob_num` int(11) NOT NULL,
  `sol_query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `submission`
--

CREATE TABLE `submission` (
  `sub_idx` int(11) NOT NULL,
  `submitted_text` text NOT NULL,
  `prob_num` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `submit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `totalscore`
--

CREATE TABLE `totalscore` (
  `name_code` int(11) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `totalscore`
--

INSERT INTO `totalscore` (`name_code`, `score`) VALUES
(1, 100),
(2, 90),
(3, 80),
(4, 70),
(5, 60),
(6, 50);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contestant`
--
ALTER TABLE `contestant`
  ADD PRIMARY KEY (`name_code`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `name_code` (`name_code`);

--
-- Indexes for table `problem`
--
ALTER TABLE `problem`
  ADD PRIMARY KEY (`prob_num`);

--
-- Indexes for table `submission`
--
ALTER TABLE `submission`
  ADD PRIMARY KEY (`sub_idx`),
  ADD KEY `prob_num` (`prob_num`);

--
-- Indexes for table `totalscore`
--
ALTER TABLE `totalscore`
  ADD PRIMARY KEY (`name_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contestant`
--
ALTER TABLE `contestant`
  MODIFY `name_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `problem`
--
ALTER TABLE `problem`
  MODIFY `prob_num` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `submission`
--
ALTER TABLE `submission`
  MODIFY `sub_idx` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`name_code`) REFERENCES `contestant` (`name_code`);

--
-- Constraints for table `submission`
--
ALTER TABLE `submission`
  ADD CONSTRAINT `submission_ibfk_1` FOREIGN KEY (`prob_num`) REFERENCES `problem` (`prob_num`);

--
-- Constraints for table `totalscore`
--
ALTER TABLE `totalscore`
  ADD CONSTRAINT `totalscore_ibfk_1` FOREIGN KEY (`name_code`) REFERENCES `contestant` (`name_code`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
