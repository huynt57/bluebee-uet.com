-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2014 at 06:19 PM
-- Server version: 5.5.34
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bluebee`
--

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(45) DEFAULT NULL,
  `object_type` varchar(45) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `possessive` int(11) DEFAULT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `clicked` int(11) DEFAULT NULL,
  `relevant_id` int(11) DEFAULT NULL,
  `relevant_object` int(11) DEFAULT NULL,
  `app` varchar(45) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class`
--

CREATE TABLE IF NOT EXISTS `tbl_class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_code` varchar(45) DEFAULT NULL,
  `class_avatar` varchar(200) DEFAULT NULL,
  `class_cover` varchar(200) DEFAULT NULL,
  `class_description` varchar(200) DEFAULT NULL,
  `class_name` varchar(200) DEFAULT NULL,
  `class_active` varchar(45) DEFAULT NULL,
  `class_token` varchar(200) DEFAULT NULL,
  `class_credit_number` int(10) DEFAULT NULL,
  `class_website` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_class`
--

INSERT INTO `tbl_class` (`class_id`, `class_code`, `class_avatar`, `class_cover`, `class_description`, `class_name`, `class_active`, `class_token`, `class_credit_number`, `class_website`) VALUES
(1, '123', NULL, NULL, NULL, 'test', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class_teacher`
--

CREATE TABLE IF NOT EXISTS `tbl_class_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class_user`
--

CREATE TABLE IF NOT EXISTS `tbl_class_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_class_user`
--

