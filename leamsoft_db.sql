-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2026 at 11:29 AM
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
-- Database: `leamsoft_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `url_link` text DEFAULT NULL,
  `banner` varchar(100) DEFAULT NULL,
  `tag_line` text DEFAULT NULL,
  `image_alt` text DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `uid` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `name`, `url_link`, `banner`, `tag_line`, `image_alt`, `position`, `status`, `uid`, `created_at`, `updated_at`) VALUES
(5, 'Leamsoft Pvt. Ltd.', '/', 'uploads/banner/mI6AjhhpK3VPV9CXM1QtnNqOaEKAzfvIZThrd2rt.jpg', 'Leamsoft Pvt. Ltd.', 'Leamsoft Pvt. Ltd.', 1, 1, 3, '2026-05-26 01:52:46', '2026-05-26 01:52:46');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `banner` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `slug` text DEFAULT NULL,
  `image_alt` text DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `uid` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"d\";s:6:\"status\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:40:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:15:\"category-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:13:\"category-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:15:\"category-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:16:\"category-publish\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:18:\"subcategory-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:5;a:5:{s:1:\"a\";i:6;s:1:\"b\";s:16:\"subcategory-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:6;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:18:\"subcategory-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:7;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:19:\"subcategory-publish\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:8;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:11:\"user-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:9;a:5:{s:1:\"a\";i:10;s:1:\"b\";s:9:\"user-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:10;a:5:{s:1:\"a\";i:11;s:1:\"b\";s:11:\"user-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:11;a:5:{s:1:\"a\";i:12;s:1:\"b\";s:12:\"user-publish\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:12;a:5:{s:1:\"a\";i:13;s:1:\"b\";s:11:\"role-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:13;a:5:{s:1:\"a\";i:14;s:1:\"b\";s:9:\"role-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:14;a:5:{s:1:\"a\";i:15;s:1:\"b\";s:11:\"role-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:15;a:5:{s:1:\"a\";i:16;s:1:\"b\";s:12:\"role-publish\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:16;a:5:{s:1:\"a\";i:17;s:1:\"b\";s:17:\"permission-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:17;a:5:{s:1:\"a\";i:18;s:1:\"b\";s:15:\"permission-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:18;a:5:{s:1:\"a\";i:19;s:1:\"b\";s:17:\"permission-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:19;a:5:{s:1:\"a\";i:20;s:1:\"b\";s:18:\"permission-publish\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:20;a:5:{s:1:\"a\";i:21;s:1:\"b\";s:15:\"general-setting\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:21;a:5:{s:1:\"a\";i:22;s:1:\"b\";s:13:\"banner-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:22;a:5:{s:1:\"a\";i:23;s:1:\"b\";s:11:\"banner-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:23;a:5:{s:1:\"a\";i:24;s:1:\"b\";s:13:\"banner-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:24;a:5:{s:1:\"a\";i:25;s:1:\"b\";s:14:\"banner-publish\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:25;a:5:{s:1:\"a\";i:26;s:1:\"b\";s:14:\"service-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:26;a:5:{s:1:\"a\";i:27;s:1:\"b\";s:12:\"service-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:27;a:5:{s:1:\"a\";i:28;s:1:\"b\";s:14:\"service-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:28;a:5:{s:1:\"a\";i:29;s:1:\"b\";s:15:\"service-publish\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:29;a:5:{s:1:\"a\";i:30;s:1:\"b\";s:11:\"blog-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:30;a:5:{s:1:\"a\";i:31;s:1:\"b\";s:9:\"blog-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:31;a:5:{s:1:\"a\";i:32;s:1:\"b\";s:11:\"blog-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:32;a:5:{s:1:\"a\";i:33;s:1:\"b\";s:12:\"blog-publish\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:33;a:5:{s:1:\"a\";i:34;s:1:\"b\";s:15:\"admin-dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:34;a:5:{s:1:\"a\";i:35;s:1:\"b\";s:12:\"enquiry-read\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:35;a:5:{s:1:\"a\";i:36;s:1:\"b\";s:14:\"gallery-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:36;a:5:{s:1:\"a\";i:37;s:1:\"b\";s:12:\"gallery-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:37;a:5:{s:1:\"a\";i:38;s:1:\"b\";s:14:\"gallery-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:38;a:5:{s:1:\"a\";i:39;s:1:\"b\";s:15:\"gallery-publish\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}i:39;a:5:{s:1:\"a\";i:40;s:1:\"b\";s:7:\"setting\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:5;i:1;i:6;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:11:\"Super Admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:6;s:1:\"b\";s:3:\"CEO\";s:1:\"c\";s:3:\"web\";}}}', 1780910898),
('work.adityasahgal@gmail.com|127.0.0.1', 'i:1;', 1780824544),
('work.adityasahgal@gmail.com|127.0.0.1:timer', 'i:1780824544;', 1780824544);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(100) DEFAULT NULL,
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` int(11) NOT NULL DEFAULT 0,
  `top` int(11) NOT NULL DEFAULT 0,
  `slug` text DEFAULT NULL,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_alt` text DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `uid` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail_img` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `banner`, `icon`, `featured`, `top`, `slug`, `short_description`, `description`, `image_alt`, `meta_title`, `meta_description`, `keywords`, `status`, `uid`, `created_at`, `updated_at`, `color`, `thumbnail_img`, `sort_order`) VALUES
