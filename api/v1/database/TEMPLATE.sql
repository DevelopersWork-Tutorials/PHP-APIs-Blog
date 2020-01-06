-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2020 at 05:30 PM
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
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `comment_id` bigint(20) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(512) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments_metadata`
--

CREATE TABLE `blog_comments_metadata` (
  `comment_id` bigint(20) NOT NULL,
  `comment_author` bigint(20) DEFAULT NULL,
  `comment_author_email` varchar(255) DEFAULT NULL,
  `post_id` bigint(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `post_id` bigint(20) NOT NULL,
  `post_part` bigint(20) NOT NULL,
  `post_content` varchar(10000) NOT NULL,
  `post_revision` bigint(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `post_revision_part_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`post_id`, `post_part`, `post_content`, `post_revision`, `timestamp`, `post_revision_part_id`) VALUES
(1, 1, 'This is simple Post', 1, '2019-12-22 16:37:29', 1),
(1, 1, 'Hello World', 2, '2019-12-30 15:19:24', 3);

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts_metadata`
--

CREATE TABLE `blog_posts_metadata` (
  `post_id` bigint(20) NOT NULL,
  `post_title` varchar(512) NOT NULL,
  `post_author_id` bigint(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_posts_metadata`
--

INSERT INTO `blog_posts_metadata` (`post_id`, `post_title`, `post_author_id`, `timestamp`) VALUES
(1, 'Hello World', 1, '2019-12-17 17:28:58');

-- --------------------------------------------------------

--
-- Table structure for table `blog_roles`
--

