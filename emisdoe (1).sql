-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2021 at 02:24 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emisdoe`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_qualifications`
--

CREATE TABLE `academic_qualifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qualification_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prerequisite_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_qualifications`
--

INSERT INTO `academic_qualifications` (`id`, `qualification_name`, `prerequisite_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'SECONDARY SCHOOL CERTIFICATE (SSC)', NULL, NULL, '2021-03-26 16:17:13', NULL),
(2, 'F.SC PRE-ENGINEERING', 1, NULL, '2021-03-26 16:17:13', NULL),
(3, 'F.SC PRE-MEDICAL', 1, NULL, '2021-03-30 05:45:59', NULL),
(4, 'I.COM', 1, NULL, '2021-03-26 16:17:13', NULL),
(5, 'D.COM', 1, NULL, '2021-03-30 05:45:59', NULL),
(6, 'MD-CAT', 3, NULL, '2021-03-26 16:17:13', NULL),
(7, 'E-CAT', 2, NULL, '2021-03-30 05:45:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_category_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `course_category_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'MBBS', 1, NULL, '2021-03-26 11:17:13', NULL),
(2, 'BDS', 1, NULL, '2021-03-26 11:17:13', NULL),
(3, 'CIVIL ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(4, 'CHEMICAL ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(5, 'MECHANICAL ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(6, 'SOFTWARE ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(7, 'BS COMPUTER SCIENCE', 3, NULL, '2021-03-26 11:17:13', NULL),
(8, 'BS PHYSICS', 3, NULL, '2021-03-26 11:17:13', NULL),
(9, 'BS CHEMISTRY', 3, NULL, '2021-03-26 11:17:13', NULL),
(10, 'BS BIO CHEMISTRY', 3, NULL, '2021-03-26 11:17:13', NULL),
(11, 'BS BIO INFORMATICS', 3, NULL, '2021-03-26 11:17:13', NULL),
(12, 'BS CIVIL TECHNOLOGY', 3, NULL, '2021-03-26 11:17:13', NULL),
(13, 'BS MECHANICAL TECHNOLOGY', 3, NULL, '2021-03-26 11:17:13', NULL),
(14, 'MECHATRONICS ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(15, 'ARCHITECHTURE ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(16, 'ELECTRONICS ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(17, 'METALLURGY ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(18, 'INDUSTRIAL ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(19, 'COMPUTER ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(20, 'GEOLOGY ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(21, 'TELECOM ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(22, 'POLYMER ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(23, 'CITY AND REGIONAL PLANNING ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(24, 'PETROLEUM AND GAS ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(25, 'ENVIRONMENTAL ENGINEERING', 2, NULL, '2021-03-26 11:17:13', NULL),
(26, 'DOCTOR OF VETERINARY MEDICINE', 3, NULL, '2021-03-26 11:17:13', NULL),
(27, 'DOCTOR OF PHARMACY', 3, NULL, '2021-03-26 11:17:13', NULL),
(28, 'DOCTOR OF PHYSIOTHERAPY', 3, NULL, '2021-03-26 11:17:13', NULL),
(29, 'BS BOTANY', 3, NULL, '2021-03-26 11:17:13', NULL),
(30, 'BS ARABIC', 3, NULL, '2021-03-26 11:17:13', NULL),
(31, 'BS GEOGRAPHY', 3, NULL, '2021-03-26 11:17:13', NULL),
(32, 'BS MATHEMATICS', 3, NULL, '2021-03-26 11:17:13', NULL),
(33, 'BS STATISTICS', 3, NULL, '2021-03-26 11:17:13', NULL),
(34, 'BS ECONOMICS', 3, NULL, '2021-03-26 11:17:13', NULL),
(35, 'BS EDUCATION', 3, NULL, '2021-03-26 11:17:13', NULL),
(36, 'BS SOCIOLOGY', 3, NULL, '2021-03-26 11:17:13', NULL),
(37, 'BS URDU', 3, NULL, '2021-03-26 11:17:13', NULL),
(38, 'BS PERSIAN', 3, NULL, '2021-03-26 11:17:13', NULL),
(39, 'BS INFORMATION MANAGEMENT', 3, NULL, '2021-03-26 11:17:13', NULL),
(40, 'BS INFORMATION TECHNOLOGY', 3, NULL, '2021-03-26 11:17:13', NULL),
(41, 'BS ENGLISH', 3, NULL, '2021-03-26 11:17:13', NULL),
(42, 'BS POLITICAL SCIENCE', 3, NULL, '2021-03-26 11:17:13', NULL),
(43, 'BS GEOLOGY', 3, NULL, '2021-03-26 11:17:13', NULL),
(44, 'BS PSYCHOLOGY', 3, NULL, '2021-03-26 11:17:13', NULL),
(45, 'BACHELORS OF BUSINESS ADMINISTRATION', 3, NULL, '2021-03-26 11:17:13', NULL),
(46, 'BS COMMERCE', 3, NULL, '2021-03-26 11:17:13', NULL),
(47, 'BS FASHION DESIGNING', 3, NULL, '2021-03-26 11:17:13', NULL),
(48, 'BS HOME ECONOMICS', 3, NULL, '2021-03-26 11:17:13', NULL),
(49, 'BS FOOD SCIENCE AND TECHNOLOGY', 3, NULL, '2021-03-26 11:17:13', NULL),
(50, 'BS HUMAN NUTRITION AND DIETETICS', 3, NULL, '2021-03-26 11:17:13', NULL),
(51, 'BS ISLAMIC STUDIES', 3, NULL, '2021-03-26 11:17:13', NULL),
(52, 'BACHELORS OF PUBLIC ADMINISTRATION', 3, NULL, '2021-03-26 11:17:13', NULL),
(53, 'BS ZOOLOGY', 3, NULL, '2021-03-26 11:17:13', NULL),
(54, 'BS AGRICULTURE AND RESOURCE ECONOMICS', 3, NULL, '2021-03-26 11:17:13', NULL),
(55, 'BS FOOD SCIENCE AND TECHNOLOGY', 3, NULL, '2021-03-26 11:17:13', NULL),
(56, 'BS ENVIRONMENTAL SCIENCE', 3, NULL, '2021-03-26 11:17:13', NULL),
(57, 'BS DAIRY SCIENCES', 3, NULL, '2021-03-26 11:17:13', NULL),
(58, 'BS MICROBIOLOGY', 3, NULL, '2021-03-26 11:17:13', NULL),
(59, 'BACHELORS IN LAW', 3, NULL, '2021-03-26 11:17:13', NULL),
(60, 'BS INTERNATIONAL RELATIONS', 3, NULL, '2021-03-26 11:17:13', NULL),
(61, 'BS ALLIED HEALTH SCIENCE', 3, NULL, '2021-03-26 11:17:13', NULL),
(62, 'BS FINE ARTS', 3, NULL, '2021-03-26 11:17:13', NULL),
(63, 'BS INTERIOR DESIGN', 3, NULL, '2021-03-26 11:17:13', NULL),
(64, 'BS MASS COMMUNICATION', 3, NULL, '2021-03-26 11:17:13', NULL),
(65, 'BS HISTORY', 3, NULL, '2021-03-26 11:17:13', NULL),
(66, 'BS SOCIAL WORK', 3, NULL, '2021-03-26 11:17:13', NULL),
(67, 'BBA BANKING AND FINANCE', 3, NULL, '2021-03-26 11:17:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_categories`
--

CREATE TABLE `course_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count_hafizequaran_marks` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_categories`
--

INSERT INTO `course_categories` (`id`, `category_name`, `count_hafizequaran_marks`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'MEDICAL', 1, NULL, '2021-03-26 11:17:13', NULL),
(2, 'ENGINEERING', 1, NULL, '2021-03-26 11:17:13', NULL),
(3, 'GENERAL', 0, NULL, '2021-03-26 11:17:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_district_quota_distributions`
--

CREATE TABLE `course_district_quota_distributions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `total_district_seats` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_district_quota_distributions`
--

INSERT INTO `course_district_quota_distributions` (`id`, `course_id`, `district_id`, `total_district_seats`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 6, NULL, '2021-03-26 11:17:13', NULL),
(2, 1, 8, 7, NULL, '2021-03-26 11:17:13', NULL),
(3, 1, 1, 7, NULL, '2021-03-26 11:17:13', NULL),
(4, 1, 3, 4, NULL, '2021-03-26 11:17:13', NULL),
(5, 1, 7, 6, NULL, '2021-03-26 11:17:13', NULL),
(6, 1, 4, 2, NULL, '2021-03-26 11:17:13', NULL),
(7, 1, 5, 3, NULL, '2021-03-26 11:17:13', NULL),
(8, 1, 6, 4, NULL, '2021-03-26 11:17:13', NULL),
(9, 1, 12, 2, NULL, '2021-03-26 11:17:13', NULL),
(10, 1, 13, 2, NULL, '2021-03-26 11:17:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_open_seats_distributions`
--

CREATE TABLE `course_open_seats_distributions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `total_open_seats` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_open_seats_distributions`
--

INSERT INTO `course_open_seats_distributions` (`id`, `course_id`, `total_open_seats`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 1, 37, NULL, '2021-03-26 11:17:13', NULL),
(3, 2, 5, NULL, '2021-03-26 11:17:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_prerequisites`
--

CREATE TABLE `course_prerequisites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `prerequisite_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `district_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `district_name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'GILGIT', NULL, '2021-03-26 11:19:48', NULL),
(2, 'GHIZER', NULL, '2021-03-26 11:19:48', NULL),
(3, 'ASTORE', NULL, '2021-03-26 11:19:48', NULL),
(4, 'HUNZA', NULL, '2021-03-26 11:19:48', NULL),
(5, 'NAGAR', NULL, '2021-03-26 11:19:48', NULL),
(6, 'GHANCHE', NULL, '2021-03-26 11:19:48', NULL),
(7, 'SKARDU', NULL, '2021-03-26 11:19:48', NULL),
(8, 'DIAMER', NULL, '2021-03-26 11:19:48', NULL),
(9, 'YASIN', NULL, '2021-03-26 11:19:48', NULL),
(10, 'DAREL', NULL, '2021-03-26 11:19:48', NULL),
(11, 'TANGIR', NULL, '2021-03-26 11:19:48', NULL),
(12, 'SHIGAR', NULL, '2021-03-26 11:19:48', NULL),
(13, 'KHARMANG', NULL, '2021-03-26 11:19:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_03_26_104113_create_course_categories_table', 1),
(5, '2021_03_26_104359_create_courses_table', 1),
(6, '2021_03_26_104441_create_districts_table', 1),
(7, '2021_03_26_104532_create_students_table', 2),
(8, '2021_03_26_104627_create_universities_table', 2),
(9, '2021_03_26_104701_create_course_district_quota_distribution_table', 2),
(10, '2021_03_26_104825_create_course_open_seats_distribution_table', 2),
(11, '2021_03_26_104923_create_student_university_courses_priorities_table', 2),
(12, '2021_03_26_104955_create_university_course_seats_table', 2),
(13, '2021_03_29_165724_create_provinces_criteria_table', 3),
(14, '2021_03_30_042813_create_academic_qualifications_table', 4),
(15, '2021_03_30_043119_create_student_academic_qualifications_table', 4),
(16, '2021_03_30_043151_create_course_prerequisites_table', 4),
(17, '2021_03_30_050658_create_provinces_table', 5),
(19, '2021_03_30_061527_create_provinces_cc_pre_qualifications', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `province_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `province_name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'PUNJAB', NULL, NULL, '2021-03-30 13:51:56'),
(2, 'KHYBER PAKHTOON KHA (KPK', NULL, NULL, NULL),
(3, 'SINDH', NULL, NULL, NULL),
(4, 'BALOCHISTAN', NULL, NULL, NULL),
(5, 'ALL PAKISTAN', NULL, NULL, NULL),
(6, 'AZAD JAMMU AND KASHMIR (AJK)', NULL, NULL, NULL),
(7, 'random province 1', '2021-03-30 14:16:46', NULL, '2021-03-30 14:16:46'),
(8, 'random province 2', '2021-03-30 14:16:40', NULL, '2021-03-30 14:16:40'),
(9, 'random province 1', '2021-03-30 14:16:33', NULL, '2021-03-30 14:16:33'),
(10, 'random province 2', '2021-03-30 14:13:35', NULL, '2021-03-30 14:13:35');

-- --------------------------------------------------------

--
-- Table structure for table `provinces_cc_pre_qualifications`
--

CREATE TABLE `provinces_cc_pre_qualifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `province_id` bigint(20) UNSIGNED NOT NULL,
  `course_category_id` bigint(20) UNSIGNED NOT NULL,
  `qualification_id` bigint(20) UNSIGNED NOT NULL,
  `division_percentage` double(12,2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinces_cc_pre_qualifications`
--

INSERT INTO `provinces_cc_pre_qualifications` (`id`, `province_id`, `course_category_id`, `qualification_id`, `division_percentage`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 1, 0.00, NULL, '2021-03-26 16:17:13', NULL),
(2, 5, 1, 3, 50.00, NULL, '2021-03-30 05:45:59', NULL),
(3, 5, 1, 6, 50.00, NULL, '2021-03-26 16:20:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` int(11) NOT NULL DEFAULT 0,
  `aggregate` double(12,5) NOT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_name`, `gender`, `aggregate`, `district_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'MOHAMMAD TAYYAB LATIF', 1, 96.54550, 1, NULL, '2021-03-26 11:17:13', NULL),
(2, 'SYEDA UZMA', 2, 94.31820, 7, NULL, '2021-03-26 11:17:13', NULL),
(3, 'ALISHA RIAZ', 2, 93.88640, 2, NULL, '2021-03-26 11:17:13', NULL),
(4, 'MUHAYYA FAIZULLAH', 2, 93.47730, 6, NULL, '2021-03-26 11:17:13', NULL),
(5, 'ZAIN TARIQ', 1, 93.25000, 2, NULL, '2021-03-26 11:17:13', NULL),
(6, 'MURTAZA ALI', 1, 92.50000, 7, NULL, '2021-03-26 11:17:13', NULL),
(7, 'FOUZIA BATOOL', 2, 92.45450, 3, NULL, '2021-03-26 11:17:13', NULL),
(8, 'RIAZ HUSSAIN', 1, 92.06820, 7, NULL, '2021-03-26 11:17:13', NULL),
(9, 'AMNA BATOOL', 2, 91.79550, 3, NULL, '2021-03-26 11:17:13', NULL),
(10, 'RUBINA ZAHRA', 2, 91.00000, 7, NULL, '2021-03-26 11:17:13', NULL),
(11, 'SYED MUSAWIR HUSSAIN', 1, 90.95450, 1, NULL, '2021-03-26 11:17:13', NULL),
(12, 'MEHRANI MAYOON SHAH', 2, 90.81820, 2, NULL, '2021-03-26 11:17:13', NULL),
(13, 'MOHAMMAD KAZIM SHAHBAZ', 1, 90.77270, 3, NULL, '2021-03-26 11:17:13', NULL),
(14, 'ALI HAIDER MUHAMMADI', 1, 91.27270, 7, NULL, '2021-03-26 11:17:13', NULL),
(15, 'ANOSHA ALI', 2, 90.56820, 1, NULL, '2021-03-26 11:17:13', NULL),
(16, 'SYED ALI SIRAJ', 1, 90.52270, 1, NULL, '2021-03-26 11:17:13', NULL),
(17, 'WAZIR MALIK ASHTAR', 1, 90.47730, 7, NULL, '2021-03-26 11:17:13', NULL),
(18, 'MUHADDISA', 2, 90.40910, 7, NULL, '2021-03-26 11:17:13', NULL),
(19, 'AQEEL MUHAMMAD', 1, 90.40910, 7, NULL, '2021-03-26 11:17:13', NULL),
(20, 'INSHIRAH SHAUKAT', 2, 90.38640, 1, NULL, '2021-03-26 11:17:13', NULL),
(21, 'MASOOD ELAHI', 1, 90.38640, 6, NULL, '2021-03-26 11:17:13', NULL),
(22, 'SHAHER BANO', 2, 90.18180, 13, NULL, '2021-03-26 11:17:13', NULL),
(23, 'NOOR FATIMA', 2, 90.13640, 6, NULL, '2021-03-26 11:17:13', NULL),
(24, 'RASHIDA AQEEL', 2, 90.13640, 7, NULL, '2021-03-26 11:17:13', NULL),
(25, 'SABA ALI', 2, 89.93180, 1, NULL, '2021-03-26 11:17:13', NULL),
(26, 'MOHAMMAD AQEEL', 1, 89.90910, 7, NULL, '2021-03-26 11:17:13', NULL),
(27, 'ZAHEER ABBAS', 1, 89.90910, 7, NULL, '2021-03-26 11:17:13', NULL),
(28, 'MUSKAN ALI', 2, 89.72730, 6, NULL, '2021-03-26 11:17:13', NULL),
(29, 'WAZIR LUCKY ALI', 1, 89.72730, 7, NULL, '2021-03-26 11:17:13', NULL),
(30, 'SABIR ALI', 1, 89.43180, 5, NULL, '2021-03-26 11:17:13', NULL),
(31, 'ABDUL MOHEMIN MAUTASIM', 1, 89.29550, 8, NULL, '2021-03-26 11:17:13', NULL),
(32, 'NASIRA BATOOL', 2, 89.27270, 7, NULL, '2021-03-26 11:17:13', NULL),
(33, 'HUSSAM-UD-DIN', 1, 89.22730, 3, NULL, '2021-03-26 11:17:13', NULL),
(34, 'ZEEJAH HAIDER', 1, 89.18180, 7, NULL, '2021-03-26 11:17:13', NULL),
(35, 'AIMAN ZEHRA', 2, 89.13640, 7, NULL, '2021-03-26 11:17:13', NULL),
(36, 'MOHAMMAD UMER', 1, 89.11360, 1, NULL, '2021-03-26 11:17:13', NULL),
(37, 'SYED AGHA ALI', 1, 89.06820, 7, NULL, '2021-03-26 11:17:13', NULL),
(38, 'NAILA ZAHRA', 2, 89.04550, 7, NULL, '2021-03-26 11:17:13', NULL),
(39, 'SABA MARYAM', 2, 88.84090, 7, NULL, '2021-03-26 11:17:13', NULL),
(40, 'FARHEEN ZAHRA', 2, 88.59090, 1, NULL, '2021-03-26 11:17:13', NULL),
(41, 'NOOR UL AIN IBRAHIM', 2, 88.59090, 6, NULL, '2021-03-26 11:17:13', NULL),
(42, 'TAHIR HUSSAIN', 1, 88.47730, 3, NULL, '2021-03-26 11:17:13', NULL),
(43, 'MALAIKA AHMAD', 2, 88.38640, 1, NULL, '2021-03-26 11:17:13', NULL),
(44, 'MUNIR ABBAS', 1, 88.36360, 6, NULL, '2021-03-26 11:17:13', NULL),
(45, 'SADIQ ALI', 1, 88.31820, 12, NULL, '2021-03-26 11:17:13', NULL),
(46, 'SAYAL ZAMRUD', 2, 88.29550, 2, NULL, '2021-03-26 11:17:13', NULL),
(47, 'HAFIZ ASIF ALI', 1, 88.29550, 7, NULL, '2021-03-26 11:17:13', NULL),
(48, 'ZEESHAN AKBER', 1, 88.27270, 7, NULL, '2021-03-26 11:17:13', NULL),
(49, 'SOHALLA BATOOL', 2, 88.25000, 5, NULL, '2021-03-26 11:17:13', NULL),
(50, 'SHEHRYAR HUSSAIN', 1, 88.25000, 13, NULL, '2021-03-26 11:17:13', NULL),
(51, 'AJAZULLAH', 1, 88.20450, 8, NULL, '2021-03-26 11:17:13', NULL),
(52, 'ELLYA', 2, 88.15910, 1, NULL, '2021-03-26 11:17:13', NULL),
(53, 'MUHAMMAD MUNTAZIR', 1, 88.04550, 7, NULL, '2021-03-26 11:17:13', NULL),
(54, 'MOHSIN ALI KHAN', 1, 88.04550, 2, NULL, '2021-03-26 11:17:13', NULL),
(55, 'KANEEZ FATIMA', 2, 88.00000, 13, NULL, '2021-03-26 11:17:13', NULL),
(56, 'ANIQA HAYAT', 2, 87.86360, 2, NULL, '2021-03-26 11:17:13', NULL),
(57, 'ZAFAR ABBAS', 1, 87.84090, 7, NULL, '2021-03-26 11:17:13', NULL),
(58, 'SYEDA EMAAN KAZMI', 2, 87.79550, 7, NULL, '2021-03-26 11:17:13', NULL),
(59, 'AYESHA ASAD', 2, 87.75000, 6, NULL, '2021-03-26 11:17:13', NULL),
(60, 'HINA BATOOL', 2, 87.75000, 5, NULL, '2021-03-26 11:17:13', NULL),
(61, 'JAWAD ULLAH', 1, 87.72730, 8, NULL, '2021-03-26 11:17:13', NULL),
(62, 'QANDEEL REHMAT', 2, 87.70450, 2, NULL, '2021-03-26 11:17:13', NULL),
(63, 'SHAKILA PARVEEN', 2, 87.65910, 6, NULL, '2021-03-26 11:17:13', NULL),
(64, 'KONAIN FATIMA', 2, 87.63640, 3, NULL, '2021-03-26 11:17:13', NULL),
(65, 'UROOJ FATIMA', 2, 87.61360, 12, NULL, '2021-03-26 11:17:13', NULL),
(66, 'AHTISHAMUL HAQ', 1, 87.56820, 3, NULL, '2021-03-26 11:17:13', NULL),
(67, 'BUSHRA TAZIN', 2, 87.47730, 2, NULL, '2021-03-26 11:17:13', NULL),
(68, 'HINA ZAHRA', 2, 87.45450, 7, NULL, '2021-03-26 11:17:13', NULL),
(69, 'QAREENA SHAHID', 2, 87.43180, 1, NULL, '2021-03-26 11:17:13', NULL),
(70, 'SANA ZAHRA', 2, 87.34090, 1, NULL, '2021-03-26 11:17:13', NULL),
(71, 'SABIRA ERAM', 2, 87.34090, 13, NULL, '2021-03-26 11:17:13', NULL),
(72, 'NAHIDA', 2, 87.34090, 7, NULL, '2021-03-26 11:17:13', NULL),
(73, 'NIGHAT BATOOL', 2, 87.31820, 1, NULL, '2021-03-26 11:17:13', NULL),
(74, 'AHMAD RAZA', 1, 87.31820, 7, NULL, '2021-03-26 11:17:13', NULL),
(75, 'MALIKA BATOOL', 2, 87.29550, 13, NULL, '2021-03-26 11:17:13', NULL),
(76, 'MAHEEN ZEHRA', 2, 87.27270, 5, NULL, '2021-03-26 11:17:13', NULL),
(77, 'MISBA KHAN', 2, 87.23730, 1, NULL, '2021-03-26 11:17:13', NULL),
(78, 'ABIDA RAFI', 2, 87.15910, 2, NULL, '2021-03-26 11:17:13', NULL),
(79, 'KAMRAN KHAN', 1, 86.61360, 8, NULL, '2021-03-26 11:17:13', NULL),
(80, 'MUHAMMAD IZHAR UL HAQ', 1, 86.61360, 3, NULL, '2021-03-26 11:17:13', NULL),
(81, 'FARYAL', 2, 86.09090, 4, NULL, '2021-03-26 11:17:13', NULL),
(82, 'MALAIKA SHER ALI', 2, 85.75000, 4, NULL, '2021-03-26 11:17:13', NULL),
(83, 'IDREES AHMAD KHAN', 1, 85.63640, 8, NULL, '2021-03-26 11:17:13', NULL),
(84, 'UMAR FAROOQ', 1, 85.00000, 8, NULL, '2021-03-26 11:17:13', NULL),
(85, 'ATHAR MEHMOOD', 1, 84.97730, 8, NULL, '2021-03-26 11:17:13', NULL),
(86, 'ATTAULLAH', 1, 84.50000, 8, NULL, '2021-03-26 11:17:13', NULL),
(87, 'AQEEL ABBAS', 1, 84.06820, 13, NULL, '2021-03-26 11:17:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_academic_qualifications`
--

CREATE TABLE `student_academic_qualifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `qualification_id` bigint(20) UNSIGNED NOT NULL,
  `total_marks` double(12,2) NOT NULL,
  `obtained_marks` double(12,2) NOT NULL,
  `is_hafizequran` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_university_courses_priorities`
--

CREATE TABLE `student_university_courses_priorities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `university_id` bigint(20) UNSIGNED NOT NULL,
  `priority` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_university_courses_priorities`
--

INSERT INTO `student_university_courses_priorities` (`id`, `student_id`, `course_id`, `university_id`, `priority`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(2, 1, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(3, 1, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(4, 1, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(5, 1, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(6, 1, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(7, 1, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(8, 1, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(9, 1, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(10, 1, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(11, 2, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(12, 2, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(13, 2, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(14, 2, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(15, 2, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(16, 2, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(17, 2, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(18, 2, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(19, 2, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(20, 2, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(21, 3, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(22, 3, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(23, 3, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(24, 3, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(25, 3, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(26, 3, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(27, 3, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(28, 3, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(29, 3, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(30, 3, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(31, 4, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(32, 4, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(33, 4, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(34, 4, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(35, 4, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(36, 4, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(37, 4, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(38, 4, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(39, 4, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(40, 4, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(41, 5, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(42, 5, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(43, 5, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(44, 5, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(45, 5, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(46, 5, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(47, 5, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(48, 5, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(49, 5, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(50, 5, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(51, 6, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(52, 6, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(53, 6, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(54, 6, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(55, 6, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(56, 6, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(57, 6, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(58, 6, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(59, 6, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(60, 6, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(61, 7, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(62, 7, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(63, 7, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(64, 7, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(65, 7, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(66, 7, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(67, 7, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(68, 7, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(69, 7, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(70, 7, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(71, 1, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(72, 1, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(73, 8, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(74, 8, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(75, 8, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(76, 8, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(77, 8, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(78, 8, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(79, 8, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(80, 8, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(81, 9, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(82, 9, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(83, 9, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(84, 9, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(85, 9, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(86, 9, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(87, 9, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(88, 9, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(89, 9, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(90, 9, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(91, 10, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(92, 10, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(93, 10, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(94, 10, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(95, 10, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(96, 10, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(97, 10, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(98, 10, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(99, 10, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(100, 10, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(101, 11, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(102, 11, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(103, 11, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(104, 11, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(105, 11, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(106, 11, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(107, 11, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(108, 11, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(109, 11, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(110, 11, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(111, 12, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(112, 12, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(113, 12, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(114, 12, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(115, 12, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(116, 12, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(117, 12, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(118, 12, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(119, 12, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(120, 12, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(121, 13, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(122, 13, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(123, 13, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(124, 13, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(125, 13, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(126, 13, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(127, 13, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(128, 13, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(129, 13, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(130, 13, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(131, 14, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(132, 14, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(133, 14, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(134, 14, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(135, 14, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(136, 14, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(137, 14, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(138, 14, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(139, 14, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(140, 14, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(141, 15, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(142, 15, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(143, 15, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(144, 15, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(145, 15, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(146, 15, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(147, 15, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(148, 15, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(149, 15, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(150, 15, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(151, 16, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(152, 16, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(153, 16, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(154, 16, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(155, 16, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(156, 16, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(157, 16, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(158, 16, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(159, 16, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(160, 16, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(161, 17, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(162, 17, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(163, 17, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(164, 17, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(165, 17, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(166, 17, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(167, 17, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(168, 17, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(169, 17, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(170, 17, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(171, 18, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(172, 18, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(173, 18, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(174, 18, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(175, 18, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(176, 18, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(177, 18, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(178, 18, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(179, 18, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(180, 18, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(181, 19, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(182, 19, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(183, 19, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(184, 19, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(185, 19, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(186, 19, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(187, 19, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(188, 19, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(189, 19, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(190, 19, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(191, 20, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(192, 20, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(193, 20, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(194, 20, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(195, 20, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(196, 20, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(197, 20, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(198, 20, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(199, 20, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(200, 20, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(201, 21, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(202, 21, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(203, 21, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(204, 21, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(205, 21, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(206, 21, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(207, 21, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(208, 21, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(209, 21, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(210, 21, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(211, 22, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(212, 22, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(213, 22, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(214, 22, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(215, 22, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(216, 22, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(217, 22, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(218, 22, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(219, 22, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(220, 22, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(221, 23, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(222, 23, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(223, 23, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(224, 23, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(225, 23, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(226, 23, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(227, 23, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(228, 23, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(229, 23, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(230, 23, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(231, 24, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(232, 24, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(233, 24, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(234, 24, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(235, 24, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(236, 24, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(237, 24, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(238, 24, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(239, 24, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(240, 24, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(241, 25, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(242, 25, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(243, 25, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(244, 25, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(245, 25, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(246, 25, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(247, 25, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(248, 25, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(249, 25, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(250, 25, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(251, 26, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(252, 26, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(253, 26, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(254, 26, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(255, 26, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(256, 26, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(257, 26, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(258, 26, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(259, 26, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(260, 26, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(261, 27, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(262, 27, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(263, 27, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(264, 27, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(265, 27, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(266, 27, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(267, 27, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(268, 27, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(269, 27, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(270, 27, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(271, 28, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(272, 28, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(273, 28, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(274, 28, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(275, 28, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(276, 28, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(277, 28, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(278, 28, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(279, 28, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(280, 28, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(281, 29, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(282, 29, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(283, 29, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(284, 29, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(285, 29, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(286, 29, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(287, 29, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(288, 29, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(289, 29, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(290, 29, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(291, 30, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(292, 30, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(293, 30, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(294, 30, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(295, 30, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(296, 30, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(297, 30, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(298, 30, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(299, 30, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(300, 30, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(301, 31, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(302, 31, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(303, 31, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(304, 31, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(305, 31, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(306, 31, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(307, 31, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(308, 31, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(309, 31, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(310, 31, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(311, 32, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(312, 32, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(313, 32, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(314, 32, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(315, 32, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(316, 32, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(317, 32, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(318, 32, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(319, 32, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(320, 32, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(321, 33, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(322, 33, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(323, 33, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(324, 33, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(325, 33, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(326, 33, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(327, 33, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(328, 33, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(329, 33, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(330, 33, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(331, 34, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(332, 34, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(333, 34, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(334, 34, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(335, 34, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(336, 34, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(337, 34, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(338, 34, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(339, 34, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(340, 34, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(341, 35, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(342, 35, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(343, 35, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(344, 35, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(345, 35, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(346, 35, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(347, 35, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(348, 35, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(349, 35, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(350, 35, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(351, 36, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(352, 36, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(353, 36, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(354, 36, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(355, 36, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(356, 36, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(357, 36, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(358, 36, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(359, 36, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(360, 36, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(361, 37, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(362, 37, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(363, 37, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(364, 37, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(365, 37, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(366, 37, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(367, 37, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(368, 37, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(369, 37, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(370, 37, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(371, 38, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(372, 38, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(373, 38, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(374, 38, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(375, 38, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(376, 38, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(377, 38, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(378, 38, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(379, 38, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(380, 38, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(381, 39, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(382, 39, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(383, 39, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(384, 39, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(385, 39, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(386, 39, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(387, 39, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(388, 39, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(389, 39, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(390, 39, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(391, 40, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(392, 40, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(393, 40, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(394, 40, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(395, 40, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(396, 40, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(397, 40, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(398, 40, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(399, 40, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(400, 40, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(401, 41, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(402, 41, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(403, 41, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(404, 41, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(405, 41, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(406, 41, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(407, 41, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(408, 41, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(409, 41, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(410, 41, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(411, 42, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(412, 42, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(413, 42, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(414, 42, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(415, 42, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(416, 42, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(417, 42, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(418, 42, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(419, 42, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(420, 42, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(421, 43, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(422, 43, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(423, 43, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(424, 43, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(425, 43, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(426, 43, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(427, 43, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(428, 43, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(429, 43, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(430, 43, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(431, 44, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(432, 44, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(433, 44, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(434, 44, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(435, 44, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(436, 44, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(437, 44, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(438, 44, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(439, 44, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(440, 44, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(441, 45, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(442, 45, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(443, 45, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(444, 45, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(445, 45, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(446, 45, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(447, 45, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(448, 45, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(449, 45, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(450, 45, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(451, 46, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(452, 46, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(453, 46, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(454, 46, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(455, 46, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(456, 46, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(457, 46, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(458, 46, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(459, 46, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(460, 46, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(461, 47, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(462, 47, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(463, 47, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(464, 47, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(465, 47, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(466, 47, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(467, 47, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(468, 47, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(469, 47, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(470, 47, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(471, 48, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(472, 48, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(473, 48, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(474, 48, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(475, 48, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(476, 48, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(477, 48, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(478, 48, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(479, 48, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(480, 48, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(481, 49, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(482, 49, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(483, 49, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(484, 49, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(485, 49, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(486, 49, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(487, 49, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(488, 49, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(489, 49, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(490, 49, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(491, 50, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(492, 50, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(493, 50, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(494, 50, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(495, 50, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(496, 50, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(497, 50, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(498, 50, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(499, 50, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(500, 50, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(501, 51, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(502, 51, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(503, 51, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(504, 51, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(505, 51, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(506, 51, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(507, 51, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(508, 51, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(509, 51, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(510, 51, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(511, 52, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(512, 52, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(513, 52, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(514, 52, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(515, 52, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(516, 52, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(517, 52, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(518, 52, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(519, 52, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(520, 52, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(521, 53, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(522, 53, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(523, 53, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(524, 53, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(525, 53, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(526, 53, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(527, 53, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(528, 53, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(529, 53, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(530, 53, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(531, 54, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(532, 54, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(533, 54, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(534, 54, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(535, 54, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(536, 54, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(537, 54, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(538, 54, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(539, 54, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(540, 54, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(541, 55, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(542, 55, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(543, 55, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(544, 55, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(545, 55, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(546, 55, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(547, 55, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(548, 55, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(549, 55, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(550, 55, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(551, 56, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(552, 56, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(553, 56, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(554, 56, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(555, 56, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(556, 56, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(557, 56, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(558, 56, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(559, 56, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(560, 56, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(561, 57, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(562, 57, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(563, 57, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(564, 57, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(565, 57, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(566, 57, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(567, 57, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(568, 57, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(569, 57, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(570, 57, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(571, 58, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(572, 58, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(573, 58, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(574, 58, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(575, 58, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(576, 58, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(577, 58, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(578, 58, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(579, 58, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(580, 58, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(581, 59, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(582, 59, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(583, 59, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(584, 59, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(585, 59, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(586, 59, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(587, 59, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(588, 59, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(589, 59, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(590, 59, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(591, 60, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(592, 60, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(593, 60, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(594, 60, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(595, 60, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(596, 60, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(597, 60, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(598, 60, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(599, 60, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(600, 60, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(601, 61, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(602, 61, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(603, 61, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(604, 61, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(605, 61, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(606, 61, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(607, 61, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(608, 61, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(609, 61, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(610, 61, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(611, 62, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(612, 62, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(613, 62, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(614, 62, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(615, 62, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(616, 62, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(617, 62, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(618, 62, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(619, 62, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(620, 62, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(621, 63, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(622, 63, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(623, 63, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(624, 63, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(625, 63, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(626, 63, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(627, 63, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(628, 63, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(629, 63, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(630, 63, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(631, 64, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(632, 64, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(633, 64, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(634, 64, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(635, 64, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(636, 64, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(637, 64, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(638, 64, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(639, 64, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(640, 64, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(641, 65, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(642, 65, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(643, 65, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(644, 65, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(645, 65, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(646, 65, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(647, 65, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(648, 65, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(649, 65, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(650, 65, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(651, 66, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(652, 66, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(653, 66, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(654, 66, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(655, 66, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(656, 66, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(657, 66, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(658, 66, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(659, 66, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(660, 66, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(661, 67, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(662, 67, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(663, 67, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(664, 67, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(665, 67, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(666, 67, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(667, 67, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(668, 67, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(669, 67, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(670, 67, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(671, 68, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(672, 68, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(673, 68, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(674, 68, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(675, 68, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(676, 68, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(677, 68, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(678, 68, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(679, 68, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(680, 68, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(681, 69, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(682, 69, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(683, 69, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(684, 69, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(685, 69, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(686, 69, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(687, 69, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(688, 69, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(689, 69, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(690, 69, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(691, 70, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(692, 70, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(693, 70, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(694, 70, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(695, 70, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(696, 70, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(697, 70, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(698, 70, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(699, 70, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(700, 70, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(701, 71, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(702, 71, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(703, 71, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(704, 71, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(705, 71, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(706, 71, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(707, 71, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(708, 71, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(709, 71, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(710, 71, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(711, 72, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(712, 72, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(713, 72, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(714, 72, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(715, 72, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(716, 72, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(717, 72, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(718, 72, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(719, 72, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(720, 72, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(721, 73, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(722, 73, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(723, 73, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(724, 73, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(725, 73, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(726, 73, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(727, 73, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(728, 73, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(729, 73, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(730, 73, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(731, 74, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(732, 74, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(733, 74, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(734, 74, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(735, 74, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(736, 74, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(737, 74, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(738, 74, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(739, 74, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(740, 74, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(741, 75, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(742, 75, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(743, 75, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(744, 75, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(745, 75, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(746, 75, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(747, 75, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(748, 75, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(749, 75, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(750, 75, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(751, 76, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(752, 76, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(753, 76, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(754, 76, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(755, 76, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(756, 76, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(757, 76, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(758, 76, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(759, 76, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(760, 76, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(761, 77, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(762, 77, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(763, 77, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(764, 77, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(765, 77, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(766, 77, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(767, 77, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(768, 77, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(769, 77, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(770, 77, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(771, 78, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(772, 78, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(773, 78, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(774, 78, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(775, 78, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(776, 78, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(777, 78, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(778, 78, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(779, 78, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(780, 78, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(781, 79, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(782, 79, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(783, 79, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(784, 79, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(785, 79, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(786, 79, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(787, 79, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(788, 79, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(789, 79, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(790, 79, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(791, 80, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(792, 80, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(793, 80, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(794, 80, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(795, 80, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(796, 80, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(797, 80, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(798, 80, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(799, 80, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(800, 80, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(801, 81, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(802, 81, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(803, 81, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(804, 81, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(805, 81, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(806, 81, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(807, 81, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(808, 81, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(809, 81, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(810, 81, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(811, 82, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(812, 82, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(813, 82, 1, 13, 3, NULL, '2021-03-26 11:20:32', NULL),
(814, 82, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(815, 82, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(816, 82, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(817, 82, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(818, 82, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(819, 82, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(820, 82, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(821, 83, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(822, 83, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(823, 83, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(824, 83, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(825, 83, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(826, 83, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(827, 83, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(828, 83, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(829, 83, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(830, 83, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(831, 84, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(832, 84, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(833, 84, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(834, 84, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(835, 84, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(836, 84, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(837, 84, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(838, 84, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(839, 84, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(840, 84, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(841, 85, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(842, 85, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(843, 85, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(844, 85, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(845, 85, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(846, 85, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(847, 85, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(848, 85, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(849, 85, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(850, 85, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(851, 86, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(852, 86, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(853, 86, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(854, 86, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(855, 86, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(856, 86, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(857, 86, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(858, 86, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(859, 86, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(860, 86, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL),
(861, 87, 1, 1, 1, NULL, '2021-03-26 11:20:32', NULL),
(862, 87, 1, 7, 2, NULL, '2021-03-26 11:20:32', NULL),
(863, 87, 1, 20, 3, NULL, '2021-03-26 11:20:32', NULL),
(864, 87, 1, 15, 4, NULL, '2021-03-26 11:20:32', NULL),
(865, 87, 1, 21, 5, NULL, '2021-03-26 11:20:32', NULL),
(866, 87, 1, 22, 6, NULL, '2021-03-26 11:20:32', NULL),
(867, 87, 1, 43, 7, NULL, '2021-03-26 11:20:32', NULL),
(868, 87, 1, 18, 8, NULL, '2021-03-26 11:20:32', NULL),
(869, 87, 1, 19, 9, NULL, '2021-03-26 11:20:32', NULL),
(870, 87, 1, 17, 10, NULL, '2021-03-26 11:20:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `universities`
--

CREATE TABLE `universities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `university_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uni_gender` tinyint(1) NOT NULL DEFAULT 0,
  `province_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `universities`
--

INSERT INTO `universities` (`id`, `university_name`, `uni_gender`, `province_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'KING EDWARD MEDICAL UNIVERSITY LAHORE', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(2, 'UNIVERSITY OF ENGINEERING AND TECHNOLOGY LAHORE', 0, 1, NULL, '2021-03-26 11:19:48', NULL),
(3, 'UNIVERSITY OF ENGINEERING AND TECHNOLOGY TAXILA', 0, 1, NULL, '2021-03-26 11:19:48', NULL),
(5, 'GOVERNMENT COLLEGE UNIVERSITY, FAISALABAD', 0, 1, NULL, '2021-03-26 11:19:48', NULL),
(6, 'GOVERNMENT COLLEGE UNIVERSITY, LAHORE', 0, 1, NULL, '2021-03-26 11:19:48', NULL),
(7, 'ALLAMA IQBAL MEDICAL UNIVERSITY, LAHORE', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(8, 'BAHAUDDIN ZAKARIYA UNIVERSITY, LAHORE', 0, 1, NULL, '2021-03-26 11:19:48', NULL),
(9, 'SZABIST UNIVERSITY SINDH', 0, 3, NULL, '2021-03-26 11:19:48', NULL),
(10, 'DOVE MEDICAL UNIVERSITY LAHORE', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(11, 'GOMAL UNIVERSITY PESHAWER', 0, 2, NULL, '2021-03-26 11:19:48', NULL),
(12, 'UNIVERSITY OF ENGINEERING AND TECHNOLOGY, PESHAWER', 0, 2, NULL, '2021-03-26 11:19:48', NULL),
(13, 'FATIMA JINNAH MEDICAL UNIVERSITY, LAHORE', 2, 5, NULL, '2021-03-26 11:19:48', NULL),
(14, 'FATIMA JINNAH WOMEN UNIVERSITY, RAWALPINDI', 2, 1, NULL, '2021-03-26 11:19:48', NULL),
(15, 'RAWALPINDI MEDICAL UNIVERSITY', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(16, 'CHANDAKA MEDICAL UNIVERSITY', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(17, 'AYUB MEDICAL COLLEGE, ABBOTABAD', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(18, 'KHYBER MEDICAL UNIVERSITY, PESHAWER', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(19, 'NISHTER MEDICAL UNIVERSITY', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(20, 'SERVICES INSTITUTE OF MEDICAL SCIENCES', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(21, 'PUNJAB MEDICAL COLLEGE, FAISALABAD', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(22, 'QUAID-E-AZAM MEDICAL COLLEGE', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(23, 'SHEIKH ZAYED MEDICAL COLLEGE, RAHIMYAR KHAN', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(25, 'NED UNIVERSITY KARACHI', 0, 3, NULL, '2021-03-26 11:19:48', NULL),
(26, 'UNIVERSITY OF ENGINEERING AND TECHNOLOGY, MEHRAN', 0, 3, NULL, '2021-03-26 11:19:48', NULL),
(27, 'DAWOOD COLLEGE, KARACHI', 0, 3, NULL, '2021-03-26 11:19:48', NULL),
(28, 'PUNJAB UNIVERSITY, LAHORE', 0, 1, NULL, '2021-03-26 11:19:48', NULL),
(29, 'UNIVERSITY OF ENGINEERING AND TECHNOLOGY, MIRPUR', 0, 1, NULL, '2021-03-26 11:19:48', NULL),
(30, 'UNIVERSITY OF ENGINEERING AND TECHNOLOGY, KHUZDAR', 0, 3, NULL, '2021-03-26 11:19:48', NULL),
(31, 'UNIVERSITY COLLEGE MUZAFFARABAD', 0, 6, NULL, '2021-03-26 11:19:48', NULL),
(32, 'UNIVERSITY OF ENGINEERING AND TECHNOLOGY, BAHAWALPUR', 0, 1, NULL, '2021-03-26 11:19:48', NULL),
(33, 'QUAID-E-AWAM UNIVERSITY, NAWABSHAH', 0, 3, NULL, '2021-03-26 11:19:48', NULL),
(34, 'UNIVERSITY OF SARGODHA', 0, 1, NULL, '2021-03-26 11:19:48', NULL),
(35, 'UNIVERSITY OF POONCH, RAWALAKOT', 0, 6, NULL, '2021-03-26 11:19:48', NULL),
(36, 'UNIVERSITY OF AGRICULTURE, PESHAWER', 0, 2, NULL, '2021-03-26 11:19:48', NULL),
(37, 'AGRICULTURE UNIVERSITY, FAISALABAD', 0, 1, NULL, '2021-03-26 11:19:48', NULL),
(38, 'UNIVERSITY OF AZAD JAMMU AND KASHMIR, MUZAFFARABAD', 0, 6, NULL, '2021-03-26 11:19:48', NULL),
(39, 'UNIVERSITY OF KOTLI AZAD JAMMU AND KASHMIR', 0, 6, NULL, '2021-03-26 11:19:48', NULL),
(40, 'GOVERNMENT COLLEGE UNIVERSITY FOR WOMEN, SIALKOTE', 0, 1, NULL, '2021-03-26 11:19:48', NULL),
(41, 'ISLAMIA UNIVERSITY, BAHAWALPUR', 0, 1, NULL, '2021-03-26 11:19:48', NULL),
(42, 'LAHORE COLLEGE FOR WOMEN UNIVERSITY, LAHORE', 0, 1, NULL, '2021-03-26 11:19:48', NULL),
(43, 'BOLAN MEDICAL COLLEGE, QUETTA', 0, 4, NULL, '2021-03-26 11:19:48', NULL),
(44, 'DE-MONTMORANCY COLLEGE, LAHORE', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(45, 'AJ AND K MEDICAL COLLEGE, MUZAFFARABAD', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(46, 'POONCH MEDICAL COLLEGE, RAWALAKOT', 0, 5, NULL, '2021-03-26 11:19:48', NULL),
(47, 'MOHTARMA BENAZIR BHUTTO SHAHEED MEDICAL COLLEGE, MIRPUR', 0, 5, NULL, '2021-03-26 11:19:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `university_course_seats`
--

CREATE TABLE `university_course_seats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `university_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `total_course_seats` int(11) NOT NULL DEFAULT 0,
  `on_rotation` tinyint(1) NOT NULL DEFAULT 0,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `is_test_required` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `university_course_seats`
--

INSERT INTO `university_course_seats` (`id`, `university_id`, `course_id`, `total_course_seats`, `on_rotation`, `is_available`, `is_test_required`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 8, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(2, 7, 1, 8, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(3, 20, 1, 3, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(4, 15, 1, 9, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(5, 21, 1, 2, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(6, 22, 1, 18, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(7, 43, 1, 1, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(8, 16, 1, 1, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(9, 17, 1, 6, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(10, 13, 1, 8, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(11, 19, 1, 1, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(12, 16, 1, 1, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(13, 16, 1, 1, 1, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(14, 23, 1, 2, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(15, 44, 2, 3, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(16, 19, 2, 2, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(17, 45, 1, 4, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(18, 46, 1, 4, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL),
(19, 47, 1, 4, 0, 1, 0, NULL, '2021-03-26 11:17:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_qualifications`
--
ALTER TABLE `academic_qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `academic_qualifications_prerequisite_id_foreign` (`prerequisite_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_course_category_id_foreign` (`course_category_id`);

--
-- Indexes for table `course_categories`
--
ALTER TABLE `course_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_district_quota_distributions`
--
ALTER TABLE `course_district_quota_distributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_district_quota_distribution_course_id_foreign` (`course_id`),
  ADD KEY `course_district_quota_distribution_district_id_foreign` (`district_id`);

--
-- Indexes for table `course_open_seats_distributions`
--
ALTER TABLE `course_open_seats_distributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_open_seats_distribution_course_id_foreign` (`course_id`);

--
-- Indexes for table `course_prerequisites`
--
ALTER TABLE `course_prerequisites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_prerequisites_course_id_foreign` (`course_id`),
  ADD KEY `course_prerequisites_prerequisite_id_foreign` (`prerequisite_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provinces_cc_pre_qualifications`
--
ALTER TABLE `provinces_cc_pre_qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provinces_cc_pre_qualifications_province_id_foreign` (`province_id`),
  ADD KEY `provinces_cc_pre_qualifications_course_category_id_foreign` (`course_category_id`),
  ADD KEY `provinces_cc_pre_qualifications_qualification_id_foreign` (`qualification_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students_district_id_foreign` (`district_id`);

--
-- Indexes for table `student_academic_qualifications`
--
ALTER TABLE `student_academic_qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_academic_qualifications_student_id_foreign` (`student_id`),
  ADD KEY `student_academic_qualifications_qualification_id_foreign` (`qualification_id`);

--
-- Indexes for table `student_university_courses_priorities`
--
ALTER TABLE `student_university_courses_priorities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_university_courses_priorities_student_id_foreign` (`student_id`),
  ADD KEY `student_university_courses_priorities_course_id_foreign` (`course_id`),
  ADD KEY `student_university_courses_priorities_university_id_foreign` (`university_id`);

--
-- Indexes for table `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `universities_province_id_foreign` (`province_id`);

--
-- Indexes for table `university_course_seats`
--
ALTER TABLE `university_course_seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `university_course_seats_university_id_foreign` (`university_id`),
  ADD KEY `university_course_seats_course_id_foreign` (`course_id`);

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
-- AUTO_INCREMENT for table `academic_qualifications`
--
ALTER TABLE `academic_qualifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `course_categories`
--
ALTER TABLE `course_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_district_quota_distributions`
--
ALTER TABLE `course_district_quota_distributions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `course_open_seats_distributions`
--
ALTER TABLE `course_open_seats_distributions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_prerequisites`
--
ALTER TABLE `course_prerequisites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `provinces_cc_pre_qualifications`
--
ALTER TABLE `provinces_cc_pre_qualifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `student_academic_qualifications`
--
ALTER TABLE `student_academic_qualifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_university_courses_priorities`
--
ALTER TABLE `student_university_courses_priorities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=871;

--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `university_course_seats`
--
ALTER TABLE `university_course_seats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic_qualifications`
--
ALTER TABLE `academic_qualifications`
  ADD CONSTRAINT `academic_qualifications_prerequisite_id_foreign` FOREIGN KEY (`prerequisite_id`) REFERENCES `academic_qualifications` (`id`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_course_category_id_foreign` FOREIGN KEY (`course_category_id`) REFERENCES `course_categories` (`id`);

--
-- Constraints for table `course_district_quota_distributions`
--
ALTER TABLE `course_district_quota_distributions`
  ADD CONSTRAINT `course_district_quota_distribution_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `course_district_quota_distribution_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`);

--
-- Constraints for table `course_open_seats_distributions`
--
ALTER TABLE `course_open_seats_distributions`
  ADD CONSTRAINT `course_open_seats_distribution_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `course_prerequisites`
--
ALTER TABLE `course_prerequisites`
  ADD CONSTRAINT `course_prerequisites_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `course_prerequisites_prerequisite_id_foreign` FOREIGN KEY (`prerequisite_id`) REFERENCES `academic_qualifications` (`id`);

--
-- Constraints for table `provinces_cc_pre_qualifications`
--
ALTER TABLE `provinces_cc_pre_qualifications`
  ADD CONSTRAINT `provinces_cc_pre_qualifications_course_category_id_foreign` FOREIGN KEY (`course_category_id`) REFERENCES `course_categories` (`id`),
  ADD CONSTRAINT `provinces_cc_pre_qualifications_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`),
  ADD CONSTRAINT `provinces_cc_pre_qualifications_qualification_id_foreign` FOREIGN KEY (`qualification_id`) REFERENCES `academic_qualifications` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`);

--
-- Constraints for table `student_academic_qualifications`
--
ALTER TABLE `student_academic_qualifications`
  ADD CONSTRAINT `student_academic_qualifications_qualification_id_foreign` FOREIGN KEY (`qualification_id`) REFERENCES `academic_qualifications` (`id`),
  ADD CONSTRAINT `student_academic_qualifications_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `student_university_courses_priorities`
--
ALTER TABLE `student_university_courses_priorities`
  ADD CONSTRAINT `student_university_courses_priorities_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `student_university_courses_priorities_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `student_university_courses_priorities_university_id_foreign` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`);

--
-- Constraints for table `universities`
--
ALTER TABLE `universities`
  ADD CONSTRAINT `universities_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);

--
-- Constraints for table `university_course_seats`
--
ALTER TABLE `university_course_seats`
  ADD CONSTRAINT `university_course_seats_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `university_course_seats_university_id_foreign` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