(3, 'Software Development', NULL, '💻', 1, 0, 'software-development', 'Custom web, mobile, and enterprise software built to scale.', 'We design and build robust software products — from MVPs to mission-critical enterprise systems. Modern stacks, clean code, and a relentless focus on shipping what users need.', NULL, 'Software Development Services | LEAMSOFT', 'Custom web, mobile, and enterprise software built to scale.', 'software development, leamsoft, it services', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '#00b4ff', NULL, 0),
(4, 'AI & Machine Learning', NULL, '🤖', 1, 0, 'ai-machine-learning', 'Custom AI models and LLM integrations that transform how you operate.', 'From predictive analytics to LLM-powered assistants and computer vision pipelines — we build AI that solves real business problems.', NULL, 'AI & Machine Learning Services | LEAMSOFT', 'Custom AI models and LLM integrations that transform how you operate.', 'ai & machine learning, leamsoft, it services', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '#a855f7', NULL, 1),
(5, 'Cloud Solutions', NULL, '☁️', 1, 0, 'cloud-solutions', 'AWS, Azure & GCP expertise for the modern enterprise.', 'We architect, migrate, and manage cloud infrastructure that is secure, cost-effective, and built for scale.', NULL, 'Cloud Solutions Services | LEAMSOFT', 'AWS, Azure & GCP expertise for the modern enterprise.', 'cloud solutions, leamsoft, it services', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '#39d353', NULL, 2),
(6, 'Cyber Security', NULL, '🛡️', 1, 0, 'cyber-security', 'Enterprise security from pen testing to compliance.', 'End-to-end cyber security services that protect your business, your data, and your reputation.', NULL, 'Cyber Security Services | LEAMSOFT', 'Enterprise security from pen testing to compliance.', 'cyber security, leamsoft, it services', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '#ff3b5c', NULL, 3),
(7, 'Digital Marketing', NULL, '📈', 1, 0, 'digital-marketing', 'Data-driven growth marketing that compounds.', 'SEO, paid campaigns, content, and analytics that grow brands beyond vanity metrics.', NULL, 'Digital Marketing Services | LEAMSOFT', 'Data-driven growth marketing that compounds.', 'digital marketing, leamsoft, it services', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '#ff8c00', NULL, 4),
(8, 'IT Consulting', NULL, '💼', 1, 0, 'it-consulting', 'Strategic technology advisory aligned to business outcomes.', 'Strategic guidance from leaders who have shipped at scale — from technology roadmaps to team augmentation.', NULL, 'IT Consulting Services | LEAMSOFT', 'Strategic technology advisory aligned to business outcomes.', 'it consulting, leamsoft, it services', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '#ffd700', NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL,
  `pname` text DEFAULT NULL,
  `name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `phone` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`id`, `pname`, `name`, `email`, `phone`, `message`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Aditya Sahgal', 'adityasahagal399@gmail.com', '7895481169', 'This is a test message', '2025-01-17 14:55:14', '2025-01-17 14:55:14'),
(2, NULL, 'qNhrtqEcZEqa', 'jv0gld5er3do4zqdr@yahoo.com', '9941063334', 'DGVeDgGt', '2025-01-18 03:06:58', '2025-01-18 03:06:58'),
(3, NULL, 'Zoey Collins', 'jose.kirtley@hotmail.com', '2551132238', 'Quickly Claim Your Self-Employed Tax Refund\r\n\r\nIf you’re self-employed, this is your moment to save big. The SETC program won’t last forever—claim your refund while you can!\r\n\r\nVisit: https://bit.ly/SETC-Pros now\r\n\r\nHere’s why you can’t wait:\r\n- Discover tax credits you might have overlooked.  \r\n- Get your refund in just 5-7 days after submitting your SETC packet.  \r\n\r\n+ Don’t wait! Tax credits end in April 2025, so act fast. Secure your rightful refund today!  \r\n\r\n* Why This Matters to You:\r\n- Your finances could get a huge boost with this refund.  \r\n- This streamlined process makes getting your refund a breeze.  \r\n\r\nTurn Q1 2025 into your most profitable quarter.\r\n\r\nBegin your journey to financial relief today!  \r\n\r\nVisit: https://bit.ly/SETC-Pros now\r\n\r\n\r\n\r\n\r\nIf you wish to stop to receive emails from me anymore, just fill the form at https://bit.ly/unsubscribenowpls with your website url.', '2025-01-18 19:34:27', '2025-01-18 19:34:27'),
(4, NULL, 'Johanna', 'info@nicolai.medicopostura.com', '6805036624', 'Hey \r\n\r\nLooking to improve your posture and live a healthier life? Our Medico Postura™ Body Posture Corrector is here to help!\r\n\r\nExperience instant posture improvement with Medico Postura™. This easy-to-use device can be worn anywhere, anytime – at home, work, or even while you sleep.\r\n\r\nMade from lightweight, breathable fabric, it ensures comfort all day long.\r\n\r\nGrab it today at a fantastic 60% OFF: https://medicopostura.com\r\n\r\nPlus, enjoy FREE shipping for today only!\r\n\r\nDon\'t miss out on this amazing deal. Get yours now and start transforming your posture!\r\n\r\nThank You, \r\n\r\nJohanna', '2025-01-19 17:12:26', '2025-01-19 17:12:26'),
(5, NULL, 'AZjvSsQrkUow', 'diucyluxxqdmywcnh@yahoo.com', '9798613174', 'hhQFAJDoNxiDA', '2025-01-19 21:24:55', '2025-01-19 21:24:55'),
(6, NULL, 'ADITYA SAHGAL', 'adityasahagal399@gmail.com', '7895481169', 'Test', '2026-05-28 00:20:01', '2026-05-28 00:20:01');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `tag_line` text DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `uid` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_05_20_172256_create_permission_tables', 1),
(5, '2025_01_20_165319_create_gallery_table', 2),
(6, '2026_05_24_100000_create_categories_table', 3),
(7, '2026_05_24_100001_create_subcategories_table', 3),
(8, '2026_05_24_100002_add_category_columns_to_services_table', 3),
(9, '2026_05_24_100003_fix_emoji_charset_on_category_tables', 4),
(10, '2026_05_26_120000_create_real_gallery_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 3),
(5, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 3),
(6, 'App\\Models\\User', 1),
(6, 'App\\Models\\User', 3),
(7, 'App\\Models\\User', 1),
(7, 'App\\Models\\User', 3),
(8, 'App\\Models\\User', 1),
(8, 'App\\Models\\User', 3),
(9, 'App\\Models\\User', 1),
(9, 'App\\Models\\User', 3),
(10, 'App\\Models\\User', 1),
(10, 'App\\Models\\User', 3),
(11, 'App\\Models\\User', 1),
(11, 'App\\Models\\User', 3),
(12, 'App\\Models\\User', 1),
(12, 'App\\Models\\User', 3),
(13, 'App\\Models\\User', 1),
(13, 'App\\Models\\User', 3),
(14, 'App\\Models\\User', 1),
(14, 'App\\Models\\User', 3),
(15, 'App\\Models\\User', 1),
(15, 'App\\Models\\User', 3),
(16, 'App\\Models\\User', 1),
(16, 'App\\Models\\User', 3),
(17, 'App\\Models\\User', 1),
(17, 'App\\Models\\User', 3),
(18, 'App\\Models\\User', 1),
(18, 'App\\Models\\User', 3),
(19, 'App\\Models\\User', 1),
(19, 'App\\Models\\User', 3),
(20, 'App\\Models\\User', 1),
(20, 'App\\Models\\User', 3),
(21, 'App\\Models\\User', 1),
(21, 'App\\Models\\User', 3),
(22, 'App\\Models\\User', 1),
(22, 'App\\Models\\User', 3),
(23, 'App\\Models\\User', 1),
(23, 'App\\Models\\User', 3),
(24, 'App\\Models\\User', 1),
(24, 'App\\Models\\User', 3),
(25, 'App\\Models\\User', 1),
(25, 'App\\Models\\User', 3),
(26, 'App\\Models\\User', 1),
(26, 'App\\Models\\User', 3),
(27, 'App\\Models\\User', 1),
(27, 'App\\Models\\User', 3),
(28, 'App\\Models\\User', 1),
(28, 'App\\Models\\User', 3),
(29, 'App\\Models\\User', 1),
(29, 'App\\Models\\User', 3),
(30, 'App\\Models\\User', 1),
(30, 'App\\Models\\User', 3),
(31, 'App\\Models\\User', 1),
(31, 'App\\Models\\User', 3),
(32, 'App\\Models\\User', 1),
(32, 'App\\Models\\User', 3),
(33, 'App\\Models\\User', 1),
(33, 'App\\Models\\User', 3),
(34, 'App\\Models\\User', 1),
(34, 'App\\Models\\User', 3),
(35, 'App\\Models\\User', 1),
(35, 'App\\Models\\User', 3),
(36, 'App\\Models\\User', 1),
(36, 'App\\Models\\User', 3),
(37, 'App\\Models\\User', 1),
(37, 'App\\Models\\User', 3),
(38, 'App\\Models\\User', 1),
(38, 'App\\Models\\User', 3),
(39, 'App\\Models\\User', 1),
(39, 'App\\Models\\User', 3),
(40, 'App\\Models\\User', 1),
(40, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(5, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 3),
(6, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'category-create', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(2, 'category-edit', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(3, 'category-delete', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(4, 'category-publish', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(5, 'subcategory-create', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(6, 'subcategory-edit', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(7, 'subcategory-delete', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(8, 'subcategory-publish', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(9, 'user-create', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(10, 'user-edit', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(11, 'user-delete', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(12, 'user-publish', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(13, 'role-create', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(14, 'role-edit', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(15, 'role-delete', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(16, 'role-publish', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(17, 'permission-create', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(18, 'permission-edit', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(19, 'permission-delete', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(20, 'permission-publish', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(21, 'general-setting', 'web', 1, '2024-05-21 09:44:18', '2024-05-21 09:44:18'),
(22, 'banner-create', 'web', 1, '2024-05-23 03:06:36', '2024-05-23 03:06:36'),
(23, 'banner-edit', 'web', 1, '2024-05-23 03:06:56', '2024-05-23 03:06:56'),
(24, 'banner-delete', 'web', 1, '2024-05-23 03:07:15', '2024-05-23 03:07:15'),
(25, 'banner-publish', 'web', 1, '2024-05-23 03:07:38', '2024-05-23 03:07:38'),
(26, 'service-create', 'web', 1, '2024-05-25 02:30:58', '2024-05-25 02:30:58'),
(27, 'service-edit', 'web', 1, '2024-05-25 02:31:25', '2024-05-25 02:31:25'),
(28, 'service-delete', 'web', 1, '2024-05-25 02:31:48', '2024-05-25 02:31:48'),
(29, 'service-publish', 'web', 1, '2024-05-25 02:32:07', '2024-05-25 02:32:07'),
(30, 'blog-create', 'web', 1, '2024-05-25 02:32:30', '2024-05-25 02:32:30'),
(31, 'blog-edit', 'web', 1, '2024-05-25 02:32:46', '2024-05-25 02:32:46'),
(32, 'blog-delete', 'web', 1, '2024-05-25 02:33:04', '2024-05-25 02:33:04'),
(33, 'blog-publish', 'web', 1, '2024-05-25 02:33:22', '2024-05-25 02:33:22'),
(34, 'admin-dashboard', 'web', 1, '2024-05-28 11:28:15', '2024-05-28 11:28:15'),
(35, 'enquiry-read', 'web', 1, '2024-07-26 13:05:01', '2024-07-26 13:05:01'),
(36, 'gallery-create', 'web', 1, '2026-05-26 01:09:01', '2026-05-26 01:09:01'),
(37, 'gallery-edit', 'web', 1, '2026-05-26 01:09:01', '2026-05-26 01:09:01'),
(38, 'gallery-delete', 'web', 1, '2026-05-26 01:09:01', '2026-05-26 01:09:01'),
(39, 'gallery-publish', 'web', 1, '2026-05-26 01:09:01', '2026-05-26 01:09:01'),
(40, 'setting', 'web', 1, '2026-05-26 01:09:01', '2026-05-26 01:09:01');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(5, 'Super Admin', 'web', '2026-05-26 01:09:01', '2026-05-26 01:09:01'),
(6, 'CEO', 'web', '2026-05-26 01:47:55', '2026-05-26 01:47:55');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 5),
(1, 6),
(2, 5),
(2, 6),
(3, 5),
(3, 6),
(4, 5),
(4, 6),
(5, 5),
(5, 6),
(6, 5),
(6, 6),
(7, 5),
(7, 6),
(8, 5),
(8, 6),
(9, 5),
(9, 6),
(10, 5),
(10, 6),
(11, 5),
(11, 6),
(12, 5),
(12, 6),
(13, 5),
(13, 6),
(14, 5),
(14, 6),
(15, 5),
(15, 6),
(16, 5),
(16, 6),
(17, 5),
(17, 6),
(18, 5),
(18, 6),
(19, 5),
(19, 6),
(20, 5),
(20, 6),
(21, 5),
(21, 6),
(22, 5),
(22, 6),
(23, 5),
(23, 6),
(24, 5),
(24, 6),
(25, 5),
(25, 6),
(26, 5),
(26, 6),
(27, 5),
(27, 6),
(28, 5),
(28, 6),
(29, 5),
(29, 6),
(30, 5),
(30, 6),
(31, 5),
(31, 6),
(32, 5),
(32, 6),
(33, 5),
(33, 6),
(34, 5),
(34, 6),
(35, 5),
(35, 6),
(36, 5),
(36, 6),
(37, 5),
(37, 6),
(38, 5),
(38, 6),
(39, 5),
(39, 6),
(40, 5),
(40, 6);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` text DEFAULT NULL,
  `thumbnail_img` text DEFAULT NULL,
  `photos` text DEFAULT NULL,
  `image_alt` text DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `mrp_price` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `gst` int(11) DEFAULT NULL,
  `tax` int(11) DEFAULT NULL,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` text DEFAULT NULL,
  `h1_tag` text DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `featured` int(11) NOT NULL DEFAULT 0,
  `top` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `uid` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category_id`, `subcategory_id`, `name`, `code`, `thumbnail_img`, `photos`, `image_alt`, `price`, `mrp_price`, `discount`, `gst`, `tax`, `short_description`, `description`, `slug`, `h1_tag`, `meta_title`, `meta_description`, `keywords`, `featured`, `top`, `status`, `uid`, `created_at`, `updated_at`, `icon`, `sort_order`) VALUES
