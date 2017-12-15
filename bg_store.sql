-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2017 at 04:30 PM
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
-- Database: `bg_store`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `clear_cart` (IN `cartid` INT)  NO SQL
BEGIN

DELETE FROM cartdetail WHERE cartdetail.cart_id=cartid;
CALL update_cart(cartid);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `decrease_quantity` (IN `cartid` INT, IN `pid` INT, OUT `op` VARCHAR(2))  MODIFIES SQL DATA
BEGIN
DECLARE q INT;
DECLARE cprice INT;
DECLARE pprice INT;
SELECT cartdetail.quantity, cartdetail.total_price into q,cprice FROM cartdetail WHERE cart_id=cartid AND product_id=pid;
SELECT product.product_price into pprice FROM product WHERE product.product_id=pid;
IF q>0 then
	SET q=q-1;
	SET cprice=cprice-pprice;
	UPDATE cartdetail SET cartdetail.quantity=q, cartdetail.total_price=cprice WHERE cart_id=cartid AND product_id=pid;
    CALL update_cart(cartid);
    SET op = 'ok';
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_from_cart` (IN `cartid` INT, IN `pid` INT)  NO SQL
BEGIN

DELETE FROM cartdetail WHERE cartdetail.cart_id=cartid AND cartdetail.product_id=pid;
CALL update_cart(cartid);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `increase_quantity` (IN `cartid` INT, IN `pid` INT, OUT `op` VARCHAR(2))  MODIFIES SQL DATA
BEGIN
DECLARE q INT;
DECLARE cprice INT;
DECLARE pprice INT;
SELECT cartdetail.quantity, cartdetail.total_price into q,cprice FROM cartdetail WHERE cart_id=cartid AND product_id=pid;
SELECT product.product_price into pprice FROM product WHERE product.product_id=pid;
SET q=q+1;
SET cprice=cprice+pprice;
UPDATE cartdetail SET cartdetail.quantity=q, cartdetail.total_price=cprice WHERE cart_id=cartid AND product_id=pid;
CALL update_cart(cartid);
SET op = 'ok';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_to_cart` (IN `cartid` INT, IN `pid` INT)  NO SQL
BEGIN
DECLARE price INT;
SELECT product.product_price into price From product WHERE product.product_id=pid;
INSERT INTO `cartdetail`(`cart_id`, `product_id`, `quantity`, `total_price`) VALUES (cartid,pid,1,price);
CALL update_cart(cartid);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_cart` (IN `cartid` INT)  NO SQL
BEGIN

    DECLARE q INT;
    DECLARE p INT;

    SELECT SUM(cartdetail.quantity) INTO q FROM cartdetail 
    WHERE cartdetail.cart_id = cartid;
    SELECT SUM(cartdetail.total_price) INTO p from cartdetail 
    WHERE cartdetail.cart_id = cartid;
    
    UPDATE cart SET cart.quantity = q WHERE cart.cart_id=cartid;
    UPDATE cart SET cart.total_amount = p WHERE cart.cart_id=cartid;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL,
  `address_details` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `address_details`, `user_id`) VALUES
(1, '159/48 Phichaironnarongsongkram Rd.,Pak Phriao Sub-Distrct, Muang District, Saraburi 18000', 4),
(2, 'asdf', 4),
(3, 'New world', 4),
(4, '89/17 AAA condo BBB rd., Abcd , Kalaland', 7),
(5, 'bbbbbbbbbbbbbggggg', 7),
(6, 'mmmmmmmmmmmmaaa', 7),
(7, 'Fuck 1', 10),
(8, 'FUck u 2', 10),
(9, 'asdf', 10);

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`) VALUES
(1, 'John Sandford'),
(2, 'Richard Paul Evans'),
(3, 'Toni Morrison'),
(4, 'Nora Roberts'),
(5, 'Jeffrey Archer'),
(6, 'George R. R. Martin'),
(7, 'Edward Falco'),
(8, 'Ace Atkins'),
(9, 'W. Bruce Cameron'),
(10, 'Craig Johnson'),
(11, 'James Patterson'),
(12, 'James Patterson'),
(13, 'Adriana Trigiani'),
(14, 'William Landay'),
(15, 'Christopher Moore'),
(16, 'Stuart Woods'),
(17, 'Mary Higgins Clark'),
(18, 'Stephen King'),
(19, 'Steve Berry'),
(20, 'Charlaine Harris'),
(21, 'John Grisham'),
(22, 'David Baldacci'),
(23, 'John Irving'),
(24, 'Stephen King'),
(25, 'Hilary Mantel'),
(26, 'Rick Riordan'),
(27, 'Amanda Hocking'),
(28, 'Rick Riordan'),
(29, 'Markus Zusak'),
(30, 'Rick Riordan'),
(31, 'Aprilynne Pike'),
(32, 'John Green'),
(33, 'Veronica Roth'),
(34, 'Kristin Cashore'),
(35, 'John Flanagan'),
(36, 'Veronica Roth'),
(37, 'Rick Riordan'),
(38, 'John Grisham'),
(39, 'Carl Hiaasen'),
(40, 'Ransom Riggs');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `total_price` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`order_id`, `product_id`, `quantity`, `total_price`) VALUES
(16, 1, 1, 675),
(16, 2, 1, 1550),
(17, 7, 1, 990),
(18, 2, 1, 1550),
(20, 2, 1, 1550),
(21, 25, 1, 3000),
(21, 26, 1, 3000),
(22, 29, 1, 1600),
(23, 3, 1, 1650),
(23, 13, 1, 1400),
(23, 27, 1, 3000),
(23, 28, 1, 3800),
(23, 29, 1, 1600),
(24, 25, 1, 3000),
(24, 26, 1, 3000),
(25, 15, 1, 850),
(25, 27, 1, 3000),
(26, 28, 1, 3800),
(26, 29, 1, 1600),
(27, 26, 1, 3000),
(28, 1, 1, 750),
(28, 11, 1, 460),
(28, 29, 1, 1600),
(29, 24, 1, 2760),
(30, 28, 1, 3800),
(30, 29, 1, 1600),
(31, 18, 1, 800),
(31, 19, 1, 1500),
(32, 22, 1, 3000),
(33, 28, 1, 3800),
(34, 17, 1, 1196),
(34, 18, 1, 800),
(35, 1, 1, 750),
(35, 25, 1, 3000),
(35, 26, 1, 3000),
(35, 27, 1, 3000),
(35, 29, 1, 1600),
(36, 29, 1, 1600),
(37, 28, 1, 3800),
(38, 11, 1, 460),
(39, 13, 1, 1400),
(40, 23, 1, 3000),
(41, 6, 1, 981),
(42, 2, 1, 1550),
(42, 7, 1, 990),
(43, 24, 1, 2760),
(44, 2, 1, 1550),
(45, 1, 1, 750),
(46, 24, 1, 2760),
(46, 30, 2, 3200),
(47, 21, 3, 12000),
(48, 18, 1, 800),
(48, 26, 1, 3000),
(48, 30, 1, 1600);