INSERT INTO `tbl_class_user` (`id`, `class_id`, `user_id`, `is_active`, `admin_id`) VALUES
(1, 1, 5, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class_year`
--

CREATE TABLE IF NOT EXISTS `tbl_class_year` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_code` varchar(200) DEFAULT NULL,
  `class_year` varchar(200) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_class_year`
--

INSERT INTO `tbl_class_year` (`id`, `class_code`, `class_year`, `is_active`, `class_id`) VALUES
(3, '123', '2014', NULL, 5),
(4, '1234', '2014', NULL, 6),
(5, '123123124', '2014', NULL, 7),
(7, 'INT2007', '2014', NULL, 9),
(8, '456', '2014', NULL, 10),
(9, '456', '2014', NULL, 11),
(10, '789', '2014', NULL, 12),
(11, '7890', '2014', NULL, 13),
(12, '7890', '2014', NULL, 14);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE IF NOT EXISTS `tbl_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_post_id` int(11) DEFAULT NULL,
  `comment_group_id` int(11) DEFAULT NULL,
  `comment_class_id` int(11) DEFAULT NULL,
  `comment_author_id` int(11) DEFAULT NULL,
  `comment_content` varchar(300) DEFAULT NULL,
  `comment_time` timestamp NULL DEFAULT NULL,
  `comment_active` int(11) DEFAULT NULL,
  `comment_rate` int(11) DEFAULT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `tbl_comment`
--

INSERT INTO `tbl_comment` (`comment_id`, `comment_post_id`, `comment_group_id`, `comment_class_id`, `comment_author_id`, `comment_content`, `comment_time`, `comment_active`, `comment_rate`) VALUES
(40, 4, NULL, 1, NULL, 'long', NULL, NULL, NULL),
(41, 4, NULL, 1, NULL, 'phong', NULL, NULL, NULL),
(42, 3, NULL, 1, NULL, 'hao', NULL, NULL, NULL),
(43, 4, NULL, 1, NULL, 'hao', NULL, NULL, NULL),
(44, 3, NULL, 1, NULL, 'phong', NULL, NULL, NULL),
(45, 4, NULL, 1, NULL, 'phong', NULL, NULL, NULL),
(46, 4, NULL, 1, NULL, 'khanh', NULL, NULL, NULL),
(47, 4, NULL, 1, NULL, 'phong', NULL, NULL, NULL),
(48, 4, NULL, 1, NULL, 'long', NULL, NULL, NULL),
(49, 3, NULL, 1, NULL, 'phong', NULL, NULL, NULL),
(50, 4, NULL, 1, NULL, 'thang', NULL, NULL, NULL),
(51, 5, NULL, 1, NULL, 'lfdsjaldf', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dept`
--

CREATE TABLE IF NOT EXISTS `tbl_dept` (
  `dept_id` int(100) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) DEFAULT NULL,
  `dept_active` int(2) DEFAULT NULL,
  `dept_faculty` int(2) DEFAULT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_doc`
--

CREATE TABLE IF NOT EXISTS `tbl_doc` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_url` varchar(200) DEFAULT NULL,
  `doc_name` varchar(200) DEFAULT NULL,
  `doc_scribd_id` varchar(200) DEFAULT NULL,
  `doc_description` varchar(200) DEFAULT NULL,
  `doc_title` varchar(200) DEFAULT NULL,
  `doc_status` varchar(200) DEFAULT NULL,
  `doc_aturhor` int(11) DEFAULT NULL,
  `doc_type` int(2) DEFAULT NULL,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_doc_class`
--

CREATE TABLE IF NOT EXISTS `tbl_doc_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_doc_group`
--

CREATE TABLE IF NOT EXISTS `tbl_doc_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faculty`
--

CREATE TABLE IF NOT EXISTS `tbl_faculty` (
  `faculty_id` int(11) NOT NULL AUTO_INCREMENT,
  `faculty_university` int(11) DEFAULT NULL,
  `faculty_name` varchar(200) DEFAULT NULL,
  `faculty_code` varchar(200) DEFAULT NULL,
  `faculty_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`faculty_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_faculty`
--

INSERT INTO `tbl_faculty` (`faculty_id`, `faculty_university`, `faculty_name`, `faculty_code`, `faculty_active`) VALUES
(1, NULL, 'Công nghệ thông tin', NULL, 1),
(2, NULL, 'Điện tử viễn thông', NULL, 1),
(3, NULL, 'Vật lý kỹ thuật', NULL, 1),
(4, NULL, 'Cơ điện tử', NULL, 1),
(5, NULL, 'Cơ học kỹ thuật', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group`
--

CREATE TABLE IF NOT EXISTS `tbl_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_avatar` varchar(200) DEFAULT NULL,
  `group_cover` varchar(200) DEFAULT NULL,
  `group_description` varchar(200) DEFAULT NULL,
  `group_name` varchar(200) DEFAULT NULL,
  `group_active` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group_user`
--

CREATE TABLE IF NOT EXISTS `tbl_group_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lesson`
--

CREATE TABLE IF NOT EXISTS `tbl_lesson` (
  `lesson_id` int(10) NOT NULL,
  `lesson_active` int(10) DEFAULT NULL,
  `lesson_weeks` varchar(100) DEFAULT NULL,
  `lesson_subject` int(10) DEFAULT NULL,
  `lesson_name` varchar(300) DEFAULT NULL,
  `lesson_info` varchar(500) DEFAULT NULL,
  `lesson_doc` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`lesson_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news`
--

CREATE TABLE IF NOT EXISTS `tbl_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_university` int(11) DEFAULT NULL,
  `news_title` int(11) DEFAULT NULL,
  `news_content` varchar(1000) DEFAULT NULL,
  `news_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post`
--

CREATE TABLE IF NOT EXISTS `tbl_post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_author` int(11) DEFAULT NULL,
  `post_date` timestamp NULL DEFAULT NULL,
  `post_content` varchar(500) DEFAULT NULL,
  `post_title` varchar(200) DEFAULT NULL,
  `post_active` int(11) DEFAULT NULL,
  `post_rate` int(11) DEFAULT NULL,
  `post_type` varchar(45) DEFAULT NULL,
  `post_class` int(11) DEFAULT NULL,
  `post_group` int(11) DEFAULT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_post`
--

INSERT INTO `tbl_post` (`post_id`, `post_author`, `post_date`, `post_content`, `post_title`, `post_active`, `post_rate`, `post_type`, `post_class`, `post_group`) VALUES
(1, 5, '0000-00-00 00:00:00', 'nothing', NULL, 1, NULL, 'class_post', NULL, NULL),
(2, NULL, '0000-00-00 00:00:00', 'khoa', NULL, 1, NULL, 'class_post', 1, NULL),
(3, NULL, '0000-00-00 00:00:00', 'long', NULL, 1, NULL, 'class_post', 1, NULL),
(4, NULL, '0000-00-00 00:00:00', 'phong', NULL, 1, NULL, 'class_post', 1, NULL),
(5, NULL, '0000-00-00 00:00:00', 'llll', NULL, 1, NULL, 'class_post', 1, NULL),
(6, NULL, '0000-00-00 00:00:00', 'khoa', NULL, 1, NULL, 'class_post', 1, NULL),
(7, NULL, '0000-00-00 00:00:00', 'long', NULL, 1, NULL, 'class_post', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post_class`
--

CREATE TABLE IF NOT EXISTS `tbl_post_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post_group`
--

CREATE TABLE IF NOT EXISTS `tbl_post_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_program`
--

CREATE TABLE IF NOT EXISTS `tbl_program` (
  `program_id` int(2) NOT NULL AUTO_INCREMENT,
  `program_name` varchar(200) DEFAULT NULL,
  `program_credits` int(4) DEFAULT NULL,
  `program_year` int(4) DEFAULT NULL,
  `program_active` int(2) DEFAULT NULL,
  `program_code` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`program_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_program_subject`
--

CREATE TABLE IF NOT EXISTS `tbl_program_subject` (
  `id` int(19) NOT NULL AUTO_INCREMENT,
  `program_id` int(19) DEFAULT NULL,
  `subject_id` int(10) DEFAULT NULL,
  `is_active` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject`
--

CREATE TABLE IF NOT EXISTS `tbl_subject` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(45) DEFAULT NULL,
  `subject_code` varchar(45) DEFAULT NULL,
  `subject_active` varchar(45) DEFAULT NULL,
  `subject_university` varchar(45) DEFAULT NULL,
  `subject_type` int(3) DEFAULT NULL,
  `subject_year` int(3) DEFAULT NULL,
  `subject_credits` int(3) DEFAULT NULL,
  `subject_credit_hour` varchar(100) DEFAULT NULL,
  `subject_requirement` varchar(500) DEFAULT NULL,
  `subject_target` varchar(1000) DEFAULT NULL,
  `subject_info` varchar(1000) DEFAULT NULL,
  `subject_test` varchar(1000) DEFAULT NULL,
  `subject_faculty` int(12) DEFAULT NULL,
  `subject_dept` int(12) DEFAULT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject_doc`
--

CREATE TABLE IF NOT EXISTS `tbl_subject_doc` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `subject_id` int(5) DEFAULT NULL,
  `doc_id` int(5) DEFAULT NULL,
  `doc_type` int(2) DEFAULT NULL,
  `active` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject_faculty`
--

CREATE TABLE IF NOT EXISTS `tbl_subject_faculty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `university_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject_teacher`
--

CREATE TABLE IF NOT EXISTS `tbl_subject_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject_type`
--

CREATE TABLE IF NOT EXISTS `tbl_subject_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_type_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `is_active` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_subject_type`
--

INSERT INTO `tbl_subject_type` (`id`, `subject_type_name`, `is_active`) VALUES
(1, 'Ki?n th?c chung', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher`
--

CREATE TABLE IF NOT EXISTS `tbl_teacher` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_name` varchar(45) DEFAULT NULL,
  `teacher_personal_page` varchar(45) DEFAULT NULL,
  `teacher_avatar` varchar(45) DEFAULT NULL,
  `teacher_description` varchar(45) DEFAULT NULL,
  `teacher_work_place` int(11) DEFAULT NULL,
  `teacher_active` int(11) DEFAULT NULL,
  `teacher_status` int(11) DEFAULT NULL,
  `teacher_acadamic_title` varchar(45) DEFAULT NULL,
  `teacher_birthday` varchar(45) DEFAULT NULL,
  `teacher_sex` int(5) DEFAULT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_university`
--

CREATE TABLE IF NOT EXISTS `tbl_university` (
  `university_id` int(11) NOT NULL AUTO_INCREMENT,
  `university_name` varchar(200) DEFAULT NULL,
  `university_location` varchar(200) DEFAULT NULL,
  `university_code` varchar(200) DEFAULT NULL,
  `university_web` varchar(200) DEFAULT NULL,
  `university_description` varchar(200) DEFAULT NULL,
  `university_active` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`university_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_fb` varchar(200) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `user_real_name` varchar(45) DEFAULT NULL,
  `user_avatar` varchar(200) DEFAULT NULL,
  `user_cover` varchar(200) DEFAULT NULL,
  `user_student_code` varchar(45) DEFAULT NULL,
  `user_university` int(11) DEFAULT NULL,
  `user_gender` varchar(45) DEFAULT NULL,
  `user_dob` varchar(45) DEFAULT NULL,
  `user_hometown` varchar(200) DEFAULT NULL,
  `user_phone` varchar(45) DEFAULT NULL,
  `user_description` varchar(200) DEFAULT NULL,
  `user_faculty` int(11) DEFAULT NULL,
  `user_class` int(11) DEFAULT NULL,
  `user_active` int(11) DEFAULT NULL,
  `user_status` int(11) DEFAULT NULL,
  `user_group` int(11) DEFAULT NULL,
  `user_token` varchar(200) DEFAULT NULL,
  `user_activator` varchar(200) DEFAULT NULL,
  `user_qoutes` varchar(400) DEFAULT NULL,
  `user_date_attend` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_id_fb`, `username`, `password`, `user_real_name`, `user_avatar`, `user_cover`, `user_student_code`, `user_university`, `user_gender`, `user_dob`, `user_hometown`, `user_phone`, `user_description`, `user_faculty`, `user_class`, `user_active`, `user_status`, `user_group`, `user_token`, `user_activator`, `user_qoutes`, `user_date_attend`) VALUES
(5, NULL, 'huynt57@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'huy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, '3essbj9wfk6c4cc8og4cggc8c400ss8', '5101c56e813c995c9df3d5ba6ab5be06', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_university`
--

CREATE TABLE IF NOT EXISTS `tbl_user_university` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `university_id` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE IF NOT EXISTS `views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `created_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `vote_type` varchar(45) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `object_type` varchar(45) DEFAULT NULL,
  `created_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
