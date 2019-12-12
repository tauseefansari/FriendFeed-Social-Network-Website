-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2019 at 07:19 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socnet`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_body` text NOT NULL,
  `posted_by` varchar(60) NOT NULL,
  `posted_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `removed` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_body`, `posted_by`, `posted_to`, `date_added`, `removed`, `post_id`) VALUES
(1, 'Nice Post', 'tauseef_ansari', 'tauseef_ansari', '2019-07-27 18:59:48', 'no', 2),
(2, 'Awesome Post', 'tauseef_ansari', 'tauseef_ansari', '2019-07-27 19:00:32', 'no', 1),
(3, 'Thank You', 'tauseef_ansari', 'tauseef_ansari', '2019-07-28 11:49:26', 'no', 2),
(4, 'I know!', 'tauseef_ansari', 'tauseef_ansari', '2019-07-28 11:49:47', 'no', 1),
(5, 'if this is Empty then Not Work!', 'tauseef_ansari', 'tauseef_ansari', '2019-07-28 12:43:20', 'no', 2),
(6, 'nice one', 'mark_zuckerberg', 'tauseef_ansari', '2019-08-07 16:43:55', 'no', 7),
(7, 'nice post', 'mark_zuckerberg', 'tauseef_ansari', '2019-08-07 16:44:51', 'no', 7),
(8, 'hey', 'mark_zuckerberg', 'tauseef_ansari', '2019-08-07 16:46:30', 'no', 7),
(9, 'awesome post', 'mark_zuckerberg', 'tauseef_ansari', '2019-08-07 16:47:24', 'no', 7);

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `username`, `post_id`) VALUES
(5, 'tauseef_ansari', 1),
(6, 'tauseef_ansari', 2),
(11, 'tauseef_ansari', 3),
(13, 'mark_zuckerberg', 7),
(14, 'mark_zuckerberg', 3),
(15, 'mark_zuckerberg', 6),
(20, 'tauseef_ansari', 11),
(21, 'tauseef_ansari', 10),
(24, 'tauseef_ansari', 8),
(28, 'mark_zuckerberg', 12),
(30, 'tauseef_ansari', 13);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_to`, `user_from`, `body`, `date`, `opened`, `viewed`, `deleted`) VALUES
(1, 'mark_zuckerberg', 'tauseef_ansari', 'this is my first message', '2019-08-02 18:22:26', 'yes', 'yes', 'no'),
(2, 'mark_zuckerberg', 'tauseef_ansari', 'hiii', '2019-08-03 17:47:59', 'yes', 'yes', 'no'),
(3, 'tauseef_ansari', 'mark_zuckerberg', 'hiii\r\n', '2019-08-03 17:49:05', 'yes', 'yes', 'no'),
(4, 'tauseef_ansari', 'mark_zuckerberg', 'we got the message', '2019-08-03 17:49:17', 'yes', 'yes', 'no'),
(5, 'mark_zuckerberg', 'tauseef_ansari', 'hiii', '2019-08-03 17:49:23', 'yes', 'yes', 'no'),
(6, 'mark_zuckerberg', 'tauseef_ansari', 'hiii', '2019-08-03 17:52:52', 'yes', 'yes', 'no'),
(7, 'mark_zuckerberg', 'tauseef_ansari', 'hiii', '2019-08-03 17:54:12', 'yes', 'yes', 'no'),
(8, 'mark_zuckerberg', 'tauseef_ansari', 'hiii', '2019-08-03 17:54:14', 'yes', 'yes', 'no'),
(9, 'tauseef_ansari', 'mark_zuckerberg', 'we got the message', '2019-08-03 17:54:26', 'yes', 'yes', 'no'),
(10, 'tauseef_ansari', 'mark_zuckerberg', 'done\r\n', '2019-08-03 17:54:40', 'yes', 'yes', 'no'),
(11, 'mark_zuckerberg', 'tauseef_ansari', 'hiii', '2019-08-03 17:54:45', 'yes', 'yes', 'no'),
(12, 'mark_zuckerberg', 'tauseef_ansari', 'hiii', '2019-08-03 18:01:47', 'yes', 'yes', 'no'),
(13, 'mark_zuckerberg', 'tauseef_ansari', 'check for auto scrolling', '2019-08-03 18:02:13', 'yes', 'yes', 'no'),
(14, 'mark_zuckerberg', 'tauseef_ansari', 'again check', '2019-08-03 18:02:26', 'yes', 'yes', 'no'),
(15, 'dennis_ritchie', 'tauseef_ansari', 'Hii Dennis Ritchie', '2019-08-04 15:18:37', 'yes', 'yes', 'no'),
(16, 'tauseef_ansari', 'dennis_ritchie', 'Hello Tauseef', '2019-08-04 15:20:22', 'yes', 'yes', 'no'),
(17, 'mark_zuckerberg', 'tauseef_ansari', 'check later', '2019-08-04 17:21:44', 'yes', 'yes', 'no'),
(18, 'mark_zuckerberg', 'tauseef_ansari', 'again check', '2019-08-04 17:22:46', 'yes', 'yes', 'no'),
(19, 'mark_zuckerberg', 'tauseef_ansari', 're check', '2019-08-04 17:23:51', 'yes', 'yes', 'no'),
(20, 'mark_zuckerberg', 'tauseef_ansari', 'checking work', '2019-08-04 17:25:07', 'yes', 'yes', 'no'),
(21, 'dennis_ritchie', 'tauseef_ansari', 'hiii\r\n', '2019-08-05 14:01:34', 'yes', 'yes', 'no'),
(22, 'dennis_ritchie', 'tauseef_ansari', 'hello', '2019-08-05 14:01:41', 'yes', 'yes', 'no'),
(23, 'tauseef_ansari', 'mark_zuckerberg', 'check notification', '2019-08-05 17:57:38', 'yes', 'yes', 'no'),
(24, 'tauseef_ansari', 'mark_zuckerberg', 'notification check', '2019-08-07 15:48:47', 'yes', 'yes', 'no'),
(25, 'tauseef_ansari', 'mark_zuckerberg', 'hiii', '2019-08-07 16:43:10', 'yes', 'yes', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_to`, `user_from`, `message`, `link`, `datetime`, `opened`, `viewed`) VALUES
(1, 'tauseef_ansari', 'mark_zuckerberg', 'Mark Zuckerberg liked your post', 'post.php?id=9', '2019-08-07 15:47:09', 'yes', 'yes'),
(2, 'tauseef_ansari', 'mark_zuckerberg', 'Mark Zuckerberg commented on your post', 'post.php?id=7', '2019-08-07 16:44:51', 'yes', 'yes'),
(4, 'tauseef_ansari', 'mark_zuckerberg', 'Mark Zuckerberg commented on your post', 'post.php?id=7', '2019-08-07 16:46:30', 'yes', 'yes'),
(6, 'tauseef_ansari', 'mark_zuckerberg', 'Mark Zuckerberg commented on your post', 'post.php?id=7', '2019-08-07 16:47:24', 'yes', 'yes'),
(7, 'tauseef_ansari', 'mark_zuckerberg', 'Mark Zuckerberg liked your post', 'post.php?id=10', '2019-08-07 16:47:46', 'yes', 'yes'),
(8, 'tauseef_ansari', 'mark_zuckerberg', 'Mark Zuckerberg posted on your profile', 'post.php?id=11', '2019-08-07 16:54:47', 'yes', 'yes'),
(9, 'mark_zuckerberg', 'tauseef_ansari', 'Tauseef Ansari liked your post', 'post.php?id=11', '2019-08-07 16:57:34', 'yes', 'yes'),
(10, 'mark_zuckerberg', 'tauseef_ansari', 'Tauseef Ansari liked your post', 'post.php?id=11', '2019-08-07 16:59:59', 'yes', 'yes'),
(11, 'mark_zuckerberg', 'tauseef_ansari', 'Tauseef Ansari liked your post', 'post.php?id=11', '2019-08-08 16:41:45', 'yes', 'yes'),
(12, 'mark_zuckerberg', 'tauseef_ansari', 'Tauseef Ansari liked your post', 'post.php?id=10', '2019-08-08 17:25:45', 'yes', 'yes'),
(13, 'mark_zuckerberg', 'tauseef_ansari', 'Tauseef Ansari liked your post', 'post.php?id=9', '2019-08-14 13:26:31', 'yes', 'yes'),
(14, 'mark_zuckerberg', 'tauseef_ansari', 'Tauseef Ansari liked your post', 'post.php?id=9', '2019-08-14 13:26:44', 'yes', 'yes'),
(15, 'dennis_ritchie', 'tauseef_ansari', 'Tauseef Ansari liked your post', 'post.php?id=8', '2019-08-14 13:27:17', 'no', 'no'),
(16, 'tauseef_ansari', 'mark_zuckerberg', 'Mark Zuckerberg liked your post', 'post.php?id=12', '2019-08-14 13:29:16', 'yes', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL,
  `added_by` varchar(60) NOT NULL,
  `user_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  `likes` int(11) NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `added_by`, `user_to`, `date_added`, `user_closed`, `deleted`, `likes`, `image`) VALUES
(1, 'Welcome to Social Network!!!!!', 'tauseef_ansari', 'none', '2019-07-25 17:10:42', 'no', 'no', 1, ''),
(2, 'This is Social Networking Website!!!!! ', 'tauseef_ansari', 'none', '2019-07-26 17:18:22', 'no', 'no', 1, ''),
(3, 'Checking Comment Section', 'tauseef_ansari', 'none', '2019-07-28 13:29:35', 'no', 'no', 2, ''),
(4, 'Testing Another Friend', 'mark_zuckerberg', 'none', '2019-07-29 15:31:42', 'no', 'no', 0, ''),
(5, 'private post', 'mark_zuckerberg', 'none', '2019-07-30 18:16:02', 'no', 'no', 0, ''),
(6, 'Hello Tauseef Ansari', 'mark_zuckerberg', 'tauseef_ansari', '2019-07-30 18:18:08', 'no', 'no', 1, ''),
(7, 'Hello Mark', 'tauseef_ansari', 'mark_zuckerberg', '2019-07-30 18:23:01', 'no', 'yes', 1, ''),
(8, 'Hii \r\nI am Dennis', 'dennis_ritchie', 'tauseef_ansari', '2019-08-04 15:21:01', 'no', 'no', 1, ''),
(9, 'private post', 'mark_zuckerberg', 'tauseef_ansari', '2019-08-07 15:47:09', 'no', 'no', 0, ''),
(10, 'ohhhh yeahhhhh!!!!', 'mark_zuckerberg', 'tauseef_ansari', '2019-08-07 16:47:46', 'no', 'no', 1, ''),
(11, 'profile post option!!!', 'mark_zuckerberg', 'tauseef_ansari', '2019-08-07 16:54:47', 'no', 'no', 1, ''),
(12, 'Checking Likes\r\n', 'tauseef_ansari', 'none', '2019-08-14 13:28:55', 'no', 'no', 1, ''),
(13, 'Checking Post', 'tauseef_ansari', 'none', '2019-08-14 13:31:30', 'no', 'no', 1, ''),
(14, 'again Checking Post', 'tauseef_ansari', 'none', '2019-08-14 13:32:49', 'no', 'no', 0, ''),
(15, 'hiiiiiiiiiiiii', 'tauseef_ansari', 'none', '2019-08-14 13:34:20', 'no', 'no', 0, ''),
(16, '<br> <iframe width=\'420\' height=\'315\' src=\'https://www.youtube.com/embed/kWmX3pd1f10\'></iframe> <br>', 'tauseef_ansari', 'none', '2019-08-14 15:48:38', 'no', 'no', 0, ''),
(17, '<br> <iframe width=\'420\' height=\'315\' src=\'https://www.youtube.com/embed/J7LqgglEfQw\'></iframe> <br>', 'tauseef_ansari', 'none', '2019-08-14 15:55:15', 'no', 'no', 0, ''),
(18, 'Checking for trending words', 'tauseef_ansari', 'none', '2019-08-14 16:51:36', 'no', 'yes', 0, ''),
(19, 'Check trending word', 'tauseef_ansari', 'none', '2019-08-14 16:53:11', 'no', 'yes', 0, ''),
(20, 'Checking trending words', 'tauseef_ansari', 'none', '2019-08-14 16:59:59', 'no', 'no', 0, ''),
(21, 'Buggati Chiron', 'tauseef_ansari', 'none', '2019-08-14 18:10:15', 'no', 'yes', 0, 'assets/images/posts/5d54407762be4se-image-204c6caaa086fafe35dc6199ebe10880.jpg'),
(22, 'Buggati Chiron', 'tauseef_ansari', 'none', '2019-08-14 18:18:03', 'no', 'no', 0, 'assets/images/posts/5d54424b99a2e5d54407762be4se-image-204c6caaa086fafe35dc6199ebe10880.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `trends`
--

CREATE TABLE `trends` (
  `title` varchar(50) NOT NULL,
  `hits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trends`
--

INSERT INTO `trends` (`title`, `hits`) VALUES
('Checking', 1),
('Trending', 1),
('Words', 1),
('Buggati', 2),
('Chiron', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signup_date` date NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `num_post` int(11) NOT NULL,
  `num_likes` int(11) NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `friend_array` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `signup_date`, `profile_pic`, `num_post`, `num_likes`, `user_closed`, `friend_array`) VALUES
