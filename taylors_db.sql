-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2026 at 11:10 PM
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
-- Database: `taylors_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `album_id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `release_year` year(4) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`album_id`, `title`, `release_year`, `description`, `cover_image`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'Taylor Swift', '2006', '2006 Era. Taylor\'s self-titled debut album launched her country music career. A blend of teenage heartbreak and small-town storytelling.', 'img/taylorswift2006.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(2, 'Fearless', '2008', '2008 Era. Her sophomore album blended country and pop, earning her the Grammy for Album of the Year and launching her into superstardom.', 'img/fearless.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(3, 'Speak Now', '2010', '2010 Era. Entirely self-written, this album showcased Taylor\'s songwriting maturity with dramatic ballads and bold storytelling.', 'img/speaknow.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(4, 'Red', '2012', '2012 Era. A genre-blending masterpiece mixing country, pop, rock, and dubstep. Widely regarded as one of her most emotionally raw albums.', 'img/red.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(5, '1989', '2014', '2014 Era. Taylor\'s official pop crossover. A synth-pop record inspired by the 1980s that became one of the best-selling albums of the decade.', 'img/1989.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(6, 'Reputation', '2017', '2017 Era. A dark, hip-hop-influenced record exploring themes of media scrutiny, betrayal, and new love. Her most theatrical era.', 'img/reputation.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(7, 'Lover', '2019', '2019 Era. A bright, colorful pop record celebrating love and identity. Features some of her most upbeat and optimistic songwriting.', 'img/lover.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(8, 'Folklore', '2020', '2020 Era. An indie-folk surprise album recorded during the pandemic. Universally acclaimed as one of the greatest albums of the 2020s.', 'img/folklore.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(9, 'Evermore', '2020', '2020 Era. A sister album to Folklore, released just months later. Continues the indie-folk aesthetic with even more introspective storytelling.', 'img/evermore.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(10, 'Midnights', '2022', '2022 Era. A synth-pop record about sleepless nights and self-reflection. Broke multiple streaming records on release night.', 'img/midnights.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(11, 'TTPD', '2024', '2024 Era. The Tortured Poets Department — a double album exploring themes of heartbreak, obsession, and artistic identity. Her longest album to date.', 'img/ttpd.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(12, 'Showgirl', '2025', '2025 Era. Taylor\'s most theatrical record yet, drawing inspiration from old Hollywood, cabaret, and dramatic pop. A bold reinvention.', 'img/showgirl.webp', '2026-05-31 00:53:58', '2026-05-31 20:36:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE `awards` (
  `award_id` int(11) NOT NULL,
  `award_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `awards`
--

INSERT INTO `awards` (`award_id`, `award_name`, `description`, `image`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'GRAMMYS', '14-time Grammy winner and the first artist to win Album of the Year four times (Fearless, 1989, Folklore, Midnights). Also holds the record for most AOTY wins in history.', 'img/grammys.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(2, 'AMA', '40 trophies total at the American Music Awards — the most of any artist in history. She also holds the record for most Artist of the Year wins.', 'img/ama.webp', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(3, 'BILLBOARD', '39 total Billboard Music Award wins with chart dominance spanning multiple genres. Multiple entries on the Hot 100 simultaneously, a feat few artists have achieved.', 'img/billboards.webp', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(4, 'VMA\'s', '23 MTV Video Music Award Moonperson trophies including multiple Video of the Year wins. One of the most decorated artists in VMA history.', 'img/vma.webp', '2026-05-31 00:53:58', '2026-05-31 20:47:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_info`
--

CREATE TABLE `personal_info` (
  `info_id` int(11) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_info`
--

INSERT INTO `personal_info` (`info_id`, `category`, `title`, `description`, `image`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'Childhood', 'Childhood', 'Taylor Swift was born on December 13, 1989, in West Reading, Pennsylvania. She grew up in Wyomissing, PA, and began performing in musical theater at age 9. Her passion for country music led her family to move to Nashville, Tennessee when she was 14 to pursue a music career.', 'img/taylor4.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(2, 'Education', 'Education', 'Taylor graduated from Hendersonville High School one year early — at age 16 — to focus on her rapidly growing music career. Despite leaving traditional school early, she has consistently emphasized the importance of education and literacy, donating millions to schools and libraries across the U.S.', 'img/taylor5.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(3, 'Career', 'Career', 'From Nashville to global superstardom, Taylor redefined the music industry. She signed with Big Machine Records at 14, released her self-titled debut at 16, and has since released 11 studio albums spanning country, pop, folk, and alternative genres. She is the first artist to win the Grammy Album of the Year four times.', 'img/taylor6.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(4, 'Acting', 'Acting', 'Taylor has appeared in several films and TV projects including Valentine\'s Day (2010), The Giver (2014), and Cats (2019). She also starred as Bombalurina in Cats and voiced a character in The Lorax. Her acting roles, while secondary to her music career, have shown her versatility as a performer.', 'img/taylor7.webp', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(5, 'Relationships', 'Relationships', 'Taylor\'s personal life has been widely covered by the media. She has been in several high-profile relationships over the years. As of 2025, she is in a relationship with NFL superstar Travis Kelce, tight end for the Kansas City Chiefs, whom she began dating in 2023.', 'img/taylor8.jpg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(6, 'Facts', 'Fun Facts', 'Taylor Swift is the first artist to win Album of the Year four times at the Grammy Awards. She has broken numerous Spotify and Apple Music streaming records, and her Eras Tour became the highest-grossing concert tour in history, surpassing $1 billion in revenue. She was also named TIME Magazine\'s Person of the Year 2023.', 'img/taylor9.webp', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `song_id` int(11) NOT NULL,
  `album_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `youtube_id` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`song_id`, `album_id`, `title`, `youtube_id`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 1, 'Tim McGraw', 'lEehaxN0TXw', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(2, 1, 'Teardrops On My Guitar', 'lEehaxN0TXw', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(3, 1, 'Our Song', '4v1Eez7ECU4', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(4, 1, 'Picture to Burn', '15a_L2ybl2Y', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(5, 1, 'Should\'ve Said No', 'dUisZV--Nbs', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(6, 1, 'Mary\'s Song', 'VfVuptgjeU', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(7, 1, 'Cold as You', 'SoXPvCcFibo', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(8, 1, 'The Outside', 'L4hOi4KvRY0', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(9, 1, 'Stay Beautiful', '6BOPfGQLUH8', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(10, 1, 'Tied Together with a Smile', 'aCVHGH5sO0c', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(11, 2, 'Love Story', '8xg3vE8Ie_E', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(12, 2, 'You Belong With Me', 'VuNIsY6JdUw', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(13, 2, 'Fifteen', 'Pb-K2tXWK4w', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(14, 2, 'White Horse', 'D1Xr-JFLxik', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(15, 2, 'Fearless', 'eVNNfmr_vWI', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(16, 2, 'Breathe', 'eVNNfmr_vWI', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(17, 2, 'The Best Day', 'eVNNfmr_vWI', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(18, 2, 'You\'re Not Sorry', 'eVNNfmr_vWI', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(19, 2, 'Tell Me Why', 'eVNNfmr_vWI', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(20, 2, 'Mr. Perfectly Fine', 'eVNNfmr_vWI', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(21, 3, 'Mine', 'XPBwXKgDTdE', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(22, 3, 'Back To December', 'oOEhHDx6xOQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(23, 3, 'Mean', 'oOEhHDx6xOQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(24, 3, 'The Story Of Us', 'oOEhHDx6xOQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(25, 3, 'Sparks Fly', 'oOEhHDx6xOQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(26, 3, 'Enchanted', 'oOEhHDx6xOQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(27, 3, 'Better Than Revenge', 'oOEhHDx6xOQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(28, 3, 'Dear John', 'oOEhHDx6xOQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(29, 3, 'Ours', 'oOEhHDx6xOQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(30, 3, 'Long Live', 'oOEhHDx6xOQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(31, 4, 'All Too Well', 'rX9GLnJ06F4', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(32, 4, '22', 'AgFeZr5ptV8', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(33, 4, 'I Knew You Were Trouble', 'vNoKguSdy4Y', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(34, 4, 'Red', 'Zlot0i3Zykw', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(35, 4, 'Begin Again', 'bVcxtHhyfZQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(36, 4, 'Everything Has Changed', 'SWQwtE9N5aU', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(37, 4, 'State of Grace', 'gr4cqcqnAN0', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(38, 4, 'Holy Ground', 'NA90OVe2ixo', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(39, 4, 'Treacherous', 'OE2RVmaioAo', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(40, 4, 'Nothing New', 'EsiqARpjOBQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(41, 5, 'Shake It Off', 'nfWlot6h_JM', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(42, 5, 'Blank Space', 'e-ORhEE9VVg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(43, 5, 'Style', '-CmadmM5cOk', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(44, 5, 'Bad Blood', 'QcIy9NiNbmo', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(45, 5, 'Wildest Dreams', 'IdneKLhsWOQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(46, 5, 'Out Of The Woods', 'JLf9q36UsBk', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(47, 5, 'Clean', 'AppsjTInqiw', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(48, 5, 'New Romantics', 'wyK7YuwUWsU', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(49, 5, 'This Love', 'mvxQYPR4lmU', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(50, 5, 'Is It Over Now?', 'vNoKguSdy4Y', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(51, 6, 'LWYMMD', '3tmd-ClpJxA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(52, 6, 'Delicate', 'tCXGJQYZ9JA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(53, 6, '...Ready For It?', 'wIft-t-MQuE', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(54, 6, 'End Game', 'dfnCAmr569k', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(55, 6, 'Gorgeous', 'tCXGJQYZ9JA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(56, 6, 'Getaway Car', 'tCXGJQYZ9JA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(57, 6, 'Call It What You Want', 'tCXGJQYZ9JA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(58, 6, 'Don\'t Blame Me', 'tCXGJQYZ9JA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(59, 6, 'I Did Something Bad', 'tCXGJQYZ9JA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(60, 6, 'New Year\'s Day', 'KkvTYrFIxNM', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(61, 7, 'Cruel Summer', 'ic8j13piAhQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(62, 7, 'Lover', '-BjZmE2gtdo', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(63, 7, 'The Man', 'AqAJLh9wuZ0', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(64, 7, 'You Need To Calm Down', '1wgr1Bjxs7E', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(65, 7, 'ME!', 'FuXNumBwDOM', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(66, 7, 'The Archer', '3sAdg1N-byw', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(67, 7, 'Paper Rings', 'a3FVEgsi5ag', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(68, 7, 'Cornelia Street', 'bqJ9I-3MG1g', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(69, 7, 'Death By A Thousand', 'KNp1yY9s5dc', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(70, 7, 'Miss Americana', '2B9fBFtBXhU', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(71, 8, 'cardigan', 'M_lVZIpgnjU', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(72, 8, 'the 1', '_yHn-954iVQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(73, 8, 'exile', 'Nm08yUg38tE', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(74, 8, 'august', '92jy750yv00', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(75, 8, 'betty', 'gtzCuhDTRzk', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(76, 8, 'mirrorball', 'UupJ9yX3_Bg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(77, 8, 'seven', 'llshN1pcGoY', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(78, 8, 'invisible string', 'CQ_dWZG5RJU', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(79, 8, 'my tears ricochet', 'CsiVvkzCdSI', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(80, 8, 'epiphany', 'M_lVZIpgnjU', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(81, 9, 'willow', 'RsEZmictANA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(82, 9, 'champagne problems', 'wMpqCRF7TKg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(83, 9, 'gold rush', 'RsEZmictANA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(84, 9, 'no body, no crime', 'RsEZmictANA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(85, 9, 'tolerate it', 'RsEZmictANA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(86, 9, 'ivy', 'RsEZmictANA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(87, 9, 'cowboy like me', 'RsEZmictANA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(88, 9, 'long story short', 'RsEZmictANA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(89, 9, 'marjorie', 'RsEZmictANA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(90, 9, 'evermore', 'RsEZmictANA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(91, 10, 'Anti-Hero', 'gGwN25z7FrE', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(92, 10, 'Bejeweled', 'ywUqTGWU7ec', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(93, 10, 'Karma', 'pzVYSfzNQ5Y', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(94, 10, 'Lavender Haze', 'GwNPBeWpI-0', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(95, 10, 'Maroon', 'IHMySdortig', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(96, 10, 'Snow On The Beach', '_p0jeMjTccw', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(97, 10, 'You\'re On Your Own, Kid', 'fKgoo_KT6aM', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(98, 10, 'Midnight Rain', 'EL72UcDZLSk', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(99, 10, 'Vigilante Shit', 'mnCmHleqQGk', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(100, 10, 'Mastermind', 'teos2yMvkEA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(101, 11, 'Fortnight', 'q3zqJs7JUCQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(102, 11, 'I Can Do It With a Broken Heart', 'i8_w_m6HLJ0', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(103, 11, 'Down Bad', 'EVbtjaWXQVg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(104, 11, 'But Daddy I Love Him', 'U2W173hRfyA', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(105, 11, 'Florida!!!', 'uEssK8o3jKg', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(106, 11, 'Guilty as Sin?', 'OOYlWF6V8t8', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(107, 11, 'Who\'s Afraid of Little Old Me?', 'vOZFiX6hDXQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(108, 11, 'So Long, London', 'CCUr2pNJft4', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(109, 11, 'The Alchemy', 'iMMUAd66vxo', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(110, 11, 'The Manuscript', 'iY6Qhlua8Zw', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(111, 12, 'The Fate of Ophelia', 'ko70cExuzZM', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(112, 12, 'The Life of a Showgirl', 'slUhVTAznMo', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(113, 12, 'Elizabeth Taylor', 'slUhVTAznMo', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(114, 12, 'Father Figure', 'b3hW8c9mmLQ', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(115, 12, 'Cancelled!', 'F-5XoUZ42Tc', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(116, 12, 'Eldest Daughter', 'rhzMYDvgG2U', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(117, 12, 'Ruin The Friendship', 'f5ZAXAxHqog', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(118, 12, 'Honey', '9Sx8MWI8qTU', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(119, 12, 'Wi$h Li$t', 'mC54kTYa9oI', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(120, 12, 'The Manuscript', 'iY6Qhlua8Zw', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `tour_id` int(11) NOT NULL,
  `tour_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `total_sales` varchar(50) DEFAULT NULL,
  `attendance` varchar(50) DEFAULT NULL,
  `songs_count` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`tour_id`, `tour_name`, `description`, `image`, `total_sales`, `attendance`, `songs_count`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'Fearless Tour', 'The fairytale-themed tour that captured hearts worldwide. Taylor\'s first major headlining tour, performed across North America and international markets.', 'img/Fearless1.webp', '63700000.00', '1100000', '15', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(2, 'Speak Now Tour', 'An enchanting, self-produced theatrical production. Every song was written solely by Taylor, showcasing her as one of music\'s premier songwriters.', 'img/speaknow1.webp', '123700000.00', '1600000', '17', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(3, 'The Red Tour', 'The bold transition to pop. Featuring elaborate set pieces and costume changes, this tour marked Taylor\'s evolution from country to mainstream pop.', 'img/red1.jpg', '150200000.00', '1700000', '18', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(4, '1989 World Tour', 'The ultimate pop rebirth. Named after her landmark pop album, this stadium tour cemented Taylor as one of the world\'s biggest pop stars.', 'img/19892.jpg', '250700000.00', '2200000', '18', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(5, 'Reputation Tour', 'A massive stadium spectacle featuring elaborate snake imagery, pyrotechnics, and a bold visual identity exploring themes of media and persona.', 'img/reputation1.jpg', '345700000.00', '2800000', '19', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL),
(6, 'The Eras Tour', 'The biggest concert tour in history. A nearly 4-hour journey through all of Taylor\'s musical eras, breaking records for attendance and revenue worldwide.', 'img/erastour1.jpg', '1000000000.00', '4300000', '44', '2026-05-31 00:53:58', '2026-05-31 00:53:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'rojan', 'jeysebel212006', 'admin', '2026-05-30 18:43:24', '2026-05-30 18:43:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`award_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `personal_info`
--
ALTER TABLE `personal_info`
  ADD PRIMARY KEY (`info_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`song_id`),
  ADD KEY `album_id` (`album_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`tour_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `award_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_info`
--
ALTER TABLE `personal_info`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `song_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `tour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `awards`
--
ALTER TABLE `awards`
  ADD CONSTRAINT `awards_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `personal_info`
--
ALTER TABLE `personal_info`
  ADD CONSTRAINT `personal_info_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `songs_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`album_id`),
  ADD CONSTRAINT `songs_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
