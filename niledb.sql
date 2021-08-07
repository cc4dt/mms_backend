-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 06, 2021 at 10:07 PM
-- Server version: 10.1.48-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `niledb`
--

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `CompanyName`, `CompanyName_ar`, `created_at`, `updated_at`, `create_by`, `update_by`) VALUES
(1, 'HAM', 'هام', NULL, NULL, NULL, NULL);

--
-- Dumping data for table `employees_level`
--

INSERT INTO `employees_level` (`id`, `LevelName`, `LevelName_ar`, `created_at`, `updated_at`, `create_by`, `update_by`) VALUES
(1, 'Admin', 'مدير', NULL, NULL, NULL, NULL),
(2, 'Supervisor', 'مشرف', NULL, NULL, NULL, NULL),
(3, 'TeamLeader', 'قائد فريق', NULL, NULL, NULL, NULL),
(4, 'Dealer', 'خدمات العملاء', NULL, NULL, NULL, NULL),
(5, 'Client', 'العميل', NULL, NULL, NULL, NULL);

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `equ_name`, `equ_name_ar`, `equ_station_id`, `created_at`, `updated_at`) VALUES
(1, 'Dispenser', 'ماكينة الوقود', 100, NULL, NULL),
(2, 'Compressor', 'الكمبرسور', 100, NULL, NULL),
(3, 'Tank&Lines', 'التنك و الخطوط', 100, NULL, NULL),
(4, 'Genset', 'المولد', 100, NULL, NULL),
(6, 'Lighting', 'الإضاءة الخارجية', 100, NULL, NULL),
(7, 'Office', 'المبنى', 100, NULL, NULL),
(8, 'Car wash', 'المغسلة', 100, NULL, NULL),
(9, 'Electrical', 'الكهرباء', 100, NULL, NULL),
(10, 'Other', 'أخرى', 100, NULL, NULL);

--
-- Dumping data for table `equipment_part`
--

