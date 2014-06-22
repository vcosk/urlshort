SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


--
-- Database: `goahead_short`
--

-- --------------------------------------------------------

--
-- Table structure for table `URL_MAP`
--

CREATE TABLE IF NOT EXISTS `URL_MAP` (
  `CODE` varchar(7) DEFAULT NULL,
  `LINK` varchar(1000) NOT NULL,
  `COUNT` int(3) DEFAULT '0',
  `USER_ID` int(1) NOT NULL DEFAULT '0',
  `TS` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