CREATE TABLE `blog_roles` (
  `role_id` bigint(20) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `priority` bigint(20) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_roles`
--

INSERT INTO `blog_roles` (`role_id`, `role_name`, `priority`, `timestamp`) VALUES
(0, 'OWNER', 99999999999, '2019-12-31 15:26:56'),
(1, 'ADMINISTRATOR', 9999, '2019-12-17 17:29:30'),
(2, 'MODERATOR', 9998, '2019-12-17 17:29:43'),
(3, 'USER', 1, '2019-12-22 16:42:20'),
(4, 'CONTRIBUTOR', 10, '2019-12-22 16:42:56'),
(5, 'AUTHOR', 25, '2019-12-22 16:42:56'),
(6, 'EDITOR', 50, '2019-12-22 16:43:05'),
(8, 'comment_mod', 25, '2020-01-06 16:28:49');

-- --------------------------------------------------------

--
-- Table structure for table `blog_roles_services_map`
--

CREATE TABLE `blog_roles_services_map` (
  `map_id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `service_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_roles_services_map`
--

INSERT INTO `blog_roles_services_map` (`map_id`, `role_id`, `service_id`) VALUES
(1, 3, 1),
(3, 4, 13),
(2, 5, 3),
(4, 8, 3),
(5, 8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `blog_roles_services_users_map`
--

CREATE TABLE `blog_roles_services_users_map` (
  `map_id` bigint(20) NOT NULL,
  `role_id` bigint(20) DEFAULT NULL,
  `service_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `isOwner` tinyint(1) DEFAULT NULL,
  `createdBy` bigint(20) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_roles_services_users_map`
--

INSERT INTO `blog_roles_services_users_map` (`map_id`, `role_id`, `service_id`, `user_id`, `isOwner`, `createdBy`, `isActive`, `timestamp`) VALUES
(1, 0, NULL, 1, 1, 1, 1, '2019-12-31 15:59:19'),
(2, 1, NULL, 1, NULL, 1, 1, '2019-12-31 15:59:58'),
(3, 5, NULL, 2, NULL, 1, 1, '2019-12-31 16:19:18'),
(4, 2, NULL, 2, NULL, 1, 1, '2019-12-31 16:21:54'),
(6, 2, NULL, 4, NULL, 1, 0, '2019-12-31 16:23:12'),
(8, 2, NULL, 4, NULL, 1, 1, '2019-12-31 16:24:45'),
(9, NULL, 3, 4, NULL, 1, 0, '2020-01-05 16:38:25'),
(10, NULL, 4, 4, NULL, 1, 0, '2020-01-05 16:38:25'),
(15, NULL, 3, 4, NULL, 1, 1, '2020-01-05 16:40:08'),
(16, NULL, 4, 4, NULL, 1, 1, '2020-01-05 16:40:08');

-- --------------------------------------------------------

--
-- Table structure for table `blog_services`
--

CREATE TABLE `blog_services` (
  `service_id` bigint(20) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_parent` bigint(20) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_services`
--

INSERT INTO `blog_services` (`service_id`, `service_name`, `service_parent`, `timestamp`) VALUES
(1, 'CHANGE PASSWORD', NULL, '2019-12-17 17:30:08'),
(2, 'POSTS', NULL, '2019-12-22 16:43:34'),
(3, 'CREATE', 2, '2019-12-22 16:43:42'),
(4, 'UPDATE', 2, '2019-12-22 16:43:51'),
(5, 'DELETE', 2, '2019-12-22 16:43:59'),
(6, 'READ', 2, '2019-12-22 16:44:16'),
(7, 'COMMENTS', NULL, '2019-12-22 16:44:41'),
(8, 'CREATE', 7, '2019-12-22 16:44:46'),
(9, 'UPDATE', 7, '2019-12-22 16:44:52'),
(10, 'DELETE', 7, '2019-12-22 16:45:01'),
(11, 'READ', 7, '2019-12-22 16:45:05'),
(12, 'APPROVE', 7, '2019-12-22 16:45:11'),
(13, 'SPAM', 7, '2019-12-22 16:45:16'),
(14, 'ROLES', NULL, '2019-12-31 15:24:02'),
(15, 'CREATE', 14, '2019-12-31 15:24:31'),
(16, 'UPDATE', 14, '2019-12-31 15:24:31'),
(17, 'ASSIGN', 14, '2019-12-31 15:24:43');

-- --------------------------------------------------------

--
-- Table structure for table `blog_users`
--

CREATE TABLE `blog_users` (
  `uid` bigint(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_users`
--

INSERT INTO `blog_users` (`uid`, `username`, `createdOn`) VALUES
(1, 'admin', '2019-12-08 16:23:41'),
(2, 'admin1', '2019-12-16 16:29:51'),
(3, 'mod', '2019-12-16 16:30:44'),
(4, 'admin5', '2019-12-17 17:21:08'),
(5, 'admin6', '2019-12-17 17:21:57'),
(7, 'admin7', '2019-12-17 17:57:58'),
(8, 'admin8', '2019-12-29 15:44:14'),
(9, 'admin9', '2019-12-29 15:50:34'),
(10, 'admin90', '2019-12-29 15:52:22'),
(11, 'admin91', '2019-12-29 15:53:11'),
(12, 'admin92', '2019-12-29 15:53:38');

-- --------------------------------------------------------

--
-- Table structure for table `blog_users_credentials`
--

CREATE TABLE `blog_users_credentials` (
  `uid` bigint(20) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT 'e2fc714c4727ee9395f324cd2e7f331f'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_users_credentials`
--

INSERT INTO `blog_users_credentials` (`uid`, `password`) VALUES
(1, 'e35cf7b66449df565f93c607d5a81d09'),
(2, 'e2fc714c4727ee9395f324cd2e7f331f'),
(3, 'adcaec3805aa912c0d0b14a81bedb6ff'),
(5, 'adcaec3805aa912c0d0b14a81bedb6ff'),
(7, 'adcaec3805aa912c0d0b14a81bedb6ff'),
(8, 'e10adc3949ba59abbe56e057f20f883e'),
(9, 'e10adc3949ba59abbe56e057f20f883e'),
(10, 'e10adc3949ba59abbe56e057f20f883e'),
(11, 'e10adc3949ba59abbe56e057f20f883e'),
(12, 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `blog_users_information`
--

CREATE TABLE `blog_users_information` (
  `uid` bigint(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phoneNumber` bigint(20) DEFAULT NULL,
  `emailVerified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_users_information`
--

INSERT INTO `blog_users_information` (`uid`, `email`, `phoneNumber`, `emailVerified`) VALUES
(1, 'admin@developerswork.yt', NULL, 0),
(2, 'admin1@developerswork.yt', 0, 0),
(3, 'mod@developerswork.yt', 1211214742454, 0),
(5, 'mod2@developerswork.yt', NULL, 0),
(7, 'mod3@developerswork.yt', NULL, 0),
(8, 'admin8@sas.a', NULL, 0),
(9, 'admin9@sas.a', NULL, 0),
(10, 'admin90@sas.a', NULL, 0),
(11, 'admin80@sas.a', NULL, 0),
(12, 'admin82@sas.a', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `blog_comments_metadata`
--
ALTER TABLE `blog_comments_metadata`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `blog_comments_metadata map user_id` (`comment_author`),
  ADD KEY `blog_comments_metadata map post_id` (`post_id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`post_revision_part_id`),
  ADD UNIQUE KEY `post_id` (`post_id`,`post_part`,`post_revision`);

--
-- Indexes for table `blog_posts_metadata`
--
ALTER TABLE `blog_posts_metadata`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `post_title` (`post_title`,`post_author_id`),
  ADD KEY `post_metadata map user_id` (`post_author_id`);

--
-- Indexes for table `blog_roles`
--
ALTER TABLE `blog_roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `blog_roles_services_map`
--
ALTER TABLE `blog_roles_services_map`
  ADD PRIMARY KEY (`map_id`),
  ADD UNIQUE KEY `role_id` (`role_id`,`service_id`),
  ADD KEY `roles_services map service_id` (`service_id`);

--
-- Indexes for table `blog_roles_services_users_map`
--
ALTER TABLE `blog_roles_services_users_map`
  ADD PRIMARY KEY (`map_id`),
  ADD UNIQUE KEY `isOwner` (`isOwner`),
  ADD UNIQUE KEY `role_service_map_id` (`role_id`,`user_id`,`isActive`) USING BTREE,
  ADD UNIQUE KEY `service_id` (`service_id`,`user_id`,`isActive`) USING BTREE,
  ADD KEY `roles_services_users map uid` (`user_id`),
  ADD KEY `roles_services_users map createdBy` (`createdBy`);

--
-- Indexes for table `blog_services`
--
ALTER TABLE `blog_services`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `service_parent map service_id` (`service_parent`);

--
-- Indexes for table `blog_users`
--
ALTER TABLE `blog_users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `blog_users_credentials`
--
ALTER TABLE `blog_users_credentials`
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `blog_users_information`
--
ALTER TABLE `blog_users_information`
  ADD UNIQUE KEY `uid` (`uid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_comments_metadata`
--
ALTER TABLE `blog_comments_metadata`
  MODIFY `comment_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `post_revision_part_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_posts_metadata`
--
ALTER TABLE `blog_posts_metadata`
  MODIFY `post_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_roles`
--
ALTER TABLE `blog_roles`
  MODIFY `role_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `blog_roles_services_map`
--
ALTER TABLE `blog_roles_services_map`
  MODIFY `map_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `blog_roles_services_users_map`
--
ALTER TABLE `blog_roles_services_users_map`
  MODIFY `map_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `blog_services`
--
ALTER TABLE `blog_services`
  MODIFY `service_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `blog_users`
--
ALTER TABLE `blog_users`
  MODIFY `uid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD CONSTRAINT `comments map comment_id` FOREIGN KEY (`comment_id`) REFERENCES `blog_comments_metadata` (`comment_id`);

--
-- Constraints for table `blog_comments_metadata`
--
ALTER TABLE `blog_comments_metadata`
  ADD CONSTRAINT `blog_comments_metadata map post_id` FOREIGN KEY (`post_id`) REFERENCES `blog_posts_metadata` (`post_id`),
  ADD CONSTRAINT `blog_comments_metadata map user_id` FOREIGN KEY (`comment_author`) REFERENCES `blog_users` (`uid`);

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `posts map post_id` FOREIGN KEY (`post_id`) REFERENCES `blog_posts_metadata` (`post_id`);

--
-- Constraints for table `blog_posts_metadata`
--
ALTER TABLE `blog_posts_metadata`
  ADD CONSTRAINT `post_metadata map user_id` FOREIGN KEY (`post_author_id`) REFERENCES `blog_users` (`uid`);

--
-- Constraints for table `blog_roles_services_map`
--
ALTER TABLE `blog_roles_services_map`
  ADD CONSTRAINT `roles_services map role_id` FOREIGN KEY (`role_id`) REFERENCES `blog_roles` (`role_id`),
  ADD CONSTRAINT `roles_services map service_id` FOREIGN KEY (`service_id`) REFERENCES `blog_services` (`service_id`);

--
-- Constraints for table `blog_roles_services_users_map`
--
ALTER TABLE `blog_roles_services_users_map`
  ADD CONSTRAINT `roles_services_users map createdBy` FOREIGN KEY (`createdBy`) REFERENCES `blog_users` (`uid`),
  ADD CONSTRAINT `roles_services_users map role_id` FOREIGN KEY (`role_id`) REFERENCES `blog_roles` (`role_id`),
  ADD CONSTRAINT `roles_services_users map service_id` FOREIGN KEY (`service_id`) REFERENCES `blog_services` (`service_id`),
  ADD CONSTRAINT `roles_services_users map uid` FOREIGN KEY (`user_id`) REFERENCES `blog_users` (`uid`);

--
-- Constraints for table `blog_services`
--
ALTER TABLE `blog_services`
  ADD CONSTRAINT `service_parent map service_id` FOREIGN KEY (`service_parent`) REFERENCES `blog_services` (`service_id`);

--
-- Constraints for table `blog_users_credentials`
--
ALTER TABLE `blog_users_credentials`
  ADD CONSTRAINT `users_credentials link users` FOREIGN KEY (`uid`) REFERENCES `blog_users` (`uid`);

--
-- Constraints for table `blog_users_information`
--
ALTER TABLE `blog_users_information`
  ADD CONSTRAINT `users_info link users` FOREIGN KEY (`uid`) REFERENCES `blog_users` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
