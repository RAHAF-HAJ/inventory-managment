-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2020 at 10:15 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `c_management`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `InventoryPurchaseSalesDetails` (IN `whr` VARCHAR(1000), IN `grpby` VARCHAR(1000), IN `hvg` VARCHAR(1000))  BEGIN
declare finalQuery varchar(60000) default '';
SET @finalQuery = CONCAT("SELECT purchase_details_articles_join.inventory_id as inventory_id, purchase_details_articles_join.article_id as article_id, purchase_details_articles_join.desig,purchase_details_articles_join.ref as ref, purchase_details_articles_join.category_id, purchase_details_articles_join.unit_id , SUM(purchase_details_articles_join.qty) as purchase_qty, MAX(purchase_details_articles_join.price) as purchase_maximum_price,\r\n    SUM(purchase_details_articles_join.price * purchase_details_articles_join.qty) as purchase_total_price,\r\n    SUM(purchase_details_articles_join.total_tva) as purchase_total_vat,\r\n    SUM(purchase_details_articles_join.over_all_total) as purchase_over_all_total,\r\n    COALESCE(SUM(sale_details_articles_join.qty), 0) as sale_qty,\r\n    COALESCE(SUM(sale_details_articles_join.price * sale_details_articles_join.qty), 0) as sale_total_price,\r\n    COALESCE(SUM(sale_details_articles_join.total_tva),0) as sale_total_vat,\r\n                         COALESCE(SUM(sale_details_articles_join.total_product_discount),0) as total_product_discount,\r\n    COALESCE(SUM(sale_details_articles_join.total_client_discount),0) as total_client_discount,\r\n    \r\n                         \r\n    COALESCE(SUM(sale_details_articles_join.over_all_total), 0) as sale_over_all_total,\r\n    (SUM(purchase_details_articles_join.qty) - COALESCE(SUM(sale_details_articles_join.qty), 0)) as remaining_qty\r\n    FROM `purchase_details_articles_join`\r\n    LEFT JOIN sale_details_articles_join ON sale_details_articles_join.inventory_id = purchase_details_articles_join.inventory_id\r\n                    WHERE 1 AND ", whr, ' ' , grpby, ' ' ,hvg);
PREPARE stmt FROM @finalQuery;
 EXECUTE stmt;
 DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InventoryTotals` (IN `whr` VARCHAR(1000))  NO SQL
BEGIN
declare finalQuery varchar(60000) default '';
SET @finalQuery = CONCAT("SELECT (SUM(purchase_details_articles_join.total) - COALESCE(SUM(sale_details_articles_join.total),0)) as remaining_purchase_sum, 
            (SUM(purchase_details_articles_join.total_tva) - COALESCE(SUM(sale_details_articles_join.total_tva),0)) as remaining_purchase_tva,
            (SUM(purchase_details_articles_join.over_all_total) - COALESCE(SUM(sale_details_articles_join.over_all_total),0)) as remaining_purchase_ttc
        FROM `purchase_details_articles_join`
LEFT JOIN sale_details_articles_join ON sale_details_articles_join.inventory_id = purchase_details_articles_join.inventory_id
                WHERE 1 AND ", whr);
PREPARE stmt FROM @finalQuery;
 EXECUTE stmt;
 DEALLOCATE PREPARE stmt;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `productRemainingQty` (`article_id` INT(20)) RETURNS INT(20) BEGIN
DECLARE select_var INT(11);

SELECT (SUM(purchase_details_articles_join.qty) - COALESCE(SUM(sale_details_articles_join.qty), 0)) as remaining_qty
INTO select_var
FROM `purchase_details_articles_join`
LEFT JOIN sale_details_articles_join ON sale_details_articles_join.inventory_id = purchase_details_articles_join.inventory_id
where purchase_details_articles_join.article_id = article_id;

RETURN select_var;


END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(20) NOT NULL,
  `ref` varchar(100) NOT NULL,
  `desig` varchar(255) NOT NULL,
  `tva` int(2) NOT NULL,
  `supplier_id` int(20) NOT NULL,
  `category_id` int(20) DEFAULT NULL,
  `unit_id` int(20) NOT NULL,
  `thumb` varchar(255) NOT NULL DEFAULT 'no_thumb.jpg',
  `color` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(20) NOT NULL,
  `updated_by` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `ref`, `desig`, `tva`, `supplier_id`, `category_id`, `unit_id`, `thumb`, `color`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, '4545454545', 'hp laser jet 1555', 10, 1, 1, 1, 'no_thumb.jpg', '', '2020-05-23 16:59:16', '2020-05-23 16:59:16', 1, 1),
(2, '4878787', 'Printer', 20, 2, 2, 1, 'no_thumb.jpg', '', '2020-05-23 16:59:16', '2020-05-23 16:59:16', 1, 1),
(6, 'dkddfkldf', 'PC', 20, 44, 1, 1, 'logo.png', '', '2020-05-23 16:59:16', '2020-05-25 13:07:17', 1, 1),
(7, 'sdkldfdflsdsdsdsdfdf', 'Books', 20, 1, 0, 1, '7.jpg', '', '2020-05-23 16:59:16', '2020-05-25 13:07:22', 1, 1),
(8, '45x55', 'Offices', 20, 1, 2, 1, '8.jpg', '', '2020-05-23 16:59:16', '2020-05-25 13:07:28', 1, 1),
(13, 'fffgggffg', 'Laptips', 20, 1, 0, 1, 'no_thumb.jpg', '', '2020-05-23 16:59:16', '2020-05-25 13:07:33', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(20) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(0, 'Uncategorized'),
(1, 'Technology equipments'),
(2, 'Offieces'),
(3, 'Stationary'),
(4, 'Electrical');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `city` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `is_special` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL DEFAULT '1',
  `updated_by` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `tel`, `email`, `zip_code`, `city`, `address`, `is_special`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(4, 'said hamri', '554', 'ssdd@dd.com', '565656456', 'etetzete', 'zetzetzete', 1, '2020-05-21 00:48:30', '2020-05-28 15:57:12', 1, 1),
(7, 'khalid essaadani', '45458686', 'ssdd@dd.com', '455445', 'FGKLDFKL', '&pound;DFDFMLDFDFMLMO', 1, '2020-05-21 00:48:30', '2020-05-28 15:57:19', 1, 1),
(8, 'sdlaksjdlskad', 'sadsa', 'lkdslsak@lkdsalk.com', '444', 'sajkdskaj', 'salkdjlksajd', 0, '2020-05-20 20:36:26', '2020-05-20 20:36:26', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `manager` int(20) NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `name`, `manager`, `address`) VALUES
(2, 'Tech1', 1, 'Erbil'),
(3, 'Tech2', 3, 'Dahook'),
(5, 'Tech3', 1, 'Kirkuk');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`) VALUES
(1, 'show_clients'),
(2, 'edit_clients'),
(3, 'add_clients'),
(4, 'delete_clients'),
(5, 'show_suppliers'),
(6, 'add_suppliers'),
(7, 'edit_suppliers'),
(8, 'delete_suppliers'),
(9, 'show_sales'),
(10, 'add_sales'),
(11, 'edit_sales'),
(12, 'delete_sales'),
(13, 'show_purchases'),
(14, 'add_purchases'),
(15, 'edit_purchases'),
(16, 'delete_purchases'),
(17, 'show_articles'),
(18, 'add_articles'),
(19, 'edit_articles'),
(20, 'delete_articles'),
(21, 'show_inventories'),
(22, 'add_inventories'),
(23, 'edit_inventories'),
(24, 'delete_inventories'),
(25, 'show_users_roles'),
(26, 'show_inactive_users'),
(27, 'aed_users_roles'),
(28, 'show_logs'),
(29, 'sale_all_inventories');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(20) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `supplier_id` int(20) NOT NULL,
  `car_number` int(11) NOT NULL,
  `date` date NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8 NOT NULL,
  `note` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(20) NOT NULL,
  `updated_by` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `company_name`, `supplier_id`, `car_number`, `date`, `subject`, `note`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(12, 'printer provider', 1, 5546454, '2020-06-22', '&lt;p&gt;This is a printer purchase&lt;/p&gt;&lt;ol&gt;&lt;li&gt;test&lt;/li&gt;&lt;li&gt;dfdf&lt;/li&gt;&lt;/ol&gt;', '&lt;p&gt;This is a printer purchase&lt;/p&gt;&lt;ol&gt;&lt;li&gt;dfdsf&lt;/li&gt;&lt;/ol&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;ul&gt;&lt;li&gt;dfdf&lt;/li&gt;&lt;/ul&gt;', '2020-05-26 15:53:21', '2020-05-31 17:52:02', 1, 1),
