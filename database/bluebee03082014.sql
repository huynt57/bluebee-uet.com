-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2014 at 06:37 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_dept`
--

INSERT INTO `tbl_dept` (`dept_id`, `dept_name`, `dept_active`, `dept_faculty`, `dept_target`, `dept_knowleadge`, `dept_behavior`, `dept_out_standard`, `dept_contact`, `dept_in_standart`, `dept_language`, `dept_credits`, `dept_code`, `dept_link_download`, `dept_skill`) VALUES
(1, 'Khoa học máy tính', 1, 1, 'Chương trình đào tạo Khoa học máy tính của khoa Công nghệ thông tin, Trường Đại học Công nghệ, Đại học Quốc gia Hà Nội nhằm tạo ra nguồn nhân lực chất lượng cao trong lĩnh vực Khoa học máy tính, có khả năng nghiên cứu và làm việc trong các tập đoàn lớn về Công nghệ thông tin ở Việt Nam cũng như các nước trong khu vực.', 'Sinh viên tốt nghiệp được trang bị kiến thức có hệ thống và hiện đại, phù hợp với các chương trình đào tạo tiên tiến trên thế giới.  <br/>\r\n                                                •	Kiến thức tổng hợp về toán, khoa học tự nhiên, khoa học xã hội và nhân văn, ngoại ngữ. <br/>\r\n                                                •	Kiến thức nền tảng trong KHMT như cơ sở toán trong KHMT, lập trình, cấu trúc dữ liệu và giải thuật, lý thuyết thông tin, chương trình dịch, trí tuệ nhân tạo. Đối với kiến thức sâu về ngành, tập trung đào chuyên sâu theo định hướng “Các hệ thống thông minh” và “Tương tác người máy” như xử lý ngôn ngữ tự nhiên, học máy, nhận dạng mẫu, tin sinh, xử lý tiếng nói, xử lý ảnh, tương tác người máy tính, lập trình trò chơi.<br/>\r\n                                                •	Kiến thức tổng quan khác trong CNTT như công nghệ phần mềm, cơ sở dữ liệu, mạng máy tính, kiến trúc máy tính thông qua tỉ lệ môn học lựa chọn cao cùng với số lượng các môn học lựa chọn phong phú.<br/>\r\n                                                •	Sinh viên được chú trọng đào tạo về kỹ năng lập trình với các ngôn ngữ, môi trường lập trình tiên tiến, tỉ trọng thực hành cao và nhiều bài tập ứng dụng thực tế. <br/>\r\n                                                •	Sinh viên được đào tạo tăng cường tiếng Anh để có khả năng tự cập nhật kiến thức và làm việc trong môi trường CNTT trên thế giới. <br/>\r\n                                            </p>', '   •	Phẩm chất chính trị tốt <br/>\r\n                                                •	Ý thức tổ chức kỷ luật, có tác phong làm việc khoa học, nghiêm túc, có đạo đức nghề nghiệp về bảo vệ thông tin, bản quyền.<br/>\r\n                                                •	Tinh thần làm việc theo nhóm, rèn luyện thường xuyên tính kỷ luật và khả năng giao tiếp.<br/>', '<ul>\r\n	<li>\r\n	<p>C&aacute;c vị tr&iacute; c&ocirc;ng t&aacute;c c&oacute; thể đảm nhận:</p>\r\n	</li>\r\n	<li>- Giảng vi&ecirc;n về nh&oacute;m ng&agrave;nh M&aacute;y t&iacute;nh v&agrave; C&ocirc;ng nghệ Th&ocirc;ng tin</li>\r\n	<li>- Chuy&ecirc;n gia nghi&ecirc;n cứu v&agrave; ph&aacute;t triển về C&ocirc;ng nghệ Th&ocirc;ng tin</li>\r\n	<li>- Trưởng nh&oacute;m ph&aacute;t triển phần mềm</li>\r\n	<li>- Chuy&ecirc;n vi&ecirc;n ph&aacute;t triển ứng dụng web/tr&ograve; chơi/di động/c&aacute;c hệ thống nh&uacute;ng</li>\r\n	<li>- Trưởng nh&oacute;m ph&aacute;t triển</li>\r\n	<li>- Quản l&yacute; dự &aacute;n</li>\r\n	<li>- Lập tr&igrave;nh vi&ecirc;n</li>\r\n</ul>\r\n\r\n<p>B&ecirc;n cạnh đ&oacute;, với thế mạnh về ngoại ngữ v&agrave; chuy&ecirc;n m&ocirc;n, sinh vi&ecirc;n tốt nghiệp cũng c&oacute; thể học l&ecirc;n c&aacute;c bậc cao hơn như thạc sỹ, tiến sĩ, sau khi ra trường.</p>', '  Nếu bạn có thắc mắc về ngành Khoa học máy tính , hãy liên hệ :<br/>\r\n\r\n                            <strong>Đại học Công Nghệ - Đại học Quốc Gia Hà Nội</strong><br/>\r\n                            Khoa học máy tính <br/>\r\n                            Số 2, Xuân Thủy, Cầu Giấy, Hà Nội<br/>\r\n                            Điện thoại :<br/>\r\n                            Fax : <br/>\r\n                            Email : <a>kienduynguyen94@gmail.com</a><br/>\r\n                            Web : <a>uet.vnu.edu.vn</a><br/>', 'Làm bài kiểm tra đầu vào bằng tiếng anh', 'Tiếng Anh', 140, '52480101', NULL, '<p>\r\n                                                •	Tư duy logic tốt, có năng lực sáng tạo để giải quyết các bài toán ứng dụng cụ thể. có năng lực tự học để nắm bắt các công nghệ, công cụ, kỹ năng mới trong phát triển phần mềm. <br/>\r\n                                                •	Năng lực làm việc với vị trí lập trình viên trình độ cao cho các công ty phát triển phần mềm và hệ thống của các công ty trong và ngoài nước. Đặc biệt thích hợp cho các vị trí trong các lĩnh vực đòi hỏi công nghệ hiện đại và sáng tạo như phát triển các hệ thống thông minh, tương tác người máy. <br/>\r\n                                                •	Khả năng làm việc ở nhiều vị trí khác nhau trong các cơ quan tổ chức phát triển và ứng dụng CNTT hàng đầu trong nước.   <br/>\r\n                                                •	Sinh viên được trang bị kiến thức nền tảng và một số chuyên đề chuyên sâu trong KHMT, vì vậy có nhiều thuận lợi trong việc học lên thạc sĩ và tiến sĩ ngành KHMT và trở thành nhà nghiên cứu, giảng viên các trường đại học. <br/>\r\n                                            </p>'),
(2, 'Công nghệ thông tin', 1, 1, NULL, 'Sinh viên tốt nghiệp ngành Công nghệ thông tin được trang bị các kiến thức cơ bản và chuyên sâu về Công nghệ thông tin, cũng như được định hướng một số vấn đề hiện đại tiệm cận với kiến thức chung về Công nghệ thông tin của thế giới. ', '<ul>\r\n	<li>\r\n	<p>- Sinh vi&ecirc;n tốt nghiệp ng&agrave;nh C&ocirc;ng nghệ Th&ocirc;ng tin chất lượng cao c&oacute; phẩm chất ch&iacute;nh trị tốt, c&oacute; &yacute; thức tổ chức kỷ luật, c&oacute; t&aacute;c phong l&agrave;m việc khoa học, nghi&ecirc;m t&uacute;c, c&oacute; đạo đức nghề nghiệp về bảo vệ th&ocirc;ng tin, bản quyền, c&oacute; tinh thần l&agrave;m việc theo nh&oacute;m, r&egrave;n luyện thường xuy&ecirc;n t&iacute;nh kỷ luật v&agrave; khả năng giao tiếp. Lu&ocirc;n c&oacute; &yacute; thức học hỏi vươn l&ecirc;n, kh&ocirc;ng ngừng trau dồi năng lực để ho&agrave; nhập với tr&igrave;nh độ chung về c&ocirc;ng nghệ th&ocirc;ng tin của khu vực v&agrave; thế giới.</p>\r\n\r\n	<p><em>Ngo&agrave;i c&aacute;c mục ti&ecirc;u chung, sinh vi&ecirc;n được đ&agrave;o tạo với c&aacute;c mục ti&ecirc;u bổ sung cho mỗi định hướng:</em></p>\r\n\r\n	<p><em>a. Định hướng C&ocirc;ng nghệ phần mềm</em></p>\r\n\r\n	<p>- Nắm vững kiến thức cơ bản v&agrave; chuy&ecirc;n s&acirc;u về C&ocirc;ng nghệ phần mềm: quy tr&igrave;nh x&acirc;y dựng, quản l&yacute; v&agrave; bảo tr&igrave; hệ thống phần mềm; ph&acirc;n t&iacute;ch, thiết kế v&agrave; quản l&yacute; c&aacute;c dự &aacute;n phần mềm. Tổ chức thực hiện v&agrave; quản l&yacute; được c&aacute;c c&ocirc;ng việc trong lĩnh vực c&ocirc;ng nghệ phần mềm, c&oacute; khả năng x&acirc;y dựng m&ocirc; h&igrave;nh v&agrave; &aacute;p dụng c&aacute;c nguy&ecirc;n tắc của c&ocirc;ng nghệ phần mềm v&agrave;o thực tế. C&oacute; khả năng nghi&ecirc;n cứu, đề xuất c&aacute;c hướng ph&aacute;t triển cho c&ocirc;ng nghệ phần mềm.</p>\r\n\r\n	<p><em>b. Định hướng Hệ thống th&ocirc;ng tin</em></p>\r\n\r\n	<p>- Nắm vững kiến thức cơ bản v&agrave; chuy&ecirc;n s&acirc;u về Hệ thống th&ocirc;ng tin, đ&aacute;p ứng c&aacute;c y&ecirc;u cầu về nghi&ecirc;n cứu ph&aacute;t triển v&agrave; ứng dụng c&ocirc;ng nghệ th&ocirc;ng tin của x&atilde; hội. Tham mưu, tư vấn v&agrave; x&acirc;y dựng được c&aacute;c hệ thống th&ocirc;ng tin cấp cao cho việc quản l&yacute; kinh tế, h&agrave;nh ch&iacute;nh v&agrave; dịch vụ.</p>\r\n\r\n	<p><em>c. Định hướng Mạng v&agrave; truyền th&ocirc;ng m&aacute;y t&iacute;nh</em></p>\r\n\r\n	<p>- Nắm vững kiến thức cơ bản v&agrave; chuy&ecirc;n s&acirc;u về Mạng v&agrave; truyền th&ocirc;ng m&aacute;y t&iacute;nh, đ&aacute;p ứng y&ecirc;u cầu về nghi&ecirc;n cứu, ứng dụng trong lĩnh vực mạng v&agrave; truyền th&ocirc;ng m&aacute;y t&iacute;nh. C&oacute; khả năng thiết kế, chế tạo, bảo tr&igrave;, sản xuất, thử nghiệm, quản l&yacute; c&aacute;c hệ thống mạng v&agrave; truyền th&ocirc;ng m&aacute;y t&iacute;nh. C&oacute; khả năng tiếp tục nghi&ecirc;n cứu v&agrave; ph&aacute;t triển c&ocirc;ng nghệ trong lĩnh vực mạng v&agrave; truyền th&ocirc;ng m&aacute;y t&iacute;nh.</p>\r\n\r\n	<p><em>d. Định hướng Khoa học dịch vụ</em></p>\r\n\r\n	<p>- Nắm vững kiến thức cơ bản v&agrave; chuy&ecirc;n s&acirc;u về Dịch vụ C&ocirc;ng nghệ th&ocirc;ng tin, đ&aacute;p ứng c&aacute;c vấn đề về ph&acirc;n t&iacute;ch, x&acirc;y dựng giải ph&aacute;p nền tảng cho c&aacute;c dịch vụ C&ocirc;ng nghệ th&ocirc;ng tin v&agrave; dịch vụ dựa tr&ecirc;n C&ocirc;ng nghệ th&ocirc;ng tin trong thực tế. Tổ chức thực hiện v&agrave; quản l&yacute; được c&aacute;c c&ocirc;ng việc trong lĩnh vực Dịch vụ C&ocirc;ng nghệ th&ocirc;ng tin, c&oacute; khả năng x&acirc;y dựng m&ocirc; h&igrave;nh v&agrave; &aacute;p dụng c&aacute;c nguy&ecirc;n tắc của Dịch vụ C&ocirc;ng nghệ th&ocirc;ng tin v&agrave;o thực tế. C&oacute; khả năng tiếp tục nghi&ecirc;n cứu v&agrave; ph&aacute;t triển c&aacute;c m&ocirc; h&igrave;nh li&ecirc;n quan đến dịch vụ C&ocirc;ng nghệ th&ocirc;ng tin.</p>\r\n	</li>\r\n</ul>\r\n', '<ul>\r\n	<li>\r\n	<p>Sinh vi&ecirc;n tốt nghiệp ng&agrave;nh C&ocirc;ng nghệ th&ocirc;ng tin c&oacute; khả năng tham mưu tư vấn v&agrave; c&oacute; khả năng thực hiện nhiệm vụ với tư c&aacute;ch như một chuy&ecirc;n vi&ecirc;n trong lĩnh vực C&ocirc;ng nghệ th&ocirc;ng tin, đ&aacute;p ứng c&aacute;c y&ecirc;u cầu về nghi&ecirc;n cứu v&agrave; ứng dụng C&ocirc;ng nghệ th&ocirc;ng tin của x&atilde; hội. Ngo&agrave;i ra, sinh vi&ecirc;n tốt nghiệp ra trường c&oacute; thể tiếp tục học tập, nghi&ecirc;n cứu v&agrave; ph&aacute;t triển ng&agrave;nh C&ocirc;ng nghệ th&ocirc;ng tin trong tương lai.</p>\r\n\r\n	<p>C&aacute;c vị tr&iacute; c&ocirc;ng t&aacute;c c&oacute; thể đảm nhận:</p>\r\n	</li>\r\n	<li>- Lập tr&igrave;nh vi&ecirc;n</li>\r\n	<li>- Trưởng nh&oacute;m ph&aacute;t triển phần mềm</li>\r\n	<li>- Quản l&yacute; dự &aacute;n phần mềm</li>\r\n	<li>- Chuy&ecirc;n gia nghi&ecirc;n cứu v&agrave; ph&aacute;t triển về M&aacute;y t&iacute;nh v&agrave; C&ocirc;ng nghệ th&ocirc;ng tin</li>\r\n	<li>- Quản trị mạng</li>\r\n	<li>- Chuy&ecirc;n vi&ecirc;n thiết kế v&agrave; xử l&yacute; nội dung số</li>\r\n	<li>- Chuy&ecirc;n vi&ecirc;n tư vấn dịch vụ c&ocirc;ng nghệ th&ocirc;ng tin</li>\r\n	<li>- Chuy&ecirc;n vi&ecirc;n kiểm thử phần mềm</li>\r\n	<li>- Chuy&ecirc;n gia về an ninh hệ thống</li>\r\n	<li>- Giảng vi&ecirc;n, nghi&ecirc;n cứu vi&ecirc;n về nh&oacute;m ng&agrave;nh M&aacute;y t&iacute;nh v&agrave; C&ocirc;ng nghệ th&ocirc;ng tin</li>\r\n</ul>\r\n\r\n<p>B&ecirc;n cạnh đ&oacute; sinh vi&ecirc;n đ&atilde; tốt nghiệp cũng c&oacute; thể học l&ecirc;n c&aacute;c bậc cao hơn như thạc sỹ, tiến sĩ, sau khi ra trường.</p>\r\n\r\n<p>&nbsp;</p>', '<ul>\r\n	<li>\r\n	<p>Nếu bạn c&oacute; thắc mắc về ng&agrave;nh C&ocirc;ng nghệ th&ocirc;ng tin&nbsp;, h&atilde;y li&ecirc;n hệ :<br />\r\n	<strong>Trường&nbsp;Đại học C&ocirc;ng Nghệ - Đại học Quốc Gia H&agrave; Nội</strong><br />\r\n	<strong>Địa chỉ:&nbsp;</strong>Nh&agrave; G2 - Số 144 đường Xu&acirc;n Thủy, Cầu Giấy, H&agrave; Nội<br />\r\n	<strong>Điện thoại:</strong>&nbsp;04&nbsp;37547064<br />\r\n	<strong>Fax:</strong>&nbsp;<br />\r\n	<strong>Email:</strong><br />\r\n	<strong>Web</strong>&nbsp;:&nbsp;uet.vnu.edu.vn</p>\r\n	</li>\r\n</ul>', NULL, 'Tiếng Anh', 128, '52480201', NULL, '- Sinh viên tốt nghiệp ngành Công nghệ Thông tin chất lượng cao được đào tạo kỹ năng thực hành cao trong hầu hết các lĩnh vực của Công nghệ Thông tin. Nắm vững và thành thạo trong phân tích, thiết kế, xây dựng, cài đặt, bảo trì, phát triển và quản lý các hệ thống, chương trình, dự án. Sinh viên ngành Công nghệ Thông tin chất lượng cao còn được trang bị tốt kỹ năng làm việc theo nhóm và kỹ năng giao tiếp, có khả năng sử dụng thành thạo ngoại ngữ phục vụ học tập, nghiên cứu, hoà nhập nhanh với cộng đồng công nghệ thông tin khu vực và quốc tế sau khi ra trường.');

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
  `doc_author` varchar(30) DEFAULT NULL,
  `doc_type` int(2) DEFAULT NULL,
  `doc_path` varchar(500) DEFAULT NULL,
  `subject_dept` int(3) DEFAULT NULL,
  `subject_type` int(3) DEFAULT NULL,
  `subject_faculty` int(3) DEFAULT NULL,
  `doc_author_name` text,
  `doc_publisher` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

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
(1, NULL, 'Công nghệ thông tin', NULL, 1, '<ul>\r\n	<li>- &nbsp; &nbsp;Lĩnh vực&nbsp;M&aacute;y t&iacute;nh</li>\r\n	<li>- &nbsp; &nbsp;Lĩnh vực&nbsp;C&ocirc;ng nghệ th&ocirc;ng tin</li>\r\n</ul>', '<ul>\r\n	<li><a href="http://fit.uet.vnu.edu.vn/?q=content/b%E1%BB%99-m%C3%B4n-c%C3%A1c-h%E1%BB%87-th%E1%BB%91ng-th%C3%B4ng-tin">Bộ m&ocirc;n C&aacute;c Hệ thống Th&ocirc;ng tin</a></li>\r\n	<li><a href="http://fit.uet.vnu.edu.vn/?q=content/b%E1%BB%99-m%C3%B4n-c%C3%B4ng-ngh%E1%BB%87-ph%E1%BA%A7n-m%E1%BB%81m">Bộ m&ocirc;n C&ocirc;ng nghệ Phần mềm</a></li>\r\n	<li><a href="http://fit.uet.vnu.edu.vn/?q=content/b%E1%BB%99-m%C3%B4n-khoa-h%E1%BB%8Dc-m%C3%A1y-t%C3%ADnh">Bộ m&ocirc;n Khoa học M&aacute;y t&iacute;nh</a></li>\r\n	<li>Bộ m&ocirc;n Khoa học v&agrave; Kỹ thuật t&iacute;nh to&aacute;n</li>\r\n	<li><a href="http://fit.uet.vnu.edu.vn/?q=content/b%E1%BB%99-m%C3%B4n-truy%E1%BB%81n-th%C3%B4ng-v%C3%A0-m%E1%BA%A1ng-m%C3%A1y-t%C3%ADnh">Bộ m&ocirc;n Truyền th&ocirc;ng v&agrave; Mạng M&aacute;y t&iacute;nh</a></li>\r\n	<li>Ph&ograve;ng Th&iacute; nghiệm An to&agrave;n th&ocirc;ng tin</li>\r\n	<li><a href="http://fit.uet.vnu.edu.vn/?q=content/ph%C3%B2ng-th%C3%AD-nghi%E1%BB%87m-c%C3%B4ng-ngh%E1%BB%87-tri-th%E1%BB%A9c">Ph&ograve;ng Th&iacute; nghiệm C&ocirc;ng nghệ Tri thức</a></li>\r\n	<li><a href="http://fit.uet.vnu.edu.vn/?q=content/ph%C3%B2ng-th%C3%AD-nghi%E1%BB%87m-h%E1%BB%87-th%E1%BB%91ng-nh%C3%BAng">Ph&ograve;ng Th&iacute; nghiệm Hệ thống Nh&uacute;ng</a></li>\r\n	<li><a href="http://fit.uet.vnu.edu.vn/?q=content/ph%C3%B2ng-th%C3%AD-nghi%E1%BB%87m-t%C6%B0%C6%A1ng-t%C3%A1c-ng%C6%B0%E1%BB%9Di-%E2%80%93-m%C3%A1y">Ph&ograve;ng Th&iacute; nghiệm Tương t&aacute;c Người &ndash; M&aacute;y</a></li>\r\n</ul>'),
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
  `subject_name` varchar(100) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `tbl_subject`
--

INSERT INTO `tbl_subject` (`subject_id`, `subject_name`, `subject_code`, `subject_active`, `subject_university`, `subject_type`, `subject_year`, `subject_credits`, `subject_credit_hour`, `subject_requirement`, `subject_target`, `subject_info`, `subject_test`, `subject_faculty`, `subject_dept`, `subject_content`) VALUES
(0, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 'Những nguyên lý cơ bản của chủ nghĩa Mác – Lênin 1', 'PHI1004', '1', NULL, 1, NULL, 2, '21 - 5 - 4', 'Dùng cho sinh viên khối không chuyên ngành Mác-Lênin, tư tưởng Hồ Chí Minh trình độ đại học, cao đẳng.', '<p>M&ocirc;n học Những nguy&ecirc;n l&yacute; cơ bản của chủ nghĩa M&aacute;c-L&ecirc;nin nhằm gi&uacute;p cho sinh vi&ecirc;n:</p>\r\n\r\n<p>- X&aacute;c lập cơ sở l&yacute; luận cơ bản nhất để từ đ&oacute; c&oacute; thể tiếp cận được nội dung m&ocirc;n học Tư tưởng Hồ Ch&iacute; Minh v&agrave; Đường lối c&aacute;ch mạng của Đảng Cộng sản Việt Nam, hiểu biết nền tảng tư tưởng của Đảng;</p>\r\n\r\n<p>- X&acirc;y dựng niềm tin, l&yacute; tưởng c&aacute;ch mạng cho sinh vi&ecirc;n;</p>\r\n\r\n<p>- Từng bước x&aacute;c lập thế giới quan, nh&acirc;n sinh quan v&agrave; phương ph&aacute;p luận chung nhất để tiếp cận c&aacute;c khoa học chuy&ecirc;n ng&agrave;nh được đ&agrave;o tạo.</p>', NULL, NULL, 1, 1, 'Ngoài 1 chương mở đầu nhằm giới thiệu khái lược về chủ nghĩa Mác-Lênin và một số vấn đề chung của môn học. Căn cứ vào mục tiêu môn học, nội dung chương trình môn học được cấu trúc thành 3 phần, 9 chương: Phần thứ nhất có 3 chương bao quát những nội dung cơ bản về thế giới quan và phương pháp luận của chủ nghĩa Mác-Lênin; phần thứ hai có 3 chương trình bày ba nội dung trọng tâm thuộc học thuyết kinh tế của chủ nghĩa Mác-Lênin về phương thức sản xuất tư bản chủ nghĩa; phần thứ ba có 3 chương, trong đó có 2 chương khái quát những nội dung cơ bản thuộc lý luận của chủ nghĩa Mác-Lênin về chủ nghĩa xã hội và 1 chương khái quát chủ nghĩa xã hội hiện thực và triển vọng.'),
(2, 'Những nguyên lý cơ bản của chủ nghĩa Mác – Lênin 2', 'PHI1004', '1', NULL, 1, NULL, 3, '32 - 8 - 5 ', 'Dùng cho sinh viên khối không chuyên ngành Mác-Lênin, tư tưởng Hồ Chí Minh trình độ đại học, cao đẳng.', '<p>M&ocirc;n học Những nguy&ecirc;n l&yacute; cơ bản của chủ nghĩa M&aacute;c-L&ecirc;nin nhằm gi&uacute;p cho sinh vi&ecirc;n:</p>\r\n\r\n<p>- X&aacute;c lập cơ sở l&yacute; luận cơ bản nhất để từ đ&oacute; c&oacute; thể tiếp cận được nội dung m&ocirc;n học Tư tưởng Hồ Ch&iacute; Minh v&agrave; Đường lối c&aacute;ch mạng của Đảng Cộng sản Việt Nam, hiểu biết nền tảng tư tưởng của Đảng;</p>\r\n\r\n<p>- X&acirc;y dựng niềm tin, l&yacute; tưởng c&aacute;ch mạng cho sinh vi&ecirc;n;</p>\r\n\r\n<p>- Từng bước x&aacute;c lập thế giới quan, nh&acirc;n sinh quan v&agrave; phương ph&aacute;p luận chung nhất để tiếp cận c&aacute;c khoa học chuy&ecirc;n ng&agrave;nh được đ&agrave;o tạo.</p>', NULL, NULL, 1, 1, 'Ngoài 1 chương mở đầu nhằm giới thiệu khái lược về chủ nghĩa Mác-Lênin và một số vấn đề chung của môn học. Căn cứ vào mục tiêu môn học, nội dung chương trình môn học được cấu trúc thành 3 phần, 9 chương: Phần thứ nhất có 3 chương bao quát những nội dung cơ bản về thế giới quan và phương pháp luận của chủ nghĩa Mác-Lênin; phần thứ hai có 3 chương trình bày ba nội dung trọng tâm thuộc học thuyết kinh tế của chủ nghĩa Mác-Lênin về phương thức sản xuất tư bản chủ nghĩa; phần thứ ba có 3 chương, trong đó có 2 chương khái quát những nội dung cơ bản thuộc lý luận của chủ nghĩa Mác-Lênin về chủ nghĩa xã hội và 1 chương khái quát chủ nghĩa xã hội hiện thực và triển vọng.'),
(3, 'Đại số', 'MAT1093', '1', NULL, 2, NULL, 4, '45 - 15', NULL, '<p>- Trang bị cho sinh vi&ecirc;n những kh&aacute;i niệm v&agrave; kỹ năng cơ bản nhất của Đại số tuyến t&iacute;nh một trong những m&ocirc;n cơ sở của To&aacute;n học, tạo điều kiện để học tập, nghi&ecirc;n cứu c&aacute;c m&ocirc;n học kh&aacute;c.</p>\r\n\r\n<p>- Gi&uacute;p sinh vi&ecirc;n hiểu được c&aacute;c kiến thức cơ bản của Đại số tuyến t&iacute;nh, li&ecirc;n hệ với những kiến thức đ&atilde; học ở bậc phổ th&ocirc;ng, biết c&aacute;ch tự hệ thống ho&aacute; kiến thức, t&igrave;m t&ograve;i mở rộng th&ecirc;m c&aacute;c kiến thức cơ bản để phục vụ c&ocirc;ng t&aacute;c sau n&agrave;y.</p>', NULL, NULL, 1, 1, 'Đại số tuyến tính là một trong những môn học đầu tiên của Toán học trừu tượng, sinh viên cần nắm vững các khái niệm, hình dung chính xác các khái niệm đó trong những tình huống cụ thể, biết vận dụng các kết quả mới. Phần đầu chương trình ôn tập lại các khái niệm về tập hợp và ánh xạ, sau đó giới thiệu một số cấu trúc đại số như nhóm, vành, trường. Một thời lượng đáng kể dành cho việc giới thiệu trường số phức, các tính chất của số phức, đa thức và phân thức hữu tỉ thực. Chương III là lý thuyết về ma trận, định thức và hệ phương trình tuyến tính. Ở chương này sinh viên sẽ được ôn lại cách giải hệ phương trình tuyến tính đã học từ chương trình phổ thông. Tuy vậy toàn bộ lý thuyết sẽ được trình bày một cách có hệ thống và ở một ngôn ngữ tổng quát. Chương IV gồm những vấn đề cơ bản của không gian véc tơ, không gian Euclid. Đây có thể coi như những tổng quát hóa lên trường hợp nhiều chiều của các khái niệm mặt phẳng toạ độ, hệ toạ độ trong không gian mà sinh viên đã nắm vững từ bậc phổ thông. Chương V khảo sát một số tính chất quan trọng của ánh xạ tuyến tính, toán tử tuyến tính trong không gian véc tơ hữu hạn chiều, phép biến đổi trực giao, dạng song tuyến tính, dạng toàn phương toán tử tự liên hợp (hay phép biến đổi đối xứng). Chương VI dành cho áp dụng lí thuyết không gian véc tơ Euclid, dạng toàn phương vào việc khảo sát một số vấn đề của hình học giải tích như phân loại các đường bậc hai, mặt bậc hai.'),
(4, 'Giải tích 1', 'MAT1094', '1', NULL, 2, NULL, 5, '50 - 25', NULL, '<p>- Trang bị cho sinh vi&ecirc;n những kh&aacute;i niệm v&agrave; cơ bản nhất Giải t&iacute;ch một biến số, một trong những m&ocirc;n cơ sở của To&aacute;n học, tạo điều kiện để học tập, nghi&ecirc;n cứu c&aacute;c m&ocirc;n học kh&aacute;c.</p>\r\n\r\n<p>- Gi&uacute;p sinh vi&ecirc;n hiểu được c&aacute;c kiến thức cơ bản của Giải t&iacute;ch một biến số, li&ecirc;n hệ với những kiến thức đ&atilde; học ở bậc phổ th&ocirc;ng, biết c&aacute;ch tự hệ thống ho&aacute; kiến thức, t&igrave;m t&ograve;i mở rộng th&ecirc;m c&aacute;c kiến thức cơ bản để phục vụ c&ocirc;ng t&aacute;c sau n&agrave;y.</p>', NULL, NULL, 1, 1, 'Môn học giới thiệu các khái niệm về tập hợp và ánh xạ, giới hạn của dãy số và hàm số, hàm liên tục và hàm sơ cấp, các hàm ngược và hàm hyperbolic, các khái niệm về đạo hàm và vi phân của hàm một biến, các định lí cơ bản về hàm khả vi, nguyên hàm và tích phân, tích phân suy rộng với cận vô hạn hoặc với hàm không bị chặn, lí thuyết về chuỗi số, chuỗi hàm tổng quát, chuỗi lũy thừa và chuỗi Fourier.'),
(5, 'Tín hiệu và hệ thống', 'ELT2035', '1', NULL, 3, NULL, 3, '42 - 3', NULL, 'Các khái niệm cơ sở về các loại tín hiệu và hệ thống tuyến tính bất biến, các phương pháp biểu diễn và phân tích tín hiệu và hệ thống tuyến tính bất biến; sử dụng các phương pháp và các công cụ tính toán cho việc biểu diễn và phân tích tín hiệu và hệ thống, phân tích, giải quyết và trình bày các vấn đề có liên quan tới chủ đề của môn học.', NULL, NULL, 1, 1, 'Phân loại tín hiệu và hệ thống, các loại tín hiệu cơ sở, các mô hình hệ thống, biểu diễn hệ thống tuyến tính bất biến trong miền thời gian, biểu diễn Fourier và áp dụng cho tín hiệu và hệ thống tuyến tính bất biến, biến đổi Laplace và áp dụng cho phân tích hệ thống tuyến tính bất biến liên tục, biến đổi Z và áp dụng cho phân tích hệ thống tuyến tính bất biến rời rạc.'),
(6, 'Cấu trúc dữ liệu và giải thuật', 'INT2203', '1', NULL, 3, NULL, 3, '30 - 15', NULL, 'Biết mô tả và cài đặt được các cấu trúc dữ liệu đơn giản như mảng, bản ghi, hàng đợi, găn xếp, ...; biết mô tả và cài đặt được các cấu trúc dữ liệu phức tạp như cây, mảng băm; biết mô tả và cài đặt được các thuật toán sắp xếp, tìm kiếm; biết mô tả và cài đặt được các thuật trên đồ thị như thuật toán tìm đường đi ngắn nhất, thuật toán tìm các thành phần liên thông, các thuật toán tìm kiếm và duyệt trên cây và đồ thị; có khả năng ứng dụng các cấu trúc dữ liệu và giải thuật để giải quyết các bài toán trong CNTT.', NULL, NULL, 1, 1, 'Môn học cung cấp các kiến thức nền tảng về các cấu trúc dữ liệu cũng như các thuật toán cho sinh viên. Phần đầu của môn học, sinh viên được học các cấu trúc dữ liệu cơ bản như hàng đợi, ngăn xếp cho đến các cấu trúc dữ liệu phức tạp như cây,  mảng băm. Phần còn lại của môn học trang bị cho sinh viên các thuật toán từ đơn giản đến phức tạp để giải quyết một loạt các bài toán cơ bản như sắp xếp, tìm kiếm, các bài toán trên đồ thị hay trên cây.'),
(7, 'Lập trình hướng đổi tượng', 'INT2204', '1', NULL, 4, NULL, 3, '30 - 15', NULL, 'Hiểu các nguyên lý cơ bản của thiết kế hướng đối tượng; hiểu các vấn đề căn bản và một số vấn đề nâng cao trong việc viết các lớp và phương thức như bản chất của đối tượng và tham chiếu đối tượng, dữ liệu và quyền truy nhập, biến và phạm vi; hiểu các quan niệm nằm sau cây thừa kế, đa hình, và việc lập trình theo interface; hiểu nguyên lý hoạt động của các ngoại lệ và các dòng vào ra cơ bản; hắm được khái niệm căn bản về lập trình tổng quát và làm quen với các cấu trúc dữ liệu tổng quát; hó khả năng đưa ra một giải pháp lập trình hướng đối tượng cho các bài toán ở quy mô tương đối đơn giản; hiểu được sơ đồ lớp bằng ngôn ngữ đặc tả UML với cú pháp cơ bản; có khả năng cài đặt một thiết kế hướng đối tượng cho trước bằng ngôn ngữ Java.', NULL, NULL, 1, 1, 'Môn học đi sâu giới thiệu cách tiếp cận hướng đối tượng đối với việc lập trình, với ngôn ngữ minh họa là Java. Mục tiêu là giúp cho sinh viên có được một hiểu biết tốt về các khái niệm cơ bản của lập trình hướng đối tượng như đối tượng, lớp, phương thức, thừa kế, đa hình, và interface, đi kèm theo là các nguyên lý căn bản về trừu tượng hóa, tính mô-đun và tái sử dụng trong thiết kế hướng đối tượng..'),
(8, 'Kiến trúc máy tính', 'INT2205', '1', NULL, 4, NULL, 3, '45', NULL, 'Nắm vững kiến thức về cổng lôgic số, hàm lôgic, mạch lôgic tổ hợp đơn giản từ các cổng logic, các latch, flip-flop, và các mạch lôgic tuần tự đơn giản; nắm vững các nguyên lý vào ra dữ liệu của máy tính; nắm vững kiến trúc tổng quan của bộ vi xử lý - các thành phần và giao tiếp giữa các thành phần; nắm vững các khái niệm của một kiến trúc tập lệnh - Instruction Set Architecture (ISA), khái niệm ngắt và sự hỗ trợ của phần cứng, khái niệm hợp ngữ và quan hệ giữa hợp ngữ và các lệnh máy, khái niệm về máy ảo và bộ nhớ ảo.', NULL, NULL, 1, 1, 'Cung cấp cho sinh viên các kiến thức về: Các biểu diễn số trong máy tính. Cổng lôgic số, hàm lôgic, mạch lôgic tổ hợp đơn giản từ các cổng logic, các latch, flip-flop, và các mạch lôgic tuần tự đơn giản. Cây phả hệ bộ nhớ trong máy tính (từ các thanh ghi tới vùng lưu trữ thứ cấp) và đặc điểm của các loại bộ nhớ khác nhau. Các nguyên lý vào ra dữ liệu của máy tính. Kiến trúc tổng quan của bộ vi xử lý - các thành phần và giao tiếp giữa các thành phần. Sự khác nhau giữa kiến trúc macroarchitecture và microarchitecture của một CPU và hoạt động của một chu trình fetch-execute. Khái niệm của một kiến trúc tập lệnh - Instruction Set Architecture (ISA). Khái niệm ngắt và sự hỗ trợ của phần cứng. Khái niệm hợp ngữ và quan hệ giữa hợp ngữ và các lệnh máy. Khái niệm về máy ảo và bộ nhớ ảo.'),
(9, 'Lập trình nâng cao', 'INT2202', '1', NULL, 5, NULL, 3, '30 - 15', NULL, 'Hiểu các khái niệm và biết vận dụng các kỹ thuật trong lập trình để biểu diễn bài toán và giải quyết bài toán bằng lập trình; hiểu các khái niệm cơ bản trong lập trình hướng đối tượng, có khả năng lập trình các bài toán cơ bản bằng lập trình hướng đối tượng trong C++; có khả năng lập trình với nhiều loại cấu trúc dữ liệu phức tạp và các kỹ thuật khó. Các kiểu dữ liệu như Xâu, Mảng nhiều chiều, Cấu trúc và Lớp. Các kỹ thuật lập trình khó như hàm đệ qui, xử lý trên xâu, xây dựng lớp và đối tượng, xây dựng các hàm mẫu.', NULL, NULL, 1, 1, 'Cung cấp cho sinh viên các kiến thức cơ bản và nâng cao về cách giải quyết các bài toán bằng lập trình. Giới thiệu các khái niệm và cấu trúc lập trình căn bản để giải quyết bài toán (minh hoạ trên ngôn ngữ C++): biến, kiểu dữ liệu, biểu thức, phép gán, vào ra dữ liệu đơn giản; các cấu trúc lặp và điều kiện, phân rã cấu trúc; làm việc với tệp; khái niệm hàm và sử dụng hàm. Giới thiệu các khái niệm và kỹ thuật nâng cao trong lập trình: làm việc với dữ liệu có cấu trúc; kỹ thuật đệ qui; kiểu dữ liệu trừu tượng; khuôn mẫu hàm; các khái niệm và kỹ thuật cơ bản trong lập trình hướng đối tượng; lập trình trên nhiều tệp. Thực hành trên ngôn ngữ lập trình hướng đối tượng C++. '),
(10, 'Trí tuệ nhân tạo', 'INT3401', '1', NULL, 5, NULL, 3, '45', NULL, 'Biết mô tả và biễu diễn các yêu cầu của một bài toán thực tế dưới dạng bài toán tìm kiếm; hiểu và vận dụng được các chiến lược tìm kiếm mù và tìm kiếm có kinh nghiệm; biết sử dụng logic mệnh đề và logic vị từ để biểu diễn tri thức; hiểu và biết sử dụng các luật phân giải và suy diễn; hiểu và biết sử dụng các phương pháp học máy. ', NULL, NULL, 1, 1, 'Môn học cung cấp các kiến thức nền tảng trong lĩnh vực trí tuệ nhân tạo bao gồm các phương pháp giải quyết vấn để sử dụng phương pháp tìm kiếm, các chiến lược tìm kiếm có kinh nghiệm, tìm kiếm thỏa mãn ràng buộc, tìm kiếm có đối thủ trong trò chơi, các phương pháp biểu diễn tri thức và lập luận tự động, lập luận không chắc chắn. Người học được giới thiệu các khái niệm và kỹ thuật cơ bản về học máy. Môn học cũng giới thiệu với người học một số công cụ để xây dựng các hệ thống thông minh.'),
(11, 'Thực tập chuyên ngành', 'INT3508', '1', NULL, 6, NULL, 3, '15 - 30', NULL, 'Có kỹ năng làm việc nhóm; hiểu và áp dụng được một quy trình phát triển phần mềm; vận dụng các kiến thức về phân tích thiết kế để xây dựng yêu cầu, tiến hành phân tích và thiết kế các hệ thống phần mềm; biết làm việc trong môi trường thực tế; biết nghiên cứu, xây dựng sản phẩm phục vụ cho mục đích khoa học hoặc đời sống.', NULL, NULL, 1, 1, 'Sinh viên sẽ đi thực tập ở các công ty, viện  nghiên cứu, hoặc chính tại các bộ môn, phòng thí nghiệm, và trung tâm trong Trường Đại học Công nghệ. Thông qua việc thực hiện các đề tài được giao, sinh viên có cơ hội áp dụng kiến thức, kỹ năng đã học vào giải quyết bài toán thực tế và qua đó cũng biết được là mình còn kém mặt nào để rút kinh nghiệm. Bên cạnh đó sinh viên cũng được hiểu biết hơn về môi trường công ty (cả văn hóa và công nghệ), rèn luyện kĩ năng giao tiếp, làm việc nhóm, tác phong công nghiệp.'),
(12, 'Khóa luận tốt nghiệp ', 'INT4050', '1', NULL, 6, NULL, 10, NULL, NULL, 'Có kỹ năng đọc tài liệu tiếng Anh thành thạo; có kỹ năng tiến hành nghiên cứu, giải quyết vấn đề; có kỹ năng thực hiện thí nghiệm, đánh giá; có kỹ năng viết báo cáo (luận văn) bằng tiếng Anh; có kỹ năng trình bày bằng tiếng Anh.', NULL, NULL, 1, 1, 'Sinh viên năm cuối được làm khóa luận tốt nghiệp dưới sự hướng dẫn của giảng viên. Theo đó sinh viên cần vận dụng các kiến thức và kỹ năng đã tích lũy được để giải quyết một vấn đề nghiên cứu cơ bản hoặc giải pháp thực tiễn thuộc lĩnh vực CNTT. Việc thực hiện khóa luận tốt nghiệp giúp sinh viên củng cố hoặc có thêm kiến thức và kỹ năng trong hoạt động chuyên môn như: đọc tài liệu, phát triển ý tưởng, lập trình, thực hiện thí nghiệm, đánh giá, viết luận văn, trình bày báo cáo, v.v.'),
(13, 'Những nguyên lý cơ bản của chủ nghĩa Mác – Lênin 1', 'PHI1004', '1', NULL, 1, NULL, 2, '21 - 5 - 4', 'Dùng cho sinh viên khối không chuyên ngành Mác-Lênin, tư tưởng Hồ Chí Minh trình độ đại học, cao đẳng.', '<p>M&ocirc;n học Những nguy&ecirc;n l&yacute; cơ bản của chủ nghĩa M&aacute;c-L&ecirc;nin nhằm gi&uacute;p cho sinh vi&ecirc;n:</p>\r\n\r\n<p>- X&aacute;c lập cơ sở l&yacute; luận cơ bản nhất để từ đ&oacute; c&oacute; thể tiếp cận được nội dung m&ocirc;n học Tư tưởng Hồ Ch&iacute; Minh v&agrave; Đường lối c&aacute;ch mạng của Đảng Cộng sản Việt Nam, hiểu biết nền tảng tư tưởng của Đảng;</p>\r\n\r\n<p>- X&acirc;y dựng niềm tin, l&yacute; tưởng c&aacute;ch mạng cho sinh vi&ecirc;n;</p>\r\n\r\n<p>- Từng bước x&aacute;c lập thế giới quan, nh&acirc;n sinh quan v&agrave; phương ph&aacute;p luận chung nhất để tiếp cận c&aacute;c khoa học chuy&ecirc;n ng&agrave;nh được đ&agrave;o tạo.</p>', NULL, NULL, 1, 2, 'Ngoài 1 chương mở đầu nhằm giới thiệu khái lược về chủ nghĩa Mác-Lênin và một số vấn đề chung của môn học. Căn cứ vào mục tiêu môn học, nội dung chương trình môn học được cấu trúc thành 3 phần, 9 chương: Phần thứ nhất có 3 chương bao quát những nội dung cơ bản về thế giới quan và phương pháp luận của chủ nghĩa Mác-Lênin; phần thứ hai có 3 chương trình bày ba nội dung trọng tâm thuộc học thuyết kinh tế của chủ nghĩa Mác-Lênin về phương thức sản xuất tư bản chủ nghĩa; phần thứ ba có 3 chương, trong đó có 2 chương khái quát những nội dung cơ bản thuộc lý luận của chủ nghĩa Mác-Lênin về chủ nghĩa xã hội và 1 chương khái quát chủ nghĩa xã hội hiện thực và triển vọng.'),
(14, 'Những nguyên lý cơ bản của chủ nghĩa Mác – Lênin 2', 'PHI1004', '1', NULL, 1, NULL, 3, '32 - 8 - 5 ', 'Dùng cho sinh viên khối không chuyên ngành Mác-Lênin, tư tưởng Hồ Chí Minh trình độ đại học, cao đẳng.', '<p>M&ocirc;n học Những nguy&ecirc;n l&yacute; cơ bản của chủ nghĩa M&aacute;c-L&ecirc;nin nhằm gi&uacute;p cho sinh vi&ecirc;n:</p>\r\n\r\n<p>- X&aacute;c lập cơ sở l&yacute; luận cơ bản nhất để từ đ&oacute; c&oacute; thể tiếp cận được nội dung m&ocirc;n học Tư tưởng Hồ Ch&iacute; Minh v&agrave; Đường lối c&aacute;ch mạng của Đảng Cộng sản Việt Nam, hiểu biết nền tảng tư tưởng của Đảng;</p>\r\n\r\n<p>- X&acirc;y dựng niềm tin, l&yacute; tưởng c&aacute;ch mạng cho sinh vi&ecirc;n;</p>\r\n\r\n<p>- Từng bước x&aacute;c lập thế giới quan, nh&acirc;n sinh quan v&agrave; phương ph&aacute;p luận chung nhất để tiếp cận c&aacute;c khoa học chuy&ecirc;n ng&agrave;nh được đ&agrave;o tạo.</p>', NULL, NULL, 1, 2, 'Ngoài 1 chương mở đầu nhằm giới thiệu khái lược về chủ nghĩa Mác-Lênin và một số vấn đề chung của môn học. Căn cứ vào mục tiêu môn học, nội dung chương trình môn học được cấu trúc thành 3 phần, 9 chương: Phần thứ nhất có 3 chương bao quát những nội dung cơ bản về thế giới quan và phương pháp luận của chủ nghĩa Mác-Lênin; phần thứ hai có 3 chương trình bày ba nội dung trọng tâm thuộc học thuyết kinh tế của chủ nghĩa Mác-Lênin về phương thức sản xuất tư bản chủ nghĩa; phần thứ ba có 3 chương, trong đó có 2 chương khái quát những nội dung cơ bản thuộc lý luận của chủ nghĩa Mác-Lênin về chủ nghĩa xã hội và 1 chương khái quát chủ nghĩa xã hội hiện thực và triển vọng.'),
(17, 'Đại số', 'MAT1093', '1', NULL, 2, NULL, 4, '45 - 15', NULL, '<p>- Trang bị cho sinh vi&ecirc;n những kh&aacute;i niệm v&agrave; kỹ năng cơ bản nhất của Đại số tuyến t&iacute;nh một trong những m&ocirc;n cơ sở của To&aacute;n học, tạo điều kiện để học tập, nghi&ecirc;n cứu c&aacute;c m&ocirc;n học kh&aacute;c.</p>\r\n\r\n<p>- Gi&uacute;p sinh vi&ecirc;n hiểu được c&aacute;c kiến thức cơ bản của Đại số tuyến t&iacute;nh, li&ecirc;n hệ với những kiến thức đ&atilde; học ở bậc phổ th&ocirc;ng, biết c&aacute;ch tự hệ thống ho&aacute; kiến thức, t&igrave;m t&ograve;i mở rộng th&ecirc;m c&aacute;c kiến thức cơ bản để phục vụ c&ocirc;ng t&aacute;c sau n&agrave;y.</p>', NULL, NULL, 1, 2, 'Đại số tuyến tính là một trong những môn học đầu tiên của Toán học trừu tượng, sinh viên cần nắm vững các khái niệm, hình dung chính xác các khái niệm đó trong những tình huống cụ thể, biết vận dụng các kết quả mới. Phần đầu chương trình ôn tập lại các khái niệm về tập hợp và ánh xạ, sau đó giới thiệu một số cấu trúc đại số như nhóm, vành, trường. Một thời lượng đáng kể dành cho việc giới thiệu trường số phức, các tính chất của số phức, đa thức và phân thức hữu tỉ thực. Chương III là lý thuyết về ma trận, định thức và hệ phương trình tuyến tính. Ở chương này sinh viên sẽ được ôn lại cách giải hệ phương trình tuyến tính đã học từ chương trình phổ thông. Tuy vậy toàn bộ lý thuyết sẽ được trình bày một cách có hệ thống và ở một ngôn ngữ tổng quát. Chương IV gồm những vấn đề cơ bản của không gian véc tơ, không gian Euclid. Đây có thể coi như những tổng quát hóa lên trường hợp nhiều chiều của các khái niệm mặt phẳng toạ độ, hệ toạ độ trong không gian mà sinh viên đã nắm vững từ bậc phổ thông. Chương V khảo sát một số tính chất quan trọng của ánh xạ tuyến tính, toán tử tuyến tính trong không gian véc tơ hữu hạn chiều, phép biến đổi trực giao, dạng song tuyến tính, dạng toàn phương toán tử tự liên hợp (hay phép biến đổi đối xứng). Chương VI dành cho áp dụng lí thuyết không gian véc tơ Euclid, dạng toàn phương vào việc khảo sát một số vấn đề của hình học giải tích như phân loại các đường bậc hai, mặt bậc hai.'),
(18, 'Giải tích 1', 'MAT1094', '1', NULL, 2, NULL, 5, '50 - 25', NULL, '<p>- Trang bị cho sinh vi&ecirc;n những kh&aacute;i niệm v&agrave; cơ bản nhất Giải t&iacute;ch một biến số, một trong những m&ocirc;n cơ sở của To&aacute;n học, tạo điều kiện để học tập, nghi&ecirc;n cứu c&aacute;c m&ocirc;n học kh&aacute;c.</p>\r\n\r\n<p>- Gi&uacute;p sinh vi&ecirc;n hiểu được c&aacute;c kiến thức cơ bản của Giải t&iacute;ch một biến số, li&ecirc;n hệ với những kiến thức đ&atilde; học ở bậc phổ th&ocirc;ng, biết c&aacute;ch tự hệ thống ho&aacute; kiến thức, t&igrave;m t&ograve;i mở rộng th&ecirc;m c&aacute;c kiến thức cơ bản để phục vụ c&ocirc;ng t&aacute;c sau n&agrave;y.</p>', NULL, NULL, 1, 2, 'Môn học giới thiệu các khái niệm về tập hợp và ánh xạ, giới hạn của dãy số và hàm số, hàm liên tục và hàm sơ cấp, các hàm ngược và hàm hyperbolic, các khái niệm về đạo hàm và vi phân của hàm một biến, các định lí cơ bản về hàm khả vi, nguyên hàm và tích phân, tích phân suy rộng với cận vô hạn hoặc với hàm không bị chặn, lí thuyết về chuỗi số, chuỗi hàm tổng quát, chuỗi lũy thừa và chuỗi Fourier.'),
(19, 'Tín hiệu và hệ thống', 'ELT2035', '1', NULL, 3, NULL, 3, '42 - 3', NULL, 'Các khái niệm cơ sở về các loại tín hiệu và hệ thống tuyến tính bất biến, các phương pháp biểu diễn và phân tích tín hiệu và hệ thống tuyến tính bất biến; sử dụng các phương pháp và các công cụ tính toán cho việc biểu diễn và phân tích tín hiệu và hệ thống, phân tích, giải quyết và trình bày các vấn đề có liên quan tới chủ đề của môn học.', NULL, NULL, 1, 2, 'Phân loại tín hiệu và hệ thống, các loại tín hiệu cơ sở, các mô hình hệ thống, biểu diễn hệ thống tuyến tính bất biến trong miền thời gian, biểu diễn Fourier và áp dụng cho tín hiệu và hệ thống tuyến tính bất biến, biến đổi Laplace và áp dụng cho phân tích hệ thống tuyến tính bất biến liên tục, biến đổi Z và áp dụng cho phân tích hệ thống tuyến tính bất biến rời rạc.'),
(20, 'Cấu trúc dữ liệu và giải thuật', 'INT2203', '1', NULL, 3, NULL, 3, '30 - 15', NULL, 'Biết mô tả và cài đặt được các cấu trúc dữ liệu đơn giản như mảng, bản ghi, hàng đợi, găn xếp, ...; biết mô tả và cài đặt được các cấu trúc dữ liệu phức tạp như cây, mảng băm; biết mô tả và cài đặt được các thuật toán sắp xếp, tìm kiếm; biết mô tả và cài đặt được các thuật trên đồ thị như thuật toán tìm đường đi ngắn nhất, thuật toán tìm các thành phần liên thông, các thuật toán tìm kiếm và duyệt trên cây và đồ thị; có khả năng ứng dụng các cấu trúc dữ liệu và giải thuật để giải quyết các bài toán trong CNTT.', NULL, NULL, 1, 2, 'Môn học cung cấp các kiến thức nền tảng về các cấu trúc dữ liệu cũng như các thuật toán cho sinh viên. Phần đầu của môn học, sinh viên được học các cấu trúc dữ liệu cơ bản như hàng đợi, ngăn xếp cho đến các cấu trúc dữ liệu phức tạp như cây,  mảng băm. Phần còn lại của môn học trang bị cho sinh viên các thuật toán từ đơn giản đến phức tạp để giải quyết một loạt các bài toán cơ bản như sắp xếp, tìm kiếm, các bài toán trên đồ thị hay trên cây.'),
(21, 'Lập trình hướng đổi tượng', 'INT2204', '1', NULL, 4, NULL, 3, '30 - 15', NULL, 'Hiểu các nguyên lý cơ bản của thiết kế hướng đối tượng; hiểu các vấn đề căn bản và một số vấn đề nâng cao trong việc viết các lớp và phương thức như bản chất của đối tượng và tham chiếu đối tượng, dữ liệu và quyền truy nhập, biến và phạm vi; hiểu các quan niệm nằm sau cây thừa kế, đa hình, và việc lập trình theo interface; hiểu nguyên lý hoạt động của các ngoại lệ và các dòng vào ra cơ bản; hắm được khái niệm căn bản về lập trình tổng quát và làm quen với các cấu trúc dữ liệu tổng quát; hó khả năng đưa ra một giải pháp lập trình hướng đối tượng cho các bài toán ở quy mô tương đối đơn giản; hiểu được sơ đồ lớp bằng ngôn ngữ đặc tả UML với cú pháp cơ bản; có khả năng cài đặt một thiết kế hướng đối tượng cho trước bằng ngôn ngữ Java.', NULL, NULL, 1, 2, 'Môn học đi sâu giới thiệu cách tiếp cận hướng đối tượng đối với việc lập trình, với ngôn ngữ minh họa là Java. Mục tiêu là giúp cho sinh viên có được một hiểu biết tốt về các khái niệm cơ bản của lập trình hướng đối tượng như đối tượng, lớp, phương thức, thừa kế, đa hình, và interface, đi kèm theo là các nguyên lý căn bản về trừu tượng hóa, tính mô-đun và tái sử dụng trong thiết kế hướng đối tượng..'),
(22, 'Kiến trúc máy tính', 'INT2205', '1', NULL, 4, NULL, 3, '45', NULL, 'Nắm vững kiến thức về cổng lôgic số, hàm lôgic, mạch lôgic tổ hợp đơn giản từ các cổng logic, các latch, flip-flop, và các mạch lôgic tuần tự đơn giản; nắm vững các nguyên lý vào ra dữ liệu của máy tính; nắm vững kiến trúc tổng quan của bộ vi xử lý - các thành phần và giao tiếp giữa các thành phần; nắm vững các khái niệm của một kiến trúc tập lệnh - Instruction Set Architecture (ISA), khái niệm ngắt và sự hỗ trợ của phần cứng, khái niệm hợp ngữ và quan hệ giữa hợp ngữ và các lệnh máy, khái niệm về máy ảo và bộ nhớ ảo.', NULL, NULL, 1, 2, 'Cung cấp cho sinh viên các kiến thức về: Các biểu diễn số trong máy tính. Cổng lôgic số, hàm lôgic, mạch lôgic tổ hợp đơn giản từ các cổng logic, các latch, flip-flop, và các mạch lôgic tuần tự đơn giản. Cây phả hệ bộ nhớ trong máy tính (từ các thanh ghi tới vùng lưu trữ thứ cấp) và đặc điểm của các loại bộ nhớ khác nhau. Các nguyên lý vào ra dữ liệu của máy tính. Kiến trúc tổng quan của bộ vi xử lý - các thành phần và giao tiếp giữa các thành phần. Sự khác nhau giữa kiến trúc macroarchitecture và microarchitecture của một CPU và hoạt động của một chu trình fetch-execute. Khái niệm của một kiến trúc tập lệnh - Instruction Set Architecture (ISA). Khái niệm ngắt và sự hỗ trợ của phần cứng. Khái niệm hợp ngữ và quan hệ giữa hợp ngữ và các lệnh máy. Khái niệm về máy ảo và bộ nhớ ảo.'),
(23, 'Lập trình nâng cao', 'INT2202', '1', NULL, 5, NULL, 3, '30 - 15', NULL, 'Hiểu các khái niệm và biết vận dụng các kỹ thuật trong lập trình để biểu diễn bài toán và giải quyết bài toán bằng lập trình; hiểu các khái niệm cơ bản trong lập trình hướng đối tượng, có khả năng lập trình các bài toán cơ bản bằng lập trình hướng đối tượng trong C++; có khả năng lập trình với nhiều loại cấu trúc dữ liệu phức tạp và các kỹ thuật khó. Các kiểu dữ liệu như Xâu, Mảng nhiều chiều, Cấu trúc và Lớp. Các kỹ thuật lập trình khó như hàm đệ qui, xử lý trên xâu, xây dựng lớp và đối tượng, xây dựng các hàm mẫu.', NULL, NULL, 1, 2, 'Cung cấp cho sinh viên các kiến thức cơ bản và nâng cao về cách giải quyết các bài toán bằng lập trình. Giới thiệu các khái niệm và cấu trúc lập trình căn bản để giải quyết bài toán (minh hoạ trên ngôn ngữ C++): biến, kiểu dữ liệu, biểu thức, phép gán, vào ra dữ liệu đơn giản; các cấu trúc lặp và điều kiện, phân rã cấu trúc; làm việc với tệp; khái niệm hàm và sử dụng hàm. Giới thiệu các khái niệm và kỹ thuật nâng cao trong lập trình: làm việc với dữ liệu có cấu trúc; kỹ thuật đệ qui; kiểu dữ liệu trừu tượng; khuôn mẫu hàm; các khái niệm và kỹ thuật cơ bản trong lập trình hướng đối tượng; lập trình trên nhiều tệp. Thực hành trên ngôn ngữ lập trình hướng đối tượng C++. '),
(24, 'Hệ quản trị cơ sở dữ liệu', 'INT3202', '1', NULL, 5, NULL, 3, '30 - 15', NULL, 'Có thể sử dụng một hệ quản trị CSDL (mySQL, Oracle, DB2, SQL Server, …) trong cả việc phát triển cũng như quản trị các CSDL phục vụ bài toán ứng dụng \r\nNắm vững cách quản lý truy cập dữ liệu của người dùng, các phương pháp lưu trữ dữ liệu, lập trình với thủ tục lưu trữ, phương pháp sao lưu và phục hồi dữ liệu, giao diện lập trình với hệ quản trị CSDL; có thể sử dụng bộ công cụ chuyên biệt để: tạo bản sao dữ liệu, phân mảnh dữ liệu, mô hình cụm dữ liệu (cluster).', NULL, NULL, 1, 2, 'Môn học cung cấp các kiến thức giúp sinh viên có thể sử dụng một hệ quản trị CSDL trong việc cả phát triển cũng như quản trị các CSDL phục vụ bài toán đích. Tuỳ nhu cầu thực tế, một hệ quản trị CSDL phổ biến sẽ được lựa chọn (Oracle, DB2, SQL Server, …) tiến hành xây dựng các bài thực hành. '),
(25, 'Thực tập chuyên ngành', 'INT3508', '1', NULL, 6, NULL, 3, '15 - 30', NULL, 'Có kỹ năng làm việc nhóm; hiểu và áp dụng được một quy trình phát triển phần mềm; vận dụng các kiến thức về phân tích thiết kế để xây dựng yêu cầu, tiến hành phân tích và thiết kế các hệ thống phần mềm; biết làm việc trong môi trường thực tế; biết nghiên cứu, xây dựng sản phẩm phục vụ cho mục đích khoa học hoặc đời sống.', NULL, NULL, 1, 2, 'Sinh viên sẽ đi thực tập ở các công ty, viện  nghiên cứu, hoặc chính tại các bộ môn, phòng thí nghiệm, và trung tâm trong Trường Đại học Công nghệ. Thông qua việc thực hiện các đề tài được giao, sinh viên có cơ hội áp dụng kiến thức, kỹ năng đã học vào giải quyết bài toán thực tế và qua đó cũng biết được là mình còn kém mặt nào để rút kinh nghiệm. Bên cạnh đó sinh viên cũng được hiểu biết hơn về môi trường công ty (cả văn hóa và công nghệ), rèn luyện kĩ năng giao tiếp, làm việc nhóm, tác phong công nghiệp.'),
(26, 'Khóa luận tốt nghiệp', 'INT4050', '1', NULL, 6, NULL, 7, '', NULL, 'Có kỹ năng đọc tài liệu thành thạo; có kỹ năng tiến hành nghiên cứu, giải quyết vấn đề; có kỹ năng thực hiện thí nghiệm, đánh giá; có kỹ năng viết báo cáo (luận văn); có kỹ năng trình bày.', NULL, NULL, 1, 2, 'Sinh viên năm cuối đủ điều kiện sẽ được làm khóa luận tốt nghiệp dưới sự hướng dẫn của giảng viên. Theo đó sinh viên cần vận dụng các kiến thức và kỹ năng đã tích lũy được để giải quyết một vấn đề nghiên cứu cơ bản hoặc giải pháp thực tiễn thuộc lĩnh vực CNTT. Việc thực hiện khóa luận tốt nghiệp giúp sinh viên củng cố hoặc có thêm kiến thức và kỹ năng trong hoạt động chuyên môn như: đọc tài liệu, phát triển ý tưởng, lập trình, thực hiện thí nghiệm, đánh giá, viết luận văn, trình bày báo cáo, v.v.');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `tbl_subject_group_type`
--

INSERT INTO `tbl_subject_group_type` (`subject_type_id`, `subject_group_type`, `active`, `detail`, `subject_group`, `subject_dept`, `subject_faculty`) VALUES
(0, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 'Lý luận chính trị', 1, ' <p>\r\n                                        -	Hiểu được hệ thống tri thức khoa học những nguyên lý cơ bản của Chủ nghĩa Mác Lênin; <br/>\r\n                                        -	Hiểu được hệ thống tri thức khoa học những nguyên lý cơ bản của Chủ nghĩa Mác Lênin; <br/>\r\n                                        -	Hiểu được những kiến thức cơ bản, có tính hệ thống về tư tưởng, đạo đức, giá trị văn hóa Hồ Chí Minh, những nội dung cơ bản của Đường lối cách mạng của Đảng Cộng sản Việt Nam, chủ yếu là đường lối trong thời kỳ đổi mới trên một số lĩnh vực cơ bản của đời sống xã hội.<br/>\r\n\r\n                                   </p>', 1, 1, 1),
(2, 'Tin học', 1, '<p>\r\n                                        -	Nhớ và giải thích được các kiến thức cơ bản về thông tin;<br/>\r\n                                        -	Sử dụng được công cụ xử lý thông tin thông dụng (hệ điều hành, các phần mềm hỗ trợ công tác văn phòng và khai thác Internet ...);<br/>\r\n                                        -	Có khả năng phân tích, đánh giá và lập trình một ngôn ngữ lập trình bậc cao (hiểu các cấu trúc điều khiển, các kiểu dữ liệu có cấu trúc, hàm/chương trình con, biến cục bộ/biến toàn cục, vào ra dữ liệu tệp, các bước để xây dựng chương trình hoàn chỉnh);<br/>\r\n                                        -	Có khả năng phân tích, đánh giá phương pháp lập trình hướng thủ tục và lập trình hướng đối tượng; phân biệt được ưu và nhược điểm của hai phương pháp lập trình.<br/>\r\n\r\n                                    </p>', 1, 1, 1),
(3, 'Ngoại ngữ ', 1, '<p>\r\n                                            -	Có thể hiểu được nhiều kiểu văn bản dài, khó và nắm bắt được ngụ ý.<br/>\r\n                                            -	Có thể diễn đạt ý mình một cách trôi chảy, tức thì mà không phải quá vất vả tìm từ.<br/>\r\n                                            -	Có thể sử dụng ngôn ngữ một cách linh hoạt, hiệu quả cho các mục đích xã hội, học tập và chuyên môn.<br/>\r\n                                            -	Có thể tạo ra các văn bản có cấu trúc tốt, rõ ràng, cụ thể về các đề tài phức tạp, cho thấy khả năng kiểm soát tốt các hình thức sắp xếp ý, các liên từ và phương tiện liên kết.<br/>\r\n\r\n                                        </p>', 1, 1, 1),
(4, 'Giáo dục thể chất và quốc phòng an ninh ', 1, '<p>\r\n                                            -	Hiểu và vận dụng những kiến thức khoa học cơ bản trong lĩnh vực thể dục thể thao vào quá trình tập luyện và tự rèn luyện, ngăn ngừa các chấn thương để củng cố và tăng cường sức khỏe. Sử dụng các bài tập phát triển thể lực chung và thể lực chuyên môn đặc thù. Vận dụng những kỹ, chiến thuật cơ bản, luật thi đấu vào các hoạt động thể thao ngoại khóa cộng đồng;<br/>\r\n                                            -	Hiểu được nội dung cơ bản về đường lối quân sự và nhiệm vụ công tác quốc phòng – an ninh của Đảng, Nhà nước trong tình hình mới. Vận dụng kiến thức đã học vào chiến đấu trong điều kiện tác chiến thông thường.<br/>\r\n                                        </p>', 1, 1, 1),
(5, 'Kiến thức chung theo lĩnh vực ', 1, '<ul>\r\n	<li>- Bi&ecirc;́t được c&aacute;c ki&ecirc;́n thức cơ bản v&ecirc;̀ V&acirc;̣t lý cơ, nhi&ecirc;̣t, điện và quang; hi&ecirc;̉u được các hiện tượng và quy luật V&acirc;̣t lý và các ứng dụng li&ecirc;n quan trong khoa học kỹ thu&acirc;̣t và đời s&ocirc;́ng; vận dụng kiến thức đ&ecirc;̉ học t&acirc;̣p và nghi&ecirc;n cứu các m&ocirc;n học kh&aacute;c của c&aacute;c ng&agrave;nh kỹ thuật và c&ocirc;ng nghệ;</li>\r\n	<li>- Nắm được c&aacute;c kiến thức li&ecirc;n quan đến Giải t&iacute;ch to&aacute;n học như t&iacute;nh giới hạn,<br />\r\n	t&iacute;nh đạo h&agrave;m, t&iacute;nh t&iacute;ch ph&acirc;n của c&aacute;c h&agrave;m một biến v&agrave; h&agrave;m nhiều biến;</li>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kiến thức li&ecirc;n quan đến Đại số cao cấp như ma trận v&agrave; c&aacute;c ph&eacute;p biến đổi, giải c&aacute;c hệ phương tr&igrave;nh nhiều biến số...</li>\r\n</ul>', 2, 1, 1),
(6, 'Kiến thức chung của khối ngành', 1, '<ul>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kiến thức li&ecirc;n quan đến cấu tr&uacute;c dữ liệu về mảng, danh s&aacute;ch li&ecirc;n kết, h&agrave;ng đợi, ngăn xếp, c&acirc;y nhị ph&acirc;n, bảng băm;</li>\r\n	<li>- Vận dụng được c&aacute;c thuật to&aacute;n cơ bản li&ecirc;n quan đến sắp xếp, t&igrave;m kiếm v&agrave; c&aacute;c thuật to&aacute;n kh&aacute;c tr&ecirc;n c&aacute;c cấu tr&uacute;c dữ liệu;</li>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kh&aacute;i niệm cơ bản về số phức v&agrave; c&aacute;c loại biểu diễn của số phức;</li>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kh&aacute;i niệm cơ bản của l&yacute; thuyết x&aacute;c suất;</li>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c phương ph&aacute;p ph&acirc;n t&iacute;ch t&iacute;n hiệu, ph&acirc;n t&iacute;ch v&agrave; thiết kế hệ thống tuyến t&iacute;nh trong c&aacute;c miền biểu diễn kh&aacute;c nhau.</li>\r\n</ul>', 3, 1, 1),
(7, 'Kiến thức chung của nhóm ngành ', 1, '<ul>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kiến thức cơ bản về To&aacute;n rời rạc để x&acirc;y dựng c&aacute;c thuật to&aacute;n, tối ưu c&aacute;c giải ph&aacute;p trong c&ocirc;ng nghệ;</li>\r\n	<li>- Sử dụng được một ng&ocirc;n ngữ lập tr&igrave;nh hướng đối tượng, hiểu c&aacute;c kh&aacute;i niệm v&agrave; viết được chương tr&igrave;nh phần mềm theo phương ph&aacute;p hướng đối tượng;</li>\r\n	<li>- Hiểu được cơ chế hoạt động chung của hệ thống m&aacute;y t&iacute;nh, c&aacute;c bộ phận, cấu tr&uacute;c của m&aacute;y t&iacute;nh;</li>\r\n	<li>- Hiểu nguy&ecirc;n l&yacute; cơ bản chung hệ điều h&agrave;nh của m&aacute;y t&iacute;nh;</li>\r\n	<li>- Hiểu c&aacute;c kh&aacute;i niệm cơ bản về mạng m&aacute;y t&iacute;nh, c&aacute;c bộ phận, c&aacute;c giao thức, c&aacute;ch thức truyền dữ liệu tr&ecirc;n mạng;</li>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kh&aacute;i niệm về cơ sở dữ liệu trong hệ thống, c&aacute;c phương ph&aacute;p x&acirc;y dựng v&agrave; tối ưu h&oacute;a cơ sở dữ liệu của hệ thống;</li>\r\n	<li>- Hiểu c&aacute;c kh&aacute;i niệm chung về quy tr&igrave;nh ph&aacute;t triển phần mềm, c&aacute;c kỹ thuật x&acirc;y dựng một hệ thống phần mềm c&oacute; chất lượng.&nbsp;</li>\r\n</ul>', 4, 1, 1),
(8, 'Kiến thức của ngành và bổ trợ', 1, '<ul>\r\n	<li>- Lập tr&igrave;nh th&agrave;nh thạo một số ng&ocirc;n ngữ lập tr&igrave;nh th&ocirc;ng dụng;</li>\r\n	<li>- Vận dụng được c&aacute;c kiến thức về ph&acirc;n t&iacute;ch thiết kế để x&acirc;y dựng y&ecirc;u cầu, tiến h&agrave;nh ph&acirc;n t&iacute;ch v&agrave; thiết kế c&aacute;c hệ thống phần mềm;</li>\r\n	<li>- Vận dụng được c&aacute;c kiến thức về tr&iacute; tuệ nh&acirc;n tạo, học m&aacute;y, xử l&yacute; ng&ocirc;n ngữ tự nhi&ecirc;n, v.v. để x&acirc;y dựng c&aacute;c chương tr&igrave;nh c&oacute; khả năng xử l&yacute; th&ocirc;ng minh cho nhiều loại dữ liệu kh&aacute;c nhau như văn bản, tiếng n&oacute;i, ảnh, sinh học;</li>\r\n	<li>- Nắm được c&aacute;c vấn đề hiện đại v&agrave; c&oacute; khả năng đi s&acirc;u v&agrave;o nghi&ecirc;n cứu lĩnh vực truyền th&ocirc;ng đa phương tiện, c&oacute; thể thiết kế v&agrave; x&acirc;y dựng c&aacute;c ứng dụng về truyền th&ocirc;ng đa phương tiện;</li>\r\n	<li>- Hiểu c&aacute;c nguy&ecirc;n l&yacute; cơ bản của đồ họa m&aacute;y t&iacute;nh hiện đại, hiểu kiến thức h&igrave;nh học b&ecirc;n dưới c&aacute;c m&ocirc; h&igrave;nh 3 chiều, hiểu vấn đề hiệu năng khi vẽ c&aacute;c m&ocirc; h&igrave;nh 3D;</li>\r\n	<li>- Nắm vững kiến thức về l&yacute; thuyết th&ocirc;ng tin để c&oacute; thể &aacute;p dụng trong c&aacute;c b&agrave;i to&aacute;n về suy diễn thống k&ecirc;, truyền th&ocirc;ng, n&eacute;n dữ liệu, v.v.;</li>\r\n	<li>- Biết c&aacute;ch cập nhật c&aacute;c kiến thức hiện đại trong ng&agrave;nh Khoa học m&aacute;y t&iacute;nh;</li>\r\n	<li>- Biết tối ưu h&oacute;a hệ thống th&ocirc;ng qua c&aacute;c kiến thức bổ trợ về c&aacute;c ng&agrave;nh kh&aacute;c li&ecirc;n quan đến Khoa học m&aacute;y t&iacute;nh;</li>\r\n	<li>- Biết c&aacute;c kỹ thuật, c&aacute;c c&ocirc;ng nghệ mới trong ng&agrave;nh Khoa học m&aacute;y t&iacute;nh, ứng dụng trong ph&aacute;t triển c&aacute;c phần mềm đặc biệt, bảo đảm chất lượng v&agrave; an to&agrave;n, an ninh cho hệ thống.</li>\r\n</ul>', 5, 1, 1),
(9, 'Llý luận chính trị', 1, '<ul>\r\n	<li>- Hiểu được hệ thống tri thức khoa học những nguy&ecirc;n l&yacute; cơ bản của Chủ nghĩa M&aacute;c L&ecirc;nin;</li>\r\n	<li>- Hiểu được những kiến thức cơ bản, c&oacute; t&iacute;nh hệ thống về tư tưởng, đạo đức, gi&aacute; trị văn h&oacute;a Hồ Ch&iacute; Minh, những nội dung cơ bản của Đường lối c&aacute;ch mạng của Đảng Cộng sản Việt Nam, chủ yếu l&agrave; đường lối trong thời kỳ đổi mới tr&ecirc;n một số lĩnh vực cơ bản của đời sống x&atilde; hội.</li>\r\n</ul>', 1, 2, 1),
(10, 'Tin học', 1, '<ul>\r\n	<li>- Nhớ v&agrave; giải th&iacute;ch được c&aacute;c kiến thức cơ bản về th&ocirc;ng tin;</li>\r\n	<li>- Sử dụng được c&ocirc;ng cụ xử l&yacute; th&ocirc;ng tin th&ocirc;ng dụng (hệ điều h&agrave;nh, c&aacute;c phần mềm hỗ trợ c&ocirc;ng t&aacute;c văn ph&ograve;ng v&agrave; khai th&aacute;c Internet ...);</li>\r\n	<li>- C&oacute; khả năng ph&acirc;n t&iacute;ch, đ&aacute;nh gi&aacute; v&agrave; lập tr&igrave;nh một ng&ocirc;n ngữ lập tr&igrave;nh bậc cao (hiểu c&aacute;c cấu tr&uacute;c điều khiển, c&aacute;c kiểu dữ liệu c&oacute; cấu tr&uacute;c, h&agrave;m/chương tr&igrave;nh con, biến cục bộ/biến to&agrave;n cục, v&agrave;o ra dữ liệu tệp, c&aacute;c bước để x&acirc;y dựng chương tr&igrave;nh ho&agrave;n chỉnh);</li>\r\n	<li>- C&oacute; khả năng ph&acirc;n t&iacute;ch, đ&aacute;nh gi&aacute; phương ph&aacute;p lập tr&igrave;nh hướng thủ tục v&agrave; lập tr&igrave;nh hướng đối tượng; ph&acirc;n biệt được ưu v&agrave; nhược điểm của hai phương ph&aacute;p lập tr&igrave;nh.</li>\r\n</ul>', 1, 2, 1),
(11, 'Ngoại ngữ ', 1, '<ul>\r\n	<li>- Hiểu được c&aacute;c &yacute; ch&iacute;nh của một diễn ng&ocirc;n ti&ecirc;u chuẩn, r&otilde; r&agrave;ng về c&aacute;c vấn đề quen thuộc trong c&ocirc;ng việc, trường học, giải tr&iacute;, v.v.</li>\r\n	<li>- Xử l&yacute; hầu hết c&aacute;c t&igrave;nh huống c&oacute; thể xảy ra khi đi đến nơi sử dụng ng&ocirc;n ngữ;</li>\r\n	<li>- Viết đơn giản những li&ecirc;n kết về c&aacute;c chủ đề quen thuộc hoặc c&aacute; nh&acirc;n quan t&acirc;m;</li>\r\n	<li>- M&ocirc; tả được những kinh nghiệm, sự kiện, giấc mơ, hy vọng v&agrave; ho&agrave;i b&atilde;o v&agrave; c&oacute; thể tr&igrave;nh b&agrave;y ngắn gọn c&aacute;c l&yacute; do, giải th&iacute;ch cho &yacute; kiến v&agrave; kế hoạch của m&igrave;nh;</li>\r\n	<li>- Viết văn bản r&otilde; r&agrave;ng, chi tiết với nhiều chủ đề kh&aacute;c nhau v&agrave; c&oacute; thể giải th&iacute;ch quan điểm của m&igrave;nh về một vấn đề, n&ecirc;u ra được những ưu điểm, nhược điểm của c&aacute;c phương &aacute;n lựa chọn kh&aacute;c nhau.</li>\r\n</ul>', 1, 2, 1),
(12, 'Giáo dục thể chất và quốc phòng an ninh', 1, '<ul>\r\n	<li>- Hiểu v&agrave; vận dụng những kiến thức khoa học cơ bản trong lĩnh vực thể dục thể thao v&agrave;o qu&aacute; tr&igrave;nh tập luyện v&agrave; tự r&egrave;n luyện, ngăn ngừa c&aacute;c chấn thương để củng cố v&agrave; tăng cường sức khỏe. Sử dụng c&aacute;c b&agrave;i tập ph&aacute;t triển thể lực chung v&agrave; thể lực chuy&ecirc;n m&ocirc;n đặc th&ugrave;. Vận dụng những kỹ, chiến thuật cơ bản, luật thi đấu v&agrave;o c&aacute;c hoạt động thể thao ngoại kh&oacute;a cộng đồng;</li>\r\n	<li>- Hiểu được nội dung cơ bản về đường lối qu&acirc;n sự v&agrave; nhiệm vụ c&ocirc;ng t&aacute;c quốc ph&ograve;ng &ndash; an ninh của Đảng, Nh&agrave; n&shy;ước trong t&igrave;nh h&igrave;nh mới. Vận dụng kiến thức đ&atilde; học v&agrave;o chiến đấu trong điều kiện t&aacute;c chiến th&ocirc;ng thường.</li>\r\n</ul>\r\n', 1, 2, 1),
(13, 'Kiến thức chung theo lĩnh vực', 1, '<ul>\r\n	<li>- Bi&ecirc;́t được c&aacute;c ki&ecirc;́n thức cơ bản v&ecirc;̀ V&acirc;̣t lý cơ, nhi&ecirc;̣t, điện và quang; hi&ecirc;̉u được các hiện tượng và quy luật V&acirc;̣t lý và các ứng dụng li&ecirc;n quan trong khoa học kỹ thu&acirc;̣t và đời s&ocirc;́ng; vận dụng kiến thức đ&ecirc;̉ học t&acirc;̣p và nghi&ecirc;n cứu các m&ocirc;n học kh&aacute;c của c&aacute;c ng&agrave;nh kỹ thuật và c&ocirc;ng nghệ;</li>\r\n	<li>- Nắm được c&aacute;c kiến thức li&ecirc;n quan đến Giải t&iacute;ch to&aacute;n học như t&iacute;nh giới hạn,<br />\r\n	t&iacute;nh đạo h&agrave;m, t&iacute;nh t&iacute;ch ph&acirc;n của c&aacute;c h&agrave;m một biến v&agrave; h&agrave;m nhiều biến;</li>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kiến thức li&ecirc;n quan đến Đại số cao cấp như ma trận v&agrave; c&aacute;c ph&eacute;p biến đổi, giải c&aacute;c hệ phương tr&igrave;nh nhiều biến số...</li>\r\n</ul>\r\n', 2, 2, 1),
(14, 'Kiến thức chung của khối ngành', 1, '<ul>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kiến thức li&ecirc;n quan đến cấu tr&uacute;c dữ liệu về mảng, danh s&aacute;ch li&ecirc;n kết, h&agrave;ng đợi, ngăn xếp, c&acirc;y nhị ph&acirc;n, bảng băm;</li>\r\n	<li>- Vận dụng được c&aacute;c thuật to&aacute;n cơ bản li&ecirc;n quan đến sắp xếp, t&igrave;m kiếm v&agrave; c&aacute;c thuật to&aacute;n kh&aacute;c tr&ecirc;n c&aacute;c cấu tr&uacute;c dữ liệu;</li>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kh&aacute;i niệm cơ bản về số phức v&agrave; c&aacute;c loại biểu diễn của số phức;</li>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kh&aacute;i niệm cơ bản của l&yacute; thuyết x&aacute;c suất;</li>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c phương ph&aacute;p ph&acirc;n t&iacute;ch t&iacute;n hiệu, ph&acirc;n t&iacute;ch v&agrave; thiết kế hệ thống tuyến t&iacute;nh trong c&aacute;c miền biểu diễn kh&aacute;c nhau.</li>\r\n</ul>', 3, 2, 1),
(15, 'Kiến thức chung của nhóm ngành ', 1, '<ul>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kiến thức cơ bản về To&aacute;n rời rạc để x&acirc;y dựng c&aacute;c thuật to&aacute;n, tối ưu c&aacute;c giải ph&aacute;p trong c&ocirc;ng nghệ;</li>\r\n	<li>- Sử dụng được một ng&ocirc;n ngữ lập tr&igrave;nh hướng đối tượng, hiểu c&aacute;c kh&aacute;i niệm v&agrave; viết được chương tr&igrave;nh phần mềm theo phương ph&aacute;p hướng đối tượng;</li>\r\n	<li>- Hiểu được cơ chế hoạt động chung của hệ thống m&aacute;y t&iacute;nh, c&aacute;c bộ phận, cấu tr&uacute;c của m&aacute;y t&iacute;nh;</li>\r\n	<li>- Hiểu nguy&ecirc;n l&yacute; cơ bản chung hệ điều h&agrave;nh của m&aacute;y t&iacute;nh;</li>\r\n	<li>- Hiểu c&aacute;c kh&aacute;i niệm cơ bản về mạng m&aacute;y t&iacute;nh, c&aacute;c bộ phận, c&aacute;c giao thức, c&aacute;ch thức truyền dữ liệu tr&ecirc;n mạng;</li>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kh&aacute;i niệm về cơ sở dữ liệu trong hệ thống, c&aacute;c phương ph&aacute;p x&acirc;y dựng v&agrave; tối ưu h&oacute;a cơ sở dữ liệu của hệ thống;</li>\r\n	<li>- Hiểu c&aacute;c kh&aacute;i niệm chung về quy tr&igrave;nh ph&aacute;t triển phần mềm, c&aacute;c kỹ thuật x&acirc;y dựng một hệ thống phần mềm c&oacute; chất lượng.&nbsp;</li>\r\n</ul>', 4, 2, 1),
(16, 'Kiến thức của ngành và bổ trợ', 1, '<ul>\r\n	<li>- Lập tr&igrave;nh th&agrave;nh thạo một số ng&ocirc;n ngữ lập tr&igrave;nh th&ocirc;ng dụng;</li>\r\n	<li>- Vận dụng c&aacute;c kiến thức về ph&acirc;n t&iacute;ch thiết kế để x&acirc;y dựng y&ecirc;u cầu, tiến h&agrave;nh ph&acirc;n t&iacute;ch v&agrave; thiết kế c&aacute;c hệ thống phần mềm;</li>\r\n	<li>- Vận dụng việc x&acirc;y dựng cơ sở dữ liệu cho hệ thống, sử dụng c&aacute;c c&ocirc;ng cụ để quản trị c&aacute;c hệ cơ sở dữ liệu;</li>\r\n	<li>- Biết lập tr&igrave;nh c&aacute;c ứng dụng tr&ecirc;n m&ocirc;i trường web;</li>\r\n	<li>- Biết v&agrave; vận dụng c&aacute;c kỹ thuật thiết kế giao diện người d&ugrave;ng trong x&acirc;y dựng hệ thống phần mềm;</li>\r\n	<li>- Biết c&aacute;ch cập nhật c&aacute;c kiến thức hiện đại trong ng&agrave;nh C&ocirc;ng nghệ th&ocirc;ng tin</li>\r\n	<li>- Biết tối ưu h&oacute;a hệ thống th&ocirc;ng qua c&aacute;c kiến thức bổ trợ về c&aacute;c ng&agrave;nh kh&aacute;c li&ecirc;n quan đến C&ocirc;ng nghệ th&ocirc;ng tin;</li>\r\n	<li>- Biết c&aacute;c kỹ thuật, c&aacute;c c&ocirc;ng nghệ mới trong ng&agrave;nh C&ocirc;ng nghệ th&ocirc;ng tin, ứng dụng trong ph&aacute;t triển c&aacute;c phần mềm đặc biệt, bảo đảm chất lượng v&agrave; an to&agrave;n, an ninh cho hệ thống.</li>\r\n</ul>', 5, 2, 1),
(34, 'Kiến thức thực tập và tốt nghiệp', 1, '<ul>\r\n	<li>- Biết l&agrave;m việc trong m&ocirc;i trường thực tế;</li>\r\n	<li>- Biết nghi&ecirc;n cứu, x&acirc;y dựng sản phẩm phục vụ cho mục đ&iacute;ch khoa học hoặc đời sống;</li>\r\n	<li>- Biết tr&igrave;nh b&agrave;y &lrm;&yacute; tưởng dưới dạng một b&aacute;o c&aacute;o khoa học.</li>\r\n</ul>', 6, 1, 1),
(35, 'Kiến thức thực tập và tốt nghiệp', 1, '<ul>\r\n	<li>- Biết l&agrave;m việc trong m&ocirc;i trường thực tế;</li>\r\n	<li>- Biết nghi&ecirc;n cứu, x&acirc;y dựng sản phẩm phục vụ cho mục đ&iacute;ch khoa học hoặc đời sống;</li>\r\n	<li>- Biết tr&igrave;nh b&agrave;y &lrm;&yacute; tưởng dưới dạng một b&aacute;o c&aacute;o khoa học.</li>\r\n</ul>\r\n', 6, 2, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_subject_type`
--

INSERT INTO `tbl_subject_type` (`id`, `subject_type_name`, `is_active`) VALUES
(1, 'Khối kiến thức chung', 1),
(2, 'Khối kiến thức chung theo lĩnh vực', 1),
(3, 'Khối kiến thức chung cho khối ngành', 1),
(4, 'Khối kiến thức chung cho nhóm ngành', 1),
(5, 'Khối kiến thức ngành và bổ trợ', 1),
(6, 'Kiến thức thực tập và tốt nghiệp', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher`
--

CREATE TABLE IF NOT EXISTS `tbl_teacher` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_name` varchar(45) DEFAULT NULL,
  `teacher_personal_page` varchar(45) DEFAULT NULL,
  `teacher_avatar` varchar(200) DEFAULT NULL,
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
(1, 'PGS. TS. Phạm Bảo Sơn', NULL, 'http://www.olp.vn/_/rsrc/1388994770308/olympic/HDGK%20phat%20bieu_Thay%20Pham%20Bao%20Son%20New.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1);

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
(1, 1, NULL, 1, 'Chủ nhiệm Khoa Công nghệ Thông tin');

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