(5, 3, 4, 'Web Development', NULL, NULL, NULL, 'Web Development', 0, 0, 0, 0, 0, 'Performant, SEO-friendly web platforms.', '<p>Performant, SEO-friendly web platforms.</p><p>At LEAMSOFT, our web development practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'web-development', 'Web Development', 'Web Development Services | LEAMSOFT', 'Performant, SEO-friendly web platforms.', 'web development, leamsoft, it services', 1, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🌐', 0),
(6, 3, 5, 'Mobile App Development', NULL, NULL, NULL, 'Mobile App Development', 0, 0, 0, 0, 0, 'Native and cross-platform mobile apps.', '<p>Native and cross-platform mobile apps.</p><p>At LEAMSOFT, our mobile app development practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'mobile-app-development', 'Mobile App Development', 'Mobile App Development Services | LEAMSOFT', 'Native and cross-platform mobile apps.', 'mobile app development, leamsoft, it services', 1, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '📱', 1),
(7, 3, 6, 'Enterprise Software', NULL, NULL, NULL, 'Enterprise Software', 0, 0, 0, 0, 0, 'ERP, CRM, and bespoke internal tools.', '<p>ERP, CRM, and bespoke internal tools.</p><p>At LEAMSOFT, our enterprise software practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'enterprise-software', 'Enterprise Software', 'Enterprise Software Services | LEAMSOFT', 'ERP, CRM, and bespoke internal tools.', 'enterprise software, leamsoft, it services', 0, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🏢', 2),
(8, 3, 7, 'E-Commerce Platforms', NULL, NULL, NULL, 'E-Commerce Platforms', 0, 0, 0, 0, 0, 'Custom storefronts and checkout flows.', '<p>Custom storefronts and checkout flows.</p><p>At LEAMSOFT, our e-commerce platforms practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'e-commerce-platforms', 'E-Commerce Platforms', 'E-Commerce Platforms Services | LEAMSOFT', 'Custom storefronts and checkout flows.', 'e-commerce platforms, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🛒', 3),
(9, 3, 8, 'API Development', NULL, NULL, NULL, 'API Development', 0, 0, 0, 0, 0, 'REST & GraphQL APIs that scale.', '<p>REST & GraphQL APIs that scale.</p><p>At LEAMSOFT, our api development practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'api-development', 'API Development', 'API Development Services | LEAMSOFT', 'REST & GraphQL APIs that scale.', 'api development, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🔌', 4),
(10, 3, 9, 'SaaS Product Development', NULL, NULL, NULL, 'SaaS Product Development', 0, 0, 0, 0, 0, 'Multi-tenant SaaS from idea to launch.', '<p>Multi-tenant SaaS from idea to launch.</p><p>At LEAMSOFT, our saas product development practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'saas-product-development', 'SaaS Product Development', 'SaaS Product Development Services | LEAMSOFT', 'Multi-tenant SaaS from idea to launch.', 'saas product development, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '☁️', 5),
(11, 4, 10, 'Custom AI Models', NULL, NULL, NULL, 'Custom AI Models', 0, 0, 0, 0, 0, 'ML models trained on your data.', '<p>ML models trained on your data.</p><p>At LEAMSOFT, our custom ai models practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'custom-ai-models', 'Custom AI Models', 'Custom AI Models Services | LEAMSOFT', 'ML models trained on your data.', 'custom ai models, leamsoft, it services', 1, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🧠', 0),
(12, 4, 11, 'LLM Integration', NULL, NULL, NULL, 'LLM Integration', 0, 0, 0, 0, 0, 'GPT, Claude, and open-source LLMs.', '<p>GPT, Claude, and open-source LLMs.</p><p>At LEAMSOFT, our llm integration practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'llm-integration', 'LLM Integration', 'LLM Integration Services | LEAMSOFT', 'GPT, Claude, and open-source LLMs.', 'llm integration, leamsoft, it services', 1, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '💬', 1),
(13, 4, 12, 'Computer Vision', NULL, NULL, NULL, 'Computer Vision', 0, 0, 0, 0, 0, 'Image & video understanding.', '<p>Image & video understanding.</p><p>At LEAMSOFT, our computer vision practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'computer-vision', 'Computer Vision', 'Computer Vision Services | LEAMSOFT', 'Image & video understanding.', 'computer vision, leamsoft, it services', 0, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '👁️', 2),
(14, 4, 13, 'Predictive Analytics', NULL, NULL, NULL, 'Predictive Analytics', 0, 0, 0, 0, 0, 'Forecasting and decision intelligence.', '<p>Forecasting and decision intelligence.</p><p>At LEAMSOFT, our predictive analytics practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'predictive-analytics', 'Predictive Analytics', 'Predictive Analytics Services | LEAMSOFT', 'Forecasting and decision intelligence.', 'predictive analytics, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '📊', 3),
(15, 4, 14, 'NLP Solutions', NULL, NULL, NULL, 'NLP Solutions', 0, 0, 0, 0, 0, 'Text classification, extraction, summarisation.', '<p>Text classification, extraction, summarisation.</p><p>At LEAMSOFT, our nlp solutions practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'nlp-solutions', 'NLP Solutions', 'NLP Solutions Services | LEAMSOFT', 'Text classification, extraction, summarisation.', 'nlp solutions, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '📝', 4),
(16, 4, 15, 'MLOps & Deployment', NULL, NULL, NULL, 'MLOps & Deployment', 0, 0, 0, 0, 0, 'Production AI infrastructure.', '<p>Production AI infrastructure.</p><p>At LEAMSOFT, our mlops & deployment practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'mlops-deployment', 'MLOps & Deployment', 'MLOps & Deployment Services | LEAMSOFT', 'Production AI infrastructure.', 'mlops & deployment, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '⚙️', 5),
(17, 5, 16, 'Cloud Migration', NULL, NULL, NULL, 'Cloud Migration', 0, 0, 0, 0, 0, 'Lift-and-shift to cloud-native moves.', '<p>Lift-and-shift to cloud-native moves.</p><p>At LEAMSOFT, our cloud migration practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'cloud-migration', 'Cloud Migration', 'Cloud Migration Services | LEAMSOFT', 'Lift-and-shift to cloud-native moves.', 'cloud migration, leamsoft, it services', 1, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🚀', 0),
(18, 5, 17, 'Cloud Architecture', NULL, NULL, NULL, 'Cloud Architecture', 0, 0, 0, 0, 0, 'Multi-region, fault-tolerant systems.', '<p>Multi-region, fault-tolerant systems.</p><p>At LEAMSOFT, our cloud architecture practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'cloud-architecture', 'Cloud Architecture', 'Cloud Architecture Services | LEAMSOFT', 'Multi-region, fault-tolerant systems.', 'cloud architecture, leamsoft, it services', 1, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🏗️', 1),
(19, 5, 18, 'DevOps & CI/CD', NULL, NULL, NULL, 'DevOps & CI/CD', 0, 0, 0, 0, 0, 'Automated pipelines and infrastructure as code.', '<p>Automated pipelines and infrastructure as code.</p><p>At LEAMSOFT, our devops & ci/cd practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'devops-cicd', 'DevOps & CI/CD', 'DevOps & CI/CD Services | LEAMSOFT', 'Automated pipelines and infrastructure as code.', 'devops & ci/cd, leamsoft, it services', 0, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🔄', 2),
(20, 5, 19, 'Kubernetes & Docker', NULL, NULL, NULL, 'Kubernetes & Docker', 0, 0, 0, 0, 0, 'Containerised production environments.', '<p>Containerised production environments.</p><p>At LEAMSOFT, our kubernetes & docker practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'kubernetes-docker', 'Kubernetes & Docker', 'Kubernetes & Docker Services | LEAMSOFT', 'Containerised production environments.', 'kubernetes & docker, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '📦', 3),
(21, 5, 20, 'Serverless Solutions', NULL, NULL, NULL, 'Serverless Solutions', 0, 0, 0, 0, 0, 'AWS Lambda, Azure Functions, Cloud Run.', '<p>AWS Lambda, Azure Functions, Cloud Run.</p><p>At LEAMSOFT, our serverless solutions practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'serverless-solutions', 'Serverless Solutions', 'Serverless Solutions Services | LEAMSOFT', 'AWS Lambda, Azure Functions, Cloud Run.', 'serverless solutions, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '⚡', 4),
(22, 5, 21, 'Managed Cloud Ops', NULL, NULL, NULL, 'Managed Cloud Ops', 0, 0, 0, 0, 0, '24/7 monitoring and managed services.', '<p>24/7 monitoring and managed services.</p><p>At LEAMSOFT, our managed cloud ops practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'managed-cloud-ops', 'Managed Cloud Ops', 'Managed Cloud Ops Services | LEAMSOFT', '24/7 monitoring and managed services.', 'managed cloud ops, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🛠️', 5),
(23, 6, 22, 'Penetration Testing', NULL, NULL, NULL, 'Penetration Testing', 0, 0, 0, 0, 0, 'Find vulnerabilities before attackers do.', '<p>Find vulnerabilities before attackers do.</p><p>At LEAMSOFT, our penetration testing practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'penetration-testing', 'Penetration Testing', 'Penetration Testing Services | LEAMSOFT', 'Find vulnerabilities before attackers do.', 'penetration testing, leamsoft, it services', 1, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🎯', 0),
(24, 6, 23, 'Vulnerability Assessment', NULL, NULL, NULL, 'Vulnerability Assessment', 0, 0, 0, 0, 0, 'Continuous scanning and reporting.', '<p>Continuous scanning and reporting.</p><p>At LEAMSOFT, our vulnerability assessment practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'vulnerability-assessment', 'Vulnerability Assessment', 'Vulnerability Assessment Services | LEAMSOFT', 'Continuous scanning and reporting.', 'vulnerability assessment, leamsoft, it services', 1, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🔍', 1),
(25, 6, 24, 'Compliance & Audit', NULL, NULL, NULL, 'Compliance & Audit', 0, 0, 0, 0, 0, 'ISO 27001, SOC2, GDPR readiness.', '<p>ISO 27001, SOC2, GDPR readiness.</p><p>At LEAMSOFT, our compliance & audit practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'compliance-audit', 'Compliance & Audit', 'Compliance & Audit Services | LEAMSOFT', 'ISO 27001, SOC2, GDPR readiness.', 'compliance & audit, leamsoft, it services', 0, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '📋', 2),
(26, 6, 25, 'Incident Response', NULL, NULL, NULL, 'Incident Response', 0, 0, 0, 0, 0, 'Rapid response and post-mortem.', '<p>Rapid response and post-mortem.</p><p>At LEAMSOFT, our incident response practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'incident-response', 'Incident Response', 'Incident Response Services | LEAMSOFT', 'Rapid response and post-mortem.', 'incident response, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '⚠️', 3),
(27, 6, 26, 'Data Protection', NULL, NULL, NULL, 'Data Protection', 0, 0, 0, 0, 0, 'Encryption, DLP, and privacy controls.', '<p>Encryption, DLP, and privacy controls.</p><p>At LEAMSOFT, our data protection practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'data-protection', 'Data Protection', 'Data Protection Services | LEAMSOFT', 'Encryption, DLP, and privacy controls.', 'data protection, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🔐', 4),
(28, 6, 27, 'Security Operations', NULL, NULL, NULL, 'Security Operations', 0, 0, 0, 0, 0, 'SOC, SIEM, and threat monitoring.', '<p>SOC, SIEM, and threat monitoring.</p><p>At LEAMSOFT, our security operations practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'security-operations', 'Security Operations', 'Security Operations Services | LEAMSOFT', 'SOC, SIEM, and threat monitoring.', 'security operations, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '👮', 5),
(29, 7, 28, 'SEO Services', NULL, NULL, NULL, 'SEO Services', 0, 0, 0, 0, 0, 'Technical SEO and content optimisation.', '<p>Technical SEO and content optimisation.</p><p>At LEAMSOFT, our seo services practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'seo-services', 'SEO Services', 'SEO Services Services | LEAMSOFT', 'Technical SEO and content optimisation.', 'seo services, leamsoft, it services', 1, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🔍', 0),
(30, 7, 29, 'PPC Advertising', NULL, NULL, NULL, 'PPC Advertising', 0, 0, 0, 0, 0, 'Google, Meta, LinkedIn paid campaigns.', '<p>Google, Meta, LinkedIn paid campaigns.</p><p>At LEAMSOFT, our ppc advertising practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'ppc-advertising', 'PPC Advertising', 'PPC Advertising Services | LEAMSOFT', 'Google, Meta, LinkedIn paid campaigns.', 'ppc advertising, leamsoft, it services', 1, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '💰', 1),
(31, 7, 30, 'Social Media Marketing', NULL, NULL, NULL, 'Social Media Marketing', 0, 0, 0, 0, 0, 'Content, community, and growth.', '<p>Content, community, and growth.</p><p>At LEAMSOFT, our social media marketing practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'social-media-marketing', 'Social Media Marketing', 'Social Media Marketing Services | LEAMSOFT', 'Content, community, and growth.', 'social media marketing, leamsoft, it services', 0, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '📱', 2),
(32, 7, 31, 'Content Strategy', NULL, NULL, NULL, 'Content Strategy', 0, 0, 0, 0, 0, 'Editorial planning and execution.', '<p>Editorial planning and execution.</p><p>At LEAMSOFT, our content strategy practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'content-strategy', 'Content Strategy', 'Content Strategy Services | LEAMSOFT', 'Editorial planning and execution.', 'content strategy, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '✍️', 3),
(33, 7, 32, 'Email Marketing', NULL, NULL, NULL, 'Email Marketing', 0, 0, 0, 0, 0, 'Lifecycle and transactional sequences.', '<p>Lifecycle and transactional sequences.</p><p>At LEAMSOFT, our email marketing practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'email-marketing', 'Email Marketing', 'Email Marketing Services | LEAMSOFT', 'Lifecycle and transactional sequences.', 'email marketing, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '✉️', 4),
(34, 7, 33, 'Conversion Optimisation', NULL, NULL, NULL, 'Conversion Optimisation', 0, 0, 0, 0, 0, 'A/B testing and funnel improvements.', '<p>A/B testing and funnel improvements.</p><p>At LEAMSOFT, our conversion optimisation practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'conversion-optimisation', 'Conversion Optimisation', 'Conversion Optimisation Services | LEAMSOFT', 'A/B testing and funnel improvements.', 'conversion optimisation, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🎯', 5),
(35, 8, 34, 'Technology Strategy', NULL, NULL, NULL, 'Technology Strategy', 0, 0, 0, 0, 0, 'Tech roadmaps aligned to your goals.', '<p>Tech roadmaps aligned to your goals.</p><p>At LEAMSOFT, our technology strategy practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'technology-strategy', 'Technology Strategy', 'Technology Strategy Services | LEAMSOFT', 'Tech roadmaps aligned to your goals.', 'technology strategy, leamsoft, it services', 1, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🗺️', 0),
(36, 8, 35, 'Digital Transformation', NULL, NULL, NULL, 'Digital Transformation', 0, 0, 0, 0, 0, 'Modernising legacy systems and processes.', '<p>Modernising legacy systems and processes.</p><p>At LEAMSOFT, our digital transformation practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'digital-transformation', 'Digital Transformation', 'Digital Transformation Services | LEAMSOFT', 'Modernising legacy systems and processes.', 'digital transformation, leamsoft, it services', 1, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🔄', 1),
(37, 8, 36, 'Team Augmentation', NULL, NULL, NULL, 'Team Augmentation', 0, 0, 0, 0, 0, 'Embedded engineers and specialists.', '<p>Embedded engineers and specialists.</p><p>At LEAMSOFT, our team augmentation practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'team-augmentation', 'Team Augmentation', 'Team Augmentation Services | LEAMSOFT', 'Embedded engineers and specialists.', 'team augmentation, leamsoft, it services', 0, 1, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '👥', 2),
(38, 8, 37, 'Architecture Review', NULL, NULL, NULL, 'Architecture Review', 0, 0, 0, 0, 0, 'Independent audits of your stack.', '<p>Independent audits of your stack.</p><p>At LEAMSOFT, our architecture review practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'architecture-review', 'Architecture Review', 'Architecture Review Services | LEAMSOFT', 'Independent audits of your stack.', 'architecture review, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '🏛️', 3),
(39, 8, 38, 'Process Automation', NULL, NULL, NULL, 'Process Automation', 0, 0, 0, 0, 0, 'RPA and intelligent workflow automation.', '<p>RPA and intelligent workflow automation.</p><p>At LEAMSOFT, our process automation practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'process-automation', 'Process Automation', 'Process Automation Services | LEAMSOFT', 'RPA and intelligent workflow automation.', 'process automation, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '⚙️', 4),
(40, 8, 39, 'Data Strategy', NULL, NULL, NULL, 'Data Strategy', 0, 0, 0, 0, 0, 'Data platform and analytics blueprints.', '<p>Data platform and analytics blueprints.</p><p>At LEAMSOFT, our data strategy practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>', 'data-strategy', 'Data Strategy', 'Data Strategy Services | LEAMSOFT', 'Data platform and analytics blueprints.', 'data strategy, leamsoft, it services', 0, 0, 1, 1, '2026-05-24 07:28:40', '2026-05-24 07:28:40', '📊', 5);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Gx0d8Qph7zrgv5fNogFeg6Wwwn5RkOFWUDxHQukA', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoid1lKQ0VEbmk0THpkcmwzY3U1WGQ5MGFObWZKSjdRZEIyMnFvSW5vcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9lbnF1aXJ5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MztzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3Nzk5NDcxMjk7fX0=', 1779947435),
('pXI2gpV9YDnvkk1JlgZR93nQ13DwsqcpP2Eq9ImU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGdtS2VyM3pTSEdyVEE1TEJIRDBLWEVFODFobkVWR2ppYVUwa1hsYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1779941591),
('tZQAVrNteFNSahvDw6tRB4NzICv4nUbMiAa3bqsA', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiTjdPRVV3UHB2endQUHloeGcwS3VoMDZuSWpaZEQ5WnZXQm91b0ZoQyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MztzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3ODA4MjQ0OTc7fX0=', 1780824506),
('uJeJW7ktPgGqdGmSZHHUqzAVquoOAn1hkVKKibEM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM253YVU2bkZXVEFkek5aSU80NlVEY3laN3pmNTFSeEdXSjk0aFIxVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9iYW5uZXIiO319', 1780214542),
('yc9Qc46JzSUPBgcbU504n4EUIzMOjSnBwSQCaNFI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.121.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib0o5Q3Y3dW9VZEk0RllkOHFzYjNrcDZjVTFhM1ZZaWhEbkF3bkFYdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1780824468);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `frontend_color` varchar(255) NOT NULL DEFAULT 'default',
  `logo` varchar(255) DEFAULT NULL,
  `admin_logo` varchar(255) DEFAULT NULL,
  `admin_login_background` varchar(255) DEFAULT NULL,
  `admin_login_sidebar` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `address` varchar(1000) DEFAULT NULL,
  `description` mediumtext NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `facebook` varchar(1000) DEFAULT NULL,
  `instagram` varchar(1000) DEFAULT NULL,
  `linkedin` varchar(1000) DEFAULT NULL,
  `twitter` varchar(1000) DEFAULT NULL,
  `youtube` varchar(1000) DEFAULT NULL,
  `google_plus` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `frontend_color`, `logo`, `admin_logo`, `admin_login_background`, `admin_login_sidebar`, `favicon`, `site_name`, `address`, `description`, `phone`, `email`, `facebook`, `instagram`, `linkedin`, `twitter`, `youtube`, `google_plus`, `created_at`, `updated_at`) VALUES
(1, 'default', 'uploads/logo/TlJjwoyBcAmqNqRNlmL7AGSO0wpAH2uCV5TxDt0L.png', 'uploads/admin_logo/KRYlVHbamu9K4GDQ1icNkk2WsLbymZi9tCZTihHS.png', NULL, NULL, 'uploads/favicon/Sk3IJk1SJ2FMiZxMbPmnfClXhSqoiUfaGktkEY2M.png', 'Leamsoft Pvt. Ltd.', '106 Talla Gathiya, Jyolikot, Nainital, Naini Tal, Uttarakhand, 263127, India', 'Leamsoft', '+91 9217461169', 'info@leamsoft.com', '#', '#', '#', '#', '#', '#', '2026-05-26 07:04:16', '2026-05-26 01:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(100) DEFAULT NULL,
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` int(11) NOT NULL DEFAULT 0,
  `top` int(11) NOT NULL DEFAULT 0,
  `slug` text DEFAULT NULL,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_alt` text DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `uid` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `thumbnail_img` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `cid`, `name`, `banner`, `icon`, `featured`, `top`, `slug`, `short_description`, `description`, `image_alt`, `meta_title`, `meta_description`, `keywords`, `status`, `uid`, `created_at`, `updated_at`, `category_id`, `thumbnail_img`, `sort_order`) VALUES
(4, NULL, 'Web Development', NULL, '🌐', 0, 0, 'web-development', 'Performant, SEO-friendly web platforms.', 'Performant, SEO-friendly web platforms. Our team delivers production-grade web development tailored to your business goals.', NULL, 'Web Development | LEAMSOFT', 'Performant, SEO-friendly web platforms.', 'web development, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 3, NULL, 0),
(5, NULL, 'Mobile App Development', NULL, '📱', 0, 0, 'mobile-app-development', 'Native and cross-platform mobile apps.', 'Native and cross-platform mobile apps. Our team delivers production-grade mobile app development tailored to your business goals.', NULL, 'Mobile App Development | LEAMSOFT', 'Native and cross-platform mobile apps.', 'mobile app development, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 3, NULL, 1),
(6, NULL, 'Enterprise Software', NULL, '🏢', 0, 0, 'enterprise-software', 'ERP, CRM, and bespoke internal tools.', 'ERP, CRM, and bespoke internal tools. Our team delivers production-grade enterprise software tailored to your business goals.', NULL, 'Enterprise Software | LEAMSOFT', 'ERP, CRM, and bespoke internal tools.', 'enterprise software, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 3, NULL, 2),
(7, NULL, 'E-Commerce Platforms', NULL, '🛒', 0, 0, 'e-commerce-platforms', 'Custom storefronts and checkout flows.', 'Custom storefronts and checkout flows. Our team delivers production-grade e-commerce platforms tailored to your business goals.', NULL, 'E-Commerce Platforms | LEAMSOFT', 'Custom storefronts and checkout flows.', 'e-commerce platforms, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 3, NULL, 3),
(8, NULL, 'API Development', NULL, '🔌', 0, 0, 'api-development', 'REST & GraphQL APIs that scale.', 'REST & GraphQL APIs that scale. Our team delivers production-grade api development tailored to your business goals.', NULL, 'API Development | LEAMSOFT', 'REST & GraphQL APIs that scale.', 'api development, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 3, NULL, 4),
(9, NULL, 'SaaS Product Development', NULL, '☁️', 0, 0, 'saas-product-development', 'Multi-tenant SaaS from idea to launch.', 'Multi-tenant SaaS from idea to launch. Our team delivers production-grade saas product development tailored to your business goals.', NULL, 'SaaS Product Development | LEAMSOFT', 'Multi-tenant SaaS from idea to launch.', 'saas product development, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 3, NULL, 5),
(10, NULL, 'Custom AI Models', NULL, '🧠', 0, 0, 'custom-ai-models', 'ML models trained on your data.', 'ML models trained on your data. Our team delivers production-grade custom ai models tailored to your business goals.', NULL, 'Custom AI Models | LEAMSOFT', 'ML models trained on your data.', 'custom ai models, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 4, NULL, 0),
(11, NULL, 'LLM Integration', NULL, '💬', 0, 0, 'llm-integration', 'GPT, Claude, and open-source LLMs.', 'GPT, Claude, and open-source LLMs. Our team delivers production-grade llm integration tailored to your business goals.', NULL, 'LLM Integration | LEAMSOFT', 'GPT, Claude, and open-source LLMs.', 'llm integration, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 4, NULL, 1),
(12, NULL, 'Computer Vision', NULL, '👁️', 0, 0, 'computer-vision', 'Image & video understanding.', 'Image & video understanding. Our team delivers production-grade computer vision tailored to your business goals.', NULL, 'Computer Vision | LEAMSOFT', 'Image & video understanding.', 'computer vision, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 4, NULL, 2),
(13, NULL, 'Predictive Analytics', NULL, '📊', 0, 0, 'predictive-analytics', 'Forecasting and decision intelligence.', 'Forecasting and decision intelligence. Our team delivers production-grade predictive analytics tailored to your business goals.', NULL, 'Predictive Analytics | LEAMSOFT', 'Forecasting and decision intelligence.', 'predictive analytics, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 4, NULL, 3),
(14, NULL, 'NLP Solutions', NULL, '📝', 0, 0, 'nlp-solutions', 'Text classification, extraction, summarisation.', 'Text classification, extraction, summarisation. Our team delivers production-grade nlp solutions tailored to your business goals.', NULL, 'NLP Solutions | LEAMSOFT', 'Text classification, extraction, summarisation.', 'nlp solutions, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 4, NULL, 4),
(15, NULL, 'MLOps & Deployment', NULL, '⚙️', 0, 0, 'mlops-deployment', 'Production AI infrastructure.', 'Production AI infrastructure. Our team delivers production-grade mlops & deployment tailored to your business goals.', NULL, 'MLOps & Deployment | LEAMSOFT', 'Production AI infrastructure.', 'mlops & deployment, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 4, NULL, 5),
(16, NULL, 'Cloud Migration', NULL, '🚀', 0, 0, 'cloud-migration', 'Lift-and-shift to cloud-native moves.', 'Lift-and-shift to cloud-native moves. Our team delivers production-grade cloud migration tailored to your business goals.', NULL, 'Cloud Migration | LEAMSOFT', 'Lift-and-shift to cloud-native moves.', 'cloud migration, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 5, NULL, 0),
(17, NULL, 'Cloud Architecture', NULL, '🏗️', 0, 0, 'cloud-architecture', 'Multi-region, fault-tolerant systems.', 'Multi-region, fault-tolerant systems. Our team delivers production-grade cloud architecture tailored to your business goals.', NULL, 'Cloud Architecture | LEAMSOFT', 'Multi-region, fault-tolerant systems.', 'cloud architecture, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 5, NULL, 1),
(18, NULL, 'DevOps & CI/CD', NULL, '🔄', 0, 0, 'devops-cicd', 'Automated pipelines and infrastructure as code.', 'Automated pipelines and infrastructure as code. Our team delivers production-grade devops & ci/cd tailored to your business goals.', NULL, 'DevOps & CI/CD | LEAMSOFT', 'Automated pipelines and infrastructure as code.', 'devops & ci/cd, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 5, NULL, 2),
(19, NULL, 'Kubernetes & Docker', NULL, '📦', 0, 0, 'kubernetes-docker', 'Containerised production environments.', 'Containerised production environments. Our team delivers production-grade kubernetes & docker tailored to your business goals.', NULL, 'Kubernetes & Docker | LEAMSOFT', 'Containerised production environments.', 'kubernetes & docker, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 5, NULL, 3),
(20, NULL, 'Serverless Solutions', NULL, '⚡', 0, 0, 'serverless-solutions', 'AWS Lambda, Azure Functions, Cloud Run.', 'AWS Lambda, Azure Functions, Cloud Run. Our team delivers production-grade serverless solutions tailored to your business goals.', NULL, 'Serverless Solutions | LEAMSOFT', 'AWS Lambda, Azure Functions, Cloud Run.', 'serverless solutions, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 5, NULL, 4),
(21, NULL, 'Managed Cloud Ops', NULL, '🛠️', 0, 0, 'managed-cloud-ops', '24/7 monitoring and managed services.', '24/7 monitoring and managed services. Our team delivers production-grade managed cloud ops tailored to your business goals.', NULL, 'Managed Cloud Ops | LEAMSOFT', '24/7 monitoring and managed services.', 'managed cloud ops, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 5, NULL, 5),
(22, NULL, 'Penetration Testing', NULL, '🎯', 0, 0, 'penetration-testing', 'Find vulnerabilities before attackers do.', 'Find vulnerabilities before attackers do. Our team delivers production-grade penetration testing tailored to your business goals.', NULL, 'Penetration Testing | LEAMSOFT', 'Find vulnerabilities before attackers do.', 'penetration testing, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 6, NULL, 0),
(23, NULL, 'Vulnerability Assessment', NULL, '🔍', 0, 0, 'vulnerability-assessment', 'Continuous scanning and reporting.', 'Continuous scanning and reporting. Our team delivers production-grade vulnerability assessment tailored to your business goals.', NULL, 'Vulnerability Assessment | LEAMSOFT', 'Continuous scanning and reporting.', 'vulnerability assessment, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 6, NULL, 1),
(24, NULL, 'Compliance & Audit', NULL, '📋', 0, 0, 'compliance-audit', 'ISO 27001, SOC2, GDPR readiness.', 'ISO 27001, SOC2, GDPR readiness. Our team delivers production-grade compliance & audit tailored to your business goals.', NULL, 'Compliance & Audit | LEAMSOFT', 'ISO 27001, SOC2, GDPR readiness.', 'compliance & audit, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 6, NULL, 2),
(25, NULL, 'Incident Response', NULL, '⚠️', 0, 0, 'incident-response', 'Rapid response and post-mortem.', 'Rapid response and post-mortem. Our team delivers production-grade incident response tailored to your business goals.', NULL, 'Incident Response | LEAMSOFT', 'Rapid response and post-mortem.', 'incident response, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 6, NULL, 3),
(26, NULL, 'Data Protection', NULL, '🔐', 0, 0, 'data-protection', 'Encryption, DLP, and privacy controls.', 'Encryption, DLP, and privacy controls. Our team delivers production-grade data protection tailored to your business goals.', NULL, 'Data Protection | LEAMSOFT', 'Encryption, DLP, and privacy controls.', 'data protection, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 6, NULL, 4),
(27, NULL, 'Security Operations', NULL, '👮', 0, 0, 'security-operations', 'SOC, SIEM, and threat monitoring.', 'SOC, SIEM, and threat monitoring. Our team delivers production-grade security operations tailored to your business goals.', NULL, 'Security Operations | LEAMSOFT', 'SOC, SIEM, and threat monitoring.', 'security operations, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 6, NULL, 5),
(28, NULL, 'SEO Services', NULL, '🔍', 0, 0, 'seo-services', 'Technical SEO and content optimisation.', 'Technical SEO and content optimisation. Our team delivers production-grade seo services tailored to your business goals.', NULL, 'SEO Services | LEAMSOFT', 'Technical SEO and content optimisation.', 'seo services, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 7, NULL, 0),
(29, NULL, 'PPC Advertising', NULL, '💰', 0, 0, 'ppc-advertising', 'Google, Meta, LinkedIn paid campaigns.', 'Google, Meta, LinkedIn paid campaigns. Our team delivers production-grade ppc advertising tailored to your business goals.', NULL, 'PPC Advertising | LEAMSOFT', 'Google, Meta, LinkedIn paid campaigns.', 'ppc advertising, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 7, NULL, 1),
(30, NULL, 'Social Media Marketing', NULL, '📱', 0, 0, 'social-media-marketing', 'Content, community, and growth.', 'Content, community, and growth. Our team delivers production-grade social media marketing tailored to your business goals.', NULL, 'Social Media Marketing | LEAMSOFT', 'Content, community, and growth.', 'social media marketing, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 7, NULL, 2),
(31, NULL, 'Content Strategy', NULL, '✍️', 0, 0, 'content-strategy', 'Editorial planning and execution.', 'Editorial planning and execution. Our team delivers production-grade content strategy tailored to your business goals.', NULL, 'Content Strategy | LEAMSOFT', 'Editorial planning and execution.', 'content strategy, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 7, NULL, 3),
(32, NULL, 'Email Marketing', NULL, '✉️', 0, 0, 'email-marketing', 'Lifecycle and transactional sequences.', 'Lifecycle and transactional sequences. Our team delivers production-grade email marketing tailored to your business goals.', NULL, 'Email Marketing | LEAMSOFT', 'Lifecycle and transactional sequences.', 'email marketing, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 7, NULL, 4),
(33, NULL, 'Conversion Optimisation', NULL, '🎯', 0, 0, 'conversion-optimisation', 'A/B testing and funnel improvements.', 'A/B testing and funnel improvements. Our team delivers production-grade conversion optimisation tailored to your business goals.', NULL, 'Conversion Optimisation | LEAMSOFT', 'A/B testing and funnel improvements.', 'conversion optimisation, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 7, NULL, 5),
(34, NULL, 'Technology Strategy', NULL, '🗺️', 0, 0, 'technology-strategy', 'Tech roadmaps aligned to your goals.', 'Tech roadmaps aligned to your goals. Our team delivers production-grade technology strategy tailored to your business goals.', NULL, 'Technology Strategy | LEAMSOFT', 'Tech roadmaps aligned to your goals.', 'technology strategy, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 8, NULL, 0),
(35, NULL, 'Digital Transformation', NULL, '🔄', 0, 0, 'digital-transformation', 'Modernising legacy systems and processes.', 'Modernising legacy systems and processes. Our team delivers production-grade digital transformation tailored to your business goals.', NULL, 'Digital Transformation | LEAMSOFT', 'Modernising legacy systems and processes.', 'digital transformation, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 8, NULL, 1),
(36, NULL, 'Team Augmentation', NULL, '👥', 0, 0, 'team-augmentation', 'Embedded engineers and specialists.', 'Embedded engineers and specialists. Our team delivers production-grade team augmentation tailored to your business goals.', NULL, 'Team Augmentation | LEAMSOFT', 'Embedded engineers and specialists.', 'team augmentation, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 8, NULL, 2),
(37, NULL, 'Architecture Review', NULL, '🏛️', 0, 0, 'architecture-review', 'Independent audits of your stack.', 'Independent audits of your stack. Our team delivers production-grade architecture review tailored to your business goals.', NULL, 'Architecture Review | LEAMSOFT', 'Independent audits of your stack.', 'architecture review, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 8, NULL, 3),
(38, NULL, 'Process Automation', NULL, '⚙️', 0, 0, 'process-automation', 'RPA and intelligent workflow automation.', 'RPA and intelligent workflow automation. Our team delivers production-grade process automation tailored to your business goals.', NULL, 'Process Automation | LEAMSOFT', 'RPA and intelligent workflow automation.', 'process automation, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 8, NULL, 4),
(39, NULL, 'Data Strategy', NULL, '📊', 0, 0, 'data-strategy', 'Data platform and analytics blueprints.', 'Data platform and analytics blueprints. Our team delivers production-grade data strategy tailored to your business goals.', NULL, 'Data Strategy | LEAMSOFT', 'Data platform and analytics blueprints.', 'data strategy, leamsoft', 1, NULL, '2026-05-24 07:28:40', '2026-05-24 07:28:40', 8, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `uid` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `designation`, `phone`, `status`, `uid`, `created_at`, `updated_at`) VALUES
(3, 'Aditya Sahgal', 'adityasahagal399@gmail.com', NULL, '$2y$12$Syd2LhltSC3DxCZmTeUGXOlvQ6HstYZAD3cln7utEl5GoFRVHZRdq', 'UzBxXthdBt7g5GfQS0wcYOKfAm6JL30YeDEZVSKTFzjZnlL80O9kEBxTvbpW', 'Full Stack Developer', '07895481169', 1, 1, '2024-07-28 12:33:59', '2026-05-27 09:39:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_category_id_status_index` (`category_id`,`status`),
  ADD KEY `services_subcategory_id_status_index` (`subcategory_id`,`status`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
