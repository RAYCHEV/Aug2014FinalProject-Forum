-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 
-- Версия на сървъра: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `forum`
--

-- --------------------------------------------------------

--
-- Структура на таблица `cat`
--

CREATE TABLE IF NOT EXISTS `cat` (
`cat_id` int(11) NOT NULL,
  `group_cat_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `desc` varchar(250) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `date_added` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Структура на таблица `group_cat`
--

CREATE TABLE IF NOT EXISTS `group_cat` (
`group_cat_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `date_added` int(11) NOT NULL,
  `desc` varchar(250) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Структура на таблица `in-posts`
--

CREATE TABLE IF NOT EXISTS `in-posts` (
`in-post_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `date_added` int(11) NOT NULL,
  `content` text NOT NULL,
  `view_count` int(11) NOT NULL,
  `edited_by` int(11) NOT NULL,
  `editet_when` time NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Структура на таблица `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
`post_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `date_added` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `view_count` int(11) NOT NULL,
  `edited_by` int(11) NOT NULL,
  `editet_when` time NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `real_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_registred` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cat`
--
ALTER TABLE `cat`
 ADD PRIMARY KEY (`cat_id`), ADD KEY `group_cat_id` (`group_cat_id`);

--
-- Indexes for table `group_cat`
--
ALTER TABLE `group_cat`
 ADD PRIMARY KEY (`group_cat_id`);

--
-- Indexes for table `in-posts`
--
ALTER TABLE `in-posts`
 ADD PRIMARY KEY (`in-post_id`), ADD KEY `added_by` (`added_by`), ADD KEY `cat_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
 ADD PRIMARY KEY (`post_id`), ADD KEY `added_by` (`added_by`), ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cat`
--
ALTER TABLE `cat`
MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `group_cat`
--
ALTER TABLE `group_cat`
MODIFY `group_cat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `in-posts`
--
ALTER TABLE `in-posts`
MODIFY `in-post_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;