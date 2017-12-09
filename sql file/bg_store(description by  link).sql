-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2017 at 10:57 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

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
(27, 26, 1, 3000);

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
  `confirm_date` datetime NOT NULL,
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
(21, 3, 2, 6100, '2017-11-25', '15:56:39', '2017-11-27 04:19:02', 'ab address', 'PAID', '22555169_345693485901946_2938074877608530639_n.jpg'),
(22, 3, 1, 1700, '2017-11-26', '15:36:30', '2017-11-27 13:36:21', 'ab address', 'PENDING', '22payment-receipt.jpg'),
(23, 3, 5, 11550, '2017-11-26', '17:04:35', '2017-11-27 08:16:32', 'ababab address', 'SHIPPED', '23payment-receipt.jpg'),
(24, 7, 2, 6100, '2017-11-26', '19:23:29', '2017-11-27 03:19:54', 'asdasdasdasdasd', 'PAID', '24payment-receipt.jpg'),
(25, 7, 2, 3950, '2017-11-26', '19:23:38', '0000-00-00 00:00:00', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'PENDING', '25payment-receipt.jpg'),
(27, 7, 1, 3100, '2017-11-27', '03:09:17', '0000-00-00 00:00:00', 'ff address2', 'PENDING', '27payment-receipt.jpg');

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
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_tag`, `quantity`, `product_pic`, `product_discount`, `add_date`, `description`) VALUES
(1, 'Avalon (ENG)', '750.00', 'Bluff, Party', 1, 'avalon_en.jpg', 0, '2017-11-26 02:03:09', 'https://boardgamegeek.com/boardgame/128882/resistance-avalon'),
(2, 'Bears VS Babies', '1550.00', 'Bluff, Party', 101, 'bears_vs_babies.jpg', 0, '2017-11-18 00:00:00', 'https://boardgamegeek.com/boardgame/211534/bears-vs-babies'),
(3, 'Deception: Murder in Hong Kong', '1650.00', 'Bluff, Case solving', 99, 'deception.jpg', 0, '2017-11-17 00:00:00', 'https://boardgamegeek.com/boardgame/156129/deception-murder-hong-kong'),
(4, 'Dominion Intrigue', '1850.00', 'Deck Building', 100, 'dominion_intrigue.jpg', 0, '2017-11-17 00:00:00', 'https://boardgamegeek.com/boardgame/40834/dominion-intrigue'),
(5, 'Exploding Kittens (1st Edition)', '1290.00', 'Party', 0, 'ex_kittens_1ed.png', 0, '2017-11-17 00:00:00', 'https://boardgamegeek.com/boardgame/172225/exploding-kittens'),
(6, 'Exploding Kittens (Black Box)', '1090.00', 'Party', 100, 'ex_kittens_black.jpg', 10, '2017-11-17 00:00:00', 'https://boardgamegeek.com/boardgame/172225/exploding-kittens'),
(7, 'Exploding Kittens (Red Box)', '990.00', 'Party', 101, 'ex_kittens_red.png', 0, '2017-11-17 00:00:00', 'https://boardgamegeek.com/boardgame/172225/exploding-kittens'),
(8, 'Imploding Kittens (Expansion of Exploding Kittens)', '950.00', 'Party, Expansion', 100, 'im_kittens.png', 0, '2017-11-17 00:00:00', 'https://boardgamegeek.com/boardgame/172225/exploding-kittens'),
(9, 'Game of Throne: The Board Game (2nd Edition)', '2350.00', 'Strategic', 100, 'GoT_BG.jpg', 0, '2017-11-17 00:00:00', 'https://boardgamegeek.com/boardgame/103343/game-thrones-board-game-second-edition'),
(10, 'House of Madness (2nd Edition)', '3800.00', 'Thematic', 100, 'house_of_madness.jpg', 0, '2017-11-17 00:00:00', 'https://boardgamegeek.com/boardgame/205059/mansions-madness-second-edition'),
(11, 'Love Letter (Box Edition)', '500.00', 'Party', 100, 'love_letter.jpg', 8, '2017-11-17 00:00:00', 'https://boardgamegeek.com/boardgame/129622/love-letter'),
(12, 'Dominion Prosperity', '1200.00', 'Deck building, Expansion', 5, 'dominion_prosperity.jpg', 0, '2017-11-25 02:44:13', 'https://boardgamegeek.com/boardgame/66690/dominion-prosperity'),
(13, 'Century Spice Road', '1400.00', 'Deck Building', 49, 'century_spice_road.jpg', 0, '2017-11-22 15:33:00', 'https://boardgamegeek.com/boardgame/209685/century-spice-road'),
(14, 'T.I.M.E. Stories', '2650.00', 'Thematic', 100, 'time_stories.png', 0, '2017-11-25 00:50:20', 'https://boardgamegeek.com/boardgame/146508/time-stories'),
(15, 'Bang! The Dice Game', '850.00', 'Bluff, Party', 42, 'bang_the_dice.jpg', 0, '2017-11-25 02:32:54', 'https://boardgamegeek.com/boardgame/143741/bang-dice-game'),
(16, 'Dominion 1st Edition (Base box)', '2000.00', 'Deck building', 30, 'dominion_1st_base.jpg', 0, '2017-11-25 02:37:13', 'https://boardgamegeek.com/boardgame/36218/dominion'),
(17, 'Dominion Seaside', '1300.00', 'Deck building, Expansion', 6, 'dominion_seaside.jpg', 8, '2017-11-25 02:38:57', 'https://boardgamegeek.com/boardgame/51811/dominion-seaside'),
(18, 'Dominion Alchemy', '800.00', 'Deck building, Expansion', 10, 'dominion_alchemy.jpg', 0, '2017-11-25 02:41:59', 'https://boardgamegeek.com/boardgame/66098/dominion-alchemy'),
(19, 'Dominion Hinterland', '1500.00', 'Deck building, Expansion', 10, 'dominion_hinterland.jpg', 0, '2017-11-25 02:42:39', 'https://boardgamegeek.com/boardgame/104557/dominion-hinterlands'),
(20, 'Exploding Kittens (Party pack)', '1800.00', 'Bluff, Party', 20, 'ex_kittens_party.png', 0, '2017-11-25 02:45:35', 'https://boardgamegeek.com/boardgame/172225/exploding-kittens'),
(21, 'Arcadia Quest (Base box)', '4000.00', 'Thematic, RPG', 10, 'arcadia_base.png', 0, '2017-11-25 02:50:18', 'https://boardgamegeek.com/boardgame/155068/arcadia-quest'),
(22, 'Arcadia Quest : Fire Dragon', '3000.00', 'Thematic, RPG, Expansion', 5, 'arcadia_fire_dragon.jpg', 0, '2017-11-25 02:55:08', 'https://boardgamegeek.com/boardgame/189455/arcadia-quest-fire-dragon'),
(23, 'Arcadia Quest : Frost Dragon', '3000.00', 'Thematic, RPG, Expansion', 5, 'arcadia_frost_dragon.jpg', 0, '2017-11-25 02:55:08', 'https://boardgamegeek.com/boardgame/188447/arcadia-quest-frost-dragon'),
(24, 'Arcadia Quest : Chaos Dragon', '3000.00', 'Thematic, RPG, Expansion', 5, 'arcadia_chaos_dragon.jpg', 8, '2017-11-25 02:55:08', 'https://boardgamegeek.com/boardgame/189197/arcadia-quest-chaos-dragon'),
(25, 'Arcadia Quest : Pets', '3000.00', 'Thematic, RPG, Expansion', 3, 'arcadia_pets.jpg', 0, '2017-11-25 02:55:08', 'https://boardgamegeek.com/boardgame/188699/arcadia-quest-pets'),
(26, 'Arcadia Quest : Beyond The Grave', '3000.00', 'Thematic, RPG, Expansion', 2, 'arcadia_beyond_the_grave.jpg', 0, '2017-11-25 02:55:08', 'https://boardgamegeek.com/boardgame/156089/arcadia-quest-beyond-grave'),
(27, 'Arcadia Quest : Inferno', '3000.00', 'Thematic, RPG, Expansion', 3, 'arcadia_inferno.jpg', 0, '2017-11-25 02:56:50', 'https://boardgamegeek.com/boardgame/179803/arcadia-quest-inferno'),
(28, 'Masmorra : Dungeon of Arcadia', '3800.00', 'Thematic, RPG', 6, 'masmorra.png', 0, '2017-11-25 02:58:12', 'https://boardgamegeek.com/boardgame/181524/masmorra-dungeons-arcadia'),
(29, 'Pandemic', '1600.00', 'Cooperation', 17, 'pandemic.png', 0, '2017-11-26 02:33:49', 'https://boardgamegeek.com/boardgame/30549/pandemic');

--
-- Triggers `product`
--
DELIMITER $$
CREATE TRIGGER `onproductdelete` BEFORE DELETE ON `product` FOR EACH ROW BEGIN

INSERT INTO product_history(product_id,action,description,action_date)
VALUES(old.product_id,"DELETE",CONCAT("DELETE ",old.product_name), NOW());

INSERT INTO product_delete(delete_date,product_id,product_name,product_price,product_tag,quantity,product_pic,product_discount) VALUES(NOW(),old.product_id,old.product_name,old.product_price,old.product_tag,old.quantity,old.product_pic,old.product_discount);

END
$$
DELIMITER ;

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

-- --------------------------------------------------------

--
-- Table structure for table `product_history`
--

CREATE TABLE `product_history` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `action` varchar(8) NOT NULL,
  `description` varchar(100) NOT NULL,
  `action_date` datetime NOT NULL,
  `by_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_history`
--

INSERT INTO `product_history` (`id`, `product_id`, `action`, `description`, `action_date`, `by_user`) VALUES
(7, 13, 'DELETE', 'DELETE Century Spice Road', '2017-11-20 23:39:21', 1),
(8, 12, 'DELETE', 'DELETE T.I.M.E. Stories', '2017-11-21 01:48:13', 0),
(9, 12, 'DELETE', 'DELETE ', '2017-11-22 01:48:01', 0),
(10, 12, 'DELETE', 'DELETE product_delete.product_name', '2017-11-22 15:31:19', 0),
(11, 15, 'DELETE', 'DELETE T.I.M.E. Stories', '2017-11-22 15:34:27', 0),
(12, 16, 'DELETE', 'DELETE T.I.M.E. Stories', '2017-11-22 15:34:44', 0),
(13, 17, 'DELETE', 'DELETE T.I.M.E. Stories', '2017-11-22 15:35:31', 0),
(14, 14, 'DELETE', 'DELETE T.I.M.E. Stories', '2017-11-22 15:39:57', 0),
(15, 18, 'DELETE', 'DELETE T.I.M.E. Stories', '2017-11-22 15:40:35', 0),
(16, 19, 'DELETE', 'DELETE T.I.M.E. Stories', '2017-11-23 09:19:29', 0),
(17, 1, 'DELETE', 'DELETE Avalon (ENG)', '2017-11-26 02:03:02', 0),
(18, 30, 'DELETE', 'DELETE Pandemic', '2017-11-26 02:32:23', 0);

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
(2, 'aa', 'bb', 2, 'a', 'b', 'ab@mail.com', '2017-11-21 11:16:27', 0, '0.jpg'),
(3, 'ab', 'ab', 2, 'ababa', 'abaa', 'aba@mail.com', '2017-11-23 09:45:27', 0, '410132-yogi-bear.jpg'),
(4, 'pawat', '1234', 2, 'Pawat', 'Treepoca', 'pawat4@hotmail.com', '2017-11-21 11:16:27', 0, '0.jpg'),
(5, 'hellboy', 'hell', 2, 'hell', 'boy', 'wth@mail.com', '2017-11-21 11:16:27', 1, '0.jpg'),
(7, 'ff', 'ff', 2, 'ff', 'gg', 'ff@mail.com', '2017-11-21 11:16:27', 0, '0.jpg'),
(8, 'hello', 'hello', 2, 'Hello', 'Itsme', 'itsme@mail.com', '2017-11-21 11:28:46', 1, '0.jpg');

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `onuserdelete` BEFORE DELETE ON `user` FOR EACH ROW BEGIN

INSERT INTO user_delete(user_id,user_name,user_password,user_type,user_fname,user_lname,user_email,user_registerdate,delete_date) VALUES(old.USER_ID,old.USER_NAME,old.USER_PASSWORD,old.USER_TYPE,old.USER_FNAME,old.USER_LNAME,old.USER_EMAIL,old.register_date,NOW());

END
$$
DELIMITER ;

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
-- Table structure for table `user_delete`
--

CREATE TABLE `user_delete` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_password` varchar(20) NOT NULL,
  `user_type` int(11) NOT NULL,
  `user_fname` varchar(40) NOT NULL,
  `user_lname` varchar(40) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_registerdate` datetime NOT NULL,
  `delete_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_delete`
--

INSERT INTO `user_delete` (`id`, `user_id`, `user_name`, `user_password`, `user_type`, `user_fname`, `user_lname`, `user_email`, `user_registerdate`, `delete_date`) VALUES
(1, 9, 'ab', 'aa', 2, 'ab', 'ab', 'a@a.com', '2017-11-23 20:30:08', '2017-11-23 20:30:51'),
(2, 10, 'ab', 'aa', 2, 'ab', 'aba', 'a@a.com', '2017-11-23 20:32:02', '2017-11-23 21:54:34'),
(3, 11, 'ab', 'aa', 2, 'aaa', 'l', 'k@mai.com', '2017-11-23 20:34:28', '2017-11-23 21:54:34'),
(4, 12, 'ab', 'a', 2, 'aaa', 'l', 'k@mai.com', '2017-11-23 20:34:56', '2017-11-23 21:54:34'),
(5, 13, 'ab', 'aa', 2, 'aaa', 'l', 'k@mai.com', '2017-11-23 20:35:47', '2017-11-23 21:54:34');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `product_history`
--
ALTER TABLE `product_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_tag`
--
ALTER TABLE `product_tag`
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
-- Indexes for table `user_delete`
--
ALTER TABLE `user_delete`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orderheader`
--
ALTER TABLE `orderheader`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `product_delete`
--
ALTER TABLE `product_delete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_history`
--
ALTER TABLE `product_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_tag`
--
ALTER TABLE `product_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `TYPE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_delete`
--
ALTER TABLE `user_delete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
