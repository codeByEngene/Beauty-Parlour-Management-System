-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2026 at 10:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_settings`
--

CREATE TABLE `about_settings` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `page_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_settings`
--

INSERT INTO `about_settings` (`id`, `page_title`, `page_description`) VALUES
(1, 'About Us', 'Our main focus is on quality and hygiene. Our Parlour is well equipped with advanced technology equipments and provides best quality services. Our staff is well trained and experienced, offering advanced services in Skin, Hair and Body Shaping that will provide you with a luxurious experience that leave you feeling relaxed and stress free.\r\n      ');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service_name` varchar(100) DEFAULT NULL,
  `service_desc` text DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`, `service_desc`, `cost`, `image`, `creation_date`) VALUES
(3, 'Cleansing', 'we clean your face with good product', 550, '4.jpg', '2026-03-17 17:41:46'),
(4, 'Facial', 'Hydra Facial', 1500, '8.jpg', '2026-03-17 17:41:46'),
(5, 'Fuit facial', 'Natural fruit-based facial for glowing skin', 500, '2ecd94cf3a9501b938f36835f03567e3.jpg', '2026-03-17 18:03:15'),
(6, 'Charcoal Facial', 'Deep cleansing facial with activated charcoal.', 1050, 'e3d053e923751a1685f06b44793f88e9.jpg', '2026-03-17 18:23:02'),
(8, 'Body Treatments', 'relaxation ', 5000, '39a807a47eed82b32170fa0e400d99b5.jpg', '2026-03-20 02:31:15'),
(10, 'Body Scrub', 'A refreshing exfoliation treatment that removes dead skin cells, unclogs pores, and improves blood circulation. It helps to reveal smoother, softer, and brighter skin while giving a relaxing spa-like experience.', 500, '53c56d492a6cb0499473aba9c4c38115.jpeg', '2026-03-21 11:26:24'),
(11, 'Back Massage', 'A relaxing and therapeutic massage focused on the back, shoulders, and neck to relieve muscle tension, reduce stress, and improve blood circulation. Ideal for easing stiffness caused by long working hours or physical strain.', 1000, 'ed554aee4ea06af16c155205262b95b6.jpeg', '2026-03-21 11:27:47'),
(12, 'Aromatherapy', 'A soothing therapy that uses natural essential oils to relax the body and mind. It helps reduce stress, improve mood, relieve muscle tension, and promote overall well-being through gentle massage and calming aromas.', 1050, 'd5a362904230ac6e49afe21498be5b14.jpeg', '2026-03-21 11:28:43'),
(13, 'Hair Dry & Blow Dry', 'A refreshing hair cleansing service followed by professional blow drying to give your hair a smooth, voluminous, and salon-finished look. Perfect for everyday styling or before special occasions.', 500, '8961b4b57f76822673ee99ffcc4597e7.jpeg', '2026-03-21 11:31:04'),
(14, 'Nail Art', 'Creative and stylish nail designs that enhance the beauty of your hands. From simple patterns to intricate artwork, glitter, and extensions, our nail art services let you express your personality with trendy and elegant finishes.', 300, '0aafac7a8ec55eca93bff2359f54d0e1.jpeg', '2026-03-21 11:32:07'),
(15, 'Gel Manicure', 'A long-lasting manicure that uses gel-based polish cured under UV or LED light for a glossy, chip-resistant finish. It includes nail shaping, cuticle care, and a smooth, durable polish that stays perfect for weeks.', 400, 'a6ca059ab2d3d4839ab5efa587303ed7.jpeg', '2026-03-21 11:33:33'),
(16, 'Hair Treatment', 'Specialized hair treatments designed to repair damaged hair, strengthen strands, reduce hair fall, and restore shine and softness. Includes deep conditioning, protein treatments, and scalp nourishment tailored to your hair type.', 1500, 'c14227143b18c6bfae103fa456f7172e.jpeg', '2026-03-21 11:34:59'),
(17, 'Hair Bleaching', 'Let your hair shine', 500, 'f72769fe2adde22fe67c7dbba843a10f.webp', '2026-03-21 11:37:03'),
(18, 'Bob Cut Hair', 'Fresh, styling hair that speaks for itself', 350, '610b45e6762504c3d1a2550e7d7fc40a.jpg', '2026-03-21 11:39:02'),
(19, 'Anti-Aging Facial  ', 'A rejuvenating facial treatment that helps reduce fine lines, wrinkles, and signs of aging. Using specialized creams, serums, and massage techniques, it boosts skin elasticity, hydrates deeply, and restores a youthful glow.', 800, '09306b0464d6214df4b97a007bddaf37.jpeg', '2026-03-21 11:41:28'),
(20, 'Acne Treatment Facial', 'A targeted facial treatment designed to treat and prevent acne breakouts. It deeply cleanses pores, reduces excess oil, calms inflammation, and promotes clear, healthy skin with professional-grade products.', 800, '5c646249e84ad676e9221055df65689f.jpeg', '2026-03-21 11:42:52'),
(21, 'Massage Oil Therapy', 'Relaxing massage using specially blended oils that nourish the skin, reduce muscle tension, and promote overall wellness. Choose from a variety of oils infused with essential fragrances for a soothing and rejuvenating experience.', 850, 'e5b02a2335e638a811fa53b306430df9.jpeg', '2026-03-21 11:44:30'),
(22, 'Bleaching Hair', 'Make your hair as you want ', 450, '3fb4a5b6896d41276de8ad8d086eb5a9.jpg', '2026-03-21 12:02:33'),
(23, 'Bridal Makeup', 'Be the queen of your special day.', 5000, '1be09265b805a10557b99297e19111a1.jpg', '2026-03-21 12:03:55'),
(24, 'Face Massage', 'A soothing facial massage that improves blood circulation, relieves tension, and revitalizes the skin. It helps reduce puffiness, relax facial muscles, and enhance your natural glow.\r\n\r\nRefresh your face, relax your mind!', 3500, '06030abda26e76ef3d0e298382a4b99b.jpg', '2026-03-21 12:05:32');

-- --------------------------------------------------------

--
-- Table structure for table `tblappointment`
--

CREATE TABLE `tblappointment` (
  `ID` int(11) NOT NULL,
  `AppointmentNumber` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ServiceId` int(11) DEFAULT NULL,
  `AptDate` date DEFAULT NULL,
  `AptTime` time DEFAULT NULL,
  `Message` mediumtext DEFAULT NULL,
  `BookingDate` timestamp NULL DEFAULT current_timestamp(),
  `Status` varchar(50) DEFAULT NULL,
  `Remark` varchar(250) DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblappointment`
--

INSERT INTO `tblappointment` (`ID`, `AppointmentNumber`, `UserID`, `ServiceId`, `AptDate`, `AptTime`, `Message`, `BookingDate`, `Status`, `Remark`, `UpdationDate`) VALUES
(16, 367757143, 17, 3, '2026-03-27', '05:00:00', 'is it available', '2026-03-20 10:07:20', 'Accepted', 'yes, thank you for choosing us', '2026-03-20 10:09:11'),
(18, 758709084, 25, NULL, '2026-03-21', '10:30:00', 'I want make over also', '2026-03-21 02:32:59', 'Rejected', 'sorry', '2026-04-05 05:16:27'),
(24, 780254526, 28, NULL, '2026-03-24', '11:00:00', '', '2026-03-23 02:21:45', 'Accepted', 'ok', '2026-03-23 11:57:12'),
(25, 197179095, 17, 10, '2026-03-23', '17:00:00', '', '2026-03-23 11:08:39', 'Rejected', 'Sorry Not available', '2026-03-23 11:20:35'),
(29, 151800483, 28, 3, '2026-03-25', '16:00:00', 'dsd', '2026-03-25 09:13:58', 'Accepted', 'ok', '2026-03-25 09:14:17'),
(32, 819561540, 26, 5, '2026-03-25', '18:00:00', 'hhh', '2026-03-25 11:30:08', 'Rejected', 'not available', '2026-03-25 11:30:31'),
(34, 226858478, 29, 13, '2026-03-29', '13:00:00', 'cvghjk', '2026-03-29 06:15:14', 'Rejected', 'sorry', '2026-04-05 05:16:13'),
(36, 834325476, 28, 19, '2026-03-29', '14:00:00', 'Come with clean skin first \r\n', '2026-03-29 07:19:24', 'Rejected', 'Sorry ', '2026-04-05 05:16:01'),
(37, 758781005, 28, 3, '2026-03-29', '15:00:00', 'Hello', '2026-03-29 08:37:04', 'Accepted', 'ok done', '2026-03-29 08:38:43'),
(38, 888872890, 29, 4, '2026-03-29', '15:00:00', 'smas', '2026-03-29 08:41:14', 'Accepted', 'Ok confirmed', '2026-03-29 08:42:24'),
(39, 672865053, 33, 8, '2026-03-30', '14:00:00', 'dsjkasjfa', '2026-03-30 08:05:11', 'Accepted', 'ok', '2026-03-30 08:05:36'),
(40, 267313818, 35, 13, '2026-04-05', '13:00:00', 'dfghj', '2026-04-05 06:55:29', 'Accepted', 'thank you', '2026-04-05 06:56:42'),
(42, 711387824, 29, 4, '2026-04-07', '10:00:00', 'fgf', '2026-04-06 09:57:30', 'Accepted', 'ddf', '2026-04-06 09:57:53'),
(48, 191710795, 29, 5, '2026-04-08', '09:00:00', 'dfdfdf', '2026-04-06 11:06:22', 'Accepted', 'fg', '2026-04-06 11:06:43'),
(50, 555769382, 29, 5, '2026-04-10', '10:00:00', 'I also wanna have a makeover', '2026-04-06 11:09:53', 'Accepted', 'Done', '2026-04-06 11:10:24'),
(51, 176776160, 29, 5, '2026-04-07', '13:00:00', 'nghjjdhgh', '2026-04-07 06:24:08', 'Accepted', 'available', '2026-04-07 06:25:23'),
(52, 375743152, 39, 4, '2026-04-08', '13:00:00', 'I am coming ', '2026-04-08 06:17:45', 'Accepted', 'Ok ', '2026-04-08 06:18:45'),
(53, 708452021, 39, 8, '2026-04-09', '09:00:00', 'Can you reply me fast\r\n', '2026-04-08 15:40:20', 'Accepted', 'confirmed', '2026-04-08 15:42:57'),
(54, 699812016, 40, 4, '2026-04-10', '09:00:00', 'project demo', '2026-04-09 06:48:53', 'Pending', NULL, NULL),
(55, 346597399, 29, 5, '2026-05-05', '09:00:00', 'sdsajfh', '2026-05-04 02:07:52', 'Accepted', 'ok done', '2026-05-04 02:08:37');

-- --------------------------------------------------------

--
-- Table structure for table `tblcontact`
--

CREATE TABLE `tblcontact` (
  `ID` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `Name` varchar(100) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Message` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `IsRead` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcontact`
--

INSERT INTO `tblcontact` (`ID`, `UserId`, `Name`, `Phone`, `Email`, `Message`, `PostingDate`, `IsRead`) VALUES
(3, NULL, 'aayusha', '984474647', 'aayusha090@gmail.com', 'hello ', '2026-03-09 05:29:07', 1),
(4, NULL, 'Anjan - Shrestha', '9846575665', 'anjanastha090@gmail.com', 'kndfjheehgjg', '2026-03-12 17:18:55', 1),
(6, NULL, 'anna ', '98364523', 'anna@gmail.com', 'hello which services you provide', '2026-03-19 03:23:23', 1),
(8, 18, 'kim Jisoo', '9824159000', 'jiso@1gmail.com', 'I want to ask for bridal services at 10 pm.', '2026-03-21 03:45:28', 1),
(10, NULL, 'Rajip Chaudhary', '9811111111', 'rajip@gmail.com', 'I want to book reservation for 2 days for my sister weeding.', '2026-04-07 13:39:10', 1),
(11, NULL, 'Ann Thakur', '9832222333', 'ann@gmail.com', 'I want too services for 2 days.', '2026-04-07 13:42:07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblinvoice`
--