(13, 'Books company', 5, 546545, '2020-05-22', '&lt;p&gt;This is a test&lt;/p&gt;', '&lt;p&gt;This is a test&lt;/p&gt;', '2020-05-28 16:21:22', '2020-05-31 17:51:56', 1, 1),
(14, 'cloudapprsq', 6, 564564, '2020-05-22', '', '', '2020-05-31 17:47:13', '2020-05-31 17:47:35', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` int(20) NOT NULL,
  `purchase_id` int(20) NOT NULL,
  `article_id` int(20) NOT NULL,
  `expire` date NOT NULL,
  `price` double NOT NULL,
  `qty` int(11) NOT NULL,
  `inventory_id` int(20) NOT NULL,
  `thumb` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(20) NOT NULL,
  `updated_by` int(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_id`, `article_id`, `expire`, `price`, `qty`, `inventory_id`, `thumb`, `created_at`, `created_by`, `updated_by`, `updated_at`) VALUES
(4, 12, 2, '2020-05-31', 900000, 8, 5, 'a:0:{}', '2020-05-26 15:53:22', 1, 1, '2020-05-31 22:33:31'),
(5, 12, 13, '2020-05-06', 400000, 15, 2, '', '2020-05-26 16:01:13', 0, 1, '2020-05-31 18:19:51'),
(6, 13, 7, '2020-04-30', 5000, 10, 3, 'a:0:{}', '2020-05-28 16:21:23', 1, 1, '2020-05-31 18:20:36'),
(7, 12, 6, '2020-05-05', 4500, 15, 2, '', '2020-05-29 13:54:03', 0, 1, '2020-05-31 18:19:51'),
(8, 14, 2, '2020-04-29', 120000, 15, 5, 'a:0:{}', '2020-05-31 17:47:13', 1, 1, '2020-05-31 18:20:08');

