-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 25, 2025 at 07:40 PM
-- Server version: 10.11.11-MariaDB-0+deb12u1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ccm_muthaiga`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `booking_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `member_id` varchar(255) NOT NULL,
  `booking_type_id` varchar(255) NOT NULL,
  `club_id` varchar(255) NOT NULL,
  `arrival_at` varchar(255) NOT NULL,
  `departure_at` varchar(255) NOT NULL,
  `facility_camp_id` varchar(255) NOT NULL,
  `facility_id` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL DEFAULT '''0.00''',
  `transaction_code` varchar(255) NOT NULL,
  `payment_method_id` varchar(255) NOT NULL,
  `booking_status_id` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_calendar`
--

CREATE TABLE `booking_calendar` (
  `id` int(11) NOT NULL,
  `booking_calendar_id` varchar(255) NOT NULL,
  `booking_id` varchar(255) NOT NULL,
  `booking_at` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_detail`
--

CREATE TABLE `booking_detail` (
  `id` int(11) NOT NULL,
  `booking_detail_id` varchar(255) NOT NULL,
  `club_id` varchar(255) NOT NULL,
  `booking_id` varchar(255) NOT NULL,
  `guest_no` varchar(255) NOT NULL DEFAULT '0',
  `member_adult_no` int(11) NOT NULL DEFAULT 0,
  `member_child_no` int(11) NOT NULL DEFAULT 0,
  `guest_adult_no` int(11) NOT NULL DEFAULT 0,
  `guest_child_no` int(11) NOT NULL DEFAULT 0,
  `member_adult_overnight_no` int(11) NOT NULL DEFAULT 0,
  `member_child_overnight_no` int(11) NOT NULL DEFAULT 0,
  `guest_adult_overnight__no` int(11) NOT NULL DEFAULT 0,
  `guest_child_overnight_no` int(11) NOT NULL DEFAULT 0,
  `bill_amount` varchar(255) NOT NULL DEFAULT '0.00',
  `remark` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_detail_facility`
--

CREATE TABLE `booking_detail_facility` (
  `id` int(11) NOT NULL,
  `booking_detail_facility_id` varchar(255) NOT NULL,
  `booking_id` varchar(255) NOT NULL,
  `facility_camp_id` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_rate`
--

CREATE TABLE `booking_rate` (
  `id` int(11) NOT NULL,
  `booking_rate_id` varchar(255) NOT NULL,
  `booking_type_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `day_id` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `id` int(11) NOT NULL,
  `document_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `club_id` varchar(255) NOT NULL,
  `document_url` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `message_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_booking_type`
--

CREATE TABLE `m_booking_type` (
  `id` int(11) NOT NULL,
  `booking_type_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_cc_bcc`
--

CREATE TABLE `m_cc_bcc` (
  `id` int(11) NOT NULL,
  `cc_bcc_smtp_id` varchar(255) NOT NULL,
  `smtp_setting_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_day`
--

CREATE TABLE `m_day` (
  `id` int(11) NOT NULL,
  `day_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_facility`
--

CREATE TABLE `m_facility` (
  `id` int(11) NOT NULL,
  `facility_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_facility_camp`
--

CREATE TABLE `m_facility_camp` (
  `id` int(11) NOT NULL,
  `facility_camp_id` varchar(255) NOT NULL,
  `facility_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `full_legal_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_guest_type`
--

CREATE TABLE `m_guest_type` (
  `id` int(11) NOT NULL,
  `guest_type_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_joining_fee`
--

CREATE TABLE `m_joining_fee` (
  `id` int(11) NOT NULL,
  `joining_fee_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `member_id` varchar(255) NOT NULL,
  `joining_fee_type_id` varchar(255) NOT NULL,
  `membership_type_id` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `currency_id` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `due_at` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_joining_fee_type`
--

CREATE TABLE `m_joining_fee_type` (
  `id` int(11) NOT NULL,
  `joining_fee_type_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `currency_id` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `state` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_membership`
--

CREATE TABLE `m_membership` (
  `id` int(11) NOT NULL,
  `membership_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_member_type`
--

CREATE TABLE `m_member_type` (
  `id` int(11) NOT NULL,
  `member_type_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `currency_id` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL DEFAULT '''0.00''',
  `year` int(11) NOT NULL DEFAULT 2025,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_member_type`
--

INSERT INTO `m_member_type` (`id`, `member_type_id`, `name`, `currency_id`, `amount`, `year`, `state`, `active`, `updated_at`, `created_at`) VALUES
(1, '17543450598', 'Test', '', '1000.00', 2025, 1, 1, '2025-08-21 20:23:26', '2025-08-21 20:23:26');

-- --------------------------------------------------------

--
-- Table structure for table `m_product_category`
--

CREATE TABLE `m_product_category` (
  `id` int(11) NOT NULL,
  `product_category_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_product_type`
--

CREATE TABLE `m_product_type` (
  `id` int(11) NOT NULL,
  `product_type_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_smtp_email`
--

CREATE TABLE `m_smtp_email` (
  `id` int(11) NOT NULL,
  `smtp_email_id` varchar(255) NOT NULL,
  `smtp_setting_id` varchar(255) NOT NULL,
  `cc_bcc_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_smtp_setting`
--

CREATE TABLE `m_smtp_setting` (
  `id` int(11) NOT NULL,
  `smtp_setting_id` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `smtp_secure` varchar(255) NOT NULL,
  `smtp_auth` varchar(255) NOT NULL,
  `email_from` varchar(255) NOT NULL,
  `reply_to_email` varchar(255) NOT NULL,
  `smtp_auto_tls` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_subscription_type`
--

CREATE TABLE `m_subscription_type` (
  `id` int(11) NOT NULL,
  `subscription_type_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `currency_id` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_user_type`
--

CREATE TABLE `m_user_type` (
  `id` int(11) NOT NULL,
  `user_type_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `state` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notice_board`
--

CREATE TABLE `notice_board` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` varchar(255) NOT NULL,
  `notice_board_id` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL,
  `payment_history_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `booking_id` varchar(255) NOT NULL DEFAULT 'N/A',
  `subscription_id` varchar(255) NOT NULL DEFAULT 'N/A',
  `joining_fee_id` varchar(255) NOT NULL DEFAULT 'N/A',
  `product_id` varchar(255) NOT NULL DEFAULT 'N/A',
  `transaction_code` varchar(255) NOT NULL,
  `bill_amount` varchar(255) NOT NULL DEFAULT '0.00',
  `paid_amount` varchar(255) NOT NULL DEFAULT '0.00',
  `payment_method_id` varchar(255) NOT NULL,
  `payment_status_id` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_category_id` varchar(255) NOT NULL,
  `product_type_id` varchar(255) NOT NULL,
  `currency_id` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `event_at` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `expiry_at` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `state` int(1) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `id` int(11) NOT NULL,
  `subscription_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `member_id` varchar(255) NOT NULL,
  `membership_fee_type_id` varchar(255) NOT NULL,
  `due_at` varchar(255) NOT NULL,
  `currency_id` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_us`
--

CREATE TABLE `support_us` (
  `id` int(11) NOT NULL,
  `support_us_id` varchar(255) NOT NULL,
  `full_legal_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `issue` text NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type_id` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT 'assets/img/',
  `title_id` varchar(255) NOT NULL,
  `full_legal_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender_id` varchar(255) DEFAULT NULL,
  `birth` varchar(255) DEFAULT NULL,
  `country_id` varchar(255) DEFAULT NULL,
  `id_no` varchar(225) DEFAULT NULL,
  `residential_address` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_address` varchar(225) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `town_id` varchar(225) DEFAULT NULL,
  `city_id` varchar(255) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `membership_id` varchar(255) DEFAULT NULL,
  `membership_no` varchar(255) DEFAULT NULL,
  `member_type_id` varchar(255) NOT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_phone_no` varchar(255) DEFAULT NULL,
  `sub_reference_no` varchar(255) DEFAULT NULL,
  `designation_id` varchar(255) DEFAULT NULL,
  `citizenship_id` varchar(255) DEFAULT NULL,
  `membership_type_id` varchar(255) NOT NULL DEFAULT 'N/A',
  `sms_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activation_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_at` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `reset` int(11) NOT NULL DEFAULT 0,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_id`, `user_type_id`, `url`, `title_id`, `full_legal_name`, `phone_number`, `email`, `gender_id`, `birth`, `country_id`, `id_no`, `residential_address`, `postal_address`, `postal_code`, `town_id`, `city_id`, `remark`, `password`, `membership_id`, `membership_no`, `member_type_id`, `contact_name`, `contact_phone_no`, `sub_reference_no`, `designation_id`, `citizenship_id`, `membership_type_id`, `sms_code`, `activation_token`, `joining_at`, `email_verified_at`, `reset`, `state`, `active`, `updated_at`, `created_at`) VALUES
(1, '1770383887643', '4534654653', 'assets/img/', '', 'Kelvin Muli', NULL, 'nmclubadmin@gmail.com', '', '', '', '', NULL, '', '', '', '', '', '$2y$10$ACOr5mQDDRtDrRsRfDJ3kOqn7VlxomzFt5Sq9AA7RKzdrl3K4lkL.', '', '', '', '', '', '', '', '', 'N/A', NULL, NULL, '', NULL, 1, 1, 1, '2025-08-24 23:11:16', '2025-08-16 23:55:24'),
(2, '177038753942', '1755383886420', 'assets/img/', '', 'Kelvin Muli', NULL, 'nmmember@gmail.com', '', '', '', '', NULL, '', '', '', '', '', '$2y$10$ACOr5mQDDRtDrRsRfDJ3kOqn7VlxomzFt5Sq9AA7RKzdrl3K4lkL.', '', '', '', '', '', '', '', '', 'N/A', NULL, NULL, '', NULL, 1, 1, 1, '2025-08-24 23:13:12', '2025-08-16 23:55:24');

-- --------------------------------------------------------

--
-- Table structure for table `user_right`
--

CREATE TABLE `user_right` (
  `id` int(11) NOT NULL,
  `user_right_id` varchar(255) NOT NULL,
  `user_type_id` varchar(255) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  `view` int(11) NOT NULL DEFAULT 1,
  `figure` int(11) NOT NULL DEFAULT 0,
  `privacy` int(11) NOT NULL DEFAULT 0,
  `approve` int(11) NOT NULL DEFAULT 0,
  `input` int(11) NOT NULL DEFAULT 0,
  `edit` int(11) NOT NULL DEFAULT 0,
  `remove` int(11) NOT NULL DEFAULT 0,
  `state` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `user_right`
--

INSERT INTO `user_right` (`id`, `user_right_id`, `user_type_id`, `module_id`, `view`, `figure`, `privacy`, `approve`, `input`, `edit`, `remove`, `state`, `updated_at`, `created_at`) VALUES
(1, '1755448605161', '4534654653', '61134678909', 1, 0, 0, 0, 0, 0, 0, 1, '2025-08-17 15:18:43', '2025-08-17 15:18:43'),
(2, '175544705170', '4534654653', '62230678800', 1, 0, 0, 0, 1, 1, 1, 1, '2025-08-25 10:45:23', '2025-08-17 15:19:19'),
(3, '1755443043491', '4534654653', '62306723120', 1, 0, 0, 0, 0, 0, 0, 1, '2025-08-17 15:19:23', '2025-08-17 15:19:23'),
(4, '1755443137490', '4534654653', '17097446458', 0, 0, 0, 0, 0, 0, 0, 1, '2025-08-25 10:45:11', '2025-08-17 15:19:33'),
(5, '1755448977186', '4534654653', '17894946752', 0, 0, 0, 0, 0, 0, 0, 1, '2025-08-25 10:45:31', '2025-08-17 15:19:39'),
(6, '1755445385520', '4534654653', '17804724081', 0, 0, 0, 0, 0, 0, 0, 1, '2025-08-25 10:45:37', '2025-08-17 15:19:44'),
(7, '1755448104667', '4534654653', '1635853924', 0, 0, 0, 0, 0, 0, 0, 1, '2025-08-25 10:45:43', '2025-08-17 15:20:06'),
(8, '1755447711474', '4534654653', '1636554968', 0, 0, 0, 0, 0, 0, 0, 1, '2025-08-25 10:45:50', '2025-08-17 15:20:18'),
(9, '1755441009901', '4534654653', '1630914321', 0, 0, 0, 0, 0, 0, 0, 1, '2025-08-25 10:45:55', '2025-08-17 15:20:31'),
(10, '1755447591744', '1755383886420', '61134678909', 1, 0, 0, 0, 0, 0, 0, 1, '2025-08-17 15:21:06', '2025-08-17 15:21:06'),
(11, '1755445499915', '1755383886420', '17097446458', 0, 0, 0, 0, 0, 0, 0, 1, '2025-08-25 10:44:24', '2025-08-17 15:21:13'),
(12, '1755446841194', '1755383886420', '17894946752', 0, 0, 0, 0, 0, 0, 0, 1, '2025-08-25 10:44:20', '2025-08-17 15:21:17'),
(13, '1755448101089', '1755383886420', '17804724081', 0, 0, 0, 0, 0, 0, 0, 1, '2025-08-25 10:44:18', '2025-08-17 15:21:23'),
(14, '1755445266388', '1755383886420', '73833067810', 0, 0, 0, 0, 0, 0, 0, 1, '2025-08-25 10:44:10', '2025-08-17 15:21:36'),
(15, '1755447449186', '1755383886420', '1636554968', 0, 0, 0, 0, 0, 0, 0, 1, '2025-08-25 10:44:37', '2025-08-17 15:21:47'),
(16, '1755448869872', '1755383886420', '1630914321', 0, 0, 0, 0, 0, 0, 0, 1, '2025-08-25 10:44:46', '2025-08-17 15:22:00'),
(17, '1756118897434', '1755383886420', '62230678800', 1, 0, 0, 0, 0, 0, 0, 1, '2025-08-25 10:44:30', '2025-08-25 10:44:30'),
(18, '1756115202602', '1755383886420', '62306723120', 1, 0, 0, 0, 0, 0, 0, 1, '2025-08-25 10:44:32', '2025-08-25 10:44:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_id` (`booking_id`);

--
-- Indexes for table `booking_calendar`
--
ALTER TABLE `booking_calendar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_calendar_id` (`booking_calendar_id`);

--
-- Indexes for table `booking_detail`
--
ALTER TABLE `booking_detail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_detail_id` (`booking_detail_id`);

--
-- Indexes for table `booking_detail_facility`
--
ALTER TABLE `booking_detail_facility`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_detail_facility_id` (`booking_detail_facility_id`);

--
-- Indexes for table `booking_rate`
--
ALTER TABLE `booking_rate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_booking_type`
--
ALTER TABLE `m_booking_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_type_id` (`booking_type_id`);

--
-- Indexes for table `m_cc_bcc`
--
ALTER TABLE `m_cc_bcc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cc_bcc_smtp_id` (`cc_bcc_smtp_id`);

--
-- Indexes for table `m_day`
--
ALTER TABLE `m_day`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_calendar_id` (`day_id`);

--
-- Indexes for table `m_facility`
--
ALTER TABLE `m_facility`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `facility_id` (`facility_id`);

--
-- Indexes for table `m_facility_camp`
--
ALTER TABLE `m_facility_camp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `facility_camp_id` (`facility_camp_id`);

--
-- Indexes for table `m_guest_type`
--
ALTER TABLE `m_guest_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guest_type_id` (`guest_type_id`);

--
-- Indexes for table `m_joining_fee`
--
ALTER TABLE `m_joining_fee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_joining_fee_type`
--
ALTER TABLE `m_joining_fee_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_membership`
--
ALTER TABLE `m_membership`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_calendar_id` (`membership_id`);

--
-- Indexes for table `m_member_type`
--
ALTER TABLE `m_member_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guest_type_id` (`member_type_id`);

--
-- Indexes for table `m_product_category`
--
ALTER TABLE `m_product_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_category_id` (`product_category_id`);

--
-- Indexes for table `m_product_type`
--
ALTER TABLE `m_product_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_type_id` (`product_type_id`);

--
-- Indexes for table `m_smtp_email`
--
ALTER TABLE `m_smtp_email`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cc_bcc_smtp_id` (`smtp_email_id`);

--
-- Indexes for table `m_smtp_setting`
--
ALTER TABLE `m_smtp_setting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `smtp_setting_id` (`smtp_setting_id`);

--
-- Indexes for table `m_subscription_type`
--
ALTER TABLE `m_subscription_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_user_type`
--
ALTER TABLE `m_user_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `audit_recommendation_id` (`user_type_id`);

--
-- Indexes for table `notice_board`
--
ALTER TABLE `notice_board`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_history_id` (`payment_history_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_us`
--
ALTER TABLE `support_us`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `support_us_id` (`support_us_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `user_right`
--
ALTER TABLE `user_right`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_right_id` (`user_right_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_calendar`
--
ALTER TABLE `booking_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_detail`
--
ALTER TABLE `booking_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_detail_facility`
--
ALTER TABLE `booking_detail_facility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_rate`
--
ALTER TABLE `booking_rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_booking_type`
--
ALTER TABLE `m_booking_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_cc_bcc`
--
ALTER TABLE `m_cc_bcc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_day`
--
ALTER TABLE `m_day`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_facility`
--
ALTER TABLE `m_facility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_facility_camp`
--
ALTER TABLE `m_facility_camp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_guest_type`
--
ALTER TABLE `m_guest_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_joining_fee`
--
ALTER TABLE `m_joining_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_joining_fee_type`
--
ALTER TABLE `m_joining_fee_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_membership`
--
ALTER TABLE `m_membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_member_type`
--
ALTER TABLE `m_member_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_product_category`
--
ALTER TABLE `m_product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_product_type`
--
ALTER TABLE `m_product_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_smtp_email`
--
ALTER TABLE `m_smtp_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_smtp_setting`
--
ALTER TABLE `m_smtp_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_subscription_type`
--
ALTER TABLE `m_subscription_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_user_type`
--
ALTER TABLE `m_user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notice_board`
--
ALTER TABLE `notice_board`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_us`
--
ALTER TABLE `support_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_right`
--
ALTER TABLE `user_right`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
