-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 03 Nis 2026, 10:50:37
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `aether_lumen`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `image_gallery` text DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_gallery` text DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `seo_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `blogs`
--

INSERT INTO `blogs` (`id`, `status`, `order`, `slug`, `title`, `subtitle`, `excerpt`, `description`, `content`, `icon`, `image`, `image_url`, `image_gallery`, `video`, `video_url`, `video_gallery`, `banner`, `banner_url`, `meta_title`, `meta_description`, `seo_text`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'blog-test-1', 'Blog Test 1', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-26 05:58:47', '2026-03-27 14:51:56'),
(2, 1, 3, 'blog-test-2', 'Blog Test 2', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-26 05:58:52', '2026-03-27 14:51:56'),
(3, 1, 4, 'blog-test-3', 'Blog Test 3', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-26 05:58:56', '2026-03-27 14:51:56'),
(4, 0, 1, 'test', 'test', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-27 14:49:09', '2026-03-31 14:47:53');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `brands`
--

INSERT INTO `brands` (`id`, `status`, `order`, `name`, `image`, `image_url`, `url`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Marka Test 1', '[]', NULL, NULL, '2026-04-01 12:18:39', '2026-04-01 12:35:37'),
(2, 1, 0, 'Marka Test 2', '[]', NULL, NULL, '2026-04-01 12:18:50', '2026-04-01 12:32:28'),
(3, 1, 0, 'Marka Test 3', '[]', NULL, NULL, '2026-04-01 12:19:06', '2026-04-01 12:19:06');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `image_gallery` text DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_gallery` text DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `seo_text` text DEFAULT NULL,
  `_lft` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `_rgt` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`id`, `status`, `order`, `slug`, `name`, `excerpt`, `description`, `content`, `icon`, `image`, `image_url`, `image_gallery`, `video`, `video_url`, `video_gallery`, `banner`, `banner_url`, `meta_title`, `meta_description`, `seo_text`, `_lft`, `_rgt`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'ana-kategori-1', 'Ana Kategori 1', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', 1, 8, NULL, '2026-03-27 08:15:16', '2026-03-27 14:51:23'),
(2, 1, 3, 'ana-kategori-2', 'Ana Kategori 2', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', 9, 10, NULL, '2026-03-27 08:15:32', '2026-03-27 14:51:23'),
(3, 1, 4, 'ana-kategori-3', 'Ana Kategori 3', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', 11, 12, NULL, '2026-03-27 08:15:53', '2026-03-27 14:51:23'),
(4, 1, 5, 'kategori-seviye-2', 'Kategori Seviye 2', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', 2, 7, 1, '2026-03-27 08:17:36', '2026-03-27 14:51:23'),
(5, 1, 6, 'kategori-seviye-3', 'Kategori Seviye 3', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', 3, 6, 4, '2026-03-27 08:18:00', '2026-03-27 14:51:23'),
(6, 1, 7, 'kategori-seviye-4', 'Kategori Seviye 4', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', 4, 5, 5, '2026-03-27 08:18:23', '2026-03-27 14:51:24'),
(8, 0, 1, 'test', 'test', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', 13, 14, NULL, '2026-03-27 14:49:38', '2026-03-27 14:51:30');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `certificates`
--

CREATE TABLE `certificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `received_at` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `certificates`
--

INSERT INTO `certificates` (`id`, `status`, `order`, `title`, `organization`, `received_at`, `description`, `image`, `image_url`, `file`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Sertifika Test 1', '', '2026-03-26 07:45:00', '', 'certificates\\March2026\\mevzRiaXVPMX0TOiBjtZ.webp', NULL, '[{\"download_link\":\"certificates\\\\March2026\\\\WxDPdRcs3W9vdqe0g2fx.pdf\",\"original_name\":\"demo-pdf.pdf\"}]', '2026-03-26 04:47:49', '2026-03-26 04:51:43'),
(2, 1, 0, 'Sertifika Test 2', '', '2026-03-26 07:48:00', '', 'certificates\\March2026\\TynP6kcfBC11gFbZF985.webp', NULL, '[{\"download_link\":\"certificates\\\\March2026\\\\wgI5VOgBtl9wIvwXeaPf.pdf\",\"original_name\":\"demo-pdf.pdf\"}]', '2026-03-26 04:48:17', '2026-03-26 04:51:51'),
(3, 1, 0, 'Sertifika Test 3', '', '2026-03-26 07:48:00', '', 'certificates\\March2026\\l6vm2eyr0CZrtK1l9YRb.webp', NULL, '[{\"download_link\":\"certificates\\\\March2026\\\\X6YD5JrwwOGTQr3bKBwd.pdf\",\"original_name\":\"demo-pdf.pdf\"}]', '2026-03-26 04:48:38', '2026-03-26 04:52:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `surname`, `email`, `phone`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(4, 'Abel Rodriquez', 'Zamora', 'qanaj@mailinator.com', '+1 (973) 961-6284', 'Eu sed labore quo de', 'Consequatur Quia vo', '2026-03-27 05:02:16', '2026-03-27 05:02:16'),
(5, 'Sandra Jefferson', 'Matthews', 'loqaq@mailinator.com', '+1 (912) 385-2829', 'Aute irure ad sunt e', 'Vitae hic nisi reici', '2026-03-27 08:06:22', '2026-03-27 08:06:22'),
(6, 'Quentin Sawyer', 'Simon', 'zegyluj@mailinator.com', '+1 (885) 897-8927', 'Et aut consequatur', 'Tempor reiciendis ve', '2026-04-01 14:13:23', '2026-04-01 14:13:23'),
(7, 'Anika Sawyer', 'Mcdaniel', 'qiqovoz@mailinator.com', '+1 (184) 319-2428', 'Quis maxime dicta qu', 'Dolor tempor perspic', '2026-04-01 14:15:16', '2026-04-01 14:15:16'),
(8, 'Kenyon Figueroa', 'Delgado', 'beqe@mailinator.com', '+1 (996) 716-7605', 'Animi et similique', 'Totam quis consequun', '2026-04-01 14:32:10', '2026-04-01 14:32:10'),
(9, 'Clio Burris', 'Sexton', 'wabu@mailinator.com', '+1 (819) 112-9663', 'Est hic ipsum vitae', 'Consequuntur suscipi', '2026-04-01 14:43:13', '2026-04-01 14:43:13');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `counters`
--

CREATE TABLE `counters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `percentage` tinyint(3) UNSIGNED DEFAULT 80,
  `icon` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `counters`
--

INSERT INTO `counters` (`id`, `status`, `order`, `title`, `value`, `percentage`, `icon`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Sayaç Test 1', '45', 75, 'alarm', '2026-03-25 05:26:22', '2026-03-25 05:53:35'),
(2, 1, 0, 'Sayaç Test 2', '85', 65, 'user-group', '2026-03-25 05:27:11', '2026-03-25 05:29:10'),
(3, 1, 0, 'Sayaç Test 3', '500', 95, 'chart', '2026-03-25 05:28:33', '2026-03-25 05:28:33'),
(4, 1, 0, 'Sayaç Test 4', '250', 80, 'share', '2026-03-25 05:30:25', '2026-03-25 05:30:25');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `data_rows`
--

CREATE TABLE `data_rows` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_type_id` int(10) UNSIGNED NOT NULL,
  `field` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `browse` tinyint(1) NOT NULL DEFAULT 1,
  `read` tinyint(1) NOT NULL DEFAULT 1,
  `edit` tinyint(1) NOT NULL DEFAULT 1,
  `add` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 1,
  `details` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `data_rows`
--

INSERT INTO `data_rows` (`id`, `data_type_id`, `field`, `type`, `display_name`, `required`, `browse`, `read`, `edit`, `add`, `delete`, `details`, `order`) VALUES
(1, 1, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, '{}', 1),
(2, 1, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 2),
(3, 1, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, '{}', 3),
(4, 1, 'password', 'password', 'Password', 1, 0, 0, 1, 1, 0, '{}', 4),
(5, 1, 'remember_token', 'text', 'Remember Token', 0, 0, 0, 0, 0, 0, '{}', 5),
(6, 1, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, '{}', 6),
(7, 1, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 7),
(8, 1, 'avatar', 'image', 'Avatar', 0, 1, 1, 1, 1, 1, '{}', 8),
(9, 1, 'user_belongsto_role_relationship', 'relationship', 'Role', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"roles\",\"pivot\":\"0\",\"taggable\":\"0\"}', 10),
(10, 1, 'user_belongstomany_role_relationship', 'relationship', 'Roles', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"user_roles\",\"pivot\":\"1\",\"taggable\":\"0\"}', 11),
(11, 1, 'settings', 'hidden', 'Settings', 0, 0, 0, 0, 0, 0, '{}', 12),
(12, 2, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, '{}', 1),
(13, 2, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 2),
(14, 2, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, '{}', 3),
(15, 2, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 4),
(16, 3, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, '{}', 1),
(17, 3, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 2),
(18, 3, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, '{}', 3),
(19, 3, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 4),
(20, 3, 'display_name', 'text', 'Display Name', 1, 1, 1, 1, 1, 1, '{}', 5),
(21, 1, 'role_id', 'text', 'Role', 0, 1, 1, 1, 1, 1, '{}', 9),
(22, 5, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(23, 5, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 5),
(24, 5, 'order', 'number', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 2),
(25, 5, 'slug', 'text', 'URL', 0, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\",\"forceUpdate\":true}}', 10),
(26, 5, 'is_homepage', 'checkbox', 'Ana Sayfa', 1, 0, 1, 1, 1, 1, '{\"on\":\"Evet\",\"off\":\"Hay\\u0131r\"}', 8),
(27, 5, 'menu_show', 'checkbox', 'Menü', 1, 1, 1, 1, 1, 1, '{\"on\":\"G\\u00f6ster\",\"off\":\"Gizle\"}', 6),
(28, 5, 'blade_name', 'text', 'Blade Name (Yazılım)', 0, 1, 1, 1, 1, 1, '{}', 9),
(29, 5, 'title', 'text', 'Başlık', 1, 1, 1, 1, 1, 1, '{}', 11),
(30, 5, 'subtitle', 'text', 'Alt Başlık', 0, 0, 1, 1, 1, 1, '{}', 12),
(31, 5, 'content', 'rich_text_box', 'İçerik', 0, 0, 1, 1, 1, 1, '{}', 15),
(32, 5, 'image', 'image', 'Resim', 0, 0, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 21),
(33, 5, 'meta_title', 'text', 'Meta Title', 0, 0, 1, 1, 1, 1, '{}', 16),
(34, 5, 'meta_description', 'text_area', 'Meta Description', 0, 0, 1, 1, 1, 1, '{}', 17),
(35, 5, 'seo_text', 'rich_text_box', 'Seo Text', 0, 0, 1, 1, 1, 1, '{}', 18),
(36, 5, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 30),
(37, 5, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 31),
(38, 5, 'parent_id', 'text', 'Üst Sayfa', 0, 1, 1, 1, 1, 1, '{}', 3),
(39, 6, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(40, 6, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 5),
(41, 6, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 2),
(42, 6, 'name', 'text', 'Kategori Adı', 1, 1, 1, 1, 1, 1, '{}', 7),
(43, 6, 'slug', 'text', 'URL', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\",\"forceUpdate\":true}}', 6),
(44, 6, 'description', 'rich_text_box', 'Açıklama', 0, 0, 1, 1, 1, 1, '{}', 9),
(45, 6, 'meta_title', 'text', 'Meta Title', 0, 0, 1, 1, 1, 1, '{}', 11),
(46, 6, 'meta_description', 'text_area', 'Meta Description', 0, 0, 1, 1, 1, 1, '{}', 12),
(47, 6, 'seo_text', 'rich_text_box', 'Seo Text', 0, 0, 1, 1, 1, 1, '{}', 13),
(48, 6, '_lft', 'text', 'Lft', 1, 0, 0, 0, 0, 0, '{}', 26),
(49, 6, '_rgt', 'text', 'Rgt', 1, 0, 0, 0, 0, 0, '{}', 27),
(50, 6, 'parent_id', 'text', 'Üst Kategori', 0, 1, 1, 1, 1, 1, '{}', 3),
(51, 6, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 24),
(52, 6, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 25),
(53, 6, 'category_belongsto_category_relationship', 'relationship', 'Üst Kategori', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Models\\\\Category\",\"table\":\"categories\",\"type\":\"belongsTo\",\"column\":\"parent_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"categories\",\"pivot\":\"0\",\"taggable\":\"0\"}', 4),
(54, 7, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(55, 7, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 5),
(56, 7, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 2),
(57, 7, 'slug', 'text', 'URL', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\",\"forceUpdate\":true}}', 6),
(58, 7, 'name', 'text', 'Ürün Adı', 1, 1, 1, 1, 1, 1, '{}', 7),
(59, 7, 'description', 'rich_text_box', 'Açıklama', 0, 0, 1, 1, 1, 1, '{}', 9),
(60, 7, 'image', 'image', 'Resim', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 21),
(61, 7, 'meta_title', 'text', 'Meta Title', 0, 0, 1, 1, 1, 1, '{}', 12),
(62, 7, 'meta_description', 'text_area', 'Meta Description', 0, 0, 1, 1, 1, 1, '{}', 13),
(63, 7, 'seo_text', 'rich_text_box', 'Seo Text', 0, 0, 1, 1, 1, 1, '{}', 14),
(64, 7, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 29),
(65, 7, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 30),
(66, 7, 'category_id', 'text', 'Kategori', 0, 1, 1, 1, 1, 1, '{}', 3),
(67, 7, 'product_belongsto_category_relationship', 'relationship', 'Kategori', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Models\\\\Category\",\"table\":\"categories\",\"type\":\"belongsTo\",\"column\":\"category_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"categories\",\"pivot\":\"0\",\"taggable\":\"0\"}', 4),
(74, 9, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(75, 9, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 3),
(76, 9, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 2),
(77, 9, 'title', 'text_area', 'Başlık', 1, 1, 1, 1, 1, 1, '{}', 4),
(78, 9, 'subtitle', 'text_area', 'Alt Başlık', 0, 0, 1, 1, 1, 1, '{}', 5),
(82, 9, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 17),
(83, 9, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 18),
(84, 5, 'page_belongsto_page_relationship', 'relationship', 'Üst Sayfa', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Models\\\\Page\",\"table\":\"pages\",\"type\":\"belongsTo\",\"column\":\"parent_id\",\"key\":\"id\",\"label\":\"title\",\"pivot_table\":\"categories\",\"pivot\":\"0\",\"taggable\":\"0\"}', 4),
(86, 11, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(87, 11, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 3),
(88, 11, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 2),
(89, 11, 'title', 'text', 'Sayaç Başlığı', 1, 1, 1, 1, 1, 1, '{}', 4),
(91, 11, 'value', 'text', 'Sayaç Değeri (sayı)', 1, 1, 1, 1, 1, 1, '{}', 5),
(92, 11, 'percentage', 'number', 'Yüzdelik Değer', 0, 0, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"numeric|min:0|max:100\"},\"min\":0,\"max\":100,\"step\":1}', 6),
(93, 11, 'icon', 'text', 'İkon', 0, 1, 1, 1, 1, 1, '{}', 7),
(95, 11, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 9),
(96, 11, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 10),
(97, 5, 'menu_data_source', 'text', 'Menu Data Source (Yazılım)', 0, 0, 1, 1, 1, 1, '{}', 29),
(98, 6, 'image', 'image', 'Resim', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 16),
(99, 5, 'excerpt', 'text_area', 'Kısa Açıklama (özet)', 0, 1, 1, 1, 1, 1, '{}', 13),
(100, 5, 'description', 'rich_text_box', 'Açıklama', 0, 0, 1, 1, 1, 1, '{}', 14),
(102, 5, 'icon', 'text', 'İkon', 0, 0, 1, 1, 1, 1, '{}', 19),
(103, 5, 'image_url', 'text', 'Resim URL', 0, 0, 1, 1, 1, 1, '{}', 20),
(106, 5, 'video', 'file', 'Video', 0, 0, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 23),
(107, 5, 'video_url', 'text', 'Video URL', 0, 0, 1, 1, 1, 1, '{}', 22),
(108, 5, 'image_gallery', 'multiple_images', 'Resim Galerisi', 0, 0, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 26),
(109, 5, 'video_gallery', 'file', 'Video Galerisi', 0, 0, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 27),
(110, 5, 'banner', 'image', 'Banner', 0, 0, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 25),
(111, 5, 'banner_url', 'text', 'Banner URL', 0, 0, 1, 1, 1, 1, '{}', 24),
(112, 12, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(113, 12, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 2),
(115, 12, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 3),
(116, 12, 'slug', 'text', 'URL', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\",\"forceUpdate\":true}}', 4),
(117, 12, 'title', 'text', 'Başlık', 1, 1, 1, 1, 1, 1, '{}', 5),
(118, 12, 'excerpt', 'text_area', 'Kısa Açıklama (özet)', 0, 1, 1, 1, 1, 1, '{}', 7),
(119, 12, 'description', 'rich_text_box', 'Açıklama', 0, 0, 1, 1, 1, 1, '{}', 8),
(120, 12, 'content', 'rich_text_box', 'İçerik', 0, 0, 1, 1, 1, 1, '{}', 9),
(122, 12, 'icon', 'text', 'İkon', 0, 0, 1, 1, 1, 1, '{}', 11),
(123, 12, 'image', 'image', 'Resim', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 13),
(124, 12, 'image_url', 'text', 'Resim URL', 0, 0, 1, 1, 1, 1, '{}', 12),
(125, 12, 'image_gallery', 'multiple_images', 'Resim Galerisi', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 18),
(126, 12, 'video', 'file', 'Video', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 15),
(127, 12, 'video_url', 'text', 'Video URL', 0, 0, 1, 1, 1, 1, '{}', 14),
(128, 12, 'video_gallery', 'file', 'Video Galerisi', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 19),
(129, 12, 'banner', 'image', 'Banner', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 17),
(130, 12, 'banner_url', 'text', 'Banner URL', 0, 0, 1, 1, 1, 1, '{}', 16),
(131, 12, 'meta_title', 'text', 'Meta Title', 0, 0, 1, 1, 1, 1, '{}', 20),
(132, 12, 'meta_description', 'text_area', 'Meta Description', 0, 0, 1, 1, 1, 1, '{}', 21),
(133, 12, 'seo_text', 'rich_text_box', 'Seo Text', 0, 0, 1, 1, 1, 1, '{}', 22),
(134, 12, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 23),
(135, 12, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 24),
(136, 13, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(137, 13, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 2),
(138, 13, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 3),
(139, 13, 'title', 'text', 'Başlık', 1, 1, 1, 1, 1, 1, '{}', 4),
(140, 13, 'organization', 'text', 'Organizasyon', 0, 1, 1, 1, 1, 1, '{}', 5),
(141, 13, 'received_at', 'timestamp', 'Veriliş Tarihi', 0, 1, 1, 1, 1, 1, '{}', 6),
(142, 13, 'description', 'text_area', 'Açıklama', 0, 0, 1, 1, 1, 1, '{}', 7),
(143, 13, 'image', 'image', 'Resim', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 9),
(144, 13, 'image_url', 'text', 'Resim URL', 0, 0, 1, 1, 1, 1, '{}', 8),
(145, 13, 'file', 'file', 'Sertifika Dosyası', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimetypes:application\\/pdf\"}}', 10),
(147, 13, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 11),
(148, 13, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 12),
(149, 14, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(150, 14, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 2),
(152, 14, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 3),
(153, 14, 'slug', 'text', 'URL', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\",\"forceUpdate\":true}}', 4),
(154, 14, 'title', 'text', 'Başlık', 1, 1, 1, 1, 1, 1, '{}', 5),
(155, 14, 'excerpt', 'text_area', 'Kısa Açıklama (özet)', 0, 1, 1, 1, 1, 1, '{}', 7),
(156, 14, 'description', 'rich_text_box', 'Açıklama', 0, 0, 1, 1, 1, 1, '{}', 8),
(157, 14, 'content', 'rich_text_box', 'İçerik', 0, 0, 1, 1, 1, 1, '{}', 9),
(159, 14, 'icon', 'text', 'İkon', 0, 0, 1, 1, 1, 1, '{}', 11),
(160, 14, 'image', 'image', 'Resim', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 13),
(161, 14, 'image_url', 'text', 'Resim URL', 0, 0, 1, 1, 1, 1, '{}', 12),
(162, 14, 'image_gallery', 'multiple_images', 'Resim Galerisi', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 18),
(163, 14, 'video', 'file', 'Video', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 15),
(164, 14, 'video_url', 'text', 'Video URL', 0, 0, 1, 1, 1, 1, '{}', 14),
(165, 14, 'video_gallery', 'file', 'Video Galerisi', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 19),
(166, 14, 'banner', 'image', 'Banner', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 17),
(167, 14, 'banner_url', 'text', 'Banner URL', 0, 0, 1, 1, 1, 1, '{}', 16),
(168, 14, 'meta_title', 'text', 'Meta Title', 0, 0, 1, 1, 1, 1, '{}', 20),
(169, 14, 'meta_description', 'text_area', 'Meta Description', 0, 0, 1, 1, 1, 1, '{}', 21),
(170, 14, 'seo_text', 'rich_text_box', 'Seo Text', 0, 0, 1, 1, 1, 1, '{}', 22),
(171, 14, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 23),
(172, 14, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 24),
(173, 15, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(174, 15, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 2),
(175, 15, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 3),
(176, 15, 'title', 'text', 'Başlık', 1, 1, 1, 1, 1, 1, '{}', 4),
(177, 15, 'image', 'image', 'Resim', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 6),
(178, 15, 'image_url', 'text', 'Resim URL', 0, 0, 1, 1, 1, 1, '{}', 5),
(179, 15, 'video', 'file', 'Video', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 7),
(180, 15, 'video_url', 'text', 'Video URL', 0, 0, 1, 1, 1, 1, '{}', 8),
(181, 15, 'content', 'text_area', 'İçerik', 0, 1, 1, 1, 1, 1, '{}', 9),
(182, 15, 'action_text', 'text', 'Buton Yazısı', 0, 0, 1, 1, 1, 1, '{}', 10),
(183, 15, 'action_link', 'text', 'Buton URL', 0, 0, 1, 1, 1, 1, '{}', 11),
(184, 15, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 12),
(185, 15, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 13),
(186, 16, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(187, 16, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 2),
(188, 16, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 3),
(189, 16, 'title', 'text', 'Başlık', 0, 1, 1, 1, 1, 1, '{}', 4),
(190, 16, 'link', 'text', 'URL', 1, 1, 1, 1, 1, 1, '{}', 5),
(191, 16, 'username', 'text', 'Kullanıcı Adı', 0, 1, 1, 1, 1, 1, '{}', 6),
(192, 16, 'icon', 'text', 'İkon', 0, 1, 1, 1, 1, 1, '{}', 7),
(195, 16, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 10),
(196, 16, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 11),
(197, 17, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(198, 17, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 2),
(200, 17, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 3),
(201, 17, 'name', 'text', 'Müşteri Adı', 1, 1, 1, 1, 1, 1, '{}', 4),
(202, 17, 'company', 'text', 'Şirket', 0, 1, 1, 1, 1, 1, '{}', 5),
(203, 17, 'title', 'text', 'Başlık', 0, 1, 1, 1, 1, 1, '{}', 6),
(204, 17, 'comment', 'text_area', 'Yorum', 1, 1, 1, 1, 1, 1, '{}', 7),
(205, 17, 'rating', 'number', 'Yıldız', 1, 1, 1, 1, 1, 1, '{}', 8),
(206, 17, 'image', 'image', 'Resim', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 10),
(207, 17, 'image_url', 'text', 'Resim URL', 0, 1, 1, 1, 1, 1, '{}', 9),
(208, 17, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 11),
(209, 17, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 12),
(211, 6, 'excerpt', 'text_area', 'Kısa Açıklama (özet)', 0, 1, 1, 1, 1, 1, '{}', 8),
(212, 6, 'content', 'rich_text_box', 'İçerik', 0, 0, 1, 1, 1, 1, '{}', 10),
(214, 6, 'icon', 'text', 'İkon', 0, 0, 1, 1, 1, 1, '{}', 14),
(215, 6, 'image_url', 'text', 'Resim URL', 0, 0, 1, 1, 1, 1, '{}', 15),
(216, 6, 'image_gallery', 'multiple_images', 'Resim Galerisi', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 21),
(217, 6, 'video', 'file', 'Video', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 18),
(218, 6, 'video_url', 'text', 'Video URL', 0, 0, 1, 1, 1, 1, '{}', 17),
(219, 6, 'video_gallery', 'file', 'Video Galerisi', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 22),
(220, 6, 'banner', 'image', 'Banner', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 20),
(221, 6, 'banner_url', 'text', 'Banner URL', 0, 0, 1, 1, 1, 1, '{}', 19),
(225, 7, 'sku', 'text', 'Sku', 0, 0, 1, 1, 1, 1, '{}', 15),
(226, 7, 'product_code', 'text', 'Ürün Kodu', 0, 0, 1, 1, 1, 1, '{}', 16),
(227, 7, 'oem_no', 'text', 'Oem No', 0, 0, 1, 1, 1, 1, '{}', 17),
(228, 7, 'barcode', 'text', 'Barkod', 0, 0, 1, 1, 1, 1, '{}', 18),
(229, 7, 'excerpt', 'text_area', 'Kısa Açıklama (özet)', 0, 1, 1, 1, 1, 1, '{}', 8),
(230, 7, 'content', 'rich_text_box', 'İçerik', 0, 0, 1, 1, 1, 1, '{}', 10),
(232, 7, 'icon', 'text', 'İkon', 0, 0, 1, 1, 1, 1, '{}', 19),
(233, 7, 'image_url', 'text', 'Resim URL', 0, 0, 1, 1, 1, 1, '{}', 20),
(234, 7, 'image_gallery', 'multiple_images', 'Resim Galerisi', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 26),
(235, 7, 'video', 'file', 'Video', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 23),
(236, 7, 'video_url', 'text', 'Video URL', 0, 0, 1, 1, 1, 1, '{}', 22),
(237, 7, 'video_gallery', 'file', 'Video Galerisi', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 27),
(238, 7, 'banner', 'image', 'Banner', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 25),
(239, 7, 'banner_url', 'text', 'Banner URL', 0, 0, 1, 1, 1, 1, '{}', 24),
(240, 9, 'excerpt', 'text_area', 'Kısa Açıklama (özet)', 0, 1, 1, 1, 1, 1, '{}', 6),
(243, 9, 'bg_image', 'image', 'Arka Plan', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 10),
(244, 9, 'bg_image_url', 'text', 'Arka Plan URL', 0, 0, 1, 1, 1, 1, '{}', 9),
(245, 9, 'mascot_image', 'image', 'Maskot', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 12),
(246, 9, 'mascot_image_url', 'text', 'Maskot URL', 0, 0, 1, 1, 1, 1, '{}', 11),
(247, 9, 'bg_video', 'file', 'Arka Plan Video', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 14),
(248, 9, 'bg_video_url', 'text', 'Arka Plan Video URL', 0, 0, 1, 1, 1, 1, '{}', 13),
(249, 9, 'action_text', 'text', 'Buton Yazısı', 0, 0, 1, 1, 1, 1, '{}', 15),
(250, 9, 'action_link', 'text', 'Buton URL', 0, 0, 1, 1, 1, 1, '{}', 16),
(251, 18, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(252, 18, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 2),
(254, 18, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 3),
(255, 18, 'slug', 'text', 'URL', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\",\"forceUpdate\":true}}', 4),
(256, 18, 'title', 'text', 'Başlık', 1, 1, 1, 1, 1, 1, '{}', 5),
(257, 18, 'client', 'text', 'Müşteri', 0, 1, 1, 1, 1, 1, '{}', 6),
(258, 18, 'location', 'text', 'Lokasyon', 0, 1, 1, 1, 1, 1, '{}', 7),
(259, 18, 'url', 'text', 'Proje URL', 0, 1, 1, 1, 1, 1, '{}', 8),
(260, 18, 'completion_date', 'timestamp', 'Bitiş Tarihi', 0, 1, 1, 1, 1, 1, '{}', 9),
(261, 18, 'excerpt', 'text_area', 'Kısa Açıklama (özet)', 0, 1, 1, 1, 1, 1, '{}', 10),
(262, 18, 'description', 'rich_text_box', 'Açıklama', 0, 0, 1, 1, 1, 1, '{}', 11),
(263, 18, 'content', 'rich_text_box', 'İçerik', 0, 0, 1, 1, 1, 1, '{}', 12),
(265, 18, 'icon', 'text', 'İkon', 0, 0, 1, 1, 1, 1, '{}', 14),
(266, 18, 'image', 'image', 'Resim', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 16),
(267, 18, 'image_url', 'text', 'Resim URL', 0, 0, 1, 1, 1, 1, '{}', 15),
(268, 18, 'image_gallery', 'multiple_images', 'Resim Galerisi', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 21),
(269, 18, 'video', 'file', 'Video', 0, 0, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 18),
(270, 18, 'video_url', 'text', 'Video URL', 0, 0, 1, 1, 1, 1, '{}', 17),
(271, 18, 'video_gallery', 'file', 'Video Galerisi', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 22),
(272, 18, 'banner', 'image', 'Banner', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 20),
(273, 18, 'banner_url', 'text', 'Banner URL', 0, 0, 1, 1, 1, 1, '{}', 19),
(274, 18, 'meta_title', 'text', 'Meta Title', 0, 0, 1, 1, 1, 1, '{}', 23),
(275, 18, 'meta_description', 'text_area', 'Meta Description', 0, 0, 1, 1, 1, 1, '{}', 24),
(276, 18, 'seo_text', 'rich_text_box', 'Seo Text', 0, 0, 1, 1, 1, 1, '{}', 25),
(277, 18, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 26),
(278, 18, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 27),
(279, 19, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(280, 19, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 2),
(282, 19, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 3),
(283, 19, 'slug', 'text', 'URL', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\",\"forceUpdate\":true}}', 4),
(284, 19, 'title', 'text', 'Başlık', 1, 1, 1, 1, 1, 1, '{}', 5),
(285, 19, 'client', 'text', 'Müşteri', 0, 1, 1, 1, 1, 1, '{}', 6),
(286, 19, 'location', 'text', 'Lokasyon', 0, 1, 1, 1, 1, 1, '{}', 7),
(287, 19, 'url', 'text', 'Referans URL', 0, 1, 1, 1, 1, 1, '{}', 8),
(288, 19, 'completion_date', 'timestamp', 'Bitiş Tarihi', 0, 1, 1, 1, 1, 1, '{}', 9),
(289, 19, 'excerpt', 'text_area', 'Kısa Açıklama (özet)', 0, 1, 1, 1, 1, 1, '{}', 10),
(290, 19, 'description', 'rich_text_box', 'Açıklama', 0, 0, 1, 1, 1, 1, '{}', 11),
(291, 19, 'content', 'rich_text_box', 'İçerik', 0, 0, 1, 1, 1, 1, '{}', 12),
(293, 19, 'icon', 'text', 'İkon', 0, 0, 1, 1, 1, 1, '{}', 14),
(294, 19, 'image', 'image', 'Resim', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 16),
(295, 19, 'image_url', 'text', 'Resim URL', 0, 0, 1, 1, 1, 1, '{}', 15),
(296, 19, 'image_gallery', 'multiple_images', 'Resim Galerisi', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 21),
(297, 19, 'video', 'file', 'Video', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 18),
(298, 19, 'video_url', 'text', 'Video URL', 0, 0, 1, 1, 1, 1, '{}', 17),
(299, 19, 'video_gallery', 'file', 'Video Galerisi', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 22),
(300, 19, 'banner', 'image', 'Banner', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 20),
(301, 19, 'banner_url', 'text', 'Banner URL', 0, 0, 1, 1, 1, 1, '{}', 19),
(302, 19, 'meta_title', 'text', 'Meta Title', 0, 0, 1, 1, 1, 1, '{}', 23),
(303, 19, 'meta_description', 'text_area', 'Meta Description', 0, 0, 1, 1, 1, 1, '{}', 24),
(304, 19, 'seo_text', 'rich_text_box', 'Seo Text', 0, 0, 1, 1, 1, 1, '{}', 25),
(305, 19, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 26),
(306, 19, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 27),
(307, 20, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(308, 20, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 2),
(309, 20, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 3),
(312, 20, 'title', 'text', 'Başlık', 0, 1, 1, 1, 1, 1, '{}', 4),
(314, 20, 'description', 'text_area', 'Açıklama', 1, 0, 1, 1, 1, 1, '{}', 6),
(315, 20, 'image', 'image', 'Resim', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 7),
(316, 20, 'image_url', 'text', 'Resim URL', 0, 0, 1, 1, 1, 1, '{}', 5),
(317, 20, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 8),
(318, 20, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 9),
(319, 21, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(320, 21, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 2),
(321, 21, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 3),
(324, 21, 'title', 'text', 'Başlık', 0, 1, 1, 1, 1, 1, '{}', 4),
(326, 21, 'description', 'text_area', 'Açıklama', 0, 0, 1, 1, 1, 1, '{}', 5),
(327, 21, 'image', 'image', 'Kapak Resmi', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png\"}}', 7),
(328, 21, 'image_url', 'text', 'Kapak Resimi URL', 0, 0, 1, 1, 1, 1, '{}', 6),
(329, 21, 'video', 'file', 'Video', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webm,mp4,mov\"}}', 9),
(330, 21, 'video_url', 'text', 'Video URL', 0, 0, 1, 1, 1, 1, '{}', 8),
(331, 21, 'embed_code', 'code_editor', 'Embed Code', 0, 1, 1, 1, 1, 1, '{}', 10),
(332, 21, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 11),
(333, 21, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 12),
(334, 12, 'subtitle', 'text', 'Alt Başlık', 0, 0, 1, 1, 1, 1, '{}', 6),
(335, 14, 'subtitle', 'text', 'Alt Başlık', 0, 0, 1, 1, 1, 1, '{}', 6),
(336, 22, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(338, 22, 'name', 'text', 'Ad', 1, 1, 1, 1, 1, 1, '{}', 3),
(339, 22, 'surname', 'text', 'Soyad', 1, 1, 1, 1, 1, 1, '{}', 4),
(340, 22, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, '{}', 5),
(341, 22, 'phone', 'text', 'Telefon ', 0, 1, 1, 1, 1, 1, '{}', 6),
(342, 22, 'subject', 'text', 'Başlık', 0, 1, 1, 1, 1, 1, '{}', 7),
(343, 22, 'message', 'text', 'Mesaj', 1, 1, 1, 1, 1, 1, '{}', 8),
(344, 22, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 9),
(345, 22, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 10),
(346, 5, 'footer_show', 'checkbox', 'Footer', 1, 1, 1, 1, 1, 1, '{\"on\":\"G\\u00f6ster\",\"off\":\"Gizle\"}', 7),
(347, 1, 'email_verified_at', 'timestamp', 'Email Verified At', 0, 1, 1, 1, 1, 1, '{}', 6),
(348, 23, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(349, 23, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 3),
(350, 23, 'order', 'text', 'Sıra', 1, 1, 1, 0, 0, 0, '{}', 2),
(351, 23, 'name', 'text', 'Marka Adı', 1, 1, 1, 1, 1, 1, '{}', 4),
(352, 23, 'image', 'file', 'Logo', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"nullable|mimes:webp,jpg,jpeg,png,svg\"}}', 6),
(353, 23, 'image_url', 'text', 'Logo URL', 0, 1, 1, 1, 1, 1, '{}', 5),
(354, 23, 'url', 'text', 'URL', 0, 1, 1, 1, 1, 1, '{}', 7),
(355, 23, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 8),
(356, 23, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 9),
(357, 24, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(358, 24, 'old_url', 'text', 'Eski URL', 1, 1, 1, 1, 1, 1, '{}', 3),
(359, 24, 'new_url', 'text', 'Yeni URL', 1, 1, 1, 1, 1, 1, '{}', 4),
(360, 24, 'status', 'checkbox', 'Durum', 1, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 2),
(361, 24, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 5),
(362, 24, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 6),
(363, 7, 'table_html', 'rich_text_box', 'Tablo', 0, 0, 1, 1, 1, 1, '{}', 11),
(364, 25, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(365, 25, 'status', 'checkbox', 'Durum', 0, 1, 1, 1, 1, 1, '{\"on\":\"Aktif\",\"off\":\"Pasif\",\"checked\":true}', 2),
(366, 25, 'question', 'text_area', 'Soru', 1, 1, 1, 1, 1, 1, '{}', 4),
(367, 25, 'answer', 'text_area', 'Cevap', 1, 1, 1, 1, 1, 1, '{}', 5),
(368, 25, 'order', 'text', 'Sıra', 0, 1, 0, 0, 0, 0, '{}', 3),
(369, 25, 'created_at', 'timestamp', 'Tarih', 0, 1, 1, 0, 0, 0, '{}', 6),
(370, 25, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 7);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `data_types`
--

CREATE TABLE `data_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `display_name_singular` varchar(255) NOT NULL,
  `display_name_plural` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `policy_name` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT 0,
  `server_side` tinyint(4) NOT NULL DEFAULT 0,
  `details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `data_types`
--

INSERT INTO `data_types` (`id`, `name`, `slug`, `display_name_singular`, `display_name_plural`, `icon`, `model_name`, `policy_name`, `controller`, `description`, `generate_permissions`, `server_side`, `details`, `created_at`, `updated_at`) VALUES
(1, 'users', 'users', 'Kullanıcı', 'Kullanıcılar', 'voyager-person', 'TCG\\Voyager\\Models\\User', 'TCG\\Voyager\\Policies\\UserPolicy', 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController', NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"desc\",\"default_search_key\":null,\"scope\":null}', '2025-11-07 11:11:39', '2026-01-19 05:41:50'),
(2, 'menus', 'menus', 'Menü', 'Menüler', 'voyager-file-text', 'TCG\\Voyager\\Models\\Menu', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"desc\",\"default_search_key\":null,\"scope\":null}', '2025-11-07 11:11:39', '2026-01-19 05:45:00'),
(3, 'roles', 'roles', 'Rol', 'Roller', 'voyager-lock', 'TCG\\Voyager\\Models\\Role', NULL, 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController', NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"desc\",\"default_search_key\":null,\"scope\":null}', '2025-11-07 11:11:39', '2026-01-19 05:42:21'),
(5, 'pages', 'pages', 'Sayfa', 'Sayfalar', 'voyager-file-text', 'App\\Models\\Page', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"title\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-11-07 11:22:47', '2026-04-03 08:19:41'),
(6, 'categories', 'categories', 'Kategori', 'Kategoriler', 'voyager-archive', 'App\\Models\\Category', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"name\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-11-07 11:34:46', '2026-04-03 08:19:04'),
(7, 'products', 'products', 'Ürün', 'Ürünler', 'voyager-basket', 'App\\Models\\Product', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"name\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-11-07 11:38:28', '2026-04-03 08:20:00'),
(9, 'sliders', 'sliders', 'Slider', 'Sliderlar', 'voyager-tv', 'App\\Models\\Slider', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"title\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-11-11 07:06:07', '2026-04-01 12:42:42'),
(11, 'counters', 'counters', 'Sayaç', 'Sayaçlar', 'voyager-dashboard', 'App\\Models\\Counter', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"title\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-11-12 10:37:41', '2026-04-01 12:38:29'),
(12, 'blogs', 'blogs', 'Blog', 'Blog', 'voyager-browser', 'App\\Models\\Blog', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"title\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-12-22 07:40:34', '2026-04-03 08:18:26'),
(13, 'certificates', 'certificates', 'Sertifika', 'Sertifikalar', 'voyager-certificate', 'App\\Models\\Certificate', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"title\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-12-22 07:41:00', '2026-04-01 12:38:00'),
(14, 'news', 'news', 'Haber', 'Haberler', 'voyager-news', 'App\\Models\\News', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"title\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-12-22 07:41:58', '2026-04-03 08:18:42'),
(15, 'popups', 'popups', 'Duyuru', 'Duyurular', 'voyager-megaphone', 'App\\Models\\Popup', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"title\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-12-22 07:42:19', '2026-04-01 12:40:50'),
(16, 'social_medias', 'social-medias', 'Sosyal Medya', 'Sosyal Medyalar', 'voyager-phone', 'App\\Models\\SocialMedia', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"title\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-12-22 07:42:40', '2026-04-01 12:42:54'),
(17, 'testimonials', 'testimonials', 'Müşteri Yorumu', 'Müşteri Yorumları', 'voyager-bubble', 'App\\Models\\Testimonial', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"name\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-12-22 07:43:01', '2026-04-01 12:43:22'),
(18, 'projects', 'projects', 'Proje', 'Projeler', 'voyager-folder', 'App\\Models\\Project', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"title\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-12-22 10:40:54', '2026-04-03 08:20:15'),
(19, 'references', 'references', 'Referans', 'Referanslar', 'voyager-plug', 'App\\Models\\Reference', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"title\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-12-22 10:41:13', '2026-04-03 08:20:31'),
(20, 'photos', 'photos', 'Fotoğraf', 'Fotoğraflar', 'voyager-photos', 'App\\Models\\Photo', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"title\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-12-23 07:57:39', '2026-04-01 12:40:06'),
(21, 'videos', 'videos', 'Video', 'Videolar', 'voyager-video', 'App\\Models\\Video', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"title\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-12-23 07:58:58', '2026-04-01 12:44:13'),
(22, 'contacts', 'contacts', 'Mesaj', 'Mesajlar', 'voyager-mail', 'App\\Models\\Contact', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2025-12-30 12:02:22', '2026-04-01 12:38:10'),
(23, 'brands', 'brands', 'Marka', 'Markalar', 'voyager-diamond', 'App\\Models\\Brand', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"order\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2026-03-10 05:48:44', '2026-04-01 12:17:49'),
(24, 'redirect_301s', 'redirect-301s', 'Yönlendirme', 'Yönlendirmeler', 'voyager-paper-plane', 'App\\Models\\Redirect301', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2026-03-12 12:23:10', '2026-04-01 12:41:52'),
(25, 'faqs', 'faqs', 'Soru & Cevap', 'SSS', 'voyager-question', 'App\\Models\\Faqs', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"order\",\"order_display_column\":\"question\",\"order_direction\":\"asc\",\"default_search_key\":null}', '2026-04-01 13:02:24', '2026-04-01 13:02:24');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `failed_jobs`
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
-- Tablo için tablo yapısı `faqs`
--

CREATE TABLE `faqs` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `order` int(11) DEFAULT 0,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `faqs`
--

INSERT INTO `faqs` (`id`, `status`, `order`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Soru test 1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2026-04-01 13:15:11', '2026-04-01 13:18:05'),
(2, 1, 0, 'Soru Test 2', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2026-04-01 13:17:51', '2026-04-01 13:17:51'),
(3, 1, 0, 'Soru Test 3', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2026-04-01 13:18:31', '2026-04-01 13:18:31');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-11-07 11:11:39', '2025-11-07 11:11:39');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL DEFAULT '_self',
  `icon_class` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `parameters` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `url`, `target`, `icon_class`, `color`, `parent_id`, `order`, `created_at`, `updated_at`, `route`, `parameters`) VALUES
(1, 1, 'Başlangıç', '', '_self', 'voyager-home', '#000000', NULL, 1, '2025-11-07 11:11:39', '2026-03-29 17:20:09', 'voyager.dashboard', 'null'),
(2, 1, 'Medya', '', '_self', 'voyager-images', '#000000', NULL, 5, '2025-11-07 11:11:39', '2026-01-19 05:29:15', 'voyager.media.index', 'null'),
(3, 1, 'Kullanıcılar', '', '_self', 'voyager-person', '#000000', 19, 1, '2025-11-07 11:11:39', '2026-01-19 05:27:49', 'voyager.users.index', 'null'),
(4, 1, 'Roller', '', '_self', 'voyager-lock', '#000000', 19, 2, '2025-11-07 11:11:39', '2026-01-19 05:27:55', 'voyager.roles.index', 'null'),
(5, 1, 'Araçlar', '', '_self', 'voyager-tools', '#000000', NULL, 3, '2025-11-07 11:11:39', '2026-01-19 05:28:05', NULL, ''),
(6, 1, 'Menüler', '', '_self', 'voyager-archive', '#000000', 5, 1, '2025-11-07 11:11:39', '2026-01-19 05:34:40', 'voyager.menus.index', 'null'),
(7, 1, 'Veritabanı', '', '_self', 'voyager-data', '#000000', 5, 2, '2025-11-07 11:11:39', '2026-01-19 05:28:39', 'voyager.database.index', 'null'),
(8, 1, 'Pusula', '', '_self', 'voyager-compass', '#000000', 5, 3, '2025-11-07 11:11:39', '2026-01-19 05:29:03', 'voyager.compass.index', 'null'),
(9, 1, 'BREAD', '', '_self', 'voyager-bread', NULL, 5, 4, '2025-11-07 11:11:39', '2025-12-01 05:59:30', 'voyager.bread.index', NULL),
(10, 1, 'Ayarlar', '', '_self', 'voyager-settings', '#000000', NULL, 4, '2025-11-07 11:11:39', '2026-01-19 05:29:10', 'voyager.settings.index', 'null'),
(11, 1, 'Sayfalar', '', '_self', 'voyager-file-text', '#000000', NULL, 6, '2025-11-07 11:22:47', '2026-01-19 05:29:22', 'voyager.pages.index', 'null'),
(12, 1, 'Kategoriler', '', '_self', 'voyager-archive', '#000000', 20, 2, '2025-11-07 11:34:46', '2026-01-19 05:31:13', 'voyager.categories.index', 'null'),
(13, 1, 'Ürünler', '', '_self', 'voyager-basket', '#000000', 20, 1, '2025-11-07 11:38:29', '2026-01-19 05:31:01', 'voyager.products.index', 'null'),
(15, 1, 'Sliderlar', '', '_self', 'voyager-tv', '#000000', 18, 1, '2025-11-11 07:06:07', '2025-12-09 05:34:46', 'voyager.sliders.index', 'null'),
(16, 1, 'Sayaçlar', '', '_self', 'voyager-dashboard', '#000000', 18, 2, '2025-11-12 10:37:41', '2026-01-19 05:31:29', 'voyager.counters.index', 'null'),
(17, 1, 'Çeviriler', '/admin/translations', '_self', 'voyager-world', '#000000', 34, 1, '2025-12-08 09:49:10', '2026-04-01 13:24:23', NULL, ''),
(18, 1, 'Bileşenler', '', '_self', 'voyager-puzzle', '#000000', NULL, 8, '2025-12-08 10:45:59', '2026-01-19 05:31:22', NULL, ''),
(19, 1, 'Yetkilendirme', '', '_self', 'voyager-people', '#000000', NULL, 2, '2025-12-09 03:28:28', '2026-01-19 05:12:24', NULL, ''),
(20, 1, 'Ürünler', '', '_self', 'voyager-shop', '#000000', NULL, 7, '2025-12-09 05:33:36', '2026-01-19 05:29:30', NULL, ''),
(21, 1, 'Blog', '', '_self', 'voyager-browser', '#000000', NULL, 11, '2025-12-22 07:40:34', '2026-03-26 05:58:26', 'voyager.blogs.index', 'null'),
(22, 1, 'Sertifikalar', '', '_self', 'voyager-certificate', '#000000', NULL, 12, '2025-12-22 07:41:00', '2026-01-19 05:33:07', 'voyager.certificates.index', 'null'),
(23, 1, 'Haberler', '', '_self', 'voyager-news', '#000000', 31, 1, '2025-12-22 07:41:58', '2026-01-19 05:32:05', 'voyager.news.index', 'null'),
(24, 1, 'Duyurular', '', '_self', 'voyager-megaphone', '#000000', 18, 3, '2025-12-22 07:42:19', '2026-01-19 05:31:50', 'voyager.popups.index', 'null'),
(25, 1, 'Sosyal Medyalar', '', '_self', 'voyager-phone', '#000000', NULL, 14, '2025-12-22 07:42:40', '2026-03-10 06:01:18', 'voyager.social-medias.index', 'null'),
(26, 1, 'Müşteri Yorumları', '', '_self', 'voyager-bubble', '#000000', NULL, 15, '2025-12-22 07:43:01', '2026-03-10 06:01:18', 'voyager.testimonials.index', 'null'),
(27, 1, 'Projeler', '', '_self', 'voyager-folder', '#000000', NULL, 16, '2025-12-22 10:40:54', '2026-03-10 06:01:18', 'voyager.projects.index', 'null'),
(28, 1, 'Referanslar', '', '_self', 'voyager-plug', '#000000', NULL, 17, '2025-12-22 10:41:13', '2026-03-10 06:01:18', 'voyager.references.index', 'null'),
(29, 1, 'Fotoğraflar', '', '_self', 'voyager-photos', '#000000', 31, 2, '2025-12-23 07:57:39', '2026-01-19 05:32:13', 'voyager.photos.index', 'null'),
(30, 1, 'Videolar', '', '_self', 'voyager-video', '#000000', 31, 3, '2025-12-23 07:58:58', '2026-01-19 05:32:23', 'voyager.videos.index', 'null'),
(31, 1, 'Medya', '', '_self', 'voyager-camera', '#000000', NULL, 9, '2025-12-23 08:00:51', '2026-01-19 05:31:57', NULL, ''),
(32, 1, 'Mesajlar', '', '_self', 'voyager-mail', '#000000', NULL, 19, '2025-12-30 12:02:22', '2026-04-01 13:24:23', 'voyager.contacts.index', 'null'),
(34, 1, 'Yerelleştirme', '', '_self', 'voyager-world', '#000000', NULL, 10, '2026-01-19 03:52:00', '2026-01-19 05:32:32', NULL, ''),
(35, 1, 'Sistem Çevirileri', 'admin/language-files', '_self', 'voyager-world', '#000000', 34, 2, '2026-01-19 09:19:21', '2026-04-01 13:24:23', NULL, ''),
(36, 1, 'Markalar', '', '_self', 'voyager-diamond', NULL, NULL, 13, '2026-03-10 05:48:44', '2026-03-10 06:01:18', 'voyager.brands.index', NULL),
(37, 1, 'Yönlendirmeler', '', '_self', 'voyager-paper-plane', NULL, NULL, 20, '2026-03-12 12:23:10', '2026-04-01 13:24:23', 'voyager.redirect-301s.index', NULL),
(38, 1, 'İkon Paketi', 'admin/icons', '_self', 'voyager-heart', '#000000', NULL, 21, '2026-03-30 14:10:02', '2026-04-01 13:24:23', NULL, ''),
(39, 1, 'SSS', '', '_self', 'voyager-question', NULL, NULL, 18, '2026-04-01 13:02:24', '2026-04-01 13:24:23', 'voyager.faqs.index', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_01_01_000000_add_voyager_user_fields', 1),
(4, '2016_01_01_000000_create_data_types_table', 1),
(5, '2016_05_19_173453_create_menu_table', 1),
(6, '2016_10_21_190000_create_roles_table', 1),
(7, '2016_10_21_190000_create_settings_table', 1),
(8, '2016_11_30_135954_create_permission_table', 1),
(9, '2016_11_30_141208_create_permission_role_table', 1),
(10, '2016_12_26_201236_data_types__add__server_side', 1),
(11, '2017_01_13_000000_add_route_to_menu_items_table', 1),
(12, '2017_01_14_005015_create_translations_table', 1),
(13, '2017_01_15_000000_make_table_name_nullable_in_permissions_table', 1),
(14, '2017_03_06_000000_add_controller_to_data_types_table', 1),
(15, '2017_04_21_000000_add_order_to_data_rows_table', 1),
(16, '2017_07_05_210000_add_policyname_to_data_types_table', 1),
(17, '2017_08_05_000000_add_group_to_settings_table', 1),
(18, '2017_11_26_013050_add_user_role_relationship', 1),
(19, '2017_11_26_015000_create_user_roles_table', 1),
(20, '2018_03_11_000000_add_user_settings', 1),
(21, '2018_03_14_000000_add_details_to_data_types_table', 1),
(22, '2018_03_16_000000_make_settings_value_nullable', 1),
(23, '2019_08_19_000000_create_failed_jobs_table', 1),
(24, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `image_gallery` text DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_gallery` text DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `seo_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `news`
--

INSERT INTO `news` (`id`, `status`, `order`, `slug`, `title`, `subtitle`, `excerpt`, `description`, `content`, `icon`, `image`, `image_url`, `image_gallery`, `video`, `video_url`, `video_gallery`, `banner`, `banner_url`, `meta_title`, `meta_description`, `seo_text`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'haber-test-1', 'Haber Test 1', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-26 05:59:14', '2026-03-27 14:51:37'),
(2, 1, 3, 'haber-test-2', 'Haber Test 2', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-26 05:59:26', '2026-03-27 14:51:37'),
(3, 1, 4, 'haber-test-3', 'Haber Test 3', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-26 05:59:38', '2026-03-27 14:51:37'),
(4, 0, 1, 'test', 'test', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-27 14:49:23', '2026-03-27 14:51:46');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `slug` varchar(255) DEFAULT NULL,
  `is_homepage` tinyint(1) NOT NULL DEFAULT 0,
  `menu_show` tinyint(1) NOT NULL DEFAULT 1,
  `footer_show` tinyint(4) NOT NULL DEFAULT 1,
  `menu_data_source` varchar(255) DEFAULT NULL,
  `blade_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `image_gallery` text DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_gallery` text DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `seo_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `pages`
--

INSERT INTO `pages` (`id`, `status`, `order`, `slug`, `is_homepage`, `menu_show`, `footer_show`, `menu_data_source`, `blade_name`, `title`, `subtitle`, `excerpt`, `description`, `content`, `icon`, `image`, `image_url`, `image_gallery`, `video`, `video_url`, `video_gallery`, `banner`, `banner_url`, `meta_title`, `meta_description`, `seo_text`, `created_at`, `updated_at`, `parent_id`) VALUES
(1, 1, 2, 'anasayfa', 1, 1, 1, NULL, 'index', 'Anasayfa', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-25 04:23:45', '2026-03-27 14:51:03', NULL),
(2, 1, 3, 'kurumsal', 0, 1, 1, NULL, 'corporate', 'Kurumsal', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-25 04:25:17', '2026-03-27 14:51:03', NULL),
(3, 1, 4, 'urunler', 0, 1, 1, 'categories', 'products', 'Ürünler', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-25 04:26:01', '2026-03-27 14:51:03', NULL),
(4, 1, 5, 'iletisim', 0, 1, 1, NULL, 'contact', 'İletişim', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-25 04:28:16', '2026-03-27 14:51:03', NULL),
(5, 1, 6, 'referanslar', 0, 1, 1, NULL, 'references', 'Referanslar', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-26 05:39:46', '2026-03-27 14:51:03', NULL),
(6, 1, 7, 'projeler', 0, 1, 1, NULL, 'projects', 'Projeler', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-26 05:40:17', '2026-03-27 14:51:04', NULL),
(7, 1, 8, 'blog', 0, 1, 1, NULL, 'blog', 'Blog', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-26 05:40:37', '2026-03-27 14:51:04', NULL),
(9, 1, 9, 'medya', 0, 1, 1, NULL, 'media', 'Medya', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-26 05:55:28', '2026-03-27 14:51:04', NULL),
(10, 0, 1, 'test', 0, 0, 0, NULL, NULL, 'test', '', '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-27 14:49:47', '2026-04-01 12:36:11', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `table_name`, `created_at`, `updated_at`) VALUES
(1, 'browse_admin', NULL, '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(2, 'browse_bread', NULL, '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(3, 'browse_database', NULL, '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(4, 'browse_media', NULL, '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(5, 'browse_compass', NULL, '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(6, 'browse_menus', 'menus', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(7, 'read_menus', 'menus', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(8, 'edit_menus', 'menus', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(9, 'add_menus', 'menus', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(10, 'delete_menus', 'menus', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(11, 'browse_roles', 'roles', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(12, 'read_roles', 'roles', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(13, 'edit_roles', 'roles', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(14, 'add_roles', 'roles', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(15, 'delete_roles', 'roles', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(16, 'browse_users', 'users', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(17, 'read_users', 'users', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(18, 'edit_users', 'users', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(19, 'add_users', 'users', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(20, 'delete_users', 'users', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(21, 'browse_settings', 'settings', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(22, 'read_settings', 'settings', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(23, 'edit_settings', 'settings', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(24, 'add_settings', 'settings', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(25, 'delete_settings', 'settings', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(26, 'browse_pages', 'pages', '2025-11-07 11:22:47', '2025-11-07 11:22:47'),
(27, 'read_pages', 'pages', '2025-11-07 11:22:47', '2025-11-07 11:22:47'),
(28, 'edit_pages', 'pages', '2025-11-07 11:22:47', '2025-11-07 11:22:47'),
(29, 'add_pages', 'pages', '2025-11-07 11:22:47', '2025-11-07 11:22:47'),
(30, 'delete_pages', 'pages', '2025-11-07 11:22:47', '2025-11-07 11:22:47'),
(31, 'browse_categories', 'categories', '2025-11-07 11:34:46', '2025-11-07 11:34:46'),
(32, 'read_categories', 'categories', '2025-11-07 11:34:46', '2025-11-07 11:34:46'),
(33, 'edit_categories', 'categories', '2025-11-07 11:34:46', '2025-11-07 11:34:46'),
(34, 'add_categories', 'categories', '2025-11-07 11:34:46', '2025-11-07 11:34:46'),
(35, 'delete_categories', 'categories', '2025-11-07 11:34:46', '2025-11-07 11:34:46'),
(36, 'browse_products', 'products', '2025-11-07 11:38:28', '2025-11-07 11:38:28'),
(37, 'read_products', 'products', '2025-11-07 11:38:29', '2025-11-07 11:38:29'),
(38, 'edit_products', 'products', '2025-11-07 11:38:29', '2025-11-07 11:38:29'),
(39, 'add_products', 'products', '2025-11-07 11:38:29', '2025-11-07 11:38:29'),
(40, 'delete_products', 'products', '2025-11-07 11:38:29', '2025-11-07 11:38:29'),
(46, 'browse_sliders', 'sliders', '2025-11-11 07:06:07', '2025-11-11 07:06:07'),
(47, 'read_sliders', 'sliders', '2025-11-11 07:06:07', '2025-11-11 07:06:07'),
(48, 'edit_sliders', 'sliders', '2025-11-11 07:06:07', '2025-11-11 07:06:07'),
(49, 'add_sliders', 'sliders', '2025-11-11 07:06:07', '2025-11-11 07:06:07'),
(50, 'delete_sliders', 'sliders', '2025-11-11 07:06:07', '2025-11-11 07:06:07'),
(51, 'browse_counters', 'counters', '2025-11-12 10:37:41', '2025-11-12 10:37:41'),
(52, 'read_counters', 'counters', '2025-11-12 10:37:41', '2025-11-12 10:37:41'),
(53, 'edit_counters', 'counters', '2025-11-12 10:37:41', '2025-11-12 10:37:41'),
(54, 'add_counters', 'counters', '2025-11-12 10:37:41', '2025-11-12 10:37:41'),
(55, 'delete_counters', 'counters', '2025-11-12 10:37:41', '2025-11-12 10:37:41'),
(56, 'browse_blogs', 'blogs', '2025-12-22 07:40:34', '2025-12-22 07:40:34'),
(57, 'read_blogs', 'blogs', '2025-12-22 07:40:34', '2025-12-22 07:40:34'),
(58, 'edit_blogs', 'blogs', '2025-12-22 07:40:34', '2025-12-22 07:40:34'),
(59, 'add_blogs', 'blogs', '2025-12-22 07:40:34', '2025-12-22 07:40:34'),
(60, 'delete_blogs', 'blogs', '2025-12-22 07:40:34', '2025-12-22 07:40:34'),
(61, 'browse_certificates', 'certificates', '2025-12-22 07:41:00', '2025-12-22 07:41:00'),
(62, 'read_certificates', 'certificates', '2025-12-22 07:41:00', '2025-12-22 07:41:00'),
(63, 'edit_certificates', 'certificates', '2025-12-22 07:41:00', '2025-12-22 07:41:00'),
(64, 'add_certificates', 'certificates', '2025-12-22 07:41:00', '2025-12-22 07:41:00'),
(65, 'delete_certificates', 'certificates', '2025-12-22 07:41:00', '2025-12-22 07:41:00'),
(66, 'browse_news', 'news', '2025-12-22 07:41:58', '2025-12-22 07:41:58'),
(67, 'read_news', 'news', '2025-12-22 07:41:58', '2025-12-22 07:41:58'),
(68, 'edit_news', 'news', '2025-12-22 07:41:58', '2025-12-22 07:41:58'),
(69, 'add_news', 'news', '2025-12-22 07:41:58', '2025-12-22 07:41:58'),
(70, 'delete_news', 'news', '2025-12-22 07:41:58', '2025-12-22 07:41:58'),
(71, 'browse_popups', 'popups', '2025-12-22 07:42:19', '2025-12-22 07:42:19'),
(72, 'read_popups', 'popups', '2025-12-22 07:42:19', '2025-12-22 07:42:19'),
(73, 'edit_popups', 'popups', '2025-12-22 07:42:19', '2025-12-22 07:42:19'),
(74, 'add_popups', 'popups', '2025-12-22 07:42:19', '2025-12-22 07:42:19'),
(75, 'delete_popups', 'popups', '2025-12-22 07:42:19', '2025-12-22 07:42:19'),
(76, 'browse_social_medias', 'social_medias', '2025-12-22 07:42:40', '2025-12-22 07:42:40'),
(77, 'read_social_medias', 'social_medias', '2025-12-22 07:42:40', '2025-12-22 07:42:40'),
(78, 'edit_social_medias', 'social_medias', '2025-12-22 07:42:40', '2025-12-22 07:42:40'),
(79, 'add_social_medias', 'social_medias', '2025-12-22 07:42:40', '2025-12-22 07:42:40'),
(80, 'delete_social_medias', 'social_medias', '2025-12-22 07:42:40', '2025-12-22 07:42:40'),
(81, 'browse_testimonials', 'testimonials', '2025-12-22 07:43:01', '2025-12-22 07:43:01'),
(82, 'read_testimonials', 'testimonials', '2025-12-22 07:43:01', '2025-12-22 07:43:01'),
(83, 'edit_testimonials', 'testimonials', '2025-12-22 07:43:01', '2025-12-22 07:43:01'),
(84, 'add_testimonials', 'testimonials', '2025-12-22 07:43:01', '2025-12-22 07:43:01'),
(85, 'delete_testimonials', 'testimonials', '2025-12-22 07:43:01', '2025-12-22 07:43:01'),
(86, 'browse_projects', 'projects', '2025-12-22 10:40:54', '2025-12-22 10:40:54'),
(87, 'read_projects', 'projects', '2025-12-22 10:40:54', '2025-12-22 10:40:54'),
(88, 'edit_projects', 'projects', '2025-12-22 10:40:54', '2025-12-22 10:40:54'),
(89, 'add_projects', 'projects', '2025-12-22 10:40:54', '2025-12-22 10:40:54'),
(90, 'delete_projects', 'projects', '2025-12-22 10:40:54', '2025-12-22 10:40:54'),
(91, 'browse_references', 'references', '2025-12-22 10:41:13', '2025-12-22 10:41:13'),
(92, 'read_references', 'references', '2025-12-22 10:41:13', '2025-12-22 10:41:13'),
(93, 'edit_references', 'references', '2025-12-22 10:41:13', '2025-12-22 10:41:13'),
(94, 'add_references', 'references', '2025-12-22 10:41:13', '2025-12-22 10:41:13'),
(95, 'delete_references', 'references', '2025-12-22 10:41:13', '2025-12-22 10:41:13'),
(96, 'browse_photos', 'photos', '2025-12-23 07:57:39', '2025-12-23 07:57:39'),
(97, 'read_photos', 'photos', '2025-12-23 07:57:39', '2025-12-23 07:57:39'),
(98, 'edit_photos', 'photos', '2025-12-23 07:57:39', '2025-12-23 07:57:39'),
(99, 'add_photos', 'photos', '2025-12-23 07:57:39', '2025-12-23 07:57:39'),
(100, 'delete_photos', 'photos', '2025-12-23 07:57:39', '2025-12-23 07:57:39'),
(101, 'browse_videos', 'videos', '2025-12-23 07:58:58', '2025-12-23 07:58:58'),
(102, 'read_videos', 'videos', '2025-12-23 07:58:58', '2025-12-23 07:58:58'),
(103, 'edit_videos', 'videos', '2025-12-23 07:58:58', '2025-12-23 07:58:58'),
(104, 'add_videos', 'videos', '2025-12-23 07:58:58', '2025-12-23 07:58:58'),
(105, 'delete_videos', 'videos', '2025-12-23 07:58:58', '2025-12-23 07:58:58'),
(106, 'browse_contacts', 'contacts', '2025-12-30 12:02:22', '2025-12-30 12:02:22'),
(107, 'read_contacts', 'contacts', '2025-12-30 12:02:22', '2025-12-30 12:02:22'),
(108, 'edit_contacts', 'contacts', '2025-12-30 12:02:22', '2025-12-30 12:02:22'),
(109, 'add_contacts', 'contacts', '2025-12-30 12:02:22', '2025-12-30 12:02:22'),
(110, 'delete_contacts', 'contacts', '2025-12-30 12:02:22', '2025-12-30 12:02:22'),
(111, 'browse_brands', 'brands', '2026-03-10 05:48:44', '2026-03-10 05:48:44'),
(112, 'read_brands', 'brands', '2026-03-10 05:48:44', '2026-03-10 05:48:44'),
(113, 'edit_brands', 'brands', '2026-03-10 05:48:44', '2026-03-10 05:48:44'),
(114, 'add_brands', 'brands', '2026-03-10 05:48:44', '2026-03-10 05:48:44'),
(115, 'delete_brands', 'brands', '2026-03-10 05:48:44', '2026-03-10 05:48:44'),
(116, 'browse_redirect_301s', 'redirect_301s', '2026-03-12 12:23:10', '2026-03-12 12:23:10'),
(117, 'read_redirect_301s', 'redirect_301s', '2026-03-12 12:23:10', '2026-03-12 12:23:10'),
(118, 'edit_redirect_301s', 'redirect_301s', '2026-03-12 12:23:10', '2026-03-12 12:23:10'),
(119, 'add_redirect_301s', 'redirect_301s', '2026-03-12 12:23:10', '2026-03-12 12:23:10'),
(120, 'delete_redirect_301s', 'redirect_301s', '2026-03-12 12:23:10', '2026-03-12 12:23:10'),
(121, 'browse_faqs', 'faqs', '2026-04-01 13:02:24', '2026-04-01 13:02:24'),
(122, 'read_faqs', 'faqs', '2026-04-01 13:02:24', '2026-04-01 13:02:24'),
(123, 'edit_faqs', 'faqs', '2026-04-01 13:02:24', '2026-04-01 13:02:24'),
(124, 'add_faqs', 'faqs', '2026-04-01 13:02:24', '2026-04-01 13:02:24'),
(125, 'delete_faqs', 'faqs', '2026-04-01 13:02:24', '2026-04-01 13:02:24');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `photos`
--

CREATE TABLE `photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `title` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `photos`
--

INSERT INTO `photos` (`id`, `order`, `status`, `title`, `description`, `image`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 'Fotoğraf Test 1', '', NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPOCTym9W3GI8WZ6J-GEqp76bcClWrI_YcEg&s', '2026-03-26 06:13:18', '2026-03-26 06:13:18'),
(2, 0, 1, 'Fotoğraf Test 2', '', NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPOCTym9W3GI8WZ6J-GEqp76bcClWrI_YcEg&s', '2026-03-26 06:13:37', '2026-03-26 06:13:37'),
(3, 0, 1, 'Fotoğraf Test 3', '', NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPOCTym9W3GI8WZ6J-GEqp76bcClWrI_YcEg&s', '2026-03-26 06:13:51', '2026-03-26 06:13:51');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `popups`
--

CREATE TABLE `popups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `action_text` varchar(255) DEFAULT NULL,
  `action_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `popups`
--

INSERT INTO `popups` (`id`, `status`, `order`, `title`, `content`, `image`, `image_url`, `video`, `video_url`, `action_text`, `action_link`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'test', '', NULL, NULL, '[]', NULL, '', '', '2026-03-27 03:33:09', '2026-03-27 03:33:09');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `oem_no` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `table_html` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `image_gallery` text DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_gallery` text DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `seo_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `status`, `order`, `slug`, `sku`, `product_code`, `oem_no`, `barcode`, `name`, `excerpt`, `description`, `content`, `table_html`, `icon`, `image`, `image_url`, `image_gallery`, `video`, `video_url`, `video_gallery`, `banner`, `banner_url`, `meta_title`, `meta_description`, `seo_text`, `created_at`, `updated_at`, `category_id`) VALUES
(1, 1, 2, 'kategorisiz-urun-1', NULL, NULL, NULL, NULL, 'Kategorisiz Ürün 1', '', '', '', NULL, NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-27 08:20:23', '2026-03-27 14:51:12', NULL),
(2, 1, 3, 'kategorisiz-urun-2', NULL, NULL, NULL, NULL, 'Kategorisiz Ürün 2', '', '', '', NULL, NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-27 08:20:41', '2026-03-27 14:51:12', NULL),
(3, 1, 4, 'kategorisiz-urun-3', NULL, NULL, NULL, NULL, 'Kategorisiz Ürün 3 ', '', '', '', NULL, NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-27 08:20:57', '2026-03-27 14:51:12', NULL),
(4, 1, 5, 'test-urunu-1', NULL, NULL, NULL, NULL, 'Test Ürünü 1', '', '', '', NULL, NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-27 11:18:03', '2026-03-27 14:51:12', 1),
(5, 1, 6, 'test-urunu-2', NULL, NULL, NULL, NULL, 'Test Ürünü 2', '', '', '', NULL, NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-27 11:19:07', '2026-03-27 14:51:12', 4),
(6, 1, 7, 'test-urunu-3', NULL, NULL, NULL, NULL, 'Test Ürünü 3', '', '', '', NULL, NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-27 11:19:30', '2026-03-27 14:51:12', 5),
(7, 0, 1, 'test', NULL, NULL, NULL, NULL, 'test', '', '', '', NULL, NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-27 14:49:31', '2026-03-27 14:51:18', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `client` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `completion_date` timestamp NULL DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `image_gallery` text DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_gallery` text DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `seo_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `projects`
--

INSERT INTO `projects` (`id`, `status`, `order`, `slug`, `title`, `client`, `location`, `url`, `completion_date`, `excerpt`, `description`, `content`, `icon`, `image`, `image_url`, `image_gallery`, `video`, `video_url`, `video_gallery`, `banner`, `banner_url`, `meta_title`, `meta_description`, `seo_text`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'proje-test-1', 'Proje Test 1', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-25 05:43:15', '2026-03-27 14:52:07'),
(2, 1, 3, 'proje-test-2', 'Proje Test 2', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-25 05:47:02', '2026-03-27 14:52:07'),
(3, 1, 4, 'proje-test-3', 'Proje Test 3', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-25 05:47:19', '2026-03-27 14:52:07'),
(4, 0, 1, 'test', 'test', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-27 12:21:32', '2026-04-01 07:10:38');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `redirect_301s`
--

CREATE TABLE `redirect_301s` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `old_url` varchar(255) NOT NULL,
  `new_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `references`
--

CREATE TABLE `references` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `client` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `completion_date` timestamp NULL DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `image_gallery` text DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_gallery` text DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `seo_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `references`
--

INSERT INTO `references` (`id`, `status`, `order`, `slug`, `title`, `client`, `location`, `url`, `completion_date`, `excerpt`, `description`, `content`, `icon`, `image`, `image_url`, `image_gallery`, `video`, `video_url`, `video_gallery`, `banner`, `banner_url`, `meta_title`, `meta_description`, `seo_text`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'referans-test-1', 'Referans Test 1', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-26 05:50:32', '2026-03-27 14:52:12'),
(2, 1, 3, 'referans-test-2', 'Referans Test 2', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-26 05:50:51', '2026-03-27 14:52:12'),
(3, 1, 4, 'referans-test-3', 'Referans Test 3', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-26 05:51:10', '2026-03-27 14:52:12'),
(4, 0, 1, 'test', 'test', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '[]', NULL, NULL, '', '', '', '2026-03-27 12:21:37', '2026-04-01 07:10:32');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', '2025-11-07 11:11:39', '2025-11-07 11:11:39'),
(2, 'user', 'Normal User', '2025-11-07 11:11:39', '2025-11-07 11:11:39');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `details` text DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `group` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `key`, `display_name`, `value`, `details`, `type`, `order`, `group`) VALUES
(1, 'site.title', 'Site Title', 'Aether Lumen', '', 'text', 1, 'Site'),
(5, 'admin.bg_image', 'Admin Background Image', 'settings\\March2026\\pDI5162AmkHKO7x2ixER.webp', '', 'image', 5, 'Admin'),
(6, 'admin.title', 'Admin Title', 'Aether Lumen', '', 'text', 1, 'Admin'),
(7, 'admin.description', 'Admin Description', 'Aether Lumen Site Management', '', 'text', 2, 'Admin'),
(8, 'admin.loader', 'Admin Loader', '', '', 'image', 3, 'Admin'),
(9, 'admin.icon_image', 'Admin Icon Image', '', '', 'image', 4, 'Admin'),
(12, 'site.logo', 'Logo', '[{\"download_link\":\"settings\\\\March2026\\\\It1m7q92Ih3Md7Y7fDQE.png\",\"original_name\":\"Square192x192Logo.png\"}]', NULL, 'file', 10, 'Site'),
(29, 'documents.catalog', 'Catalog', '[{\"download_link\":\"settings\\\\March2026\\\\s6XOlr3L2G8A2ytTccux.pdf\",\"original_name\":\"demo-pdf.pdf\"}]', NULL, 'file', 7, 'Documents'),
(30, 'documents.intro_video', 'Intro Video (.webm, .mp4)', '[{\"download_link\":\"settings\\\\March2026\\\\Y8Z6HZVktKyzZI0Y5GMp.webm\",\"original_name\":\"demo-video-1.webm\"}]', NULL, 'file', 8, 'Documents'),
(31, 'site.logo-secondary', 'Logo Secondary', '[{\"download_link\":\"settings\\\\March2026\\\\THYCwDj9DtwautVDVJr2.png\",\"original_name\":\"Square192x192Logo-2.png\"}]', NULL, 'file', 19, 'Site'),
(33, 'site.favicon', 'Favicon', '[{\"download_link\":\"settings\\\\March2026\\\\SUUl8uFl1Dbpc52sAXDf.png\",\"original_name\":\"Square192x192Logo.png\"}]', NULL, 'file', 9, 'Site'),
(35, 'contact-information.form-email', 'Form Email', 'mustafw42@gmail.com', NULL, 'text', 14, 'Contact Information'),
(36, 'contact-information.address', 'Address', 'Suite 283 84384 Marcel Mall, Buckridgefort, NY 26840-4536', NULL, 'text_area', 16, 'Contact Information'),
(37, 'contact-information.phone', 'Phone', '0552 402 5050', NULL, 'text', 17, 'Contact Information'),
(38, 'contact-information.email', 'Email', 'aether@demo.com', NULL, 'text', 22, 'Contact Information'),
(40, 'contact-information.google-maps-iframe', 'Google Maps iframe', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3172355.715869027!2d32.4905180673562!3d39.06083147200288!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14b0155c964f2671%3A0x40d9dbd42a625f2a!2zVMO8cmtpeWU!5e0!3m2!1str!2str!4v1767106656515!5m2!1str!2str\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', NULL, 'text_area', 24, 'Contact Information'),
(41, 'contact-information.google-maps-link', 'Google Maps Link', 'https://maps.app.goo.gl/BYCXCc4qj4gPUkaD6', NULL, 'text', 23, 'Contact Information'),
(42, 'admin.dashboard_banner', 'Admin Dashboard Banner', 'settings\\December2025\\c4P9IvmZG2bR6Ba55GJ2.webp', NULL, 'image', 18, 'Admin'),
(45, 'site.description', 'Site Description', 'Aether Lumen Site Description (Please change the default site description)', NULL, 'text', 6, 'Site'),
(46, 'documents.intro_video_cover_image', 'Intro Video Cover Image', '', NULL, 'image', 20, 'Documents'),
(51, 'contact-information.recaptcha-status', 'reCAPTCHA', 'aktif', '{\r\n    \"options\": {\r\n        \"aktif\": \"Aktif\",\r\n        \"pasif\": \"Pasif\"\r\n    }\r\n}', 'select_dropdown', 12, 'Contact Information'),
(52, 'contact-information.recaptcha-site-key', 'reCAPTCHA Site Key', '6LfO0CsqAAAAABr7j77Gip1iwenNFQlQ2P9M1P1A', NULL, 'text', 13, 'Contact Information'),
(53, 'meta-tags.head', '<head> </head>', '', NULL, 'code_editor', 25, 'Meta Tags'),
(54, 'meta-tags.body', '<body> </body>', '', NULL, 'code_editor', 26, 'Meta Tags');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `bg_image` varchar(255) DEFAULT NULL,
  `bg_image_url` varchar(255) DEFAULT NULL,
  `mascot_image` varchar(255) DEFAULT NULL,
  `mascot_image_url` varchar(255) DEFAULT NULL,
  `bg_video` varchar(255) DEFAULT NULL,
  `bg_video_url` varchar(255) DEFAULT NULL,
  `action_text` varchar(255) DEFAULT NULL,
  `action_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `sliders`
--

INSERT INTO `sliders` (`id`, `status`, `order`, `title`, `subtitle`, `excerpt`, `bg_image`, `bg_image_url`, `mascot_image`, `mascot_image_url`, `bg_video`, `bg_video_url`, `action_text`, `action_link`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Slider Test 1', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '', '', '2026-03-25 08:44:49', '2026-03-25 08:44:49'),
(2, 1, 0, 'Slider Test 2', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '', '', '2026-03-25 08:44:56', '2026-03-25 08:44:56'),
(3, 1, 0, 'Slider Test 3', '', '', NULL, NULL, NULL, NULL, '[]', NULL, '', '', '2026-03-25 08:45:02', '2026-03-25 08:45:02');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `social_medias`
--

CREATE TABLE `social_medias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `social_medias`
--

INSERT INTO `social_medias` (`id`, `status`, `order`, `title`, `link`, `username`, `icon`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'WhatsApp', 'https://wa.me/+90', NULL, 'whatsapp', '2026-03-27 03:46:51', '2026-03-27 03:46:51'),
(2, 1, 0, 'Facebook', 'https://www.facebook.com/', NULL, 'facebook', '2026-03-27 03:47:32', '2026-03-27 03:47:32'),
(3, 1, 0, 'YouTube', 'https://www.youtube.com/@', NULL, 'youtube', '2026-03-27 03:48:06', '2026-03-27 03:48:06'),
(4, 1, 0, 'Twitter', 'https://x.com', NULL, 'twitter', '2026-03-27 03:48:43', '2026-03-27 03:48:43');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `testimonials`
--

INSERT INTO `testimonials` (`id`, `status`, `order`, `name`, `company`, `title`, `comment`, `rating`, `image`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Kintaro', 'Aether', 'Test Yorumu 1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', 5, NULL, 'https://avatars.githubusercontent.com/u/118665344?v=4', '2026-03-26 05:02:06', '2026-03-26 05:04:40'),
(2, 1, 0, 'Arthur Leywin', 'Leywin', 'Test Yorumu 2', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.\n\n', 4, NULL, 'https://i.pinimg.com/736x/4d/d3/ec/4dd3ec68feee2f914be3809f46530ab7.jpg', '2026-03-26 05:04:20', '2026-03-26 05:07:04'),
(3, 1, 0, 'Mustafa', 'Post Ajans', 'Test Yorumu 3', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\n\n', 5, NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPOCTym9W3GI8WZ6J-GEqp76bcClWrI_YcEg&s', '2026-03-26 05:06:43', '2026-03-26 05:06:43');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `translations`
--

CREATE TABLE `translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `column_name` varchar(255) NOT NULL,
  `foreign_key` int(10) UNSIGNED NOT NULL,
  `locale` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `translations`
--

INSERT INTO `translations` (`id`, `table_name`, `column_name`, `foreign_key`, `locale`, `value`, `created_at`, `updated_at`) VALUES
(1535, 'data_rows', 'display_name', 112, 'en', 'Id', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1536, 'data_rows', 'display_name', 113, 'en', 'Durum', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1537, 'data_rows', 'display_name', 115, 'en', 'Sıra', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1538, 'data_rows', 'display_name', 116, 'en', 'URL', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1539, 'data_rows', 'display_name', 117, 'en', 'Başlık', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1540, 'data_rows', 'display_name', 334, 'en', 'Alt Başlık', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1541, 'data_rows', 'display_name', 118, 'en', 'Kısa Açıklama (özet)', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1542, 'data_rows', 'display_name', 119, 'en', 'Açıklama', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1543, 'data_rows', 'display_name', 120, 'en', 'İçerik', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1544, 'data_rows', 'display_name', 121, 'en', 'Görüntülenme', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1545, 'data_rows', 'display_name', 122, 'en', 'Icon', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1546, 'data_rows', 'display_name', 123, 'en', 'Resim', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1547, 'data_rows', 'display_name', 124, 'en', 'Resim URL', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1548, 'data_rows', 'display_name', 125, 'en', 'Resim Galerisi', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1549, 'data_rows', 'display_name', 126, 'en', 'Video', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1550, 'data_rows', 'display_name', 127, 'en', 'Video URL', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1551, 'data_rows', 'display_name', 128, 'en', 'Video Galerisi', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1552, 'data_rows', 'display_name', 129, 'en', 'Banner', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1553, 'data_rows', 'display_name', 130, 'en', 'Banner URL', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1554, 'data_rows', 'display_name', 131, 'en', 'Meta Title', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1555, 'data_rows', 'display_name', 132, 'en', 'Meta Description', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1556, 'data_rows', 'display_name', 133, 'en', 'Seo Text', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1557, 'data_rows', 'display_name', 134, 'en', 'Created At', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1558, 'data_rows', 'display_name', 135, 'en', 'Updated At', '2026-03-24 11:48:54', '2026-03-24 11:48:54'),
(1559, 'data_types', 'display_name_singular', 12, 'en', 'Blog', '2026-03-24 11:48:54', '2026-03-26 05:58:00'),
(1560, 'data_types', 'display_name_plural', 12, 'en', 'Blog', '2026-03-24 11:48:54', '2026-03-26 05:58:00'),
(1561, 'data_rows', 'display_name', 348, 'en', 'Id', '2026-03-24 11:52:02', '2026-03-24 11:52:02'),
(1562, 'data_rows', 'display_name', 349, 'en', 'Durum', '2026-03-24 11:52:02', '2026-03-24 11:52:02'),
(1563, 'data_rows', 'display_name', 350, 'en', 'Sıra', '2026-03-24 11:52:02', '2026-03-24 11:52:02'),
(1564, 'data_rows', 'display_name', 351, 'en', 'Marka Adı', '2026-03-24 11:52:02', '2026-03-24 11:52:02'),
(1565, 'data_rows', 'display_name', 352, 'en', 'Logo', '2026-03-24 11:52:02', '2026-03-24 11:52:02'),
(1566, 'data_rows', 'display_name', 353, 'en', 'Logo URL', '2026-03-24 11:52:02', '2026-03-24 11:52:02'),
(1567, 'data_rows', 'display_name', 354, 'en', 'URL', '2026-03-24 11:52:02', '2026-03-24 11:52:02'),
(1568, 'data_rows', 'display_name', 355, 'en', 'Created At', '2026-03-24 11:52:02', '2026-03-24 11:52:02'),
(1569, 'data_rows', 'display_name', 356, 'en', 'Updated At', '2026-03-24 11:52:02', '2026-03-24 11:52:02'),
(1570, 'data_types', 'display_name_singular', 23, 'en', 'Marka', '2026-03-24 11:52:02', '2026-03-24 11:52:02'),
(1571, 'data_types', 'display_name_plural', 23, 'en', 'Markalar', '2026-03-24 11:52:02', '2026-03-24 11:52:02'),
(1572, 'data_rows', 'display_name', 39, 'en', 'Id', '2026-03-24 11:52:25', '2026-03-24 11:52:25'),
(1573, 'data_rows', 'display_name', 40, 'en', 'Durum', '2026-03-24 11:52:25', '2026-03-24 11:52:25'),
(1574, 'data_rows', 'display_name', 41, 'en', 'Sıra', '2026-03-24 11:52:25', '2026-03-24 11:52:25'),
(1575, 'data_rows', 'display_name', 43, 'en', 'URL', '2026-03-24 11:52:25', '2026-03-24 11:52:25'),
(1576, 'data_rows', 'display_name', 42, 'en', 'Kategori Adı', '2026-03-24 11:52:25', '2026-03-24 11:52:25'),
(1577, 'data_rows', 'display_name', 211, 'en', 'Kısa Açıklama (özet)', '2026-03-24 11:52:25', '2026-03-24 11:52:25'),
(1578, 'data_rows', 'display_name', 44, 'en', 'Açıklama', '2026-03-24 11:52:25', '2026-03-24 11:52:25'),
(1579, 'data_rows', 'display_name', 212, 'en', 'İçerik', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1580, 'data_rows', 'display_name', 213, 'en', 'Görüntülenme', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1581, 'data_rows', 'display_name', 214, 'en', 'Icon', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1582, 'data_rows', 'display_name', 98, 'en', 'Resim', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1583, 'data_rows', 'display_name', 215, 'en', 'Resim URL', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1584, 'data_rows', 'display_name', 216, 'en', 'Resim Galerisi', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1585, 'data_rows', 'display_name', 217, 'en', 'Video', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1586, 'data_rows', 'display_name', 218, 'en', 'Video URL', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1587, 'data_rows', 'display_name', 219, 'en', 'Video Galerisi', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1588, 'data_rows', 'display_name', 220, 'en', 'Banner', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1589, 'data_rows', 'display_name', 221, 'en', 'Banner URL', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1590, 'data_rows', 'display_name', 45, 'en', 'Meta Title', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1591, 'data_rows', 'display_name', 46, 'en', 'Meta Description', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1592, 'data_rows', 'display_name', 47, 'en', 'Seo Text', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1593, 'data_rows', 'display_name', 48, 'en', 'Lft', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1594, 'data_rows', 'display_name', 49, 'en', 'Rgt', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1595, 'data_rows', 'display_name', 50, 'en', 'Üst Kategori', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1596, 'data_rows', 'display_name', 51, 'en', 'Created At', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1597, 'data_rows', 'display_name', 52, 'en', 'Updated At', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1598, 'data_rows', 'display_name', 53, 'en', 'Üst Kategori', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1599, 'data_types', 'display_name_singular', 6, 'en', 'Kategori', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1600, 'data_types', 'display_name_plural', 6, 'en', 'Kategoriler', '2026-03-24 11:52:26', '2026-03-24 11:52:26'),
(1601, 'data_rows', 'display_name', 136, 'en', 'Id', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1602, 'data_rows', 'display_name', 137, 'en', 'Durum', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1603, 'data_rows', 'display_name', 138, 'en', 'Sıra', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1604, 'data_rows', 'display_name', 139, 'en', 'Başlık', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1605, 'data_rows', 'display_name', 140, 'en', 'Organizasyon', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1606, 'data_rows', 'display_name', 141, 'en', 'Veriliş Tarihi', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1607, 'data_rows', 'display_name', 142, 'en', 'Açıklama', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1608, 'data_rows', 'display_name', 143, 'en', 'Image', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1609, 'data_rows', 'display_name', 144, 'en', 'Image URL', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1610, 'data_rows', 'display_name', 145, 'en', 'Sertifika Dosyası', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1611, 'data_rows', 'display_name', 146, 'en', 'Sertifika Dosyası URL', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1612, 'data_rows', 'display_name', 147, 'en', 'Created At', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1613, 'data_rows', 'display_name', 148, 'en', 'Updated At', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1614, 'data_types', 'display_name_singular', 13, 'en', 'Sertifika', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1615, 'data_types', 'display_name_plural', 13, 'en', 'Sertifikalar', '2026-03-24 11:52:38', '2026-03-24 11:52:38'),
(1616, 'data_rows', 'display_name', 336, 'en', 'Id', '2026-03-24 11:52:57', '2026-03-24 11:52:57'),
(1617, 'data_rows', 'display_name', 338, 'en', 'Ad', '2026-03-24 11:52:57', '2026-03-24 11:52:57'),
(1618, 'data_rows', 'display_name', 339, 'en', 'Soyad', '2026-03-24 11:52:57', '2026-03-24 11:52:57'),
(1619, 'data_rows', 'display_name', 340, 'en', 'Email', '2026-03-24 11:52:57', '2026-03-24 11:52:57'),
(1620, 'data_rows', 'display_name', 341, 'en', 'Telefon ', '2026-03-24 11:52:57', '2026-03-24 11:52:57'),
(1621, 'data_rows', 'display_name', 342, 'en', 'Başlık', '2026-03-24 11:52:57', '2026-03-24 11:52:57'),
(1622, 'data_rows', 'display_name', 343, 'en', 'Mesaj', '2026-03-24 11:52:57', '2026-03-24 11:52:57'),
(1623, 'data_rows', 'display_name', 344, 'en', 'Gönderim Tarihi', '2026-03-24 11:52:57', '2026-03-24 11:52:57'),
(1624, 'data_rows', 'display_name', 345, 'en', 'Updated At', '2026-03-24 11:52:57', '2026-03-24 11:52:57'),
(1625, 'data_types', 'display_name_singular', 22, 'en', 'Mesaj', '2026-03-24 11:52:57', '2026-03-24 11:52:57'),
(1626, 'data_types', 'display_name_plural', 22, 'en', 'Mesajlar', '2026-03-24 11:52:57', '2026-03-24 11:52:57'),
(1627, 'data_rows', 'display_name', 86, 'en', 'Id', '2026-03-24 11:53:11', '2026-03-24 11:53:11'),
(1628, 'data_rows', 'display_name', 87, 'en', 'Durum', '2026-03-24 11:53:11', '2026-03-24 11:53:11'),
(1629, 'data_rows', 'display_name', 88, 'en', 'Sıra', '2026-03-24 11:53:11', '2026-03-24 11:53:11'),
(1630, 'data_rows', 'display_name', 89, 'en', 'Sayaç Başlığı', '2026-03-24 11:53:11', '2026-03-24 11:53:11'),
(1631, 'data_rows', 'display_name', 91, 'en', 'Sayaç Değeri (sayı)', '2026-03-24 11:53:11', '2026-03-24 11:53:11'),
(1632, 'data_rows', 'display_name', 92, 'en', 'Yüzdelik Değer', '2026-03-24 11:53:11', '2026-03-24 11:53:11'),
(1633, 'data_rows', 'display_name', 93, 'en', 'Icon', '2026-03-24 11:53:11', '2026-03-24 11:53:11'),
(1634, 'data_rows', 'display_name', 95, 'en', 'Created At', '2026-03-24 11:53:11', '2026-03-24 11:53:11'),
(1635, 'data_rows', 'display_name', 96, 'en', 'Updated At', '2026-03-24 11:53:11', '2026-03-24 11:53:11'),
(1636, 'data_types', 'display_name_singular', 11, 'en', 'Sayaç', '2026-03-24 11:53:11', '2026-03-24 11:53:11'),
(1637, 'data_types', 'display_name_plural', 11, 'en', 'Sayaçlar', '2026-03-24 11:53:11', '2026-03-24 11:53:11'),
(1638, 'data_rows', 'display_name', 149, 'en', 'Id', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1639, 'data_rows', 'display_name', 150, 'en', 'Durum', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1640, 'data_rows', 'display_name', 152, 'en', 'Sıra', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1641, 'data_rows', 'display_name', 153, 'en', 'URL', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1642, 'data_rows', 'display_name', 154, 'en', 'Başlık', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1643, 'data_rows', 'display_name', 335, 'en', 'Alt Başlık', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1644, 'data_rows', 'display_name', 155, 'en', 'Kısa Açıklama (özet)', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1645, 'data_rows', 'display_name', 156, 'en', 'Açıklama', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1646, 'data_rows', 'display_name', 157, 'en', 'İçerik', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1647, 'data_rows', 'display_name', 158, 'en', 'Görüntülenme', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1648, 'data_rows', 'display_name', 159, 'en', 'Icon', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1649, 'data_rows', 'display_name', 160, 'en', 'Resim', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1650, 'data_rows', 'display_name', 161, 'en', 'Resim URL', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1651, 'data_rows', 'display_name', 162, 'en', 'Resim Galerisi', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1652, 'data_rows', 'display_name', 163, 'en', 'Video', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1653, 'data_rows', 'display_name', 164, 'en', 'Video URL', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1654, 'data_rows', 'display_name', 165, 'en', 'Video Galerisi', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1655, 'data_rows', 'display_name', 166, 'en', 'Banner', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1656, 'data_rows', 'display_name', 167, 'en', 'Banner URL', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1657, 'data_rows', 'display_name', 168, 'en', 'Meta Title', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1658, 'data_rows', 'display_name', 169, 'en', 'Meta Description', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1659, 'data_rows', 'display_name', 170, 'en', 'Seo Text', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1660, 'data_rows', 'display_name', 171, 'en', 'Created At', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1661, 'data_rows', 'display_name', 172, 'en', 'Updated At', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1662, 'data_types', 'display_name_singular', 14, 'en', 'Haber', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1663, 'data_types', 'display_name_plural', 14, 'en', 'Haberler', '2026-03-24 11:53:34', '2026-03-24 11:53:34'),
(1664, 'data_rows', 'display_name', 22, 'en', 'Id', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1665, 'data_rows', 'display_name', 23, 'en', 'Durum', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1666, 'data_rows', 'display_name', 24, 'en', 'Sıra', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1667, 'data_rows', 'display_name', 25, 'en', 'URL', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1668, 'data_rows', 'display_name', 26, 'en', 'Ana Sayfa', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1669, 'data_rows', 'display_name', 27, 'en', 'Menü', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1670, 'data_rows', 'display_name', 346, 'en', 'Footer', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1671, 'data_rows', 'display_name', 97, 'en', 'Menu Data Source', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1672, 'data_rows', 'display_name', 28, 'en', 'Blade Name ', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1673, 'data_rows', 'display_name', 29, 'en', 'Başlık', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1674, 'data_rows', 'display_name', 30, 'en', 'Alt Başlık', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1675, 'data_rows', 'display_name', 99, 'en', 'Kısa Açıklama (özet)', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1676, 'data_rows', 'display_name', 100, 'en', 'Açıklama', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1677, 'data_rows', 'display_name', 31, 'en', 'İçerik', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1678, 'data_rows', 'display_name', 101, 'en', 'Görüntülenme', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1679, 'data_rows', 'display_name', 102, 'en', 'Icon', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1680, 'data_rows', 'display_name', 32, 'en', 'Resim', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1681, 'data_rows', 'display_name', 103, 'en', 'Resim URL', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1682, 'data_rows', 'display_name', 108, 'en', 'Resim Galerisi', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1683, 'data_rows', 'display_name', 106, 'en', 'Video', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1684, 'data_rows', 'display_name', 107, 'en', 'Video URL', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1685, 'data_rows', 'display_name', 109, 'en', 'Video Galerisi', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1686, 'data_rows', 'display_name', 110, 'en', 'Banner', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1687, 'data_rows', 'display_name', 111, 'en', 'Banner URL', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1688, 'data_rows', 'display_name', 33, 'en', 'Meta Title', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1689, 'data_rows', 'display_name', 34, 'en', 'Meta Description', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1690, 'data_rows', 'display_name', 35, 'en', 'Seo Text', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1691, 'data_rows', 'display_name', 36, 'en', 'Created At', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1692, 'data_rows', 'display_name', 37, 'en', 'Updated At', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1693, 'data_rows', 'display_name', 38, 'en', 'Üst Sayfa', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1694, 'data_rows', 'display_name', 84, 'en', 'Üst Sayfa', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1695, 'data_types', 'display_name_singular', 5, 'en', 'Sayfa', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1696, 'data_types', 'display_name_plural', 5, 'en', 'Sayfalar', '2026-03-24 11:55:08', '2026-03-24 11:55:08'),
(1697, 'data_rows', 'display_name', 307, 'en', 'Id', '2026-03-24 11:55:41', '2026-03-24 11:55:41'),
(1698, 'data_rows', 'display_name', 308, 'en', 'Sıra', '2026-03-24 11:55:41', '2026-03-24 11:55:41'),
(1699, 'data_rows', 'display_name', 309, 'en', 'Durum', '2026-03-24 11:55:41', '2026-03-24 11:55:41'),
(1700, 'data_rows', 'display_name', 312, 'en', 'Başlık', '2026-03-24 11:55:41', '2026-03-24 11:55:41'),
(1701, 'data_rows', 'display_name', 313, 'en', 'Kısa Açıklama (özet)', '2026-03-24 11:55:41', '2026-03-24 11:55:41'),
(1702, 'data_rows', 'display_name', 314, 'en', 'Açıklama', '2026-03-24 11:55:41', '2026-03-24 11:55:41'),
(1703, 'data_rows', 'display_name', 315, 'en', 'Image', '2026-03-24 11:55:41', '2026-03-24 11:55:41'),
(1704, 'data_rows', 'display_name', 316, 'en', 'Image URL', '2026-03-24 11:55:41', '2026-03-24 11:55:41'),
(1705, 'data_rows', 'display_name', 317, 'en', 'Created At', '2026-03-24 11:55:41', '2026-03-24 11:55:41'),
(1706, 'data_rows', 'display_name', 318, 'en', 'Updated At', '2026-03-24 11:55:41', '2026-03-24 11:55:41'),
(1707, 'data_types', 'display_name_singular', 20, 'en', 'Fotoğraf', '2026-03-24 11:55:41', '2026-03-24 11:55:41'),
(1708, 'data_types', 'display_name_plural', 20, 'en', 'Fotoğraflar', '2026-03-24 11:55:41', '2026-03-24 11:55:41'),
(1709, 'data_rows', 'display_name', 173, 'en', 'Id', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1710, 'data_rows', 'display_name', 174, 'en', 'Durum', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1711, 'data_rows', 'display_name', 175, 'en', 'Sıra', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1712, 'data_rows', 'display_name', 176, 'en', 'Başlık', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1713, 'data_rows', 'display_name', 181, 'en', 'İçerik', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1714, 'data_rows', 'display_name', 177, 'en', 'Resim', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1715, 'data_rows', 'display_name', 178, 'en', 'Resim URL', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1716, 'data_rows', 'display_name', 179, 'en', 'Video', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1717, 'data_rows', 'display_name', 180, 'en', 'Video URL', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1718, 'data_rows', 'display_name', 182, 'en', 'Buton Yazısı', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1719, 'data_rows', 'display_name', 183, 'en', 'Buton URL', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1720, 'data_rows', 'display_name', 184, 'en', 'Created At', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1721, 'data_rows', 'display_name', 185, 'en', 'Updated At', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1722, 'data_types', 'display_name_singular', 15, 'en', 'Duyuru', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1723, 'data_types', 'display_name_plural', 15, 'en', 'Duyurular', '2026-03-24 11:55:58', '2026-03-24 11:55:58'),
(1724, 'data_rows', 'display_name', 54, 'en', 'Id', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1725, 'data_rows', 'display_name', 55, 'en', 'Durum', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1726, 'data_rows', 'display_name', 56, 'en', 'Sıra', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1727, 'data_rows', 'display_name', 57, 'en', 'URL', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1728, 'data_rows', 'display_name', 225, 'en', 'Sku', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1729, 'data_rows', 'display_name', 226, 'en', 'Product Code', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1730, 'data_rows', 'display_name', 227, 'en', 'Oem No', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1731, 'data_rows', 'display_name', 228, 'en', 'Barcode', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1732, 'data_rows', 'display_name', 58, 'en', 'Ürün Adı', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1733, 'data_rows', 'display_name', 229, 'en', 'Kısa Açıklama (özet)', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1734, 'data_rows', 'display_name', 59, 'en', 'Açıklama', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1735, 'data_rows', 'display_name', 230, 'en', 'İçerik', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1736, 'data_rows', 'display_name', 231, 'en', 'Görüntülenme', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1737, 'data_rows', 'display_name', 232, 'en', 'Icon', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1738, 'data_rows', 'display_name', 60, 'en', 'Resim', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1739, 'data_rows', 'display_name', 233, 'en', 'Resim URL', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1740, 'data_rows', 'display_name', 234, 'en', 'Resim Galerisi', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1741, 'data_rows', 'display_name', 235, 'en', 'Video', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1742, 'data_rows', 'display_name', 236, 'en', 'Video URL', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1743, 'data_rows', 'display_name', 237, 'en', 'Video Galerisi', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1744, 'data_rows', 'display_name', 238, 'en', 'Banner', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1745, 'data_rows', 'display_name', 239, 'en', 'Banner URL', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1746, 'data_rows', 'display_name', 61, 'en', 'Meta Title', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1747, 'data_rows', 'display_name', 62, 'en', 'Meta Description', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1748, 'data_rows', 'display_name', 63, 'en', 'Seo Text', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1749, 'data_rows', 'display_name', 64, 'en', 'Created At', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1750, 'data_rows', 'display_name', 65, 'en', 'Updated At', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1751, 'data_rows', 'display_name', 66, 'en', 'Kategori', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1752, 'data_rows', 'display_name', 67, 'en', 'Kategori', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1753, 'data_types', 'display_name_singular', 7, 'en', 'Ürün', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1754, 'data_types', 'display_name_plural', 7, 'en', 'Ürünler', '2026-03-24 11:56:30', '2026-03-24 11:56:30'),
(1755, 'data_rows', 'display_name', 251, 'en', 'Id', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1756, 'data_rows', 'display_name', 252, 'en', 'Durum', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1757, 'data_rows', 'display_name', 254, 'en', 'Sıra', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1758, 'data_rows', 'display_name', 255, 'en', 'URL', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1759, 'data_rows', 'display_name', 256, 'en', 'Başlık', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1760, 'data_rows', 'display_name', 257, 'en', 'Müşteri', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1761, 'data_rows', 'display_name', 258, 'en', 'Lokasyon', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1762, 'data_rows', 'display_name', 259, 'en', 'URL', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1763, 'data_rows', 'display_name', 260, 'en', 'Bitiş Tarihi', '2026-03-24 11:56:49', '2026-03-25 05:41:40'),
(1764, 'data_rows', 'display_name', 261, 'en', 'Kısa Açıklama (özet)', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1765, 'data_rows', 'display_name', 262, 'en', 'Açıklama', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1766, 'data_rows', 'display_name', 263, 'en', 'İçerik', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1767, 'data_rows', 'display_name', 264, 'en', 'Görüntülenme', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1768, 'data_rows', 'display_name', 265, 'en', 'Icon', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1769, 'data_rows', 'display_name', 266, 'en', 'Resim', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1770, 'data_rows', 'display_name', 267, 'en', 'Resim URL', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1771, 'data_rows', 'display_name', 268, 'en', 'Resim Galerisi', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1772, 'data_rows', 'display_name', 269, 'en', 'Video', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1773, 'data_rows', 'display_name', 270, 'en', 'Video URL', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1774, 'data_rows', 'display_name', 271, 'en', 'Video Galerisi', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1775, 'data_rows', 'display_name', 272, 'en', 'Banner', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1776, 'data_rows', 'display_name', 273, 'en', 'Banner URL', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1777, 'data_rows', 'display_name', 274, 'en', 'Meta Title', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1778, 'data_rows', 'display_name', 275, 'en', 'Meta Description', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1779, 'data_rows', 'display_name', 276, 'en', 'Seo Text', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1780, 'data_rows', 'display_name', 277, 'en', 'Created At', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1781, 'data_rows', 'display_name', 278, 'en', 'Updated At', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1782, 'data_types', 'display_name_singular', 18, 'en', 'Proje', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1783, 'data_types', 'display_name_plural', 18, 'en', 'Projeler', '2026-03-24 11:56:49', '2026-03-24 11:56:49'),
(1784, 'data_rows', 'display_name', 357, 'en', 'Id', '2026-03-24 11:56:58', '2026-03-24 11:56:58'),
(1785, 'data_rows', 'display_name', 360, 'en', 'Durum', '2026-03-24 11:56:58', '2026-03-24 11:56:58'),
(1786, 'data_rows', 'display_name', 358, 'en', 'Eski URL', '2026-03-24 11:56:58', '2026-03-24 11:56:58'),
(1787, 'data_rows', 'display_name', 359, 'en', 'Yeni URL', '2026-03-24 11:56:58', '2026-03-24 11:56:58'),
(1788, 'data_rows', 'display_name', 361, 'en', 'Created At', '2026-03-24 11:56:58', '2026-03-24 11:56:58'),
(1789, 'data_rows', 'display_name', 362, 'en', 'Updated At', '2026-03-24 11:56:58', '2026-03-24 11:56:58'),
(1790, 'data_types', 'display_name_singular', 24, 'en', 'Yönlendirme', '2026-03-24 11:56:58', '2026-03-24 11:56:58'),
(1791, 'data_types', 'display_name_plural', 24, 'en', 'Yönlendirmeler', '2026-03-24 11:56:58', '2026-03-24 11:56:58'),
(1792, 'data_rows', 'display_name', 279, 'en', 'Id', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1793, 'data_rows', 'display_name', 280, 'en', 'Durum', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1794, 'data_rows', 'display_name', 282, 'en', 'Sıra', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1795, 'data_rows', 'display_name', 283, 'en', 'URL', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1796, 'data_rows', 'display_name', 284, 'en', 'Başlık', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1797, 'data_rows', 'display_name', 285, 'en', 'Müşteri', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1798, 'data_rows', 'display_name', 286, 'en', 'Lokasyon', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1799, 'data_rows', 'display_name', 287, 'en', 'URL', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1800, 'data_rows', 'display_name', 288, 'en', 'Bitiş Tarihi', '2026-03-24 11:57:56', '2026-03-25 05:41:44'),
(1801, 'data_rows', 'display_name', 289, 'en', 'Kısa Açıklama (özet)', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1802, 'data_rows', 'display_name', 290, 'en', 'Açıklama', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1803, 'data_rows', 'display_name', 291, 'en', 'İçerik', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1804, 'data_rows', 'display_name', 292, 'en', 'Görüntülenme', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1805, 'data_rows', 'display_name', 293, 'en', 'Icon', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1806, 'data_rows', 'display_name', 294, 'en', 'Resim', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1807, 'data_rows', 'display_name', 295, 'en', 'Resim URL', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1808, 'data_rows', 'display_name', 296, 'en', 'Resim Galerisi', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1809, 'data_rows', 'display_name', 297, 'en', 'Video', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1810, 'data_rows', 'display_name', 298, 'en', 'Video URL', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1811, 'data_rows', 'display_name', 299, 'en', 'Video Galerisi', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1812, 'data_rows', 'display_name', 300, 'en', 'Banner', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1813, 'data_rows', 'display_name', 301, 'en', 'Banner URL', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1814, 'data_rows', 'display_name', 302, 'en', 'Meta Title', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1815, 'data_rows', 'display_name', 303, 'en', 'Meta Description', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1816, 'data_rows', 'display_name', 304, 'en', 'Seo Text', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1817, 'data_rows', 'display_name', 305, 'en', 'Created At', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1818, 'data_rows', 'display_name', 306, 'en', 'Updated At', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1819, 'data_types', 'display_name_singular', 19, 'en', 'Referans', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1820, 'data_types', 'display_name_plural', 19, 'en', 'Referanslar', '2026-03-24 11:57:56', '2026-03-24 11:57:56'),
(1821, 'data_rows', 'display_name', 74, 'en', 'Id', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1822, 'data_rows', 'display_name', 75, 'en', 'Durum', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1823, 'data_rows', 'display_name', 76, 'en', 'Sıra', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1824, 'data_rows', 'display_name', 77, 'en', 'Başlık', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1825, 'data_rows', 'display_name', 78, 'en', 'Alt Başlık', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1826, 'data_rows', 'display_name', 240, 'en', 'Kısa Açıklama (özet)', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1827, 'data_rows', 'display_name', 241, 'en', 'Açıklama', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1828, 'data_rows', 'display_name', 242, 'en', 'İçerik', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1829, 'data_rows', 'display_name', 243, 'en', 'Arka Plan', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1830, 'data_rows', 'display_name', 244, 'en', 'Arka Plan URL', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1831, 'data_rows', 'display_name', 245, 'en', 'Maskot', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1832, 'data_rows', 'display_name', 246, 'en', 'Maskot URL', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1833, 'data_rows', 'display_name', 247, 'en', 'Arka Plan Video', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1834, 'data_rows', 'display_name', 248, 'en', 'Arka Plan Video URL', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1835, 'data_rows', 'display_name', 249, 'en', 'Buton Yazısı', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1836, 'data_rows', 'display_name', 250, 'en', 'Buton URL', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1837, 'data_rows', 'display_name', 82, 'en', 'Created At', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1838, 'data_rows', 'display_name', 83, 'en', 'Updated At', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1839, 'data_types', 'display_name_singular', 9, 'en', 'Slider', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1840, 'data_types', 'display_name_plural', 9, 'en', 'Sliderlar', '2026-03-24 11:58:07', '2026-03-24 11:58:07'),
(1841, 'data_rows', 'display_name', 186, 'en', 'Id', '2026-03-24 11:58:19', '2026-03-24 11:58:19'),
(1842, 'data_rows', 'display_name', 187, 'en', 'Durum', '2026-03-24 11:58:19', '2026-03-24 11:58:19'),
(1843, 'data_rows', 'display_name', 188, 'en', 'Sıra', '2026-03-24 11:58:19', '2026-03-24 11:58:19'),
(1844, 'data_rows', 'display_name', 189, 'en', 'Başlık', '2026-03-24 11:58:19', '2026-03-24 11:58:19'),
(1845, 'data_rows', 'display_name', 190, 'en', 'URL', '2026-03-24 11:58:19', '2026-03-24 11:58:19'),
(1846, 'data_rows', 'display_name', 191, 'en', 'Kullanıcı Adı', '2026-03-24 11:58:19', '2026-03-24 11:58:19'),
(1847, 'data_rows', 'display_name', 192, 'en', 'Icon', '2026-03-24 11:58:19', '2026-03-24 11:58:19'),
(1848, 'data_rows', 'display_name', 193, 'en', 'Resim', '2026-03-24 11:58:19', '2026-03-24 11:58:19'),
(1849, 'data_rows', 'display_name', 194, 'en', 'Resim URL', '2026-03-24 11:58:19', '2026-03-24 11:58:19'),
(1850, 'data_rows', 'display_name', 195, 'en', 'Created At', '2026-03-24 11:58:19', '2026-03-24 11:58:19'),
(1851, 'data_rows', 'display_name', 196, 'en', 'Updated At', '2026-03-24 11:58:19', '2026-03-24 11:58:19'),
(1852, 'data_types', 'display_name_singular', 16, 'en', 'Sosyal Medya', '2026-03-24 11:58:19', '2026-03-24 11:58:19'),
(1853, 'data_types', 'display_name_plural', 16, 'en', 'Sosyal Medyalar', '2026-03-24 11:58:19', '2026-03-24 11:58:19'),
(1854, 'data_rows', 'display_name', 197, 'en', 'Id', '2026-03-24 11:58:29', '2026-03-24 11:58:29'),
(1855, 'data_rows', 'display_name', 198, 'en', 'Durum', '2026-03-24 11:58:29', '2026-03-24 11:58:29'),
(1856, 'data_rows', 'display_name', 200, 'en', 'Sıra', '2026-03-24 11:58:29', '2026-03-24 11:58:29'),
(1857, 'data_rows', 'display_name', 201, 'en', 'Müşteri Adı', '2026-03-24 11:58:29', '2026-03-24 11:58:29'),
(1858, 'data_rows', 'display_name', 202, 'en', 'Şirket', '2026-03-24 11:58:29', '2026-03-24 11:58:29'),
(1859, 'data_rows', 'display_name', 203, 'en', 'Başlık', '2026-03-24 11:58:29', '2026-03-24 11:58:29'),
(1860, 'data_rows', 'display_name', 204, 'en', 'Yorum', '2026-03-24 11:58:29', '2026-03-24 11:58:29'),
(1861, 'data_rows', 'display_name', 205, 'en', 'Yıldız', '2026-03-24 11:58:29', '2026-03-24 11:58:29'),
(1862, 'data_rows', 'display_name', 206, 'en', 'Resim', '2026-03-24 11:58:29', '2026-03-24 11:58:29'),
(1863, 'data_rows', 'display_name', 207, 'en', 'Resim URL', '2026-03-24 11:58:29', '2026-03-24 11:58:29'),
(1864, 'data_rows', 'display_name', 208, 'en', 'Created At', '2026-03-24 11:58:29', '2026-03-24 11:58:29'),
(1865, 'data_rows', 'display_name', 209, 'en', 'Updated At', '2026-03-24 11:58:29', '2026-03-24 11:58:29'),
(1866, 'data_types', 'display_name_singular', 17, 'en', 'Müşteri Yorumu', '2026-03-24 11:58:29', '2026-03-24 11:58:29'),
(1867, 'data_types', 'display_name_plural', 17, 'en', 'Müşteri Yorumları', '2026-03-24 11:58:29', '2026-03-24 11:58:29'),
(1868, 'data_rows', 'display_name', 319, 'en', 'Id', '2026-03-24 11:58:42', '2026-03-24 11:58:42'),
(1869, 'data_rows', 'display_name', 320, 'en', 'Sıra', '2026-03-24 11:58:42', '2026-03-24 11:58:42'),
(1870, 'data_rows', 'display_name', 321, 'en', 'Durum', '2026-03-24 11:58:42', '2026-03-24 11:58:42'),
(1871, 'data_rows', 'display_name', 324, 'en', 'Başlık', '2026-03-24 11:58:42', '2026-03-24 11:58:42'),
(1872, 'data_rows', 'display_name', 325, 'en', 'Kısa Açıklama (özet)', '2026-03-24 11:58:42', '2026-03-24 11:58:42'),
(1873, 'data_rows', 'display_name', 326, 'en', 'Açıklama', '2026-03-24 11:58:42', '2026-03-24 11:58:42'),
(1874, 'data_rows', 'display_name', 327, 'en', 'Resim', '2026-03-24 11:58:42', '2026-03-24 11:58:42'),
(1875, 'data_rows', 'display_name', 328, 'en', 'Resim URL', '2026-03-24 11:58:42', '2026-03-24 11:58:42'),
(1876, 'data_rows', 'display_name', 329, 'en', 'Video', '2026-03-24 11:58:43', '2026-03-24 11:58:43'),
(1877, 'data_rows', 'display_name', 330, 'en', 'Video URL', '2026-03-24 11:58:43', '2026-03-24 11:58:43'),
(1878, 'data_rows', 'display_name', 331, 'en', 'Embed Code', '2026-03-24 11:58:43', '2026-03-24 11:58:43'),
(1879, 'data_rows', 'display_name', 332, 'en', 'Created At', '2026-03-24 11:58:43', '2026-03-24 11:58:43'),
(1880, 'data_rows', 'display_name', 333, 'en', 'Updated At', '2026-03-24 11:58:43', '2026-03-24 11:58:43'),
(1881, 'data_types', 'display_name_singular', 21, 'en', 'Video', '2026-03-24 11:58:43', '2026-03-24 11:58:43'),
(1882, 'data_types', 'display_name_plural', 21, 'en', 'Videolar', '2026-03-24 11:58:43', '2026-03-24 11:58:43'),
(1883, 'pages', 'slug', 1, 'en', 'home', '2026-03-25 04:23:46', '2026-03-25 04:23:46'),
(1884, 'pages', 'title', 1, 'en', 'Home', '2026-03-25 04:23:46', '2026-03-25 04:23:46'),
(1885, 'pages', 'slug', 2, 'en', 'corporate', '2026-03-25 04:25:17', '2026-03-25 04:25:17'),
(1886, 'pages', 'title', 2, 'en', 'Corporate', '2026-03-25 04:25:17', '2026-03-25 04:25:17'),
(1887, 'pages', 'slug', 3, 'en', 'products', '2026-03-25 04:26:02', '2026-03-25 04:26:02'),
(1888, 'pages', 'title', 3, 'en', 'Products', '2026-03-25 04:26:02', '2026-03-25 04:26:02'),
(1889, 'pages', 'slug', 4, 'en', 'contact', '2026-03-25 04:28:17', '2026-03-25 04:28:17'),
(1890, 'pages', 'title', 4, 'en', 'Contact', '2026-03-25 04:28:17', '2026-03-25 04:28:17'),
(1891, 'counters', 'title', 1, 'en', 'Counter Test 1', '2026-03-25 05:26:23', '2026-03-25 05:26:23'),
(1892, 'counters', 'title', 2, 'en', 'Counter Test 2', '2026-03-25 05:27:11', '2026-03-25 05:27:11'),
(1893, 'counters', 'title', 3, 'en', 'Counter Test 3', '2026-03-25 05:28:33', '2026-03-25 05:28:33'),
(1894, 'counters', 'title', 4, 'en', 'Counter Test 4', '2026-03-25 05:30:25', '2026-03-25 05:30:25'),
(1895, 'projects', 'slug', 1, 'en', 'project-test-1', '2026-03-25 05:43:15', '2026-03-25 05:43:15'),
(1896, 'projects', 'title', 1, 'en', 'Project Test 1', '2026-03-25 05:43:15', '2026-03-25 05:43:15'),
(1897, 'projects', 'slug', 2, 'en', 'project-test-2', '2026-03-25 05:47:02', '2026-03-25 05:47:02'),
(1898, 'projects', 'title', 2, 'en', 'Project Test 2', '2026-03-25 05:47:02', '2026-03-25 05:47:02'),
(1899, 'projects', 'slug', 3, 'en', 'project-test-3', '2026-03-25 05:47:19', '2026-03-25 05:47:19'),
(1900, 'projects', 'title', 3, 'en', 'Project Test 3', '2026-03-25 05:47:19', '2026-03-25 05:47:19'),
(1901, 'certificates', 'title', 1, 'en', 'Certificate Test 1', '2026-03-26 04:48:00', '2026-03-26 04:48:00'),
(1902, 'certificates', 'title', 2, 'en', 'Certificate Test 2', '2026-03-26 04:48:17', '2026-03-26 04:48:17'),
(1903, 'certificates', 'title', 3, 'en', 'Certificate Test 3', '2026-03-26 04:48:38', '2026-03-26 04:48:38'),
(1904, 'testimonials', 'title', 1, 'en', 'Test Comment 1', '2026-03-26 05:02:06', '2026-03-26 05:02:06'),
(1905, 'testimonials', 'title', 2, 'en', 'Test Comment 2', '2026-03-26 05:04:21', '2026-03-26 05:04:21'),
(1906, 'testimonials', 'comment', 1, 'en', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', '2026-03-26 05:04:40', '2026-03-26 05:04:40'),
(1907, 'testimonials', 'title', 3, 'en', 'Test Comment 3', '2026-03-26 05:06:43', '2026-03-26 05:06:43'),
(1908, 'testimonials', 'comment', 2, 'en', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.\n\n', '2026-03-26 05:07:04', '2026-03-26 05:07:04'),
(1909, 'pages', 'slug', 5, 'en', 'references', '2026-03-26 05:39:46', '2026-03-26 05:39:46'),
(1910, 'pages', 'title', 5, 'en', 'References', '2026-03-26 05:39:46', '2026-03-26 05:39:46'),
(1911, 'pages', 'slug', 6, 'en', 'projects', '2026-03-26 05:40:17', '2026-03-26 05:40:17'),
(1912, 'pages', 'title', 6, 'en', 'Projects', '2026-03-26 05:40:17', '2026-03-26 05:40:17'),
(1913, 'pages', 'slug', 7, 'en', 'blog', '2026-03-26 05:40:37', '2026-03-26 05:40:37'),
(1914, 'pages', 'title', 7, 'en', 'Blog', '2026-03-26 05:40:37', '2026-03-26 05:40:37'),
(1917, 'references', 'slug', 1, 'en', 'referance-test-1', '2026-03-26 05:50:32', '2026-03-26 05:50:32'),
(1918, 'references', 'title', 1, 'en', 'Referance Test 1', '2026-03-26 05:50:32', '2026-03-26 05:50:32'),
(1919, 'references', 'slug', 2, 'en', 'referance-test-2', '2026-03-26 05:50:51', '2026-03-26 05:50:51'),
(1920, 'references', 'title', 2, 'en', 'Referance Test 2', '2026-03-26 05:50:51', '2026-03-26 05:50:51'),
(1921, 'references', 'slug', 3, 'en', 'referance-test-3', '2026-03-26 05:51:10', '2026-03-26 05:51:10'),
(1922, 'references', 'title', 3, 'en', 'Referance Test 3', '2026-03-26 05:51:10', '2026-03-26 05:51:10'),
(1923, 'pages', 'slug', 9, 'en', 'media', '2026-03-26 05:55:28', '2026-03-26 05:55:28'),
(1924, 'pages', 'title', 9, 'en', 'Media', '2026-03-26 05:55:28', '2026-03-26 05:55:28'),
(1925, 'menu_items', 'title', 21, 'en', 'Blog', '2026-03-26 05:58:26', '2026-03-26 05:58:26'),
(1926, 'news', 'slug', 1, 'en', 'news-test-1', '2026-03-26 05:59:14', '2026-03-26 05:59:14'),
(1927, 'news', 'title', 1, 'en', 'News Test 1', '2026-03-26 05:59:14', '2026-03-26 05:59:14'),
(1928, 'news', 'slug', 2, 'en', 'news-test-2', '2026-03-26 05:59:26', '2026-03-26 05:59:26'),
(1929, 'news', 'title', 2, 'en', 'News Test 2', '2026-03-26 05:59:26', '2026-03-26 05:59:26'),
(1930, 'news', 'slug', 3, 'en', 'news-test-3', '2026-03-26 05:59:39', '2026-03-26 05:59:39'),
(1931, 'news', 'title', 3, 'en', 'News Test 3', '2026-03-26 05:59:39', '2026-03-26 05:59:39'),
(1932, 'blogs', 'slug', 1, 'en', 'blog-test-1', '2026-03-26 06:08:24', '2026-03-26 06:08:24'),
(1933, 'blogs', 'title', 1, 'en', 'Blog Test 1', '2026-03-26 06:08:24', '2026-03-26 06:08:24'),
(1934, 'photos', 'title', 1, 'en', 'Photo Test 1', '2026-03-26 06:13:18', '2026-03-26 06:13:18'),
(1935, 'photos', 'title', 2, 'en', 'Photo Test 2', '2026-03-26 06:13:38', '2026-03-26 06:13:38'),
(1936, 'photos', 'title', 3, 'en', 'Photo Test 3', '2026-03-26 06:13:51', '2026-03-26 06:13:51'),
(1937, 'videos', 'title', 1, 'en', 'Video Test 1', '2026-03-26 07:10:13', '2026-03-26 07:10:13'),
(1938, 'videos', 'title', 2, 'en', 'Video Test 2', '2026-03-26 07:53:00', '2026-03-26 07:53:00'),
(1939, 'videos', 'title', 3, 'en', 'Video Test 3', '2026-03-26 07:53:03', '2026-03-26 07:53:03'),
(1940, 'categories', 'slug', 1, 'en', 'root-category-1', '2026-03-27 08:15:17', '2026-03-27 08:21:22'),
(1941, 'categories', 'name', 1, 'en', 'Root Category 1', '2026-03-27 08:15:17', '2026-03-27 08:21:22'),
(1942, 'categories', 'slug', 2, 'en', 'root-category-2', '2026-03-27 08:15:32', '2026-03-27 08:21:29'),
(1943, 'categories', 'name', 2, 'en', 'Root Category 2', '2026-03-27 08:15:32', '2026-03-27 08:21:29'),
(1944, 'categories', 'slug', 3, 'en', 'root-category-3', '2026-03-27 08:15:53', '2026-03-27 08:21:36'),
(1945, 'categories', 'name', 3, 'en', 'Root Category 3', '2026-03-27 08:15:53', '2026-03-27 08:21:36'),
(1946, 'categories', 'slug', 4, 'en', 'category-level-2', '2026-03-27 08:17:36', '2026-03-27 08:17:36'),
(1947, 'categories', 'name', 4, 'en', 'Category Level 2', '2026-03-27 08:17:36', '2026-03-27 08:17:36'),
(1948, 'categories', 'slug', 5, 'en', 'category-level-3', '2026-03-27 08:18:00', '2026-03-27 08:18:00'),
(1949, 'categories', 'name', 5, 'en', 'Category Level 3', '2026-03-27 08:18:00', '2026-03-27 08:18:00'),
(1950, 'categories', 'slug', 6, 'en', 'category-level-4', '2026-03-27 08:18:23', '2026-03-27 08:18:23'),
(1951, 'categories', 'name', 6, 'en', 'Category Level 4', '2026-03-27 08:18:23', '2026-03-27 08:18:23'),
(1954, 'products', 'slug', 1, 'en', 'uncategorized-product-1', '2026-03-27 08:20:23', '2026-03-27 08:20:23'),
(1955, 'products', 'name', 1, 'en', 'Uncategorized Product 1', '2026-03-27 08:20:23', '2026-03-27 08:20:23'),
(1956, 'products', 'slug', 2, 'en', 'uncategorized-product-2', '2026-03-27 08:20:41', '2026-03-27 08:20:41'),
(1957, 'products', 'name', 2, 'en', 'Uncategorized Product 2', '2026-03-27 08:20:41', '2026-03-27 08:20:41'),
(1958, 'products', 'slug', 3, 'en', 'uncategorized-product-3', '2026-03-27 08:20:57', '2026-03-27 08:20:57'),
(1959, 'products', 'name', 3, 'en', 'Uncategorized Product 3', '2026-03-27 08:20:57', '2026-03-27 08:20:57'),
(1960, 'products', 'slug', 4, 'en', 'test-product-1', '2026-03-27 11:18:04', '2026-03-27 11:18:04'),
(1961, 'products', 'name', 4, 'en', 'Test Product 1', '2026-03-27 11:18:04', '2026-03-27 11:18:04'),
(1962, 'products', 'slug', 5, 'en', 'test-product-2', '2026-03-27 11:19:07', '2026-03-27 11:19:07'),
(1963, 'products', 'name', 5, 'en', 'Test Product 2', '2026-03-27 11:19:07', '2026-03-27 11:19:07'),
(1964, 'products', 'slug', 6, 'en', 'test-product-3', '2026-03-27 11:19:30', '2026-03-27 11:19:30'),
(1965, 'products', 'name', 6, 'en', 'Test Product 3', '2026-03-27 11:19:30', '2026-03-27 11:19:30'),
(1966, 'pages', 'slug', 10, 'en', 'test', '2026-03-27 14:50:03', '2026-03-27 14:50:03'),
(1967, 'pages', 'title', 10, 'en', 'test', '2026-03-27 14:50:03', '2026-03-27 14:50:03'),
(1968, 'products', 'slug', 7, 'en', 'test', '2026-03-27 14:51:19', '2026-03-27 14:51:19'),
(1969, 'products', 'name', 7, 'en', 'test', '2026-03-27 14:51:19', '2026-03-27 14:51:19'),
(1970, 'categories', 'slug', 8, 'en', 'test', '2026-03-27 14:51:30', '2026-03-27 14:51:30'),
(1971, 'categories', 'name', 8, 'en', 'test', '2026-03-27 14:51:30', '2026-03-27 14:51:30'),
(1972, 'news', 'slug', 4, 'en', 'test', '2026-03-27 14:51:46', '2026-03-27 14:51:46'),
(1973, 'news', 'title', 4, 'en', 'test', '2026-03-27 14:51:46', '2026-03-27 14:51:46'),
(1974, 'blogs', 'slug', 4, 'en', 'test', '2026-03-27 14:51:52', '2026-03-27 14:51:52'),
(1975, 'blogs', 'title', 4, 'en', 'test', '2026-03-27 14:51:52', '2026-03-27 14:51:52'),
(1976, 'projects', 'slug', 4, 'en', 'test', '2026-03-27 14:52:04', '2026-03-27 14:52:04'),
(1977, 'projects', 'title', 4, 'en', 'test', '2026-03-27 14:52:04', '2026-03-27 14:52:04'),
(1978, 'references', 'slug', 4, 'en', 'test', '2026-03-27 14:52:19', '2026-03-27 14:52:19'),
(1979, 'references', 'title', 4, 'en', 'test', '2026-03-27 14:52:19', '2026-03-27 14:52:19'),
(1980, 'menu_items', 'title', 1, 'en', 'Başlangıç', '2026-03-29 17:19:24', '2026-03-29 17:20:09'),
(1981, 'menu_items', 'title', 38, 'en', 'Icons', '2026-03-30 14:10:25', '2026-03-30 14:10:25'),
(1984, 'brands', 'name', 1, 'en', 'Brand Test 1', '2026-04-01 12:18:40', '2026-04-01 12:18:40'),
(1985, 'brands', 'name', 2, 'en', 'Brand Test 2', '2026-04-01 12:18:50', '2026-04-01 12:18:50'),
(1986, 'brands', 'name', 3, 'en', 'Brand Test 3', '2026-04-01 12:19:06', '2026-04-01 12:19:06'),
(1987, 'data_rows', 'display_name', 363, 'en', 'Tablo', '2026-04-01 12:41:17', '2026-04-01 12:41:17'),
(1988, 'faqs', 'question', 1, 'en', 'Question test 1', '2026-04-01 13:15:11', '2026-04-01 13:18:05'),
(1989, 'faqs', 'question', 2, 'en', 'Question Test 2', '2026-04-01 13:17:51', '2026-04-01 13:17:51'),
(1990, 'faqs', 'answer', 1, 'en', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2026-04-01 13:18:05', '2026-04-01 13:18:05'),
(1991, 'faqs', 'question', 3, 'en', 'Question Test 3', '2026-04-01 13:18:31', '2026-04-01 13:18:31');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `settings` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `settings`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin test', 'admin@test.com', 'users/default.png\n', NULL, '$2y$10$YgSgEAtEeCirDR0F3UMlIuf.QnrLPmOq.G6lFCGmr7Ik.2e9hFynK', 'H12F1WfQX9vCObAcd636HzN6cgeLBB3RTifDNMw77k07vWz4HF3jljhE9Uib', '{\"locale\":\"tr\"}', '2025-11-07 11:11:47', '2026-03-29 18:56:12'),
(2, 1, 'Mustafa', 'mustafw42@gmail.com', 'users/default.png', NULL, '$2y$10$2iQVRmrsgA7jDotYeSoKZO.HZxccfEjMfcZNKMuK7hWgHHthW4P46', NULL, '{\"locale\":\"tr\"}', '2026-03-25 04:22:10', '2026-03-25 04:22:10');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `videos`
--

CREATE TABLE `videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `embed_code` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `videos`
--

INSERT INTO `videos` (`id`, `order`, `status`, `title`, `description`, `image`, `image_url`, `video`, `video_url`, `embed_code`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Video Test 1', '', NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPOCTym9W3GI8WZ6J-GEqp76bcClWrI_YcEg&s', '[]', NULL, NULL, '2026-03-26 07:09:17', '2026-03-27 21:40:01'),
(2, 2, 1, 'Video Test 2', '', NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPOCTym9W3GI8WZ6J-GEqp76bcClWrI_YcEg&s', '[]', NULL, NULL, '2026-03-26 07:12:29', '2026-03-27 21:40:01'),
(3, 3, 1, 'Video Test 3', '', NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPOCTym9W3GI8WZ6J-GEqp76bcClWrI_YcEg&s', '[]', NULL, NULL, '2026-03-26 07:12:36', '2026-03-27 21:40:01');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`);

--
-- Tablo için indeksler `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories__lft__rgt_parent_id_index` (`_lft`,`_rgt`,`parent_id`);

--
-- Tablo için indeksler `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `counters`
--
ALTER TABLE `counters`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `data_rows`
--
ALTER TABLE `data_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_rows_data_type_id_foreign` (`data_type_id`);

--
-- Tablo için indeksler `data_types`
--
ALTER TABLE `data_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_types_name_unique` (`name`),
  ADD UNIQUE KEY `data_types_slug_unique` (`slug`);

--
-- Tablo için indeksler `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Tablo için indeksler `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Tablo için indeksler `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

--
-- Tablo için indeksler `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`);

--
-- Tablo için indeksler `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`),
  ADD KEY `pages_parent_id_foreign` (`parent_id`);

--
-- Tablo için indeksler `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Tablo için indeksler `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_key_index` (`key`);

--
-- Tablo için indeksler `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_permission_id_index` (`permission_id`),
  ADD KEY `permission_role_role_id_index` (`role_id`);

--
-- Tablo için indeksler `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Tablo için indeksler `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `popups`
--
ALTER TABLE `popups`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_product_code_index` (`product_code`),
  ADD KEY `products_oem_no_index` (`oem_no`),
  ADD KEY `products_barcode_index` (`barcode`);

--
-- Tablo için indeksler `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projects_slug_unique` (`slug`);

--
-- Tablo için indeksler `redirect_301s`
--
ALTER TABLE `redirect_301s`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `references`
--
ALTER TABLE `references`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `references_slug_unique` (`slug`);

--
-- Tablo için indeksler `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Tablo için indeksler `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `social_medias`
--
ALTER TABLE `social_medias`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `translations_table_name_column_name_foreign_key_locale_unique` (`table_name`,`column_name`,`foreign_key`,`locale`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Tablo için indeksler `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `user_roles_user_id_index` (`user_id`),
  ADD KEY `user_roles_role_id_index` (`role_id`);

--
-- Tablo için indeksler `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `counters`
--
ALTER TABLE `counters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `data_rows`
--
ALTER TABLE `data_rows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=371;

--
-- Tablo için AUTO_INCREMENT değeri `data_types`
--
ALTER TABLE `data_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Tablo için AUTO_INCREMENT değeri `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Tablo için AUTO_INCREMENT değeri `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Tablo için AUTO_INCREMENT değeri `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- Tablo için AUTO_INCREMENT değeri `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `photos`
--
ALTER TABLE `photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `popups`
--
ALTER TABLE `popups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `redirect_301s`
--
ALTER TABLE `redirect_301s`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `references`
--
ALTER TABLE `references`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Tablo için AUTO_INCREMENT değeri `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `social_medias`
--
ALTER TABLE `social_medias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1992;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `data_rows`
--
ALTER TABLE `data_rows`
  ADD CONSTRAINT `data_rows_data_type_id_foreign` FOREIGN KEY (`data_type_id`) REFERENCES `data_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL;

--
-- Tablo kısıtlamaları `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Tablo kısıtlamaları `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Tablo kısıtlamaları `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