--
-- Triggers `purchase_details`
--
DELIMITER $$
CREATE TRIGGER `PurchaseOrderDeletionConstain` BEFORE DELETE ON `purchase_details` FOR EACH ROW BEGIN
DECLARE remining_qty INT(11);
SET @remining_qty = productRemainingQty(id);
if(remining_qty < qty) THEN
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'table t1 does not support deletion';
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `purchase_details_articles_join`
-- (See below for the actual view)
--
CREATE TABLE `purchase_details_articles_join` (
`purchase_id` int(20)
,`purchase_details_id` int(20)
,`article_id` int(20)
,`inventory_id` int(20)
,`supplier_id` int(20)
,`ref` varchar(100)
,`desig` varchar(255)
,`tva` int(2)
,`category_id` int(20)
,`unit_id` int(20)
,`thumb` varchar(255)
,`color` varchar(20)
,`expire` date
,`price` double
,`qty` int(11)
,`total` double
,`total_tva` double
,`over_all_total` double
);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(20) NOT NULL,
  `role_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Normal user'),
(6, 'Developer'),
(27, 'Viewer');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(20) NOT NULL,
  `permission_id` int(20) NOT NULL,
  `value` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`id`, `role_id`, `permission_id`, `value`) VALUES
(147, 26, 1, 0),
(148, 26, 2, 0),
(149, 26, 3, 0),
(150, 26, 4, 0),
(151, 26, 5, 0),
(152, 26, 6, 0),
(153, 26, 7, 0),
(154, 26, 8, 0),
(155, 26, 9, 1),
(156, 26, 10, 1),
(157, 26, 11, 1),
(158, 26, 12, 1),
(159, 26, 13, 0),
(160, 26, 14, 0),
(161, 26, 15, 0),
(162, 26, 16, 0),
(163, 26, 17, 1),
(164, 26, 18, 1),
(165, 26, 19, 1),
(166, 26, 20, 1),
(167, 26, 21, 0),
(168, 26, 22, 0),
(169, 26, 23, 0),
(170, 26, 24, 0),
(171, 26, 25, 0),
(172, 26, 27, 0),
(173, 26, 26, 0),
(174, 26, 28, 0),
(175, 26, 29, 0),
(176, 27, 1, 1),
(177, 27, 2, 0),
(178, 27, 3, 0),
(179, 27, 4, 0),
(180, 27, 5, 1),
(181, 27, 6, 0),
(182, 27, 7, 0),
(183, 27, 8, 0),
(184, 27, 9, 1),
(185, 27, 10, 0),
(186, 27, 11, 0),
(187, 27, 12, 0),
(188, 27, 13, 1),
(189, 27, 14, 0),
(190, 27, 15, 0),
(191, 27, 16, 0),
(192, 27, 17, 1),
(193, 27, 18, 0),
(194, 27, 19, 0),
(195, 27, 20, 0),
(196, 27, 21, 1),
(197, 27, 22, 0),
(198, 27, 23, 0),
(199, 27, 24, 0),
(200, 27, 25, 0),
(201, 27, 27, 0),
(202, 27, 26, 0),
(203, 27, 28, 0),
(204, 27, 29, 0),
(205, 1, 1, 1),
(206, 1, 2, 1),
(207, 1, 3, 1),
(208, 1, 4, 1),
(209, 1, 5, 0),
(210, 1, 6, 0),
(211, 1, 7, 0),
(212, 1, 8, 0),
(213, 1, 9, 0),
(214, 1, 10, 0),
(215, 1, 11, 0),
(216, 1, 12, 0),
(217, 1, 13, 0),
(218, 1, 14, 0),
(219, 1, 15, 0),
(220, 1, 16, 0),
(221, 1, 17, 0),
(222, 1, 18, 0),
(223, 1, 19, 0),
(224, 1, 20, 0),
(225, 1, 21, 0),
(226, 1, 22, 0),
(227, 1, 23, 0),
(228, 1, 24, 0),
(229, 1, 25, 0),
(230, 1, 27, 0),
(231, 1, 26, 0),
(232, 1, 28, 0),
(233, 1, 29, 0),
(234, 2, 1, 0),
(235, 2, 2, 0),
(236, 2, 3, 0),
(237, 2, 4, 0),
(238, 2, 5, 0),
(239, 2, 6, 0),
(240, 2, 7, 0),
(241, 2, 8, 0),
(242, 2, 9, 0),
(243, 2, 10, 0),
(244, 2, 11, 0),
(245, 2, 12, 0),
(246, 2, 13, 0),
(247, 2, 14, 0),
(248, 2, 15, 0),
(249, 2, 16, 0),
(250, 2, 17, 0),
(251, 2, 18, 0),
(252, 2, 19, 0),
(253, 2, 20, 0),
(254, 2, 21, 0),
(255, 2, 22, 0),
(256, 2, 23, 0),
(257, 2, 24, 0),
(258, 2, 25, 0),
(259, 2, 27, 0),
(260, 2, 26, 0),
(261, 2, 28, 0),
(262, 2, 29, 0),
(263, 6, 1, 0),
(264, 6, 2, 0),
(265, 6, 3, 0),
(266, 6, 4, 0),
(267, 6, 5, 0),
(268, 6, 6, 0),
(269, 6, 7, 0),
(270, 6, 8, 0),
(271, 6, 9, 0),
(272, 6, 10, 0),
(273, 6, 11, 0),
(274, 6, 12, 0),
(275, 6, 13, 0),
(276, 6, 14, 0),
(277, 6, 15, 0),
(278, 6, 16, 0),
(279, 6, 17, 0),
(280, 6, 18, 0),
(281, 6, 19, 0),
(282, 6, 20, 0),
(283, 6, 21, 0),
(284, 6, 22, 0),
(285, 6, 23, 0),
(286, 6, 24, 0),
(287, 6, 25, 0),
(288, 6, 27, 0),
(289, 6, 26, 0),
(290, 6, 28, 0),
(291, 6, 29, 0),
(292, 1, 1, 1),
(293, 1, 2, 1),
(294, 1, 3, 1),
(295, 1, 4, 1),
(296, 1, 5, 1),
(297, 1, 6, 1),
(298, 1, 7, 1),
(299, 1, 8, 1),
(300, 1, 9, 1),
(301, 1, 10, 1),
(302, 1, 11, 1),
(303, 1, 12, 1),
(304, 1, 13, 1),
(305, 1, 14, 1),
(306, 1, 15, 1),
(307, 1, 16, 1),
(308, 1, 17, 1),
(309, 1, 18, 1),
(310, 1, 19, 1),
(311, 1, 20, 1),
(312, 1, 21, 1),
(313, 1, 22, 1),
(314, 1, 23, 1),
(315, 1, 24, 1),
(316, 1, 25, 1),
(317, 1, 27, 1),
(318, 1, 26, 1),
(319, 1, 28, 1),
(320, 1, 29, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `roles_permissions_join`
-- (See below for the actual view)
--
CREATE TABLE `roles_permissions_join` (
`id` int(20)
,`role_name` varchar(100)
,`value` int(1)
,`permission` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(20) NOT NULL,
  `number` int(11) NOT NULL,
  `client_id` int(20) NOT NULL,
  `discount` float NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `subject` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(20) NOT NULL,
  `updated_by` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `number`, `client_id`, `discount`, `date`, `subject`, `note`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(3, 465465, 4, 0, '2020-02-20', '&lt;p&gt;&lt;em&gt;&lt;strong&gt;Test&lt;/strong&gt;&lt;/em&gt;&lt;/p&gt;', '&lt;p&gt;Test&lt;/p&gt;', '2020-05-27 20:07:57', '2020-05-31 17:48:16', 1, 1),
(4, 654654, 7, 0, '2020-03-20', '&lt;p&gt;This is a test&lt;/p&gt;', '', '2020-05-28 22:06:23', '2020-05-31 17:48:11', 1, 1),
(5, 654654, 8, 5, '2020-04-20', '', '', '2020-05-28 22:22:24', '2020-05-31 17:48:05', 1, 1),
(6, 4555, 4, 0, '2020-04-20', '', '', '2020-05-29 23:31:24', '2020-05-31 17:47:58', 1, 1),
(7, 5645, 4, 0, '2020-05-20', '', '', '2020-05-31 17:34:09', '2020-05-31 17:40:47', 1, 1),
(8, 45345, 7, 0, '2020-05-06', '', '', '2020-05-31 17:49:52', '2020-05-31 17:49:52', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` int(20) NOT NULL,
  `sale_id` int(20) NOT NULL,
  `article_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `qty` int(11) NOT NULL,
  `inventory_id` int(20) NOT NULL,
  `discount` float NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(20) NOT NULL,
  `updated_by` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_details`
