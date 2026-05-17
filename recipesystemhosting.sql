-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql303.infinityfree.com
-- Generation Time: May 17, 2026 at 11:52 AM
-- Server version: 11.4.10-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_41939933_recipesystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `blockeduser`
--

CREATE TABLE `blockeduser` (
  `UserID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `blockeduser`
--

INSERT INTO `blockeduser` (`UserID`, `FirstName`, `LastName`, `Email`) VALUES
(9, 'omar', 'fahad', 'omar@gmail.com'),
(10, 'Salem', 'fahad', 'Salem@gmail.com'),
(11, 'Ibrahim', 'Almusnad', 'Ibrahim@gmail.com'),
(12, 'Aliyah', 'Alharbi', 'aliyah@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `CommentID` int(11) NOT NULL,
  `RecipeID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`CommentID`, `RecipeID`, `UserID`, `comment`, `date`) VALUES
(7, 15, 30, 'Very Good!', '2026-05-17 07:22:23'),
(9, 15, 33, 'Tasty', '2026-05-17 07:34:05'),
(10, 16, 31, 'NICE!', '2026-05-17 07:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `UserID` int(11) NOT NULL,
  `RecipeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`UserID`, `RecipeID`) VALUES
(27, 15),
(32, 15),
(33, 15);

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `IngredientID` int(11) NOT NULL,
  `RecipeID` int(11) NOT NULL,
  `ingredientName` varchar(100) NOT NULL,
  `ingredientQuantity` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`IngredientID`, `RecipeID`, `ingredientName`, `ingredientQuantity`) VALUES
(41, 15, 'Flour', '1 cup'),
(42, 15, 'sweetsyrup', '1 teaspoon'),
(43, 15, 'Milk', '1 cup'),
(50, 16, 'Dates', '1 cup'),
(51, 16, 'Cocoa', '1 cup'),
(52, 18, 'Flour', '1 cup'),
(54, 20, 'oats', '1 cup'),
(55, 20, 'water', '1 cup');

-- --------------------------------------------------------

--
-- Table structure for table `instructions`
--

CREATE TABLE `instructions` (
  `InstructionID` int(11) NOT NULL,
  `RecipeID` int(11) NOT NULL,
  `Step` text NOT NULL,
  `StepOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `instructions`
--

INSERT INTO `instructions` (`InstructionID`, `RecipeID`, `Step`, `StepOrder`) VALUES
(40, 15, 'add all ingredients', 1),
(41, 15, 'mix ingredients', 2),
(42, 15, 'fry', 3),
(47, 16, 'mix ingredients', 1),
(48, 18, 'Add all ingredients', 1),
(50, 20, 'add all ingredients', 1),
(51, 20, 'boil', 2);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `UserID` int(11) NOT NULL,
  `RecipeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`UserID`, `RecipeID`) VALUES
(27, 15),
(32, 15),
(33, 15),
(31, 20);

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `RecipeID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `PhotoFileName` varchar(255) DEFAULT NULL,
  `VideoPathName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`RecipeID`, `UserID`, `CategoryID`, `Name`, `description`, `PhotoFileName`, `VideoPathName`) VALUES
(15, 31, 1, 'Luqaimat', 'Luqaimat are traditional bite-sized dough balls that are deep-fried until perfectly golden and crispy on the outside while staying soft and airy on the inside. They’re then drenched in sweet syrup—usually date syrup', 'recipe_1779027506_9859.jpeg', 'https://www.youtube.com/watch?si=UNU-IEA1hV0zs3nO&v=77Te7fNjahk&feature=youtu.be'),
(16, 30, 3, 'Date Balls', 'Date balls are bite-sized, naturally sweet treats made from blended dates, nuts, and sometimes cocoa or coconut—rolled into soft, energy-packed snacks that are both healthy and delicious.', 'recipe_1779027671_4134.jpeg', '31b68846-1f33-4d7f-a667-39297e178e14.mp4'),
(18, 33, 1, 'qatayef', 'Qataef are soft, fluffy Arabic pancakes filled with sweet cream, nuts, or cheese, then folded and often fried or served fresh—drizzled with syrup for a rich, traditional dessert popular during Ramadan.', 'recipe_1779028416_1065.jpeg', NULL),
(20, 32, 2, 'Oat Soup', 'A warm and comforting oat soup made with wholesome oats, lightly seasoned and simmered to a smooth, creamy texture—perfect for a healthy and filling meal.', 'recipe_1779033117_7651.jpeg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recipecategory`
--

CREATE TABLE `recipecategory` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `recipecategory`
--

INSERT INTO `recipecategory` (`CategoryID`, `CategoryName`) VALUES
(1, 'Iftar'),
(2, 'Suhoor'),
(3, 'Snack');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `ReportID` int(11) NOT NULL,
  `RecipeID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`ReportID`, `RecipeID`, `UserID`) VALUES
(16, 15, 32),
(17, 16, 31);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `UserType` enum('user','admin') NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ProfilePhoto` varchar(255) NOT NULL DEFAULT 'defalut.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `UserType`, `FirstName`, `LastName`, `Email`, `Password`, `ProfilePhoto`) VALUES
(4, 'admin', 'Khalid', 'Almoayed', 'Khalid@gmail.com', '$2y$10$XPj41Wz21oCp7W2mCSfVXuwfocZ5ts/S.n718SNQLjVIeqXwi57w.', 'Khalid.png'),
(22, 'user', 'Ibrahim', 'Almusnad', 'Alhanoufib@hotmail.com', '$2y$10$EvvRcMh2YGNxMguh9rxire8yf7VVfgFtLCRZ7lMjg640.oigYCP7q', 'default.png'),
(27, 'user', 'Layan', 'As\'Saab', 'loin@gmail.com', '$2y$10$.2Xdh2.M0PuiqiBdVOqeteTiW1wmoU/a8F3PV2Az09wqTkQlLNYLO', 'profile_1779023964_7484.jpeg'),
(29, 'user', 'hano', 'Almusnad', 'a@hotmail.com', '$2y$10$hVX0J8hMEyalcmOtVRuRX.K0jh.JZcE7gWXYescevbOQ4EBN3srOC', 'profile_1779025535_9795.jpeg'),
(30, 'user', 'noura', 'saud', 'noura@gmail.com', '$2y$10$kD6a25.22p3dVfaf29XEE.Bnvw.rsebWJXO9vyBTXUtwdipOa3gqu', 'profile_1779027249_5631.jpeg'),
(31, 'user', 'saleh', 'Ahemd', 'saleh@gmail.com', '$2y$10$gOLvYski1czo96CcDDFsSO/buaa8TS5QydhZ44itJiawiaZPqV93S', 'default.png'),
(32, 'user', 'Ahemd', 'Nasser', 'Ahmed@gmail.com', '$2y$10$FUpiPWbL9CbLcbc324wNU.az34FkXi/pSyr/j3WKaw/MBNFa9iqga', 'profile_1779027694_4832.jpeg'),
(33, 'user', 'Layal', 'Saled', 'layal@gmail.com', '$2y$10$dJDMS..0muONLUe/5R6zs.efzlXF6cl7ZbY9SE7D.tpVulJdA39b6', 'profile_1779028308_4032.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blockeduser`
--
ALTER TABLE `blockeduser`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `comment_ibfk_1` (`RecipeID`),
  ADD KEY `comment_ibfk_2` (`UserID`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`UserID`,`RecipeID`),
  ADD KEY `RecipeID` (`RecipeID`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`IngredientID`),
  ADD KEY `ingredients_ibfk_1` (`RecipeID`);

--
-- Indexes for table `instructions`
--
ALTER TABLE `instructions`
  ADD PRIMARY KEY (`InstructionID`),
  ADD KEY `instructions_ibfk_1` (`RecipeID`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`UserID`,`RecipeID`),
  ADD KEY `likes_ibfk_3` (`RecipeID`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`RecipeID`),
  ADD KEY `recipe_ibfk_1` (`CategoryID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `recipecategory`
--
ALTER TABLE `recipecategory`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`ReportID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `RecipeID` (`RecipeID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blockeduser`
--
ALTER TABLE `blockeduser`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `IngredientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `instructions`
--
ALTER TABLE `instructions`
  MODIFY `InstructionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `RecipeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `recipecategory`
--
ALTER TABLE `recipecategory`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`RecipeID`) REFERENCES `recipe` (`RecipeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`RecipeID`) REFERENCES `recipe` (`RecipeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `ingredients_ibfk_1` FOREIGN KEY (`RecipeID`) REFERENCES `recipe` (`RecipeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `instructions`
--
ALTER TABLE `instructions`
  ADD CONSTRAINT `instructions_ibfk_1` FOREIGN KEY (`RecipeID`) REFERENCES `recipe` (`RecipeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_3` FOREIGN KEY (`RecipeID`) REFERENCES `recipe` (`RecipeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_4` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `recipecategory` (`CategoryID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`RecipeID`) REFERENCES `recipe` (`RecipeID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