(1, 'Tauseef', 'Ansari', 'tauseef_ansari', 'tauseeftanvir@gmail.com', '543284b3413aa53934514fe0b2d6d436', '2019-07-25', 'assets/images/profile_pics/tauseef_ansari99151a3e08814ed0b38d6cea88ff56acn.jpeg', 16, 7, 'no', ',dennis_ritchie,james_gosling,mark_zuckerberg,'),
(2, 'Mark', 'Zuckerberg', 'mark_zuckerberg', 'Abc@gmail.com', 'd6b0ab7f1c8ab8f514db9a6d85de160a', '2019-07-29', 'assets/images/profile_pics/mark_zuckerberg1b0db20496e577245a25d7e33dda14f3n.jpeg', 6, 3, 'no', ',tauseef_ansari,'),
(3, 'Dennis', 'Ritchie', 'dennis_ritchie', 'Dennis@gmail.com', '2bde5d2edf2091021fbca34253a86832', '2019-08-04', 'assets/images/profile_pics/defaults/head_emerald.png', 1, 1, 'no', ',tauseef_ansari,'),
(4, 'James', 'Gosling', 'james_gosling', 'James@gmail.com', '0af851d6672212da9a457d4f9cd056c8', '2019-08-08', 'assets/images/profile_pics/defaults/head_carrot.png', 0, 0, 'no', ',tauseef_ansari,');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
