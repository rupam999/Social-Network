-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2020 at 05:24 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbms`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `home` (IN `us` VARCHAR(10))  SELECT * FROM personal_details where u_id!=us ORDER BY RAND()$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chat_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`chat_id`, `sender_id`, `message`) VALUES
(1, 2, 'hello user'),
(2, 6, 'heelllllo'),
(3, 2, 'nghfh'),
(4, 8, ''),
(5, 8, 'thfetht');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `f_id` int(11) NOT NULL,
  `rec_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `req_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`f_id`, `rec_id`, `friend_id`, `req_id`) VALUES
(1, 1, 2, 1),
(2, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `friend_request`
--

CREATE TABLE `friend_request` (
  `request_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `response` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friend_request`
--

INSERT INTO `friend_request` (`request_id`, `sender_id`, `receiver_id`, `response`) VALUES
(1, 2, 1, 1),
(2, 6, 4, 0),
(3, 6, 2, 0),
(4, 6, 3, 0),
(5, 6, 1, 0),
(6, 6, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `groupdes`
--

CREATE TABLE `groupdes` (
  `groupId` int(10) NOT NULL,
  `groupname` varchar(255) NOT NULL,
  `groupdes` varchar(255) NOT NULL,
  `groupimg` varchar(255) NOT NULL,
  `groupcover` varchar(255) NOT NULL,
  `createdby` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groupdes`
--

INSERT INTO `groupdes` (`groupId`, `groupname`, `groupdes`, `groupimg`, `groupcover`, `createdby`) VALUES
(1, 'Dummy Group', 'This is a test dummy Group', '27-11-2018-1543292141.jpg', '27-11-2018-1543292141.jpg', 1),
(3, 'Acharya Tech', 'This is a group For ...', '27-11-2018-1543292805.jpg', '27-11-2018-1543292805.jpg', 1),
(4, 'Test Group', 'Dummy Group', '27-11-2018-1543292847.jpg', '27-11-2018-1543292847.jpg', 2),
(5, 'Check', 'test123', '27-11-2018-1543292877.jpg', '27-11-2018-1543292877.jpg', 2),
(6, 'Academy stu...', 'This is a test dummy Group', '27-11-2018-1543293138.png', '27-11-2018-1543293138.png', 3),
(7, 'Hello world', 'This is a test dummy Group', '27-11-2018-1543293249.jpg', '27-11-2018-1543293249.jpg', 3),
(8, 'New Hello World', 'This is a group For ...', '27-11-2018-1543293604.png', '27-11-2018-1543293604.png', 5);

-- --------------------------------------------------------

--
-- Table structure for table `groupmember`
--