--
-- Triggers `orderdetail`
--
DELIMITER $$
CREATE TRIGGER `oninsertorderdetail` AFTER INSERT ON `orderdetail` FOR EACH ROW BEGIN


UPDATE product SET product.quantity = (product.quantity - new.quantity) WHERE product.product_id = new.product_id;


END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `orderheader`
--

CREATE TABLE `orderheader` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `total_amount` int(11) NOT NULL DEFAULT '0',
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `confirm_date` datetime DEFAULT NULL,
  `to_address` varchar(200) NOT NULL,
  `order_status` varchar(20) NOT NULL,
  `payment` varchar(200) DEFAULT 'noimg.png'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderheader`
--

INSERT INTO `orderheader` (`order_id`, `user_id`, `quantity`, `total_amount`, `order_date`, `order_time`, `confirm_date`, `to_address`, `order_status`, `payment`) VALUES
(16, 4, 2, 2325, '2017-11-19', '01:05:50', '2017-11-27 16:47:21', 'ghj,', 'CANCELED', 'noimg.png'),
(17, 2, 1, 1090, '2017-11-22', '13:08:32', '2017-11-27 16:45:09', 'address', 'CANCELED', 'noimg.png'),
(18, 2, 1, 1650, '2017-11-22', '13:19:41', '2017-11-23 13:12:25', 'a', 'CANCELED', 'noimg.png'),
(19, 3, 1, 1650, '2017-11-22', '13:34:21', '2017-11-27 08:27:00', 'a', 'CANCELED', 'noimg.png'),
(20, 4, 1, 1650, '2017-11-22', '14:02:42', '2017-11-27 16:47:02', 'addresssssss', 'CANCELED', 'noimg.png'),
(21, 3, 2, 6100, '2017-11-25', '15:56:39', '2017-11-28 09:26:47', 'ab address', 'SHIPPED', '22555169_345693485901946_2938074877608530639_n.jpg'),
(22, 3, 1, 1700, '2017-11-26', '15:36:30', '2017-11-28 09:26:54', 'ab address', 'SHIPPED', '22payment-receipt.jpg'),
(23, 3, 5, 11550, '2017-11-26', '17:04:35', '2017-11-27 08:16:32', 'ababab address', 'SHIPPED', '23payment-receipt.jpg'),
(24, 7, 2, 6100, '2017-11-26', '19:23:29', '2017-11-28 16:56:08', 'asdasdasdasdasd', 'CANCELED', '24payment-receipt.jpg'),
(25, 7, 2, 3950, '2017-11-26', '19:23:38', '2017-11-29 12:39:31', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'SHIPPED', '25payment-receipt.jpg'),
(27, 7, 1, 3100, '2017-11-27', '03:09:17', '2017-11-29 12:39:21', 'ff address2', 'SHIPPED', '27payment-receipt.jpg'),
(28, 7, 3, 2910, '2017-11-28', '09:31:30', '2017-11-28 17:00:06', 'gogogogogogogogogogogogogogo', 'CANCELED', 'noimg.png'),
(29, 7, 1, 2860, '2017-11-28', '09:32:41', '2017-11-28 17:00:14', '1111111111111111111111111111111111111111', 'CANCELED', 'noimg.png'),
(30, 7, 2, 5500, '2017-11-28', '09:34:25', '2017-11-28 17:21:33', '22222222222222222222222222222222222', 'CANCELED', 'noimg.png'),
(31, 7, 2, 2400, '2017-11-28', '09:40:26', '2017-11-28 17:00:03', '8888888888888888\r\n', 'CANCELED', 'noimg.png'),
(32, 7, 1, 3100, '2017-11-28', '09:43:40', '2017-11-28 16:58:19', '555555555555555555', 'CANCELED', 'noimg.png'),
(33, 7, 1, 3900, '2017-11-28', '09:45:06', '2017-11-28 23:57:10', '666666666666666666666666', 'CANCELED', 'noimg.png'),
(34, 7, 2, 2096, '2017-11-28', '09:46:28', '2017-11-28 17:00:00', '2000000000000000000', 'CANCELED', 'noimg.png'),
(35, 7, 5, 11450, '2017-11-28', '23:58:13', '2017-11-29 00:45:13', 'aaaaaaaaaaaaaaa', 'CANCELED', 'noimg.png'),
(36, 7, 1, 1700, '2017-11-29', '00:00:39', NULL, 'aaaaaaaaaaaaaaa', 'UNPAID', 'noimg.png'),
(37, 7, 1, 3900, '2017-11-29', '00:02:17', '2017-11-29 00:15:22', 'aaaaaaaaaaaaaaa', 'CANCELED', 'noimg.png'),
(38, 7, 1, 560, '2017-11-29', '00:06:51', NULL, 'mmmmmmmmmmmmaaa', 'UNPAID', 'noimg.png'),
(39, 7, 1, 1500, '2017-11-29', '00:07:08', '2017-11-29 00:45:18', 'bbbbbbbbbbbbbggggg', 'CANCELED', 'noimg.png'),
(40, 7, 1, 3100, '2017-11-29', '00:08:36', NULL, 'aaaaaaaaaaaaaaa', 'UNPAID', 'noimg.png'),
(42, 7, 2, 2640, '2017-11-29', '00:50:08', NULL, 'abcd', 'UNPAID', 'noimg.png'),
(43, 7, 1, 2860, '2017-11-29', '00:51:11', NULL, '89/17 AAA condo BBB rd., Abcd , Kalaland', 'UNPAID', 'noimg.png'),
(44, 7, 1, 1650, '2017-11-29', '00:53:34', '2017-11-29 02:29:23', '89/17 AAA condo BBB rd., Abcd , Kalaland', 'INVALID', '44payment-receipt.jpg'),
(45, 10, 1, 850, '2017-11-29', '01:54:45', '2017-11-29 01:56:00', 'gjgjfdkdjfkgjdj', 'PAID', '4541payment-receipt.jpg'),
(46, 10, 3, 6060, '2017-11-29', '02:05:18', NULL, 'Fuck 1', 'UNPAID', 'noimg.png'),
(47, 11, 3, 12100, '2017-11-29', '02:08:44', NULL, 'sadfkjhsadfkjhsadfkjhsadfkjhadsf\r\n', 'UNPAID', 'noimg.png'),
(48, 7, 3, 5500, '2017-11-29', '02:52:24', NULL, '89/17 AAA condo BBB rd., Abcd , Kalaland', 'UNPAID', 'noimg.png');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_price` decimal(7,2) NOT NULL,
  `product_tag` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_pic` varchar(50) NOT NULL DEFAULT 'noimg.jpg',
  `product_discount` int(11) NOT NULL DEFAULT '0',
  `add_date` datetime NOT NULL,
  `description` varchar(3500) NOT NULL,
  `author_id` int(11) NOT NULL,
  `publisher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_tag`, `quantity`, `product_pic`, `product_discount`, `add_date`, `description`, `author_id`, `publisher_id`) VALUES
(1, 'Stolen Prey', '242.00', 'Adventure', 55, 'w124.jpg', 0, '2017-11-26 02:03:09', 'Stolen Prey\'s Desctiption', 1, 1),
(2, 'Road to Grace', '230.00', 'Thriller', 77, 'w124(1).jpg', 0, '2017-11-18 00:00:00', 'Road to Grace\'s Desctiption', 2, 2),
(3, 'Home', '345.00', 'Horror', 22, 'w124(2).jpg', 0, '2017-11-17 00:00:00', 'Home\'s Desctiption', 3, 3),
(4, 'The Witness', '304.00', 'Children\'s', 12, 'w124(3).jpg', 0, '2017-11-17 00:00:00', 'The Witness\'s Desctiption', 4, 4),
(5, 'The Sins of the Father', '344.00', 'Comedy', 7, 'w124(4).jpg', 0, '2017-11-17 00:00:00', 'The Sins of the Father\'s Desctiption', 5, 5),
(6, 'A Dance with Dragons: A Song of Ice and Fire, Book', '297.00', 'Fantasy', 81, 'w124(5).jpg', 10, '2017-11-17 00:00:00', 'A Dance with Dragons: A Song of Ice and Fire, Book 5\'s Desctiption', 6, 1),
(7, 'The Family Corleone', '282.00', 'Science Fiction', 40, 'w124(6).jpg', 0, '2017-11-17 00:00:00', 'The Family Corleone\'s Desctiption', 7, 2),
(8, 'Robert B. Parker\'s Lullaby', '330.00', 'Action', 33, 'w124(7).jpg', 0, '2017-11-17 00:00:00', 'Robert B. Parker\'s Lullaby\'s Desctiption', 8, 3),
(9, 'A Dog\'s Journey', '364.00', 'Adventure', 58, 'w124(8).jpg', 0, '2017-11-17 00:00:00', 'A Dog\'s Journey\'s Desctiption', 9, 4),
(10, 'As the Crow Flies: A Walt Longmire Mystery', '289.00', 'Thriller', 35, 'w124(9).jpg', 0, '2017-11-17 00:00:00', 'As the Crow Flies: A Walt Longmire Mystery\'s Desctiption', 10, 5),
(11, 'Guilty Wives', '356.00', 'Horror', 93, 'w124(10).jpg', 8, '2017-11-17 00:00:00', 'Guilty Wives\'s Desctiption', 11, 1),
(12, '11th Hour', '313.00', 'Children\'s', 37, 'w124(11).jpg', 0, '2017-11-25 02:44:13', '11th Hour\'s Desctiption', 12, 2),
(13, 'The Shoemaker\'s Wife', '213.00', 'Comedy', 52, 'w124(12).jpg', 0, '2017-11-22 15:33:00', 'The Shoemaker\'s Wife\'s Desctiption', 13, 3),
(14, 'Defending Jacob', '250.00', 'Fantasy', 6, 'w124(13).jpg', 0, '2017-11-25 00:50:20', 'Defending Jacob\'s Desctiption', 14, 4),
(15, 'Sacre Bleu: A Comedy D\'Art', '376.00', 'Science Fiction', 1, 'w124(14).jpg', 0, '2017-11-25 02:32:54', 'Sacre Bleu: A Comedy D\'Art\'s Desctiption', 15, 5),
(16, 'Unnatural Acts', '212.00', 'Action', 49, 'w124(15).jpg', 0, '2017-11-25 02:37:13', 'Unnatural Acts\'s Desctiption', 16, 1),
(17, 'The Lost Years', '300.00', 'Adventure', 65, 'w124(16).jpg', 8, '2017-11-25 02:38:57', 'The Lost Years\'s Desctiption', 17, 2),
(18, '11/22/63', '297.00', 'Thriller', 56, 'w124(17).jpg', 0, '2017-11-25 02:41:59', '11/22/63\'s Desctiption', 18, 3),
(19, 'The Columbus Affair', '209.00', 'Horror', 73, 'w124(18).jpg', 0, '2017-11-25 02:42:39', 'The Columbus Affair\'s Desctiption', 19, 4),
(20, 'Deadlocked: A Sookie Stackhouse Novel', '293.00', 'Children\'s', 20, 'w124(19).jpg', 0, '2017-11-25 02:45:35', 'Deadlocked: A Sookie Stackhouse Novel\'s Desctiption', 20, 5),
(21, 'Calico Joe', '252.00', 'Comedy', 1, 'w124(20).jpg', 0, '2017-11-25 02:50:18', 'Calico Joe\'s Desctiption', 21, 1),
(22, 'The Innocent', '399.00', 'Fantasy', 14, 'w124(21).jpg', 0, '2017-11-25 02:55:08', 'The Innocent\'s Desctiption', 22, 2),
(23, 'In One Person', '234.00', 'Science Fiction', 63, 'w124(22).jpg', 0, '2017-11-25 02:55:08', 'In One Person\'s Desctiption', 23, 3),
(24, 'The Wind Through the Keyhole', '283.00', 'Action', 74, 'w124(23).jpg', 8, '2017-11-25 02:55:08', 'The Wind Through the Keyhole\'s Desctiption', 24, 4),
(25, 'Bring Up the Bodies', '228.00', 'Adventure', 17, 'w124(24).jpg', 0, '2017-11-25 02:55:08', 'Bring Up the Bodies\'s Desctiption', 25, 5),
(26, 'The Serpent\'s Shadow', '328.00', 'Thriller', 70, 'w125.jpg', 0, '2017-11-25 02:55:08', 'The Serpent\'s Shadow\'s Desctiption', 26, 1),
(27, 'Ascend', '368.00', 'Horror', 59, 'w125(1).jpg', 0, '2017-11-25 02:56:50', 'Ascend\'s Desctiption', 27, 2),
(28, 'The Son of Neptune (The Heroes of Olympus #2)', '354.00', 'Children\'s', 4, 'w125(2).jpg', 0, '2017-11-25 02:58:12', 'The Son of Neptune (The Heroes of Olympus #2)\'s Desctiption', 28, 3),
(29, 'The Book Thief', '395.00', 'Comedy', 60, 'w125(3).jpg', 0, '2017-11-26 02:33:49', 'The Book Thief\'s Desctiption', 29, 4),
(30, 'The Throne of Fire (Kane Chronicles #2)', '390.00', 'Fantasy', 19, 'w125(4).jpg', 0, '0000-00-00 00:00:00', 'The Throne of Fire (Kane Chronicles #2)\'s Desctiption', 30, 5),
(31, 'Destined', '330.00', 'Science Fiction', 11, 'w125(5).jpg', 0, '0000-00-00 00:00:00', 'Destined\'s Desctiption', 31, 1),
(32, 'The Fault in Our Stars', '263.00', 'Action', 16, 'w125(6).jpg', 0, '0000-00-00 00:00:00', 'The Fault in Our Stars\'s Desctiption', 32, 2),
(33, 'Insurgent', '208.00', 'Adventure', 0, 'w125(7).jpg', 0, '0000-00-00 00:00:00', 'Insurgent\'s Desctiption', 33, 3),
(34, 'Bitterblue', '252.00', 'Thriller', 3, 'w125(8).jpg', 0, '0000-00-00 00:00:00', 'Bitterblue\'s Desctiption', 34, 4),
(35, 'The Invaders', '394.00', 'Horror', 86, 'w125(9).jpg', 0, '0000-00-00 00:00:00', 'The Invaders\'s Desctiption', 35, 5),
(36, 'Divergent', '272.00', 'Children\'s', 78, 'w125(10).jpg', 0, '0000-00-00 00:00:00', 'Divergent\'s Desctiption', 36, 1),
(37, 'The Lost Hero ', '317.00', 'Comedy', 89, 'w125(11).jpg', 0, '0000-00-00 00:00:00', 'The Lost Hero \'s Desctiption', 37, 2),
(38, 'Theodore Boone: The Abduction', '332.00', 'Fantasy', 100, 'w125(12).jpg', 0, '0000-00-00 00:00:00', 'Theodore Boone: The Abduction\'s Desctiption', 38, 3),
(39, 'Chomp', '344.00', 'Science Fiction', 1, 'w125(13).jpg', 0, '0000-00-00 00:00:00', 'Chomp\'s Desctiption', 39, 4),
(40, 'Miss Peregrine\'s Home for Peculiar Children', '201.00', 'Action', 19, 'w125(14).jpg', 0, '0000-00-00 00:00:00', 'Miss Peregrine\'s Home for Peculiar Children\'s Desctiption', 40, 5);

-- --------------------------------------------------------

--
-- Table structure for table `product_delete`
--

CREATE TABLE `product_delete` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_price` decimal(7,2) NOT NULL,
  `product_tag` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_pic` varchar(50) NOT NULL,
  `product_discount` int(11) NOT NULL,
  `delete_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_delete`
--

INSERT INTO `product_delete` (`id`, `product_id`, `product_name`, `product_price`, `product_tag`, `quantity`, `product_pic`, `product_discount`, `delete_date`) VALUES
(2, 31, 'aaaaaaaaaa', '50.00', 'Bluff', 2, 'aaaaaaaaaapayment-receipt.jpg', 0, '2017-11-29 01:43:50'),
(3, 32, 'g', '100.00', 'g', 123, 'g45noimg.png', 10, '2017-11-29 02:17:45');

-- --------------------------------------------------------

--
-- Table structure for table `product_tag`
--

CREATE TABLE `product_tag` (
  `id` int(11) NOT NULL,
  `tag_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_tag`
--

INSERT INTO `product_tag` (`id`, `tag_name`) VALUES
(1, 'Bluff'),
(2, 'Party'),
(3, 'Deck building'),
(4, 'Case solving'),
(5, 'Expansion'),
(6, 'Strategic'),
(7, 'Thematic'),
(8, 'RPG'),
(9, 'Cooperation');

--
-- Triggers `product_tag`
--
DELIMITER $$
CREATE TRIGGER `oninsert` BEFORE INSERT ON `product_tag` FOR EACH ROW BEGIN

IF new.tag_name IN (SELECT tag_name FROM product_tag) THEN
	SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'TAG ALREADY IN THE TABLE';
END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`id`, `name`) VALUES
(1, 'Puffin'),
(2, 'Scholastic'),
(3, 'Harper Collins'),
(4, 'Penguin'),
(5, 'Random House');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `USER_ID` int(11) NOT NULL,
  `USER_NAME` varchar(20) NOT NULL,
  `USER_PASSWORD` varchar(20) NOT NULL,
  `USER_TYPE` int(11) NOT NULL,
  `USER_FNAME` varchar(40) NOT NULL,
  `USER_LNAME` varchar(40) NOT NULL,
  `USER_EMAIL` varchar(50) NOT NULL,
  `register_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `disable` tinyint(1) NOT NULL,
  `propic` varchar(200) NOT NULL DEFAULT '0.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`USER_ID`, `USER_NAME`, `USER_PASSWORD`, `USER_TYPE`, `USER_FNAME`, `USER_LNAME`, `USER_EMAIL`, `register_date`, `disable`, `propic`) VALUES
