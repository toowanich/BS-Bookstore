-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2017 at 08:34 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `deposit` (IN `accno` VARCHAR(20), IN `amount` FLOAT)  MODIFIES SQL DATA
    DETERMINISTIC
BEGIN
select @accid:=id from account where no=accno;
insert into transaction(type,amount,date,accid) 
values('D',amount,now(),@accid);
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `withdraw` (IN `accno` VARCHAR(20), IN `amount` FLOAT)  MODIFIES SQL DATA
    DETERMINISTIC
BEGIN
 select @accid:=id from account where no=accno;
 INSERT INTO transaction(type,amount,date,accid)
 VALUES('W',amount,now(),@accid);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `withdraw2` (IN `accno` VARCHAR(20), IN `amount` FLOAT)  MODIFIES SQL DATA
BEGIN
SET @accid = null;
SELECT id into @accid FROM account where no=accno;
IF @accid is null THEN
	SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Account not found';
ELSE
	SELECT calBalance(@accid) INTO @bal;
    IF @bal - amount < 0 THEN
    	SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Not enough money';
        ROLLBACK;
    END IF;
    INSERT INTO transaction(type, amount, date,accid) 
    VALUES ('W', amount,now(),@accid);
    COMMIT;
END IF;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `calBalance` (`id2` INT) RETURNS FLOAT MODIFIES SQL DATA
    DETERMINISTIC
BEGIN
 
 SELECT SUM(CASE TYPE WHEN 'W' THEN -amount WHEN 'D' THEN amount END) INTO @ans FROM transaction where accid=id2;
 RETURN @ans;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `CustomerLevel` (`p_creditLimit` DOUBLE) RETURNS VARCHAR(10) CHARSET latin1 NO SQL
    DETERMINISTIC
BEGIN
DECLARE lvl varchar(10);
If p_creditLimit > 50000 Then 
 SET lvl = 'PLATINUM';
ELSEIF (p_creditLimit <=50000 and p_creditLimit >= 10000) THEN 
 SET lvl = 'Gold';
ELSEIF p_creditLimit < 10000 THEN
 SET lvl = 'SILVER';
END IF;

RETURN (lvl);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `no` varchar(20) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `creditLimit` double DEFAULT NULL,
  `bal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `no`, `name`, `creditLimit`, `bal`) VALUES
(1, '1111', 'Mr. A', 15000, 6800),
(2, '2222', 'Mr. B', 55000, 500);

--
-- Triggers `account`
--
DELIMITER $$
CREATE TRIGGER `onupdatechk` BEFORE UPDATE ON `account` FOR EACH ROW BEGIN




END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `onuserdelete` AFTER DELETE ON `account` FOR EACH ROW BEGIN

insert into userhistory(logmessage,userid)
values('DELETE USER',old.id);


END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `onuserinsert` AFTER INSERT ON `account` FOR EACH ROW BEGIN

insert into userhistory(logmessage,userid)
values('ADD NEW USER',new.id);



END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `type` char(1) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `accid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `type`, `amount`, `date`, `accid`) VALUES
(1, 'D', 5000, '2016-11-16 08:33:31', 1),
(2, 'W', 100, '2016-11-16 08:42:52', 1),
(3, 'D', 1000, '2016-11-16 08:53:01', 2),
(4, 'W', 500, '2016-11-16 08:53:11', 2),
(5, 'W', 100, '2016-11-23 08:30:17', 1),
(6, 'D', 1000, '2016-11-23 08:52:22', 1),
(7, 'W', 1000, '2016-11-23 08:53:19', 1),
(8, 'W', 100, '2017-11-06 08:22:37', 1),
(9, 'W', 100, '2017-11-06 08:23:27', 1),
(10, 'W', 100, '2017-11-06 08:26:45', 1),
(11, 'D', 100, '2017-11-06 08:43:44', 1),
(12, 'D', 100, '2017-11-06 08:44:47', 1),
(13, 'D', 100, '2017-11-06 08:45:00', 1),
(14, 'D', 1000, '2017-11-06 08:47:16', 1),
(15, 'D', 1000, '2017-11-06 08:49:12', 1),
(16, 'W', 1000, '2017-11-06 08:49:41', 1),
(17, 'D', 1000, '2017-11-06 08:49:52', 1),
(18, 'W', 1000, '2017-11-06 08:50:06', 1),
(19, 'D', 500, '2017-11-06 08:50:31', 1),
(20, 'D', 1000, '2017-11-06 08:51:29', 1),
(21, 'W', 1000, '2017-11-06 08:51:58', 1),
(22, 'D', 1000, '2017-11-06 08:52:06', 1),
(23, 'D', 1, '2017-11-06 08:52:41', 1),
(24, 'W', 1, '2017-11-06 08:52:54', 1),
(25, 'D', 1, '2017-11-06 08:54:12', 1),
(26, 'D', 100, '2017-11-06 08:57:05', 1),
(27, 'W', 100, '2017-11-06 08:57:18', 1),
(28, 'D', 100, '2017-11-06 08:58:37', 1),
(29, 'D', 100, '2017-11-06 08:59:03', 1),
(30, 'D', 100, '2017-11-06 09:00:09', 1),
(31, 'W', 500, '2017-11-06 09:00:20', 1),
(33, 'W', 1, '2017-11-15 14:11:36', 1),
(34, 'W', 101, '2017-11-15 14:13:23', 1),
(35, 'W', 101, '2017-11-15 14:14:39', 1),
(36, 'W', 101, '2017-11-15 00:00:00', 1),
(39, 'W', 101, '2017-11-15 14:21:56', 1),
(43, 'D', 4, '2017-11-15 14:32:32', 1),
(44, 'D', 100, '2017-11-15 14:33:14', 1);

