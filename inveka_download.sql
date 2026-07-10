-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: INVEKA
-- ------------------------------------------------------
-- Server version	8.0.46-0ubuntu0.24.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `barangs`
--

DROP TABLE IF EXISTS `barangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kategori_barang_id` bigint unsigned NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_jual` decimal(15,2) NOT NULL DEFAULT '0.00',
  `harga_beli_terakhir` decimal(15,2) NOT NULL DEFAULT '0.00',
  `stok` int NOT NULL DEFAULT '0',
  `stok_minimum` int NOT NULL DEFAULT '0',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `ukuran` enum('kecil','sedang','besar') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `berat` enum('ringan','sedang','berat') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `barangs_kategori_barang_id_foreign` (`kategori_barang_id`),
  CONSTRAINT `barangs_kategori_barang_id_foreign` FOREIGN KEY (`kategori_barang_id`) REFERENCES `kategori_barangs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barangs`
--

LOCK TABLES `barangs` WRITE;
/*!40000 ALTER TABLE `barangs` DISABLE KEYS */;
INSERT INTO `barangs` VALUES (1,1,'Palu merk A',20000.00,10000.00,45,48,'barang/01KVPZTZYRXRH1S2EYY3FW3GQ4.webp','josjis','sedang','berat',NULL,'2026-06-22 06:21:14','2026-07-02 14:44:25');
/*!40000 ALTER TABLE `barangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buyers`
--

DROP TABLE IF EXISTS `buyers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buyers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kecamatan_id` bigint unsigned NOT NULL,
  `nama_toko` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_toko` json DEFAULT NULL,
  `jam_buka` time DEFAULT NULL,
  `jam_tutup` time DEFAULT NULL,
  `hari_operasional` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'e.g. Senin - Sabtu',
  `nama_owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buyers_kecamatan_id_foreign` (`kecamatan_id`),
  CONSTRAINT `buyers_kecamatan_id_foreign` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatans` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buyers`
--

