-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 28, 2023 at 01:30 PM
-- Server version: 10.3.39-MariaDB-log-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stbcsorg_influencer`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(10) NOT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `starting_date` varchar(20) DEFAULT NULL,
  `ending_date` varchar(20) DEFAULT NULL,
  `client_id` int(10) DEFAULT NULL,
  `regions` text DEFAULT NULL,
  `budget` varchar(255) DEFAULT NULL,
  `kpi` varchar(255) DEFAULT NULL,
  `asset` varchar(255) DEFAULT NULL,
  `client_brief` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `total_reach` int(10) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `campaign_name`, `starting_date`, `ending_date`, `client_id`, `regions`, `budget`, `kpi`, `asset`, `client_brief`, `description`, `status`, `total_reach`, `created_at`, `updated_at`) VALUES
(1, 'Example Camp', '2023-05-04', '2023-05-24', 1, NULL, '1200', '76767', NULL, NULL, 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen book. It usually begins with:\r\n\r\n“Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.”', 'Clossed', NULL, '2023-05-02 21:02:53', NULL),
(2, 'Hello Camp', '2023-05-11', '2023-05-22', 4, NULL, '1200', '76767', 'test', 'test', 'The passage experienced a surge in popularity during the 1960s when Letraset used it on their dry-transfer sheets, and again during the 90s as desktop publishers bundled the text with their software. Today it\'s seen all around the web; on templates, websites, and stock designs. Use our generator to get your own, or read on for the authoritative history of lorem ipsum.', 'Clossed', NULL, '2023-05-02 21:21:02', NULL),
(3, 'Something', '2023-05-04', '2023-05-30', 5, NULL, '125584', 'None', NULL, NULL, NULL, 'Clossed', NULL, '2023-05-04 16:12:51', NULL),
(4, 'New Camp', '2023-05-16', '2023-05-26', 1, NULL, '9097', '657', NULL, NULL, 'Nothing', 'Ongoing', 500, '2023-05-06 12:46:03', NULL),
(5, 'New Camp', '2023-05-09', '2023-05-24', 1, NULL, '9097', '657', 'https://www.formget.com/php-checkbox/#:~:text=To%20get%20value%20of%20a,%3E%20%3C%3F', 'No need of it', 'hello from sourav', 'Approved', NULL, '2023-05-07 10:25:22', NULL),
(6, 'New Camp', '2023-05-09', '2023-05-24', 1, NULL, '9097', '657', 'https://www.formget.com/php-checkbox/#:~:text=To%20get%20value%20of%20a,%3E%20%3C%3F', 'No need of it', 'hello from sourav', 'Pending', NULL, '2023-05-07 10:25:40', NULL),
(7, 'Hello Camp', '2023-05-09', '2023-05-31', 4, NULL, '9097', '657', 'https://www.formget.com/php', 'No need of it', 'Not interested to write now', 'Draft', NULL, '2023-05-07 10:43:11', NULL),
(8, 'Sooooo', '2023-05-08', '2023-05-30', 5, NULL, 'sdfsgf', 'sefse', 'fsdf', 'sdfs', 'sdfsddf', 'Draft', NULL, '2023-05-07 11:01:55', NULL),
(9, 'DOO', '2023-05-12', '2023-05-30', 7, NULL, '5000', 'Brand Awarness', NULL, NULL, NULL, 'Approved', NULL, '2023-05-12 06:50:15', NULL),
(10, 'SOMETHING', '2023-05-20', '2023-05-25', 7, NULL, '5000', 'NONE', NULL, NULL, NULL, 'Pending', NULL, '2023-05-12 16:06:02', NULL),
(11, 'Demo Camp', '2023-05-14', '2023-05-30', 1, NULL, '10000', '600', NULL, NULL, NULL, NULL, NULL, '2023-05-12 18:13:13', NULL),
(12, 'Ting Ting', '2023-05-14', '2023-05-30', 1, NULL, '10000', '600', NULL, NULL, NULL, 'Pending', NULL, '2023-05-12 18:14:16', NULL),
(13, 'Demo Camp', NULL, NULL, 7, NULL, '10000', '600', NULL, NULL, NULL, 'Pending', NULL, '2023-05-17 17:08:11', NULL),
(14, 'Hello Camp', NULL, NULL, 7, NULL, '10000', '657', 'https://www.formget.com/php', 'No need of it', NULL, 'Pending', NULL, '2023-05-18 04:05:26', NULL),
(15, 'Demo Camp', NULL, NULL, 7, NULL, '10000', '600', NULL, NULL, NULL, 'Pending', NULL, '2023-05-19 08:22:17', NULL),
(16, 'Sooooo', '2023-05-22', '2023-05-31', 7, NULL, 'sdfsgf', 'sefse', 'fsdf', 'sdfs', NULL, 'Pending', NULL, '2023-05-21 17:54:46', NULL),
(17, 'Example Camp', NULL, NULL, 7, NULL, '1200', '76767', NULL, NULL, NULL, 'Pending', NULL, '2023-05-23 07:01:27', NULL),
(18, 'DOOg', '2023-06-11', '2023-06-12', 8, NULL, '5000', 'sefse', NULL, NULL, NULL, 'Approved', NULL, '2023-06-11 06:58:22', NULL),
(19, 'nft cars', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Draft', NULL, '2023-06-12 02:46:47', NULL),
(20, 'Demo Camp', '2023-07-07', '2023-07-27', 4, NULL, NULL, '657', 'https://www.formget.com/php-checkbox/#:~:text=To%20get%20value%20of%20a,%3E%20%3C%3F', 'No need of it', NULL, 'Pending', NULL, '2023-07-06 05:30:21', NULL),
(21, 'DON', '2023-07-13', '2023-07-26', 1, NULL, NULL, '454545', NULL, NULL, NULL, 'Approved', NULL, '2023-07-06 07:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `campaign_best_post`
--

CREATE TABLE `campaign_best_post` (
  `id` int(11) NOT NULL,
  `campaign_id` int(10) DEFAULT NULL,
  `best_post_url` text DEFAULT NULL,
  `best_post_file` varchar(255) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `campaign_best_post`
--

INSERT INTO `campaign_best_post` (`id`, `campaign_id`, `best_post_url`, `best_post_file`, `created_at`, `created_by`) VALUES
(1, 4, 'https://www.facebook.com/watch?v=918897852497041', 'C4.png', '2023-05-16 08:49:03', '19'),
(2, 4, 'https://github.com/settings/tokens', 'C4.jpg', '2023-05-16 12:10:36', '19'),
(3, 4, 'https://github.com/settings/tokens', 'C4.jpg', '2023-05-16 12:11:24', '19');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_content_custom_price`
--

