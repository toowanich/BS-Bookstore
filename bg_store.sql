-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2017 at 12:14 PM
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
  `description` varchar(3500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_tag`, `quantity`, `product_pic`, `product_discount`, `add_date`, `description`) VALUES
(1, 'Avalon (ENG)', '700.00', 'Bluff, Party', 0, 'avalon_en.jpg', 0, '2017-11-26 02:03:09', 'The Resistance: Avalon pits the forces of Good and Evil in a battle to control the future of civilization. Arthur represents the future of Britain, a promise of prosperity and honor, yet hidden among his brave warriors are Mordred\'s unscrupulous minions. These forces of evil are few in number but have knowledge of each other and remain hidden from all but one of Arthur\'s servants. Merlin alone knows the agents of evil, but he must speak of this only in riddles. If his true identity is discovered, all will be lost. The Resistance: Avalon is a standalone game, and while The Resistance is not required to play, the games are compatible and can be combined.'),
(2, 'Bears VS Babies', '1550.00', 'Party', 101, 'bears_vs_babies.jpg', 0, '2017-11-18 00:00:00', 'Bears vs Babies is a card game in which you build handsome, incredible monsters who go to war with horrible, awful babies.\r\n\r\nThe shared deck of cards consists of bear parts (and other monster parts) and baby cards. When you draw a part, you use it to build a monster for yourself; when you draw a baby, it goes in the center of the table. When babies are provoked, they attack, and anyone who has fewer monster parts than the number of attacking babies loses their monster; everyone with more parts than babies defeats this infantile army and scores.'),
(3, 'Deception: Murder in Hong Kong', '1650.00', 'Bluff, Case solving', 99, 'deception.jpg', 0, '2017-11-17 00:00:00', 'Deception: Murder in Hong Kong is a game of deduction and deception for 4-12 players that plays in about 20 minutes.  In the game, players take on the roles of investigators attempting to solve a murder case – but there\'s a twist. The killer is one of the investigators! Each player\'s role and team are randomly assigned at the start of play and include the unique roles of Forensic Scientist, Witness, Investigator, Murderer, and Accomplice. While the Investigators attempt to deduce the truth, the murderer\'s team must deceive and mislead. This is a battle of wits!  The Forensic Scientist has the solution but can express the clues only using special scene tiles while the investigators (and the murderer) attempt to interpret the evidence. In order to succeed, the investigators must not only deduce the truth from the clues of the Forensic Scientist, they must also see through the misdirection being injected into the equation by the Murderer and Accomplice!  Find out who among you can cut through deception to find the truth and who is capable of getting away with murder!'),
(4, 'Dominion Intrigue', '1850.00', 'Deck Building', 100, 'dominion_intrigue.jpg', 0, '2017-11-17 00:00:00', 'In Dominion: Intrigue (as with Dominion), each player starts with an identical, very small deck of cards. In the center of the table is a selection of other cards the players can \"buy\" as they can afford them. Through their selection of cards to buy, and how they play their hands as they draw them, the players construct their deck on the fly, striving for the most efficient path to the precious victory points by game end.  From the back of the box: \"Somethingï¿½s afoot. The steward smiles at you like he has a secret, or like he thinks you have a secret, or like you think he thinks you have a secret. There are secret plots brewing, youï¿½re sure of it. At the very least, there are yours. A passing servant murmurs, ï¿½The eggs are on the plate.ï¿½ You frantically search your codebook for the translation before realizing he means that breakfast is ready. Excellent. Everything is going according to plan.\"  Dominion: Intrigue adds rules for playing with up to 8 players at two tables or for playing a single game with up to 6 players when combined with Dominion. This game adds 25 new Kingdom cards and a complete set of Treasure and Victory cards. The game can be played alone by players experienced in Dominion or with the basic game of Dominion.'),
(5, 'Exploding Kittens (1st Edition)', '1290.00', 'Party', 0, 'ex_kittens_1ed.png', 0, '2017-11-17 00:00:00', 'Exploding Kittens is a kitty-powered version of Russian Roulette. Players take turns drawing cards until someone draws an exploding kitten and loses the game. The deck is made up of cards that let you avoid exploding by peeking at cards before you draw, forcing your opponent to draw multiple cards, or shuffling the deck.  The game gets more and more intense with each card you draw because fewer cards left in the deck means a greater chance of drawing the kitten and exploding in a fiery ball of feline hyperbole.'),
(6, 'Exploding Kittens (Black Box)', '1090.00', 'Party', 100, 'ex_kittens_black.jpg', 10, '2017-11-17 00:00:00', 'Exploding Kittens made history when it became the most-backed game in Kickstarter history and the campaign with the most number of backers, ever.   It is a highly-strategic, kitty-powered version of Russian Roulette. Players draw cards until someone draws an Exploding Kitten, at which point they explode, they are dead, and they are out of the game ï¿½ unless that player has a Defuse card, which can defuse the kitten using things like laser pointers, belly rubs, and catnip sandwiches. All of the other cards in the deck are used to move, mitigate, or avoid the Exploding Kittens.   Exploding Kittens NSFW version is for more mature audience. Definitely NOT for family and young children. Not AUTHENTIC but first grade replica. No obvious difference with the original ones.'),
(7, 'Exploding Kittens (Red Box)', '990.00', 'Party', 101, 'ex_kittens_red.png', 0, '2017-11-17 00:00:00', 'Exploding Kittens is a kitty-powered version of Russian Roulette. Players take turns drawing cards until someone draws an exploding kitten and loses the game. The deck is made up of cards that let you avoid exploding by peeking at cards before you draw, forcing your opponent to draw multiple cards, or shuffling the deck.  The game gets more and more intense with each card you draw because fewer cards left in the deck means a greater chance of drawing the kitten and exploding in a fiery ball of feline hyperbole.'),
(8, 'Imploding Kittens (Expansion of Exploding Kittens)', '950.00', 'Party, Expansion', 100, 'im_kittens.png', 0, '2017-11-17 00:00:00', 'Imploding Kittens is the first Expansion of Exploding Kittens, the award-winning card game that made Kickstarter history as the most-backed project, ever. This Expansion deck includes 20 new cards featuring 6 new types of actions and an Imploding Kitten which increases the game from 5 to 6 players.'),
(9, 'Game of Throne: The Board Game (2nd Edition)', '2350.00', 'Strategic', 100, 'GoT_BG.jpg', 0, '2017-11-17 00:00:00', 'King Robert Baratheon is dead, and the lands of Westeros brace for battle.  In the second edition of A Game of Thrones: The Board Game, three to six players take on the roles of the great Houses of the Seven Kingdoms of Westeros, as they vie for control of the Iron Throne through the use of diplomacy and warfare. Based on the best-selling A Song of Ice and Fire series of fantasy novels by George R.R. Martin, A Game of Thrones is an epic board game in which it will take more than military might to win. Will you take power through force, use honeyed words to coerce your way onto the throne, or rally the townsfolk to your side? Through strategic planning, masterful diplomacy, and clever card play, spread your influence over Westeros!'),
(10, 'Mansions of Madness (2nd Edition)', '3800.00', 'Thematic', 100, 'house_of_madness.jpg', 0, '2017-11-17 00:00:00', 'An influential film director is holding a screening of his latest production in the abandoned estate Whale Manor, and you\'ve been asked to attend! There\'s just one catch: Whale Manor is haunted by the spirits of dead actors, all of whom are cursed to relive the drama of their films again and again. House of Fears is a print-on-demand story expansion for Mansions of Madness! This cinematic adventure by acclaimed novelist Tracy Hickman thrusts players into a living 1920s movie – but can they escape the horror before the film\'s tragic ending?'),
(11, 'Love Letter (Box Edition)', '500.00', 'Party', 100, 'love_letter.jpg', 8, '2017-11-17 00:00:00', 'All of the eligible young men (and many of the not-so-young) seek to woo the princess of Tempest. Unfortunately, she has locked herself in the palace, and you must rely on others to take your romantic letters to her. Will yours reach her first?  Love Letter is a game of risk, deduction, and luck for 2–4 players. Your goal is to get your love letter into Princess Annette\'s hands while deflecting the letters from competing suitors. From a deck with only sixteen cards, each player starts with only one card in hand; one card is removed from play. On a turn, you draw one card, and play one card, trying to expose others and knock them from the game. Powerful cards lead to early gains, but make you a target. Rely on weaker cards for too long, however, and your letter may be tossed in the fire!  Number 4 in the Tempest: Shared World Game Series'),
(12, 'Dominion Prosperity', '1200.00', 'Deck building, Expansion', 5, 'dominion_prosperity.jpg', 0, '2017-11-25 02:44:13', 'Released in late 2010, Prosperity is the 4th addition to the Dominion game family. It adds 25 new Kingdom cards to Dominion, plus 2 new Basic cards that let players keep building up past Gold and Province. The central theme is wealth; there are treasures with abilities, cards that interact with treasures, and powerful expensive cards. (Source: http://www.riograndegames.com/games.html?id=361 )  From the back of the box: \"Ah, money. There\'s nothing like the sound of coins clinking in your hands. You vastly prefer it to the sound of coins clinking in someone else\'s hands, or the sound of coins just sitting there in a pile that no-one can quite reach without getting up. Getting up, that\'s all behind you now. Life has been good to you. Just ten years ago, you were tilling your own fields in a simple straw hat. Today, your kingdom stretches from sea to sea, and your straw hat is the largest the world has ever known. You also have the world\'s smallest dog, and a life-sized statue of yourself made out of baklava. Sure, money can\'t buy happiness, but it can buy envy, anger, and also this kind of blank feeling. You still have problems - troublesome neighbours that must be conquered.  But this time, you\'ll conquer them in style.\"'),
(13, 'Century Spice Road', '1400.00', 'Deck Building', 49, 'century_spice_road.jpg', 0, '2017-11-22 15:33:00', 'Century: Spice Road is the first in a series of games that explores the history of each century with spice-trading as the theme for the first installment. In Century: Spice Road, players are caravan leaders who travel the famed silk road to deliver spices to the far reaches of the continent for fame and glory. Each turn, players perform one of four actions:  Establish a trade route (by taking a market card) Make a trade or harvest spices (by playing a card from hand) Fulfill a demand (by meeting a victory point card\'s requirements and claiming it) Rest (by taking back into your hand all of the cards you\'ve played) The last round is triggered once a player has claimed their fifth victory point card, then whoever has the most victory points wins.'),
(14, 'T.I.M.E. Stories', '2650.00', 'Thematic', 100, 'time_stories.png', 0, '2017-11-25 00:50:20', 'The T.I.M.E Agency protects humanity by preventing temporal faults and paradoxes from threatening the fabric of our universe. As temporal agents, you and your team will be sent into the bodies of beings from different worlds or realities to successfully complete the missions given to you. Failure is impossible, as you will be able to go back in time as many times as required.  T.I.M.E Stories is a narrative game, a game of \"decksploration\". Each player is free to give their character as deep a \"role\" as they want, in order to live through a story, as much in the game as around the table. But it\'s also a board game with rules which allow for reflection and optimization.'),
(15, 'Bang! The Dice Game', '850.00', 'Bluff, Party', 44, 'bang_the_dice.jpg', 0, '2017-11-25 02:32:54', 'In the U.S. wild west, the eternal battle between the law and the outlaws keeps heating up. Suddenly, a rain of arrows darken the sky: It\'s an Indian attack! Are you bold enough to keep up with the Indians? Do you have the courage to challenge your fate? Can you expose and defeat the ruthless gunmen around you?  BANG! The Dice Game keeps the core of the Bang! card game in place. At the start of the game, players each take a role card that secretly places them on a team: the Sheriff and deputies, outlaws, and renegades. The Sheriff and deputies need to kill the outlaws, the outlaws win by killing the Sheriff, and the renegades want to be the last players alive in the game.'),
(16, 'Dominion 1st Edition (Base box)', '2000.00', 'Deck building', 30, 'dominion_1st_base.jpg', 0, '2017-11-25 02:37:13', '\"You are a monarch, like your parents before you, a ruler of a small pleasant kingdom of rivers and evergreens. Unlike your parents, however, you have hopes and dreams! You want a bigger and more pleasant kingdom, with more rivers and a wider variety of trees. You want a Dominion! In all directions lie fiefs, freeholds, and feodums. All are small bits of land, controlled by petty lords and verging on anarchy. You will bring civilization to these people, uniting them under your banner.  But wait! It must be something in the air; several other monarchs have had the exact same idea. You must race to get as much of the unclaimed land as possible, fending them off along the way. To do this you will hire minions, construct buildings, spruce up your castle, and fill the coffers of your treasury. Your parents wouldn\'t be proud, but your grandparents, on your mother\'s side, would be delighted.\"'),
(17, 'Dominion Seaside', '1300.00', 'Deck building, Expansion', 6, 'dominion_seaside.jpg', 8, '2017-11-25 02:38:57', 'Dominion: Seaside is an expansion to both Dominion and Dominion: Intrigue. As such, it does not contain material for a complete game. Specifically, it does not include the basic Treasure, Victory, Curse, or Trash cards. Thus, you will need either the base game or Intrigue to play with this expansion, and you will need to have experience playing Dominion with either of the first two games. It is designed to work with either or both of these sets, and any future expansions that may be published.  From the back of the box: \"All you ask is a tall ship and a star to steer her by. And someone who knows how to steer ships using stars. You finally got some of those rivers you\'d wanted, and they led to the sea. These are dangerous, pirate-infested waters, and you cautiously send rat-infested ships across them, to establish lucrative trade at far-off merchant-infested ports. First, you will take over some islands, as a foothold. The natives seem friendly enough, crying their peace cries, and giving you spears and poison darts before you are even close enough to accept them properly. When you finally reach those ports you will conquer them, and from there you will look for more rivers. One day, all the rivers will be yours.\"'),
(18, 'Dominion Alchemy', '800.00', 'Deck building, Expansion', 10, 'dominion_alchemy.jpg', 0, '2017-11-25 02:41:59', 'There are strange things going on in your basement laboratories. They keep calling up for more barrels of quicksilver, or bits of your hair. Well it\'s all in the name of progress. They\'re looking for a way to turn lead into gold, or at least into something better than lead. That lead had just been too good of a bargain to pass up; you didn\'t think, where will I put all this lead, what am I going to do with this lead anyway. Well that will all be sorted out. They\'re also looking for a universal solvent. If they manage that one, you will take whatever they use to hold it in and build a castle out of it. A castle that can\'t be dissolved! Now that\'s progress.  Dominion: Alchemy is an expansion, and can\'t be played by itself; to play with it, you need Dominion a standalone expansion to Dominion (Dominion: Intrigue), or Dominion Base Cards . Those provide the Basic cards you need to play (Treasure, Victory, and Curse cards), as well as the full rules for setup and gameplay. Dominion: Alchemy can also be combined with any other Dominion expansions you have.'),
(19, 'Dominion Hinterland', '1500.00', 'Deck building, Expansion', 10, 'dominion_hinterland.jpg', 0, '2017-11-25 02:42:39', 'The world is big and your kingdom small. Small when compared to the world, that is; it\'s moderate-sized when compared to other kingdoms. But in a big world like this one - big when compared to smaller worlds anyway, if such things exist; it\'s moderate-sized when compared to worlds of roughly the same size, and a little small when compared to worlds just a little larger - well, to make a long story short - short when compared to longer stories anyway - it is time to stretch your borders. You\'ve heard of far-off places - exotic countries, where they have pancakes but not waffles, where the people wear the wrong number of shirts, and don\'t even have a word for the look two people give each other when they each hope that the other will do something that they both want done but which neither of them wants to do. It is to these lands that you now turn your gaze.  Dominion: Hinterlands is the sixth addition to the game of Dominion. It adds 26 new Kingdom cards to Dominion, including 20 Actions, 3 Treasures, 3 Victory cards, and 3 Reactions. The central theme is cards that do something immediately when you buy them or gain them.'),
(20, 'Exploding Kittens (Party pack)', '1800.00', 'Bluff, Party', 20, 'ex_kittens_party.png', 0, '2017-11-25 02:45:35', 'Select cards from Exploding Kittens, Imploding Kittens and the Exploding Kittens App All new cards backs with white border to prevent chipping 2-10 Players A new mechanism for balancing the game to the number of players in your party The box plays party music when opened - take a listen below'),
(21, 'Arcadia Quest (Base box)', '4000.00', 'Thematic, RPG', 10, 'arcadia_base.png', 0, '2017-11-25 02:50:18', 'In Arcadia Quest, players lead guilds of intrepid heroes on an epic campaign to dethrone the vampire lord and reclaim the mighty Arcadia for their own. But only one guild may lead in the end, so players must battle against each other as well as against the monstrous occupying forces.  Arcadia Quest is a campaign-based game for 2 to 4 players, where each player controls a guild of three unique heroes, facing off against the other players and the various monsters controlled by the game. Players need to accomplish a series of quests in order to win each scenario and choose where to go next in the campaign.  Players are able to choose the path their campaign takes, navigating through six out of eleven available scenarios, so each time the campaign is played it can have a different configuration of scenarios. As the campaign progresses, the heroes are able to acquire new weapons, equipment and abilities that give them powerful options to tackle the obstacles ahead. Furthermore, by fulfilling specific quests in a scenario, players unlock exclusive features in subsequent scenarios.'),
(22, 'Arcadia Quest : Fire Dragon', '3000.00', 'Thematic, RPG, Expansion', 5, 'arcadia_fire_dragon.jpg', 0, '2017-11-25 02:55:08', 'Mog\'dor, the Fire Dragon, is a blight upon the land. He mercilessly burns everything in his path, setting crops and cottages ablaze! One last time, the guilds of Arcadia will need to unite if they are to have any hope of defeating this scorching foe.  The Fire Dragon box is similar to the Frost Dragon, Chaos Dragon, and Poison Dragon boxes, presenting the opportunity to extend any campaign beyond the final scenario, into an epic showdown with this majestic dragon. While the overall structure is similar, The Fire dragon offers a whole new experience for players, with new mechanics and new gear bringing all new challenges and strategies!'),
(23, 'Arcadia Quest : Frost Dragon', '3000.00', 'Thematic, RPG, Expansion', 4, 'arcadia_frost_dragon.jpg', 0, '2017-11-25 02:55:08', 'The Frost Dragon is an expansion for both Arcadia Quest, and Arcadia Quest inferno.  The game comes with a large Dragon Mini, new loot cards, new tiles and the new type of cards, \"Dragonstone cards\".  After finishing a campaign, the players will get a new load out of Level 6 Upgrade cards, with a budget that is based on the amount of medals each guild completed during the campaign.  This last part of the fight doesn’t have PvP Quest Cards and all players have to kill the Dragon before he wrecks too much of the city! This is a fully cooperative fight, in which the players win as a group if they manage to kill the Dragon and they lose if too many parts of the city have been destroyed, or if the Dragon kills Heroes so much that they can’t find the resolve to continue the fight. In this ultimate showdown, the Dragon is controlled by a special set of Dragon Turn cards that will trigger special attacks and movements from the Frost Dragon. Players will need to make tough choices in the face of the Dragon\'s actions, deciding as a group where to focus their efforts (and who to sacrifice).'),
(24, 'Arcadia Quest : Chaos Dragon', '3000.00', 'Thematic, RPG, Expansion', 3, 'arcadia_chaos_dragon.jpg', 8, '2017-11-25 02:55:08', 'The mighty Chaos Dragon is sowing chaos into the city of Arcadia. The laws of nature hardly apply, and the very fabric of reality that holds the realm together threatens to unravel. The guilds of Arcadia will need an uneasy truce between them in order to take down this magnificent chaotic foe!'),
(25, 'Arcadia Quest : Pets', '3000.00', 'Thematic, RPG, Expansion', 13, 'arcadia_pets.jpg', 0, '2017-11-25 02:55:08', 'Arcadia Quest: Pets is not only a campaign expansion, bringing a whole new campaign, with new scenarios, monsters, heroes, rewards, and titles, for use with either the original Arcadia Quest or the Arcadia Quest: Inferno core boxes, but it’s also a modular expansion that introduces Pets, a brand new system that can be added to ANY Arcadia Quest experience. This includes classic Arcadia Quest, Arcadia Quest: Inferno, Beyond the Grave and even Frost Dragon, The Fall of Arcadia and anything else Cool Mini or Not come up with.'),
(26, 'Arcadia Quest : Beyond The Grave', '3000.00', 'Thematic, RPG, Expansion', 14, 'arcadia_beyond_the_grave.jpg', 0, '2017-11-25 02:55:08', 'Nobody paid much attention when Dr. Spider was expelled from Arcadia University for excessive experiments into Necromancy. Even Lord Fang ignored him after taking over the city, and the bad Doctor pillaged the cemeteries and mausoleums of Arcadia for test subjects. Obsessed with his experiments, Dr. Spider retreated to his secret lab and worked long hours to tease the secret of immortality from the universe, and to prove, once and for all, that he should have fame, fortune, and (most importantly) tenure! The accidental revivification of the Dread King to his mortal form was merely a side effect! Nothing to worry about. … Well, nothing for Dr. Spider to worry about. That\'s what heroes are for, right?'),
(27, 'Arcadia Quest : Inferno', '3000.00', 'Thematic, RPG, Expansion', 5, 'arcadia_inferno.jpg', 0, '2017-11-25 02:56:50', 'Inferno is a standalone expansion to Arcadia Quest. It is 100% compatible with the original base game and introduces four new Guilds: Sharks, Tigers, Crows, and Serpents. It features new types of heroes, such as Alchemists and Gladiators.  There is a new branching campaign system, and the storyline revolves around the guilds descending into a fiery abyss. There are Brimstone cards that make the terrain risky to navigate, which operate similarly to the Tombstone cards from Arcadia Quest: Beyond the Grave.  A new mechanism called \"Damnation\" will tempt the heroes with powerful weapons that can corrupt the characters over time or change the behavior of nearby monsters. There are also Angels, which are allied characters for the heroes to rescue, escort or assist. Working with the Angels can affect the branching campaign path system and even allow the player to recruit them for use in later missions.'),
(28, 'Masmorra : Dungeon of Arcadia', '3800.00', 'Thematic, RPG', 6, 'masmorra.png', 0, '2017-11-25 02:58:12', 'Masmorra: Dungeons of Arcadia is a fast-paced, dice-driven dungeon crawl board game set in the Arcadia Quest universe where players control Heroes that explore three levels of a dungeon filled with monsters, traps and treasure! Bosses, special rooms and countless surprises await the Heroes, but only one can be the first to reach the final level and become the undisputed champion of the Realm!  In Masmorra, players get to roll and re-roll a pool of Dice that guides their actions for their turn, and a unique dungeon is created as players lay down tiles while exploring it and fighting off monsters that are presented by special dice! But Heroes must also be aware of opponent Heroes, as they\'ll be able to use cards to disrupt their carefully laid-out plans!'),
(29, 'Pandemic', '1600.00', 'Cooperation', 17, 'pandemic.png', 0, '2017-11-26 02:33:49', 'In Pandemic, several virulent diseases have broken out simultaneously all over the world! The players are disease-fighting specialists whose mission is to treat disease hotspots while researching cures for each of four plagues before they get out of hand.  The game board depicts several major population centers on Earth. On each turn, a player can use up to four actions to travel between cities, treat infected populaces, discover a cure, or build a research station. A deck of cards provides the players with these abilities, but sprinkled throughout this deck are Epidemic! cards that accelerate and intensify the diseases\' activity. A second, separate deck of cards controls the \"normal\" spread of the infections.');

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
-- AUTO_INCREMENT for table `orderheader`
--
ALTER TABLE `orderheader`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `TYPE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