LOCK TABLES `buyers` WRITE;
/*!40000 ALTER TABLE `buyers` DISABLE KEYS */;
INSERT INTO `buyers` VALUES (1,1,'Buyer 1','[\"foto-toko/01KW6YRCTFSGQPGSZ4EX65GQMD.png\", \"foto-toko/01KW6XCJ7GHX03DQEDS480WZDS.png\"]','08:00:00','18:00:00','Senin - Sabtu','Owner buyer 1','+628920839203','Jalan','Josjis',NULL,'2026-06-22 06:18:48','2026-06-28 11:47:13'),(2,1,'Toko Dummy 1',NULL,NULL,NULL,NULL,'Owner 1','081294445338','Jl. Dummy No 1','dummy buyer',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(3,1,'Toko Dummy 2',NULL,NULL,NULL,NULL,'Owner 2','081240650295','Jl. Dummy No 2','dummy buyer',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(4,1,'Toko Dummy 3',NULL,NULL,NULL,NULL,'Owner 3','081248282651','Jl. Dummy No 3','dummy buyer',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(5,1,'Toko Dummy 4',NULL,NULL,NULL,NULL,'Owner 4','081243669046','Jl. Dummy No 4','dummy buyer',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(6,1,'Toko Dummy 5',NULL,NULL,NULL,NULL,'Owner 5','081249909864','Jl. Dummy No 5','dummy buyer',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59');
/*!40000 ALTER TABLE `buyers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab','i:1;',1782906696),('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer','i:1782906696;',1782906696),('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0','i:1;',1783003523),('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0:timer','i:1783003523;',1783003523),('laravel-cache-livewire-rate-limiter:75a036ac0fdcb20b35ac6fd6a3875ea2dbe60af1','i:1;',1783439046),('laravel-cache-livewire-rate-limiter:75a036ac0fdcb20b35ac6fd6a3875ea2dbe60af1:timer','i:1783439046;',1783439046),('laravel-cache-livewire-rate-limiter:f896974426459c057a13b1fa82c825d35211455f','i:1;',1783492559),('laravel-cache-livewire-rate-limiter:f896974426459c057a13b1fa82c825d35211455f:timer','i:1783492559;',1783492559),('laravel-cache-spatie.permission.cache','a:3:{s:5:\"alias\";a:0:{}s:11:\"permissions\";a:0:{}s:5:\"roles\";a:0:{}}',1783525388);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cicilan_buyers`
--

DROP TABLE IF EXISTS `cicilan_buyers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cicilan_buyers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penjualan_id` bigint unsigned NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cicilan_buyers_penjualan_id_foreign` (`penjualan_id`),
  CONSTRAINT `cicilan_buyers_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cicilan_buyers`
--

LOCK TABLES `cicilan_buyers` WRITE;
/*!40000 ALTER TABLE `cicilan_buyers` DISABLE KEYS */;
INSERT INTO `cicilan_buyers` VALUES (1,9,'2026-07-13',12500000.00,'DP','2026-07-02 11:05:59','2026-07-02 11:05:59'),(2,9,'2026-07-18',10000000.00,'Cicilan kedua','2026-07-02 11:05:59','2026-07-02 11:05:59'),(3,10,'2026-07-26',10000000.00,'DP','2026-07-02 11:05:59','2026-07-02 11:05:59'),(4,11,'2026-07-09',15000000.00,'DP','2026-07-02 11:05:59','2026-07-02 11:05:59'),(5,11,'2026-07-14',12000000.00,'Cicilan kedua','2026-07-02 11:05:59','2026-07-02 11:05:59'),(6,12,'2026-07-11',5000000.00,'DP','2026-07-02 11:05:59','2026-07-02 11:05:59'),(7,13,'2026-06-17',9000000.00,'DP Lama','2026-07-02 11:05:59','2026-07-02 11:05:59'),(8,14,'2026-06-29',12000000.00,'DP Lama','2026-07-02 11:05:59','2026-07-02 11:05:59'),(9,15,'2026-06-15',6000000.00,'DP Lama','2026-07-02 11:05:59','2026-07-02 11:05:59');
/*!40000 ALTER TABLE `cicilan_buyers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cicilan_suppliers`
--

DROP TABLE IF EXISTS `cicilan_suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cicilan_suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pembelian_supplier_id` bigint unsigned NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cicilan_suppliers_pembelian_supplier_id_foreign` (`pembelian_supplier_id`),
  CONSTRAINT `cicilan_suppliers_pembelian_supplier_id_foreign` FOREIGN KEY (`pembelian_supplier_id`) REFERENCES `pembelian_suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cicilan_suppliers`
--

LOCK TABLES `cicilan_suppliers` WRITE;
/*!40000 ALTER TABLE `cicilan_suppliers` DISABLE KEYS */;
/*!40000 ALTER TABLE `cicilan_suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_barangs`
--

DROP TABLE IF EXISTS `kategori_barangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori_barangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_barangs`
--

LOCK TABLES `kategori_barangs` WRITE;
/*!40000 ALTER TABLE `kategori_barangs` DISABLE KEYS */;
INSERT INTO `kategori_barangs` VALUES (1,'Palu','2026-06-22 06:20:48','2026-06-22 06:20:48');
/*!40000 ALTER TABLE `kategori_barangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kecamatans`
--

DROP TABLE IF EXISTS `kecamatans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kecamatans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kecamatans`
--

LOCK TABLES `kecamatans` WRITE;
/*!40000 ALTER TABLE `kecamatans` DISABLE KEYS */;
INSERT INTO `kecamatans` VALUES (1,'Pedurungan','2026-06-22 06:18:18','2026-06-22 06:18:18');
/*!40000 ALTER TABLE `kecamatans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kunjungan_sales`
--

DROP TABLE IF EXISTS `kunjungan_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kunjungan_sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sales_id` bigint unsigned NOT NULL,
  `buyer_id` bigint unsigned NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `hasil_kunjungan` text COLLATE utf8mb4_unicode_ci,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kunjungan_sales_sales_id_foreign` (`sales_id`),
  KEY `kunjungan_sales_buyer_id_foreign` (`buyer_id`),
  CONSTRAINT `kunjungan_sales_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kunjungan_sales_sales_id_foreign` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kunjungan_sales`
--

LOCK TABLES `kunjungan_sales` WRITE;
/*!40000 ALTER TABLE `kunjungan_sales` DISABLE KEYS */;
INSERT INTO `kunjungan_sales` VALUES (1,1,1,'2026-07-01','sukses',NULL,NULL,'2026-07-01 07:50:13','2026-07-01 07:50:13'),(2,1,6,'2026-07-16','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(3,1,2,'2026-07-07','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(4,1,2,'2026-07-21','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(5,1,3,'2026-07-24','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(6,1,3,'2026-07-16','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(7,1,5,'2026-07-13','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(8,1,6,'2026-07-04','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(9,1,3,'2026-07-25','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(10,1,5,'2026-07-17','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(11,1,4,'2026-07-23','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(12,1,4,'2026-06-01','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(13,1,2,'2026-06-13','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(14,1,6,'2026-06-02','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(15,1,6,'2026-06-24','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(16,1,4,'2026-06-14','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(17,1,4,'2026-06-16','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(18,1,3,'2026-06-19','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(19,1,3,'2026-06-02','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(20,1,4,'2026-06-09','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(21,1,4,'2026-06-09','Order','Kunjungan dummy',NULL,'2026-07-02 11:03:59','2026-07-02 11:03:59'),(22,1,3,'2026-07-23','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(23,1,2,'2026-07-11','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(24,1,6,'2026-07-11','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(25,1,4,'2026-07-14','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(26,1,3,'2026-07-26','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(27,1,5,'2026-07-01','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(28,1,3,'2026-07-02','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(29,1,3,'2026-07-04','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(30,1,5,'2026-07-09','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(31,1,3,'2026-07-04','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(32,1,3,'2026-06-22','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(33,1,3,'2026-06-26','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(34,1,5,'2026-06-07','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(35,1,5,'2026-06-12','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(36,1,3,'2026-06-06','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(37,1,6,'2026-06-14','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(38,1,6,'2026-06-20','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(39,1,3,'2026-06-23','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(40,1,4,'2026-06-20','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(41,1,5,'2026-06-10','Order','Kunjungan dummy',NULL,'2026-07-02 11:04:25','2026-07-02 11:04:25'),(42,1,5,'2026-07-24','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(43,1,3,'2026-07-02','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(44,1,2,'2026-07-10','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(45,1,5,'2026-07-19','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(46,1,2,'2026-07-10','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(47,1,2,'2026-07-04','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(48,1,2,'2026-07-04','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(49,1,3,'2026-07-21','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(50,1,4,'2026-07-14','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(51,1,6,'2026-07-24','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(52,1,6,'2026-06-04','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(53,1,6,'2026-06-21','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(54,1,4,'2026-06-09','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(55,1,4,'2026-06-18','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(56,1,2,'2026-06-01','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(57,1,5,'2026-06-03','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(58,1,6,'2026-06-13','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(59,1,6,'2026-06-14','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(60,1,4,'2026-06-09','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(61,1,2,'2026-06-12','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:31','2026-07-02 11:05:31'),(62,1,3,'2026-07-15','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(63,1,4,'2026-07-04','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(64,1,2,'2026-07-13','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(65,1,5,'2026-07-26','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(66,1,3,'2026-07-22','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(67,1,4,'2026-07-08','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(68,1,6,'2026-07-22','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(69,1,4,'2026-07-12','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(70,1,2,'2026-07-02','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(71,1,2,'2026-07-17','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(72,1,3,'2026-06-16','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(73,1,6,'2026-06-03','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(74,1,2,'2026-06-12','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(75,1,6,'2026-06-17','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(76,1,5,'2026-06-10','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(77,1,4,'2026-06-20','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(78,1,2,'2026-06-20','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(79,1,3,'2026-06-23','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(80,1,5,'2026-06-20','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(81,1,5,'2026-06-19','Order','Kunjungan dummy',NULL,'2026-07-02 11:05:59','2026-07-02 11:05:59'),(82,1,3,'2026-07-02','sukses','gg',NULL,'2026-07-02 13:31:26','2026-07-02 13:31:26');
/*!40000 ALTER TABLE `kunjungan_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_06_21_133925_create_permission_tables',1),(5,'2026_06_21_134949_create_kecamatans_table',1),(6,'2026_06_21_135044_create_suppliers_table',1),(7,'2026_06_21_140925_create_kategori_barangs_table',1),(8,'2026_06_21_140951_create_sales_table',1),(9,'2026_06_21_141140_create_buyers_table',1),(10,'2026_06_21_141209_create_barangs_table',1),(11,'2026_06_21_141257_create_pembelian_suppliers_table',1),(12,'2026_06_21_141322_create_pembelian_supplier_details_table',1),(13,'2026_06_21_141348_create_cicilan_suppliers_table',1),(14,'2026_06_21_141422_create_penjualans_table',1),(15,'2026_06_21_141458_create_penjualan_details_table',1),(16,'2026_06_21_141526_create_cicilan_buyers_table',1),(17,'2026_06_21_141604_create_kunjungan_sales_table',1),(18,'2026_06_21_141634_create_payroll_sales_table',1),(19,'2026_06_21_143605_add_no_hp_and_role_to_users_table',1),(20,'2026_06_21_145817_add_harga_beli_terakhir_to_barangs_table',1),(21,'2026_06_22_000000_add_status_pembayaran_to_payroll_sales_table',1),(22,'2026_06_22_060951_create_riwayat_harga_juals_table',1),(23,'2026_06_23_042936_create_riwayat_stoks_table',2),(24,'2026_06_23_054314_add_avatar_url_to_users_table',2),(25,'2026_06_28_173642_add_foto_toko_to_buyers_table',3),(26,'2026_06_28_110241_add_jam_operasional_to_buyers_table',4),(27,'2026_06_28_111401_add_hari_operasional_to_buyers_table',5),(28,'2026_07_01_000000_add_hari_kerja_and_daily_rates_to_payroll_sales_table',6),(29,'2026_07_01_000001_add_tanggal_kehadiran_to_payroll_sales_table',6),(30,'2026_07_01_000002_add_username_to_users_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',3);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payroll_sales`
--

DROP TABLE IF EXISTS `payroll_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payroll_sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sales_id` bigint unsigned NOT NULL,
  `bulan` int NOT NULL,
  `tahun` int NOT NULL,
  `total_penjualan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `bonus_persen` decimal(5,2) NOT NULL DEFAULT '0.00',
  `bonus_nominal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `gaji_pokok` decimal(15,2) NOT NULL DEFAULT '0.00',
  `hari_kerja` int NOT NULL DEFAULT '0',
  `tanggal_kehadiran` json DEFAULT NULL,
  `uang_makan_harian` decimal(15,2) NOT NULL DEFAULT '0.00',
  `uang_bensin_harian` decimal(15,2) NOT NULL DEFAULT '0.00',
  `uang_makan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `uang_bensin` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_gaji` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status_pembayaran` enum('belum','sudah_digaji') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payroll_sales_sales_id_foreign` (`sales_id`),
  CONSTRAINT `payroll_sales_sales_id_foreign` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payroll_sales`
--

LOCK TABLES `payroll_sales` WRITE;
/*!40000 ALTER TABLE `payroll_sales` DISABLE KEYS */;
INSERT INTO `payroll_sales` VALUES (4,1,6,2026,27000000.00,0.00,0.00,3000000.00,0,NULL,0.00,0.00,0.00,0.00,3000000.00,'sudah_digaji',NULL,'2026-06-26 15:23:01','2026-07-02 11:05:59'),(5,1,7,2026,64500000.00,0.00,0.00,3000000.00,0,NULL,0.00,0.00,0.00,0.00,3000000.00,'belum',NULL,'2026-07-01 11:48:30','2026-07-02 11:05:59');
/*!40000 ALTER TABLE `payroll_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembelian_supplier_details`
--

DROP TABLE IF EXISTS `pembelian_supplier_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembelian_supplier_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pembelian_supplier_id` bigint unsigned NOT NULL,
  `barang_id` bigint unsigned NOT NULL,
  `qty` int NOT NULL,
  `harga_beli` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembelian_supplier_details_pembelian_supplier_id_foreign` (`pembelian_supplier_id`),
  KEY `pembelian_supplier_details_barang_id_foreign` (`barang_id`),
  CONSTRAINT `pembelian_supplier_details_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pembelian_supplier_details_pembelian_supplier_id_foreign` FOREIGN KEY (`pembelian_supplier_id`) REFERENCES `pembelian_suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembelian_supplier_details`
--

LOCK TABLES `pembelian_supplier_details` WRITE;
/*!40000 ALTER TABLE `pembelian_supplier_details` DISABLE KEYS */;
INSERT INTO `pembelian_supplier_details` VALUES (1,1,1,48,10000.00,480000.00,'2026-06-22 07:11:49','2026-06-22 07:11:49');
/*!40000 ALTER TABLE `pembelian_supplier_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembelian_suppliers`
--

DROP TABLE IF EXISTS `pembelian_suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembelian_suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tanggal_pembelian` date NOT NULL,
  `supplier_id` bigint unsigned NOT NULL,
  `metode` enum('lunas','nyicil') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `sudah_dibayar` decimal(15,2) NOT NULL DEFAULT '0.00',
  `sisa_pembayaran` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_pembelian` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status` enum('lunas','sebagian','belum_dibayar') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_dibayar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembelian_suppliers_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `pembelian_suppliers_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembelian_suppliers`
--

LOCK TABLES `pembelian_suppliers` WRITE;
/*!40000 ALTER TABLE `pembelian_suppliers` DISABLE KEYS */;
INSERT INTO `pembelian_suppliers` VALUES (1,'2026-06-22',1,'lunas',NULL,0.00,0.00,480000.00,'belum_dibayar','2026-06-22 07:11:49','2026-06-22 07:11:49');
/*!40000 ALTER TABLE `pembelian_suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penjualan_details`
--

DROP TABLE IF EXISTS `penjualan_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penjualan_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penjualan_id` bigint unsigned NOT NULL,
  `barang_id` bigint unsigned NOT NULL,
  `qty` int NOT NULL,
  `harga_jual` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penjualan_details_penjualan_id_foreign` (`penjualan_id`),
  KEY `penjualan_details_barang_id_foreign` (`barang_id`),
  CONSTRAINT `penjualan_details_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penjualan_details_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penjualan_details`
--

LOCK TABLES `penjualan_details` WRITE;
/*!40000 ALTER TABLE `penjualan_details` DISABLE KEYS */;
INSERT INTO `penjualan_details` VALUES (1,1,1,1,20000.00,0.00,'2026-06-22 06:21:41','2026-06-22 06:21:41'),(2,7,1,1,20000.00,20000.00,'2026-06-26 16:37:17','2026-06-26 16:37:17'),(3,16,1,1,20000.00,20000.00,'2026-07-02 14:44:25','2026-07-02 14:44:25');
/*!40000 ALTER TABLE `penjualan_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penjualans`
--

DROP TABLE IF EXISTS `penjualans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penjualans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sales_id` bigint unsigned NOT NULL,
  `buyer_id` bigint unsigned NOT NULL,
  `tanggal_beli` date NOT NULL,
  `foto_nota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metode` enum('lunas','cicil') COLLATE utf8mb4_unicode_ci NOT NULL,
  `metode_pembayaran` enum('cash','transfer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `sudah_dibayar` decimal(15,2) NOT NULL DEFAULT '0.00',
  `sisa_pembayaran` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_penjualan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status_bayar` enum('lunas','sebagian','belum_dibayar') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_dibayar',
  `status_persetujuan` enum('pending','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penjualans_sales_id_foreign` (`sales_id`),
  KEY `penjualans_buyer_id_foreign` (`buyer_id`),
  CONSTRAINT `penjualans_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penjualans_sales_id_foreign` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penjualans`
--

LOCK TABLES `penjualans` WRITE;
/*!40000 ALTER TABLE `penjualans` DISABLE KEYS */;
INSERT INTO `penjualans` VALUES (1,1,1,'2026-06-22','nota_penjualan/01KVPZVTX5YDG0W3P55HT2ME3P.avif','lunas','cash',NULL,0.00,0.00,0.00,'lunas','disetujui','2026-06-22 06:21:41','2026-06-22 06:22:38'),(2,1,1,'2026-06-15',NULL,'cicil','transfer',NULL,0.00,0.00,1993695.00,'belum_dibayar','disetujui','2026-06-25 12:33:55','2026-06-25 12:33:55'),(3,1,1,'2026-06-15',NULL,'cicil','transfer',NULL,0.00,0.00,2169196.00,'belum_dibayar','disetujui','2026-06-25 12:33:55','2026-06-25 12:33:55'),(4,1,1,'2026-06-23',NULL,'cicil','transfer',NULL,0.00,0.00,3579666.00,'belum_dibayar','disetujui','2026-06-25 12:33:55','2026-06-25 12:33:55'),(5,1,1,'2026-06-16',NULL,'cicil','transfer',NULL,0.00,0.00,1017157.00,'belum_dibayar','disetujui','2026-06-25 12:33:55','2026-06-25 12:33:55'),(6,1,1,'2026-06-19',NULL,'cicil','transfer',NULL,0.00,0.00,4291438.00,'belum_dibayar','disetujui','2026-06-25 12:33:55','2026-06-25 12:33:55'),(7,1,1,'2026-06-26','nota_penjualan/01KW2CNXGQ4FZVBC71WC14VCRD.jpeg','lunas','cash',NULL,0.00,0.00,20000.00,'lunas','pending','2026-06-26 16:37:17','2026-06-26 16:37:17'),(8,1,2,'2026-07-08',NULL,'lunas','transfer',NULL,0.00,25000000.00,25000000.00,'belum_dibayar','disetujui','2026-07-02 11:05:31','2026-07-02 11:05:31'),(9,1,2,'2026-07-11',NULL,'lunas','transfer',NULL,22500000.00,2500000.00,25000000.00,'belum_dibayar','disetujui','2026-07-02 11:05:59','2026-07-02 11:05:59'),(10,1,3,'2026-07-24',NULL,'lunas','transfer',NULL,10000000.00,10000000.00,20000000.00,'belum_dibayar','disetujui','2026-07-02 11:05:59','2026-07-02 11:05:59'),(11,1,4,'2026-07-07',NULL,'lunas','transfer',NULL,27000000.00,3000000.00,30000000.00,'belum_dibayar','disetujui','2026-07-02 11:05:59','2026-07-02 11:05:59'),(12,1,5,'2026-07-09',NULL,'lunas','transfer',NULL,5000000.00,5000000.00,10000000.00,'belum_dibayar','disetujui','2026-07-02 11:05:59','2026-07-02 11:05:59'),(13,1,2,'2026-06-12',NULL,'lunas','transfer',NULL,9000000.00,6000000.00,15000000.00,'belum_dibayar','disetujui','2026-07-02 11:05:59','2026-07-02 11:05:59'),(14,1,3,'2026-06-24',NULL,'lunas','transfer',NULL,12000000.00,8000000.00,20000000.00,'belum_dibayar','disetujui','2026-07-02 11:05:59','2026-07-02 11:05:59'),(15,1,4,'2026-06-10',NULL,'lunas','transfer',NULL,6000000.00,4000000.00,10000000.00,'belum_dibayar','disetujui','2026-07-02 11:05:59','2026-07-02 11:05:59'),(16,1,6,'2026-07-02','nota_penjualan/01KWHMKHP3YJ49J8FSDBC5W9TC.png','lunas','cash',NULL,0.00,0.00,20000.00,'lunas','pending','2026-07-02 14:44:25','2026-07-02 14:44:25');
/*!40000 ALTER TABLE `penjualans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `riwayat_harga_juals`
--

DROP TABLE IF EXISTS `riwayat_harga_juals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `riwayat_harga_juals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `barang_id` bigint unsigned NOT NULL,
  `harga_lama` decimal(15,2) NOT NULL,
  `harga_baru` decimal(15,2) NOT NULL,
  `tanggal_berubah` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `riwayat_harga_juals_barang_id_foreign` (`barang_id`),
  CONSTRAINT `riwayat_harga_juals_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `riwayat_harga_juals`
--

LOCK TABLES `riwayat_harga_juals` WRITE;
/*!40000 ALTER TABLE `riwayat_harga_juals` DISABLE KEYS */;
/*!40000 ALTER TABLE `riwayat_harga_juals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `riwayat_stoks`
--

DROP TABLE IF EXISTS `riwayat_stoks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `riwayat_stoks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `barang_id` bigint unsigned NOT NULL,
  `tipe` enum('tambah','kurang') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `riwayat_stoks_barang_id_foreign` (`barang_id`),
  CONSTRAINT `riwayat_stoks_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `riwayat_stoks`
--

LOCK TABLES `riwayat_stoks` WRITE;
/*!40000 ALTER TABLE `riwayat_stoks` DISABLE KEYS */;
/*!40000 ALTER TABLE `riwayat_stoks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'super_admin','web','2026-06-26 15:12:27','2026-06-26 15:12:27');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `nama_sales` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `gaji_pokok` decimal(15,2) NOT NULL DEFAULT '0.00',
  `tanggal_bergabung` date NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sales_no_hp_unique` (`no_hp`),
  KEY `sales_user_id_foreign` (`user_id`),
  CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,2,'Sales 1','+62843243343','Jalan',3000000.00,'2026-06-22',NULL,'2026-06-22 06:17:45','2026-06-22 06:17:45');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('hnQKJc2bUsrDkEWnbibUqd2DwIPRRTOnXO9XEcNN',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0','YTo3OntzOjY6Il90b2tlbiI7czo0MDoicklYOW8yR0sycngyWU93eE1BV3lGMXNhZXlHNnB1U2MxOUt2cEtEWiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO3M6NToicm91dGUiO3M6MzA6ImZpbGFtZW50LnNhbGVzLnBhZ2VzLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6ImM5NjBkN2UwMGIzMjliNDUzZGI2N2VmNDYxZGNiNGE3MzIyMjNiYzdkNzZlMDE5Y2UzMTFmYWY0YjUwNDc4YmMiO3M6NjoidGFibGVzIjthOjE6e3M6NDA6ImE0MTgxYmQ4OTI4MmEzMDMxYTcwMjI1MDg4YzI4ZGRjX2NvbHVtbnMiO2E6Njp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6ImZvdG9fdG9rbyI7czo1OiJsYWJlbCI7czo0OiJGb3RvIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJuYW1hX3Rva28iO3M6NToibGFiZWwiO3M6OToiTmFtYSBUb2tvIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoibmFtYV9vd25lciI7czo1OiJsYWJlbCI7czoxMDoiTmFtYSBPd25lciI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MjQ6ImtlY2FtYXRhbi5uYW1hX2tlY2FtYXRhbiI7czo1OiJsYWJlbCI7czo5OiJLZWNhbWF0YW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6Im5vX2hwIjtzOjU6ImxhYmVsIjtzOjEzOiJOby4gSGFuZHBob25lIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo4OiJqYW1fYnVrYSI7czo1OiJsYWJlbCI7czoxNToiSmFtIE9wZXJhc2lvbmFsIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX19fQ==',1783492545),('iELiE4HyqT87Bxf2wMHEG6lZ3DPFaH7YRShEsicZ',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiQWU5ajkyeU1MVVBWdVNGakVvSW9aZk9qaEVDTDFnSVhaSHoxM0xIMCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO3M6NToicm91dGUiO3M6MzA6ImZpbGFtZW50LnNhbGVzLnBhZ2VzLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6ImM5NjBkN2UwMGIzMjliNDUzZGI2N2VmNDYxZGNiNGE3MzIyMjNiYzdkNzZlMDE5Y2UzMTFmYWY0YjUwNDc4YmMiO30=',1783473993);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp_supplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Supplier 1','Fuad','Admin','+6283232322324232','+628323232','Jl. Ngawi','Dekat toko pil koplo',NULL,'2026-06-22 05:37:51','2026-06-22 05:37:51');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sales',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'superadmin',NULL,'superadmin@gmail.com',NULL,NULL,'$2y$12$TcxJ2/o3teFJhnX8c3Byzud8XwoP1mtS7w4Kp/b2l/Q5o6Y3gxlBm','sales','DNINUZ0EwZM3nXxIrFXqdcxGCf7zGGxzHNCX8zpIfPUur2bWQn7vOXRLsAJe','2026-06-22 05:31:15','2026-06-28 10:26:51',NULL),(2,'Sales 1',NULL,'userapp@gmail.com','+62843243343',NULL,'$2y$12$DZDXXyJmqL5yoQ2NsaiiluiDXaRXZbllt3emGvEm6Scvw6g7lxZXG','sales',NULL,'2026-06-22 06:17:03','2026-06-24 14:46:37',NULL),(3,'Super Administrator',NULL,'admin@admin.com',NULL,NULL,'$2y$12$H7YR5y1asF/qperSJGB5ZOPSTSSF0saITrVPE1wYgLOMy6EyHZ9W2','super_admin','u6Cl9TGYarDIJI33uPkx0LZml8fwzcNrSmVZ1hi1BuzPwzXSGBkKZFqciZGq','2026-06-26 15:12:27','2026-07-02 10:23:46',NULL),(4,'sales2','sales2','sales2@gmail.com','+628323232',NULL,'$2y$12$pM9R1qHVW7Md7mXPN1gtjuUAB6B1eLrNEv2izcRImPUQP.iounOKK','sales',NULL,'2026-07-01 14:30:27','2026-07-01 14:30:27',NULL),(5,'Admin','admin','admin@local.com',NULL,NULL,'$2y$12$hKmbi28iygkuMFHPNkuac.iZ.uGqkZyPPpabhk18IPobth5IkIPyi','admin',NULL,'2026-07-07 15:42:46','2026-07-07 15:42:46',NULL),(6,'Labubu','labubu','labubuy@local.com',NULL,NULL,'$2y$12$TrxehH5Tea7/lHH.CYhzeuNGZAaagLALziWERCnPD3DFU5DIt42XO','sales',NULL,'2026-07-07 15:42:47','2026-07-07 15:42:47',NULL);
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

-- Dump completed on 2026-07-08 19:06:43
