-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 10, 2026 at 03:00 AM
-- Server version: 11.8.8-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u618510429_experiment`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `author` varchar(255) NOT NULL DEFAULT 'Arcane Sanctum',
  `author_avatar` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `reading_time` int(11) NOT NULL DEFAULT 5,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `excerpt`, `content`, `author`, `author_avatar`, `image_url`, `tags`, `featured`, `published_at`, `reading_time`, `created_at`, `updated_at`) VALUES
(1, 'The Art of Shadow Magic: A Beginner\'s Guide', 'shadow-magic-beginners-guide', 'Explore the ancient tradition of shadow work and learn how to harness the hidden power within the darkness of your own soul.', 'Shadow magic is one of the oldest and most misunderstood branches of the arcane arts. Unlike the bright flames of solar magic, shadow work requires you to descend into the depths of your own subconscious — to face the parts of yourself you have long kept hidden. This guide will walk you through the fundamental principles, helping you begin your journey with clarity and safety. The first step is always grounding. Before any shadow work can begin, you must establish a firm connection to the present moment...', 'Morgantha Vex', NULL, NULL, '[\"shadow-magic\",\"beginners\",\"rituals\"]', 1, '2026-07-06 17:42:25', 8, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(2, 'Moon Phase Magic: Harnessing Lunar Energy for Your Spells', 'moon-phase-magic-guide', 'Learn how the waxing, full, waning, and dark moon each carry distinct magical properties that can amplify your practice.', 'The moon is the most powerful celestial influence on magical practice. Each phase offers unique energies that skilled practitioners learn to work with rather than against. The New Moon represents new beginnings and is ideal for setting intentions. The Waxing Moon builds momentum. The Full Moon is peak power. The Waning Moon releases what no longer serves...', 'Elder Caius', NULL, NULL, '[\"moon\",\"lunar-magic\",\"intermediate\"]', 1, '2026-07-02 17:42:25', 6, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(3, '5 Crystals Every Witch Needs on Their Altar', 'essential-altar-crystals', 'From black tourmaline to selenite, discover the five crystals that form the foundation of any powerful magical practice.', 'Building an altar is one of the first acts of a practicing witch, and crystals are among its most important components. Each crystal carries a unique vibrational frequency. The five essentials: Black Tourmaline, Clear Quartz, Obsidian, Amethyst, Rose Quartz...', 'Morgantha Vex', NULL, NULL, '[\"crystals\",\"altar\",\"beginners\"]', 0, '2026-06-25 17:42:25', 5, '2026-07-09 17:42:25', '2026-07-09 17:42:25');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` enum('shop','library') NOT NULL DEFAULT 'shop',
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `type`, `description`, `icon`, `image_url`, `product_count`, `created_at`, `updated_at`) VALUES
(1, 'Spell Kits', 'spell-kits', 'shop', 'Complete ritual spell kits for practitioners', '✦', NULL, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(2, 'Grimoires', 'grimoires', 'shop', 'Digital and physical books of arcane knowledge', '📖', NULL, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(3, 'Crystals', 'crystals', 'shop', 'Sacred crystals and gemstones imbued with energy', '💎', NULL, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(4, 'Tarot', 'tarot', 'shop', 'Tarot decks and divination tools', '🃏', NULL, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(5, 'Runes', 'runes', 'shop', 'Ancient runic sets and oracle stones', 'ᚱ', NULL, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(6, 'Amulets', 'amulets', 'shop', 'Protective talismans and enchanted amulets', '🔮', NULL, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(7, 'Candles', 'candles', 'shop', 'Ritual candles and sacred flame tools', '🕯', NULL, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(8, 'Spells', 'spells', 'library', 'A compendium of ancient spells', '✦', NULL, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(9, 'Rituals', 'rituals', 'library', 'Sacred rituals for every occasion', '⊕', NULL, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(10, 'Moon Phases', 'moon-phases', 'library', 'Harness the power of lunar cycles', '☽', NULL, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'percent',
  `value` decimal(10,2) NOT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `min_order_total` decimal(10,2) DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL,
  `download_count` int(11) NOT NULL DEFAULT 0,
  `max_downloads` int(11) NOT NULL DEFAULT 5,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `library_entries`
--

CREATE TABLE `library_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'Spells',
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `difficulty` enum('Beginner','Intermediate','Advanced') NOT NULL DEFAULT 'Beginner',
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_entries`
--

INSERT INTO `library_entries` (`id`, `title`, `slug`, `category`, `excerpt`, `content`, `difficulty`, `tags`, `featured`, `created_at`, `updated_at`) VALUES
(1, 'The Binding Spell of Seven Shadows', 'binding-spell-seven-shadows', 'Spells', 'An ancient binding working from the medieval grimoire tradition, adapted for modern practitioners.', 'This binding working originates from a 13th-century manuscript found in the monastery of San Cipriano. The original text, written in corrupt Latin and Catalan, describes a ritual for binding harmful energies to a vessel of obsidian. Materials required: black thread (silk preferred), obsidian or black tourmaline, a candle of pure beeswax, and parchment inscribed with the intention...', 'Intermediate', '[\"binding\",\"protection\",\"medieval\"]', 1, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(2, 'Full Moon Releasing Ritual', 'full-moon-releasing-ritual', 'Rituals', 'Harness the powerful energy of the full moon to release what no longer serves you.', 'The full moon is the most potent time in the lunar cycle for releasing magic. Begin by cleansing your space with sage, palo santo, or simply salt water sprinkled at the thresholds. Set up your altar facing east — the direction of new beginnings. Bring your burdens into that light and release them to the cosmos...', 'Beginner', '[\"moon\",\"releasing\",\"full-moon\"]', 1, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(3, 'The Elder Futhark: A Complete Guide to Norse Rune Reading', 'elder-futhark-complete-guide', 'Runes', 'Master the 24 runes of the Elder Futhark, understanding their individual meanings and origins.', 'The Elder Futhark is the oldest form of the runic alphabet, used by Germanic tribes from roughly the 2nd to 8th centuries CE. Each of the 24 runes is not merely a letter but a cosmic force — a condensed symbol containing entire worlds of meaning. Fehu, the first rune, speaks of cattle, wealth, and the mobile nature of fortune...', 'Advanced', '[\"runes\",\"norse\",\"divination\"]', 1, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(4, 'Amethyst: Crystal of Dreams and Spiritual Protection', 'amethyst-crystal-guide', 'Crystals', 'Discover the rich magical and metaphysical properties of amethyst.', 'Amethyst, with its stunning violet hues ranging from pale lavender to deep purple-black, has been a stone of spiritual significance since at least ancient Greece. In crystal magic, amethyst enhances psychic abilities and intuition, protects the aura, calms an overactive mind, and facilitates access to higher states of consciousness...', 'Beginner', '[\"crystals\",\"amethyst\",\"psychic\"]', 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25');

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
(4, '2024_01_01_000001_create_categories_table', 1),
(5, '2024_01_01_000002_create_products_table', 1),
(6, '2024_01_01_000003_create_blog_posts_table', 1),
(7, '2024_01_01_000004_create_library_entries_table', 1),
(8, '2024_01_01_000005_create_orders_table', 1),
(9, '2024_01_01_000006_create_testimonials_table', 1),
(10, '2026_07_08_000001_add_role_and_status_to_users_table', 1),
(11, '2026_07_09_171224_add_payment_and_digital_fields_to_orders_and_products', 1),
(12, '2026_07_09_171224_create_coupons_table', 1),
(13, '2026_07_09_171225_create_downloads_table', 1),
(14, '2026_07_09_171226_create_audit_logs_table', 1),
(15, '2026_07_09_171227_create_payment_settings_table', 1),
(16, '2026_07_09_171505_create_settings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'card',
  `payment_gateway` varchar(255) NOT NULL DEFAULT 'manual',
  `payment_reference` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `fulfilled_at` timestamp NULL DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `coupon_code` varchar(255) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`items`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `email`, `payment_method`, `payment_gateway`, `payment_reference`, `status`, `paid_at`, `fulfilled_at`, `subtotal`, `discount`, `coupon_code`, `total`, `items`, `created_at`, `updated_at`) VALUES
(1, 'Saurabh', 'roamyards@gmail.com', 'manual', 'manual', NULL, 'pending_payment', NULL, NULL, 99.98, 0.00, NULL, 99.98, '[{\"product_id\":1,\"name\":\"Shadow Moon Ritual Kit\",\"slug\":\"shadow-moon-ritual-kit\",\"price\":49.99,\"quantity\":2,\"image_url\":null,\"type\":\"physical\"}]', '2026-07-09 17:54:16', '2026-07-09 17:54:16');

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
-- Table structure for table `payment_settings`
--

CREATE TABLE `payment_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `lore` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'physical',
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_size` bigint(20) UNSIGNED DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `rating` decimal(3,1) NOT NULL DEFAULT 0.0,
  `review_count` int(11) NOT NULL DEFAULT 0,
  `in_stock` tinyint(1) NOT NULL DEFAULT 1,
  `stock_qty` int(11) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_new` tinyint(1) NOT NULL DEFAULT 0,
  `is_bestseller` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `lore`, `price`, `original_price`, `type`, `category_id`, `image_url`, `file_path`, `file_name`, `file_size`, `tags`, `rating`, `review_count`, `in_stock`, `stock_qty`, `featured`, `is_new`, `is_bestseller`, `created_at`, `updated_at`) VALUES
(1, 'Shadow Moon Ritual Kit', 'shadow-moon-ritual-kit', 'A complete kit for shadow moon workings, including black salt, obsidian, and a hand-bound grimoire.', 'Forged in the liminal space between worlds, this kit was assembled under the dark moon by the Coven of the Eternal Flame.', 49.99, 69.99, 'physical', 1, NULL, NULL, NULL, NULL, '[\"arcane\",\"ritual\",\"shadow\"]', 4.9, 127, 1, NULL, 1, 1, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(2, 'Elemental Summoning Kit', 'elemental-summoning-kit', 'Invoke the four classical elements with this premium ritual kit.', 'Long have the elements answered the call of those who know the proper words.', 34.99, NULL, 'physical', 1, NULL, NULL, NULL, NULL, '[\"arcane\",\"elemental\"]', 4.7, 83, 1, NULL, 0, 1, 1, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(3, 'The Crimson Codex — Digital Grimoire', 'crimson-codex-digital', 'A 300-page digital grimoire covering spells, rituals, and mystical herbalism.', 'Written by Arcane Sanctum scholars over three decades, the Crimson Codex is the definitive modern grimoire.', 19.99, 29.99, 'digital', 2, NULL, 'digital-seed-content/crimson-codex.txt', 'The-Crimson-Codex.txt', 1992, '[\"grimoire\",\"digital\"]', 4.8, 241, 1, NULL, 0, 0, 1, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(4, 'Necronomicon Replica — Limited Edition', 'necronomicon-replica', 'A beautifully bound limited-edition replica of the forbidden tome.', 'Every crack of the leather spine, every aged page — this is as close as mortals dare come to the original.', 89.99, NULL, 'physical', 2, NULL, NULL, NULL, NULL, '[\"grimoire\",\"limited\"]', 5.0, 19, 1, NULL, 1, 0, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(5, 'Obsidian Sphere Collection', 'obsidian-sphere-collection', 'Three hand-polished obsidian spheres in graduating sizes, perfect for scrying.', 'Obsidian holds the memory of volcanic fire. These spheres were formed in the heart of ancient calderas.', 44.99, NULL, 'physical', 3, NULL, NULL, NULL, NULL, '[\"crystal\",\"obsidian\"]', 4.6, 56, 1, NULL, 1, 0, 1, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(6, 'Amethyst Cluster — Raw Grade A', 'amethyst-cluster-raw', 'A stunning raw amethyst cluster for altar work, meditation, and dream magic.', 'Amethyst has guarded sleepers against the dark since the dawn of civilization.', 29.99, 39.99, 'physical', 3, NULL, NULL, NULL, NULL, '[\"crystal\",\"amethyst\"]', 4.8, 93, 1, NULL, 0, 1, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(7, 'The Arcane Tarot Deck — Gold Edition', 'arcane-tarot-gold-edition', '78-card tarot deck with gold foil edges and a velvet pouch, exclusive to Arcane Sanctum.', 'Illustrated by master occult artist Vael the Grey, each card is a portal.', 59.99, 79.99, 'physical', 4, NULL, NULL, NULL, NULL, '[\"tarot\",\"gold\"]', 4.9, 312, 1, NULL, 1, 1, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(8, 'Digital Tarot Guidebook — PDF', 'digital-tarot-guidebook', 'Comprehensive 150-page PDF guide to reading the Major and Minor Arcana.', 'An essential companion for any tarot practitioner, from novice to adept.', 9.99, 14.99, 'digital', 4, NULL, 'digital-seed-content/tarot-guidebook.txt', 'Digital-Tarot-Guidebook.txt', 2076, '[\"tarot\",\"guide\"]', 4.5, 178, 1, NULL, 0, 0, 1, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(9, 'Elder Futhark Rune Set — Black Onyx', 'elder-futhark-rune-set-onyx', '24 hand-carved black onyx runes with a leather casting cloth and guidebook.', 'Carved under a waxing moon, these onyx runes carry the weight of ancestral memory.', 74.99, NULL, 'physical', 5, NULL, NULL, NULL, NULL, '[\"runes\",\"norse\"]', 4.9, 67, 1, NULL, 1, 1, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(10, 'Seal of Solomon Amulet — Sterling Silver', 'seal-of-solomon-amulet', 'Hand-crafted sterling silver Seal of Solomon amulet on an 18-inch chain.', 'The Seal of Solomon has commanded spirits and protected its wearer since antiquity.', 54.99, NULL, 'physical', 6, NULL, NULL, NULL, NULL, '[\"amulet\",\"silver\"]', 4.7, 44, 1, NULL, 0, 0, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(11, 'Black Moon Ritual Candle Set', 'black-moon-ritual-candle-set', 'Set of 7 hand-poured black beeswax ritual candles infused with onycha and mugwort.', 'Each candle burns for 12 hours, releasing a veil of sacred smoke.', 24.99, 34.99, 'physical', 7, NULL, NULL, NULL, NULL, '[\"candles\",\"ritual\"]', 4.6, 189, 1, NULL, 0, 1, 0, '2026-07-09 17:42:25', '2026-07-09 17:42:25');

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

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Spell Enchantment', '2026-07-09 17:53:16', '2026-07-09 17:53:16'),
(2, 'site_tagline', NULL, '2026-07-09 17:53:16', '2026-07-09 17:53:16'),
(3, 'contact_email', 'contact@spellenchantment.com', '2026-07-09 17:53:16', '2026-07-09 17:53:16'),
(4, 'facebook_url', NULL, '2026-07-09 17:53:16', '2026-07-09 17:53:16'),
(5, 'instagram_url', 'https://www.instagram.com/card.whispers', '2026-07-09 17:53:16', '2026-07-09 17:53:16'),
(6, 'twitter_url', NULL, '2026-07-09 17:53:16', '2026-07-09 17:53:16'),
(7, 'footer_text', NULL, '2026-07-09 17:53:16', '2026-07-09 17:53:16');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `product` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `author`, `location`, `avatar_url`, `content`, `rating`, `product`, `created_at`, `updated_at`) VALUES
(1, 'Seraphina M.', 'New Orleans, USA', NULL, 'The Shadow Moon Ritual Kit transformed my practice completely. Every element is chosen with intention — the obsidian sphere alone is worth the price. This is the real thing.', 5, 'Shadow Moon Ritual Kit', '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(2, 'Dorian K.', 'Edinburgh, Scotland', NULL, 'The Arcane Tarot Deck surpassed every expectation. The gold foil catches candlelight in the most magical way. My readings have become deeper and more nuanced.', 5, 'The Arcane Tarot Deck — Gold Edition', '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(3, 'Isolde V.', 'Amsterdam, Netherlands', NULL, 'I was skeptical about ordering crystals online. The obsidian spheres are absolutely stunning. The largest one is perfectly polished and I can use it for scrying.', 4, 'Obsidian Sphere Collection', '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(4, 'Caspian R.', 'Melbourne, Australia', NULL, 'The Crimson Codex is extraordinary. 300 pages of genuinely useful content — no fluff. The chapters on planetary hours alone are worth triple the price.', 5, 'The Crimson Codex — Digital Grimoire', '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(5, 'Lyra N.', 'Berlin, Germany', NULL, 'The Elder Futhark Rune Set in black onyx is the most beautiful rune set I have ever held. The engravings are precise and deep. Worth every penny.', 5, 'Elder Futhark Rune Set — Black Onyx', '2026-07-09 17:42:25', '2026-07-09 17:42:25'),
(6, 'Theron A.', 'Chicago, USA', NULL, 'Fast shipping, exceptional packaging, and a personal note from the shop. The Black Moon Ritual Candles smell absolutely divine. Already reordered.', 4, 'Black Moon Ritual Candle Set', '2026-07-09 17:42:25', '2026-07-09 17:42:25');

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
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@spellenchantment.com', NULL, '$2y$12$i4j/VHdpIvki8FOZuH0DjuPFxNLgfkiNVN/IaleKcQz.oIBSfKVGi', 'admin', 'active', 'z8Nqcb9NpU5QzslW6VxxShBZIEwx3jaS8x5wpQyMtbeIsYZscklyiRGlvCnu', '2026-07-09 17:49:07', '2026-07-09 17:51:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `downloads_token_unique` (`token`),
  ADD KEY `downloads_order_id_foreign` (`order_id`),
  ADD KEY `downloads_product_id_foreign` (`product_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `library_entries`
--
ALTER TABLE `library_entries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `library_entries_slug_unique` (`slug`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_settings`
--
ALTER TABLE `payment_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_settings_key_unique` (`key`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
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
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_entries`
--
ALTER TABLE `library_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_settings`
--
ALTER TABLE `payment_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `downloads`
--
ALTER TABLE `downloads`
  ADD CONSTRAINT `downloads_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `downloads_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
