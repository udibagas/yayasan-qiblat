-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: qiblat
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `carousel_buttons`
--

DROP TABLE IF EXISTS `carousel_buttons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carousel_buttons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `carousel_id` int(10) unsigned NOT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label_en` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_ar` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carousel_buttons`
--

LOCK TABLES `carousel_buttons` WRITE;
/*!40000 ALTER TABLE `carousel_buttons` DISABLE KEYS */;
INSERT INTO `carousel_buttons` VALUES (1,2,'Donasi Sekarang','Donate Now','Donate Now','primary','/program','2019-02-24 04:18:40','2019-02-24 04:20:29'),(2,2,'Download Brosur','Download Brochure','Download Brochure','primary','/brosur','2019-02-24 04:18:40','2019-02-24 04:20:29');
/*!40000 ALTER TABLE `carousel_buttons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carousels`
--

DROP TABLE IF EXISTS `carousels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carousels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carousels`
--

LOCK TABLES `carousels` WRITE;
/*!40000 ALTER TABLE `carousels` DISABLE KEYS */;
INSERT INTO `carousels` VALUES (2,'YAYASAN QIBLAT','Kewajiban dakwah yang di bebankan pada setiap kamu muslimin untuk melahirkan gerakan positif bagi kemajuan bangsa dan negara, Gerakan dakwah tersebut bukan hanya di atas mimbar tetapi juga akan lebih banyak pada aplikasi kemasyarakatan inilah yang di contohkan rasulullah Shallallahu ‘alaihi wasalam agar kita terus beramal berbuat sesuatu untuk agama Allah dengan berdakwah.',NULL,NULL,NULL,NULL,'/uploads/1550981997header-bg.jpg',1,'2019-02-09 15:12:54','2019-02-24 04:20:29');
/*!40000 ALTER TABLE `carousels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `donations`
--

DROP TABLE IF EXISTS `donations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `donations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `program_id` int(10) unsigned NOT NULL,
  `program_package_id` int(10) unsigned NOT NULL,
  `amount` bigint(20) unsigned NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `expired_at` datetime DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `external_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merchant_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billable_amount` int(10) unsigned DEFAULT NULL,
  `received_amount` int(10) unsigned DEFAULT NULL,
  `xendit_fee_amount` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donations`
--

LOCK TABLES `donations` WRITE;
/*!40000 ALTER TABLE `donations` DISABLE KEYS */;
INSERT INTO `donations` VALUES (1,1,1,3,3000000,'0',NULL,NULL,NULL,NULL,'2019-02-20 07:35:38','2019-02-20 07:35:38',NULL,NULL,NULL,NULL,NULL),(2,1,1,3,3000000,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket C','2019-02-20 07:46:35','2019-02-20 07:46:35',NULL,NULL,NULL,NULL,NULL),(3,1,1,3,3000000,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket C','2019-02-20 07:47:07','2019-02-20 07:47:07',NULL,NULL,NULL,NULL,NULL),(4,1,1,3,3000000,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket C','2019-02-20 07:48:27','2019-02-20 07:48:27',NULL,NULL,NULL,NULL,NULL),(5,1,1,3,3000000,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket C','2019-02-20 08:15:35','2019-02-20 08:15:35',NULL,NULL,NULL,NULL,NULL),(6,1,1,1,100000,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket A','2019-02-20 08:17:54','2019-02-20 08:17:54',NULL,NULL,NULL,NULL,NULL),(7,1,1,2,8999,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket B','2019-02-20 08:22:01','2019-02-20 08:22:01',NULL,NULL,NULL,NULL,NULL),(8,1,1,2,8999,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket B','2019-02-20 08:22:46','2019-02-20 08:22:46',NULL,NULL,NULL,NULL,NULL),(9,1,1,3,3000000,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket C','2019-02-20 08:23:26','2019-02-20 08:23:26',NULL,NULL,NULL,NULL,NULL),(10,1,1,2,8999,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket B','2019-02-20 08:25:57','2019-02-20 08:25:57',NULL,NULL,NULL,NULL,NULL),(11,1,1,3,3000000,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket C','2019-02-20 08:28:07','2019-02-20 08:28:07',NULL,NULL,NULL,NULL,NULL),(12,1,1,3,3000000,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket C','2019-02-20 08:32:19','2019-02-20 08:32:19',NULL,NULL,NULL,NULL,NULL),(13,1,1,3,3000000,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket C','2019-02-20 08:32:38','2019-02-20 08:32:38',NULL,NULL,NULL,NULL,NULL),(14,1,1,3,3000000,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket C','2019-02-20 08:33:29','2019-02-20 08:33:29',NULL,NULL,NULL,NULL,NULL),(15,1,1,3,3000000,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket C','2019-02-20 08:33:36','2019-02-20 08:33:36',NULL,NULL,NULL,NULL,NULL),(16,1,1,3,3000000,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket C','2019-02-20 08:34:37','2019-02-20 08:34:37',NULL,NULL,NULL,NULL,NULL),(17,1,1,3,3000000,'0','2019-02-21 15:59:39',NULL,NULL,'Percetakan Mushaf - Paket C','2019-02-20 08:59:35','2019-02-20 08:59:39',NULL,NULL,NULL,NULL,NULL),(18,1,1,3,3000000,'PENDING','2019-02-21 16:29:25',NULL,NULL,'Percetakan Mushaf - Paket C','2019-02-20 09:29:21','2019-02-20 09:29:25',NULL,NULL,NULL,NULL,NULL),(19,1,1,2,8999,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket B','2019-02-20 09:46:07','2019-02-20 09:46:07',NULL,NULL,NULL,NULL,NULL),(20,1,1,2,8999,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket B','2019-02-20 09:46:24','2019-02-20 09:46:24',NULL,NULL,NULL,NULL,NULL),(21,1,1,2,8999,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket B','2019-02-20 09:50:37','2019-02-20 09:50:37',NULL,NULL,NULL,NULL,NULL),(22,1,1,2,8999,'0',NULL,NULL,NULL,'Percetakan Mushaf - Paket B','2019-02-20 09:51:46','2019-02-20 09:51:46',NULL,NULL,NULL,NULL,NULL),(23,1,1,1,100000,NULL,'1970-01-01 07:00:00',NULL,NULL,'Percetakan Mushaf - Paket A','2019-02-20 14:53:27','2019-02-20 14:53:27',NULL,NULL,NULL,NULL,NULL),(24,1,1,1,100000,NULL,'1970-01-01 07:00:00',NULL,NULL,'Percetakan Mushaf - Paket A','2019-02-20 14:53:36','2019-02-20 14:53:36',NULL,NULL,NULL,NULL,NULL),(25,1,2,2,16000,NULL,'1970-01-01 07:00:00',NULL,NULL,'Pembangunan Masjid - Paket B','2019-02-20 15:18:43','2019-02-20 15:18:43',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `donations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(6,'2019_02_04_150623_create_post_categories_table',2),(7,'2019_02_04_150959_create_posts_table',2),(8,'2019_02_04_151412_create_post_images_table',2),(9,'2019_02_07_072533_add_field_on_users',3),(15,'2019_02_09_113049_create_carousels_table',4),(19,'2019_02_09_113525_create_programs_table',5),(20,'2019_02_09_113831_create_program_packages_table',5),(21,'2019_02_09_114222_create_donations_table',5),(25,'2019_02_09_121434_create_carousel_buttons_table',6),(26,'2019_02_09_122044_create_program_galleries_table',7),(27,'2019_02_09_122321_create_teams_table',8),(30,'2019_02_09_122641_create_settings_table',9),(32,'2019_02_10_081323_create_social_media_table',10),(33,'2019_02_10_202257_add_status_on_posts',11),(34,'2019_02_20_161436_change_field_on_donations',12),(35,'2019_02_20_220106_add_flexible_amount_on_program_packages',13),(36,'2019_02_20_224037_add_external_id_on_donations',14),(37,'2019_02_24_115136_add_type_on_post',15);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_categories`
--

DROP TABLE IF EXISTS `post_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_categories`
--

LOCK TABLES `post_categories` WRITE;
/*!40000 ALTER TABLE `post_categories` DISABLE KEYS */;
INSERT INTO `post_categories` VALUES (1,'nama indonesia','englosh name','arabic name',NULL,'keterangan indo','english description','arabic description',NULL,'2019-02-05 02:45:36','2019-02-05 02:45:36'),(2,'dehfw','jhugu','fhiueh',NULL,'uydguyefew','guyfge','feufe',NULL,'2019-02-05 02:57:35','2019-02-05 02:57:35'),(4,'dehfw','jhugu','fhiueh','/uploads/1549335552adw.png','uydguyefew','guyfge','feufe',NULL,'2019-02-05 02:59:14','2019-02-05 02:59:14');
/*!40000 ALTER TABLE `post_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_images`
--

DROP TABLE IF EXISTS `post_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_images`
--

LOCK TABLES `post_images` WRITE;
/*!40000 ALTER TABLE `post_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_category_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_en` text COLLATE utf8mb4_unicode_ci,
  `content_ar` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,NULL,'Ini judul beritanya',NULL,NULL,'Ini-judul-beritanya',NULL,NULL,'<p>Cupidatat nisi Lorem est duis quis fugiat.Eu sint tempor veniam aute incididunt aliquip anim enim excepteur sit enim nulla minim reprehenderit. Non aute pariatur enim irure qui. Culpa ex qui consectetur laboris elit commodo in cillum duis incididunt ea cillum ullamco. Reprehenderit est laboris aute irure aute commodo irure laborum irure.</p><p><br></p><p>Mollit exercitation pariatur consequat ipsum sint enim sit. Voluptate laboris est veniam consectetur amet exercitation et duis proident eu aliqua. Sint mollit culpa qui est magna ullamco aliqua commodo laboris. Voluptate excepteur eiusmod exercitation cillum dolore in deserunt nostrud.</p><p><br></p><p>Sit eiusmod quis nisi laboris adipisicing nisi dolor. Nisi ipsum deserunt sunt cillum aute eiusmod amet nulla excepteur. Est sit sint aliqua pariatur laboris amet elit cillum reprehenderit ea sit. Elit qui cupidatat ut amet do aliquip et aliqua aute proident nulla cupidatat ullamco cupidatat. Esse consectetur est aute adipisicing aute id.</p><p><br></p><p>Irure do dolor amet ut consequat ex ut occaecat aliqua reprehenderit. Enim minim pariatur do nulla. Minim ut consectetur excepteur eu ea officia pariatur ipsum ea cupidatat. Velit eu duis ut sint elit do ea est cupidatat laborum. Proident duis do consequat duis adipisicing fugiat deserunt id veniam ad ut nostrud eiusmod.</p><p><br></p><p>Excepteur est duis dolor dolore ea. Sunt voluptate veniam ea velit tempor quis adipisicing nostrud irure. Laboris quis ut deserunt dolor laboris tempor deserunt eiusmod pariatur. Sit velit exercitation id ad anim dolore exercitation nisi enim sit voluptate. Aute ex ullamco occaecat adipisicing duis eu velit cillum reprehenderit.</p>',NULL,NULL,'/uploads/1550983611pintu-kementan.png',1,'2019-02-05 14:40:24','2019-02-24 04:46:53',1,'post'),(2,NULL,'Ini judul berita',NULL,NULL,'Ini-judul-berita',NULL,NULL,'<p>Cupidatat nisi Lorem est duis quis fugiat.Eu sint tempor veniam aute incididunt aliquip anim enim excepteur sit enim nulla minim reprehenderit. Non aute pariatur enim irure qui. Culpa ex qui consectetur laboris elit commodo in cillum duis incididunt ea cillum ullamco. Reprehenderit est laboris aute irure aute commodo irure laborum irure.</p><p><br></p><p>Mollit exercitation pariatur consequat ipsum sint enim sit. Voluptate laboris est veniam consectetur amet exercitation et duis proident eu aliqua. Sint mollit culpa qui est magna ullamco aliqua commodo laboris. Voluptate excepteur eiusmod exercitation cillum dolore in deserunt nostrud.</p><p><br></p><p>Sit eiusmod quis nisi laboris adipisicing nisi dolor. Nisi ipsum deserunt sunt cillum aute eiusmod amet nulla excepteur. Est sit sint aliqua pariatur laboris amet elit cillum reprehenderit ea sit. Elit qui cupidatat ut amet do aliquip et aliqua aute proident nulla cupidatat ullamco cupidatat. Esse consectetur est aute adipisicing aute id.</p><p><br></p><p>Irure do dolor amet ut consequat ex ut occaecat aliqua reprehenderit. Enim minim pariatur do nulla. Minim ut consectetur excepteur eu ea officia pariatur ipsum ea cupidatat. Velit eu duis ut sint elit do ea est cupidatat laborum. Proident duis do consequat duis adipisicing fugiat deserunt id veniam ad ut nostrud eiusmod.</p><p><br></p><p>Excepteur est duis dolor dolore ea. Sunt voluptate veniam ea velit tempor quis adipisicing nostrud irure. Laboris quis ut deserunt dolor laboris tempor deserunt eiusmod pariatur. Sit velit exercitation id ad anim dolore exercitation nisi enim sit voluptate. Aute ex ullamco occaecat adipisicing duis eu velit cillum reprehenderit.</p>',NULL,NULL,'/uploads/1550983726asset.png',1,'2019-02-05 14:41:35','2019-02-24 04:48:48',1,'post'),(3,NULL,'Ini judul beritaddddddd','ok siap','jos','Ini-judul-beritaddddddd',NULL,NULL,'<p>Cupidatat nisi Lorem est duis quis fugiat.Eu sint tempor veniam aute incididunt aliquip anim enim excepteur sit enim nulla minim reprehenderit. Non aute pariatur enim irure qui. Culpa ex qui consectetur laboris elit commodo in cillum duis incididunt ea cillum ullamco. Reprehenderit est laboris aute irure aute commodo irure laborum irure.</p><p><br></p><p>Mollit exercitation pariatur consequat ipsum sint enim sit. Voluptate laboris est veniam consectetur amet exercitation et duis proident eu aliqua. Sint mollit culpa qui est magna ullamco aliqua commodo laboris. Voluptate excepteur eiusmod exercitation cillum dolore in deserunt nostrud.</p><p><br></p><p>Sit eiusmod quis nisi laboris adipisicing nisi dolor. Nisi ipsum deserunt sunt cillum aute eiusmod amet nulla excepteur. Est sit sint aliqua pariatur laboris amet elit cillum reprehenderit ea sit. Elit qui cupidatat ut amet do aliquip et aliqua aute proident nulla cupidatat ullamco cupidatat. Esse consectetur est aute adipisicing aute id.</p><p><br></p><p>Irure do dolor amet ut consequat ex ut occaecat aliqua reprehenderit. Enim minim pariatur do nulla. Minim ut consectetur excepteur eu ea officia pariatur ipsum ea cupidatat. Velit eu duis ut sint elit do ea est cupidatat laborum. Proident duis do consequat duis adipisicing fugiat deserunt id veniam ad ut nostrud eiusmod.</p><p><br></p><p>Excepteur est duis dolor dolore ea. Sunt voluptate veniam ea velit tempor quis adipisicing nostrud irure. Laboris quis ut deserunt dolor laboris tempor deserunt eiusmod pariatur. Sit velit exercitation id ad anim dolore exercitation nisi enim sit voluptate. Aute ex ullamco occaecat adipisicing duis eu velit cillum reprehenderit.</p>','<p>ok siap</p>','<p>jos gandhow</p>','/uploads/1549377964500px-Opi_gpio.png',1,'2019-02-05 14:43:44','2019-02-24 04:48:23',1,'post'),(4,NULL,'Tentang Kami',NULL,NULL,'Tentang-Kami',NULL,NULL,'<p>Kewajiban dakwah yang di bebankan pada setiap kamu muslimin untuk melahirkan gerakan positif bagi kemajuan bangsa dan negara, Gerakan dakwah tersebut bukan hanya di atas mimbar tetapi juga akan lebih banyak pada aplikasi kemasyarakatan inilah yang di contohkan rasulullah Shallallahu ‘alaihi wasalam agar kita terus beramal berbuat sesuatu untuk agama Allah dengan berdakwah.</p>',NULL,NULL,'/uploads/1550989457header-bg.jpg',1,'2019-02-24 06:14:58','2019-02-24 06:24:19',1,'page');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program_galleries`
--

DROP TABLE IF EXISTS `program_galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `program_galleries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `program_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_galleries`
--

LOCK TABLES `program_galleries` WRITE;
/*!40000 ALTER TABLE `program_galleries` DISABLE KEYS */;
INSERT INTO `program_galleries` VALUES (1,2,1,'/uploads/1549797492500px-Opi_gpio.png','ini jos gandhos','ini jos',NULL,NULL,NULL,NULL,'2019-02-10 11:20:20','2019-02-10 13:06:06'),(2,3,1,'/uploads/1549803855allianz-field-carousel.jpg','Jos','lorem ipsum door sit amet',NULL,NULL,NULL,NULL,'2019-02-10 13:04:31','2019-02-10 13:04:31'),(3,6,1,'/uploads/1549804014mencurigakan1.png','jfiwehf','dhwhfw',NULL,NULL,NULL,NULL,'2019-02-10 13:06:55','2019-02-10 13:06:55');
/*!40000 ALTER TABLE `program_galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program_packages`
--

DROP TABLE IF EXISTS `program_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `program_packages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `program_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci,
  `price` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `flexible_amount` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_packages`
--

LOCK TABLES `program_packages` WRITE;
/*!40000 ALTER TABLE `program_packages` DISABLE KEYS */;
INSERT INTO `program_packages` VALUES (1,2,'Paket A','Jami\' + Rumah Imam + MCK\nLuas total bangunan 135 m2\nCukup untuk 180 jama\'ah\nTerbuat dari beton, atap dari beton + kayu dan genteng atap\nPintu dan jendela dari kayu\n\n- Harga tersebut sudah termasuk dengan segala perlengkapannya.\n- Yayasan bertanggungjawab dalam hal pengawasan kegiatan da’wah dan perawatan masjid setelah dibangun.\n- Dalam hal donatur menginginkan penambahan luas maka dikenakan biaya 160 USD permeternya.\n- Dalam hal donatur menginginkan pembangunan dengan atap dak betondan atap dengan baja ringan, dan genteng Pintu dan jendela darialumunium maka dikenakan biaya penambahan sebesar 20% dari harga aslinya (200 USD permeter).',NULL,NULL,NULL,NULL,21350,'2019-02-19 03:24:47','2019-02-20 16:20:43',1),(2,2,'Paket B','Jami\' + MCK\nLuas total bangunan 100 m2\nCukup untuk 180 jama\'ah\nTerbuat dari beton, atap dari beton + kayu dan genteng atap\nPintu dan jendela dari kayu\n\n- Harga tersebut sudah termasuk dengan segala perlengkapannya.\n- Yayasan bertanggungjawab dalam hal pengawasan kegiatan da’wah dan perawatan masjid setelah dibangun.\n- Dalam hal donatur menginginkan penambahan luas maka dikenakan biaya 160 USD permeternya.\n- Dalam hal donatur menginginkan pembangunan dengan atap dak betondan atap dengan baja ringan, dan genteng Pintu dan jendela darialumunium maka dikenakan biaya penambahan sebesar 20% dari harga aslinya (200 USD permeter).','aaa',NULL,NULL,NULL,16000,'2019-02-19 03:28:54','2019-02-20 15:18:15',0),(3,3,'Sumur Gali','<p>Cukup untuk 40 rumah perhari</p><p>Komponen : Sumur kedalaman 5 - 10 meter + penampungan air 500 liter + mesin air + tempat wudhu</p>',NULL,NULL,NULL,NULL,800,'2019-02-20 06:24:54','2019-02-20 15:09:54',0),(4,3,'Sumur Bor','<p>Cukup untuk 250 rumah perhari</p><p>Komponen : Sumur kedalaman 50 - 80 meter + penampungan air 1000 liter + mesin air + tempat wudhu</p><p>Pemasangan instalasi air untuk warga</p>',NULL,NULL,NULL,NULL,3734,'2019-02-20 14:56:23','2019-02-20 15:11:08',0);
/*!40000 ALTER TABLE `program_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programs`
--

DROP TABLE IF EXISTS `programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programs`
--

LOCK TABLES `programs` WRITE;
/*!40000 ALTER TABLE `programs` DISABLE KEYS */;
INSERT INTO `programs` VALUES (1,'Percetakan Mushaf','Percetakan Mushaf Quran dan membagikan kepada masyarakat','kfowe','foijewofjg','jnfejwhfw','dkjnkjgre','fa fa-book','2019-02-09 15:42:33','2019-02-10 10:22:16'),(2,'Pembangunan Masjid','Lebih dari 500 Pembangunan Masjid yang kami dirikan',NULL,NULL,NULL,NULL,'fa fa-mosque','2019-02-09 15:44:57','2019-02-10 10:18:52'),(3,'Penggalian Sumur','Pembangunan Sumur untuk memperoleh air bersih',NULL,NULL,NULL,NULL,'far fa-circle','2019-02-09 15:51:25','2019-02-12 02:14:05'),(4,'Program Hikmah','-',NULL,NULL,NULL,NULL,'fas fa-heart','2019-02-10 00:48:29','2019-02-10 10:29:49'),(5,'Pengiriman Da\'i','Memberikan bantuan kepada masyarakat yang membutuhkan',NULL,NULL,NULL,NULL,'fa fa-users','2019-02-10 00:48:44','2019-02-10 10:21:36'),(6,'Pengiriman Imam','Program dakhwah kami sudah menyebar ke berbagai daerah',NULL,NULL,NULL,NULL,'fa fa-user','2019-02-10 00:48:58','2019-02-10 10:21:53'),(7,'Motor Dakwah','Program dakhwah kami sudah menyebar ke berbagai daerah',NULL,NULL,NULL,NULL,'fas fa-motorcycle','2019-02-10 10:18:32','2019-02-10 10:18:32'),(8,'Program \"Bersih Mesjidku\"','-',NULL,NULL,NULL,NULL,'fas fa-broom','2019-02-10 10:23:53','2019-02-12 02:15:39'),(9,'Mujamma Ta\'limi (Islamic Center)','-',NULL,NULL,NULL,NULL,'fa fa-mosque','2019-02-10 10:24:13','2019-02-10 10:24:13');
/*!40000 ALTER TABLE `programs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'name','Name','text','Nama Website','Yasayan Qiblat',NULL,'2019-02-09 10:09:46'),(2,'description','Description','textarea','Deskripsi singkat website','jos',NULL,'2019-02-09 10:09:46'),(3,'contact_phone','Contact Phone','text','Nomor HP yang bisa dihubungi oleh pengunjung','0887677',NULL,'2019-02-09 10:09:46'),(4,'contact_email','Email Address','text','Alamat email untuk surat menyurat','admin@yahoo.com',NULL,'2019-02-09 10:09:46'),(5,'contact_address','Address','textarea','Alamat kantor untuk surat menyurat','Jalan - jalan ke kota santri',NULL,'2019-02-09 10:09:47'),(6,'maps_src','Maps URL','textarea','URL Goole Maps','https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.5366675210166!2d107.04739131477164!3d-6.70415719515308!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x6d3bf43cea27a03b!2zWWF5YXNhbiBRaWJsYXQgKCDZhdik2LPYs9ipINmC2KjZhNipICk!5e0!3m2!1sid!2sid!4v1538979535332',NULL,'2019-02-09 10:09:47');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_media`
--

DROP TABLE IF EXISTS `social_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provider` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_media`
--

LOCK TABLES `social_media` WRITE;
/*!40000 ALTER TABLE `social_media` DISABLE KEYS */;
INSERT INTO `social_media` VALUES (1,'Facebook','fab fa-facebook-f','bagas.udi.sahsangka','https://facebook.com/bagas.udi.sahsangka','2019-02-10 01:29:56','2019-02-10 01:35:50'),(2,'Twitter','fab fa-twitter','@udibagas','https://twitter.com/@udibagas','2019-02-10 01:31:46','2019-02-10 01:35:59'),(3,'Youtube','fab fa-youtube','@yayasanqiblat','https://youtube.com','2019-02-10 10:32:47','2019-02-10 10:32:47'),(4,'Instagram','fab fa-instagram','@yayasanqiblat','https://efewfwe.com','2019-02-10 10:33:24','2019-02-10 10:33:24');
/*!40000 ALTER TABLE `social_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'Bagas','/uploads/1549757029bagas.jpeg','Pria yang sangat tampan dan dermawan','Bagas','Handsome and expensip','Bagas','Jos tenan','2019-02-10 00:04:26','2019-02-10 00:04:26'),(2,'Yasmince','/uploads/154975714801062015(001).jpg','Criwis dan cerdassss',NULL,NULL,NULL,NULL,'2019-02-10 00:05:58','2019-02-10 00:06:05'),(3,'Bayi Yasmin','/uploads/154975718103052013(001).jpg','Mungil dan kecil',NULL,NULL,NULL,NULL,'2019-02-10 00:06:35','2019-02-10 00:06:35');
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` tinyint(1) NOT NULL DEFAULT '0',
  `api_token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `login` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'udibagas','udibagas@gmail.com',NULL,'$2y$10$SlsahjOh5NjIsFKO/AVYpuREyTl3D8WwttjRlR3OIvcS77Kma2gs2','9iJEqQMSBzBxNc0wwAlgvprhrUhcLHbB45RKvCQ8xPJFjZkoVOIh6axuQpaM',9,'1AVSvznmeToU6eDrn74G9zYyHAeLyJaOWP2detIUF0GaMTMCI216b8oyo02f',1,'2019-02-24 14:09:09',25,'2019-02-04 08:01:51','2019-02-24 07:09:09',NULL,NULL,NULL,NULL),(2,'yasminceaa','yasmin@yahoo.com',NULL,'$2y$10$tFyB972I3Rk8/WEljUgSYOevKsvavKNwXYBHTdml2yJdCWS7WWlwi','uC6fSiCGRnHaXPxZXre2rnL5TYvSwt4DQD7rtBNkX38065huI31bLPCrgN4w',0,'9UMul4iRJ9AWsxOn7wbpKrmFtarsfmgnt6gVB1KSrdYrTD2f9i2dLVqBC43a',1,'2019-02-24 14:05:41',1,'2019-02-04 17:15:03','2019-02-24 07:05:41',NULL,NULL,'98983495','Jalan Kandri Barat\nKel. Kandri RT 01/01\nKecamatan Gunung Pati\nSemarang'),(3,'Yasmin','yasmina@yahoo.com',NULL,'$2y$10$NOpenMXw0DYOliXzaIgx2eMz4DS.ibvfsDFSAkByVpJDx3tu7USTG','ia2qenLNrr0LiCr1a6eYJPJK2NpRdgoS0yhZcUcQahqJZEVw1qI6Of5lRpqY',0,'MppRffGMGVJEmbZghzpkpAe24v2UsfAJKzGmwAJRVpLHGOz8CZqSmxWJ2wTb',1,'2019-02-24 13:42:16',1,'2019-02-24 06:39:23','2019-02-24 06:42:16',NULL,NULL,'0877877','hberhbue\r\nihvuehr\r\nihfieurf'),(4,'hamzah','hamzah@gmail.com',NULL,'$2y$10$Hu1KgvdRUj1jsQLEplJx0uiC4LPYFUH0Wu1Ck9IkFrMWPj4rQDWHO','QJdjxQ7ozDa33zfYmqvjy0mcsBklj0ShHt64qyXhscTVHnwELRzolYVa7ZU3',0,'U5LQsSEDgikNdRUhr2GnreZcDDa1eJzFKD5tcm961kjPAgr1OCeMPt41n8vA',1,NULL,0,'2019-02-24 06:59:17','2019-02-24 07:06:14',NULL,NULL,'8798798','jakarta'),(5,'putri','putri@gmail.com',NULL,'$2y$10$2gcOUeLJ/RVoYW0kCXeNheAbGQH36R51BD907Cyyf.sGbVD9yYzDy','yx2sfmJn8Cp0yiTYcvNkUGVzQwrqTEnH4CW9U5pTnjoJTLIRfYIom4JEDpdP',0,'H0sQEO6td1Cq3hXSBnq9TuA8NNvQ555Wtc4IwJ3kwsxyu3F4sInhEopTMW2u',1,NULL,0,'2019-02-24 07:07:20','2019-02-24 07:07:20',NULL,NULL,'07989','jakarta');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-24 22:08:01