CREATE TABLE `campaign_content_custom_price` (
  `campaign_id` int(10) DEFAULT NULL,
  `influencer_id` int(10) DEFAULT NULL,
  `content_id` int(10) DEFAULT NULL,
  `price` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `campaign_content_custom_price`
--

INSERT INTO `campaign_content_custom_price` (`campaign_id`, `influencer_id`, `content_id`, `price`) VALUES
(1, 42, 4, 45),
(3, 42, 4, 200),
(3, 54, 4, 300),
(3, 54, 8, 0),
(3, 42, 4, 30);

-- --------------------------------------------------------

--
-- Table structure for table `campaign_featured_article`
--

CREATE TABLE `campaign_featured_article` (
  `id` int(10) NOT NULL,
  `campaign_id` int(10) DEFAULT NULL,
  `article_url` text DEFAULT NULL,
  `article_img` varchar(255) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `campaign_featured_article`
--

INSERT INTO `campaign_featured_article` (`id`, `campaign_id`, `article_url`, `article_img`, `created_at`, `created_by`) VALUES
(1, 4, 'https://www.facebook.com/watch?v=918897852497041', 'C4S1.png', '2023-05-16 08:49:03', 19),
(2, 4, 'https://www.facebook.com/watch?v=918897852497041', 'C4S2.png', '2023-05-16 08:49:03', 19);

-- --------------------------------------------------------

--
-- Table structure for table `campaign_featured_video`
--

CREATE TABLE `campaign_featured_video` (
  `id` int(10) NOT NULL,
  `campaign_id` int(10) DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `video_file` varchar(255) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `campaign_featured_video`
--

INSERT INTO `campaign_featured_video` (`id`, `campaign_id`, `video_url`, `video_file`, `created_at`, `created_by`) VALUES
(1, 4, 'https://www.facebook.com/watch?v=918897852497041', 'C4S1.mp4', '2023-05-16 08:49:03', 19);

-- --------------------------------------------------------

--
-- Table structure for table `campaign_influencer`
--

CREATE TABLE `campaign_influencer` (
  `id` int(10) NOT NULL,
  `campaign_id` int(10) DEFAULT NULL,
  `influencer_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `campaign_influencer`
--

INSERT INTO `campaign_influencer` (`id`, `campaign_id`, `influencer_id`) VALUES
(1, 1, 42),
(2, 1, 43),
(3, 2, 48),
(4, 2, 53),
(6, 3, 42),
(7, 3, 54),
(8, 3, 40),
(16, 5, 42),
(17, 5, 52),
(19, 5, 48),
(20, 6, 42),
(21, 6, 52),
(23, 6, 48),
(25, 7, 40),
(26, 8, 42),
(55, 9, 54),
(56, 9, 53),
(57, 10, 40),
(65, 11, 40),
(66, 12, 42),
(74, 14, 48),
(75, 16, 57),
(76, 16, 55),
(77, 17, 40),
(78, 18, 56),
(79, 18, 53),
(80, 19, 61),
(81, 19, 60),
(82, 19, 61),
(92, 20, 48),
(93, 20, 40),
(94, 21, 60),
(95, 21, 61),
(96, 21, 57),
(97, 21, 56),
(98, 21, 53);

-- --------------------------------------------------------

--
-- Table structure for table `campaign_permission`
--

CREATE TABLE `campaign_permission` (
  `role_id` int(10) NOT NULL,
  `view` tinyint(1) DEFAULT NULL,
  `edit` tinyint(1) DEFAULT NULL,
  `create` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `campaign_permission`
--

INSERT INTO `campaign_permission` (`role_id`, `view`, `edit`, `create`) VALUES
(9, 1, 1, 1),
(11, NULL, NULL, NULL),
(6, 1, 1, 1),
(12, 1, 1, 1),
(3, NULL, NULL, NULL),
(13, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `comany_name` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `telegram` text DEFAULT NULL,
  `vat_no` varchar(100) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `is_favourite` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(10) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `user_id`, `username`, `name`, `email`, `comany_name`, `address`, `telegram`, `vat_no`, `note`, `is_favourite`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, NULL, 'sourav6400', 'Sourav Das', 'imsourav6400@gmail.com', 'Webase Technology Ltd.', 'Dhanmondi, Dhaka-1205', 'https://web.telegram.org/k/', '12345670', 'Test Note', 0, 19, '2023-03-29 21:04:53', 4, '2023-05-12 16:13:59'),
(4, 25, 'mrdip', 'Mr. Dip', 'dip@gmail.com', 'Webase Technology', 'Mohammadpur', 'https://web.telegram.org/k/', '435647', NULL, 0, 19, '2023-05-02 21:19:18', 4, '2023-07-06 07:45:43'),
(5, 26, 'ripabiswassharna', 'Ripa', 'ripabiswassharna@gmail.com', 'Nothing', 'Janina', 'Nei', '45899256', 'B', 0, 4, '2023-05-04 16:00:05', NULL, NULL),
(7, 27, 'Tilok1', 'Subro Datta', 'subrodatta@gmail.com', 'DOMAIN', 'Mohadebpur, Manirampur, Jashore', 't.me/tilok0011', '1254858', 'My Brother', 0, 4, '2023-05-12 06:37:24', NULL, NULL),
(8, 28, 'Alex', 'Alex Quali', 'alex.kull@gmail.com', 'Slime', 'Nothing', 't.me/alex', '21325', NULL, 0, 4, '2023-06-11 06:54:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_permission`
--

CREATE TABLE `client_permission` (
  `role_id` int(10) NOT NULL,
  `view` tinyint(1) DEFAULT NULL,
  `edit` tinyint(1) DEFAULT NULL,
  `create` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `client_permission`
--

INSERT INTO `client_permission` (`role_id`, `view`, `edit`, `create`) VALUES
(8, 1, 1, 1),
(9, 1, 1, 1),
(11, NULL, NULL, NULL),
(6, 1, 1, 1),
(12, 1, 1, NULL),
(3, 1, NULL, NULL),
(13, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_tags`
--

CREATE TABLE `client_tags` (
  `client_id` int(10) DEFAULT NULL,
  `tag_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `client_tags`
--

INSERT INTO `client_tags` (`client_id`, `tag_id`) VALUES
(1, 8),
(1, 9),
(5, 9),
(6, 2),
(6, 8),
(7, 8),
(4, 6),
(4, 8),
(8, 8);

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` int(10) NOT NULL,
  `content_name` varchar(50) DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `social_id` int(10) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `updated_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `content_name`, `short_name`, `social_id`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(4, 'Tweet', 'T', 6, 19, '2023-03-16 18:07:16', 4, '2023-08-08 06:08:35'),
(6, 'Retweets', 'RT', 6, 19, '2023-03-21 21:05:46', 4, '2023-08-09 13:33:34'),
(8, 'osef', 'Thread', NULL, 4, '2023-04-21 01:13:10', 4, '2023-08-25 21:22:40'),
(9, 'youtube dedicated', 'YT-D', 8, 4, '2023-06-12 02:17:27', 4, '2023-08-08 06:09:35'),
(10, 'youtube integrated', 'YT-S', 8, 4, '2023-06-12 02:17:45', 4, '2023-08-08 06:10:23'),
(11, 'FB Reels', 'F-R', 1, 24, '2023-07-09 16:36:06', 4, '2023-08-09 13:32:19'),
(13, 'TikTok Video', 'TK-V', 7, 4, '2023-07-12 17:06:20', NULL, NULL),
(14, 'FB POST', 'FB P', 1, 4, '2023-07-29 17:06:16', NULL, NULL),
(15, 'Quote Tweet', 'QT', 6, 4, '2023-08-24 05:32:50', NULL, NULL),
(16, 'Facebook stream', 'F-St', 1, 4, '2023-08-24 05:33:49', NULL, NULL),
(17, 'Threads', 'TH', 6, 4, '2023-08-25 21:21:36', NULL, NULL);

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
-- Table structure for table `ifluencer_package_content`
--

CREATE TABLE `ifluencer_package_content` (
  `id` int(10) NOT NULL,
  `package_id` int(10) DEFAULT NULL,
  `influencer_id` int(10) DEFAULT NULL,
  `content_id` int(10) DEFAULT NULL,
  `content_quantity` int(10) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ifluencer_package_content`
--

INSERT INTO `ifluencer_package_content` (`id`, `package_id`, `influencer_id`, `content_id`, `content_quantity`, `price`) VALUES
(65, 34, 56, 4, 100, NULL),
(66, 34, 56, 6, 100, NULL),
(68, 35, 61, 6, 25, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ifluencer_template_content`
--

CREATE TABLE `ifluencer_template_content` (
  `id` int(10) NOT NULL,
  `template_id` int(10) DEFAULT NULL,
  `influencer_id` int(10) DEFAULT NULL,
  `content_id` int(10) DEFAULT NULL,
  `content_quantity` int(10) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ifluencer_template_content`
--

INSERT INTO `ifluencer_template_content` (`id`, `template_id`, `influencer_id`, `content_id`, `content_quantity`, `price`) VALUES
(128, 21, 65, 4, 100, 50),
(129, 21, 65, 6, 50, 10),
(130, 21, 62, 4, 50, 100),
(131, 21, 62, 6, 100, 150),
(132, 21, 53, 4, 10, 50),
(133, 21, 53, 6, 10, 80),
(134, 21, 66, 11, 8, 100),
(135, 21, 66, 14, 10, 100),
(136, 21, 57, 4, 20, 300),
(137, 21, 57, 6, 10, 100),
(139, 21, 40, 4, 1, 20),
(140, 21, 40, 11, 1, 100),
(149, 22, 61, 4, 2, 50),
(150, 22, 61, 6, 3, 60),
(153, 25, 61, 17, 3, 450),
(154, 25, 40, 17, 5, 500),
(155, 25, 92, 4, 1, 3000),
(156, 25, 98, 6, 1, 1150);

-- --------------------------------------------------------

--
-- Table structure for table `influencer`
--

CREATE TABLE `influencer` (
  `id` int(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `contact_type` varchar(100) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `telegram` varchar(255) DEFAULT NULL,
  `regions` text DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `tags` text DEFAULT '[]',
  `password` text DEFAULT NULL,
  `socials` text DEFAULT NULL,
  `contents` text DEFAULT NULL,
  `wallets` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `is_favourite` tinyint(1) NOT NULL DEFAULT 0,
  `twitter` text DEFAULT NULL,
  `dp_url` text DEFAULT NULL,
  `twitter_follower` bigint(20) NOT NULL DEFAULT 0,
  `youtube_follower` int(20) NOT NULL DEFAULT 0,
  `fb_follower` int(10) DEFAULT NULL,
  `ig_follower` int(10) DEFAULT NULL,
  `tiktok_follower` int(10) DEFAULT NULL,
  `total_follower` int(20) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `influencer`
--

INSERT INTO `influencer` (`id`, `name`, `contact_type`, `contact`, `telegram`, `regions`, `email`, `tags`, `password`, `socials`, `contents`, `wallets`, `note`, `is_favourite`, `twitter`, `dp_url`, `twitter_follower`, `youtube_follower`, `fb_follower`, `ig_follower`, `tiktok_follower`, `total_follower`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(40, 'Tilok Sarkar', 'telegram', 'tilok_rockstar', NULL, NULL, 'tilok.php@gmail.com', '[]', '$2y$10$m659EvpQQUgegoX7xDHHkewBJFfTUCZtU7EcRAS9VuE.KfVxPEG9a', NULL, NULL, NULL, 'God you know everything better than me.', 1, NULL, 'http://pbs.twimg.com/profile_images/1673816409284182017/byBBeeJa.png', 775, 0, NULL, NULL, NULL, 775, 4, '2023-04-07 15:18:39', 19, '2023-06-23 08:16:07'),
(42, 'Amit Hasan', NULL, NULL, NULL, NULL, 'nanmonirul@gmail.com', '[]', '$2y$10$v6VaFcC1YPBwcWazTtGGCuxcyxNTxH/V8tGEojShErJyotXTqPxde', NULL, NULL, NULL, NULL, 0, NULL, 'http://pbs.twimg.com/profile_images/1517228033463451648/YMnor5Mi.jpg', 5, 0, NULL, NULL, NULL, 5, 3, '2023-04-08 12:15:16', 4, '2023-06-12 02:22:43'),
(48, 'Sourav Das', 'telegram', 'sourav6400', NULL, NULL, 'imsourav6400@gmail.com', '[]', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'http://pbs.twimg.com/profile_images/1140186227347357696/FGUMIL4u.jpg', 10, 0, NULL, NULL, NULL, 10, 19, '2023-04-20 03:53:33', 19, '2023-05-12 16:28:58'),
(53, 'Nazmul', NULL, NULL, NULL, NULL, 'tomamollick007@gmail.com', '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'http://pbs.twimg.com/profile_images/1621574521894338566/Ovx_hSoN.png', 31992, 0, NULL, NULL, NULL, 31992, 4, '2023-04-20 08:23:28', 19, '2023-05-12 16:31:03'),
(55, 'Something', NULL, NULL, 'https://web.telegram.org/z/#1587343779', NULL, 'colordigitalsign13@gmail.com', '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, NULL, NULL, NULL, 0, 4, '2023-05-06 17:40:41', NULL, NULL),
(56, 'genso', NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'http://pbs.twimg.com/profile_images/1550836726339452928/H9EH--LW.jpg', 116369, 0, NULL, NULL, NULL, 116369, 4, '2023-05-08 12:38:50', 4, '2023-05-12 06:32:17'),
(57, 'dehkunle', NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'http://pbs.twimg.com/profile_images/1500982302234533894/i5xkHmR6.jpg', 496930, 0, NULL, NULL, NULL, 496930, 4, '2023-05-08 12:39:52', NULL, NULL),
(60, 'Ash Crypto', NULL, NULL, NULL, NULL, 'email@youremail.com', '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'http://pbs.twimg.com/profile_images/1653544394686095360/jFNf96ZC.jpg', 745345, 0, NULL, NULL, NULL, 745345, 4, '2023-05-31 05:12:48', NULL, NULL),
(61, 'chase', NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'http://pbs.twimg.com/profile_images/1557059330666545153/qFpFDXM3.jpg', 115202, 0, NULL, NULL, NULL, 115202, 4, '2023-06-10 06:45:25', NULL, NULL),
(62, 'Kermit', 'telegram', 'kermit', 't.me/kermit', NULL, 'something@newmail.com', '[]', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'http://pbs.twimg.com/profile_images/1591006407515586560/FXBtyobX.jpg', 15236, 0, NULL, NULL, NULL, 15236, 4, '2023-06-11 06:56:15', 4, '2023-06-11 06:56:52'),
(65, 'julia.nft', 'telegram', 'tilok0023', 'www.t.me/tilok0023', NULL, 'tilok.php@ymail.com', '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'http://pbs.twimg.com/profile_images/1608458807704948739/ZHX1p8r0.jpg', 23061, 0, NULL, NULL, NULL, 23061, 4, '2023-06-12 01:30:39', NULL, NULL),
(66, 'Genzo', NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, NULL, NULL, NULL, 0, 4, '2023-06-12 01:49:51', NULL, NULL),
(68, 'dan fuentes', NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, NULL, NULL, NULL, 0, 4, '2023-07-07 03:58:18', NULL, NULL),
(88, 'Elon Musk', 'telegram', NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, 'Hello from Elon Musk', 0, NULL, 'https://pbs.twimg.com/profile_images/1683325380441128960/yRsRRjGO_normal.jpg', 153964262, 0, NULL, NULL, NULL, 153964262, 24, '2023-08-22 22:06:26', NULL, NULL),
(89, 'Lionel Messi', 'telegram', NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, 'Hello from Messi', 0, NULL, 'https://pbs.twimg.com/profile_images/1611332347470692353/h5JnKeil_normal.jpg', 743153, 0, NULL, NULL, NULL, 743153, 24, '2023-08-22 22:10:22', NULL, NULL),
(92, 'Cristiano Ronaldo', 'telegram', NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'https://pbs.twimg.com/profile_images/1594446880498401282/o4L2z8Ay_normal.jpg', 109369443, 0, NULL, NULL, NULL, 109369443, 24, '2023-08-22 22:18:16', NULL, NULL),
(94, 'Sheikh Hasinaa', 'telegram', NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'https://pbs.twimg.com/profile_images/1278806824519524358/3emmgjpc_normal.jpg', 253, 0, NULL, NULL, NULL, 253, 24, '2023-08-22 22:27:20', NULL, NULL),
(95, 'Mimi chakraborty', 'mobile', '01313581114', NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'https://pbs.twimg.com/profile_images/1691250516523888640/XRf-ZS2y_normal.jpg', 966901, 0, NULL, NULL, NULL, 966901, 4, '2023-08-23 01:52:53', NULL, NULL),
(96, 'Soumik Saha', 'telegram', 'bigboxboy8', NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'https://pbs.twimg.com/profile_images/1469414562365538308/FgD0zQay_normal.jpg', 27, 0, NULL, NULL, NULL, 27, 4, '2023-08-23 01:54:30', NULL, NULL),
(97, 'defiwarhol', 'telegram', NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'https://pbs.twimg.com/profile_images/1666775984622690304/z57xiv1J_normal.jpg', 12460, 0, NULL, NULL, NULL, 12460, 4, '2023-08-24 05:21:54', NULL, NULL),
(98, 'Uxninja', 'telegram', NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'https://pbs.twimg.com/profile_images/1350600381500432387/XFXpvxBG_normal.jpg', 1364, 0, NULL, NULL, NULL, 1364, 4, '2023-08-25 21:18:14', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `influencer_contents`
--

CREATE TABLE `influencer_contents` (
  `id` int(11) NOT NULL,
  `influencer_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `price` int(10) DEFAULT NULL,
  `color_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `influencer_contents`
--

INSERT INTO `influencer_contents` (`id`, `influencer_id`, `content_id`, `price`, `color_code`) VALUES
(2, 26, 4, 200, NULL),
(3, 32, 6, 15000, NULL),
(4, 37, 4, 15, NULL),
(5, 38, 4, 20, NULL),
(6, 39, 6, 15, NULL),
(11, 42, 4, 200, NULL),
(12, 43, 4, 75, NULL),
(13, 47, 4, 15, NULL),
(14, 48, 6, 100, NULL),
(15, 51, 4, 15, NULL),
(17, 53, 6, 150, NULL),
(18, 54, 4, 200, NULL),
(19, 44, 4, 500, NULL),
(20, 54, 8, 300, NULL),
(21, 55, 4, 150, NULL),
(22, 56, 4, 150, NULL),
(23, 57, 4, 500, NULL),
(30, 60, 4, 200, NULL),
(31, 61, 4, 250, NULL),
(32, 62, 4, 100, NULL),
(33, 62, 6, 150, NULL),
(36, 65, 4, 50, NULL),
(39, 53, 4, 100, NULL),
(40, 61, 6, 50, NULL),
(41, 42, 4, 200, NULL),
(42, 40, 8, 100, '#096754'),
(43, 60, 8, 100, NULL),
(48, 61, 9, 200, NULL),
(55, 48, 4, 100, NULL),
(58, 66, 11, 50, NULL),
(59, 68, 9, 20, NULL),
(63, 40, 4, 20, NULL),
(70, 40, 11, 10, NULL),
(71, 40, 10, 50, NULL),
(72, 88, 4, 500, NULL),
(73, 88, 6, 600, NULL),
(74, 89, 4, 15, NULL),
(76, 92, 4, 15, NULL),
(78, 94, 4, 15, NULL),
(79, 95, 4, 150, NULL),
(80, 95, 6, 20, NULL),
(81, 96, 4, 100, NULL),
(82, 96, 6, 120, NULL),
(83, 97, 4, 15, NULL),
(84, 61, 15, 500, NULL),
(85, 61, 16, 1500, NULL),
(86, 98, 4, 15, NULL),
(87, 61, 17, 450, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `influencer_package`
--

CREATE TABLE `influencer_package` (
  `id` int(10) NOT NULL,
  `package_name` varchar(255) DEFAULT NULL,
  `influencer_id` int(10) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `influencer_package`
--

INSERT INTO `influencer_package` (`id`, `package_name`, `influencer_id`, `price`) VALUES
(34, 'GENZO COMBO', 56, 3000.00),
(35, 'Tweeter Package', 61, 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `influencer_permission`
--

CREATE TABLE `influencer_permission` (
  `role_id` int(10) NOT NULL,
  `view` tinyint(1) DEFAULT NULL,
  `edit` tinyint(1) DEFAULT NULL,
  `create` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `influencer_permission`
--

INSERT INTO `influencer_permission` (`role_id`, `view`, `edit`, `create`) VALUES
(9, 1, 1, 1),
(11, NULL, NULL, NULL),
(6, 1, 1, 1),
(12, NULL, NULL, NULL),
(3, 1, NULL, NULL),
(13, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `influencer_regions`
--

CREATE TABLE `influencer_regions` (
  `influencer_id` int(10) NOT NULL,
  `region_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `influencer_regions`
--

INSERT INTO `influencer_regions` (`influencer_id`, `region_id`) VALUES
(30, 7),
(30, 8),
(30, 9),
(29, 6),
(29, 8),
(29, 9),
(28, 6),
(28, 11),
(28, 12),
(31, 7),
(37, 6),
(37, 7),
(32, 7),
(32, 8),
(26, 10),
(38, 7),
(39, 6),
(39, 10),
(41, 6),
(42, 7),
(43, 7),
(44, 8),
(48, 6),
(48, 7),
(48, 11),
(50, 7),
(52, 7),
(53, 7),
(54, 8),
(55, 11),
(60, 7),
(62, 8),
(65, 7),
(56, 10),
(57, 9),
(66, 13),
(88, 7),
(88, 9),
(89, 7),
(89, 9),
(92, 6),
(92, 7),
(94, 6),
(95, 6),
(96, 9),
(97, 11),
(40, 6),
(61, 8);

-- --------------------------------------------------------

--
-- Table structure for table `influencer_socials`
--

CREATE TABLE `influencer_socials` (
  `influencer_id` int(10) NOT NULL,
  `social_id` int(10) NOT NULL,
  `social_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `influencer_socials`
--

INSERT INTO `influencer_socials` (`influencer_id`, `social_id`, `social_address`) VALUES
(29, 4, 'https://www.linkedin.com/'),
(29, 6, 'https://twitter.com/tokenomicsz'),
(26, 1, 'https://www.facebook.com/updated'),
(26, 6, 'https://twitter.com/sourav6400'),
(31, 1, 'https://twitter.com/GranMag0'),
(32, 6, 'https://twitter.com/tokenomicsz'),
(37, 1, 'fabcebook.com'),
(38, 1, 'https://www.facebook.com/'),
(38, 6, 'https://twitter.com/dipduniiya'),
(39, 1, 'https://www.facebook.com/sourav6400/'),
(39, 6, 'https://www.twitter.com/amdad121'),
(28, 6, 'https://twitter.com/joyerjoy569'),
(40, 6, 'https://twitter.com/tokenomicsz'),
(41, 6, 'https://twitter.com/dipduniiya'),
(42, 6, 'https://twitter.com/procoderamit'),
(41, 9, 'https://www.instagram.com/dipduniya/'),
(43, 9, 'https://www.instagram.com/dipduniya/'),
(44, 6, 'https://twitter.com/Abrahamchase09'),
(47, 1, NULL),
(48, 6, 'https://twitter.com/sourav6400'),
(48, 9, 'https://www.instagram.com/sourav6400'),
(48, 8, 'https://www.youtube.com/@EkattorTelevision'),
(50, 6, 'https://twitter.com/TommmyonXRP'),
(51, 1, NULL),
(52, 6, 'https://twitter.com/Football__Tweet'),
(53, 6, 'https://twitter.com/_mathieson_'),
(54, 6, 'https://twitter.com/bloomstarbms'),
(55, 1, 'https://www.facebook.com/ekanto.apon.520'),
(56, 6, 'https://twitter.com/genso_meta'),
(57, 6, 'https://twitter.com/Dehkunle'),
(60, 6, 'https://twitter.com/Ashcryptoreal'),
(61, 6, 'https://twitter.com/Abrahamchase09'),
(62, 6, 'https://twitter.com/crypto__kermit'),
(65, 6, 'https://twitter.com/juliadziesinska'),
(66, 1, 'https://twitter.com/CryptoGenzo'),
(68, 8, 'https://www.youtube.com/@dan_fuentes'),
(40, 1, 'www.facebook.com/ekanto.apon'),
(88, 6, 'https://twitter.com/elonmusk'),
(89, 6, 'https://twitter.com/imessi'),
(92, 6, 'https://twitter.com/Cristiano'),
(94, 6, 'https://twitter.com/sheikh_hasinaa'),
(95, 6, 'https://twitter.com/mimichakraborty'),
(96, 6, 'https://twitter.com/SoumikS48209396'),
(97, 6, 'https://twitter.com/Defi_Warhol'),
(97, 15, 'https://t.me/defi_Warhol'),
(61, 1, 'https://www.facebook.com/JeffMooreEP'),
(98, 6, 'https://twitter.com/uixninja');

-- --------------------------------------------------------

--
-- Table structure for table `influencer_tags`
--

CREATE TABLE `influencer_tags` (
  `influencer_id` int(10) NOT NULL,
  `tag_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `influencer_tags`
--

INSERT INTO `influencer_tags` (`influencer_id`, `tag_id`) VALUES
(30, 2),
(30, 8),
(29, 6),
(29, 8),
(28, 2),
(28, 6),
(31, 2),
(37, 6),
(37, 8),
(32, 6),
(32, 7),
(26, 2),
(26, 9),
(38, 6),
(39, 8),
(39, 9),
(41, 6),
(41, 8),
(42, 6),
(43, 8),
(44, 2),
(44, 7),
(48, 8),
(48, 9),
(50, 7),
(52, 2),
(52, 8),
(53, 6),
(54, 2),
(54, 6),
(55, 6),
(60, 8),
(62, 8),
(65, 7),
(57, 6),
(66, 9),
(68, 9),
(88, 6),
(88, 7),
(89, 2),
(89, 6),
(92, 2),
(92, 6),
(94, 6),
(95, 2),
(96, 9),
(40, 2),
(40, 8),
(40, 10),
(40, 11),
(61, 6),
(61, 7);

-- --------------------------------------------------------

--
-- Table structure for table `influencer_template`
--

CREATE TABLE `influencer_template` (
  `id` int(11) NOT NULL,
  `template_name` varchar(255) DEFAULT NULL,
  `influencers` text DEFAULT NULL,
  `packages` text DEFAULT NULL,
  `clients_budget` int(20) DEFAULT NULL,
  `profit_margin` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `influencer_template`
--

INSERT INTO `influencer_template` (`id`, `template_name`, `influencers`, `packages`, `clients_budget`, `profit_margin`) VALUES
(21, 'TEST 1', '[\"40\",\"73\",\"53\",\"62\",\"65\",\"66\",\"57\"]', '[\"34\"]', 40000, 15),
(22, 'time to get tilok his money', '[\"61\",\"57\",\"40\"]', NULL, 10000, 20),
(23, 'SOMETHING', '[\"53\",\"55\",\"56\",\"57\",\"61\"]', NULL, 10000, 15),
(24, 'DDDDD', '[\"53\",\"48\",\"42\",\"40\"]', NULL, 50000, 25),
(25, 'lexlaflex', '[\"61\",\"92\",\"40\",\"98\"]', NULL, 10000, 20);

-- --------------------------------------------------------

--
-- Table structure for table `influencer_wallets`
--

CREATE TABLE `influencer_wallets` (
  `influencer_id` int(10) NOT NULL,
  `wallet_id` int(10) NOT NULL,
  `wallet_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `influencer_wallets`
--

INSERT INTO `influencer_wallets` (`influencer_id`, `wallet_id`, `wallet_address`) VALUES
(22, 11, '123456765'),
(22, 12, '654321276'),
(23, 11, '12367845'),
(23, 12, '98756674'),
(24, 12, '12345678'),
(24, 11, '98765432'),
(25, 12, '4566789'),
(25, 13, '5666886'),
(26, 12, '6788080808'),
(27, 11, NULL),
(28, 11, '561456495684532143215641'),
(29, 13, '25654956468456'),
(30, 11, NULL),
(31, 11, NULL),
(32, 11, NULL),
(37, 11, NULL),
(38, 11, NULL),
(39, 12, '120'),
(39, 11, '150'),
(40, 11, '00000000000000225'),
(41, 11, NULL),
(42, 11, NULL),
(43, 11, NULL),
(44, 11, NULL),
(47, 11, NULL),
(48, 11, '50'),
(51, 11, NULL),
(54, 11, NULL),
(56, 11, NULL),
(57, 11, NULL),
(42, 13, '0000000000000022555'),
(60, 11, '2145645845451425'),
(61, 11, NULL),
(62, 11, '2545684845'),
(65, 11, NULL),
(66, 11, NULL),
(68, 11, NULL),
(88, 11, '878785'),
(88, 13, '767654'),
(89, 11, NULL),
(92, 11, NULL),
(94, 11, NULL),
(95, 11, '21561456456151564'),
(96, 11, '458624586354634'),
(97, 11, NULL),
(98, 11, NULL);

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_permission`
--

CREATE TABLE `payment_permission` (
  `role_id` int(10) NOT NULL,
  `view` tinyint(1) DEFAULT NULL,
  `edit` tinyint(1) DEFAULT NULL,
  `create` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment_permission`
--

INSERT INTO `payment_permission` (`role_id`, `view`, `edit`, `create`) VALUES
(9, 1, 1, 1),
(11, 1, 1, 1),
(6, 1, 1, 1),
(12, 1, 1, NULL),
(3, NULL, NULL, NULL),
(13, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` int(10) NOT NULL,
  `region` varchar(100) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `updated_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `region`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(6, 'ASIA', 4, '2023-03-21 05:09:54', 19, '2023-03-21 21:10:15'),
(7, 'EUROPE', 4, '2023-03-21 05:10:08', NULL, NULL),
(8, 'Nigeria', 19, '2023-03-21 21:04:17', 4, '2023-08-24 05:27:34'),
(9, 'US', 19, '2023-03-21 21:04:25', 4, '2023-07-07 03:59:48'),
(11, 'GLOBAL', 4, '2023-03-24 05:20:11', 4, '2023-07-07 03:59:00'),
(13, 'Turkey', 4, '2023-06-12 01:49:32', NULL, NULL),
(14, 'LATAM', 4, '2023-07-07 03:58:51', NULL, NULL),
(15, 'Japan', 4, '2023-08-25 21:20:53', NULL, NULL),
(16, 'France', 4, '2023-08-25 21:20:59', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Publisher', 1, '2023-03-13 13:23:39', NULL, NULL),
(2, 'User', 1, '2023-03-13 13:27:47', NULL, NULL),
(3, 'Developer', 1, '2023-03-13 13:30:41', NULL, NULL),
(6, 'Admin', 1, '2023-03-13 13:30:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

CREATE TABLE `socials` (
  `id` int(10) NOT NULL,
  `social` varchar(100) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `updated_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `socials`
--

INSERT INTO `socials` (`id`, `social`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Facebook', 19, '2023-03-16 13:45:36', NULL, NULL),
(4, 'Linkedin', 19, '2023-03-16 20:29:18', NULL, NULL),
(6, 'Twitter', 19, '2023-03-18 07:45:41', NULL, NULL),
(7, 'TikTok', 4, '2023-03-21 04:59:57', NULL, NULL),
(8, 'Youtube', 4, '2023-03-21 05:00:11', NULL, NULL),
(9, 'Instagram', 4, '2023-03-21 05:00:25', NULL, NULL),
(10, 'Medium', 4, '2023-03-21 05:00:33', NULL, NULL),
(13, 'Threads', 4, '2023-07-31 04:12:59', 4, '2023-07-31 16:58:18'),
(15, 'Telegram', 4, '2023-07-31 04:13:21', 4, '2023-07-31 04:13:28'),
(16, 'Newsletter', 4, '2023-07-31 04:13:51', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `tag` varchar(100) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `updated_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(2, 'Degen', 19, '2023-03-14 21:36:35', 4, '2023-08-25 21:20:25'),
(6, 'Vip', 3, '2023-03-19 12:31:29', 4, '2023-06-12 02:15:45'),
(7, 'Technical', 19, '2023-03-21 21:49:57', 4, '2023-06-12 02:15:31'),
(8, 'NFT COLLECTORS', 4, '2023-03-22 02:52:20', 4, '2023-05-12 06:31:28'),
(10, 'Gamers', 4, '2023-04-07 14:35:17', 4, '2023-08-24 05:27:55'),
(11, 'Educators', 4, '2023-08-24 05:28:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `plan` varchar(50) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contact`, `username`, `role`, `plan`, `email_verified_at`, `password`, `remember_token`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Sourav Das', 'imsourav6400@gmail.com', NULL, NULL, '6', NULL, NULL, '$2y$10$IbMQkEQai3Ed8oNOcyFl2.xjDgG9xMshhr4BYsZOti5xx6Q.DsMny', NULL, 1, NULL, '2023-03-12 11:47:00', 4, '2023-05-10 11:50:53'),
(4, 'Tilok Sarker', 'tilok.php@gmail.com', NULL, NULL, '6', NULL, NULL, '$2y$10$amsuRA6GzmFfRk.YlMBSS.ByNl2ZERF3uCzD0fF/uYcQ1EbBvcLYC', NULL, 1, NULL, '2023-03-13 03:53:07', 3, '2023-04-09 10:11:31'),
(24, 'Admin', 'admin@gmail.com', NULL, NULL, '6', NULL, NULL, '$2y$10$DUYG5jVXyTrScZdmDKG2qeAhV.89uq2f9Lb79y8NY2t81lWgTeS1i', NULL, 1, NULL, '2023-03-15 06:16:40', 4, '2023-07-05 04:56:26'),
(26, 'Ripa', 'ripabiswassharna@gmail.com', NULL, 'ripabiswassharna', 'Client', NULL, NULL, '$2y$10$RnDRySpCQsJx./3JaTXlq.HsVe2OV4tkJx/OtE55xIkFsDX65rCfy', NULL, 1, 4, '2023-05-04 16:00:05', NULL, NULL),
(28, 'Alex Quali', 'alex.kull@gmail.com', NULL, 'Alex', '6', NULL, NULL, '$2y$10$Npqyy4aoMSE/5SwBzj.Ls.ZRoTdZB5j6WUbPrHfUpdsfvBySClBm6', NULL, 1, 4, '2023-06-11 00:54:07', 4, '2023-07-22 11:52:30'),
(30, 'Sourav Das', 'sourav.das@w3scloud.com', NULL, NULL, 'Developer', NULL, NULL, '$2y$10$DUYG5jVXyTrScZdmDKG2qeAhV.89uq2f9Lb79y8NY2t81lWgTeS1i', NULL, 1, NULL, '2023-07-05 11:44:27', NULL, '2023-07-09 11:02:58');

-- --------------------------------------------------------

--
-- Table structure for table `user_management_permission`
--

CREATE TABLE `user_management_permission` (
  `role_id` int(10) NOT NULL,
  `view` tinyint(1) DEFAULT NULL,
  `edit` tinyint(1) DEFAULT NULL,
  `create` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_management_permission`
--

INSERT INTO `user_management_permission` (`role_id`, `view`, `edit`, `create`) VALUES
(9, 1, 1, 1),
(11, NULL, NULL, NULL),
(6, 1, 1, 1),
(12, 1, 1, NULL),
(3, NULL, NULL, NULL),
(13, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` int(10) NOT NULL,
  `wallet_type` varchar(100) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `updated_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `wallet_type`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(11, 'TRC 20', 4, '2023-03-18 06:03:02', NULL, NULL),
(12, 'ERC 20', 4, '2023-03-21 04:58:47', NULL, NULL),
(13, 'BTC', 4, '2023-03-21 04:58:55', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_best_post`
--
ALTER TABLE `campaign_best_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_featured_article`
--
ALTER TABLE `campaign_featured_article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_featured_video`
--
ALTER TABLE `campaign_featured_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_influencer`
--
ALTER TABLE `campaign_influencer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `ifluencer_package_content`
--
ALTER TABLE `ifluencer_package_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ifluencer_template_content`
--
ALTER TABLE `ifluencer_template_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `influencer`
--
ALTER TABLE `influencer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `influencer_contents`
--
ALTER TABLE `influencer_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `influencer_package`
--
ALTER TABLE `influencer_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `influencer_template`
--
ALTER TABLE `influencer_template`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by_const` (`created_by`),
  ADD KEY `updated_by_const` (`updated_by`);

--
-- Indexes for table `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `campaign_best_post`
--
ALTER TABLE `campaign_best_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `campaign_featured_article`
--
ALTER TABLE `campaign_featured_article`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `campaign_featured_video`
--
ALTER TABLE `campaign_featured_video`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `campaign_influencer`
--
ALTER TABLE `campaign_influencer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ifluencer_package_content`
--
ALTER TABLE `ifluencer_package_content`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `ifluencer_template_content`
--
ALTER TABLE `ifluencer_template_content`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `influencer`
--
ALTER TABLE `influencer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `influencer_contents`
--
ALTER TABLE `influencer_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `influencer_package`
--
ALTER TABLE `influencer_package`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `influencer_template`
--
ALTER TABLE `influencer_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `socials`
--
ALTER TABLE `socials`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `created_by_const` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `updated_by_const` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