CREATE TABLE `groupmember` (
  `join_id` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `u_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groupmember`
--

INSERT INTO `groupmember` (`join_id`, `groupid`, `u_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 2),
(5, 5, 2),
(6, 1, 3),
(7, 6, 3),
(8, 7, 3),
(9, 8, 5),
(10, 6, 6),
(11, 8, 2),
(12, 3, 2),
(13, 1, 2),
(14, 5, 8);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_login` int(11) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `name`, `email`, `gender`, `password`, `first_login`, `active`) VALUES
(1, 'Bittu Chakraborty', 'rupamcompany999@gmail.com', 'male', 'fc5b1fe18236e6e1bc92275b93432281', 1, 0),
(2, 'Rupam Chakraborty', 'rupamchakraborty999@gmail.com', 'male', 'fc5b1fe18236e6e1bc92275b93432281', 1, 1),
(3, 'Arijit Kundu', 'arijit@gmail.com', 'male', 'fc5b1fe18236e6e1bc92275b93432281', 1, 0),
(4, 'KP Chakraborty', 'kchakraborty@gmail.com', 'male', 'fc5b1fe18236e6e1bc92275b93432281', 1, 0),
(5, 'B Chakraborty', 'bchakraborty@gmail.com', 'female', 'fc5b1fe18236e6e1bc92275b93432281', 1, 0),
(6, 'Arnav Kumar', 'arnav.becs.16@acharya.ac.in', 'male', 'ae0deb9b83bc7867873158b4e5e3d239', 1, 0),
(7, 'RUPAM CHAKRABORTY', 'test@test.com', 'male', 'fc5b1fe18236e6e1bc92275b93432281', 1, 0),
(8, 'RUPAM CHAKRABORTY', 'rup@rup.com', 'male', 'd8578edf8458ce06fbc5bb76a58c5ca4', 1, 1),
(9, 'RUPAM CHAKRABORTY', 'a@aa.com', 'male', '26a58b9e6ef5c3d61aa04d820ba35ba1', 1, 1),
(10, 'Arihant', 'ari@gmail.com', 'male', 'd8578edf8458ce06fbc5bb76a58c5ca4', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `log_login`
--

CREATE TABLE `log_login` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_profile`
--

CREATE TABLE `log_profile` (
  `u_id` int(11) NOT NULL,
  `profile_img` varchar(255) NOT NULL,
  `datee` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_profile`
--

INSERT INTO `log_profile` (`u_id`, `profile_img`, `datee`) VALUES
(2, '29-11-2018-1543475762.jpg', '2018-11-29'),
(6, '30-11-2018-1543561856.jpg', '2018-11-30'),
(6, '30-11-2018-1543561856.jpg', '2018-11-30'),
(7, '03-12-2018-1543844361.jpg', '2018-12-03'),
(7, '03-12-2018-1543844361.jpg', '2018-12-03'),
(8, '04-12-2018-1543902449.jpg', '2018-12-04'),
(8, '04-12-2018-1543902449.jpg', '2018-12-04'),
(10, '08-11-2019-1573236936.jpg', '2019-11-08'),
(10, '08-11-2019-1573236936.jpg', '2019-11-08');

-- --------------------------------------------------------

--
-- Table structure for table `month`
--

CREATE TABLE `month` (
  `value` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `month`
--

INSERT INTO `month` (`value`, `name`) VALUES
(1, 'jan'),
(2, 'feb'),
(3, 'mar'),
(4, 'apr'),
(5, 'may'),
(6, 'jun'),
(7, 'jul'),
(8, 'aug'),
(9, 'sep'),
(10, 'oct'),
(11, 'nov'),
(12, 'dec');

-- --------------------------------------------------------

--
-- Table structure for table `personal_chat`
--

CREATE TABLE `personal_chat` (
  `p_chat_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personal_chat`
--

INSERT INTO `personal_chat` (`p_chat_id`, `sender_id`, `receiver_id`, `message`) VALUES
(1, 1, 2, 'ok'),
(2, 2, 1, 'hello'),
(3, 1, 2, '76rdyas');

-- --------------------------------------------------------

--
-- Table structure for table `personal_details`
--

CREATE TABLE `personal_details` (
  `u_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `day` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `c_city` varchar(100) NOT NULL,
  `p_city` varchar(100) NOT NULL,
  `school` varchar(100) NOT NULL,
  `college` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `about_me` text NOT NULL,
  `intersted` varchar(25) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `cover_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personal_details`
--

INSERT INTO `personal_details` (`u_id`, `name`, `email`, `day`, `month`, `year`, `c_city`, `p_city`, `school`, `college`, `company`, `about_me`, `intersted`, `profile_pic`, `cover_pic`) VALUES
(10, 'Arihant', 'ari@gmail.com', 10, 8, 1996, 'Bangalore', 'Bangalore', 'BGA', 'AIT', '', '', '', '08-11-2019-1573236936.jpg', '08-11-2019-1573236936.jpg'),
(3, 'Arijit Kundu', 'arijit@gmail.com', 27, 11, 2018, 'Kolkata', 'Belda', 'BGA', 'UEM', 'none', '', '', '27-11-2018-1543293175.jpg', '27-11-2018-1543293081.jpg'),
(6, 'ARNAV KUMAR', 'arnav.becs.16@acharya.ac.in', 7, 8, 1999, 'bangalore', 'Bangalore', 'acharya college', 'acharya', 'Rupam company', '', '', '30-11-2018-1543561856.jpg', '30-11-2018-1543561871.jpg'),
(5, 'B Chakraborty', 'bchakraborty@gmail.com', 10, 2, 1980, 'Belda', 'Belda', 'BBV', 'Dantan College', 'none', '', '', '27-11-2018-1543293555.jpg', '27-11-2018-1543293555.jpg'),
(4, 'KP Chakraborty', 'kchakraborty@gmail.com', 21, 1, 1980, 'Belda', 'Belda', 'Belda Gangadhar Academy', 'Belda College', 'Chakraborty Fruit Store', '', '', '27-11-2018-1543293389.jpg', '27-11-2018-1543293389.jpg'),
(8, 'RUPAM CHAKRABORTY', 'rup@rup.com', 1, 1, 1970, 'erefrer', 'gfgrg', 'eefre', 'eff', 'wrwr', '', '', '04-12-2018-1543902449.jpg', '04-12-2018-1543902449.jpg'),
(2, 'Rupam Chakraborty', 'rupamchakraborty999@gmail.com', 14, 8, 1997, 'Bangalore', 'Bangalore', 'BGA', 'Acharya IT', 'Rupam company', '', '', '29-11-2018-1543475762.jpg', '27-11-2018-1543292237.jpg'),
(1, 'Bittu Chakraborty', 'rupamcompany999@gmail.com', 27, 11, 2018, 'Bangalore', 'Deuli', 'Belda Gangadhar Academy', 'Acharya IT', 'Not Yet', '', '', '27-11-2018-1543292091.jpg', '27-11-2018-1543292091.jpg'),
(7, 'RUPAM CHAKRABORTY', 'test@test.com', 1, 1, 1970, '', '', '', '', '', '', '', '03-12-2018-1543844361.jpg', '03-12-2018-1543844361.jpg');

--
-- Triggers `personal_details`
--
DELIMITER $$
CREATE TRIGGER `profile` AFTER UPDATE ON `personal_details` FOR EACH ROW INSERT INTO log_profile(u_id,profile_img,datee) VALUES (new.u_id,new.profile_pic,NOW())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `img_text` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `profile_img` int(11) NOT NULL,
  `onlyText` int(11) NOT NULL,
  `group_post` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `u_id`, `img_text`, `image`, `profile_img`, `onlyText`, `group_post`, `group_id`, `date`) VALUES
(1, 1, '', '27-11-2018-1543292091.jpg', 1, 0, 0, 0, '0000-00-00'),
(2, 1, '', '27-11-2018-1543292091.jpg', 2, 0, 0, 0, '0000-00-00'),
(3, 2, '', '27-11-2018-1543292237.jpg', 1, 0, 0, 0, '0000-00-00'),
(4, 2, '', '27-11-2018-1543292237.jpg', 2, 0, 0, 0, '0000-00-00'),
(5, 1, 'New Car', '27-11-2018-1543292905.jpg', 0, 0, 0, 0, '0000-00-00'),
(6, 1, 'Hello world', '', 0, 1, 0, 0, '0000-00-00'),
(7, 2, 'OK google', '', 0, 1, 0, 0, '0000-00-00'),
(8, 2, '', '27-11-2018-1543292945.jpg', 0, 0, 0, 0, '0000-00-00'),
(9, 3, '', '27-11-2018-1543293081.jpg', 1, 0, 0, 0, '0000-00-00'),
(10, 3, '', '27-11-2018-1543293081.jpg', 2, 0, 0, 0, '0000-00-00'),
(11, 3, 'Test 123', '', 0, 1, 0, 0, '0000-00-00'),
(12, 3, '', '27-11-2018-1543293175.jpg', 1, 0, 0, 0, '0000-00-00'),
(13, 4, '', '27-11-2018-1543293389.jpg', 1, 0, 0, 0, '0000-00-00'),
(14, 4, '', '27-11-2018-1543293389.jpg', 2, 0, 0, 0, '0000-00-00'),
(15, 4, '', '27-11-2018-1543293421.jpg', 0, 0, 0, 0, '0000-00-00'),
(16, 5, '', '27-11-2018-1543293555.jpg', 1, 0, 0, 0, '0000-00-00'),
(17, 5, '', '27-11-2018-1543293555.jpg', 2, 0, 0, 0, '0000-00-00'),
(18, 2, '', '29-11-2018-1543474243.jpg', 1, 0, 0, 0, '0000-00-00'),
(19, 2, '', '29-11-2018-1543475050.jpg', 1, 0, 0, 0, '0000-00-00'),
(20, 2, '', '29-11-2018-1543475217.png', 1, 0, 0, 0, '0000-00-00'),
(21, 2, '', '29-11-2018-1543475475.jpg', 1, 0, 0, 0, '0000-00-00'),
(22, 2, '', '29-11-2018-1543475492.jpg', 1, 0, 0, 0, '0000-00-00'),
(23, 2, '', '29-11-2018-1543475762.jpg', 1, 0, 0, 0, '0000-00-00'),
(24, 2, '', '29-11-2018-1543487532.png', 0, 0, 0, 0, '0000-00-00'),
(25, 2, '', '29-11-2018-1543487540.jpg', 0, 0, 0, 0, '0000-00-00'),
(26, 2, '', '29-11-2018-1543487548.jpg', 0, 0, 0, 0, '0000-00-00'),
(27, 6, '', '30-11-2018-1543561836.jpg', 0, 0, 0, 0, '0000-00-00'),
(28, 6, '', '30-11-2018-1543561856.jpg', 1, 0, 0, 0, '0000-00-00'),
(29, 6, '', '30-11-2018-1543561871.jpg', 2, 0, 0, 0, '0000-00-00'),
(30, 6, 'hello', '', 0, 1, 1, 6, '0000-00-00'),
(31, 2, 'hghfghfghfhg', '', 0, 1, 1, 8, '0000-00-00'),
(32, 7, '', '03-12-2018-1543844361.jpg', 1, 0, 0, 0, '0000-00-00'),
(33, 7, '', '03-12-2018-1543844361.jpg', 2, 0, 0, 0, '0000-00-00'),
(34, 8, '', '04-12-2018-1543902449.jpg', 1, 0, 0, 0, '0000-00-00'),
(35, 8, '', '04-12-2018-1543902449.jpg', 2, 0, 0, 0, '0000-00-00'),
(36, 8, 'dtdetyu', '', 0, 1, 0, 0, '0000-00-00'),
(37, 8, 'htjfgrgvj', '', 0, 1, 1, 5, '0000-00-00'),
(38, 8, 'gdcdehghc', '04-12-2018-1543902549.jpg', 0, 0, 0, 0, '0000-00-00'),
(39, 10, '', '08-11-2019-1573236936.jpg', 1, 0, 0, 0, '0000-00-00'),
(40, 10, '', '08-11-2019-1573236936.jpg', 2, 0, 0, 0, '0000-00-00'),
(41, 10, 'This is a normal Post', '', 0, 1, 0, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `profile_image`
--

CREATE TABLE `profile_image` (
  `image_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `p_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile_image`
--

INSERT INTO `profile_image` (`image_id`, `u_id`, `name`, `category`, `p_date`) VALUES
(1, 1, '27-11-2018-1543292091.jpg', 1, '0000-00-00'),
(2, 1, '27-11-2018-1543292091.jpg', 2, '0000-00-00'),
(3, 2, '27-11-2018-1543292237.jpg', 1, '0000-00-00'),
(4, 2, '27-11-2018-1543292237.jpg', 2, '0000-00-00'),
(5, 3, '27-11-2018-1543293081.jpg', 1, '0000-00-00'),
(6, 3, '27-11-2018-1543293081.jpg', 2, '0000-00-00'),
(7, 3, '27-11-2018-1543293175.jpg', 1, '0000-00-00'),
(8, 4, '27-11-2018-1543293389.jpg', 1, '0000-00-00'),
(9, 4, '27-11-2018-1543293389.jpg', 2, '0000-00-00'),
(10, 5, '27-11-2018-1543293555.jpg', 1, '0000-00-00'),
(11, 5, '27-11-2018-1543293555.jpg', 2, '0000-00-00'),
(12, 2, '29-11-2018-1543474243.jpg', 1, '0000-00-00'),
(13, 2, '29-11-2018-1543475050.jpg', 1, '0000-00-00'),
(14, 2, '29-11-2018-1543475217.png', 1, '0000-00-00'),
(15, 2, '29-11-2018-1543475475.jpg', 1, '0000-00-00'),
(16, 2, '29-11-2018-1543475492.jpg', 1, '0000-00-00'),
(17, 2, '29-11-2018-1543475762.jpg', 1, '0000-00-00'),
(18, 6, '30-11-2018-1543561856.jpg', 1, '0000-00-00'),
(19, 6, '30-11-2018-1543561871.jpg', 2, '0000-00-00'),
(20, 7, '03-12-2018-1543844361.jpg', 1, '0000-00-00'),
(21, 7, '03-12-2018-1543844361.jpg', 2, '0000-00-00'),
(22, 8, '04-12-2018-1543902449.jpg', 1, '0000-00-00'),
(23, 8, '04-12-2018-1543902449.jpg', 2, '0000-00-00'),
(24, 10, '08-11-2019-1573236936.jpg', 1, '0000-00-00'),
(25, 10, '08-11-2019-1573236936.jpg', 2, '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `friend_request`
--
ALTER TABLE `friend_request`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `groupdes`
--
ALTER TABLE `groupdes`
  ADD PRIMARY KEY (`groupId`);

--
-- Indexes for table `groupmember`
--
ALTER TABLE `groupmember`
  ADD PRIMARY KEY (`join_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `month`
--
ALTER TABLE `month`
  ADD PRIMARY KEY (`value`);

--
-- Indexes for table `personal_chat`
--
ALTER TABLE `personal_chat`
  ADD PRIMARY KEY (`p_chat_id`);

--
-- Indexes for table `personal_details`
--
ALTER TABLE `personal_details`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `profile_image`
--
ALTER TABLE `profile_image`
  ADD PRIMARY KEY (`image_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `friend_request`
--
ALTER TABLE `friend_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `groupdes`
--
ALTER TABLE `groupdes`
  MODIFY `groupId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `groupmember`
--
ALTER TABLE `groupmember`
  MODIFY `join_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_chat`
--
ALTER TABLE `personal_chat`
  MODIFY `p_chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `profile_image`
--
ALTER TABLE `profile_image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
