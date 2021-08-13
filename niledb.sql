-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: 13 أغسطس 2021 الساعة 17:02
-- إصدار الخادم: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gsms`
--

--
-- إرجاع أو استيراد بيانات الجدول `companies`
--

INSERT INTO `companies` (`id`, `name_en`, `name_ar`, `created_at`, `updated_at`) VALUES
(1, 'nile', 'النيل', NULL, NULL);

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `username`, `positions`, `department_no`, `extension`, `hide_cost`, `work_phone`, `level_id`, `company_id`, `created_by_id`, `updated_by_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'm.abdelgadir@protonmail.com', NULL, '$2y$10$w7Tlf1kNeK.ISHOCpMzAmu2.5DEBqW2ZMgUwezQ6q4pzrYCDvbuVG', '', 0, 0, 0, -1, NULL, 1, 1, 1, 1, NULL, NULL, NULL),
(2, 'Supervisor', 'supervisor@mail.com', NULL, '$2y$10$CbW3WsuickJ1AOx8A6Vm3.5jHMeFFgeaLMwoVkeHQ7CUN2ILOKd.a', NULL, 0, 0, 0, -1, NULL, 2, 1, NULL, NULL, NULL, NULL, NULL),
(3, 'Teamleader', 'teamleader@mail.com', NULL, '$2y$10$UOq8OdHW0ux8Symvg5y2fugRVSqu5Yt/QhEge8kik2rzPOlir.xNi', NULL, 0, 0, 0, -1, NULL, 3, 1, NULL, NULL, NULL, NULL, NULL),
(4, 'Client', 'client@mail.com', NULL, '$2y$10$7qcHfw6Sf7hSkwRPZ0MYBeoAJGVZNf99nVGDiNxkUS3InI8C.xI9y', NULL, 0, 0, 0, -1, NULL, 5, 1, NULL, NULL, NULL, NULL, NULL);
COMMIT;
--
-- إرجاع أو استيراد بيانات الجدول `equipment`
--

INSERT INTO `equipment` (`id`, `name_en`, `name_ar`, `created_at`, `updated_at`) VALUES
(1, 'Dispenser', 'Dispenser', NULL, NULL),
(2, 'Compressor', 'الكمبرسور', NULL, NULL),
(3, 'Tank&Lines', 'التنك و الخطوط', NULL, NULL),
(4, 'Genset', 'المولد', NULL, NULL),
(6, 'Lighting', 'الإضاءة الخارجية', NULL, NULL),
(7, 'Office', 'المبنى', NULL, NULL),
(8, 'Car wash', 'المغسلة', NULL, NULL),
(9, 'Electrical', 'الكهرباء', NULL, NULL),
(10, 'Other', 'أخرى', NULL, NULL);

--
-- إرجاع أو استيراد بيانات الجدول `breakdowns`
--

INSERT INTO `breakdowns` (`id`, `name_en`, `name_ar`, `equipment_id`, `created_at`, `updated_at`) VALUES
(1, 'Hose Or Nozzle Leakage', 'تسرب خرطوم أو فوهة', 1, NULL, NULL);

--
-- إرجاع أو استيراد بيانات الجدول `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\User', 1, 'dveice', '7f064eb1db19dd78f8beb9139151c36bf05dc06520cd73cc8ee5a54a9a6cf7f3', '[\"*\"]', '2021-08-13 14:44:51', '2021-08-12 21:30:42', '2021-08-13 14:44:51');

--
-- إرجاع أو استيراد بيانات الجدول `states`
--

INSERT INTO `states` (`id`, `name_en`, `name_ar`, `created_at`, `updated_at`) VALUES
(1, 'khartoum', 'الخرطوم', NULL, NULL);

--
-- إرجاع أو استيراد بيانات الجدول `stations`
--

INSERT INTO `stations` (`id`, `name_en`, `name_ar`, `company_id`, `state_id`, `created_at`, `updated_at`) VALUES
(1, 'jabra', 'جبرة', 1, 1, NULL, NULL);

--
-- إرجاع أو استيراد بيانات الجدول `tickets`
--

INSERT INTO `tickets` (`id`, `number`, `station_id`, `breakdown_id`, `open_description`, `teamleader_id`, `type_id`, `trade_id`, `priority_id`, `work_description`, `status_id`, `created_by_id`, `updated_by_id`, `created_at`, `updated_at`) VALUES
(1, '5464812315649', 1, 1, 'lknlknlgrt hvrtr t tycb nvtyn', 1, 1, 2, 1, NULL, 1, 1, 1, '2021-08-12 17:18:06', '2021-08-12 17:24:10'),
(2, '123654987', 1, 1, 'Des Crip', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2021-08-13 13:33:58', '2021-08-13 13:33:58'),
(3, '123654', 1, 1, 'Des Crip', 1, 2, 1, 1, 'Work Des Crip', 6, 1, 1, '2021-08-13 13:41:13', '2021-08-13 14:12:20'),
(4, '1628872938', 1, 1, 'Des Crip 2', 1, 2, 1, 1, 'Work Des Crip 2', 6, 1, 1, '2021-08-13 14:42:18', '2021-08-13 14:42:55');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
