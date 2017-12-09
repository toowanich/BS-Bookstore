-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2017 at 09:56 AM
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
(1, 'Avalon (ENG)', '750.00', 'Bluff, Party', 0, 'avalon_en.jpg', 0, '2017-11-26 02:03:09', 'https://boardgamegeek.com/boardgame/128882/resistance-avalon'),
(2, 'Bears VS Babies', '1550.00', 'Bluff, Party', 99, 'bears_vs_babies.jpg', 0, '2017-11-18 00:00:00', 'https://boardgamegeek.com/boardgame/211534/bears-vs-babies'),
(3, 'Deception: Murder in Hong Kong', '1650.00', 'Bluff, Case solving', 99, 'deception.jpg', 0, '2017-11-17 00:00:00', 'https://boardgamegeek.com/boardgame/156129/deception-murder-hong-kong'),
(4, 'Dominion Intrigue', '1850.00', 'Deck Building', 100, 'dominion_intrigue.jpg', 0, '2017-11-17 00:00:00', 'https://boardgamegeek.com/boardgame/40834/dominion-intrigue'),
(5, 'Exploding Kittens (1st Edition)', '1290.00', 'Party', 0, 'ex_kittens_1ed.png', 0, '2017-11-17 00:00:00', 'https://boardgamegeek.com/boardgame/172225/exploding-kittens'),
(6, 'Exploding Kittens (Black Box)', '1090.00', 'Party', 100, 'ex_kittens_black.jpg', 10, '2017-11-17 00:00:00', 'https://boardgamegeek.com/boardgame/172225/exploding-kittens'),
(7, 'Exploding Kittens (Red Box)', '990.00', 'Party', 100, 'ex_kittens_red.png', 0, '2017-11-17 00:00:00', 'https://boardgamegeek.com/boardgame/172225/exploding-kittens'),
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
