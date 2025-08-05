-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2025 at 07:55 PM
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
-- Database: `core_clubmember_app`
--

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

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('2afd0n9sdq0sspc0598c6pqi7q2f8n7v', '::1', 1754391502, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343339313530323b737563636573737c733a36373a22446174616261736520636f6e66696775726174696f6e207361766564207375636365737366756c6c792e204442204e616d653a206e65775f6d757468616967615f6462223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('3qfhjebn155uqk37s5aig22t5u813efp', '::1', 1754393446, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343339333434363b),
('5hh6ovqvsdbb1eqhloifq9pqjg8uftbi', '::1', 1754386678, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343338363637383b),
('9k22thmn0b29eg0f50v6blngev710tud', '::1', 1754389735, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343338393733353b),
('a1e438jao0uc1d4mcgnc86blr3h7qdqv', '::1', 1754389346, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343338393334363b737563636573737c733a34363a22437573746f6d6572202246696e6e2043616c6465726f6e222063726561746564207375636365737366756c6c792e223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('g1g1asi5umbranjpn5s1nd2nsseq146h', '::1', 1754390627, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343339303632373b),
('g8fpmjlam7filvgls02c2ccr2iif8bt2', '::1', 1754393837, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343339333737313b),
('h9fprh63a96nmi8vptjscru29qulb6tm', '::1', 1754393771, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343339333737313b),
('kamlkr3ggetgak33jg5ptidjud3ulif9', '::1', 1754388966, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343338383936363b737563636573737c733a33303a22437573746f6d65722064656c65746564207375636365737366756c6c792e223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('oe1psfe88l7pektghiivni4j8rc0n0p1', '::1', 1754391115, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343339313131353b),
('pkqerrki832ch4s984pgnnmsluhrv0f7', '::1', 1754388093, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343338383039333b737563636573737c733a33363a22437573746f6d65722063726561746564207375636365737366756c6c792e2049443a2030223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('rcdpnlbfejr15ceh5u7rj618pr50cvkq', '::1', 1754387526, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343338373532363b),
('sajj18jolvssf2ai1d2n5epinl4di5pe', '::1', 1754393016, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343339333031363b),
('u3qpgmdr4em40ur4a58npcs188fa6b93', '::1', 1754388662, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343338383636323b737563636573737c733a34363a22437573746f6d65722063726561746564207375636365737366756c6c792e20437573746f6d6572204e616d653a20223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('v2tn0q46p67u3gmp8esl5gjdsh640c5h', '::1', 1754386355, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343338363335353b),
('vd0j1ur4910p1nikl9h85d0jdeg7cbr0', '::1', 1754392714, 0x5f5f63695f6c6173745f726567656e65726174657c693a313735343339323731343b737563636573737c733a36333a22446174616261736520636f6e66696775726174696f6e207361766564207375636365737366756c6c792e204442204e616d653a20416d61796120506572657a223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d);

-- --------------------------------------------------------

--
-- Table structure for table `club_member_admin`
--

CREATE TABLE `club_member_admin` (
  `user_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `email_address` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` enum('Active','Inactive','Suspended') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `club_member_audit_logs`
--

CREATE TABLE `club_member_audit_logs` (
  `audit_log_id` bigint(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `entity_type` varchar(100) DEFAULT NULL,
  `entity_id` varchar(255) DEFAULT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `club_member_billing_plan`
--

CREATE TABLE `club_member_billing_plan` (
  `billing_plan_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `cost_per_user_per_month` decimal(10,2) NOT NULL,
  `features` text DEFAULT NULL COMMENT 'JSON or comma-separated list of features',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `club_member_editions`
--

CREATE TABLE `club_member_editions` (
  `edition_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `edition_code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `club_member_edition_modules`
--

CREATE TABLE `club_member_edition_modules` (
  `edition_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `club_member_email_settings`
--

CREATE TABLE `club_member_email_settings` (
  `email_setting_id` int(11) NOT NULL,
  `config_name` varchar(100) NOT NULL,
  `host` varchar(255) NOT NULL,
  `port` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL COMMENT 'Store encrypted',
  `encryption` enum('None','SSL','TLS') DEFAULT NULL,
  `from_email` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `club_member_error_logs`
--

CREATE TABLE `club_member_error_logs` (
  `error_id` bigint(20) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `level` varchar(20) NOT NULL COMMENT 'e.g., ERROR, WARNING, INFO',
  `message` text NOT NULL,
  `stack_trace` text DEFAULT NULL,
  `context` text DEFAULT NULL COMMENT 'JSON containing context data',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `club_member_gateway`
--

CREATE TABLE `club_member_gateway` (
  `club_member_gateway_id` int(11) NOT NULL,
  `payment_gateway_provider_id` int(11) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `merchant_id` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `club_member_modules`
--

CREATE TABLE `club_member_modules` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `module_code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `club_member_payment_gateway_providers`
--

CREATE TABLE `club_member_payment_gateway_providers` (
  `payment_gateway_provider_id` int(11) NOT NULL,
  `payment_provider` varchar(100) NOT NULL,
  `gateway_name` varchar(100) NOT NULL,
  `api_base_url` varchar(255) DEFAULT NULL,
  `call_back_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `club_member_scheduled_tasks`
--

CREATE TABLE `club_member_scheduled_tasks` (
  `task_id` int(11) NOT NULL,
  `task_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `cron_schedule` varchar(100) NOT NULL,
  `last_run_at` datetime DEFAULT NULL,
  `next_run_at` datetime DEFAULT NULL,
  `status` enum('Enabled','Disabled','Running') DEFAULT 'Enabled',
  `last_run_message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `club_member_settings`
--

CREATE TABLE `club_member_settings` (
  `setting_id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel_no` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `town` varchar(20) NOT NULL,
  `reg_no` varchar(20) NOT NULL,
  `physical_address` text NOT NULL,
  `postal_address` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `agreement` varchar(255) NOT NULL,
  `type` enum('Club','Association') NOT NULL,
  `status` enum('Active','Inactive','Trial','Suspended') DEFAULT 'Trial',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer_id`, `name`, `short_name`, `email`, `tel_no`, `country`, `town`, `reg_no`, `physical_address`, `postal_address`, `logo`, `agreement`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 1754388821, 'New Muthaiga Residents Association', 'NMRA', 'committee@newmuthaiga.com', '0726542690', 'Kenya', '', 'CPE/002/2025', 'Nairobi, Kenya', '00508-00100', 'logo_1754388821.png', 'agreement_1754388821.png', 'Club', 'Active', '2025-08-05 10:13:41', '2025-08-05 10:16:31'),
(2, 1754388857, 'Kenya Fly Fishers\' Club', 'Burton Duke', 'info@mailinator.com', '0726542690', 'Kenya', '', 'CPE/002/2025', '76038', '98989', '1000345569.png', '10003455691.png', 'Club', 'Trial', '2025-08-05 10:14:17', '2025-08-05 10:17:30'),
(6, 1754389250, 'Finn Calderonvvv', 'Clarke Gilliam', 'hebu@mailinator.com', '25', 'Other', '', 'Eu recusandae Assum', 'Ipsum rerum aut inci', 'Inventore voluptate ', 'logo_1754389250.png', 'agreement_1754389250.png', 'Association', 'Suspended', '2025-08-05 10:20:50', '2025-08-05 11:33:45');

-- --------------------------------------------------------

--
-- Table structure for table `customer_admin`
--

CREATE TABLE `customer_admin` (
  `customer_admin_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL COMMENT 'Could be a GUID or from an external auth provider',
  `customer_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `email_address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_billing`
--

CREATE TABLE `customer_billing` (
  `customer_billing_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `billing_plan_id` int(11) NOT NULL,
  `no_of_users` int(11) NOT NULL,
  `max_storage` int(11) DEFAULT NULL COMMENT 'Storage in MB',
  `plan_type` enum('Trial','Annual','Monthly','Quarterly') NOT NULL,
  `start_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `status` enum('Active','Expired','Cancelled') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_billing_modules`
--

CREATE TABLE `customer_billing_modules` (
  `customer_billing_module_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_billing_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `configuration1` text DEFAULT NULL,
  `configuration2` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_billing_payments`
--

CREATE TABLE `customer_billing_payments` (
  `payment_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_billing_id` int(11) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_details` text DEFAULT NULL COMMENT 'e.g., Transaction ID, Check Number',
  `lpo_no` varchar(100) DEFAULT NULL,
  `invoice_no` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `plan_start_date` date NOT NULL,
  `plan_expiry_date` date NOT NULL,
  `status` enum('Completed','Pending','Failed') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_db_settings`
--

CREATE TABLE `customer_db_settings` (
  `id` int(11) NOT NULL,
  `customer_db_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `sub_domain` varchar(100) NOT NULL,
  `database_name` varchar(100) NOT NULL,
  `database_user` varchar(100) NOT NULL,
  `database_pwd` varchar(255) NOT NULL COMMENT 'Store encrypted',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_email_settings`
--

CREATE TABLE `customer_email_settings` (
  `customer_email_setting_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `config_name` varchar(100) NOT NULL,
  `host` varchar(255) NOT NULL,
  `port` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL COMMENT 'Store encrypted',
  `encryption` enum('None','SSL','TLS') DEFAULT NULL,
  `from_email` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment_gateway`
--

CREATE TABLE `customer_payment_gateway` (
  `customer_payment_gateway_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_gateway_provider_id` int(11) NOT NULL,
  `secret_key` varchar(255) DEFAULT NULL,
  `merchant_id` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entities`
--

CREATE TABLE `entities` (
  `entity_id` int(11) NOT NULL,
  `entity_type` varchar(100) NOT NULL COMMENT 'e.g., customer, club_member_settings',
  `reference_id` int(11) NOT NULL COMMENT 'The ID of the record in the respective table',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_module`
--

CREATE TABLE `maintenance_module` (
  `id` int(11) NOT NULL,
  `module_id` varchar(225) NOT NULL,
  `name` varchar(225) NOT NULL,
  `module_tag` varchar(225) NOT NULL,
  `module_icon` varchar(225) NOT NULL,
  `path` varchar(225) NOT NULL,
  `withsub` int(11) NOT NULL DEFAULT 0,
  `main_id` varchar(225) NOT NULL,
  `sub` int(11) NOT NULL DEFAULT 0,
  `state` int(11) NOT NULL DEFAULT 0,
  `divider` int(11) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `maintenance_module`
--

INSERT INTO `maintenance_module` (`id`, `module_id`, `name`, `module_tag`, `module_icon`, `path`, `withsub`, `main_id`, `sub`, `state`, `divider`, `order`) VALUES
(1, 'c78d7c5c376ca', 'Dashboard', 'H', 'dashboard', 'dashboard', 0, '', 0, 1, 0, 1),
(2, 'yuiommg6', 'Joining Fees', 'L', 'money', '', 1, '', 0, 1, 0, 2),
(3, 'Chort1D78', 'Listing', 'PL', '', 'joining_listing', 0, 'yuiommg6', 1, 1, 0, 2),
(4, 'CAoj9Xr1D7', 'Add Joining Fees', 'PSL', '', 'joining_setup', 0, 'yuiommg6', 1, 1, 0, 2),
(20, 'oiiiooomm', 'Clubs', 'SS', 'home', '', 1, '', 0, 1, 0, 7),
(21, 'c78d7chghfg5c3u8ca', 'Club Listing', 'OS', '', 'club_listing', 0, 'oiiiooomm', 1, 1, 0, 7),
(22, 'tyuio767', 'Club Admin Listing', 'HR', '', 'user_listing', 0, 'oiiiooomm', 1, 1, 0, 7),
(23, 'J8cL5x5HUK', 'Members', 'EMP', 'group', '', 1, '', 0, 1, 0, 6),
(24, 'tyuiogt767', 'Members Listing', 'EMS', '', 'member_listing', 0, 'J8cL5x5HUK', 1, 1, 0, 6),
(26, 'tyuio767ef', 'Listing', 'ASL', '', 'subscription_listing', 0, 'c78d7ubc38cat', 1, 1, 0, 3),
(27, 'c78d7ubc38cat', 'Subscriptions', 'SC', 'move_to_inbox', '', 1, '', 0, 1, 0, 3),
(28, 'c78d7ubc38cattt', 'Bookings', 'IR', 'apps', '', 1, '', 0, 1, 0, 4),
(29, 'tyuio767efttt', 'Add Booking', 'ILG', '', 'add-booking', 0, 'c78d7ubc38cattt', 1, 1, 0, 4),
(30, 'c78d7ubc38carrrttt', 'Shop', 'IV', 'web', '', 1, '', 0, 1, 0, 5),
(31, 'tyuio767etrerfttt', 'Shop Listing', 'INL', '', 'shop-listing-view', 0, 'c78d7ubc38carrrttt', 1, 1, 0, 5),
(32, 'c78d7c5c376caaaa', 'System Settings', 'AR', 'settings', 'admin/UserRight', 1, '', 0, 1, 0, 11),
(33, 'tyuio767ef', 'Add Subscription ', 'ASLS', '', 'subscription_setup', 0, 'c78d7ubc38cat', 1, 1, 0, 3),
(34, 'tyuio767efttt', 'Booking Listing', 'ILG', '', 'booking_listing', 0, 'c78d7ubc38cattt', 1, 1, 0, 4),
(35, 'c78d7c5c376bbbbbbbbb', 'SMTP Setup', 'SP', 'settings', 'smtp_setup', 0, 'c78d7c5c376caaaa', 1, 1, 0, 9),
(36, 'c78d7c5c376caaaann', 'User Rights', 'AR', 'settings', 'admin/UserRight', 0, 'c78d7c5c376caaaa', 1, 1, 0, 11),
(37, 'tyuio767ef', 'Bulk Subscription ', 'ASLS', '', 'bulk_subscription', 0, 'c78d7ubc38cat', 1, 1, 0, 3),
(38, 'tyuio767efttt', 'Past Bookings Report', 'PBR', '', 'booking_past_report', 0, 'c78d7ubc38cattt', 1, 1, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `m_city`
--

CREATE TABLE `m_city` (
  `id` int(11) NOT NULL,
  `city_id` varchar(255) NOT NULL,
  `country_id` varchar(255) NOT NULL DEFAULT '764520317',
  `name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 0,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_city`
--

INSERT INTO `m_city` (`id`, `city_id`, `country_id`, `name`, `state`, `active`, `updated_at`, `created_at`) VALUES
(1, '1752918122269', '6102800116', 'Mombasa', 1, 1, '2025-07-19 07:43:48', '2025-07-19 07:43:48'),
(2, '1752912573903', '6102800116', 'Kwale', 1, 1, '2025-07-19 07:44:27', '2025-07-19 07:44:27'),
(3, '1752912684852', '6102800116', 'Kilifi', 1, 1, '2025-07-19 07:45:09', '2025-07-19 07:45:09'),
(4, '1752917929052', '6102800116', 'Tana River', 1, 1, '2025-07-19 07:45:58', '2025-07-19 07:45:58'),
(5, '1752914135679', '6102800116', 'Lamu', 1, 1, '2025-07-19 07:46:19', '2025-07-19 07:46:19'),
(6, '1752912541641', '6102800116', 'Taita-Taveta', 1, 1, '2025-07-19 07:46:46', '2025-07-19 07:46:46'),
(7, '1752913635658', '6102800116', 'Garissa', 1, 1, '2025-07-19 07:47:28', '2025-07-19 07:47:28'),
(8, '1752917826211', '6102800116', 'Wajir', 1, 1, '2025-07-19 07:47:45', '2025-07-19 07:47:45'),
(9, '1752914752238', '6102800116', 'Mandera', 1, 1, '2025-07-19 07:48:47', '2025-07-19 07:48:47'),
(10, '1752917846540', '6102800116', 'Marsabit', 1, 1, '2025-07-19 07:49:34', '2025-07-19 07:49:34'),
(11, '1752914554979', '6102800116', 'Isiolo', 1, 1, '2025-07-19 07:49:58', '2025-07-19 07:49:58'),
(12, '1752911975266', '6102800116', 'Meru', 1, 1, '2025-07-19 07:50:19', '2025-07-19 07:50:19'),
(13, '1752912975956', '6102800116', 'Tharaka-Nithi', 1, 1, '2025-07-19 07:50:53', '2025-07-19 07:50:53'),
(14, '1752914224107', '6102800116', 'Embu', 1, 1, '2025-07-19 07:51:17', '2025-07-19 07:51:17'),
(15, '1752911368939', '6102800116', 'Kitui', 1, 1, '2025-07-19 07:51:39', '2025-07-19 07:51:39'),
(16, '1752911142422', '6102800116', 'Machakos', 1, 1, '2025-07-19 07:51:58', '2025-07-19 07:51:58'),
(17, '1752912067247', '6102800116', 'Makueni', 1, 1, '2025-07-19 07:52:28', '2025-07-19 07:52:28'),
(18, '1752913040029', '6102800116', 'Nyandarua', 1, 1, '2025-07-19 07:52:51', '2025-07-19 07:52:51'),
(19, '1752917537577', '6102800116', 'Nyeri', 1, 1, '2025-07-19 08:34:04', '2025-07-19 08:34:04'),
(20, '1752915008412', '6102800116', 'Kirinyaga', 1, 1, '2025-07-19 08:34:37', '2025-07-19 08:34:37'),
(21, '1752916779378', '6102800116', 'Murang\'a', 1, 1, '2025-07-19 08:35:21', '2025-07-19 08:35:21'),
(22, '1752913977773', '6102800116', 'Kiambu', 1, 1, '2025-07-19 08:39:34', '2025-07-19 08:39:34'),
(23, '1752918233873', '6102800116', 'Turkana', 1, 1, '2025-07-19 08:39:52', '2025-07-19 08:39:52'),
(24, '1752912419488', '6102800116', 'West Pokot ', 1, 1, '2025-07-19 08:40:11', '2025-07-19 08:40:11'),
(25, '1752916021122', '6102800116', 'Samburu', 1, 1, '2025-07-19 08:40:39', '2025-07-19 08:40:39'),
(26, '1752911890048', '6102800116', 'Trans Nzoia', 1, 1, '2025-07-19 08:41:38', '2025-07-19 08:41:38'),
(27, '1752915714986', '6102800116', 'Uasin Gishu', 1, 1, '2025-07-19 08:42:32', '2025-07-19 08:42:32'),
(28, '1752917871713', '6102800116', 'Elgeyo-Marakwet', 1, 1, '2025-07-19 08:43:06', '2025-07-19 08:43:06'),
(29, '1752913976816', '6102800116', 'Nandi', 1, 1, '2025-07-19 08:43:32', '2025-07-19 08:43:32'),
(30, '1752914499737', '6102800116', 'Baringo', 1, 1, '2025-07-19 08:43:54', '2025-07-19 08:43:54'),
(31, '1752916530771', '6102800116', 'Laikipia', 1, 1, '2025-07-19 08:44:25', '2025-07-19 08:44:25'),
(32, '1752913053930', '6102800116', 'Nakuru', 1, 1, '2025-07-19 08:44:53', '2025-07-19 08:44:53'),
(33, '1752914274039', '6102800116', 'Narok', 1, 1, '2025-07-19 08:45:12', '2025-07-19 08:45:12'),
(34, '1752911712077', '6102800116', 'Kajiado', 1, 1, '2025-07-19 08:45:40', '2025-07-19 08:45:40'),
(35, '1752917419188', '6102800116', 'Kericho', 1, 1, '2025-07-19 08:47:27', '2025-07-19 08:47:27'),
(36, '1752916857522', '6102800116', 'Bomet', 1, 1, '2025-07-19 08:47:50', '2025-07-19 08:47:50'),
(37, '1752916266683', '6102800116', 'Kakamega', 1, 1, '2025-07-19 08:57:25', '2025-07-19 08:57:25'),
(38, '1752911149441', '6102800116', 'Vihiga', 1, 1, '2025-07-19 08:58:01', '2025-07-19 08:58:01'),
(39, '1752913802291', '6102800116', 'Bungoma', 1, 1, '2025-07-19 09:00:06', '2025-07-19 09:00:06'),
(40, '1752915007124', '6102800116', 'Busia', 1, 1, '2025-07-19 09:00:39', '2025-07-19 09:00:39'),
(41, '1752918826795', '6102800116', 'Siaya', 1, 1, '2025-07-19 09:01:05', '2025-07-19 09:01:05'),
(42, '1752912536877', '6102800116', 'Kisumu', 1, 1, '2025-07-19 09:01:27', '2025-07-19 09:01:27'),
(43, '1752915593061', '6102800116', 'Homa Bay', 1, 1, '2025-07-19 09:01:49', '2025-07-19 09:01:49'),
(44, '1752917573133', '6102800116', 'Migori', 1, 1, '2025-07-19 09:06:51', '2025-07-19 09:06:51'),
(45, '1752913216965', '6102800116', 'Kisii', 1, 1, '2025-07-19 09:07:59', '2025-07-19 09:07:59'),
(46, '1752916958424', '6102800116', 'Nyamira', 1, 1, '2025-07-19 09:08:38', '2025-07-19 09:08:38'),
(47, '1752917060602', '6102800116', 'Nairobi', 1, 1, '2025-07-19 09:08:58', '2025-07-19 09:08:58'),
(55, '1752927344473', '6102800223', 'Arusha', 1, 1, '2025-07-19 11:46:09', '2025-07-19 11:46:09'),
(56, '1752922987287', '6102800223', 'Dar es Salaam', 1, 1, '2025-07-19 11:47:35', '2025-07-19 11:47:35'),
(57, '1752925825029', '6102800223', 'Dodoma', 1, 1, '2025-07-19 11:48:40', '2025-07-19 11:48:40'),
(58, '1752925765986', '6102800223', 'Geita', 1, 1, '2025-07-19 11:49:04', '2025-07-19 11:49:04'),
(59, '1752922998402', '6102800223', 'Iringa', 1, 1, '2025-07-19 11:49:32', '2025-07-19 11:49:32'),
(60, '1752921830567', '6102800223', 'Kagera', 1, 1, '2025-07-19 11:50:13', '2025-07-19 11:50:13'),
(61, '1752922921450', '6102800223', 'Katavi', 1, 1, '2025-07-19 11:50:37', '2025-07-19 11:50:37'),
(62, '1752921082055', '6102800223', 'Kigoma', 1, 1, '2025-07-19 11:51:18', '2025-07-19 11:51:18'),
(63, '1752923594149', '6102800223', 'Kilimanjaro', 1, 1, '2025-07-19 11:51:37', '2025-07-19 11:51:37'),
(64, '1752928083777', '6102800223', 'Lindi', 1, 1, '2025-07-19 11:53:45', '2025-07-19 11:53:45'),
(65, '1752927710629', '6102800223', 'Manyara', 1, 1, '2025-07-19 11:54:11', '2025-07-19 11:54:11'),
(66, '1752922922064', '6102800223', 'Mara', 1, 1, '2025-07-19 11:54:34', '2025-07-19 11:54:34'),
(67, '1752922982396', '6102800223', 'Mbeya', 1, 1, '2025-07-19 11:55:05', '2025-07-19 11:55:05'),
(68, '1752926309107', '6102800223', 'Morogoro', 1, 1, '2025-07-19 11:55:28', '2025-07-19 11:55:28'),
(69, '1752924995618', '6102800223', 'Mtwara', 1, 1, '2025-07-19 11:57:46', '2025-07-19 11:57:46'),
(70, '1752923411697', '6102800223', 'Mwanza', 1, 1, '2025-07-19 11:58:52', '2025-07-19 11:58:52'),
(71, '1752921025898', '6102800223', 'Njombe', 1, 1, '2025-07-19 11:59:14', '2025-07-19 11:59:14'),
(72, '1752923480502', '6102800223', 'Pwani', 1, 1, '2025-07-19 11:59:37', '2025-07-19 11:59:37'),
(73, '1752928608723', '6102800223', 'Rukwa', 1, 1, '2025-07-19 12:00:04', '2025-07-19 12:00:04'),
(74, '1752927994305', '6102800223', 'Ruvuma', 1, 1, '2025-07-19 12:01:34', '2025-07-19 12:01:34'),
(75, '1752926286835', '6102800223', 'Shinyanga', 1, 1, '2025-07-19 12:01:59', '2025-07-19 12:01:59'),
(76, '1752921510560', '6102800223', 'Simuyu', 1, 1, '2025-07-19 12:02:14', '2025-07-19 12:02:14'),
(77, '1752925751212', '6102800223', 'Singida', 1, 1, '2025-07-19 12:02:48', '2025-07-19 12:02:48'),
(78, '1752926778683', '6102800223', 'Songwe', 1, 1, '2025-07-19 12:03:11', '2025-07-19 12:03:11'),
(79, '1752926878322', '6102800223', 'Tabora', 1, 1, '2025-07-19 12:03:35', '2025-07-19 12:03:35'),
(80, '1752923785462', '6102800223', 'Tanga', 1, 1, '2025-07-19 12:03:51', '2025-07-19 12:03:51'),
(81, '1752923855587', '6102800223', 'North Unguja', 1, 1, '2025-07-19 12:17:45', '2025-07-19 12:17:45'),
(82, '1752922223230', '6102800223', 'South Unguja', 1, 1, '2025-07-19 12:19:20', '2025-07-19 12:19:20'),
(83, '1752922387801', '6102800223', 'Urban West', 1, 1, '2025-07-19 12:19:54', '2025-07-19 12:19:54'),
(84, '1752926607984', '6102800223', 'North Pemba', 1, 1, '2025-07-19 12:20:21', '2025-07-19 12:20:21'),
(85, '1752922412465', '6102800223', 'South Pemba', 1, 1, '2025-07-19 12:21:22', '2025-07-19 12:21:22'),
(86, '1753092216649', '6102800235', 'Kampala', 1, 1, '2025-07-21 11:36:28', '2025-07-21 11:36:28'),
(87, '1753096884268', '6102800235', 'Entebbe', 1, 1, '2025-07-21 11:38:32', '2025-07-21 11:38:32'),
(88, '175309820721', '6102800235', 'Jinja', 1, 1, '2025-07-21 11:39:03', '2025-07-21 11:39:03'),
(89, '175309713044', '6102800235', 'Mbale', 1, 1, '2025-07-21 11:40:39', '2025-07-21 11:40:39'),
(90, '1753098293721', '6102800235', 'Mbarara', 1, 1, '2025-07-21 11:41:20', '2025-07-21 11:41:20'),
(91, '1753094340509', '6102800235', 'Gulu', 1, 1, '2025-07-21 11:41:45', '2025-07-21 11:41:45'),
(92, '1753094825012', '6102800235', 'Arua', 1, 1, '2025-07-21 11:42:17', '2025-07-21 11:42:17'),
(93, '1753098725921', '6102800235', 'Fort Portal', 1, 1, '2025-07-21 11:46:50', '2025-07-21 11:46:50'),
(94, '1753097745102', '6102800235', 'Lira', 1, 1, '2025-07-21 11:53:37', '2025-07-21 11:53:37'),
(95, '1753094834464', '6102800235', 'Masaka', 1, 1, '2025-07-22 05:59:52', '2025-07-21 11:56:10'),
(96, '1753168103615', '6102800235', 'Hoima', 1, 1, '2025-07-22 06:00:45', '2025-07-22 06:00:45'),
(97, '1753165221204', '6102800235', 'Soroti', 1, 1, '2025-07-22 06:01:07', '2025-07-22 06:01:07'),
(98, '1753164941720', '6102800235', 'Bushenyi', 1, 1, '2025-07-22 06:02:13', '2025-07-22 06:02:13'),
(99, '175316808720', '6102800235', 'Tororo', 1, 1, '2025-07-22 06:05:35', '2025-07-22 06:05:35'),
(100, '1753162224912', '6102800235', 'Iganga', 1, 1, '2025-07-22 06:06:02', '2025-07-22 06:06:02'),
(101, '1753166808243', '6102800235', 'Kabale', 1, 1, '2025-07-22 06:06:40', '2025-07-22 06:06:40'),
(102, '1753164064906', '6102800235', 'Kasese', 1, 1, '2025-07-22 06:07:03', '2025-07-22 06:07:03'),
(103, '1753167169064', '6102800235', 'Mukono', 1, 1, '2025-07-22 06:07:26', '2025-07-22 06:07:26'),
(104, '1753163529559', '6102800235', 'Wakiso', 1, 1, '2025-07-22 06:07:51', '2025-07-22 06:07:51'),
(105, '1753162870817', '6102800235', 'Mpigi', 1, 1, '2025-07-22 06:08:41', '2025-07-22 06:08:41'),
(106, '1753162610903', '6102800235', 'Kamuli', 1, 1, '2025-07-22 06:09:04', '2025-07-22 06:09:04'),
(107, '1753168716634', '6102800235', 'Kitgum', 1, 1, '2025-07-22 06:09:25', '2025-07-22 06:09:25'),
(108, '175316221499', '6102800235', 'Pallisa', 1, 1, '2025-07-22 06:09:50', '2025-07-22 06:09:50'),
(109, '1753168548637', '6102800235', 'Kotido', 1, 1, '2025-07-22 06:10:20', '2025-07-22 06:10:20'),
(110, '1753168566764', '6102800235', 'Kirnyandogo', 1, 1, '2025-07-22 06:10:55', '2025-07-22 06:10:55'),
(111, '1753168260865', '6102800235', 'Kyenjojo', 1, 1, '2025-07-22 06:11:34', '2025-07-22 06:11:34'),
(112, '1753168513297', '6102800235', 'Bugiri', 1, 1, '2025-07-22 06:11:58', '2025-07-22 06:11:58'),
(113, '1753166622284', '6102800235', 'Bombo', 1, 1, '2025-07-22 06:12:16', '2025-07-22 06:12:16'),
(114, '1753166574026', '6102800235', 'Moroto', 1, 1, '2025-07-22 06:22:05', '2025-07-22 06:22:05'),
(115, '1753162515226', '6102800235', 'Nebbi', 1, 1, '2025-07-22 06:22:38', '2025-07-22 06:22:38'),
(116, '1753163069940', '6102800235', 'Mityana', 1, 1, '2025-07-22 06:23:01', '2025-07-22 06:23:01'),
(117, '1753168503252', '6102800235', 'Kiboga', 1, 1, '2025-07-22 06:23:24', '2025-07-22 06:23:24'),
(118, '1753162912429', '6102800235', 'Ntungamo', 1, 1, '2025-07-22 06:23:44', '2025-07-22 06:23:44'),
(119, '1753168177329', '6102800235', 'Rukungiri', 1, 1, '2025-07-22 06:24:16', '2025-07-22 06:24:16'),
(120, '1753163005655', '6102800208', 'Mugadishu', 1, 1, '2025-07-22 06:24:56', '2025-07-22 06:24:56'),
(121, '1753183373004', '6102800208', 'Beledweyne', 1, 1, '2025-07-22 11:19:30', '2025-07-22 11:19:30'),
(122, '1753183765701', '6102800208', 'Bulo Burte', 1, 1, '2025-07-22 11:24:20', '2025-07-22 11:24:20'),
(123, '1753183047622', '6102800071', 'Addis Ababa', 1, 1, '2025-07-22 11:24:23', '2025-07-22 11:24:23'),
(124, '1753183932695', '6102800208', 'jalalaqsi', 1, 1, '2025-07-22 11:24:56', '2025-07-22 11:24:56'),
(125, '1753188693086', '6102800071', 'Amhara Region', 1, 1, '2025-07-22 11:25:08', '2025-07-22 11:25:08'),
(126, '1753184265194', '6102800208', 'Jowhar', 1, 1, '2025-07-22 11:25:20', '2025-07-22 11:25:20'),
(127, '1753181250995', '6102800071', 'Bahir Dar', 1, 1, '2025-07-22 11:25:39', '2025-07-22 11:25:39'),
(128, '1753186591796', '6102800208', 'Bal\'ad', 1, 1, '2025-07-22 11:25:46', '2025-07-22 11:25:46'),
(129, '1753187411121', '6102800071', 'Gondar', 1, 1, '2025-07-22 11:26:15', '2025-07-22 11:26:15'),
(130, '1753187752979', '6102800071', 'Dessie', 1, 1, '2025-07-22 11:26:50', '2025-07-22 11:26:50'),
(131, '1753187249543', '6102800208', 'Warsheikh', 1, 1, '2025-07-22 11:27:27', '2025-07-22 11:27:27'),
(132, '1753183687168', '6102800208', 'Dusamareb', 1, 1, '2025-07-22 11:28:02', '2025-07-22 11:28:02'),
(133, '1753188334207', '6102800071', 'Debre Markos', 1, 1, '2025-07-22 11:28:09', '2025-07-22 11:28:09'),
(134, '1753182838698', '6102800208', 'Abudwak', 1, 1, '2025-07-22 11:28:31', '2025-07-22 11:28:31'),
(135, '1753184855359', '6102800208', 'Guriel', 1, 1, '2025-07-22 11:28:52', '2025-07-22 11:28:52'),
(136, '1753186239431', '6102800208', 'Elbur', 1, 1, '2025-07-22 11:29:21', '2025-07-22 11:29:21'),
(137, '1753181260722', '6102800208', 'Hobyo', 1, 1, '2025-07-22 11:29:45', '2025-07-22 11:29:45'),
(138, '1753181342391', '6102800208', 'Harardhere', 1, 1, '2025-07-22 11:30:39', '2025-07-22 11:30:39'),
(139, '1753186899751', '6102800208', 'Galkayo', 1, 1, '2025-07-22 11:31:12', '2025-07-22 11:31:12'),
(140, '1753183864764', '6102800071', 'Adama (Nazret)', 1, 1, '2025-07-22 11:31:57', '2025-07-22 11:31:57'),
(141, '1753183123384', '6102800071', 'Jimma', 1, 1, '2025-07-22 11:32:39', '2025-07-22 11:32:39'),
(142, '1753184654690', '6102800208', 'Bosaso', 1, 1, '2025-07-22 11:32:42', '2025-07-22 11:32:42'),
(143, '175318657541', '6102800208', 'Qandala', 1, 1, '2025-07-22 11:33:03', '2025-07-22 11:33:03'),
(144, '1753184017531', '6102800208', 'Bargaal', 1, 1, '2025-07-22 11:33:28', '2025-07-22 11:33:28'),
(145, '1753188325089', '6102800208', 'Garowe', 1, 1, '2025-07-22 11:33:57', '2025-07-22 11:33:57'),
(146, '1753181201926', '6102800208', 'Eyl', 1, 1, '2025-07-22 11:34:30', '2025-07-22 11:34:30'),
(147, '1753181453914', '6102800071', 'Ambo', 1, 1, '2025-07-22 11:34:49', '2025-07-22 11:34:49'),
(148, '1753188112571', '6102800071', 'Shashamane', 1, 1, '2025-07-22 11:35:17', '2025-07-22 11:35:17'),
(149, '1753181616499', '6102800208', 'Kismayo', 1, 1, '2025-07-22 11:36:56', '2025-07-22 11:36:56'),
(150, '1753183749121', '6102800208', 'Afmadow', 1, 1, '2025-07-22 11:37:21', '2025-07-22 11:37:21'),
(151, '1753188563197', '6102800208', 'Badhaadhe', 1, 1, '2025-07-22 11:37:47', '2025-07-22 11:37:47'),
(152, '1753187107109', '6102800208', 'Bu\'aale', 1, 1, '2025-07-22 11:38:13', '2025-07-22 11:38:13'),
(153, '1753182276257', '6102800208', 'Sakow', 1, 1, '2025-07-22 11:38:32', '2025-07-22 11:38:32'),
(154, '1753182748226', '6102800208', 'Jilib', 1, 1, '2025-07-22 11:38:55', '2025-07-22 11:38:55'),
(155, '1753187893526', '6102800208', 'Baidoa', 1, 1, '2025-07-22 11:39:36', '2025-07-22 11:39:36'),
(156, '1753182020561', '6102800208', 'Buur Hakaba', 1, 1, '2025-07-22 11:40:04', '2025-07-22 11:40:04'),
(157, '1753181256629', '6102800208', 'Qansahdhere', 1, 1, '2025-07-22 11:40:42', '2025-07-22 11:40:42'),
(158, '1753184617938', '6102800208', 'Hudur', 1, 1, '2025-07-22 11:41:35', '2025-07-22 11:41:35'),
(159, '1753188132272', '6102800071', 'Mekelle', 1, 1, '2025-07-22 11:41:45', '2025-07-22 11:41:45'),
(160, '1753181668835', '6102800208', 'Tayeeglow', 1, 1, '2025-07-22 11:42:00', '2025-07-22 11:42:00'),
(161, '1753181790722', '6102800071', 'Axum', 1, 1, '2025-07-22 11:42:23', '2025-07-22 11:42:23'),
(162, '1753185886159', '6102800208', 'Waajid', 1, 1, '2025-07-22 11:42:42', '2025-07-22 11:42:42'),
(163, '1753181995112', '6102800071', 'Adigrat', 1, 1, '2025-07-22 11:43:01', '2025-07-22 11:43:01'),
(164, '1753184945420', '6102800208', 'Merca', 1, 1, '2025-07-22 11:43:02', '2025-07-22 11:43:02'),
(165, '1753184878457', '6102800208', 'Afgoye', 1, 1, '2025-07-22 11:43:23', '2025-07-22 11:43:23'),
(166, '1753186575251', '6102800071', 'Hawassa ', 1, 1, '2025-07-22 11:43:28', '2025-07-22 11:43:28'),
(167, '1753185195797', '6102800071', 'Arba Minch ', 1, 1, '2025-07-22 11:43:58', '2025-07-22 11:43:58'),
(168, '1753187981663', '6102800071', 'Wolaita Sodo', 1, 1, '2025-07-22 11:44:26', '2025-07-22 11:44:26'),
(169, '1753184220514', '6102800208', 'Qoryoley', 1, 1, '2025-07-22 11:44:44', '2025-07-22 11:44:44'),
(170, '1753182488240', '6102800071', 'Jigjiga ', 1, 1, '2025-07-22 11:44:48', '2025-07-22 11:44:48'),
(171, '1753183172917', '6102800208', 'Wanlaweyn', 1, 1, '2025-07-22 11:45:18', '2025-07-22 11:45:18'),
(172, '1753188943780', '6102800208', 'Hargeisa', 1, 1, '2025-07-22 11:45:53', '2025-07-22 11:45:53'),
(173, '175318405697', '6102800208', 'Berbera', 1, 1, '2025-07-22 11:46:14', '2025-07-22 11:46:14'),
(174, '1753188325325', '6102800208', 'Borama', 1, 1, '2025-07-22 11:47:43', '2025-07-22 11:47:43'),
(175, '1753181153512', '6102800208', 'Zeila', 1, 1, '2025-07-22 11:48:06', '2025-07-22 11:48:06'),
(176, '1753181799862', '6102800208', 'Burao', 1, 1, '2025-07-22 11:48:42', '2025-07-22 11:48:42'),
(177, '1753182768903', '6102800208', 'Las Anod', 1, 1, '2025-07-22 11:49:15', '2025-07-22 11:49:15'),
(178, '175318756306', '6102800208', 'Erigavo', 1, 1, '2025-07-22 11:49:32', '2025-07-22 11:49:32'),
(179, '1753183118265', '6102800208', 'El Afweyn', 1, 1, '2025-07-22 11:50:00', '2025-07-22 11:50:00'),
(180, '1753186344339', '6102800071', 'Gode', 1, 1, '2025-07-22 12:43:51', '2025-07-22 12:43:51'),
(181, '1753186234360', '6102800071', 'Degah Bur', 1, 1, '2025-07-22 12:44:24', '2025-07-22 12:44:24'),
(183, '1753186517983', '6102800071', 'Semera ', 1, 1, '2025-07-22 12:46:47', '2025-07-22 12:46:47'),
(184, '1753183722416', '6102800071', 'Benishangul-Gumuz', 1, 1, '2025-07-22 12:47:11', '2025-07-22 12:47:11'),
(185, '1753187449455', '6102800071', 'Assosa ', 1, 1, '2025-07-22 12:47:36', '2025-07-22 12:47:36'),
(186, '1753183618112', '6102800071', 'Gambela ', 1, 1, '2025-07-22 12:48:11', '2025-07-22 12:48:11'),
(187, '1753181317766', '6102800062', 'Djibouti city', 1, 1, '2025-07-22 12:48:50', '2025-07-22 12:48:50'),
(188, '175318476882', '6102800062', 'Ali Sabieh', 1, 1, '2025-07-22 12:49:18', '2025-07-22 12:49:18'),
(189, '1753181153288', '6102800062', 'Tadjourah', 1, 1, '2025-07-22 12:50:37', '2025-07-22 12:50:37'),
(190, '1753182176717', '6102800062', 'Obock', 1, 1, '2025-07-22 12:51:00', '2025-07-22 12:51:00'),
(191, '1753181614674', '6102800062', 'Dikhil', 1, 1, '2025-07-22 12:51:28', '2025-07-22 12:51:28'),
(192, '1753185648717', '6102800062', 'Arta', 1, 1, '2025-07-22 12:51:47', '2025-07-22 12:51:47'),
(193, '1753182400219', '6102800062', 'Yoboki', 1, 1, '2025-07-22 12:52:08', '2025-07-22 12:52:08'),
(194, '1753188746754', '6102800062', 'Balho', 1, 1, '2025-07-22 12:52:36', '2025-07-22 12:52:36'),
(195, '1753187918739', '6102800062', 'Loyada', 1, 1, '2025-07-22 12:53:12', '2025-07-22 12:53:12'),
(196, '1753185350859', '6102800062', 'Holhol', 1, 1, '2025-07-22 12:53:35', '2025-07-22 12:53:35'),
(197, '1753256586506', '6102800037', 'Bujumbura', 1, 1, '2025-07-23 06:35:18', '2025-07-23 06:35:18'),
(198, '1753257122563', '6102800037', 'Gitega', 1, 1, '2025-07-23 06:35:50', '2025-07-23 06:35:50');

-- --------------------------------------------------------

--
-- Table structure for table `m_country`
--

CREATE TABLE `m_country` (
  `id` int(11) NOT NULL,
  `country_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `timezone` varchar(255) NOT NULL DEFAULT 'Africa/Nairobi',
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_country`
--

INSERT INTO `m_country` (`id`, `country_id`, `name`, `tag`, `short_name`, `code`, `timezone`, `state`, `active`, `updated_at`, `created_at`) VALUES
(1, '6102800001', 'Afghanistan', 'AF', 'AFG', '93', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(2, '6102800002', 'Aland Islands', 'AX', 'ALA', '358', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(3, '6102800003', 'Albania', 'AL', 'ALB', '355', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(4, '6102800004', 'Algeria', 'DZ', 'DZA', '213', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(5, '6102800005', 'American Samoa', 'AS', 'ASM', '1684', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(6, '6102800006', 'Andorra', 'AD', 'AND', '376', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(7, '6102800007', 'Angola', 'AO', 'AGO', '244', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(8, '6102800008', 'Anguilla', 'AI', 'AIA', '1264', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(9, '6102800009', 'Antarctica', 'AQ', 'ATA', '0', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(10, '6102800010', 'Antigua and Barbuda', 'AG', 'ATG', '1268', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(11, '6102800011', 'Argentina', 'AR', 'ARG', '54', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(12, '6102800012', 'Armenia', 'AM', 'ARM', '374', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(13, '6102800013', 'Aruba', 'AW', 'ABW', '297', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(14, '6102800014', 'Australia', 'AU', 'AUS', '61', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(15, '6102800015', 'Austria', 'AT', 'AUT', '43', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(16, '6102800016', 'Azerbaijan', 'AZ', 'AZE', '994', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(17, '6102800017', 'Bahamas', 'BS', 'BHS', '1242', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(18, '6102800018', 'Bahrain', 'BH', 'BHR', '973', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(19, '6102800019', 'Bangladesh', 'BD', 'BGD', '880', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(20, '6102800020', 'Barbados', 'BB', 'BRB', '1246', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(21, '6102800021', 'Belarus', 'BY', 'BLR', '375', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(22, '6102800022', 'Belgium', 'BE', 'BEL', '32', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(23, '6102800023', 'Belize', 'BZ', 'BLZ', '501', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(24, '6102800024', 'Benin', 'BJ', 'BEN', '229', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(25, '6102800025', 'Bermuda', 'BM', 'BMU', '1441', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(26, '6102800026', 'Bhutan', 'BT', 'BTN', '975', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(27, '6102800027', 'Bolivia', 'BO', 'BOL', '591', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(28, '6102800028', 'Bonaire, Sint Eustatius and Saba', 'BQ', 'BES', '599', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(29, '6102800029', 'Bosnia and Herzegovina', 'BA', 'BIH', '387', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(30, '6102800030', 'Botswana', 'BW', 'BWA', '267', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(31, '6102800031', 'Bouvet Island', 'BV', 'BVT', '0', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(32, '6102800032', 'Brazil', 'BR', 'BRA', '55', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(33, '6102800033', 'British Indian Ocean Territory', 'IO', 'IOT', '246', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(34, '6102800034', 'Brunei Darussalam', 'BN', 'BRN', '673', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(35, '6102800035', 'Bulgaria', 'BG', 'BGR', '359', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(36, '6102800036', 'Burkina Faso', 'BF', 'BFA', '226', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(37, '6102800037', 'Burundi', 'BI', 'BDI', '257', 'Africa/Nairobi', 1, 1, '2025-07-23 06:32:33', '2021-08-20 12:43:39'),
(38, '6102800038', 'Cambodia', 'KH', 'KHM', '855', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(39, '6102800039', 'Cameroon', 'CM', 'CMR', '237', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(40, '6102800040', 'Canada', 'CA', 'CAN', '1', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(41, '6102800041', 'Cape Verde', 'CV', 'CPV', '238', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(42, '6102800042', 'Cayman Islands', 'KY', 'CYM', '1345', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(43, '6102800043', 'Central African Republic', 'CF', 'CAF', '236', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(44, '6102800044', 'Chad', 'TD', 'TCD', '235', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(45, '6102800045', 'Chile', 'CL', 'CHL', '56', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(46, '6102800046', 'China', 'CN', 'CHN', '86', 'Asia/Shanghai', 1, 1, '2024-05-31 21:12:03', '2021-08-20 12:43:39'),
(47, '6102800047', 'Christmas Island', 'CX', 'CXR', '61', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(48, '6102800048', 'Cocos (Keeling) Islands', 'CC', 'CCK', '672', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(49, '6102800049', 'Colombia', 'CO', 'COL', '57', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(50, '6102800050', 'Comoros', 'KM', 'COM', '269', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(51, '6102800051', 'Congo', 'CG', 'COG', '242', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(52, '6102800052', 'Congo, the Democratic Republic of the', 'CD', 'COD', '242', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(53, '6102800053', 'Cook Islands', 'CK', 'COK', '682', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(54, '6102800054', 'Costa Rica', 'CR', 'CRI', '506', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(55, '6102800055', 'Cote D\'Ivoire', 'CI', 'CIV', '225', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(56, '6102800056', 'Croatia', 'HR', 'HRV', '385', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(57, '6102800057', 'Cuba', 'CU', 'CUB', '53', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(58, '6102800058', 'Curacao', 'CW', 'CUW', '599', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(59, '6102800059', 'Cyprus', 'CY', 'CYP', '357', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(60, '6102800060', 'Czech Republic', 'CZ', 'CZE', '420', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(61, '6102800061', 'Denmark', 'DK', 'DNK', '45', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(62, '6102800062', 'Djibouti', 'DJ', 'DJI', '253', 'Africa/Nairobi', 1, 1, '2025-07-22 12:46:22', '2021-08-20 12:43:39'),
(63, '6102800063', 'Dominica', 'DM', 'DMA', '1767', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(64, '6102800064', 'Dominican Republic', 'DO', 'DOM', '1809', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(65, '6102800065', 'Ecuador', 'EC', 'ECU', '593', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(66, '6102800066', 'Egypt', 'EG', 'EGY', '20', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(67, '6102800067', 'El Salvador', 'SV', 'SLV', '503', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(68, '6102800068', 'Equatorial Guinea', 'GQ', 'GNQ', '240', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(69, '6102800069', 'Eritrea', 'ER', 'ERI', '291', 'Africa/Nairobi', 1, 1, '2025-07-22 11:20:34', '2021-08-20 12:43:39'),
(70, '6102800070', 'Estonia', 'EE', 'EST', '372', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(71, '6102800071', 'Ethiopia', 'ET', 'ETH', '251', 'Africa/Nairobi', 1, 1, '2025-07-22 11:20:13', '2021-08-20 12:43:39'),
(72, '6102800072', 'Falkland Islands (Malvinas)', 'FK', 'FLK', '500', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(73, '6102800073', 'Faroe Islands', 'FO', 'FRO', '298', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(74, '6102800074', 'Fiji', 'FJ', 'FJI', '679', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(75, '6102800075', 'Finland', 'FI', 'FIN', '358', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(76, '6102800076', 'France', 'FR', 'FRA', '33', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(77, '6102800077', 'French Guiana', 'GF', 'GUF', '594', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(78, '6102800078', 'French Polynesia', 'PF', 'PYF', '689', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(79, '6102800079', 'French Southern Territories', 'TF', 'ATF', '0', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(80, '6102800080', 'Gabon', 'GA', 'GAB', '241', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(81, '6102800081', 'Gambia', 'GM', 'GMB', '220', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(82, '6102800082', 'Georgia', 'GE', 'GEO', '995', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(83, '6102800083', 'Germany', 'DE', 'DEU', '49', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(84, '6102800084', 'Ghana', 'GH', 'GHA', '233', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(85, '6102800085', 'Gibraltar', 'GI', 'GIB', '350', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(86, '6102800086', 'Greece', 'GR', 'GRC', '30', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(87, '6102800087', 'Greenland', 'GL', 'GRL', '299', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(88, '6102800088', 'Grenada', 'GD', 'GRD', '1473', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(89, '6102800089', 'Guadeloupe', 'GP', 'GLP', '590', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(90, '6102800090', 'Guam', 'GU', 'GUM', '1671', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(91, '6102800091', 'Guatemala', 'GT', 'GTM', '502', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(92, '6102800092', 'Guernsey', 'GG', 'GGY', '44', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(93, '6102800093', 'Guinea', 'GN', 'GIN', '224', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(94, '6102800094', 'Guinea-Bissau', 'GW', 'GNB', '245', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(95, '6102800095', 'Guyana', 'GY', 'GUY', '592', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(96, '6102800096', 'Haiti', 'HT', 'HTI', '509', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(97, '6102800097', 'Heard Island and Mcdonald Islands', 'HM', 'HMD', '0', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(98, '6102800098', 'Holy See (Vatican City State)', 'VA', 'VAT', '39', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(99, '6102800099', 'Honduras', 'HN', 'HND', '504', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(100, '6102800100', 'Hong Kong', 'HK', 'HKG', '852', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(101, '6102800101', 'Hungary', 'HU', 'HUN', '36', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(102, '6102800102', 'Iceland', 'IS', 'ISL', '354', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(103, '6102800103', 'India', 'IN', 'IND', '91', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(104, '6102800104', 'Indonesia', 'ID', 'IDN', '62', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(105, '6102800105', 'Iran, Islamic Republic of', 'IR', 'IRN', '98', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(106, '6102800106', 'Iraq', 'IQ', 'IRQ', '964', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(107, '6102800107', 'Ireland', 'IE', 'IRL', '353', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(108, '6102800108', 'Isle of Man', 'IM', 'IMN', '44', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(109, '6102800109', 'Israel', 'IL', 'ISR', '972', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(110, '6102800110', 'Italy', 'IT', 'ITA', '39', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(111, '6102800111', 'Jamaica', 'JM', 'JAM', '1876', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(112, '6102800112', 'Japan', 'JP', 'JPN', '81', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(113, '6102800113', 'Jersey', 'JE', 'JEY', '44', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(114, '6102800114', 'Jordan', 'JO', 'JOR', '962', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(115, '6102800115', 'Kazakhstan', 'KZ', 'KAZ', '7', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(116, '6102800116', 'Kenya', 'KE', 'KEN', '254', 'Africa/Nairobi', 1, 1, '2024-05-31 21:12:41', '2021-08-20 12:43:39'),
(117, '6102800117', 'Kiribati', 'KI', 'KIR', '686', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(118, '6102800118', 'Korea, Democratic People\"s Republic of', 'KP', 'PRK', '850', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(119, '6102800119', 'Korea, Republic of', 'KR', 'KOR', '82', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(120, '6102800120', 'Kosovo', 'XK', 'XKX', '381', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(121, '6102800121', 'Kuwait', 'KW', 'KWT', '965', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(122, '6102800122', 'Kyrgyzstan', 'KG', 'KGZ', '996', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(123, '6102800123', 'Lao People\'s Democratic Republic', 'LA', 'LAO', '856', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(124, '6102800124', 'Latvia', 'LV', 'LVA', '371', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(125, '6102800125', 'Lebanon', 'LB', 'LBN', '961', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(126, '6102800126', 'Lesotho', 'LS', 'LSO', '266', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(127, '6102800127', 'Liberia', 'LR', 'LBR', '231', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(128, '6102800128', 'Libyan Arab Jamahiriya', 'LY', 'LBY', '218', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(129, '6102800129', 'Liechtenstein', 'LI', 'LIE', '423', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(130, '6102800130', 'Lithuania', 'LT', 'LTU', '370', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(131, '6102800131', 'Luxembourg', 'LU', 'LUX', '352', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(132, '6102800132', 'Macao', 'MO', 'MAC', '853', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(133, '6102800133', 'Macedonia, the Former Yugoslav Republic of', 'MK', 'MKD', '389', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(134, '6102800134', 'Madagascar', 'MG', 'MDG', '261', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(135, '6102800135', 'Malawi', 'MW', 'MWI', '265', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(136, '6102800136', 'Malaysia', 'MY', 'MYS', '60', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(137, '6102800137', 'Maldives', 'MV', 'MDV', '960', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(138, '6102800138', 'Mali', 'ML', 'MLI', '223', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(139, '6102800139', 'Malta', 'MT', 'MLT', '356', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(140, '6102800140', 'Marshall Islands', 'MH', 'MHL', '692', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(141, '6102800141', 'Martinique', 'MQ', 'MTQ', '596', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(142, '6102800142', 'Mauritania', 'MR', 'MRT', '222', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(143, '6102800143', 'Mauritius', 'MU', 'MUS', '230', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(144, '6102800144', 'Mayotte', 'YT', 'MYT', '269', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(145, '6102800145', 'Mexico', 'MX', 'MEX', '52', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(146, '6102800146', 'Micronesia, Federated States of', 'FM', 'FSM', '691', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(147, '6102800147', 'Moldova, Republic of', 'MD', 'MDA', '373', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(148, '6102800148', 'Monaco', 'MC', 'MCO', '377', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(149, '6102800149', 'Mongolia', 'MN', 'MNG', '976', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(150, '6102800150', 'Montenegro', 'ME', 'MNE', '382', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(151, '6102800151', 'Montserrat', 'MS', 'MSR', '1664', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(152, '6102800152', 'Morocco', 'MA', 'MAR', '212', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(153, '6102800153', 'Mozambique', 'MZ', 'MOZ', '258', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(154, '6102800154', 'Myanmar', 'MM', 'MMR', '95', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(155, '6102800155', 'Namibia', 'NA', 'NAM', '264', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(156, '6102800156', 'Nauru', 'NR', 'NRU', '674', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(157, '6102800157', 'Nepal', 'NP', 'NPL', '977', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(158, '6102800158', 'Netherlands', 'NL', 'NLD', '31', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(159, '6102800159', 'Netherlands Antilles', 'AN', 'ANT', '599', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(160, '6102800160', 'New Caledonia', 'NC', 'NCL', '687', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(161, '6102800161', 'New Zealand', 'NZ', 'NZL', '64', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(162, '6102800162', 'Nicaragua', 'NI', 'NIC', '505', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(163, '6102800163', 'Niger', 'NE', 'NER', '227', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(164, '6102800164', 'Nigeria', 'NG', 'NGA', '234', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(165, '6102800165', 'Niue', 'NU', 'NIU', '683', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(166, '6102800166', 'Norfolk Island', 'NF', 'NFK', '672', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(167, '6102800167', 'Northern Mariana Islands', 'MP', 'MNP', '1670', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(168, '6102800168', 'Norway', 'NO', 'NOR', '47', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(169, '6102800169', 'Oman', 'OM', 'OMN', '968', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(170, '6102800170', 'Pakistan', 'PK', 'PAK', '92', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(171, '6102800171', 'Palau', 'PW', 'PLW', '680', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(172, '6102800172', 'Palestinian Territory, Occupied', 'PS', 'PSE', '970', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(173, '6102800173', 'Panama', 'PA', 'PAN', '507', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(174, '6102800174', 'Papua New Guinea', 'PG', 'PNG', '675', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(175, '6102800175', 'Paraguay', 'PY', 'PRY', '595', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(176, '6102800176', 'Peru', 'PE', 'PER', '51', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(177, '6102800177', 'Philippines', 'PH', 'PHL', '63', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(178, '6102800178', 'Pitcairn', 'PN', 'PCN', '64', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(179, '6102800179', 'Poland', 'PL', 'POL', '48', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(180, '6102800180', 'Portugal', 'PT', 'PRT', '351', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(181, '6102800181', 'Puerto Rico', 'PR', 'PRI', '1787', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(182, '6102800182', 'Qatar', 'QA', 'QAT', '974', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(183, '6102800183', 'Reunion', 'RE', 'REU', '262', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(184, '6102800184', 'Romania', 'RO', 'ROM', '40', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(185, '6102800185', 'Russian Federation', 'RU', 'RUS', '70', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(186, '6102800186', 'Rwanda', 'RW', 'RWA', '250', 'Africa/Nairobi', 1, 1, '2025-07-23 06:33:15', '2021-08-20 12:43:39'),
(187, '6102800187', 'Saint Barthelemy', 'BL', 'BLM', '590', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(188, '6102800188', 'Saint Helena', 'SH', 'SHN', '290', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(189, '6102800189', 'Saint Kitts and Nevis', 'KN', 'KNA', '1869', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(190, '6102800190', 'Saint Lucia', 'LC', 'LCA', '1758', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(191, '6102800191', 'Saint Martin', 'MF', 'MAF', '590', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(192, '6102800192', 'Saint Pierre and Miquelon', 'PM', 'SPM', '508', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(193, '6102800193', 'Saint Vincent and the Grenadines', 'VC', 'VCT', '1784', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(194, '6102800194', 'Samoa', 'WS', 'WSM', '684', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(195, '6102800195', 'San Marino', 'SM', 'SMR', '378', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(196, '6102800196', 'Sao Tome and Principe', 'ST', 'STP', '239', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(197, '6102800197', 'Saudi Arabia', 'SA', 'SAU', '966', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(198, '6102800198', 'Senegal', 'SN', 'SEN', '221', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(199, '6102800199', 'Serbia', 'RS', 'SRB', '381', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(200, '6102800200', 'Serbia and Montenegro', 'CS', 'SCG', '381', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(201, '6102800201', 'Seychelles', 'SC', 'SYC', '248', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(202, '6102800202', 'Sierra Leone', 'SL', 'SLE', '232', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(203, '6102800203', 'Singapore', 'SG', 'SGP', '65', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(204, '6102800204', 'Sint Maarten', 'SX', 'SXM', '1', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(205, '6102800205', 'Slovakia', 'SK', 'SVK', '421', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(206, '6102800206', 'Slovenia', 'SI', 'SVN', '386', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(207, '6102800207', 'Solomon Islands', 'SB', 'SLB', '677', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(208, '6102800208', 'Somalia', 'SO', 'SOM', '252', 'Africa/Nairobi', 1, 1, '2025-07-21 11:45:32', '2021-08-20 12:43:39'),
(209, '6102800209', 'South Africa', 'ZA', 'ZAF', '27', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(210, '6102800210', 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', '500', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(211, '6102800211', 'South Sudan', 'SS', 'SSD', '211', 'Africa/Nairobi', 1, 1, '2025-07-22 12:46:41', '2021-08-20 12:43:39'),
(212, '6102800212', 'Spain', 'ES', 'ESP', '34', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(213, '6102800213', 'Sri Lanka', 'LK', 'LKA', '94', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(214, '6102800214', 'Sudan', 'SD', 'SDN', '249', 'Africa/Nairobi', 1, 1, '2025-07-22 12:46:58', '2021-08-20 12:43:39'),
(215, '6102800215', 'Suriname', 'SR', 'SUR', '597', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(216, '6102800216', 'Svalbard and Jan Mayen', 'SJ', 'SJM', '47', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(217, '6102800217', 'Swaziland', 'SZ', 'SWZ', '268', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(218, '6102800218', 'Sweden', 'SE', 'SWE', '46', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(219, '6102800219', 'Switzerland', 'CH', 'CHE', '41', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(220, '6102800220', 'Syrian Arab Republic', 'SY', 'SYR', '963', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(221, '6102800221', 'Taiwan, Province of China', 'TW', 'TWN', '886', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(222, '6102800222', 'Tajikistan', 'TJ', 'TJK', '992', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(223, '6102800223', 'Tanzania', 'TZ', 'TZA', '255', 'Africa/Dar_es_Salaam', 1, 1, '2024-05-31 21:13:22', '2021-08-20 12:43:39'),
(224, '6102800224', 'Thailand', 'TH', 'THA', '66', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(225, '6102800225', 'Timor-Leste', 'TL', 'TLS', '670', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(226, '6102800226', 'Togo', 'TG', 'TGO', '228', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(227, '6102800227', 'Tokelau', 'TK', 'TKL', '690', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(228, '6102800228', 'Tonga', 'TO', 'TON', '676', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(229, '6102800229', 'Trinidad and Tobago', 'TT', 'TTO', '1868', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(230, '6102800230', 'Tunisia', 'TN', 'TUN', '216', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(231, '6102800231', 'Turkey', 'TR', 'TUR', '90', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(232, '6102800232', 'Turkmenistan', 'TM', 'TKM', '7370', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(233, '6102800233', 'Turks and Caicos Islands', 'TC', 'TCA', '1649', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(234, '6102800234', 'Tuvalu', 'TV', 'TUV', '688', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(235, '6102800235', 'Uganda', 'UG', 'UGA', '256', 'Africa/Nairobi', 1, 1, '2024-05-31 21:13:12', '2021-08-20 12:43:39'),
(236, '6102800236', 'Ukraine', 'UA', 'UKR', '380', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(237, '6102800237', 'United Arab Emirates', 'AE', 'ARE', '971', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(238, '6102800238', 'United Kingdom', 'GB', 'GBR', '44', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(239, '6102800239', 'United States', 'US', 'USA', '1', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(240, '6102800240', 'United States Minor Outlying Islands', 'UM', 'UMI', '1', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(241, '6102800241', 'Uruguay', 'UY', 'URY', '598', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(242, '6102800242', 'Uzbekistan', 'UZ', 'UZB', '998', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(243, '6102800243', 'Vanuatu', 'VU', 'VUT', '678', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(244, '6102800244', 'Venezuela', 'VE', 'VEN', '58', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(245, '6102800245', 'Viet Nam', 'VN', 'VNM', '84', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(246, '6102800246', 'Virgin Islands, British', 'VG', 'VGB', '1284', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(247, '6102800247', 'Virgin Islands, U.s.', 'VI', 'VIR', '1340', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(248, '6102800248', 'Wallis and Futuna', 'WF', 'WLF', '681', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(249, '6102800249', 'Western Sahara', 'EH', 'ESH', '212', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(250, '6102800250', 'Yemen', 'YE', 'YEM', '967', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(251, '6102800251', 'Zambia', 'ZM', 'ZMB', '260', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(252, '6102800252', 'Zimbabwe', 'ZW', 'ZWE', '263', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39'),
(253, '6102800253', 'Not Applicable', 'NA', 'N/A', '0', 'Africa/Nairobi', 0, 0, '2021-08-20 12:43:39', '2021-08-20 12:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `m_county`
--

CREATE TABLE `m_county` (
  `id` int(11) NOT NULL,
  `county_id` varchar(255) NOT NULL,
  `country_id` varchar(255) NOT NULL DEFAULT '764520317',
  `name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 0,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_county`
--

INSERT INTO `m_county` (`id`, `county_id`, `country_id`, `name`, `state`, `active`, `updated_at`, `created_at`) VALUES
(1, '15504747293', '6102800116', 'Mombasa', 1, 1, '2021-11-11 18:40:18', '2019-02-18 06:55:44'),
(2, '15504725726', '6102800116', 'Kwale', 1, 1, '2022-11-03 23:56:57', '2019-02-18 06:55:44'),
(3, '15504741853', '6102800116', 'Kilifi', 1, 1, '2022-11-03 23:57:17', '2019-02-18 07:04:54'),
(4, '15504754016', '6102800116', 'Tana River', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(5, '15504733010', '6102800116', 'Lamu', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(6, '15504717229', '6102800116', 'Taita Taveta', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(7, '15504742527', '6102800116', 'Garissa', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(8, '15504785878', '6102800116', 'Wajir', 1, 1, '2022-11-03 23:59:17', '2019-02-18 07:04:54'),
(9, '15504725694', '6102800116', 'Mandera', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(10, '15504716781', '6102800116', 'Marsabit', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(11, '15504725854', '6102800116', 'Isiolo', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(12, '15504756719', '6102800116', 'Meru', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(13, '15504737138', '6102800116', 'Tharaka', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(14, '15504734801', '6102800116', 'Embu', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(15, '15504721828', '6102800116', 'Kitui', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(16, '15504710398', '6102800116', 'Machakos', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(17, '15504788688', '6102800116', 'Makueni', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(18, '15504739799', '6102800116', 'Nyandarua', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(19, '15504775055', '6102800116', 'Nyeri', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(20, '15504764012', '6102800116', 'Kirinyaga', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(21, '15504752584', '6102800116', 'Murang\'a', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(22, '15504713646', '6102800116', 'Kiambu', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:04:54'),
(23, '15504743172', '6102800116', 'Turkana', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:09:22'),
(24, '15504759292', '6102800116', 'West Pokot', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:09:22'),
(25, '15504710567', '6102800116', 'Samburu', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:09:22'),
(26, '15504770779', '6102800116', 'Trans-Nzoia', 1, 1, '2022-11-04 00:01:19', '2019-02-18 07:09:22'),
(27, '15504738063', '6102800116', 'Uasin Gishu', 1, 1, '2022-11-04 00:01:22', '2019-02-18 07:09:22'),
(28, '15504742186', '6102800116', 'Elgeyo-Marakwet', 1, 1, '2022-11-04 00:01:24', '2019-02-18 07:09:22'),
(29, '15504739588', '6102800116', 'Nandi', 1, 1, '2022-11-04 00:01:27', '2019-02-18 07:09:22'),
(30, '15504786851', '6102800116', 'Baringo', 1, 1, '2022-11-04 00:01:29', '2019-02-18 07:09:22'),
(31, '1550477930', '6102800116', 'Laikipia', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:09:22'),
(32, '15504786577', '6102800116', 'Nakuru', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:09:22'),
(33, '15504737308', '6102800116', 'Narok', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:16:20'),
(34, '15504751182', '6102800116', 'Kajiado', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:16:20'),
(35, '15504724696', '6102800116', 'Kericho', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:16:20'),
(36, '15504758853', '6102800116', 'Bomet', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:16:20'),
(37, '15504739665', '6102800116', 'Kakamega', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:16:20'),
(38, '15504758358', '6102800116', 'Vihiga', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:16:20'),
(39, '15504752234', '6102800116', 'Bungoma', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:16:20'),
(40, '15504771193', '6102800116', 'Busia', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:16:20'),
(41, '1550479407', '6102800116', 'Siaya', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:16:20'),
(42, '15504714697', '6102800116', 'Kisumu', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:16:20'),
(43, '15504712753', '6102800116', 'Homa Bay', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:16:20'),
(44, '15504726004', '6102800116', 'Migori', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:16:20'),
(45, '15504780464', '6102800116', 'Kisii', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:16:20'),
(46, '15504767229', '6102800116', 'Nyamira', 1, 1, '2022-11-04 00:02:10', '2019-02-18 07:16:20'),
(47, '15504768324', '6102800116', 'Nairobi', 1, 1, '2021-11-10 07:39:45', '2019-02-18 07:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `m_property_purpose`
--

CREATE TABLE `m_property_purpose` (
  `id` int(11) NOT NULL,
  `property_purpose_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `state` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_property_purpose`
--

INSERT INTO `m_property_purpose` (`id`, `property_purpose_id`, `name`, `path`, `order`, `state`, `active`, `updated_at`, `created_at`) VALUES
(1, '1752516734514', 'Buy', 'properties', 1, 1, 1, '2025-07-23 10:51:52', '2025-07-14 19:02:59'),
(2, '175251924071', 'Rent', 'properties', 2, 1, 1, '2025-07-23 14:26:48', '2025-07-14 19:03:29'),
(3, '1752511785272', 'Parking', 'parking', 4, 1, 1, '2025-07-23 14:26:58', '2025-07-14 19:04:13'),
(4, '1752928513775', 'Sell', 'properties', 3, 1, 1, '2025-07-23 14:26:53', '2025-07-19 11:32:36'),
(5, '1753273030032', 'Estate Agents', 'properties', 5, 1, 1, '2025-07-23 14:27:18', '2025-07-23 13:53:10'),
(6, '1753273901597', 'Vendor Management', 'properties', 6, 1, 1, '2025-07-23 14:27:23', '2025-07-23 13:53:54'),
(7, '1753277667560', 'Property Management ', 'properties', 7, 1, 1, '2025-07-23 14:27:28', '2025-07-23 13:54:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_type_id` varchar(255) NOT NULL,
  `signup_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `other_phone` varchar(255) NOT NULL,
  `tel_phone` varchar(255) NOT NULL,
  `id_no` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `about_me` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `profile_pic` text NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `activation_token` varchar(100) DEFAULT NULL,
  `reset_token_expiry` varchar(255) NOT NULL,
  `is_profile` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(11) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_type_id`, `signup_id`, `first_name`, `middle_name`, `last_name`, `phone`, `other_phone`, `tel_phone`, `id_no`, `location`, `address`, `about_me`, `email`, `username`, `profile_pic`, `email_verified_at`, `password`, `activation_token`, `reset_token_expiry`, `is_profile`, `is_active`, `updated_at`, `created_at`) VALUES
(26, 'USER-2c4fb62d50', '4534654653', '', 'Kelvin', 'Ngui', 'Muli', '0726542690', '0726542690', '0726542690', '30201211', 'Nairobi', 'Nairobi, Kenya', 'I am a tenant management agent   I am a tenant management agent                  \r\n                                                                                                                                                                                                                        ', 'mulikelvin17@gmail.com', 'Calvinh', 'assets/uploads/profile_pics/profile_26_1751570845.jpg', NULL, '$2y$10$GU58Um.pbNA3FNx4dsK8dufbrtTa6Rj8MbASzP7f6/AXVPNQHXB96', NULL, '', 1, 1, '2025-07-09 10:04:46', NULL),
(28, 'USER-f004e417d1', '4734656482', '', 'Kelvin', 'Ngui', 'Muli', '0726542690', '0726542690', '0726542690', '30201211', 'Nairobi', '', 'n/a                                                  ', 'admin@admin.com', 'mulikelvin', 'assets/uploads/profile_pics/profile_28_1751608319.jpg', NULL, '$2y$10$kgpDLoP33hqap0RkCduEaePfc9vHw6ronSO.5BKRwl4KZXPj95UxC', 'cc0e28670439f3f972f60c0b14f0c9d20141a5ddff1a55a2cee5a0cb0dc74139', '', 1, 1, '2025-07-25 09:59:53', NULL),
(29, 'USER-07f737d8c2', '4734656482', '', 'Victor', 'Kamau', 'Ngugi', '254727380799', '254727380799', '254727380799', '30086595', 'Kinoo', '', '                                                                                                    ', 'ivickinya@gmail.com', 'ivickinya', 'assets/uploads/profile_pics/profile_29_1752068157.jpeg', NULL, '$2y$10$dv9uOEj5U04YB2tmeYbe1.FkF2OY4/NPH2tr9lMAfssqFIn2PIV.S', '0fd2238eef0d97cf96288ed5fdb2cf5e8758e157c11532e8eefaa7d6f725ee46', '', 1, 1, '2025-07-10 12:25:12', NULL),
(30, 'USER-e3d6256d75', '4734656482', '', 'Mahdi', 'Abdi', 'Abdile', '+254706517337', '+254706517337', '+254706517337', '30201211', 'Nairobi', '', 'n/a                                                  ', 'mahdi.abdile@gmail.com', 'mahdi.abdile', 'assets/uploads/profile_pics/profile_28_1751608319.jpg', NULL, '$2y$10$XpWwd2c9nkhA.NxCpLt/HOEl4W7.f/b35KAJ19gqbGMIOsGqR03bG', 'cc0e28670439f3f972f60c0b14f0c9d20141a5ddff1a55a2cee5a0cb0dc74139', '', 1, 1, '2025-07-17 11:52:21', NULL),
(31, 'USER-6cae488594', '', '4534654652', '', '', '', '', '', '', '', '', '', '', 'biheni@mailinator.com', 'wajezak', '', NULL, '$2y$10$bDxHX/H09SbeNrhw28QzX.lK9jjLitxUum5qM0YD9e6w270PZ5j4O', '71bd5a827a5ea6339c84849a8ceef509f8beab6d832d969a26f317e09e2020c7', '', 0, 1, '2025-07-31 08:37:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_rights`
--

CREATE TABLE `user_rights` (
  `id` int(11) NOT NULL,
  `user_type_id` varchar(255) NOT NULL,
  `module_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `user_rights`
--

INSERT INTO `user_rights` (`id`, `user_type_id`, `module_id`, `date_time`) VALUES
(3, '48414324554', 'c78d7c5c3u8ca', '2020-06-09 16:27:05'),
(18, '484143245547887878', 'c78d7c5c376ca', '2020-09-13 21:41:24'),
(19, '484143245547887878', 'yuiommg6', '2020-09-13 21:41:25'),
(20, '484143245547887878', 'c78d7ubc38cat', '2020-09-13 21:41:27'),
(21, '484143245547887878', 'c78d7ubc38cattt', '2020-09-13 21:41:29'),
(22, '484143245547887878', 'c78d7ubc38carrrttt', '2020-09-13 21:41:30'),
(23, '484143245547887878', 'J8cL5x5HUK', '2020-09-13 21:41:32'),
(24, '484143245547887878', 'oiiiooomm', '2020-09-13 21:41:34'),
(25, '484143245547887878', 'c78d7c5c376caaaa', '2020-09-13 21:41:35'),
(31, '48414324554', 'oiiiooomm', '2020-09-13 21:44:37'),
(34, '48414324554', 'c78d7c5c376ca', '2020-09-13 21:47:31'),
(35, 'de8786ddf7c161', 'c78d7c5c376ca', '2020-09-19 15:36:21'),
(36, 'de8786ddf7c161', 'yuiommg6', '2020-09-19 15:36:29'),
(37, 'de8786ddf7c161', 'J8cL5x5HUK', '2020-09-19 15:36:37'),
(38, '4841432455478878', 'c78d7c5c376ca', '2020-09-19 16:06:58'),
(39, '4841432455478878', 'yuiommg6', '2020-09-19 16:07:00'),
(40, '4841432455478878', 'c78d7ubc38cat', '2020-09-19 16:07:03'),
(41, '4841432455478878', 'c78d7ubc38cattt', '2020-09-19 16:07:05'),
(43, '4841432455478878', 'J8cL5x5HUK', '2020-09-19 16:07:09'),
(44, '4841432455478878', 'oiiiooomm', '2020-09-19 16:07:10'),
(46, 'de8786ddf7c161', 'c78d7ubc38cat', '2020-09-19 23:53:37'),
(47, 'de8786ddf7c161', 'c78d7ubc38cattt', '2020-09-19 23:53:39'),
(48, 'de8786ddf7c161', 'c78d7ubc38carrrttt', '2020-09-19 23:53:41'),
(49, '4841432455478878', 'trertyu654', '2022-08-08 10:10:58'),
(50, '4841432455478878', 'c78d7c5c376caaaa', '2022-10-17 11:15:36'),
(51, '4841432455478878', 'c78d7ubc38carrrttt', '2022-10-17 11:16:00');

-- --------------------------------------------------------

--
-- Table structure for table `zidii_log`
--

CREATE TABLE `zidii_log` (
  `id` int(11) NOT NULL,
  `log` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zidii_transaction`
--

CREATE TABLE `zidii_transaction` (
  `payment_id` int(11) NOT NULL,
  `txncd` varchar(255) NOT NULL,
  `qwh` varchar(255) NOT NULL,
  `afd` varchar(255) NOT NULL,
  `poi` varchar(255) NOT NULL,
  `uyt` varchar(255) NOT NULL,
  `ifd` varchar(255) NOT NULL,
  `agt` varchar(255) NOT NULL,
  `id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `ivm` varchar(255) NOT NULL,
  `mc` varchar(255) NOT NULL,
  `p1` varchar(255) NOT NULL,
  `p2` varchar(255) NOT NULL,
  `p3` varchar(255) NOT NULL,
  `p4` varchar(255) NOT NULL,
  `msisdn_id` varchar(255) NOT NULL,
  `msisdn_idnum` varchar(255) NOT NULL,
  `channel` varchar(255) NOT NULL,
  `tokenid` text NOT NULL,
  `tokenemail` text NOT NULL,
  `card_mask` text NOT NULL,
  `hsh` text DEFAULT NULL,
  `date_time` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `state` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `club_member_admin`
--
ALTER TABLE `club_member_admin`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `club_member_audit_logs`
--
ALTER TABLE `club_member_audit_logs`
  ADD PRIMARY KEY (`audit_log_id`);

--
-- Indexes for table `club_member_billing_plan`
--
ALTER TABLE `club_member_billing_plan`
  ADD PRIMARY KEY (`billing_plan_id`);

--
-- Indexes for table `club_member_editions`
--
ALTER TABLE `club_member_editions`
  ADD PRIMARY KEY (`edition_id`),
  ADD UNIQUE KEY `edition_code` (`edition_code`);

--
-- Indexes for table `club_member_edition_modules`
--
ALTER TABLE `club_member_edition_modules`
  ADD PRIMARY KEY (`edition_id`,`module_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `club_member_email_settings`
--
ALTER TABLE `club_member_email_settings`
  ADD PRIMARY KEY (`email_setting_id`);

--
-- Indexes for table `club_member_error_logs`
--
ALTER TABLE `club_member_error_logs`
  ADD PRIMARY KEY (`error_id`);

--
-- Indexes for table `club_member_gateway`
--
ALTER TABLE `club_member_gateway`
  ADD PRIMARY KEY (`club_member_gateway_id`),
  ADD KEY `payment_gateway_provider_id` (`payment_gateway_provider_id`);

--
-- Indexes for table `club_member_modules`
--
ALTER TABLE `club_member_modules`
  ADD PRIMARY KEY (`module_id`),
  ADD UNIQUE KEY `module_name` (`module_name`),
  ADD UNIQUE KEY `module_code` (`module_code`);

--
-- Indexes for table `club_member_payment_gateway_providers`
--
ALTER TABLE `club_member_payment_gateway_providers`
  ADD PRIMARY KEY (`payment_gateway_provider_id`);

--
-- Indexes for table `club_member_scheduled_tasks`
--
ALTER TABLE `club_member_scheduled_tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD UNIQUE KEY `task_name` (`task_name`);

--
-- Indexes for table `club_member_settings`
--
ALTER TABLE `club_member_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_name` (`short_name`),
  ADD UNIQUE KEY `customer_id` (`customer_id`);

--
-- Indexes for table `customer_admin`
--
ALTER TABLE `customer_admin`
  ADD PRIMARY KEY (`customer_admin_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `uk_customer_email` (`customer_id`,`email_address`);

--
-- Indexes for table `customer_billing`
--
ALTER TABLE `customer_billing`
  ADD PRIMARY KEY (`customer_billing_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `billing_plan_id` (`billing_plan_id`);

--
-- Indexes for table `customer_billing_modules`
--
ALTER TABLE `customer_billing_modules`
  ADD PRIMARY KEY (`customer_billing_module_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `customer_billing_id` (`customer_billing_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `customer_billing_payments`
--
ALTER TABLE `customer_billing_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `customer_billing_id` (`customer_billing_id`);

--
-- Indexes for table `customer_db_settings`
--
ALTER TABLE `customer_db_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_domain` (`sub_domain`),
  ADD UNIQUE KEY `database_name` (`database_name`);

--
-- Indexes for table `customer_email_settings`
--
ALTER TABLE `customer_email_settings`
  ADD PRIMARY KEY (`customer_email_setting_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `customer_payment_gateway`
--
ALTER TABLE `customer_payment_gateway`
  ADD PRIMARY KEY (`customer_payment_gateway_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `payment_gateway_provider_id` (`payment_gateway_provider_id`);

--
-- Indexes for table `entities`
--
ALTER TABLE `entities`
  ADD PRIMARY KEY (`entity_id`);

--
-- Indexes for table `maintenance_module`
--
ALTER TABLE `maintenance_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_city`
--
ALTER TABLE `m_city`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `county_id` (`city_id`);

--
-- Indexes for table `m_country`
--
ALTER TABLE `m_country`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `country_id` (`country_id`);

--
-- Indexes for table `m_county`
--
ALTER TABLE `m_county`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `county_id` (`county_id`);

--
-- Indexes for table `m_property_purpose`
--
ALTER TABLE `m_property_purpose`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_type_id` (`property_purpose_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_rights`
--
ALTER TABLE `user_rights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zidii_log`
--
ALTER TABLE `zidii_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zidii_transaction`
--
ALTER TABLE `zidii_transaction`
  ADD PRIMARY KEY (`payment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `club_member_admin`
--
ALTER TABLE `club_member_admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `club_member_audit_logs`
--
ALTER TABLE `club_member_audit_logs`
  MODIFY `audit_log_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `club_member_billing_plan`
--
ALTER TABLE `club_member_billing_plan`
  MODIFY `billing_plan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `club_member_editions`
--
ALTER TABLE `club_member_editions`
  MODIFY `edition_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `club_member_email_settings`
--
ALTER TABLE `club_member_email_settings`
  MODIFY `email_setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `club_member_error_logs`
--
ALTER TABLE `club_member_error_logs`
  MODIFY `error_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `club_member_gateway`
--
ALTER TABLE `club_member_gateway`
  MODIFY `club_member_gateway_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `club_member_modules`
--
ALTER TABLE `club_member_modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `club_member_payment_gateway_providers`
--
ALTER TABLE `club_member_payment_gateway_providers`
  MODIFY `payment_gateway_provider_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `club_member_scheduled_tasks`
--
ALTER TABLE `club_member_scheduled_tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `club_member_settings`
--
ALTER TABLE `club_member_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer_admin`
--
ALTER TABLE `customer_admin`
  MODIFY `customer_admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_billing`
--
ALTER TABLE `customer_billing`
  MODIFY `customer_billing_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_billing_modules`
--
ALTER TABLE `customer_billing_modules`
  MODIFY `customer_billing_module_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_billing_payments`
--
ALTER TABLE `customer_billing_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_email_settings`
--
ALTER TABLE `customer_email_settings`
  MODIFY `customer_email_setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_payment_gateway`
--
ALTER TABLE `customer_payment_gateway`
  MODIFY `customer_payment_gateway_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entities`
--
ALTER TABLE `entities`
  MODIFY `entity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_module`
--
ALTER TABLE `maintenance_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `m_city`
--
ALTER TABLE `m_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `m_country`
--
ALTER TABLE `m_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `m_county`
--
ALTER TABLE `m_county`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `m_property_purpose`
--
ALTER TABLE `m_property_purpose`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_rights`
--
ALTER TABLE `user_rights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `club_member_edition_modules`
--
ALTER TABLE `club_member_edition_modules`
  ADD CONSTRAINT `club_member_edition_modules_ibfk_1` FOREIGN KEY (`edition_id`) REFERENCES `club_member_editions` (`edition_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `club_member_edition_modules_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `club_member_modules` (`module_id`) ON DELETE CASCADE;

--
-- Constraints for table `club_member_gateway`
--
ALTER TABLE `club_member_gateway`
  ADD CONSTRAINT `club_member_gateway_ibfk_1` FOREIGN KEY (`payment_gateway_provider_id`) REFERENCES `club_member_payment_gateway_providers` (`payment_gateway_provider_id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_admin`
--
ALTER TABLE `customer_admin`
  ADD CONSTRAINT `customer_admin_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_billing`
--
ALTER TABLE `customer_billing`
  ADD CONSTRAINT `customer_billing_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_billing_ibfk_2` FOREIGN KEY (`billing_plan_id`) REFERENCES `club_member_billing_plan` (`billing_plan_id`);

--
-- Constraints for table `customer_billing_modules`
--
ALTER TABLE `customer_billing_modules`
  ADD CONSTRAINT `customer_billing_modules_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_billing_modules_ibfk_2` FOREIGN KEY (`customer_billing_id`) REFERENCES `customer_billing` (`customer_billing_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_billing_modules_ibfk_3` FOREIGN KEY (`module_id`) REFERENCES `club_member_modules` (`module_id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_billing_payments`
--
ALTER TABLE `customer_billing_payments`
  ADD CONSTRAINT `customer_billing_payments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_billing_payments_ibfk_2` FOREIGN KEY (`customer_billing_id`) REFERENCES `customer_billing` (`customer_billing_id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_email_settings`
--
ALTER TABLE `customer_email_settings`
  ADD CONSTRAINT `customer_email_settings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_payment_gateway`
--
ALTER TABLE `customer_payment_gateway`
  ADD CONSTRAINT `customer_payment_gateway_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_payment_gateway_ibfk_2` FOREIGN KEY (`payment_gateway_provider_id`) REFERENCES `club_member_payment_gateway_providers` (`payment_gateway_provider_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
