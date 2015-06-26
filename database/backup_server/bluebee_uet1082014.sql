-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 10, 2014 at 02:37 PM
-- Server version: 5.1.73-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bluebee_uet`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `subject_general_faculty_id` int(5) NOT NULL,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `tbl_doc`
--

INSERT INTO `tbl_doc` (`doc_id`, `doc_url`, `doc_name`, `doc_scribd_id`, `doc_description`, `doc_title`, `doc_status`, `doc_author`, `doc_type`, `doc_path`, `subject_dept`, `subject_type`, `subject_faculty`, `doc_author_name`, `doc_publisher`, `subject_general_faculty_id`) VALUES
(1, 'http://imgv2-2.scribdassets.com/img/word_document/236136275/180x220/d97bc0346f/1407416290', 'Tài liệu đại số - Gilbert Strang.pdf', '236136275', 'Tài liệu đại số - Gilbert Strang - dành cho lớp thầy Đô', NULL, '1', '6', 2, 'http://bluebee-uet.com/uploads/document/user_id_6/[Strang_G.]_Linear_algebra_and_its_applications(Bookos.org)[1].pdf', 1, 2, 1, 'Nguyễn Thế Huy', NULL, 1),
(3, 'http://imgv2-2.scribdassets.com/img/word_document/236136467/180x220/6bf2a157e5/1407416474', 'Yii Application Development Cookbook, 2nd Edition.pdf', '236136467', 'Yii Application Development Cookbook, 2nd Edition', NULL, '1', '7', 2, 'http://bluebee-uet.com/uploads/document/user_id_7/Yii Application Development Cookbook, 2nd Edition.pdf', 1, 4, 1, 'Sơn Vũ', NULL, 0),
(5, 'http://imgv2-2.scribdassets.com/img/word_document/236150376/180x220/3d4e848973/1407426939', 'Đề thi mẫu cuối kì môn Cấu trúc dữ liệu và giải thuật.pdf', '236150376', 'Đề thi mẫu cuối kì môn Cấu trúc dữ liệu và giải thuật', NULL, '1', '6', 2, 'http://bluebee-uet.com/uploads/document/user_id_6/int2203_thicuoiky_1112Sem1.pdf', 1, 3, 1, 'Nguyễn Thế Huy', NULL, 1),
(6, 'http://imgv2-4.scribdassets.com/img/word_document/236150416/180x220/ae6b6f44a6/1407426979', 'Đáp án đề thi môn cấu trúc dữ liệu và giải thuật.pdf', '236150416', 'Đáp án đề thi mẫu cuối kì môn cấu trúc dữ liệu và giải thuật', NULL, '1', '6', 2, 'http://bluebee-uet.com/uploads/document/user_id_6/int2203_thicuoiky_dapan_1213Sem1.pdf', 1, 3, 1, 'Nguyễn Thế Huy', NULL, 1),
(7, 'http://imgv2-3.scribdassets.com/img/word_document/236150639/180x220/92df8a58b2/1407427138', 'Đáp án đề thi mẫu môn Kiến trúc máy tính.pdf', '236150639', 'Đáp án đề thi mẫu môn Kiến trúc máy tính', NULL, '1', '6', 2, 'http://bluebee-uet.com/uploads/document/user_id_6/Sample Exam Result.pdf', 1, 4, 1, 'Nguyễn Thế Huy', NULL, 0),
(9, 'http://imgv2-3.scribdassets.com/img/word_document/236222418/180x220/cdd5979c93/1407503078', 'Module on Complex Numbers.pptx', '236222418', 'Module on Complex Numbers', NULL, '1', '8', 2, 'http://bluebee-uet.com/uploads/document/user_id_8/Module on Complex Numbers.pptx', 1, 2, 1, 'Phan Thành', NULL, 1),
(14, 'http://imgv2-1.scribdassets.com/img/word_document/236234165/180x220/2c224148a9/1407512862', 'Slide 1 môn THCS 4 - CA.pdf', '236234165', 'Slide 1 môn Tin học cơ sở 4 - Thầy Phạm Bảo Sơn - dành cho lớp CA', NULL, '1', '6', 2, 'http://bluebee-uet.com/uploads/document/user_id_6/Lecture01-Intro.pdf', 1, 1, 1, 'Nguyễn Thế Huy', NULL, 1),
(19, 'http://imgv2-3.scribdassets.com/img/word_document/236237677/180x220/bef7acd4b1/1407515856', 'Struct - THCS 4.pdf', '236237677', 'Struct - THCS 4 - Thầy Phạm Bảo Sơn - CA', NULL, '1', '6', 2, 'http://bluebee-uet.com/uploads/document/user_id_6/Lecture07_Structures.pdf', 1, 1, 1, 'Nguyễn Thế Huy', NULL, 1),
(20, 'http://imgv2-1.scribdassets.com/img/word_document/236277879/180x220/99e4644b9b/1407545377', 'baig .doc', '236277879', 'dfdsfdsg', NULL, '1', '28', 2, 'http://bluebee-uet.com/uploads/document/user_id_28/Bai bao.doc', 1, 1, 1, 'Hiep Pham Van', NULL, 1),
(21, 'http://imgv2-2.scribdassets.com/img/word_document/236280745/180x220/88f1caa12d/1407547909', 'Kien truc may tinh.pdf', '236280745', 'Diem thi', NULL, '1', '29', 2, 'http://bluebee-uet.com/uploads/document/user_id_29/kien truc may tinh_int2205 4.pdf', 1, 4, 1, 'Luong Nguyen', NULL, 1),
(23, 'http://imgv2-1.scribdassets.com/img/word_document/236310246/180x220/1cf7ee9278/1407574035', 'proloser_angularjs.pdf', '236310246', 'proloser_angularjs', NULL, '1', '7', 2, 'http://bluebee-uet.com/uploads/document/user_id_7/proloser_angularjs.pdf', 1, 4, 1, 'Sơn Vũ', NULL, 1),
(24, 'http://imgv2-3.scribdassets.com/img/word_document/236310299/180x220/e22f331fb6/1407574064', 'jquery-introduction.pdf', '236310299', 'jquery-introduction', NULL, '1', '7', 2, 'http://bluebee-uet.com/uploads/document/user_id_7/jquery-introduction.pdf', 2, 5, 1, 'Sơn Vũ', NULL, 0),
(25, '/themes/classic/assets/img/document.png', 'Tuyển tập các bài tập C.rar', NULL, 'Tuyển tập các bài tập C, bao gồm hầu hết các dạng bài cơ bản liên quan đến lập trình C', NULL, '1', '6', 3, 'http://bluebee-uet.com/uploads/document/user_id_6/Duong.rar', 1, 1, 1, 'Nguyễn Thế Huy', NULL, 1),
(26, 'http://imgv2-1.scribdassets.com/img/word_document/236350269/180x220/c4a2b28972/1407596251', 'Notes on Discrete Mathematics - Miguel A. Lerma.pdf', '236350269', 'An useful document for Discrete Mathematics course', NULL, '1', '39', 2, 'http://bluebee-uet.com/uploads/document/user_id_39/discrete_mathematics-2005.pdf', 1, 6, 1, 'Đại Thành', NULL, 0),
(27, 'http://imgv2-2.scribdassets.com/img/word_document/236386302/180x220/f98cd8757c/1407632458', 'tin học cơ sở 4 silde 1.ppt', '236386302', 'silde 1 nhé', NULL, '1', '43', 2, 'http://bluebee-uet.com/uploads/document/user_id_43/Slide1_Introduction.ppt', 1, 1, 1, 'Arsene Tuấn Nguyễn', NULL, 1),
(28, 'http://bluebee-uet.com/uploads/document/user_id_6/1379421_316229501850728_608931035_n.jpg', 'Đề thi Giải tích 1 - Thầy Ngoạn', NULL, 'Đề thi Giải tích 1 - Lớp thầy Ngoạn', NULL, '1', '6', 1, 'http://bluebee-uet.com/uploads/document/user_id_6/1379421_316229501850728_608931035_n.jpg', 1, 2, 1, 'Nguyễn Thế Huy', NULL, 1),
(29, 'http://imgv2-1.scribdassets.com/img/word_document/236386796/180x220/57ab42fd05/1407633375', 'Slide 2 - THCS 4.ppt', '236386796', 'Slide 2 THCS 4', NULL, '1', '11', 2, 'http://bluebee-uet.com/uploads/document/user_id_11/Slide2_Language Programming.ppt', 1, 1, 1, 'Nguyễn Văn Khánh', NULL, 1);

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
  `subject_general_faculty_id` int(3) DEFAULT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `tbl_subject`
--

INSERT INTO `tbl_subject` (`subject_id`, `subject_name`, `subject_code`, `subject_active`, `subject_university`, `subject_type`, `subject_year`, `subject_credits`, `subject_credit_hour`, `subject_requirement`, `subject_target`, `subject_info`, `subject_test`, `subject_faculty`, `subject_dept`, `subject_content`, `subject_general_faculty_id`) VALUES
(1, 'Những nguyên lý cơ bản của chủ nghĩa Mác – Lênin 1', 'PHI1004', '1', NULL, 1, NULL, 2, '21 - 5 - 4', 'Dùng cho sinh viên khối không chuyên ngành Mác-Lênin, tư tưởng Hồ Chí Minh trình độ đại học, cao đẳng.', '<p>M&ocirc;n học Những nguy&ecirc;n l&yacute; cơ bản của chủ nghĩa M&aacute;c-L&ecirc;nin nhằm gi&uacute;p cho sinh vi&ecirc;n:</p>\r\n\r\n<p>- X&aacute;c lập cơ sở l&yacute; luận cơ bản nhất để từ đ&oacute; c&oacute; thể tiếp cận được nội dung m&ocirc;n học Tư tưởng Hồ Ch&iacute; Minh v&agrave; Đường lối c&aacute;ch mạng của Đảng Cộng sản Việt Nam, hiểu biết nền tảng tư tưởng của Đảng;</p>\r\n\r\n<p>- X&acirc;y dựng niềm tin, l&yacute; tưởng c&aacute;ch mạng cho sinh vi&ecirc;n;</p>\r\n\r\n<p>- Từng bước x&aacute;c lập thế giới quan, nh&acirc;n sinh quan v&agrave; phương ph&aacute;p luận chung nhất để tiếp cận c&aacute;c khoa học chuy&ecirc;n ng&agrave;nh được đ&agrave;o tạo.</p>', NULL, NULL, 1, 1, 'Ngoài 1 chương mở đầu nhằm giới thiệu khái lược về chủ nghĩa Mác-Lênin và một số vấn đề chung của môn học. Căn cứ vào mục tiêu môn học, nội dung chương trình môn học được cấu trúc thành 3 phần, 9 chương: Phần thứ nhất có 3 chương bao quát những nội dung cơ bản về thế giới quan và phương pháp luận của chủ nghĩa Mác-Lênin; phần thứ hai có 3 chương trình bày ba nội dung trọng tâm thuộc học thuyết kinh tế của chủ nghĩa Mác-Lênin về phương thức sản xuất tư bản chủ nghĩa; phần thứ ba có 3 chương, trong đó có 2 chương khái quát những nội dung cơ bản thuộc lý luận của chủ nghĩa Mác-Lênin về chủ nghĩa xã hội và 1 chương khái quát chủ nghĩa xã hội hiện thực và triển vọng.', 1),
(2, 'Những nguyên lý cơ bản của chủ nghĩa Mác – Lênin 2', 'PHI1004', '1', NULL, 1, NULL, 3, '32 - 8 - 5 ', 'Dùng cho sinh viên khối không chuyên ngành Mác-Lênin, tư tưởng Hồ Chí Minh trình độ đại học, cao đẳng.', '<p>M&ocirc;n học Những nguy&ecirc;n l&yacute; cơ bản của chủ nghĩa M&aacute;c-L&ecirc;nin nhằm gi&uacute;p cho sinh vi&ecirc;n:</p>\r\n\r\n<p>- X&aacute;c lập cơ sở l&yacute; luận cơ bản nhất để từ đ&oacute; c&oacute; thể tiếp cận được nội dung m&ocirc;n học Tư tưởng Hồ Ch&iacute; Minh v&agrave; Đường lối c&aacute;ch mạng của Đảng Cộng sản Việt Nam, hiểu biết nền tảng tư tưởng của Đảng;</p>\r\n\r\n<p>- X&acirc;y dựng niềm tin, l&yacute; tưởng c&aacute;ch mạng cho sinh vi&ecirc;n;</p>\r\n\r\n<p>- Từng bước x&aacute;c lập thế giới quan, nh&acirc;n sinh quan v&agrave; phương ph&aacute;p luận chung nhất để tiếp cận c&aacute;c khoa học chuy&ecirc;n ng&agrave;nh được đ&agrave;o tạo.</p>', NULL, NULL, 1, 1, 'Ngoài 1 chương mở đầu nhằm giới thiệu khái lược về chủ nghĩa Mác-Lênin và một số vấn đề chung của môn học. Căn cứ vào mục tiêu môn học, nội dung chương trình môn học được cấu trúc thành 3 phần, 9 chương: Phần thứ nhất có 3 chương bao quát những nội dung cơ bản về thế giới quan và phương pháp luận của chủ nghĩa Mác-Lênin; phần thứ hai có 3 chương trình bày ba nội dung trọng tâm thuộc học thuyết kinh tế của chủ nghĩa Mác-Lênin về phương thức sản xuất tư bản chủ nghĩa; phần thứ ba có 3 chương, trong đó có 2 chương khái quát những nội dung cơ bản thuộc lý luận của chủ nghĩa Mác-Lênin về chủ nghĩa xã hội và 1 chương khái quát chủ nghĩa xã hội hiện thực và triển vọng.', 1),
(3, 'Đại số', 'MAT1093', '1', NULL, 2, NULL, 4, '45 - 15', NULL, '<p>- Trang bị cho sinh vi&ecirc;n những kh&aacute;i niệm v&agrave; kỹ năng cơ bản nhất của Đại số tuyến t&iacute;nh một trong những m&ocirc;n cơ sở của To&aacute;n học, tạo điều kiện để học tập, nghi&ecirc;n cứu c&aacute;c m&ocirc;n học kh&aacute;c.</p>\r\n\r\n<p>- Gi&uacute;p sinh vi&ecirc;n hiểu được c&aacute;c kiến thức cơ bản của Đại số tuyến t&iacute;nh, li&ecirc;n hệ với những kiến thức đ&atilde; học ở bậc phổ th&ocirc;ng, biết c&aacute;ch tự hệ thống ho&aacute; kiến thức, t&igrave;m t&ograve;i mở rộng th&ecirc;m c&aacute;c kiến thức cơ bản để phục vụ c&ocirc;ng t&aacute;c sau n&agrave;y.</p>', NULL, NULL, 1, 1, 'Đại số tuyến tính là một trong những môn học đầu tiên của Toán học trừu tượng, sinh viên cần nắm vững các khái niệm, hình dung chính xác các khái niệm đó trong những tình huống cụ thể, biết vận dụng các kết quả mới. Phần đầu chương trình ôn tập lại các khái niệm về tập hợp và ánh xạ, sau đó giới thiệu một số cấu trúc đại số như nhóm, vành, trường. Một thời lượng đáng kể dành cho việc giới thiệu trường số phức, các tính chất của số phức, đa thức và phân thức hữu tỉ thực. Chương III là lý thuyết về ma trận, định thức và hệ phương trình tuyến tính. Ở chương này sinh viên sẽ được ôn lại cách giải hệ phương trình tuyến tính đã học từ chương trình phổ thông. Tuy vậy toàn bộ lý thuyết sẽ được trình bày một cách có hệ thống và ở một ngôn ngữ tổng quát. Chương IV gồm những vấn đề cơ bản của không gian véc tơ, không gian Euclid. Đây có thể coi như những tổng quát hóa lên trường hợp nhiều chiều của các khái niệm mặt phẳng toạ độ, hệ toạ độ trong không gian mà sinh viên đã nắm vững từ bậc phổ thông. Chương V khảo sát một số tính chất quan trọng của ánh xạ tuyến tính, toán tử tuyến tính trong không gian véc tơ hữu hạn chiều, phép biến đổi trực giao, dạng song tuyến tính, dạng toàn phương toán tử tự liên hợp (hay phép biến đổi đối xứng). Chương VI dành cho áp dụng lí thuyết không gian véc tơ Euclid, dạng toàn phương vào việc khảo sát một số vấn đề của hình học giải tích như phân loại các đường bậc hai, mặt bậc hai.', 1),
(4, 'Giải tích 1', 'MAT1094', '1', NULL, 2, NULL, 5, '50 - 25', NULL, '<p>- Trang bị cho sinh vi&ecirc;n những kh&aacute;i niệm v&agrave; cơ bản nhất Giải t&iacute;ch một biến số, một trong những m&ocirc;n cơ sở của To&aacute;n học, tạo điều kiện để học tập, nghi&ecirc;n cứu c&aacute;c m&ocirc;n học kh&aacute;c.</p>\r\n\r\n<p>- Gi&uacute;p sinh vi&ecirc;n hiểu được c&aacute;c kiến thức cơ bản của Giải t&iacute;ch một biến số, li&ecirc;n hệ với những kiến thức đ&atilde; học ở bậc phổ th&ocirc;ng, biết c&aacute;ch tự hệ thống ho&aacute; kiến thức, t&igrave;m t&ograve;i mở rộng th&ecirc;m c&aacute;c kiến thức cơ bản để phục vụ c&ocirc;ng t&aacute;c sau n&agrave;y.</p>', NULL, NULL, 1, 1, 'Môn học giới thiệu các khái niệm về tập hợp và ánh xạ, giới hạn của dãy số và hàm số, hàm liên tục và hàm sơ cấp, các hàm ngược và hàm hyperbolic, các khái niệm về đạo hàm và vi phân của hàm một biến, các định lí cơ bản về hàm khả vi, nguyên hàm và tích phân, tích phân suy rộng với cận vô hạn hoặc với hàm không bị chặn, lí thuyết về chuỗi số, chuỗi hàm tổng quát, chuỗi lũy thừa và chuỗi Fourier.', 1),
(5, 'Tín hiệu và hệ thống', 'ELT2035', '1', NULL, 3, NULL, 3, '42 - 3', NULL, 'Các khái niệm cơ sở về các loại tín hiệu và hệ thống tuyến tính bất biến, các phương pháp biểu diễn và phân tích tín hiệu và hệ thống tuyến tính bất biến; sử dụng các phương pháp và các công cụ tính toán cho việc biểu diễn và phân tích tín hiệu và hệ thống, phân tích, giải quyết và trình bày các vấn đề có liên quan tới chủ đề của môn học.', NULL, NULL, 1, 1, 'Phân loại tín hiệu và hệ thống, các loại tín hiệu cơ sở, các mô hình hệ thống, biểu diễn hệ thống tuyến tính bất biến trong miền thời gian, biểu diễn Fourier và áp dụng cho tín hiệu và hệ thống tuyến tính bất biến, biến đổi Laplace và áp dụng cho phân tích hệ thống tuyến tính bất biến liên tục, biến đổi Z và áp dụng cho phân tích hệ thống tuyến tính bất biến rời rạc.', 1),
(6, 'Cấu trúc dữ liệu và giải thuật', 'INT2203', '1', NULL, 3, NULL, 3, '30 - 15', NULL, 'Biết mô tả và cài đặt được các cấu trúc dữ liệu đơn giản như mảng, bản ghi, hàng đợi, găn xếp, ...; biết mô tả và cài đặt được các cấu trúc dữ liệu phức tạp như cây, mảng băm; biết mô tả và cài đặt được các thuật toán sắp xếp, tìm kiếm; biết mô tả và cài đặt được các thuật trên đồ thị như thuật toán tìm đường đi ngắn nhất, thuật toán tìm các thành phần liên thông, các thuật toán tìm kiếm và duyệt trên cây và đồ thị; có khả năng ứng dụng các cấu trúc dữ liệu và giải thuật để giải quyết các bài toán trong CNTT.', NULL, NULL, 1, 1, 'Môn học cung cấp các kiến thức nền tảng về các cấu trúc dữ liệu cũng như các thuật toán cho sinh viên. Phần đầu của môn học, sinh viên được học các cấu trúc dữ liệu cơ bản như hàng đợi, ngăn xếp cho đến các cấu trúc dữ liệu phức tạp như cây,  mảng băm. Phần còn lại của môn học trang bị cho sinh viên các thuật toán từ đơn giản đến phức tạp để giải quyết một loạt các bài toán cơ bản như sắp xếp, tìm kiếm, các bài toán trên đồ thị hay trên cây.', 1),
(7, 'Lập trình hướng đổi tượng', 'INT2204', '1', NULL, 4, NULL, 3, '30 - 15', NULL, 'Hiểu các nguyên lý cơ bản của thiết kế hướng đối tượng; hiểu các vấn đề căn bản và một số vấn đề nâng cao trong việc viết các lớp và phương thức như bản chất của đối tượng và tham chiếu đối tượng, dữ liệu và quyền truy nhập, biến và phạm vi; hiểu các quan niệm nằm sau cây thừa kế, đa hình, và việc lập trình theo interface; hiểu nguyên lý hoạt động của các ngoại lệ và các dòng vào ra cơ bản; hắm được khái niệm căn bản về lập trình tổng quát và làm quen với các cấu trúc dữ liệu tổng quát; hó khả năng đưa ra một giải pháp lập trình hướng đối tượng cho các bài toán ở quy mô tương đối đơn giản; hiểu được sơ đồ lớp bằng ngôn ngữ đặc tả UML với cú pháp cơ bản; có khả năng cài đặt một thiết kế hướng đối tượng cho trước bằng ngôn ngữ Java.', NULL, NULL, 1, 1, 'Môn học đi sâu giới thiệu cách tiếp cận hướng đối tượng đối với việc lập trình, với ngôn ngữ minh họa là Java. Mục tiêu là giúp cho sinh viên có được một hiểu biết tốt về các khái niệm cơ bản của lập trình hướng đối tượng như đối tượng, lớp, phương thức, thừa kế, đa hình, và interface, đi kèm theo là các nguyên lý căn bản về trừu tượng hóa, tính mô-đun và tái sử dụng trong thiết kế hướng đối tượng..', 1),
(8, 'Kiến trúc máy tính', 'INT2205', '1', NULL, 4, NULL, 3, '45', NULL, 'Nắm vững kiến thức về cổng lôgic số, hàm lôgic, mạch lôgic tổ hợp đơn giản từ các cổng logic, các latch, flip-flop, và các mạch lôgic tuần tự đơn giản; nắm vững các nguyên lý vào ra dữ liệu của máy tính; nắm vững kiến trúc tổng quan của bộ vi xử lý - các thành phần và giao tiếp giữa các thành phần; nắm vững các khái niệm của một kiến trúc tập lệnh - Instruction Set Architecture (ISA), khái niệm ngắt và sự hỗ trợ của phần cứng, khái niệm hợp ngữ và quan hệ giữa hợp ngữ và các lệnh máy, khái niệm về máy ảo và bộ nhớ ảo.', NULL, NULL, 1, 1, 'Cung cấp cho sinh viên các kiến thức về: Các biểu diễn số trong máy tính. Cổng lôgic số, hàm lôgic, mạch lôgic tổ hợp đơn giản từ các cổng logic, các latch, flip-flop, và các mạch lôgic tuần tự đơn giản. Cây phả hệ bộ nhớ trong máy tính (từ các thanh ghi tới vùng lưu trữ thứ cấp) và đặc điểm của các loại bộ nhớ khác nhau. Các nguyên lý vào ra dữ liệu của máy tính. Kiến trúc tổng quan của bộ vi xử lý - các thành phần và giao tiếp giữa các thành phần. Sự khác nhau giữa kiến trúc macroarchitecture và microarchitecture của một CPU và hoạt động của một chu trình fetch-execute. Khái niệm của một kiến trúc tập lệnh - Instruction Set Architecture (ISA). Khái niệm ngắt và sự hỗ trợ của phần cứng. Khái niệm hợp ngữ và quan hệ giữa hợp ngữ và các lệnh máy. Khái niệm về máy ảo và bộ nhớ ảo.', 1),
(9, 'Lập trình nâng cao', 'INT2202', '1', NULL, 5, NULL, 3, '30 - 15', NULL, 'Hiểu các khái niệm và biết vận dụng các kỹ thuật trong lập trình để biểu diễn bài toán và giải quyết bài toán bằng lập trình; hiểu các khái niệm cơ bản trong lập trình hướng đối tượng, có khả năng lập trình các bài toán cơ bản bằng lập trình hướng đối tượng trong C++; có khả năng lập trình với nhiều loại cấu trúc dữ liệu phức tạp và các kỹ thuật khó. Các kiểu dữ liệu như Xâu, Mảng nhiều chiều, Cấu trúc và Lớp. Các kỹ thuật lập trình khó như hàm đệ qui, xử lý trên xâu, xây dựng lớp và đối tượng, xây dựng các hàm mẫu.', NULL, NULL, 1, 1, 'Cung cấp cho sinh viên các kiến thức cơ bản và nâng cao về cách giải quyết các bài toán bằng lập trình. Giới thiệu các khái niệm và cấu trúc lập trình căn bản để giải quyết bài toán (minh hoạ trên ngôn ngữ C++): biến, kiểu dữ liệu, biểu thức, phép gán, vào ra dữ liệu đơn giản; các cấu trúc lặp và điều kiện, phân rã cấu trúc; làm việc với tệp; khái niệm hàm và sử dụng hàm. Giới thiệu các khái niệm và kỹ thuật nâng cao trong lập trình: làm việc với dữ liệu có cấu trúc; kỹ thuật đệ qui; kiểu dữ liệu trừu tượng; khuôn mẫu hàm; các khái niệm và kỹ thuật cơ bản trong lập trình hướng đối tượng; lập trình trên nhiều tệp. Thực hành trên ngôn ngữ lập trình hướng đối tượng C++. ', 0),
(10, 'Trí tuệ nhân tạo', 'INT3401', '1', NULL, 5, NULL, 3, '45', NULL, 'Biết mô tả và biễu diễn các yêu cầu của một bài toán thực tế dưới dạng bài toán tìm kiếm; hiểu và vận dụng được các chiến lược tìm kiếm mù và tìm kiếm có kinh nghiệm; biết sử dụng logic mệnh đề và logic vị từ để biểu diễn tri thức; hiểu và biết sử dụng các luật phân giải và suy diễn; hiểu và biết sử dụng các phương pháp học máy. ', NULL, NULL, 1, 1, 'Môn học cung cấp các kiến thức nền tảng trong lĩnh vực trí tuệ nhân tạo bao gồm các phương pháp giải quyết vấn để sử dụng phương pháp tìm kiếm, các chiến lược tìm kiếm có kinh nghiệm, tìm kiếm thỏa mãn ràng buộc, tìm kiếm có đối thủ trong trò chơi, các phương pháp biểu diễn tri thức và lập luận tự động, lập luận không chắc chắn. Người học được giới thiệu các khái niệm và kỹ thuật cơ bản về học máy. Môn học cũng giới thiệu với người học một số công cụ để xây dựng các hệ thống thông minh.', 0),
(11, 'Thực tập chuyên ngành', 'INT3508', '1', NULL, 6, NULL, 3, '15 - 30', NULL, 'Có kỹ năng làm việc nhóm; hiểu và áp dụng được một quy trình phát triển phần mềm; vận dụng các kiến thức về phân tích thiết kế để xây dựng yêu cầu, tiến hành phân tích và thiết kế các hệ thống phần mềm; biết làm việc trong môi trường thực tế; biết nghiên cứu, xây dựng sản phẩm phục vụ cho mục đích khoa học hoặc đời sống.', NULL, NULL, 1, 1, 'Sinh viên sẽ đi thực tập ở các công ty, viện  nghiên cứu, hoặc chính tại các bộ môn, phòng thí nghiệm, và trung tâm trong Trường Đại học Công nghệ. Thông qua việc thực hiện các đề tài được giao, sinh viên có cơ hội áp dụng kiến thức, kỹ năng đã học vào giải quyết bài toán thực tế và qua đó cũng biết được là mình còn kém mặt nào để rút kinh nghiệm. Bên cạnh đó sinh viên cũng được hiểu biết hơn về môi trường công ty (cả văn hóa và công nghệ), rèn luyện kĩ năng giao tiếp, làm việc nhóm, tác phong công nghiệp.', 0),
(12, 'Khóa luận tốt nghiệp ', 'INT4050', '1', NULL, 6, NULL, 10, NULL, NULL, 'Có kỹ năng đọc tài liệu tiếng Anh thành thạo; có kỹ năng tiến hành nghiên cứu, giải quyết vấn đề; có kỹ năng thực hiện thí nghiệm, đánh giá; có kỹ năng viết báo cáo (luận văn) bằng tiếng Anh; có kỹ năng trình bày bằng tiếng Anh.', NULL, NULL, 1, 1, 'Sinh viên năm cuối được làm khóa luận tốt nghiệp dưới sự hướng dẫn của giảng viên. Theo đó sinh viên cần vận dụng các kiến thức và kỹ năng đã tích lũy được để giải quyết một vấn đề nghiên cứu cơ bản hoặc giải pháp thực tiễn thuộc lĩnh vực CNTT. Việc thực hiện khóa luận tốt nghiệp giúp sinh viên củng cố hoặc có thêm kiến thức và kỹ năng trong hoạt động chuyên môn như: đọc tài liệu, phát triển ý tưởng, lập trình, thực hiện thí nghiệm, đánh giá, viết luận văn, trình bày báo cáo, v.v.', 0),
(23, 'Lập trình nâng cao', 'INT2202', '1', NULL, 5, NULL, 3, '30 - 15', NULL, 'Hiểu các khái niệm và biết vận dụng các kỹ thuật trong lập trình để biểu diễn bài toán và giải quyết bài toán bằng lập trình; hiểu các khái niệm cơ bản trong lập trình hướng đối tượng, có khả năng lập trình các bài toán cơ bản bằng lập trình hướng đối tượng trong C++; có khả năng lập trình với nhiều loại cấu trúc dữ liệu phức tạp và các kỹ thuật khó. Các kiểu dữ liệu như Xâu, Mảng nhiều chiều, Cấu trúc và Lớp. Các kỹ thuật lập trình khó như hàm đệ qui, xử lý trên xâu, xây dựng lớp và đối tượng, xây dựng các hàm mẫu.', NULL, NULL, 1, 2, 'Cung cấp cho sinh viên các kiến thức cơ bản và nâng cao về cách giải quyết các bài toán bằng lập trình. Giới thiệu các khái niệm và cấu trúc lập trình căn bản để giải quyết bài toán (minh hoạ trên ngôn ngữ C++): biến, kiểu dữ liệu, biểu thức, phép gán, vào ra dữ liệu đơn giản; các cấu trúc lặp và điều kiện, phân rã cấu trúc; làm việc với tệp; khái niệm hàm và sử dụng hàm. Giới thiệu các khái niệm và kỹ thuật nâng cao trong lập trình: làm việc với dữ liệu có cấu trúc; kỹ thuật đệ qui; kiểu dữ liệu trừu tượng; khuôn mẫu hàm; các khái niệm và kỹ thuật cơ bản trong lập trình hướng đối tượng; lập trình trên nhiều tệp. Thực hành trên ngôn ngữ lập trình hướng đối tượng C++. ', 0),
(24, 'Hệ quản trị cơ sở dữ liệu', 'INT3202', '1', NULL, 5, NULL, 3, '30 - 15', NULL, 'Có thể sử dụng một hệ quản trị CSDL (mySQL, Oracle, DB2, SQL Server, …) trong cả việc phát triển cũng như quản trị các CSDL phục vụ bài toán ứng dụng \r\nNắm vững cách quản lý truy cập dữ liệu của người dùng, các phương pháp lưu trữ dữ liệu, lập trình với thủ tục lưu trữ, phương pháp sao lưu và phục hồi dữ liệu, giao diện lập trình với hệ quản trị CSDL; có thể sử dụng bộ công cụ chuyên biệt để: tạo bản sao dữ liệu, phân mảnh dữ liệu, mô hình cụm dữ liệu (cluster).', NULL, NULL, 1, 2, 'Môn học cung cấp các kiến thức giúp sinh viên có thể sử dụng một hệ quản trị CSDL trong việc cả phát triển cũng như quản trị các CSDL phục vụ bài toán đích. Tuỳ nhu cầu thực tế, một hệ quản trị CSDL phổ biến sẽ được lựa chọn (Oracle, DB2, SQL Server, …) tiến hành xây dựng các bài thực hành. ', 0),
(26, 'Khóa luận tốt nghiệp', 'INT4050', '1', NULL, 6, NULL, 7, '', NULL, 'Có kỹ năng đọc tài liệu thành thạo; có kỹ năng tiến hành nghiên cứu, giải quyết vấn đề; có kỹ năng thực hiện thí nghiệm, đánh giá; có kỹ năng viết báo cáo (luận văn); có kỹ năng trình bày.', NULL, NULL, 1, 2, 'Sinh viên năm cuối đủ điều kiện sẽ được làm khóa luận tốt nghiệp dưới sự hướng dẫn của giảng viên. Theo đó sinh viên cần vận dụng các kiến thức và kỹ năng đã tích lũy được để giải quyết một vấn đề nghiên cứu cơ bản hoặc giải pháp thực tiễn thuộc lĩnh vực CNTT. Việc thực hiện khóa luận tốt nghiệp giúp sinh viên củng cố hoặc có thêm kiến thức và kỹ năng trong hoạt động chuyên môn như: đọc tài liệu, phát triển ý tưởng, lập trình, thực hiện thí nghiệm, đánh giá, viết luận văn, trình bày báo cáo, v.v.', 0),
(27, 'Tin học cơ sở 1', 'INT1003', '1', NULL, 1, 2014, 2, '10 - 20', NULL, '<ul>\r\n	<li>- M&ocirc;n học nhằm trang bị cho sinh vi&ecirc;n những kiến thức cơ bản về c&ocirc;ng nghệ th&ocirc;ng tin, hệ thống h&oacute;a v&agrave; bổ sung một số kiến thức mới c&aacute;c kiến thức sinh vi&ecirc;n đ&atilde; được học ở trường phổ th&ocirc;ng.</li>\r\n	<li>- M&ocirc;n học cung c&acirc;́p và đòi hỏi sau khi học xong sinh vi&ecirc;n phải c&oacute; kiến thức cơ bản, hệ thống về c&ocirc;ng nghệ th&ocirc;ng tin, hiểu r&otilde; về c&aacute;c chức năng v&agrave; c&aacute;ch l&agrave;m việc với m&aacute;y t&iacute;nh trong c&ocirc;ng việc th&ocirc;ng thường (l&agrave;m việc với hệ điều h&agrave;nh, soạn thảo văn bản, bảng t&iacute;nh, tr&igrave;nh diễn, t&igrave;m kiếm th&ocirc;ng tin tr&ecirc;n mạng&hellip;); Sử dụng th&agrave;nh thạo phần mềm cụ thể.</li>\r\n</ul>', NULL, NULL, 1, 1, '<ul>\n	<li>- Phần 1: Cung cấp cho sinh vi&ecirc;n c&aacute;c kiến thức cơ sở về th&ocirc;ng tin, m&aacute;y t&iacute;nh, phần mềm v&agrave; c&aacute;c ứng dụng c&ocirc;ng nghệ th&ocirc;ng tin.</li>\n	<li>- Phần 2: Cung cấp kiến thức v&agrave; r&egrave;n luyện kỹ năng sử dụng hệ điều h&agrave;nh, sử dụng c&aacute;c phần mềm văn ph&ograve;ng &nbsp;th&ocirc;ng dụng v&agrave; khai thác một số dịch vụ trên Internet.</li>\n</ul>', 1),
(28, 'Tin học cơ sở 4', 'INT1006', '1', NULL, 1, 2014, 3, '20 - 23 - 2', 'Tin học cơ sở 1', '  Cung cấp cho sinh viên kiến thức cơ bản về ngôn ngữ lập trình bậc cao, kỹ năng phân tích và xây dựng chương trình sử dụng ngôn ngữ lập trình bậc cao, kiểu dữ liệu trừu tượng. ', NULL, NULL, 1, 1, '<ul>\r\n	<li>- Cung cấp cho sinh vi&ecirc;n kiến thức cơ bản về lập tr&igrave;nh, ng&ocirc;n ngữ lập tr&igrave;nh bậc cao, phương ph&aacute;p lập tr&igrave;nh, c&aacute;c bước để xấy dựng chương tr&igrave;nh, cấu tr&uacute;c chương tr&igrave;nh, c&aacute;c cấu tr&uacute;c điều khiển, c&aacute;c kiểu dữ liệu, cấu tr&uacute;c mảng, h&agrave;m, biến to&agrave;n cục, biến cục bộ, v&agrave;o ra dữ liệu tệp.</li>\r\n	<li>- R&egrave;n luyện kỹ năng sử dụng th&agrave;nh thạo một ng&ocirc;n ngữ lập tr&igrave;nh bậc cao qua việc lựa chọn ng&ocirc;n ngữ cụ thể(C, C++, Java) để viết chương tr&igrave;nh.</li>\r\n</ul>', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `tbl_subject_doc`
--

INSERT INTO `tbl_subject_doc` (`id`, `subject_id`, `doc_id`, `doc_type`, `active`) VALUES
(1, 3, 1, 2, 1),
(3, 7, 3, 2, 1),
(5, 6, 5, 2, 1),
(6, 6, 6, 2, 1),
(7, 8, 7, 2, 1),
(14, 28, 14, 2, 1),
(19, 28, 19, 2, 1),
(20, 27, 20, 2, 1),
(21, 8, 21, 2, 1),
(23, 7, 23, 2, 1),
(24, 23, 24, 2, 1),
(25, 28, 25, 3, 1),
(26, 11, 26, 2, 1),
(27, 28, 27, 2, 1),
(28, 4, 28, 1, 1),
(29, 28, 29, 2, 1);

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
(5, 'Kiến thức chung theo lĩnh vực ', 1, '<ul>\n	<li>- Biết được c&aacute;c kiến thức cơ bản về Vật l&yacute; cơ, nhiệt, điện, quang; hiểu được c&aacute;c hiện tượng v&agrave; quy luật Vật l&yacute; v&agrave; c&aacute;c ứng dụng li&ecirc;n quan trong khoa học kỹ thuật v&agrave; đời sống; vận dụng kiến thức để học tập v&agrave; nghi&ecirc;n cứu c&aacute;c m&ocirc;n học kh&aacute;c của c&aacute;c ng&agrave;nh kỹ thuật v&agrave; c&ocirc;ng nghệ;</li>\n	<li>- Nắm được c&aacute;c kiến thức li&ecirc;n quan đến Giải t&iacute;ch to&aacute;n học như t&iacute;nh giới hạn,<br />\n	t&iacute;nh đạo h&agrave;m, t&iacute;nh t&iacute;ch ph&acirc;n của c&aacute;c h&agrave;m một biến v&agrave; h&agrave;m nhiều biến;</li>\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kiến thức li&ecirc;n quan đến Đại số cao cấp như ma trận v&agrave; c&aacute;c ph&eacute;p biến đổi, giải c&aacute;c hệ phương tr&igrave;nh nhiều biến số...</li>\n</ul>', 2, 1, 1),
(6, 'Kiến thức chung của khối ngành', 1, '<ul>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kiến thức li&ecirc;n quan đến cấu tr&uacute;c dữ liệu về mảng, danh s&aacute;ch li&ecirc;n kết, h&agrave;ng đợi, ngăn xếp, c&acirc;y nhị ph&acirc;n, bảng băm;</li>\r\n	<li>- Vận dụng được c&aacute;c thuật to&aacute;n cơ bản li&ecirc;n quan đến sắp xếp, t&igrave;m kiếm v&agrave; c&aacute;c thuật to&aacute;n kh&aacute;c tr&ecirc;n c&aacute;c cấu tr&uacute;c dữ liệu;</li>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kh&aacute;i niệm cơ bản về số phức v&agrave; c&aacute;c loại biểu diễn của số phức;</li>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kh&aacute;i niệm cơ bản của l&yacute; thuyết x&aacute;c suất;</li>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c phương ph&aacute;p ph&acirc;n t&iacute;ch t&iacute;n hiệu, ph&acirc;n t&iacute;ch v&agrave; thiết kế hệ thống tuyến t&iacute;nh trong c&aacute;c miền biểu diễn kh&aacute;c nhau.</li>\r\n</ul>', 3, 1, 1),
(7, 'Kiến thức chung của nhóm ngành ', 1, '<ul>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kiến thức cơ bản về To&aacute;n rời rạc để x&acirc;y dựng c&aacute;c thuật to&aacute;n, tối ưu c&aacute;c giải ph&aacute;p trong c&ocirc;ng nghệ;</li>\r\n	<li>- Sử dụng được một ng&ocirc;n ngữ lập tr&igrave;nh hướng đối tượng, hiểu c&aacute;c kh&aacute;i niệm v&agrave; viết được chương tr&igrave;nh phần mềm theo phương ph&aacute;p hướng đối tượng;</li>\r\n	<li>- Hiểu được cơ chế hoạt động chung của hệ thống m&aacute;y t&iacute;nh, c&aacute;c bộ phận, cấu tr&uacute;c của m&aacute;y t&iacute;nh;</li>\r\n	<li>- Hiểu nguy&ecirc;n l&yacute; cơ bản chung hệ điều h&agrave;nh của m&aacute;y t&iacute;nh;</li>\r\n	<li>- Hiểu c&aacute;c kh&aacute;i niệm cơ bản về mạng m&aacute;y t&iacute;nh, c&aacute;c bộ phận, c&aacute;c giao thức, c&aacute;ch thức truyền dữ liệu tr&ecirc;n mạng;</li>\r\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kh&aacute;i niệm về cơ sở dữ liệu trong hệ thống, c&aacute;c phương ph&aacute;p x&acirc;y dựng v&agrave; tối ưu h&oacute;a cơ sở dữ liệu của hệ thống;</li>\r\n	<li>- Hiểu c&aacute;c kh&aacute;i niệm chung về quy tr&igrave;nh ph&aacute;t triển phần mềm, c&aacute;c kỹ thuật x&acirc;y dựng một hệ thống phần mềm c&oacute; chất lượng.&nbsp;</li>\r\n</ul>', 4, 1, 1),
(8, 'Kiến thức của ngành và bổ trợ', 1, '<ul>\r\n	<li>- Lập tr&igrave;nh th&agrave;nh thạo một số ng&ocirc;n ngữ lập tr&igrave;nh th&ocirc;ng dụng;</li>\r\n	<li>- Vận dụng được c&aacute;c kiến thức về ph&acirc;n t&iacute;ch thiết kế để x&acirc;y dựng y&ecirc;u cầu, tiến h&agrave;nh ph&acirc;n t&iacute;ch v&agrave; thiết kế c&aacute;c hệ thống phần mềm;</li>\r\n	<li>- Vận dụng được c&aacute;c kiến thức về tr&iacute; tuệ nh&acirc;n tạo, học m&aacute;y, xử l&yacute; ng&ocirc;n ngữ tự nhi&ecirc;n, v.v. để x&acirc;y dựng c&aacute;c chương tr&igrave;nh c&oacute; khả năng xử l&yacute; th&ocirc;ng minh cho nhiều loại dữ liệu kh&aacute;c nhau như văn bản, tiếng n&oacute;i, ảnh, sinh học;</li>\r\n	<li>- Nắm được c&aacute;c vấn đề hiện đại v&agrave; c&oacute; khả năng đi s&acirc;u v&agrave;o nghi&ecirc;n cứu lĩnh vực truyền th&ocirc;ng đa phương tiện, c&oacute; thể thiết kế v&agrave; x&acirc;y dựng c&aacute;c ứng dụng về truyền th&ocirc;ng đa phương tiện;</li>\r\n	<li>- Hiểu c&aacute;c nguy&ecirc;n l&yacute; cơ bản của đồ họa m&aacute;y t&iacute;nh hiện đại, hiểu kiến thức h&igrave;nh học b&ecirc;n dưới c&aacute;c m&ocirc; h&igrave;nh 3 chiều, hiểu vấn đề hiệu năng khi vẽ c&aacute;c m&ocirc; h&igrave;nh 3D;</li>\r\n	<li>- Nắm vững kiến thức về l&yacute; thuyết th&ocirc;ng tin để c&oacute; thể &aacute;p dụng trong c&aacute;c b&agrave;i to&aacute;n về suy diễn thống k&ecirc;, truyền th&ocirc;ng, n&eacute;n dữ liệu, v.v.;</li>\r\n	<li>- Biết c&aacute;ch cập nhật c&aacute;c kiến thức hiện đại trong ng&agrave;nh Khoa học m&aacute;y t&iacute;nh;</li>\r\n	<li>- Biết tối ưu h&oacute;a hệ thống th&ocirc;ng qua c&aacute;c kiến thức bổ trợ về c&aacute;c ng&agrave;nh kh&aacute;c li&ecirc;n quan đến Khoa học m&aacute;y t&iacute;nh;</li>\r\n	<li>- Biết c&aacute;c kỹ thuật, c&aacute;c c&ocirc;ng nghệ mới trong ng&agrave;nh Khoa học m&aacute;y t&iacute;nh, ứng dụng trong ph&aacute;t triển c&aacute;c phần mềm đặc biệt, bảo đảm chất lượng v&agrave; an to&agrave;n, an ninh cho hệ thống.</li>\r\n</ul>', 5, 1, 1),
(9, 'Llý luận chính trị', 1, '<ul>\r\n	<li>- Hiểu được hệ thống tri thức khoa học những nguy&ecirc;n l&yacute; cơ bản của Chủ nghĩa M&aacute;c L&ecirc;nin;</li>\r\n	<li>- Hiểu được những kiến thức cơ bản, c&oacute; t&iacute;nh hệ thống về tư tưởng, đạo đức, gi&aacute; trị văn h&oacute;a Hồ Ch&iacute; Minh, những nội dung cơ bản của Đường lối c&aacute;ch mạng của Đảng Cộng sản Việt Nam, chủ yếu l&agrave; đường lối trong thời kỳ đổi mới tr&ecirc;n một số lĩnh vực cơ bản của đời sống x&atilde; hội.</li>\r\n</ul>', 1, 2, 1),
(10, 'Tin học', 1, '<ul>\r\n	<li>- Nhớ v&agrave; giải th&iacute;ch được c&aacute;c kiến thức cơ bản về th&ocirc;ng tin;</li>\r\n	<li>- Sử dụng được c&ocirc;ng cụ xử l&yacute; th&ocirc;ng tin th&ocirc;ng dụng (hệ điều h&agrave;nh, c&aacute;c phần mềm hỗ trợ c&ocirc;ng t&aacute;c văn ph&ograve;ng v&agrave; khai th&aacute;c Internet ...);</li>\r\n	<li>- C&oacute; khả năng ph&acirc;n t&iacute;ch, đ&aacute;nh gi&aacute; v&agrave; lập tr&igrave;nh một ng&ocirc;n ngữ lập tr&igrave;nh bậc cao (hiểu c&aacute;c cấu tr&uacute;c điều khiển, c&aacute;c kiểu dữ liệu c&oacute; cấu tr&uacute;c, h&agrave;m/chương tr&igrave;nh con, biến cục bộ/biến to&agrave;n cục, v&agrave;o ra dữ liệu tệp, c&aacute;c bước để x&acirc;y dựng chương tr&igrave;nh ho&agrave;n chỉnh);</li>\r\n	<li>- C&oacute; khả năng ph&acirc;n t&iacute;ch, đ&aacute;nh gi&aacute; phương ph&aacute;p lập tr&igrave;nh hướng thủ tục v&agrave; lập tr&igrave;nh hướng đối tượng; ph&acirc;n biệt được ưu v&agrave; nhược điểm của hai phương ph&aacute;p lập tr&igrave;nh.</li>\r\n</ul>', 1, 2, 1),
(11, 'Ngoại ngữ ', 1, '<ul>\r\n	<li>- Hiểu được c&aacute;c &yacute; ch&iacute;nh của một diễn ng&ocirc;n ti&ecirc;u chuẩn, r&otilde; r&agrave;ng về c&aacute;c vấn đề quen thuộc trong c&ocirc;ng việc, trường học, giải tr&iacute;, v.v.</li>\r\n	<li>- Xử l&yacute; hầu hết c&aacute;c t&igrave;nh huống c&oacute; thể xảy ra khi đi đến nơi sử dụng ng&ocirc;n ngữ;</li>\r\n	<li>- Viết đơn giản những li&ecirc;n kết về c&aacute;c chủ đề quen thuộc hoặc c&aacute; nh&acirc;n quan t&acirc;m;</li>\r\n	<li>- M&ocirc; tả được những kinh nghiệm, sự kiện, giấc mơ, hy vọng v&agrave; ho&agrave;i b&atilde;o v&agrave; c&oacute; thể tr&igrave;nh b&agrave;y ngắn gọn c&aacute;c l&yacute; do, giải th&iacute;ch cho &yacute; kiến v&agrave; kế hoạch của m&igrave;nh;</li>\r\n	<li>- Viết văn bản r&otilde; r&agrave;ng, chi tiết với nhiều chủ đề kh&aacute;c nhau v&agrave; c&oacute; thể giải th&iacute;ch quan điểm của m&igrave;nh về một vấn đề, n&ecirc;u ra được những ưu điểm, nhược điểm của c&aacute;c phương &aacute;n lựa chọn kh&aacute;c nhau.</li>\r\n</ul>', 1, 2, 1),
(12, 'Giáo dục thể chất và quốc phòng an ninh', 1, '<ul>\r\n	<li>- Hiểu v&agrave; vận dụng những kiến thức khoa học cơ bản trong lĩnh vực thể dục thể thao v&agrave;o qu&aacute; tr&igrave;nh tập luyện v&agrave; tự r&egrave;n luyện, ngăn ngừa c&aacute;c chấn thương để củng cố v&agrave; tăng cường sức khỏe. Sử dụng c&aacute;c b&agrave;i tập ph&aacute;t triển thể lực chung v&agrave; thể lực chuy&ecirc;n m&ocirc;n đặc th&ugrave;. Vận dụng những kỹ, chiến thuật cơ bản, luật thi đấu v&agrave;o c&aacute;c hoạt động thể thao ngoại kh&oacute;a cộng đồng;</li>\r\n	<li>- Hiểu được nội dung cơ bản về đường lối qu&acirc;n sự v&agrave; nhiệm vụ c&ocirc;ng t&aacute;c quốc ph&ograve;ng &ndash; an ninh của Đảng, Nh&agrave; n&shy;ước trong t&igrave;nh h&igrave;nh mới. Vận dụng kiến thức đ&atilde; học v&agrave;o chiến đấu trong điều kiện t&aacute;c chiến th&ocirc;ng thường.</li>\r\n</ul>\r\n', 1, 2, 1),
(13, 'Kiến thức chung theo lĩnh vực', 1, '<ul>\n	<li>- Biết được c&aacute;c kiến thức cơ bản về Vật l&yacute; cơ, nhiệt, điện, quang; hiểu được c&aacute;c hiện tượng v&agrave; quy luật Vật l&yacute; v&agrave; c&aacute;c ứng dụng li&ecirc;n quan trong khoa học kỹ thuật v&agrave; đời sống; vận dụng kiến thức để học tập v&agrave; nghi&ecirc;n cứu c&aacute;c m&ocirc;n học kh&aacute;c của c&aacute;c ng&agrave;nh kỹ thuật v&agrave; c&ocirc;ng nghệ;</li>\n	<li>- Nắm được c&aacute;c kiến thức li&ecirc;n quan đến Giải t&iacute;ch to&aacute;n học như t&iacute;nh giới hạn,<br />\n	t&iacute;nh đạo h&agrave;m, t&iacute;nh t&iacute;ch ph&acirc;n của c&aacute;c h&agrave;m một biến v&agrave; h&agrave;m nhiều biến;</li>\n	<li>- Hiểu v&agrave; vận dụng được c&aacute;c kiến thức li&ecirc;n quan đến Đại số cao cấp như ma trận v&agrave; c&aacute;c ph&eacute;p biến đổi, giải c&aacute;c hệ phương tr&igrave;nh nhiều biến số...</li>\n</ul>', 2, 2, 1),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_subject_teacher`
--