INSERT INTO `equipment_part` (`id`, `PartName`, `PartName_ar`, `equ_id`, `created_at`, `updated_at`) VALUES
(1, 'Meter', NULL, 1, NULL, NULL),
(2, 'Totalizer', NULL, 1, NULL, NULL),
(3, 'Electronic Board', NULL, 1, NULL, NULL),
(4, 'Screen', NULL, 1, NULL, NULL),
(5, 'Pulser', NULL, 1, NULL, NULL),
(6, 'Battery 6v', NULL, 1, NULL, NULL),
(7, 'Sensor Switch', NULL, 1, NULL, NULL),
(8, 'Lighting', NULL, 1, NULL, NULL),
(9, 'Filter', NULL, 1, NULL, NULL),
(10, 'Hose', NULL, 1, NULL, NULL),
(11, 'Nozzel', NULL, 1, NULL, NULL),
(12, 'Swivel', NULL, 1, NULL, NULL),
(13, 'Motor', NULL, 1, NULL, NULL),
(14, 'Pump', NULL, 1, NULL, NULL),
(15, 'TANK', NULL, 3, NULL, NULL),
(16, 'STP', NULL, 3, NULL, NULL),
(17, 'DIPSTIC', NULL, 3, NULL, NULL),
(18, 'PIPES', NULL, 3, NULL, NULL),
(19, 'Contactor', NULL, 2, NULL, NULL),
(20, 'Leakage Detector', NULL, 2, NULL, NULL),
(21, 'MCB 3Phase', NULL, 2, NULL, NULL),
(22, 'MCB Single Phase', NULL, 2, NULL, NULL),
(23, 'MCCB', NULL, 2, NULL, NULL),
(24, 'Overload', NULL, 2, NULL, NULL),
(25, 'Phase Failure', NULL, 2, NULL, NULL),
(26, 'Push Double', NULL, 2, NULL, NULL),
(27, 'Push Single', NULL, 2, NULL, NULL),
(28, 'Selector Switch', NULL, 2, NULL, NULL),
(29, 'Shunt Trip', NULL, 2, NULL, NULL);

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_customer_table', 1),
(2, '2014_10_12_000000_create_cwdamage_table', 1),
(3, '2014_10_12_000000_create_equipment_part_table', 1),
(4, '2014_10_12_000000_create_equipment_table', 1),
(5, '2014_10_12_000000_create_genset_table', 1),
(6, '2014_10_12_000000_create_location_table', 2),
(7, '2014_10_12_000000_create_users_table', 2),
(8, '2014_10_12_000000_create_zoness_dispenser_table', 2),
(9, '2019_08_19_000000_create_failed_jobs_table', 2),
(10, '2020_03_27_000000_create_close_ticket_table', 3),
(11, '2020_03_27_000000_create_company_table', 3),
(12, '2020_03_27_000000_create_employees_level_table', 3),
(13, '2020_03_27_000000_create_worktype_table', 3),
(14, '2020_03_27_000000_create_zones_table', 3),
(15, '2020_03_27_000000_create_workstatus_table', 4);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `username`, `Positions`, `DepartmentNo`, `Extension`, `HideCost`, `WorkPhone`, `level`, `DeviceToken`, `CompanyID`, `create_by`, `update_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'm.abdelgadir@protonmail.com', NULL, '$2y$10$w7Tlf1kNeK.ISHOCpMzAmu2.5DEBqW2ZMgUwezQ6q4pzrYCDvbuVG', NULL, 0, 0, 0, -1, NULL, 1, NULL, 1, NULL, NULL, NULL, '2021-08-06 14:00:17', '2021-08-06 14:00:17'),
(2, 'client', 'client@mail.com', NULL, '$2y$10$7qcHfw6Sf7hSkwRPZ0MYBeoAJGVZNf99nVGDiNxkUS3InI8C.xI9y', NULL, 0, 0, 0, -1, NULL, 5, NULL, 1, NULL, NULL, NULL, '2021-08-06 14:01:37', '2021-08-06 14:01:37'),
(3, 'teamleader', 'teamleader@mail.com', NULL, '$2y$10$UOq8OdHW0ux8Symvg5y2fugRVSqu5Yt/QhEge8kik2rzPOlir.xNi', NULL, 0, 0, 0, -1, NULL, 3, NULL, 1, NULL, NULL, NULL, '2021-08-06 14:03:05', '2021-08-06 14:03:05'),
(4, 'supervisor', 'supervisor@mail.com', NULL, '$2y$10$CbW3WsuickJ1AOx8A6Vm3.5jHMeFFgeaLMwoVkeHQ7CUN2ILOKd.a', NULL, 0, 0, 0, -1, NULL, 2, NULL, 1, NULL, NULL, NULL, '2021-08-06 14:04:25', '2021-08-06 14:04:25');

--
-- Dumping data for table `workstatus`
--

INSERT INTO `workstatus` (`id`, `WorkStatus`, `WorkStatus_ar`, `created_at`, `updated_at`, `create_by`, `update_by`) VALUES
(1, 'Open', ' مفتوح', NULL, NULL, NULL, NULL),
(2, 'Closed', 'مغلق', NULL, NULL, NULL, NULL),
(3, 'Cancelled', 'ملغي', NULL, NULL, NULL, NULL),
(4, 'Waiting for Spare Parts', 'بانتظار قطع غيار', NULL, NULL, NULL, NULL),
(5, 'Waiting for Approval', 'بانتظار موافقة الادارة', NULL, NULL, NULL, NULL),
(6, 'Waiting for Access', 'بانتظار الوصول', NULL, NULL, NULL, NULL),
(7, 'Transfer To Job', 'تم التحويل الى مهمة', NULL, NULL, NULL, NULL),
(8, 'Pending', 'معلقة', NULL, NULL, NULL, NULL),
(9, 'Needs Approval From Client', 'بانتظار موافقة العميل', NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