--
-- Triggers `transaction`
--
DELIMITER $$
CREATE TRIGGER `beforetransaction` BEFORE INSERT ON `transaction` FOR EACH ROW BEGIN

SET @bal = calBalance(new.accid);


IF new.type = 'W' THEN
	IF new.amount > @bal THEN
    	SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'NOT ENOUGH MONEY';
    END IF;
END IF;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ontransactiondelete` AFTER DELETE ON `transaction` FOR EACH ROW BEGIN

INSERT INTO transaction_history(type,amount,date,accid,deldate)
VALUES(old.type,old.amount,old.date,old.accid,NOW());

UPDATE account SET account.bal = calBalance(old.accid) 
WHERE account.id = old.accid;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `transupdatechk` BEFORE UPDATE ON `transaction` FOR EACH ROW BEGIN

SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'UPDATE NOT ALLOWED';

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updatebal` AFTER INSERT ON `transaction` FOR EACH ROW BEGIN

UPDATE account SET account.bal = calBalance(new.accid) 
WHERE account.id = new.accid;


END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `id` int(11) NOT NULL,
  `type` varchar(1) NOT NULL,
  `amount` float NOT NULL,
  `date` datetime NOT NULL,
  `accid` int(11) NOT NULL,
  `deldate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`id`, `type`, `amount`, `date`, `accid`, `deldate`) VALUES
(1, 'W', 1, '2017-11-15 14:09:41', 1, '2017-11-15 14:27:33'),
(2, 'D', 2000, '2017-11-15 14:27:55', 2, '2017-11-15 14:29:12'),
(3, 'D', 5, '2017-11-15 14:22:30', 1, '2017-11-15 14:30:39'),
(4, 'D', 2000, '2017-11-15 14:31:55', 2, '2017-11-15 14:32:10'),
(5, 'W', 800, '2017-11-15 14:33:46', 1, '2017-11-15 14:34:00');

-- --------------------------------------------------------

--
-- Table structure for table `userhistory`
--

CREATE TABLE `userhistory` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `logmessage` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userhistory`
--

INSERT INTO `userhistory` (`id`, `userid`, `logmessage`) VALUES
(0, 2, 'no. change 2222 to 2222');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