CREATE TABLE `tblinvoice` (
  `id` int(11) NOT NULL,
  `Userid` int(11) DEFAULT NULL,
  `ServiceId` int(11) DEFAULT NULL,
  `BillingId` varchar(20) DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblinvoice`
--

INSERT INTO `tblinvoice` (`id`, `Userid`, `ServiceId`, `BillingId`, `PostingDate`) VALUES
(1, 1, 3, '280978104', '2026-03-18 15:40:27'),
(2, 1, 4, '280978104', '2026-03-18 15:40:27'),
(7, 17, 5, '298010981', '2026-03-19 14:27:27'),
(8, 17, 3, '923549381', '2026-03-19 16:15:25'),
(9, 17, 4, '923549381', '2026-03-19 16:15:25'),
(26, 39, 8, '623289619', '2026-04-08 15:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `tblpages`
--

CREATE TABLE `tblpages` (
  `ID` int(11) NOT NULL,
  `PageType` varchar(50) DEFAULT NULL,
  `PageTitle` varchar(200) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(12) DEFAULT NULL,
  `Timing` varchar(200) DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpages`
--

INSERT INTO `tblpages` (`ID`, `PageType`, `PageTitle`, `Email`, `MobileNumber`, `Timing`, `PageDescription`) VALUES
(1, 'contactus', 'Contact Us', 'parlour019@gmail.com', 9824152722, '10:00 am to 8:30 pm', 'Thamel, 16 Kathmandu Nepal');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `Image` varchar(200) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `MobileNumber` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `FullName`, `email`, `Image`, `password`, `role`, `created_at`, `MobileNumber`) VALUES
(1, 'Anjan - Shrestha', 'anjanstha090@gmail.com', NULL, '81dc9bdb52d04dc20036dbd8313ed055', 'user', '2026-01-03 17:26:07', '9866654435'),
(2, 'Sushmita Gurung', 'sushmitaa090@gmail.com', NULL, 'f4d87ed3b0dbf9c79746d00cedbb5e78', 'user', '2026-01-04 07:12:28', '9866666666'),
(5, 'tester', 'tester@gmail.com', NULL, '25d55ad283aa400af464c76d713c07ad', 'user', '2026-01-04 08:13:52', '1111111114'),
(10, 'maya gurung', 'maya@gmail.com', NULL, '6531401f9a6807306651b87e44c05751', 'user', '2026-03-14 16:00:22', '9845693425'),
(14, 'Sush Gurung', 'sush@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-03-19 07:21:18', '9823128885'),
(17, 'Priyanka Thakur', 'priyanka@123gmail.com', NULL, '00c66aaf5f2c3f49946f15c1ad2ea0d3', 'user', '2026-03-19 09:39:41', '9860522411'),
(18, 'Anu Thakur', 'admin1@gmail.com', '', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '2026-03-19 10:02:29', '9861318285'),
(23, 'Anjana Shrestha ', 'admin2@gmail.com', '', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '2026-03-21 01:21:40', '9824159063'),
(25, 'Prenaka Tamang', 'prenaka@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-03-21 02:32:03', '9824159066'),
(26, 'Nikesh Gajurel ', 'nikesh@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-03-22 04:59:48', '9811111111'),
(28, 'Seema Gurung', 'seema@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-03-22 15:51:16', '9815459036'),
(29, 'Deepa Sharma', 'deepa@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-03-26 05:37:26', '1111111111'),
(31, 'Sandip Shrestha', 'sandip@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-03-29 11:40:48', '4534242444'),
(32, 'kanchan', 'kanchan@gmail.com', NULL, '25d55ad283aa400af464c76d713c07ad', 'user', '2026-03-30 05:58:38', '9874545621'),
(33, 'Rubisha Pokhrel', 'rubisha@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-03-30 06:23:18', '2129837383'),
(34, 'Samyog Rai', 'samyog@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-03-30 08:50:06', '1111112111'),
(35, 'Ashisma Shrestha', 'ashisma@gmail.com', NULL, '9be38ef1b1ff5f7bbdf253681786bd25', 'user', '2026-04-05 06:52:36', '9876543216'),
(36, 'Bikram Gyawali ', 'bikram@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-04-07 07:12:55', '9876543211'),
(37, 'Ann Thakur', 'ann@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-04-07 13:27:08', '9832222333'),
(38, 'Adit Patel', 'adit@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-04-07 14:36:56', '9812121212'),
(39, 'Anju Thakur', 'anju@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-04-08 03:16:33', '9832222332'),
(40, 'project', 'project@gmail.com', NULL, '8722837b1443b111d2028d81e4168bb6', 'user', '2026-04-09 06:47:49', '9865432101');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_settings`
--
ALTER TABLE `about_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblappointment`
--
ALTER TABLE `tblappointment`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_UserAppointment` (`UserID`),
  ADD KEY `FK_ServiceAppointment` (`ServiceId`);

