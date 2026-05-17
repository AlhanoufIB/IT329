-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 21, 2026 at 11:05 AM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipesystem`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blockeduser`
--

INSERT INTO `blockeduser` (`UserID`, `FirstName`, `LastName`, `Email`) VALUES
(9, 'omar', 'fahad', 'omar@gmail.com'),
(10, 'Salem', 'fahad', 'Salem@gmail.com'),
(11, 'Ibrahim', 'Almusnad', 'Ibrahim@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `CommentID` int(11) NOT NULL,
  `RecipeID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`CommentID`, `RecipeID`, `UserID`, `comment`, `date`) VALUES
(1, 4, 9, 'Very Good!', '2026-04-18 22:22:10'),
(2, 6, 7, 'NICE!', '2026-04-18 22:22:10'),
(5, 11, 8, 'WOW!', '2026-04-18 22:22:59'),
(6, 4, 14, 'tasty', '2026-04-20 00:12:38');

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `UserID` int(11) NOT NULL,
  `RecipeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`UserID`, `RecipeID`) VALUES
(8, 4),
(9, 4),
(14, 4),
(7, 5),
(9, 5),
(14, 5),
(14, 6);

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `IngredientID` int(11) NOT NULL,
  `RecipeID` int(11) NOT NULL,
  `ingredientName` varchar(100) NOT NULL,
  `ingredientQuantity` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`IngredientID`, `RecipeID`, `ingredientName`, `ingredientQuantity`) VALUES
(19, 5, 'oats', '1 cup'),
(20, 5, 'water', '1 cup'),
(28, 11, 'Flour', '1 cup'),
(31, 4, 'Flour', '1 cup'),
(32, 4, 'sweetsyrup', '1 teaspoon'),
(33, 4, 'Milk', '1 cup'),
(38, 6, 'Dates', '1 cup'),
(39, 6, 'Cocoa', '1 cup');

-- --------------------------------------------------------

--
-- Table structure for table `instructions`
--

CREATE TABLE `instructions` (
  `InstructionID` int(11) NOT NULL,
  `RecipeID` int(11) NOT NULL,
  `Step` text NOT NULL,
  `StepOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `instructions`
--

INSERT INTO `instructions` (`InstructionID`, `RecipeID`, `Step`, `StepOrder`) VALUES
(22, 5, 'add all ingredients', 1),
(23, 5, 'Boil', 2),
(29, 11, 'add all ingredients', 1),
(31, 4, 'add all ingredients', 1),
(32, 4, 'mix ingredients', 2),
(33, 4, 'Fry in a pan', 3),
(36, 6, 'mix ingredients', 1);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `UserID` int(11) NOT NULL,
  `RecipeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`UserID`, `RecipeID`) VALUES
(8, 4),
(9, 4),
(14, 4),
(7, 5),
(9, 5);

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `RecipeID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `description` text,
  `PhotoFileName` varchar(255) DEFAULT NULL,
  `VideoPathName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`RecipeID`, `UserID`, `CategoryID`, `Name`, `description`, `PhotoFileName`, `VideoPathName`) VALUES
(4, 7, 1, 'Luqaimat', 'Luqaimat are traditional bite-sized dough balls that are deep-fried until perfectly golden and crispy on the outside while staying soft and airy on the inside. They’re then drenched in sweet syrup—usually date syrup', 'luqaimat.jpg', 'https://youtu.be/77Te7fNjahk?si=UNU-IEA1hV0zs3nO'),
(5, 8, 2, 'Oat Soup', 'A warm and comforting oat soup made with wholesome oats, lightly seasoned and simmered to a smooth, creamy texture—perfect for a healthy and filling meal.', 'Oat-soup.jpg', NULL),
(6, 9, 3, 'Date Balls', 'Date balls are bite-sized, naturally sweet treats made from blended dates, nuts, and sometimes cocoa or coconut—rolled into soft, energy-packed snacks that are both healthy and delicious.', 'Date-balls.jpg', 'dateballs video.mp4'),
(11, 14, 1, 'qatayef', 'Qataef are soft, fluffy Arabic pancakes filled with sweet cream, nuts, or cheese, then folded and often fried or served fresh—drizzled with syrup for a rich, traditional dessert popular during Ramadan.', 'qatayef.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recipecategory`
--

CREATE TABLE `recipecategory` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`ReportID`, `RecipeID`, `UserID`) VALUES
(7, 4, 8),
(9, 4, 14),
(10, 5, 14),
(11, 6, 14);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `UserType`, `FirstName`, `LastName`, `Email`, `Password`, `ProfilePhoto`) VALUES
(4, 'admin', 'Khalid', 'Almoayed', 'Khalid@gmail.com', '$2y$10$XPj41Wz21oCp7W2mCSfVXuwfocZ5ts/S.n718SNQLjVIeqXwi57w.', 'Khalid.png'),
(7, 'user', 'Saleh', 'Ahmed', 'saleh@gmail.com', '$2y$10$AZXOPd7cgpMav2rNr/vrKOa/2FgDIr6MUjZzjApgjx5A/sZcQAKeG', 'default.png'),
(8, 'user', 'Ahemd', 'Nasser', 'Ahmed@gmail.com', '$2y$10$C6AOl0kF4KoxHnvWGYl5sO4hBVFey5k//vdZ01Qw3uesZBzRb8kDG', 'ChefAhmed.jpg'),
(9, 'user', 'noura', 'saud', 'noura@gmail.com', '$2y$10$bQ8vyo4ozJT91ppP3uJhL.BH1AWUvzLZR6dQ.S41FaaRK0KELdBwa', 'noura.jpg'),
(14, 'user', 'layal', 'Saled', 'layal@gmail.com', '$2y$10$JsrBEWjsRgCZfPfoCif6keqiqmk30rqVnhT6YtUOX6DpBaAnL1XlS', 'Layla.png');

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
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `IngredientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `instructions`
--
ALTER TABLE `instructions`
  MODIFY `InstructionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `RecipeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `recipecategory`
--
ALTER TABLE `recipecategory`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