(1, 'admin', 'admin', 1, 'admin', 'admin', 'admin@adminmail.com', '2017-11-21 11:16:27', 0, '0.jpg'),
(2, 'aa', 'bb', 2, 'Antman', 'Batman', 'ab@mail.com', '2017-11-21 11:16:27', 0, '0.jpg'),
(3, 'ab', 'ab', 2, 'Ababababa', 'Abudabee', 'aba@mail.com', '2017-11-23 09:45:27', 0, '410132-yogi-bear.jpg'),
(4, 'pawat', '1234', 2, 'Pawat', 'Treepoca', 'pawat4@hotmail.com', '2017-11-21 11:16:27', 0, '0.jpg'),
(5, 'hellboy', 'hell', 2, 'Helsing', 'Boya', 'wth@mail.com', '2017-11-21 11:16:27', 1, '0.jpg'),
(7, 'ff', 'ff', 2, 'Final', 'Fantasy', 'ff@mail.com', '2017-11-21 11:16:27', 0, '0.jpg'),
(8, 'hello', 'hello', 2, 'Hello', 'Itsme', 'itsme@mail.com', '2017-11-21 11:28:46', 1, '0.jpg'),
(9, 'hhhhh', 'hentai', 2, 'Hanzo', 'Shimada', 'hanzo@shimada.com', '2017-11-29 01:45:18', 1, '0.jpg'),
(10, 'g', 'g', 2, 'g', 'g', 'g@g.g', '2017-11-29 01:52:29', 0, '0.jpg'),
(11, '2', '2', 2, '2', '2', '2@2.2', '2017-11-29 02:08:17', 0, '0.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE `usertype` (
  `TYPE_ID` int(11) NOT NULL,
  `TYPE_NAME` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`TYPE_ID`, `TYPE_NAME`) VALUES
(1, 'Admin'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`user_id`, `product_id`) VALUES
(7, 24),
(7, 29),
(7, 15),
(7, 7),
(7, 9),
(7, 30),
(7, 11),
(7, 13),
(7, 12),
(10, 30),
(1, 32),
(7, 18);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`order_id`,`product_id`);

--
-- Indexes for table `orderheader`
--
ALTER TABLE `orderheader`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_delete`
--
ALTER TABLE `product_delete`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_tag`
--
ALTER TABLE `product_tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`USER_ID`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`TYPE_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `orderheader`
--
ALTER TABLE `orderheader`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `product_delete`
--
ALTER TABLE `product_delete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `product_tag`
--
ALTER TABLE `product_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `TYPE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