--
-- Indexes for table `tblcontact`
--
ALTER TABLE `tblcontact`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_contact_user` (`UserId`);

--
-- Indexes for table `tblinvoice`
--
ALTER TABLE `tblinvoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_UserInvoice` (`Userid`),
  ADD KEY `FK_ServiceInvoice` (`ServiceId`);

--
-- Indexes for table `tblpages`
--
ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_settings`
--
ALTER TABLE `about_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tblappointment`
--
ALTER TABLE `tblappointment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tblcontact`
--
ALTER TABLE `tblcontact`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblinvoice`
--
ALTER TABLE `tblinvoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tblpages`
--
ALTER TABLE `tblpages`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblappointment`
--
ALTER TABLE `tblappointment`
  ADD CONSTRAINT `FK_ServiceAppointment` FOREIGN KEY (`ServiceId`) REFERENCES `services` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_UserAppointment` FOREIGN KEY (`UserID`) REFERENCES `tblusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblcontact`
--
ALTER TABLE `tblcontact`
  ADD CONSTRAINT `fk_contact_user` FOREIGN KEY (`UserId`) REFERENCES `tblusers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tblinvoice`
--
ALTER TABLE `tblinvoice`
  ADD CONSTRAINT `FK_ServiceInvoice` FOREIGN KEY (`ServiceId`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_UserInvoice` FOREIGN KEY (`Userid`) REFERENCES `tblusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
