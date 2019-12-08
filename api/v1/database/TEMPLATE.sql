-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2019 at 05:57 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `blog_roles_services_map`
--

CREATE TABLE `blog_roles_services_map` (
  `map_id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `service_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog_roles_services_users_map`
--

CREATE TABLE `blog_roles_services_users_map` (
  `map_id` bigint(20) NOT NULL,
  `role_id` bigint(20) DEFAULT NULL,
  `service_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'admin', '2019-12-08 16:23:41');

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
(1, 'e2fc714c4727ee9395f324cd2e7f331f');

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
(1, 'admin@developerswork.yt', NULL, 0);

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
  ADD PRIMARY KEY (`role_id`);

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
  ADD UNIQUE KEY `role_service_map_id` (`role_id`,`user_id`),
  ADD UNIQUE KEY `service_id` (`service_id`,`user_id`),
  ADD KEY `roles_services_users map user_id` (`user_id`);

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
  MODIFY `post_revision_part_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts_metadata`
--
ALTER TABLE `blog_posts_metadata`
  MODIFY `post_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_roles`
--
ALTER TABLE `blog_roles`
  MODIFY `role_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_roles_services_map`
--
ALTER TABLE `blog_roles_services_map`
  MODIFY `map_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_roles_services_users_map`
--
ALTER TABLE `blog_roles_services_users_map`
  MODIFY `map_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_services`
--
ALTER TABLE `blog_services`
  MODIFY `service_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_users`
--
ALTER TABLE `blog_users`
  MODIFY `uid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `roles_services_users map role_id` FOREIGN KEY (`role_id`) REFERENCES `blog_roles` (`role_id`),
  ADD CONSTRAINT `roles_services_users map service_id` FOREIGN KEY (`service_id`) REFERENCES `blog_services` (`service_id`),
  ADD CONSTRAINT `roles_services_users map user_id` FOREIGN KEY (`user_id`) REFERENCES `blog_users` (`uid`);

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