INSERT INTO `tbl_subject_teacher` (`id`, `subject_id`, `teacher_id`, `is_active`) VALUES
(4, 28, 1, 1),
(5, 3, 3, 1),
(6, 3, 4, 1);

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
  `teacher_work_place` varchar(100) DEFAULT NULL,
  `teacher_active` int(11) DEFAULT NULL,
  `teacher_acadamic_title` varchar(45) DEFAULT NULL,
  `teacher_birthday` varchar(45) DEFAULT NULL,
  `teacher_sex` int(5) DEFAULT NULL,
  `teacher_faculty` int(5) DEFAULT NULL,
  `teacher_dept` int(5) DEFAULT NULL,
  `teacher_rate` int(3) DEFAULT NULL,
  `teacher_personality` varchar(3000) DEFAULT NULL,
  `advices` varchar(3000) DEFAULT NULL,
  `teacher_research` varchar(3000) DEFAULT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_teacher`
--

INSERT INTO `tbl_teacher` (`teacher_id`, `teacher_name`, `teacher_personal_page`, `teacher_avatar`, `teacher_description`, `teacher_work_place`, `teacher_active`, `teacher_acadamic_title`, `teacher_birthday`, `teacher_sex`, `teacher_faculty`, `teacher_dept`, `teacher_rate`, `teacher_personality`, `advices`, `teacher_research`) VALUES
(1, 'Phạm Bảo Sơn', 'google.com', 'http://bluebee-uet.com/themes/classic/assets/img/Teacher_img/PGS. TS. Pham Bao Son.jpg', 'Thầy dạy dễ hiểu, dễ tính', 'Đại học Công nghệ - Đại học Quốc Gia Hà Nội', 1, 'PGS. TS.', '04 - 05 - 1980', 1, 1, 1, 4, 'Tính cách thầy/cô giáo', 'Lời khuyên khi học giáo viên này', 'Công trình nghiên cứu của thầy, cô'),
(2, 'Trần Thị Minh Châu', 'uet.vnu.edu.vn/~chauttm/', 'http://bluebee-uet.com/themes/classic/assets/img/chauttm.jpg', NULL, 'Bộ môn Công nghệ Phần mềm, 309, E3', 1, 'TS. GV. ', NULL, 0, 1, 2, 4, NULL, 'Học cô rất hay', '<ul>\r\n	<li>- Lập tr&igrave;nh nh&uacute;ng v&agrave; thời gian thực.</li>\r\n	<li>- Lập tr&igrave;nh hướng đối tượng.</li>\r\n	<li>- Cấu tr&uacute;c dữ liệu v&agrave; giải thuật.</li>\r\n	<li>- Hệ ph&acirc;n t&aacute;n.</li>\r\n	<li>- C&ocirc;ng nghệ phần mềm</li>\r\n</ul>'),
(3, 'Nguyễn Nam Hải', 'uet.vnu.edu.vn/~hainn/', 'http://bluebee-uet.com/themes/classic/assets/img/Teacher_img/Nguyen Nam Hai.jpg', NULL, 'Đại học Công nghệ', 1, 'Giảng viên', NULL, 1, 1, 2, 3, 'Thầy khá là nghiêm khắc', 'Chú ý trên lớp, làm bài đầy đủ theo chỉ dẫn của thầy sẽ được kết quả tốt', '<ul>\r\n	<li>2004-2008: Unisys &ndash; Student Training management software system, model of credit trainning.</li>\r\n	<li>2003-2004: Domasoft &ndash; Domitory management software</li>\r\n	<li>2002-2003: Objtest &ndash; Objective test software system Webman &ndash; Portal, Website management system</li>\r\n	<li>2000-2002: Fiacsys &ndash; Finace &amp; Accounting management system</li>\r\n	<li>1996-2000: Unisoft &ndash; Student Training management software system</li>\r\n	<li>1994-1995: Netgard &ndash; Network guard &amp; mantain software</li>\r\n	<li>1992-1994: Jimage &ndash; Jpeg image processing software,&nbsp;Graphic Servor Calculating &ndash; Computing system for Robot&rsquo;s Dynamic System,&nbsp;Motor Auto Tuning - Servo Motor Controler auto tuning&nbsp;system</li>\r\n	<li>1990-1992: Computerization project for Vietnam Ocean Ship Company &ndash; Construction software &amp; performace system</li>\r\n	<li>1989-1990: Vsafe &ndash; Virus protection solution for IBM PC</li>\r\n	<li>1988-1989: Vied &ndash; Vietnamese editor software for NEC PC</li>\r\n</ul>'),
(4, 'Lê Phê Đô', 'uet.vnu.edu.vn/~dolp/', NULL, NULL, 'Bộ môn Các Phương pháp Toán trong Công nghệ', 1, 'TS. ', NULL, 1, 1, 2, 4, NULL, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_id_fb`, `username`, `password`, `user_real_name`, `user_avatar`, `user_cover`, `user_student_code`, `user_university`, `user_gender`, `user_dob`, `user_hometown`, `user_phone`, `user_description`, `user_faculty`, `user_class`, `user_active`, `user_status`, `user_group`, `user_token`, `user_activator`, `user_qoutes`, `user_date_attend`) VALUES
(5, NULL, 'huynt57@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'huy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, '3essbj9wfk6c4cc8og4cggc8c400ss8', '5101c56e813c995c9df3d5ba6ab5be06', NULL, NULL),
(6, '100003910426858', 'huynt57@gmail.com', NULL, 'Nguyễn Thế Huy', 'http://graph.facebook.com/100003910426858/picture?type=small', NULL, NULL, NULL, NULL, '10/22/1994', 'Hanoi, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 's4pvafif9s04wc0o4o0gc444g8gswg8', NULL, '"Tình yêu đến đầu tiên, vì tình yêu, những điều khác mới đến" (Mourinho)\n\n"I am no Genius. I am simply good at it"(Gennady Korotkevich)', '07/08/2014'),
(7, '100000231474210', 'vungocson94@gmail.com', NULL, 'Sơn Vũ', 'http://graph.facebook.com/100000231474210/picture?type=small', NULL, NULL, NULL, NULL, '04/13/1994', 'Hanoi, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'i2beckucs4gkowsgwo0cgs8sskwok48', NULL, '1.kẻ tống phân vào mình chưa chắc là ngươi xấu\r\n2.thằng lôi mình ra khỏi đống phân chưa có thể là người tốt', '07/08/2014'),
(8, '100001706738208', 'thanhcan94@yahoo.com', NULL, 'Phan Thành', 'http://graph.facebook.com/100001706738208/picture?type=small', NULL, NULL, NULL, NULL, '12/02/1994', 'Vinh Yen', NULL, NULL, NULL, NULL, 1, NULL, NULL, '8c1tsjb8viko8kowsw04ck4ksosg08c', NULL, 'Đôi khi cuộc sống thật nhiều khó khắn, từ nhỏ nhặt đến lớn lao, quan trọng là bạn có biết vượt qua nó hay không :)', '08/08/2014'),
(9, '100004064431279', 'tuanphong94@gmail.com', NULL, 'Nguyễn Tuấn Phong', 'http://graph.facebook.com/100004064431279/picture?type=small', NULL, NULL, NULL, NULL, '08/04/1994', 'Bac Ninh', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2011i2l1hv5wkwss0cc0gcokc0c4w4k', NULL, NULL, '08/08/2014'),
(10, '100000188385487', 'thanhtung9630@gmail.com', NULL, 'Tung Nguyen', 'http://graph.facebook.com/100000188385487/picture?type=small', NULL, NULL, NULL, NULL, '01/22/1993', 'Hanoi, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'hilq665r3s0k0s4cw40osoo4k4s8os4', NULL, 'Liberté, Égalité, Fraternité\r\nTự do, Bình đẳng, Bác ái', '08/08/2014'),
(11, '100000629673056', 'khanhnv3007@gmail.com', NULL, 'Nguyễn Văn Khánh', 'http://graph.facebook.com/100000629673056/picture?type=small', NULL, NULL, NULL, NULL, '07/30/1994', 'Thái Bình, Thái Bình, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, '6ac076h2u3ok0c0wc44cwkwg8ow0s8s', NULL, 'Cuộc sống là không chờ đợi!!!', '08/08/2014'),
(12, '100008048376882', 'giaplvk57@gmail.com', NULL, 'Lê Giáp', 'http://graph.facebook.com/100008048376882/picture?type=small', NULL, NULL, NULL, NULL, '02/22/1994', 'Yên Thành', NULL, NULL, NULL, NULL, 1, NULL, NULL, '158ska6zzdmo484cssoooscow0ocw4s', NULL, NULL, '08/08/2014'),
(13, '100005993747094', 'vipro.2020@yahoo.com', NULL, 'Trần Tuấn', 'http://graph.facebook.com/100005993747094/picture?type=large', NULL, NULL, NULL, NULL, '11/13/1993', 'Thanh Hóa', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'tpgaoisywc0oc488w8sg4w80sks084w', NULL, 'To see the world, things dangerous to come to, to see behind walls, to draw closer, to find each other and to feel. That is the purpose of life!!!', '08/08/2014'),
(14, '100002786762187', 'tinhbankhonggioihan@yahoo.com', NULL, 'Yêu Em Bán Xôi', 'http://graph.facebook.com/100002786762187/picture?type=large', NULL, NULL, NULL, NULL, '02/26/1992', 'Hanoi, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'mdyx9x4dwi8c48s4w8k0wwgwsw8k808', NULL, NULL, '08/08/2014'),
(15, NULL, 'sample@email.tst', '1f1767b5696e79116b11ecc7f2882783', 'uivypcri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '553f9e0f719254abcdf5b9bf51bc358c', 'Học, học nữa, học mãi', '08/08/2014'),
(16, '100003809560252', 'nhatgai192@gmail.com', NULL, 'Bach Nv', 'http://graph.facebook.com/100003809560252/picture?type=large', NULL, NULL, NULL, NULL, '05/19/1992', 'Yen, Vĩnh Phúc, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'llanj7mhwsgw0cc0gggw8skk04c08gc', NULL, NULL, '08/08/2014'),
(17, '100000139512055', 'hongquan_lienxo2200@yahoo.com', NULL, 'Kiên Duy Nguyễn', 'http://graph.facebook.com/100000139512055/picture?type=small', NULL, NULL, NULL, NULL, '11/29/1994', 'Hanoi, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'kwm97lx4he88og88gkcocok84so0wws', NULL, 'Hãy mơ điều bạn thích mơ. Hãy đi nơi bạn thích đi. Hãy trở thành người mà bạn muốn trở thành. Bởi vì ta chỉ có một cuộc đời và một cơ hội để thực hiện tất cả những gì ta mong moi trong cuộc đời ấy', '08/08/2014'),
(18, '100002465949570', 'tkson.it4292@gmail.com', NULL, 'Trần Kim Sơn', 'http://graph.facebook.com/100002465949570/picture?type=large', NULL, NULL, NULL, NULL, '02/04/1992', 'Ho Chi Minh City, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'f8qudya65y8ko4g0sws8gs0wwo4c8k8', NULL, NULL, '08/08/2014'),
(19, '100003862308440', NULL, NULL, 'Mít Ọt', 'http://graph.facebook.com/100003862308440/picture?type=large', NULL, NULL, NULL, NULL, '10/24/1993', 'Nam Dinâ?, Ha Nam Ninh, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'dc4y54zs5ao8c880g4g4kko8gw4cgs', NULL, NULL, '08/08/2014'),
(20, '100003889930668', 'matnacuoi2010@gmail.com', NULL, 'Chín Đuôi', 'http://graph.facebook.com/100003889930668/picture?type=large', NULL, NULL, NULL, NULL, '10/20/1993', 'Hung Yen, Hưng Yên, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'n6ms7dnemq88kk4o0cswcg8goc08wgg', NULL, 'Nhưng gì không mua được bằng TIỀN...............................\nthì\nSẽ mua được bằng rất nhiều TIỀN...............................................................................................................................................', '08/08/2014'),
(21, '100003056887131', 'im_your_1102@yahoo.com.vn', NULL, 'Thịt Gà Rang', 'http://graph.facebook.com/100003056887131/picture?type=large', NULL, NULL, NULL, NULL, '09/18/1994', 'Sơn Tây', NULL, NULL, NULL, NULL, 1, NULL, NULL, '456vvxeqgw84kkk8k084kwsso0ss80c', NULL, '<3 Khi bạn...\r\nNém bùn vào người khác\r\nCó thể sẽ trúng...\r\nMà cũng có thể sẽ không.\r\n<3 Nhưng:\r\nTay bạn...thì chắc chắn là đã vấy bùn...\r\n<3 Vì thế:\r\nKhi ai đó cố tình làm tổn thương bạn, thì chính bản thân họ... Cũng đã phải trả giá vì điều đó rồi...\r\n<3 Vậy nên:\r\nNếu có thể bạn hãy học cách quên đi cho lòng được thanh thanr, nhẹ nhàng và c', '08/08/2014'),
(22, '100004302130568', 'nguyenduyx188@gmail.com', NULL, 'Quang Duy', 'http://graph.facebook.com/100004302130568/picture?type=large', NULL, NULL, NULL, NULL, '07/15/1993', 'Kim Bang, Ha Nam Ninh, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'pkzu6626r280488skwocs48cgsckk0c', NULL, 'Gạo đem vào giã bao đau đớn\nGạo giã xong rồi, trắng tựa bông\nSống ở trên đời người cũng vậy\nGian nan rèn luyện mới thành công!\n                          " HỒ CHÍ MINH"', '08/08/2014'),
(23, '100003287599849', NULL, NULL, 'Kun My Kaito', 'http://graph.facebook.com/100003287599849/picture?type=small', NULL, NULL, NULL, NULL, '12/01/1984', 'Hòa Bình, Hòa Bình, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'imiuyvij91wsk44wsocw88g0cw8o880', NULL, 'nói chung là tiền anh không nhiều chỉ có vài chăm bạc  nhưng chả bao giờ tiêu vì mẹ bảo để dành tiền mà lấy vợ', '08/08/2014'),
(24, '100007574971199', 'thugiancuoichieu@gmail.com', NULL, 'Dân Tộc Việt Nam', 'http://graph.facebook.com/100007574971199/picture?type=large', NULL, NULL, NULL, NULL, '09/23/1992', 'Yên Thành', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'fwoxbukyb28048kw4ws8g4cos008kkg', NULL, NULL, '08/08/2014'),
(25, '1704865926', 'quocviet.cntt.bk@gmail.com', NULL, 'Tran Quoc Viet', 'http://graph.facebook.com/1704865926/picture?type=large', NULL, NULL, NULL, NULL, '07/29/1989', 'Hai Phong, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, '9omjhxya9a0wcow04s44ssc4wsscwog', NULL, 'I believe that if life gives you lemons, you should make lemonade... And try to find somebody whose life has given them vodka, and have a party.\nRon White', '08/08/2014'),
(26, '100005050620024', 'linhtn_57@vnu.edu.vn', NULL, 'Hatake Kakashi', 'http://graph.facebook.com/100005050620024/picture?type=large', NULL, NULL, NULL, NULL, '09/16/1993', 'Hanoi, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'cgte0dtsdw8c80kgg00wwg8wwwg0kcc', NULL, '♥ Đừng quay lại phía sau. . .\n• Với những nỗi đau bật khóc . . .\n♥ Hãy nhìn về phía trước. . .\n• Nơi luôn có một nụ cười mang cái tên :\nTƯƠNG LAI . . .!\n♥ Đừng biến trái tim bạn thành một "CON\nĐƯỜNG" để ai cũng có thể đi qua.\n• Mà hãy biến nó thành một "BẦU TRỜI".\n• Nơi mà tất cả mọi người đều "MƠ ƯỚC"\n♥“Có thể những điều anh nói em sẽ mãi mãi không thể hiểu được, anh đã quen với cảnh nghèo, nhưng', '08/08/2014'),
(27, '100003192842837', 'xaydung86@gmail.com', NULL, 'Xaydung BachKhoa', 'http://graph.facebook.com/100003192842837/picture?type=large', NULL, NULL, NULL, NULL, '11/22/1965', 'Ho Chi Minh City, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'ssrkeqa7l4goks4s4gsggk4ss0oco4c', NULL, NULL, '09/08/2014'),
(28, '100000282356186', 'thanhcris@yahoo.com', NULL, 'Hiep Pham Van', 'http://graph.facebook.com/100000282356186/picture?type=large', NULL, NULL, NULL, NULL, '05/26/1987', 'Hanoi, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'm1zl5809ck0cooskgw4scswwog8co0w', NULL, NULL, '09/08/2014'),
(29, '100003909413706', NULL, NULL, 'Luong Nguyen', 'http://graph.facebook.com/100003909413706/picture?type=large', NULL, NULL, NULL, NULL, '05/19/1994', 'Bim Son', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'muzp0cbt234ccokso44owk48ksg0sc0', NULL, NULL, '09/08/2014'),
(30, '100001787447800', 'phancuong.qt@gmail.com', NULL, 'Phan Văn Cương', 'http://graph.facebook.com/100001787447800/picture?type=small', NULL, NULL, NULL, NULL, '11/10/1988', 'Quảng Trị', NULL, NULL, NULL, NULL, 1, NULL, NULL, '4rhccz6jcckkckcg80wsoo4go0socww', NULL, 'Sông lâu không bằng sống vui', '09/08/2014'),
(31, '100002602161477', 'hienncgc60025@fpt.edu.vn', NULL, 'Hiển Nguyễn Chất', 'http://graph.facebook.com/100002602161477/picture?type=large', NULL, NULL, NULL, NULL, '09/12/1990', 'Ankroet, Lâm Ðồng, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, '', NULL, NULL, '09/08/2014'),
(32, '100003857653837', NULL, NULL, 'Trịnh Hà Duy Trịnh', 'http://graph.facebook.com/100003857653837/picture?type=large', NULL, NULL, NULL, NULL, '07/01/1987', 'Hanoi, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'd9fid7z2sp448osgccgwk4wkcok08ok', NULL, NULL, '09/08/2014'),
(33, '100002662476411', 'tamvinhqn@gmail.com', NULL, 'Bá Tước Bóng Đêm', 'http://graph.facebook.com/100002662476411/picture?type=large', NULL, NULL, NULL, NULL, '05/02/1993', 'Quang Ngai', NULL, NULL, NULL, NULL, 1, NULL, NULL, '', NULL, NULL, '09/08/2014'),
(34, '100003720842779', 'maimai_1tinhyeu0603@yahoo.com', NULL, 'Lee Minh', 'http://graph.facebook.com/100003720842779/picture?type=large', NULL, NULL, NULL, NULL, '04/05/1995', 'Thái Bình, Thái Bình, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2do7r3y8aduss88socc4k08g8cc0gsc', NULL, 'Do dự không quyết đoán tức là đánh mất đi thời cơ.', '09/08/2014'),
(35, '100002928642615', 'two_eagle_eyes@yahoo.com', NULL, 'Trần Việt Thắng', 'http://graph.facebook.com/100002928642615/picture?type=large', NULL, NULL, NULL, NULL, '02/17/1996', 'Nam Dinâ?, Ha Nam Ninh, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'eu12w3pbmooccgk4o4kk4o00kkwwk4o', NULL, 'Công nghệ - Hội họa - Âm nhạc', '09/08/2014'),
(36, '100006460197344', 'anhhieuuet@gmail.com', NULL, 'Hiệu', 'http://graph.facebook.com/100006460197344/picture?type=large', NULL, NULL, NULL, NULL, '02/15/1995', 'Nam Dinâ?, Ha Nam Ninh, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, '25mu7xi7u5us0sogwssowwooccwkg0s', NULL, NULL, '09/08/2014'),
(37, '100004172024163', 't.anhno1@gmail.com', NULL, 'Anh Manucian', 'http://graph.facebook.com/100004172024163/picture?type=large', NULL, NULL, NULL, NULL, '11/20/1996', 'Yen, Vĩnh Phúc, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'on5ibobktwgko0ss8ow400s0w8o4c44', NULL, NULL, '09/08/2014'),
(38, '100001357865189', 'vohuyhoang.ccna@gmail.com', NULL, 'Kee Tam Hoàng', 'http://graph.facebook.com/100001357865189/picture?type=large', NULL, NULL, NULL, NULL, '12/01/1994', 'Con Cuông', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'cwc9tiugfa0c0s0cows04go48kgccoc', NULL, 'Hãy chờ Bình Minh đến nếu bạn chán Hoàng Hôn nhé', '09/08/2014'),
(39, '1801886253', 'sir.dtnguyen@gmail.com', NULL, 'Đại Thành', 'http://graph.facebook.com/1801886253/picture?type=large', NULL, NULL, NULL, NULL, '06/19/1992', 'Huong Canh, Vinh Phu, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'cy8b91ifl4ow4wgok0w4g4og0k888ks', NULL, 'Chase excellence, success will follow!!!', '09/08/2014'),
(40, '100004132536909', 'huyenduong8894@gmail.com', NULL, 'Huyen Duong', 'http://graph.facebook.com/100004132536909/picture?type=large', NULL, NULL, NULL, NULL, '08/08/1994', 'Phu Tho', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'a40pohqbgv4kckc8o4s4400swsk4cws', NULL, 'K thx nhớn .ngườj lớn thật lạ .thật fiền fức >"< mún tự đứg lên bước đj vữg vàg bằg chính đôj chân of mìh .đi theo ñ j <3 mách bảo .dù đúg hay saj thj trog từ điển sốg sẽ k pjờ có mấy từ "ước j tg way trở lạj " hay "hốj hận" . aj trên tráj đất lày sinh ra kũg có ñ nét ẹp riêg ko ít thì ǹvậy nên chẳg có j fảj tự tj về bản thân hjt mặc dù mặt k', '09/08/2014'),
(41, '100001258689960', 'thiet_thuc@ymail.com', NULL, 'Davian Phoenix', 'http://graph.facebook.com/100001258689960/picture?type=large', NULL, NULL, NULL, NULL, '03/26/1996', 'Hanoi, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'eejk9e27vm88kc884ccgckgsk0kggws', NULL, NULL, '09/08/2014'),
(42, '100006555006066', 'stevenchu1994@gmail.com', NULL, 'Chu Chí Quang', 'http://graph.facebook.com/100006555006066/picture?type=large', NULL, NULL, NULL, NULL, '11/07/1994', 'Hanoi, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'jhwfkq420e80ok0o4gogw8co0cckgk0', NULL, NULL, '09/08/2014'),
(43, '100006644406239', 'tuannv_58@vnu.edu.vn', NULL, 'Arsene Tuấn Nguyễn', 'http://graph.facebook.com/100006644406239/picture?type=small', NULL, NULL, NULL, NULL, '03/22/1995', 'Bac Giang', NULL, NULL, NULL, NULL, 1, NULL, NULL, '37ot0j4l52gwoc4s0800808k8g04gk8', NULL, NULL, '09/08/2014'),
(44, '100007436822598', NULL, NULL, 'Vu Tien Thanh', 'http://graph.facebook.com/100007436822598/picture?type=large', NULL, NULL, NULL, NULL, '11/14/1996', 'Nam Dinâ?, Ha Nam Ninh, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, '1pqsm0jehl7o84kg88cgscsswko4ows', NULL, NULL, '09/08/2014'),
(45, '100003998126890', 'nh0konljne00@yahoo.com', NULL, 'Tuan Dao', 'http://graph.facebook.com/100003998126890/picture?type=large', NULL, NULL, NULL, NULL, '11/25/1996', 'Cẩm Phả Port, Quảng Ninh, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'rpdogxbz7wg40skg40wkgswgccggowc', NULL, NULL, '09/08/2014'),
(46, '100001264433813', 'thesonisdeath@yahoo.com', NULL, 'Phạm Hồng Phi', 'http://graph.facebook.com/100001264433813/picture?type=large', NULL, NULL, NULL, NULL, '07/10/1994', 'Hanoi, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'm4hadktyo0g8w0wk40s08gw8ggcowgs', NULL, NULL, '10/08/2014'),
(47, '100004001715921', 'dinhhiep196@gmail.com', NULL, 'Đình Hiệp', 'http://graph.facebook.com/100004001715921/picture?type=large', NULL, NULL, NULL, NULL, '02/12/1996', 'Phu Tho', NULL, NULL, NULL, NULL, 1, NULL, NULL, '31zoontthekggkwg8oo80ss88o0wkow', NULL, 'Đừng chờ đợi những gì bạn ước muốn mà hãy đi tìm kiếm chúng', '10/08/2014'),
(48, '100005056596981', 'tainh.57.94@gmail.com', NULL, 'Nguyễn Hùng Tài', 'http://graph.facebook.com/100005056596981/picture?type=large', NULL, NULL, NULL, NULL, '05/28/1994', 'Thanh Hóa', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'k5hbulv2ev4w4kgg04c8wgcc0w84gso', NULL, 'Tiền không phải là tất cả. Nhưng không có tiền thì chẳng làm được việc gì =))', '10/08/2014'),
(49, '100006188551665', NULL, NULL, 'Thằng Nóc', 'http://graph.facebook.com/100006188551665/picture?type=large', NULL, NULL, NULL, NULL, '01/01/1991', 'Phan Rang-Tháp Chàm, Ninh Thuận, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'jryeggcd8wgc8cocw80oo4sskgcgsc4', NULL, NULL, '10/08/2014'),
(50, '100006140254452', 'cuocsonguet@gmail.com', NULL, 'Lê Quang Đức', 'http://graph.facebook.com/100006140254452/picture?type=large', NULL, NULL, NULL, NULL, '07/31/1994', 'Thanh Hóa', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'j243ifsdrfsocsgk80s0ooggs4gwo0o', NULL, NULL, '10/08/2014'),
(51, '100006298234215', 'ducdv.k57cc@gmail.com', NULL, 'Hashirama Senju', 'http://graph.facebook.com/100006298234215/picture?type=large', NULL, NULL, NULL, NULL, '09/04/1994', 'Vinh Phuc, Ha Noi, Vietnam', NULL, NULL, NULL, NULL, 1, NULL, NULL, '41obp4li08o4400w4048oc4k484wsow', NULL, NULL, '10/08/2014');

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
  `teacher_id` int(11) DEFAULT NULL,
  `object_type` varchar(45) DEFAULT NULL,
  `rating_score` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `vote_type`, `teacher_id`, `object_type`, `rating_score`) VALUES
(1, 1, NULL, 1, NULL, 1),
(2, 2, NULL, 1, NULL, 5),
(3, 3, NULL, 1, NULL, 5),
(25, 4, NULL, 1, NULL, 3),
(26, 8, NULL, 1, NULL, 5),
(27, NULL, NULL, 1, NULL, 5),
(28, 11, NULL, 1, NULL, 5),
(29, 6, NULL, 2, NULL, 4),
(30, NULL, NULL, 2, NULL, 3),
(31, 39, NULL, 2, NULL, 5),
(32, 6, NULL, 1, NULL, 5),
(33, 11, NULL, 3, NULL, 5),
(34, 6, NULL, 3, NULL, 4),
(35, NULL, NULL, 3, NULL, 1),
(36, 6, NULL, 4, NULL, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
