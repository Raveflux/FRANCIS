-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2024 at 05:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_rewards`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `school_id_number` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `points` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `age`, `school_id_number`, `username`, `password`, `points`) VALUES
(37, 'francis', 21, 'SCC-19-000234245', 'francis', '$2y$10$hvbgjEyE5R2a0YpL6s7h6OC5ZHFY7wbZJxtD25ojB4YDVnrzx2MTe', 0),
(39, 'leo', 21, 'SCC-19-0002342456', 'leocutie', '$2y$10$Mx.B.hmsK1.r3CY1Di33TOQ6W5.OyD0gTKTAQ.KGE7cgpiD2mC/N.', 0),
(40, 'Rafayla', 23, 'SCC-19-0002342452', 'Rafayla23', '$2y$10$sWS6fyxLETOUiAM4xlu28uuwU9UUNxg7VbbOS8nX2QPj8XI1DBNV.', 0),
(41, 'cantos', 22, 'SCC-19-00023424513', 'cantos', '$2y$10$zFjy9B/02zHZFesTjsJB7uG.qwRVbxFMqIzrFS4DPofsppMul9oNW', 0),
(42, 'ernest', 22, 'SCC-19-000234424513', 'ernest', '$2y$10$oDeyTGrQrnSPhKdlu53KWeA7sboYlFFV9fuXiESH1gcMHobEDtWF2', 0),
(43, 'arthur', 22, 'SCC-19-0002334424513', 'arthur', '$2y$10$YpVYp/Gt0FrTNQN38MtUW.da6WLOBShQh8Z0XuGnrk75ActFBSTAe', 0),
(44, 'mike', 22, 'SCC-19-0004424513', 'mike', '$2y$10$TbT1Hhvv1YamLlMCDsQW1enoeKwNv97vuJLndDtwbkQZamYvc6Dg2', 0),
(45, 'nathan', 22, 'SCC-19-00044424513', 'nathan', '$2y$10$3QUi3mA.94Mnd4HbomYI6eVNMC2PAvTbzB/ytqLXyiOmNtMvsd8yy', 0),
(46, 'xavier', 22, 'SCC-19-000443424513', 'xavier', '$2y$10$2Wt.rWCXMq2qzwct1pwip.vm7OAHjCy4JhqQXOmuSbU6ySdkNhava', 0),
(47, 'wilmar', 23, 'SCC-19-0002342482', 'wilmar', '$2y$10$IoQ7UDZawz5V9.maih3G5u4mf/tuwVSOCibI75Rf/O0Ws1V0UkVE.', 0),
(48, 'pairyl', 23, 'SCC-19-00023342482', 'pairyl', '$2y$10$JksBvbSdwMyBeR58KBn3S.QuUoTBtRjCApqJ9dnq6NAD3YanYnpC6', 0),
(49, 'kirk', 18, 'SCC-19-423423', 'kirk', '$2y$10$xgxpS6jUvKJPCKkwdYE1qe00KJj1iUSsoiX52l4tX6qh/O6rGq8y.', 0),
(50, 'rexy', 28, 'SCC-19-00023422452', 'rexy', '$2y$10$s8dN1QYzh2wjvaV6J6HzXu..PbYBcKUfgg.Rwj3qOFGodPGNMwfqe', 0),
(51, 'francis', 21, 'SCC-19-0002334245', 'francis23', '$2y$10$1Ddo/T66bv7BcCNU0RplheoiWgMnE.nX5Sngm5KC8JvGaWUV9oEfu', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `school_id_number` (`school_id_number`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
