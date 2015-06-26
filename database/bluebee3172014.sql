-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2014 at 04:09 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `action`, `object_type`, `object_id`, `possessive`, `from_user_id`, `clicked`, `relevant_id`, `relevant_object`, `app`, `is_active`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  `dept_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `dept_active` int(2) DEFAULT NULL,
  `dept_faculty` int(2) DEFAULT NULL,
  `dept_target` text CHARACTER SET utf8,
  `dept_knowleadge` text CHARACTER SET utf8,
  `dept_behavior` text CHARACTER SET utf8,
  `dept_out_standard` text CHARACTER SET utf8,
  `dept_contact` text CHARACTER SET utf8,
  `dept_in_standart` text CHARACTER SET utf8,
  `dept_language` text CHARACTER SET utf8,
  `dept_credits` int(5) DEFAULT NULL,
  `dept_code` varchar(255) DEFAULT NULL,
  `dept_link_download` varchar(500) DEFAULT NULL,
  `dept_skill` text CHARACTER SET utf8,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_dept`
--

INSERT INTO `tbl_dept` (`dept_id`, `dept_name`, `dept_active`, `dept_faculty`, `dept_target`, `dept_knowleadge`, `dept_behavior`, `dept_out_standard`, `dept_contact`, `dept_in_standart`, `dept_language`, `dept_credits`, `dept_code`, `dept_link_download`, `dept_skill`) VALUES
(1, 'Khoa học máy tính', 1, 1, 'Chương trình đào tạo Khoa học máy tính của khoa Công nghệ thông tin, Trường Đại học Công nghệ, Đại học Quốc gia Hà Nội nhằm tạo ra nguồn nhân lực chất lượng cao trong lĩnh vực Khoa học máy tính, có khả năng nghiên cứu và làm việc trong các tập đoàn lớn về Công nghệ thông tin ở Việt Nam cũng như các nước trong khu vực.', 'Sinh viên tốt nghiệp được trang bị kiến thức có hệ thống và hiện đại, phù hợp với các chương trình đào tạo tiên tiến trên thế giới.  <br/>\r\n                                                •	Kiến thức tổng hợp về toán, khoa học tự nhiên, khoa học xã hội và nhân văn, ngoại ngữ. <br/>\r\n                                                •	Kiến thức nền tảng trong KHMT như cơ sở toán trong KHMT, lập trình, cấu trúc dữ liệu và giải thuật, lý thuyết thông tin, chương trình dịch, trí tuệ nhân tạo. Đối với kiến thức sâu về ngành, tập trung đào chuyên sâu theo định hướng “Các hệ thống thông minh” và “Tương tác người máy” như xử lý ngôn ngữ tự nhiên, học máy, nhận dạng mẫu, tin sinh, xử lý tiếng nói, xử lý ảnh, tương tác người máy tính, lập trình trò chơi.<br/>\r\n                                                •	Kiến thức tổng quan khác trong CNTT như công nghệ phần mềm, cơ sở dữ liệu, mạng máy tính, kiến trúc máy tính thông qua tỉ lệ môn học lựa chọn cao cùng với số lượng các môn học lựa chọn phong phú.<br/>\r\n                                                •	Sinh viên được chú trọng đào tạo về kỹ năng lập trình với các ngôn ngữ, môi trường lập trình tiên tiến, tỉ trọng thực hành cao và nhiều bài tập ứng dụng thực tế. <br/>\r\n                                                •	Sinh viên được đào tạo tăng cường tiếng Anh để có khả năng tự cập nhật kiến thức và làm việc trong môi trường CNTT trên thế giới. <br/>\r\n                                            </p>', '   •	Phẩm chất chính trị tốt <br/>\r\n                                                •	Ý thức tổ chức kỷ luật, có tác phong làm việc khoa học, nghiêm túc, có đạo đức nghề nghiệp về bảo vệ thông tin, bản quyền.<br/>\r\n                                                •	Tinh thần làm việc theo nhóm, rèn luyện thường xuyên tính kỷ luật và khả năng giao tiếp.<br/>', ' -	Giảng viên về nhóm ngành Máy tính và Công nghệ Thông tin<br/>\r\n                            -	Chuyên gia nghiên cứu và phát triển về Công nghệ Thông tin <br/>\r\n                            -	Trưởng nhóm phát triển phần mềm<br/>\r\n                            -	Chuyên viên phát triển ứng dụng web/trò chơi/di động/các hệ thống nhúng<br/>\r\n                            -	Trưởng nhóm phát triển<br/>\r\n                            -	Quản lý dự án<br/>\r\n                            -	Lập trình viên<br/>\r\n                            Bên cạnh đó, với thế mạnh về ngoại ngữ và chuyên môn, sinh viên tốt nghiệp cũng có thể học lên các bậc cao hơn như thạc sỹ, tiến sĩ, sau khi ra trường.<br/>', '  Nếu bạn có thắc mắc về ngành Khoa học máy tính , hãy liên hệ :<br/>\r\n\r\n                            <strong>Đại học Công Nghệ - Đại học Quốc Gia Hà Nội</strong><br/>\r\n                            Khoa học máy tính <br/>\r\n                            Số 2, Xuân Thủy, Cầu Giấy, Hà Nội<br/>\r\n                            Điện thoại :<br/>\r\n                            Fax : <br/>\r\n                            Email : <a>kienduynguyen94@gmail.com</a><br/>\r\n                            Web : <a>uet.vnu.edu.vn</a><br/>', 'Làm bài kiểm tra đầu vào bằng tiếng anh', 'Tiếng Anh', 140, '52480101', NULL, '<p>\r\n                                                •	Tư duy logic tốt, có năng lực sáng tạo để giải quyết các bài toán ứng dụng cụ thể. có năng lực tự học để nắm bắt các công nghệ, công cụ, kỹ năng mới trong phát triển phần mềm. <br/>\r\n                                                •	Năng lực làm việc với vị trí lập trình viên trình độ cao cho các công ty phát triển phần mềm và hệ thống của các công ty trong và ngoài nước. Đặc biệt thích hợp cho các vị trí trong các lĩnh vực đòi hỏi công nghệ hiện đại và sáng tạo như phát triển các hệ thống thông minh, tương tác người máy. <br/>\r\n                                                •	Khả năng làm việc ở nhiều vị trí khác nhau trong các cơ quan tổ chức phát triển và ứng dụng CNTT hàng đầu trong nước.   <br/>\r\n                                                •	Sinh viên được trang bị kiến thức nền tảng và một số chuyên đề chuyên sâu trong KHMT, vì vậy có nhiều thuận lợi trong việc học lên thạc sĩ và tiến sĩ ngành KHMT và trở thành nhà nghiên cứu, giảng viên các trường đại học. <br/>\r\n                                            </p>'),
(2, 'Công nghệ thông tin', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  `doc_author` int(11) DEFAULT NULL,
  `doc_type` int(2) DEFAULT NULL,
  `doc_path` varchar(500) DEFAULT NULL,
  `subject_dept` int(3) DEFAULT NULL,
  `subject_type` int(3) DEFAULT NULL,
  `subject_faculty` int(3) DEFAULT NULL,
  `doc_author_name` text,
  `doc_publisher` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tbl_doc`
--

INSERT INTO `tbl_doc` (`doc_id`, `doc_url`, `doc_name`, `doc_scribd_id`, `doc_description`, `doc_title`, `doc_status`, `doc_author`, `doc_type`, `doc_path`, `subject_dept`, `subject_type`, `subject_faculty`, `doc_author_name`, `doc_publisher`) VALUES
(1, 'E:\\xampp\\htdocs\\BlueBee.com\\protected/uploads/medium-0f9fd36fd5784e56b8612ec5db552112-650.jpg', '', NULL, '', NULL, '1', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'E:\\xampp\\htdocs\\BlueBee.com\\protected/uploads/Gmail.zip', '', NULL, '', NULL, '1', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'E:\\xampp\\htdocs\\BlueBee.com\\protected/uploads/Gmail.zip', 'huy', NULL, 'huy', NULL, '1', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'E:\\xampp\\htdocs\\BlueBee.com\\protected/uploads/speed.png', 'huy', NULL, 'huy', NULL, '1', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'http://imgv2-1.scribdassets.com/img/word_document/234960278/180x220/607646de8f/1406202392', 'huy', '234960278', 'huy', NULL, '1', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'http://imgv2-3.scribdassets.com/img/word_document/234960355/180x220/71b5a37f8f/1406202495', 'huy', '234960355', 'huy', NULL, '1', NULL, 1, NULL, 1, 1, 1, NULL, NULL),
(8, 'http://imgv2-1.scribdassets.com/img/word_document/235028990/180x220/9095bf4556/1406254764', '', '235028990', '', NULL, '1', NULL, 2, NULL, 1, 1, 1, NULL, NULL),
(9, 'http://imgv2-4.scribdassets.com/img/word_document/235029641/180x220/090149283e/1406255207', '', '235029641', '', NULL, '1', NULL, 2, NULL, 1, 1, 1, NULL, NULL),
(11, 'http://imgv2-3.scribdassets.com/img/word_document/235196884/180x220/a87d68cbb0/1406457973', '', '235196884', '', NULL, '1', NULL, 2, NULL, 1, 1, 1, NULL, NULL),
(12, 'http://imgv2-4.scribdassets.com/img/word_document/235199258/180x220/c8cf5eb218/1406461209', '', '235199258', '', NULL, '1', NULL, 2, NULL, 1, 1, 1, NULL, NULL),
(13, 'http://imgv2-1.scribdassets.com/img/word_document/235199304/180x220/da2815dfb9/1406461308', '', '235199304', '', NULL, '1', NULL, 2, NULL, 1, 1, 1, NULL, NULL),
(14, 'http://imgv2-4.scribdassets.com/img/word_document/235199463/180x220/c8d237934b/1406461575', '', '235199463', '', NULL, '1', NULL, 2, NULL, 1, 1, 1, NULL, NULL),
(15, 'http://imgv2-3.scribdassets.com/img/word_document/235199491/180x220/1f5d3f2ac7/1406461606', '', '235199491', '', NULL, '1', NULL, 2, NULL, 1, 1, 1, NULL, NULL),
(16, 'http://imgv2-2.scribdassets.com/img/word_document/235199565/180x220/d9afe6dd08/1406461747', '', '235199565', '', NULL, '1', NULL, 2, NULL, 1, 1, 1, NULL, NULL),
(17, 'E:/xampp/htdocs/BlueBee.com/uploads/1518722_373602562783177_148904274_o.jpg', '', NULL, '', NULL, '1', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'http://imgv2-3.scribdassets.com/img/word_document/235365673/180x220/fc86a7feb4/1406640974', 'Test', '235365673', 'Test', NULL, '1', NULL, 2, NULL, 1, 1, 1, NULL, NULL),
(19, 'http://imgv2-2.scribdassets.com/img/word_document/235455991/180x220/4769eefffc/1406732662', '', '235455991', '', NULL, '1', NULL, 2, 'E:/xampp/htdocs/BlueBee.com/uploads/bai tap dai so.docx', NULL, NULL, NULL, NULL, NULL);

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
  `faculty_research` text,
  `faculty_lab` text,
  PRIMARY KEY (`faculty_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_faculty`
--

INSERT INTO `tbl_faculty` (`faculty_id`, `faculty_university`, `faculty_name`, `faculty_code`, `faculty_active`, `faculty_research`, `faculty_lab`) VALUES
(1, NULL, 'Công nghệ thông tin', NULL, 1, NULL, NULL),
(2, NULL, 'Điện tử viễn thông', NULL, 1, NULL, NULL),
(3, NULL, 'Vật lý kỹ thuật', NULL, 1, NULL, NULL),
(4, NULL, 'Cơ điện tử', NULL, 1, NULL, NULL),
(5, NULL, 'Cơ học kỹ thuật', NULL, 1, NULL, NULL);

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
  `subject_content` text,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_subject`
--

INSERT INTO `tbl_subject` (`subject_id`, `subject_name`, `subject_code`, `subject_active`, `subject_university`, `subject_type`, `subject_year`, `subject_credits`, `subject_credit_hour`, `subject_requirement`, `subject_target`, `subject_info`, `subject_test`, `subject_faculty`, `subject_dept`, `subject_content`) VALUES
(1, 'Đại số tuyến tính', 'INT1006', '1', NULL, 1, NULL, 3, '20 - 23 - 2', NULL, 'Trang bị cho sinh viên những khái niệm và kỹ năng cơ bản nhất của Đại số tuyến tính một trong những môn cơ sở của Toán học, tạo điều kiện để học tập, nghiên cứu các môn học khác.\r\n                                Giúp sinh viên hiểu được các kiến thức cơ bản của Đại số tuyến tính, liên hệ với những kiến thức đã học ở bậc phổ thông, biết cách tự hệ thống hoá kiến thức, tìm tòi mở rộng thêm các kiến thức cơ bản để phục vụ công tác sau này.', NULL, NULL, 1, 1, 'Đại số tuyến tính là một trong những môn học đầu tiên của Toán học trừu tượng, sinh viên cần nắm vững các khái niệm, hình dung chính xác các khái niệm đó trong những tình huống cụ thể, biết vận dụng các kết quả mới. Phần đầu chương trình ôn tập lại các khái niệm về tập hợp và ánh xạ, sau đó giới thiệu một số cấu trúc đại số như nhóm, vành, trường. Một thời lượng đáng kể dành cho việc giới thiệu trường số phức, các tính chất của số phức, đa thức và phân thức hữu tỉ thực. Chương III là lý thuyết về ma trận, định thức và hệ phương trình tuyến tính. Ở chương này sinh viên sẽ được ôn lại cách giải hệ phương trình tuyến tính đã học từ chương trình phổ thông. Tuy vậy toàn bộ lý thuyết sẽ được trình bày một cách có hệ thống và ở một ngôn ngữ tổng quát. Chương IV gồm những vấn đề cơ bản của không gian véc tơ, không gian Euclid. Đây có thể coi như những tổng quát hóa lên trường hợp nhiều chiều của các khái niệm mặt phẳng toạ độ, hệ toạ độ trong không gian mà sinh viên đã nắm vững từ bậc phổ thông. Chương V khảo sát một số tính chất quan trọng của ánh xạ tuyến tính, toán tử tuyến tính trong không gian véc tơ hữu hạn chiều, phép biến đổi trực giao, dạng song tuyến tính, dạng toàn phương toán tử tự liên hợp (hay phép biến đổi đối xứng). Chương VI dành cho áp dụng lí thuyết không gian véc tơ Euclid, dạng toàn phương vào việc khảo sát một số vấn đề của hình học giải tích như phân loại các đường bậc hai, mặt bậc hai.'),
(2, 'Tiếng Anh A1', NULL, '1', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tbl_subject_doc`
--

INSERT INTO `tbl_subject_doc` (`id`, `subject_id`, `doc_id`, `doc_type`, `active`) VALUES
(1, 0, 1, 1, 1),
(2, 0, 2, 1, 1),
(3, 0, 3, 1, 1),
(4, 0, 4, 1, 1),
(5, 0, 5, 1, 1),
(6, 0, 6, 1, 1),
(7, 0, 7, 2, 1),
(8, 0, 8, 2, 1),
(9, 1, 9, 2, 1),
(10, NULL, 10, 3, 1),
(11, 1, 11, 2, 1),
(12, 1, 12, 2, 1),
(13, 0, 13, 2, 1),
(14, 1, 14, 2, 1),
(15, 1, 15, 2, 1),
(16, 0, 16, 2, 1),
(17, 0, 17, 1, 1),
(18, 0, 18, 2, 1),
(19, 0, 19, 2, 1);

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
-- Table structure for table `tbl_subject_group`
--

CREATE TABLE IF NOT EXISTS `tbl_subject_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_type_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `subject_group_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `subject_group_info` varchar(10000) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject_group_type`
--

CREATE TABLE IF NOT EXISTS `tbl_subject_group_type` (
  `subject_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_group_type` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `active` int(2) DEFAULT NULL,
  `detail` text CHARACTER SET utf8,
  `subject_group` int(2) DEFAULT NULL,
  `subject_dept` int(2) DEFAULT NULL,
  `subject_faculty` int(2) DEFAULT NULL,
  PRIMARY KEY (`subject_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_subject_group_type`
--

INSERT INTO `tbl_subject_group_type` (`subject_type_id`, `subject_group_type`, `active`, `detail`, `subject_group`, `subject_dept`, `subject_faculty`) VALUES
(1, 'Lý luận chính trị', 1, ' <p>\r\n                                        -	Hiểu được hệ thống tri thức khoa học những nguyên lý cơ bản của Chủ nghĩa Mác Lênin; <br/>\r\n                                        -	Hiểu được hệ thống tri thức khoa học những nguyên lý cơ bản của Chủ nghĩa Mác Lênin; <br/>\r\n                                        -	Hiểu được những kiến thức cơ bản, có tính hệ thống về tư tưởng, đạo đức, giá trị văn hóa Hồ Chí Minh, những nội dung cơ bản của Đường lối cách mạng của Đảng Cộng sản Việt Nam, chủ yếu là đường lối trong thời kỳ đổi mới trên một số lĩnh vực cơ bản của đời sống xã hội.<br/>\r\n\r\n                                   </p>', 1, 1, 1),
(2, 'Tin học', 1, '<p>\r\n                                        -	Nhớ và giải thích được các kiến thức cơ bản về thông tin;<br/>\r\n                                        -	Sử dụng được công cụ xử lý thông tin thông dụng (hệ điều hành, các phần mềm hỗ trợ công tác văn phòng và khai thác Internet ...);<br/>\r\n                                        -	Có khả năng phân tích, đánh giá và lập trình một ngôn ngữ lập trình bậc cao (hiểu các cấu trúc điều khiển, các kiểu dữ liệu có cấu trúc, hàm/chương trình con, biến cục bộ/biến toàn cục, vào ra dữ liệu tệp, các bước để xây dựng chương trình hoàn chỉnh);<br/>\r\n                                        -	Có khả năng phân tích, đánh giá phương pháp lập trình hướng thủ tục và lập trình hướng đối tượng; phân biệt được ưu và nhược điểm của hai phương pháp lập trình.<br/>\r\n\r\n                                    </p>', 1, 1, 1),
(3, 'Ngoại ngữ', 1, '<p>\r\n                                            -	Có thể hiểu được nhiều kiểu văn bản dài, khó và nắm bắt được ngụ ý.<br/>\r\n                                            -	Có thể diễn đạt ý mình một cách trôi chảy, tức thì mà không phải quá vất vả tìm từ.<br/>\r\n                                            -	Có thể sử dụng ngôn ngữ một cách linh hoạt, hiệu quả cho các mục đích xã hội, học tập và chuyên môn.<br/>\r\n                                            -	Có thể tạo ra các văn bản có cấu trúc tốt, rõ ràng, cụ thể về các đề tài phức tạp, cho thấy khả năng kiểm soát tốt các hình thức sắp xếp ý, các liên từ và phương tiện liên kết.<br/>\r\n\r\n                                        </p>', 1, 1, 1),
(4, 'GD thể chất & QPAN', 1, '<p>\r\n                                            -	Hiểu và vận dụng những kiến thức khoa học cơ bản trong lĩnh vực thể dục thể thao vào quá trình tập luyện và tự rèn luyện, ngăn ngừa các chấn thương để củng cố và tăng cường sức khỏe. Sử dụng các bài tập phát triển thể lực chung và thể lực chuyên môn đặc thù. Vận dụng những kỹ, chiến thuật cơ bản, luật thi đấu vào các hoạt động thể thao ngoại khóa cộng đồng;<br/>\r\n                                            -	Hiểu được nội dung cơ bản về đường lối quân sự và nhiệm vụ công tác quốc phòng – an ninh của Đảng, Nhà nước trong tình hình mới. Vận dụng kiến thức đã học vào chiến đấu trong điều kiện tác chiến thông thường.<br/>\r\n                                        </p>', 1, 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_subject_teacher`
--

INSERT INTO `tbl_subject_teacher` (`id`, `subject_id`, `teacher_id`, `is_active`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject_type`
--

CREATE TABLE IF NOT EXISTS `tbl_subject_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_type_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `is_active` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_subject_type`
--

INSERT INTO `tbl_subject_type` (`id`, `subject_type_name`, `is_active`) VALUES
(1, 'Khối kiến thức chung', 1),
(2, 'Khối kiến thức chung theo lĩnh vực', 1),
(3, 'Khối kiến thức chung cho khối ngành', 1),
(4, 'Khối kiến thức chung cho nhóm ngành', 1),
(5, 'Khối kiến thức ngành và bổ trợ', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_teacher`
--

INSERT INTO `tbl_teacher` (`teacher_id`, `teacher_name`, `teacher_personal_page`, `teacher_avatar`, `teacher_description`, `teacher_work_place`, `teacher_active`, `teacher_status`, `teacher_acadamic_title`, `teacher_birthday`, `teacher_sex`) VALUES
(1, 'Nguyễn Thế Huy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher_faculty_position`
--

CREATE TABLE IF NOT EXISTS `tbl_teacher_faculty_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) DEFAULT NULL,
  `teacher_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `teacher_position` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_teacher_faculty_position`
--

INSERT INTO `tbl_teacher_faculty_position` (`id`, `teacher_id`, `teacher_name`, `faculty_id`, `teacher_position`) VALUES
(1, 1, NULL, 1, NULL);

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