--

INSERT INTO `sale_details` (`id`, `sale_id`, `article_id`, `price`, `qty`, `inventory_id`, `discount`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(3, 3, 13, 500000, 2, 2, 0, '2020-05-27 20:07:58', '2020-05-29 14:22:41', 1, 1),
(4, 4, 7, 6000, 5, 3, 10, '2020-05-28 22:06:23', '2020-05-28 22:10:30', 1, 1),
(5, 5, 7, 5500, 2, 3, 0, '2020-05-28 22:22:24', '2020-05-28 22:22:24', 1, 1),
(6, 6, 7, 6000, 3, 3, 0, '2020-05-29 23:31:24', '2020-05-29 23:31:24', 1, 1),
(7, 6, 2, 1000000, 5, 5, 0, '2020-05-30 12:27:20', '2020-05-30 12:27:20', 0, 1),
(8, 7, 7, 6000, 2, 3, 0, '2020-05-31 17:34:09', '2020-05-31 17:34:09', 1, 1),
(9, 8, 7, 5500, 10, 3, 0, '2020-05-31 17:49:52', '2020-05-31 17:49:52', 1, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `sale_details_articles_join`
-- (See below for the actual view)
--
CREATE TABLE `sale_details_articles_join` (
`sale_id` int(20)
,`client_id` int(20)
,`inventory_id` int(20)
,`sale_details_id` int(20)
,`article_id` int(11)
,`ref` varchar(100)
,`desig` varchar(255)
,`tva` int(2)
,`category_id` int(20)
,`unit_id` int(20)
,`thumb` varchar(255)
,`color` varchar(20)
,`price` double
,`qty` int(11)
,`product_discount` float
,`client_discount` float
,`total` double
,`total_product_discount` double
,`total_client_discount` double
,`total_tva` double
,`over_all_total` double
);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `city` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `is_special` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL DEFAULT '1',
  `updated_by` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `tel`, `email`, `zip_code`, `city`, `address`, `is_special`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'INFO TECH1', '066556565656', 's.hamri@windowslive.com', '23000', 'Beni Mellal', '101,Hay fdkjdfkjdf, Beni Melall', 1, '2020-05-21 00:48:30', '2020-05-28 15:56:09', 1, 1),
(3, 'said hamri', '4554545', 'ssdd@dd.com', '565656456', 'etetzete', 'zetzetzete', 0, '2020-05-21 00:48:30', '2020-05-21 00:48:30', 1, 1),
(4, 'dsf', '464654', 'das@asdsad.com', '5465', '54dsad', 'sdasd', 0, '2020-05-21 00:48:30', '2020-05-21 00:48:30', 1, 1),
(5, 'rahaf haj', '65465465465454', 'test@test.com', '0000', 'Cairo', 'test test, test', 0, '2020-05-21 23:50:31', '2020-05-21 23:50:31', 1, 1),
(6, 'rahaf haj', '06456454', 'sdsad@sdsad.com', '0000', 'damass', 'salah', 0, '2020-05-22 14:17:48', '2020-05-22 14:17:48', 1, 1),
(7, 'rahaf haj', '65465465465454', 'test@test.com', '0000', 'Cairo', 'test test, test', 0, '2020-05-24 12:07:15', '2020-05-24 12:07:15', 1, 1),
(8, 'rahaf haj', '65465465465454', 'test@test.com', '0000', 'Cairo', 'test test, test', 0, '2020-05-24 12:08:55', '2020-05-24 12:08:55', 1, 1),
(9, 'Test test', '465454', 'sdsad@sdsad.com', '12345', 'Dubai', 'test', 0, '2020-05-24 12:56:15', '2020-05-24 12:56:15', 1, 1),
(10, 'Test test', '5646545', 'hamsakdr@yahoo.com', '12345', 'Dubai', 'test', 0, '2020-05-24 12:57:03', '2020-05-24 12:57:03', 1, 1),
(15, 'Test test', '5654654', 'lkdslsak@lkdsalk5454.com', '12345', 'Dubai', 'test', 0, '2020-05-24 13:17:29', '2020-05-24 13:17:29', 1, 1),
(16, 'Test test', '4654654', 'hamsakdr@yahoo.com', '12345', 'Dubai', 'test', 0, '2020-05-24 14:01:54', '2020-05-24 14:01:54', 1, 1),
(17, 'rahaf haj', '65465465465454', 'test@test.com', '0000', 'Cairo', 'test test, test', 0, '2020-05-30 13:14:45', '2020-05-30 13:14:45', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tva`
--

CREATE TABLE `tva` (
  `tva` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tva`
--

INSERT INTO `tva` (`tva`) VALUES
(20),
(14),
(10),
(7);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(20) NOT NULL,
  `unit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit`) VALUES
(1, 'U'),
(2, 'Kg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `login` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `function` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `role_id` int(20) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1',
  `avatar` varchar(255) NOT NULL DEFAULT '0.jpg',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(20) NOT NULL,
  `updated_by` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `email`, `fname`, `lname`, `function`, `phone`, `role_id`, `is_active`, `avatar`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Rahaf@test.com', 'Said', 'HAMRI', 'Admin', '564654564', 1, 0, '1.jpg', '2020-05-21 00:48:30', '2020-05-21 00:48:30', 1, 1),
(3, 'khalid', '94ca247fff5ad413788a1c8d8c80394a246dba1c', 's.hamri@windowslive.com', 'khalid', 'essaadani', 'dev', 'dfdpfl', 2, 1, '0.jpg', '2020-05-21 00:48:30', '2020-05-21 00:48:30', 1, 1),
(4, 'errer', '8356c35003e02a509a7e5c466b9d22712891a1ce', 'erere@ffdf.com', 'dfd', 'df', '', '', 2, 1, '0.jpg', '2020-05-21 00:48:30', '2020-05-21 00:48:30', 1, 1),
(5, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'rahafhaj2@gmail.com', 'rahaf', 'Rahaf', 'teteet', '655465456', 2, 1, '5.jpg', '2020-05-24 15:19:30', '2020-05-24 20:51:20', 1, 1);

-- --------------------------------------------------------

--
-- Structure for view `purchase_details_articles_join`
--
DROP TABLE IF EXISTS `purchase_details_articles_join`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `purchase_details_articles_join`  AS  select `purchases`.`id` AS `purchase_id`,`purchase_details`.`id` AS `purchase_details_id`,`purchase_details`.`article_id` AS `article_id`,`purchase_details`.`inventory_id` AS `inventory_id`,`purchases`.`supplier_id` AS `supplier_id`,`articles`.`ref` AS `ref`,`articles`.`desig` AS `desig`,`articles`.`tva` AS `tva`,`articles`.`category_id` AS `category_id`,`articles`.`unit_id` AS `unit_id`,`articles`.`thumb` AS `thumb`,`articles`.`color` AS `color`,`purchase_details`.`expire` AS `expire`,`purchase_details`.`price` AS `price`,`purchase_details`.`qty` AS `qty`,(`purchase_details`.`qty` * `purchase_details`.`price`) AS `total`,((`purchase_details`.`qty` * `purchase_details`.`price`) * (`articles`.`tva` / 100)) AS `total_tva`,((`purchase_details`.`qty` * `purchase_details`.`price`) + ((`purchase_details`.`qty` * `purchase_details`.`price`) * (`articles`.`tva` / 100))) AS `over_all_total` from ((`purchase_details` join `articles`) join `purchases`) where ((`purchase_details`.`purchase_id` = `purchases`.`id`) and (`purchase_details`.`article_id` = `articles`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `roles_permissions_join`
--
DROP TABLE IF EXISTS `roles_permissions_join`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `roles_permissions_join`  AS  select `roles`.`id` AS `id`,`roles`.`role_name` AS `role_name`,`roles_permissions`.`value` AS `value`,`permissions`.`name` AS `permission` from ((`roles_permissions` join `roles`) join `permissions`) where ((`roles_permissions`.`role_id` = `roles`.`id`) and (`roles_permissions`.`permission_id` = `permissions`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `sale_details_articles_join`
--
DROP TABLE IF EXISTS `sale_details_articles_join`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sale_details_articles_join`  AS  select `sales`.`id` AS `sale_id`,`sales`.`client_id` AS `client_id`,`sale_details`.`inventory_id` AS `inventory_id`,`sale_details`.`id` AS `sale_details_id`,`sale_details`.`article_id` AS `article_id`,`articles`.`ref` AS `ref`,`articles`.`desig` AS `desig`,`articles`.`tva` AS `tva`,`articles`.`category_id` AS `category_id`,`articles`.`unit_id` AS `unit_id`,`articles`.`thumb` AS `thumb`,`articles`.`color` AS `color`,`sale_details`.`price` AS `price`,`sale_details`.`qty` AS `qty`,`sale_details`.`discount` AS `product_discount`,`sales`.`discount` AS `client_discount`,(`sale_details`.`qty` * `sale_details`.`price`) AS `total`,((`sale_details`.`qty` * `sale_details`.`price`) * (`sale_details`.`discount` / 100)) AS `total_product_discount`,((`sale_details`.`qty` * `sale_details`.`price`) * (`sales`.`discount` / 100)) AS `total_client_discount`,((`sale_details`.`qty` * `sale_details`.`price`) * (`articles`.`tva` / 100)) AS `total_tva`,((((`sale_details`.`qty` * `sale_details`.`price`) + ((`sale_details`.`qty` * `sale_details`.`price`) * (`articles`.`tva` / 100))) - ((`sale_details`.`qty` * `sale_details`.`price`) * (`sales`.`discount` / 100))) - ((`sale_details`.`qty` * `sale_details`.`price`) * (`sale_details`.`discount` / 100))) AS `over_all_total` from ((`sale_details` join `articles`) join `sales`) where ((`sale_details`.`sale_id` = `sales`.`id`) and (`sale_details`.`article_id` = `articles`.`id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `articles_ibfk_3` (`category_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manager` (`manager`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `inventory_id` (`inventory_id`),
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `inventory_id` (`inventory_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `login` (`login`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `articles_ibfk_4` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clients_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_ibfk_1` FOREIGN KEY (`manager`) REFERENCES `users` (`id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchases_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `purchase_details_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `purchase_details_ibfk_2` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`),
  ADD CONSTRAINT `purchase_details_ibfk_3` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Constraints for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD CONSTRAINT `sale_details_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `sale_details_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `suppliers_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
