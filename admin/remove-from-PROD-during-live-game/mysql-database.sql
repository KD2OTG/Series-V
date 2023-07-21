-- phpMyAdmin SQL Dump
-- version 4.9.10
-- https://www.phpmyadmin.net/
--
-- Host: db771712099.hosting-data.io
-- Generation Time: Jul 21, 2023 at 06:15 PM
-- Server version: 5.7.38-log
-- PHP Version: 7.0.33-0+deb9u12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db771712099`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_emails`
--

CREATE TABLE `app_emails` (
  `app_email_id` int(11) NOT NULL,
  `email_subject` varchar(255) NOT NULL,
  `email_body` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_emails`
--

INSERT INTO `app_emails` (`app_email_id`, `email_subject`, `email_body`) VALUES
(1, 'Series-V - Account Enrollment Email Verification', 'Hello [ALIAS],\r\n\r\nTo continue creating your new [GAMENAME] account, please verify your email address by entering the VERIFICATION PIN within the ENROLL command you have open in the game window now:\r\n\r\nVERIFICATION PIN: [PIN]\r\n\r\n[GAMENAME] requires a verified email address in order to perform password resets and to receive important communications regarding your account.\r\n\r\n*** If you believe you have received this email in error as you did not recently attempt to create a new account to play [GAMENAME], you can safely ignore this email. ***\r\n\r\nRegards,\r\n\r\nMatt Robb'),
(2, 'Series-V - Password Reset Email Verification', 'Hello,\r\n\r\nTo continue resetting your forgotten password on your [GAMENAME] account, please verify your email address by entering the VERIFICATION PIN within the FORGOT command you have open in the game window now:\r\n\r\nVERIFICATION PIN: [PIN]\r\n\r\n[GAMENAME] requires a verified email address in order to perform password resets and to receive important communications regarding your account.\r\n\r\n*** If you believe you have received this email in error as you did not recently attempt to reset a forgotten password to play [GAMENAME], you can safely ignore this email. ***\r\n\r\nRegards,\r\n\r\nMatt Robb');

-- --------------------------------------------------------

--
-- Table structure for table `app_game`
--

CREATE TABLE `app_game` (
  `app_game_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `gameStart` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gameEnd` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dailyTurns` int(11) NOT NULL DEFAULT '500',
  `dailyTurnsLastUpdated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_game`
--

INSERT INTO `app_game` (`app_game_id`, `description`, `gameStart`, `gameEnd`, `dailyTurns`, `dailyTurnsLastUpdated`) VALUES
(1, 'Open Play / Exploration', '2023-01-01 13:00:00', '2034-01-01 02:00:00', 500, '2023-07-21 04:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `app_help`
--

CREATE TABLE `app_help` (
  `app_help_id` int(11) NOT NULL,
  `command` varchar(128) NOT NULL,
  `content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `app_help`
--

INSERT INTO `app_help` (`app_help_id`, `command`, `content`) VALUES
(1, 'HELP', 'Type HELP [COMMAND-NAME] for more information on a specific command.<br>\r\nConsumes a daily turn (DT): no<br><br>\r\n\r\n\r\n+| GENERAL |+-----------------------------------------------------------------<br>		\r\n\r\n?\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>see HELP</em><br>\r\n	\r\nABOUT\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nDisplays instructions and synopsis of the game<br>\r\n\r\nBULLETIN\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bulletin news (logins, change log, etc.)<br>\r\n\r\nHELP\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nThis help screen<br>\r\n								    \r\nLOGOUT\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nLog out of the game<br>\r\n\r\nSCORE\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nDisplays details of points earned/deducted<br>\r\n\r\nTERMS\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nDisplays Terms, Conditions, and Policies<br><br>\r\n\r\n\r\n+| GAMEPLAY |+----------------------------------------------------------------<br>		\r\n\r\n.\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nReorient yourself within the current sector<br>\r\n\r\nDROP\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nDrop an object from inventory<br>\r\n\r\nGET\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nRetrieve an object floating in the sector<br>\r\n\r\nGO\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nNavigate to a new sector<br>\r\n\r\nPROBE\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nInspect the details of a sector object<br>\r\n\r\nTORP\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nFire a mining torpedo at a sector object<br>\r\n\r\nXFER\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nTransfer fuel or torpedoes to another ship'),
(2, 'ABOUT', '+| How to Play |+--------------------------------------------------------------<br><br>\r\nSeries-V is a multi-player strategy game of space exploration.<br><br>\r\n\r\nWin the game by having the highest score among all players when time expires. Earn points by exploring space and mining asteroids, but beware that points are also deducted for mischief.<br><br>\r\n\r\nThe text-based user interface is inspired by 80s/90s computer bulletin board system (BBS) games. Players are encouraged to use pencil and paper to draft maps and to note the location of objects and obstacles.<br><br>\r\n\r\nDesigned with casual gamers in mind, the short-duration and daily turn counter encourages players to skip future rounds, but jump back in at a later date to explore a newly-configured universe.'),
(3, 'GO', 'The GO command navigates the player to a new sector.<br>\r\nConsumes a daily turn (DT):  yes<br><br>\r\n\r\nUsage examples:<br><br>\r\n\r\nGO [L, LEFT]\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Navigate left on the x-axis<br>\r\nGO [R, RIGHT]\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Navigate right on the x-axis<br>\r\nGO [U, UP]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Navigate up on the y-axis<br>\r\nGO [D, DOWN]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Navigate down on the y-axis<br>\r\nGO [F, FORWARD]\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Navigate forward on the z-axis<br>\r\nGO [B, BACK, BACKWARD]\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Navigate backward on the z-axis<br>\r\nGO [<em>object-name</em>]\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Approach (some) objects more closely'),
(6, 'R', ''),
(7, 'HELP_0', 'Available commands for non- logged in players:<br><br>\r\n							    			\r\n?\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n<em>see HELP</em><br>\r\n\r\nABOUT\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nDisplays a synopsis of the game<br>\r\n		\r\nENROLL\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nEnroll a new account to play the game<br>\r\n\r\nFORGOT\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nReset a forgotten password<br>\r\n\r\nHELP\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nDisplays this help screen<br>\r\n\r\nLOGIN\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nPrompts for credentials to log into the game<br>\r\n\r\nTERMS\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\nDisplays Terms, Conditions, and Policies\r\n'),
(8, '.', 'The . command reorients the player within the current sector.<br>\r\nConsumes a daily turn (DT): no<br><br>\r\n\r\nUsage examples:<br><br>\r\n\r\n.\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Displays key information:<br><br>\r\n\r\n[DT: ###]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Number of daily turns available to play today<br>\r\n[FUEL: ###%]&nbsp;&nbsp;&nbsp; Ship\'s fuel as a percentage of total capacity <br>\r\n[TORP: ###]&nbsp;&nbsp;&nbsp;&nbsp; Ship\'s count of remaining mining torpedoes<br>\r\n[CARGO: ###%]&nbsp;&nbsp; Ship\'s cargo as a percentage of total capacity<br>\r\n[SECTOR: #.#.#] Ship\'s position in universe using Cartesian coordinates'),
(9, 'LOGOUT', 'The LOGOUT command logs the user out of the game.  No turn is consumed by using this command.'),
(10, 'INTRO', '[GAMENAME]<br>\r\nEnter a command to continue:<br>\r\n		\r\nLOGIN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Log into game<br>\r\n	\r\nC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Create account to play game<br>\r\n							\r\nABOUT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Display information about game<br><br><br>'),
(11, '?', 'Type HELP [COMMAND-NAME] for more information on a specific command.<br>\r\nConsumes a daily turn (DT): no<br><br>\r\n\r\n'),
(12, 'PROBE', 'The PROBE command lists more detail about a sector object.<br>\r\nConsumes a daily turn (DT):  yes<br><br>\r\n\r\nUsage examples:<br><br>\r\n\r\nPROBE [ME]\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lists inventory of player\'s ship<br>\r\nPROBE [<em>object-name</em>]\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lists more detail about a sector object'),
(13, 'GET', 'The GET command retrieves an object floating in the sector and places it within inventory of the player\'s ship.<br>\r\nConsumes a daily turn (DT):  yes<br><br>\r\n\r\nUsage examples:<br><br>\r\n\r\nGET [<em>object-name</em>]\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieve object and place in inventory\r\n'),
(14, 'TORP', 'The TORP command fires a mining torpedo at a sector object.<br>\r\nConsumes a daily turn (DT):  yes<br><br>\r\n\r\nUsage examples:<br><br>\r\n\r\nTORP [<em>object-name</em>]\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fire a mining torpedo at a sector object'),
(15, 'DROP', 'The DROP command releases an object from inventory of the player\'s ship and places it floating in the sector.<br>\r\nConsumes a daily turn (DT):  yes<br><br>\r\n\r\nUsage examples:<br><br>\r\n\r\nDROP [<em>object-name</em>]\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Drop an object from inventory\r\n'),
(16, 'XFER', 'The XFER command transfers fuel or torpedoes to another ship in the current sector.<br>\r\nConsumes a daily turn (DT):  yes<br><br>\r\n\r\nUsage examples:<br><br>\r\n\r\nXFER [<em>ship-name</em>] [torpedo|fuel] [torpedo count|fuel percent]<br>\r\nXFER [<em>ship-name</em>] torpedo 5<br>\r\nXFER [<em>ship-name</em>] fuel 20'),
(17, 'SCORE', 'The SCORE command displays details of points earned or deducted. No turn is consumed by using this command.'),
(18, 'TERMS', '<p>Last Updated: 04-July-2022</p>\r\n\r\n<p>This game (“Game”) is published by Matt Robb, an individual residing in New Jersey, USA (“us”, “we”, “our”).</p>\r\n\r\n<p>There is no cost or payment required to the play the Game.\r\nBy continuing to use this website and/or playing the Game, you are confirming that you have read the Game Terms below and that you agree to be bound by them.</p>\r\n\r\n<p><b>1. Age limits</b></p>\r\n\r\n<p>The Game is intended for users aged 13 and over. If you are under 13 years of age, please do not play the Game. If you are under 18 we recommend that you read these terms with your parents to make sure that you understand them. By playing the Game, you are confirming that you are at least 13 years of age. We may terminate your ability to play the Game without warning if we have any reason to believe that you are under 13 years of age.</p>\r\n\r\n<p><b>2. Analytics and personal information (Privacy Policy)</b></p>\r\n\r\n<p>To use and play the Game you do not need to provide any personal information except for a valid email address that will be used for account verification, password resets, and periodic notifications of in-app actions and/or notification of the scheduling and start dates of future instances of the Game.</p>\r\n\r\n<p>To help monitor, analyze, and make future improvements, the Game contains analytics software that allows for the collection of statistical information about how the Game is used e.g. whether a particular task was completed, the number of times the Game has been accessed, geographic region from which the Game was accessed, and brand and version numbers of device’s web browser.</p>\r\n\r\n<p><b>3. Use of session variables, also known as browser cookies (Cookie Policy)</b></p>\r\n\r\n<p>Cookies are small text files that are downloaded to your device when you visit a website or application. Your web browser then sends these cookies back to the website or application on each subsequent visit so they can recognize you and remember things like personalized details or user preferences.</p>\r\n\r\n<p>This site utilizes session cookies, which only last for your online session and disappear from your device when you close your browser. They are used to remember “state” of your progress within the Game and to remember you between the time you issue commands.</p>\r\n\r\n<p>No persistent cookies are used for internal or external marketing or identification purposes, nor shared with other individuals or companies.</p>\r\n\r\n<p><b>4. Account</b></p>\r\n\r\n<p>You are required to create an account (“Account”) to access the Game and to use certain features and functions of the Game. Please note that regardless of any notice, we reserve the right to discontinue the Service or to terminate or suspend your Account at any time in our sole discretion, for any reason, or for no reason.</p>\r\n\r\n<p><b>5. Licensed rights</b></p>\r\n\r\n<p>The Game and all content included in the Game belongs to us and is protected by intellectual property laws around the world. You do not own the Game. The Game and any and all such content are licensed to you in accordance with these terms.\r\nAll intellectual property rights in and to the Game and any and all features, content, materials and information made available via the Game are owned by and shall remain owned by us at all times.</p>\r\n\r\n<p>We don\'t guarantee that the Game will always be available or will be updated. You understand that we may discontinue the Game or make changes to the Game at any time for any reason or no reason without notice or liability to you.</p>\r\n\r\n<p>You acknowledge that the game is provided “as is” and “as available”, and all warranties whether expressed or implied, including but not limited to warranties of satisfactory quality, fitness for purpose or non-infringement are excluded.</p>\r\n\r\n<p><b>6. Indemnification</b></p>\r\n\r\n<p>You hereby waive, release and discharge Us, its independent contractors, service providers and consultants, and their respective directors, employees, agents, partners, affiliates, and subsidiaries, harmless from and against any claims, damages, costs, liabilities and expenses (including, but not limited to, reasonable attorneys’ fees) arising out of or related to your use of the Game or this Website.</p>\r\n\r\n<p><b>7. Changes to Game terms</b></p>\r\n\r\n<p>Please note that we may change these Game Terms and/or any part thereof from time to time at our sole discretion. Any changes we make to these Game Terms will be applicable from the date they are published. You should review these Game Terms each time we make available an update to you to see whether they have been changed or updated.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `app_pointtype`
--

CREATE TABLE `app_pointtype` (
  `app_pointtype_id` int(11) NOT NULL,
  `name` varchar(8) NOT NULL,
  `point_type` varchar(50) NOT NULL,
  `activity` varchar(50) NOT NULL,
  `activity_point_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_pointtype`
--

INSERT INTO `app_pointtype` (`app_pointtype_id`, `name`, `point_type`, `activity`, `activity_point_value`) VALUES
(1, 'ESD', 'Exploration', 'Sectors discovered (1pt/sector)', 1),
(2, 'MAC', 'Mining', 'Asteroids cleared (1pt/asteroid)', 1),
(3, 'MCC', 'Mining', 'Clay composite (1pt/cubic meter)', 1),
(4, 'MSC', 'Mining', 'Silicate composite (1pt/cubic meter)', 1),
(5, 'MNIC', 'Mining', 'Nickel-Iron composite (1pt/cubic meter)', 1),
(6, 'MIC', 'Mining', 'Iridium composite (2pt/cubic meter)', 2),
(7, 'MPC', 'Mining', 'Palladium composite (2pt/cubic meter)', 2),
(8, 'MOC', 'Mining', 'Osmium composite (3pt/cubic meter)', 3),
(9, 'MRC', 'Mining', 'Ruthenium composite (3pt/cubic meter)', 3),
(10, 'MRHC', 'Mining', 'Rhodium composite (3pt/cubic meter)', 3),
(11, 'NTR', 'Notoriety', 'Torpedoes resupplied to ships (1pt/torpedo)', 1),
(12, 'NFR', 'Notoriety', 'Fuel-rods resupplied to ships (1pt/centimeter)', 1),
(13, 'NST', 'Notoriety', 'Ships torpedoed (-150pt/incident)', -150),
(14, 'NBT', 'Notoriety', 'Beacons torpedoed (-25pt/incident)', -25),
(15, 'WHD', 'Exploration', 'Wormholes discovered (150pt/wormhole)', 150),
(16, 'MFD', 'Exploration', 'Magnetic-Fields discovered (25pt/field)', 25);

-- --------------------------------------------------------

--
-- Table structure for table `app_ship_names`
--

CREATE TABLE `app_ship_names` (
  `ship_name` varchar(15) NOT NULL,
  `is_used` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_ship_names`
--

INSERT INTO `app_ship_names` (`ship_name`, `is_used`) VALUES
('Abandon', 0),
('Abduction', 0),
('Absence', 0),
('Absolution', 0),
('Abyss', 0),
('Acacia', 0),
('Acclaim', 0),
('Accord', 0),
('Accusation', 0),
('Ace', 0),
('Achiever', 0),
('Admirer', 0),
('Adore', 0),
('Adventure', 0),
('Adversary', 0),
('Advocate', 0),
('Affair', 0),
('Aficionado', 0),
('Aftermath', 0),
('Agenda', 0),
('Aggressor', 0),
('Agility', 0),
('Agitator', 0),
('Agony', 0),
('Airlock', 0),
('Alchemy', 0),
('Alderman', 0),
('Alibi', 0),
('Alienation', 0),
('Allegiance', 0),
('Allure', 0),
('Altercation', 0),
('Altitude', 0),
('Altruist', 0),
('Alumni', 0),
('Ambassador', 0),
('Ambiance', 0),
('Ambiguity', 0),
('Ambition', 0),
('Ambivalence', 0),
('Ambush', 0),
('Amnesty', 0),
('Amplitude', 0),
('Amulet', 0),
('Anaconda', 0),
('Analogue', 0),
('Anarchist', 0),
('Anarchy', 0),
('Ancestry', 0),
('Angel', 0),
('Anguish', 0),
('Animosity', 0),
('Annex', 0),
('Annihilate', 0),
('Annoyance', 0),
('Anode', 0),
('Antagonist', 0),
('Anthropology', 0),
('Antidote', 0),
('Antiquity', 0),
('Anxiety', 0),
('Apocalypse', 0),
('Apogee', 0),
('Apprentice', 0),
('Apricot', 0),
('Aquisition', 0),
('Arabesque', 0),
('Arbiter', 0),
('Arcade', 0),
('Archdiocese', 0),
('Arena', 0),
('Argon', 0),
('Argument', 0),
('Aristocracy', 0),
('Armadillo', 0),
('Armistice', 0),
('Arousal', 0),
('Arrival', 0),
('Arrogance', 0),
('Arrow', 0),
('Artisan', 0),
('Aspen', 0),
('Aspiration', 0),
('Assailant', 0),
('Assassin', 0),
('Assimilation', 0),
('Astronomer', 0),
('Asynchrony', 0),
('Atmosphere', 0),
('Atom', 0),
('Attraction', 0),
('Audacity', 0),
('Authenticator', 0),
('Autograph', 0),
('Autonomy', 0),
('Autopsy', 0),
('Autumn', 0),
('Avalanche', 0),
('Avenge', 0),
('Aversion', 0),
('Aviator', 0),
('Avoidance', 0),
('Awake', 0),
('Awaken', 0),
('Axiom', 0),
('Azalea', 0),
('Aztec', 0),
('Azure', 0),
('Babel', 0),
('Bachelor', 0),
('Backlash', 0),
('Bad', 0),
('Badge', 0),
('Baggage', 0),
('Bailiff', 0),
('Bait', 0),
('Balance', 0),
('Ballad', 0),
('Ballerina', 0),
('Bamboozle', 0),
('Bandwidth', 0),
('Banishment', 0),
('Banshee', 0),
('Barbarian', 0),
('Baritone', 0),
('Barnstormer', 0),
('Baron', 0),
('Barrage', 0),
('Barricade', 0),
('Barrow', 0),
('Battalion', 0),
('Battlefield', 0),
('Battlefront', 0),
('Battleground', 0),
('Bayonet', 0),
('Bazaar', 0),
('Beauty', 0),
('Bedeck', 0),
('Beggar', 0),
('Belfry', 0),
('Believe', 0),
('Believer', 0),
('Belligerence', 0),
('Benchmark', 0),
('Benediction', 0),
('Beneficiary', 0),
('Benevolence', 0),
('Bereavement', 0),
('Besiege', 0),
('Bestow', 1),
('Betrayal', 0),
('Betrayer', 0),
('Betrothal', 0),
('Beware', 0),
('Bewilder', 0),
('Bewitch', 0),
('Bias', 0),
('Bidder', 0),
('Bijou', 0),
('Billiard', 0),
('Biography', 0),
('Birch', 0),
('Birdie', 0),
('Birthright', 0),
('Biscuit', 0),
('Bishop', 0),
('Bison', 0),
('Bivouac', 0),
('Blackjack', 0),
('Blackmail', 0),
('Blackout', 0),
('Blade', 0),
('Blame', 0),
('Blasphemy', 1),
('Blaze', 0),
('Bleed', 0),
('Blemish', 0),
('Bless', 0),
('Blink', 0),
('Bliss', 0),
('Blockade', 0),
('Bloodlust', 0),
('Bloodshed', 1),
('Bloom', 0),
('Blossom', 0),
('Blowfish', 0),
('Bludgeon', 0),
('Bluebook', 0),
('Blueprint', 0),
('Bluff', 0),
('Blunder', 0),
('Blur', 0),
('Bluster', 0),
('Boa', 0),
('Boar', 0),
('Boatswain', 0),
('Bodyguard', 0),
('Bog', 0),
('Bogey', 0),
('Bogeymen', 0),
('Bohemoth', 0),
('Boil', 0),
('Boldness', 0),
('Bombardment', 0),
('Bomber', 0),
('Bonanza', 0),
('Bond', 0),
('Bonfire', 0),
('Bonnet', 0),
('Boo', 0),
('Booker', 0),
('Boom', 0),
('Boomerang', 0),
('Boost', 0),
('Bootlegger', 0),
('Bop', 0),
('Borderline', 0),
('Born', 0),
('Boss', 0),
('Bossman', 0),
('Bottleneck', 0),
('Boulder', 0),
('Boulevard', 0),
('Boundary', 0),
('Bounty', 0),
('Bouquet', 0),
('Bourbon', 0),
('Boycott', 0),
('Brainwash', 0),
('Brandy', 0),
('Brass', 0),
('Brave', 0),
('Bravery', 0),
('Brawl', 0),
('Brawn', 0),
('Breach', 0),
('Breakage', 0),
('Breakaway', 0),
('Breakdown', 0),
('Breaker', 0),
('Breakwater', 0),
('Breather', 0),
('Breeze', 0),
('Brethren', 0),
('Brevity', 0),
('Bribe', 0),
('Bride', 0),
('Bridegroom', 0),
('Bridesmaid', 0),
('Bridgehead', 0),
('Brigade', 0),
('Brigadier', 0),
('Brilliance', 0),
('Brilliant', 0),
('Broiler', 0),
('Broker', 0),
('Brotherhood', 0),
('Bruise', 0),
('Brute', 0),
('Bucaneer', 0),
('Buck', 0),
('Buckshot', 1),
('Bud', 0),
('Buff', 0),
('Buffalo', 0),
('Bulkhead', 0),
('Bull', 0),
('Buoyancy', 0),
('Burden', 0),
('Bureau', 0),
('Bureaucrat', 0),
('Burglar', 0),
('Burlesque', 0),
('Burnish', 0),
('Burst', 0),
('Bustle', 0),
('Butane', 0),
('Buzz', 0),
('Cabaret', 1),
('Cadaver', 0),
('Cadet', 0),
('Cafe', 0),
('Caliber', 0),
('Caliper', 0),
('Calm', 0),
('Calypso', 0),
('Campaign', 0),
('Campfire', 0),
('Candidate', 0),
('Cannonball', 0),
('Canyon', 0),
('Capitol', 0),
('Captain', 0),
('Caravan', 0),
('Carbide', 0),
('Cardinal', 0),
('Caress', 0),
('Caretaker', 0),
('Carnival', 0),
('Carpenter', 0),
('Carrier', 0),
('Cascade', 0),
('Cashmere', 0),
('Casino', 0),
('Castle', 0),
('Casualty', 0),
('Catalyst', 0),
('Catastrophe', 0),
('Cathedral', 0),
('Cathode', 0),
('Cattlemen', 0),
('Caution', 0),
('Cavalry', 0),
('Cave', 0),
('Cavern', 0),
('Cayenne', 0),
('Celebrant', 0),
('Celebrate', 0),
('Celestial', 0),
('Censor', 0),
('Ceo', 0),
('Certainty', 0),
('Certify', 0),
('Chairman', 0),
('Challenge', 0),
('Challenger', 0),
('Chamberlain', 0),
('Chambermaid', 0),
('Champagne', 0),
('Champion', 0),
('Chance', 0),
('Chancellor', 0),
('Chancery', 0),
('Chaperone', 0),
('Chaplain', 0),
('Chariot', 0),
('Charisma', 0),
('Charm', 0),
('Chase', 0),
('Chasm', 0),
('Cheat', 0),
('Checker', 0),
('Cheer', 0),
('Cheetah', 0),
('Chief', 0),
('Chieftain', 0),
('Chime', 0),
('Chirp', 0),
('Choice', 0),
('Choir', 0),
('Chosen', 0),
('Chrome', 0),
('Chronicle', 0),
('Churchmen', 0),
('Cinder', 0),
('Circuit', 0),
('Citation', 0),
('Civilian', 0),
('Civilization', 0),
('Claimant', 0),
('Clairvoyance', 0),
('Clan', 0),
('Classmate', 0),
('Clatter', 0),
('Claw', 0),
('Cleanse', 0),
('Cleave', 0),
('Clergyman', 0),
('Cleric', 0),
('Clerk', 0),
('Climax', 0),
('Clique', 0),
('Cloak', 0),
('Clockwork', 0),
('Clone', 0),
('Closure', 0),
('Cloudburst', 0),
('Clover', 0),
('Clown', 0),
('Coach', 0),
('Coachman', 0),
('Coalition', 0),
('Coast', 0),
('Cobalt', 0),
('Cobblestone', 0),
('Cobra', 1),
('Cod', 0),
('Coed', 0),
('Coffer', 0),
('Cognizance', 0),
('Coincidence', 0),
('Collaborator', 0),
('Collapse', 0),
('Collision', 0),
('Collusion', 0),
('Colonel', 0),
('Colony', 0),
('Colt', 0),
('Combatant', 0),
('Comedian', 0),
('Comic', 0),
('Commander', 0),
('Commence', 0),
('Commonwealth', 0),
('Commotion', 0),
('Community', 0),
('Companion', 0),
('Composer', 0),
('Composure', 0),
('Concealment', 0),
('Concede', 0),
('Conclusion', 0),
('Condemn', 0),
('Condolence', 0),
('Conductor', 0),
('Confederate', 0),
('Confession', 0),
('Confidant', 0),
('Confinement', 0),
('Conflict', 0),
('Conjure', 0),
('Connection', 0),
('Conquer', 0),
('Conqueror', 0),
('Consent', 0),
('Consequence', 0),
('Conspiracy', 0),
('Conspire', 0),
('Constraint', 0),
('Consulate', 0),
('Contact', 0),
('Contagion', 0),
('Contempt', 0),
('Contender', 0),
('Continuity', 0),
('Continuum', 0),
('Contradiction', 0),
('Contributor', 0),
('Controller', 0),
('Controversy', 1),
('Convert', 0),
('Convict', 0),
('Conviction', 0),
('Convoy', 0),
('Coo', 0),
('Coop', 0),
('Cope', 0),
('Core', 0),
('Cork', 0),
('Cornerstone', 0),
('Corona', 0),
('Corridor', 0),
('Corruption', 0),
('Council', 0),
('Counselor', 0),
('Counterfeit', 0),
('Countryman', 0),
('Coup', 0),
('Coupe', 0),
('Courage', 0),
('Courtship', 0),
('Covenant', 0),
('Cover', 0),
('Covet', 0),
('Cowhand', 0),
('Coyote', 0),
('Crackerjack', 0),
('Craftsman', 0),
('Crankshaft', 0),
('Craze', 0),
('Creation', 0),
('Creator', 0),
('Credibility', 0),
('Credit', 0),
('Credo', 0),
('Creed', 0),
('Creeper', 0),
('Crescendo', 0),
('Crescent', 0),
('Crest', 0),
('Crewmen', 0),
('Crimson', 0),
('Critic', 0),
('Critique', 0),
('Critter', 0),
('Crossover', 0),
('Crouch', 0),
('Crusader', 0),
('Crusher', 0),
('Crypt', 0),
('Culprit', 0),
('Curator', 1),
('Curse', 0),
('Cusp', 0),
('Custodian', 0),
('Custody', 0),
('Daffodil', 0),
('Damnation', 0),
('Damsel', 0),
('Darkness', 0),
('Darling', 0),
('Daughter', 0),
('Davenport', 0),
('Daybreak', 0),
('Daydream', 0),
('Daylight', 0),
('Deacon', 0),
('Deadlock', 0),
('Dearth', 0),
('Decade', 0),
('Decadence', 0),
('Deception', 0),
('Decimate', 0),
('Decision', 0),
('Defendant', 0),
('Deity', 0),
('Delinquent', 1),
('Delusion', 0),
('Demon', 0),
('Descendant', 0),
('Destiny', 0),
('Detective', 0),
('Deterrent', 0),
('Detractor', 0),
('Deviance', 0),
('Devotion', 1),
('Dictator', 0),
('Diety', 0),
('Dignity', 0),
('Dilemma', 0),
('Diligence', 0),
('Dimension', 0),
('Diplomat', 0),
('Disappearance', 0),
('Disbelief', 0),
('Disciple', 0),
('Disclosure', 0),
('Discovery', 0),
('Dishonesty', 0),
('Disillusion', 0),
('Disobedience', 0),
('Disparage', 0),
('Disturbance', 0),
('Diversion', 0),
('Divinity', 0),
('Dolphin', 0),
('Doomsday', 0),
('Doubloon', 0),
('Downfall', 0),
('Dowry', 0),
('Dragnet', 0),
('Dragon', 0),
('Drudgery', 0),
('Duke', 0),
('Dwarf', 0),
('Dynamite', 0),
('Dynamo', 0),
('Dynasty', 0),
('Eagle', 0),
('Eavesdrop', 0),
('Eclipse', 0),
('Elegance', 0),
('Element', 0),
('Embargo', 0),
('Embassy', 0),
('Embrace', 0),
('Emergence', 0),
('Empathy', 0),
('Emperor', 0),
('Empire', 0),
('Empower', 0),
('Enchantment', 0),
('Enchantress', 0),
('Endeavor', 0),
('Endure', 0),
('Entice', 0),
('Entrap', 0),
('Epic', 0),
('Epiphany', 0),
('Epitaph', 0),
('Equator', 0),
('Eruption', 0),
('Escalation', 0),
('Escapade', 0),
('Escape', 0),
('Espionage', 0),
('Eternal', 0),
('Eternity', 0),
('Euphoria', 0),
('Evasion', 0),
('Eve', 0),
('Examiner', 0),
('Excelsior', 0),
('Excursion', 0),
('Executor', 0),
('Exile', 0),
('Existence', 1),
('Expedition', 0),
('Exploit', 0),
('Extreme', 0),
('Exult', 0),
('Fable', 0),
('Facade', 0),
('Facet', 0),
('Faction', 0),
('Fairway', 0),
('Faithful', 0),
('Falcon', 0),
('Fallout', 0),
('Famine', 0),
('Fantasia', 0),
('Fantasy', 0),
('Farewell', 0),
('Fathom', 0),
('Feast', 0),
('Feather', 0),
('Fedora', 0),
('Fellow', 0),
('Felon', 0),
('Fern', 0),
('Fever', 0),
('Fiasco', 0),
('Fiction', 0),
('Figment', 0),
('Finalist', 0),
('Fireball', 0),
('Flame', 0),
('Flashback', 0),
('Flee', 0),
('Flirtation', 0),
('Flourish', 0),
('Fluidity', 0),
('Flurry', 0),
('Focus', 0),
('Folklore', 0),
('Footstep', 0),
('Forbear', 0),
('Forefather', 0),
('Foreigner', 1),
('Foreman', 0),
('Forerunner', 0),
('Foreshadow', 1),
('Forgery', 0),
('Fortnight', 0),
('Fortune', 0),
('Fracture', 0),
('Fraud', 0),
('Frenzy', 0),
('Freshman', 0),
('Friction', 0),
('Friendship', 0),
('Frighten', 0),
('Fringe', 1),
('Frolic', 0),
('Frontier', 0),
('Frostbite', 0),
('Fugitive', 0),
('Fury', 0),
('Fuse', 0),
('Gala', 0),
('Gallant', 0),
('Gallop', 0),
('Gambit', 0),
('Gangster', 0),
('Gardenia', 0),
('Gauntlet', 0),
('Gazelle', 0),
('Generalist', 0),
('Genesis', 0),
('Genie', 0),
('Getaway', 0),
('Ghost', 0),
('Gingham', 0),
('Glacier', 0),
('Gladiator', 0),
('Glimmer', 0),
('Glory', 0),
('Gnome', 0),
('Goodwill', 0),
('Governor', 0),
('Gratitude', 0),
('Gravity', 0),
('Grievance', 0),
('Guardhouse', 0),
('Guinea', 0),
('Guru', 0),
('Gusto', 0),
('Hailstorm', 0),
('Hairpin', 1),
('Hallmark', 0),
('Halo', 0),
('Hamlet', 0),
('Hammer', 0),
('Handmaiden', 0),
('Handshake', 0),
('Harbor', 0),
('Hardship', 0),
('Harlequin', 0),
('Harmony', 0),
('Harvest', 0),
('Hazard', 0),
('Headmaster', 0),
('Healer', 0),
('Hearsay', 0),
('Hearse', 0),
('Heaven', 0),
('Heiress', 0),
('Heist', 0),
('Helmsman', 0),
('Henchman', 0),
('Heroine', 0),
('Heyday', 0),
('Hideaway', 0),
('Hillbilly', 0),
('Hindsight', 0),
('Historian', 0),
('Hive', 0),
('Hoax', 0),
('Holiday', 0),
('Homeland', 0),
('Honesty', 0),
('Honeycomb', 0),
('Honeysuckle', 0),
('Honor', 0),
('Hoodlum', 0),
('Hoodwink', 0),
('Horseman', 0),
('Hostage', 0),
('Hound', 0),
('Hulk', 0),
('Hunger', 0),
('Hunter', 0),
('Hurricane', 0),
('Hustler', 0),
('Hyena', 0),
('Ibex', 0),
('Icecap', 0),
('Icon', 0),
('Idiom', 0),
('Idol', 0),
('Ignite', 0),
('Iguana', 0),
('Illusion', 0),
('Imagine', 0),
('Immersion', 0),
('Immigrant', 0),
('Immunity', 0),
('Imperil', 0),
('Inertia', 0),
('Infatuate', 0),
('Inferno', 0),
('Inhibition', 0),
('Inmate', 0),
('Insect', 0),
('Insistence', 0),
('Inspector', 0),
('Inspire', 0),
('Instigator', 0),
('Integrity', 0),
('Intention', 0),
('Intercept', 0),
('Intoxicate', 0),
('Intrigue', 0),
('Introvert', 0),
('Intrusion', 0),
('Intuition', 0),
('Irony', 0),
('Isolation', 0),
('Ivory', 0),
('Jackal', 0),
('Jackrabbit', 0),
('Jasper', 0),
('Javelin', 0),
('Jaywalker', 0),
('Jealousy', 0),
('Jester', 0),
('Jigsaw', 0),
('Jinx', 0),
('Jitterbug', 0),
('Jolly', 0),
('Journey', 0),
('Jubilee', 0),
('Judgement', 0),
('Juggernaut', 0),
('Juke', 0),
('Juniper', 0),
('Juror', 0),
('Justify', 0),
('Kahuna', 0),
('Karma', 0),
('Keelhaul', 0),
('Keeper', 0),
('Keepsake', 0),
('Kenya', 0),
('Kernel', 0),
('Keyhole', 0),
('Keystone', 0),
('Kickstart', 0),
('Kilt', 0),
('Kindle', 0),
('Kindness', 0),
('Kingdom', 0),
('Kiss', 0),
('Kitten', 0),
('Knife', 0),
('Knowledge', 0),
('Labyrinth', 0),
('Lace', 0),
('Lady', 0),
('Lake', 0),
('Lament', 0),
('Lance', 0),
('Lantern', 0),
('Larceny', 0),
('Lasso', 0),
('Laughter', 0),
('Laurel', 0),
('Lawman', 0),
('Leadership', 0),
('Legacy', 0),
('Legend', 0),
('Legion', 0),
('Leverage', 0),
('Liaison', 0),
('Libel', 0),
('Liberty', 0),
('Librarian', 0),
('Libretto', 0),
('Loathe', 0),
('Locust', 0),
('Longhorn', 0),
('Longshot', 0),
('Lookout', 0),
('Loon', 0),
('Loophole', 0),
('Lowball', 0),
('Loyalty', 0),
('Machinist', 0),
('Mackinaw', 0),
('Madam', 0),
('Madhouse', 0),
('Madrigal', 1),
('Maelstrom', 0),
('Maestro', 0),
('Magician', 0),
('Magistrate', 0),
('Magnolia', 0),
('Maiden', 0),
('Majesty', 0),
('Major', 0),
('Malevolence', 0),
('Malice', 0),
('Mandate', 0),
('Maniac', 0),
('Manifest', 0),
('Mankind', 0),
('Manuscript', 0),
('Marathon', 0),
('Mariner', 0),
('Marksman', 0),
('Martini', 0),
('Martyr', 0),
('Marvel', 0),
('Mastermind', 0),
('Masterpiece', 0),
('Matchmaker', 0),
('Matrix', 0),
('Maxim', 0),
('Mayhem', 0),
('Maze', 0),
('Meadow', 0),
('Medley', 0),
('Melee', 0),
('Melody', 0),
('Memento', 0),
('Memory', 0),
('Menace', 0),
('Mentor', 0),
('Merchant', 0),
('Mercy', 0),
('Mermaid', 0),
('Messenger', 0),
('Metaphor', 0),
('Midnight', 0),
('Midpoint', 0),
('Mime', 0),
('Mimic', 0),
('Ministry', 0),
('Minor', 0),
('Minstrel', 0),
('Misfortune', 0),
('Mist', 0),
('Mistletoe', 0),
('Moment', 0),
('Monacle', 0),
('Monarch', 0),
('Monitor', 0),
('Moonlight', 0),
('Morale', 0),
('Mortality', 0),
('Mosaic', 0),
('Mosquito', 0),
('Moth', 0),
('Motif', 0),
('Motion', 0),
('Motive', 0),
('Motto', 1),
('Mouse', 0),
('Musician', 0),
('Musk', 0),
('Muster', 0),
('Mystery', 0),
('Mystic', 0),
('Myth', 1),
('Namedrop', 0),
('Namesake', 0),
('Nanny', 0),
('Narrator', 0),
('Nash', 0),
('Nation', 0),
('Nature', 0),
('Navigator', 0),
('Nectar', 0),
('Nemesis', 0),
('Neon', 0),
('Nephew', 0),
('Neuron', 0),
('Newborn', 0),
('Newsboy', 0),
('Niece', 0),
('Nightfall', 0),
('Nightingale', 0),
('Ninja', 0),
('Nobleman', 0),
('Nomad', 0),
('Nominee', 0),
('Noose', 0),
('Normalcy', 0),
('Northerner', 0),
('Nostalgia', 0),
('Novelist', 0),
('Novelty', 0),
('Nuance', 0),
('Numb', 0),
('Nurture', 0),
('Nutmeg', 0),
('Nymph', 0),
('Oak', 0),
('Oasis', 0),
('Oath', 0),
('Obedience', 0),
('Obelisk', 0),
('Oblivion', 0),
('Observer', 0),
('Obsession', 0),
('Occasion', 0),
('Occult', 0),
('Occupant', 0),
('Ocean', 0),
('Ocelot', 0),
('Octopus', 0),
('Odyssey', 0),
('Offender', 0),
('Offshoot', 0),
('Offspring', 0),
('Ogre', 0),
('Olympian', 0),
('Omission', 0),
('Onset', 0),
('Opera', 0),
('Opportunity', 0),
('Oppression', 0),
('Optimist', 0),
('Oracle', 0),
('Orator', 0),
('Orchard', 0),
('Ordinance', 0),
('Orient', 0),
('Ornament', 0),
('Orphan', 0),
('Ostrich', 0),
('Otter', 0),
('Outback', 0),
('Outbreak', 0),
('Outcast', 0),
('Outcry', 0),
('Outlaw', 0),
('Outlook', 0),
('Outreach', 0),
('Outsider', 0),
('Outsmart', 0),
('Ovation', 0),
('Overcast', 0),
('Overcome', 0),
('Overhaul', 0),
('Overjoy', 0),
('Overreach', 0),
('Overseer', 0),
('Owl', 0),
('Oxcart', 0),
('Oyster', 0),
('Pace', 0),
('Pacifier', 0),
('Packet', 0),
('Padlock', 0),
('Pagan', 0),
('Pageant', 0),
('Painter', 0),
('Palace', 0),
('Palette', 0),
('Palladium', 0),
('Palm', 0),
('Pamphlet', 1),
('Panic', 0),
('Parade', 0),
('Paradise', 0),
('Paradox', 0),
('Pardon', 0),
('Pariah', 0),
('Parlor', 0),
('Passion', 1),
('Pastor', 0),
('Pathfinder', 0),
('Patient', 0),
('Patriarch', 0),
('Patriot', 0),
('Pawn', 1),
('Payday', 0),
('Pearl', 0),
('Peddler', 0),
('Pendulum', 0),
('Peril', 0),
('Perjury', 0),
('Persistence', 0),
('Persona', 0),
('Petition', 1),
('Phantom', 0),
('Pheasant', 0),
('Physique', 0),
('Pigeon', 0),
('Pinto', 0),
('Pioneer', 0),
('Pistol', 0),
('Pitfall', 0),
('Plaintiff', 0),
('Plantation', 0),
('Plasma', 0),
('Playwright', 0),
('Plume', 0),
('Poet', 0),
('Poison', 0),
('Ponder', 0),
('Pope', 0),
('Portrayal', 0),
('Postcard', 0),
('Postmark', 0),
('Power', 0),
('Prayer', 0),
('Preacher', 0),
('Precision', 0),
('Prevail', 0),
('Pride', 0),
('Priest', 0),
('Princess', 0),
('Proclaim', 0),
('Prodigy', 0),
('Promoter', 0),
('Prophecy', 0),
('Protector', 0),
('Proverb', 0),
('Prowl', 1),
('Prudence', 0),
('Pulse', 0),
('Pursue', 0),
('Quake', 0),
('Quantum', 0),
('Queen', 0),
('Quibble', 0),
('Quicksand', 0),
('Quirk', 0),
('Quorum', 0),
('Racketeer', 0),
('Radiance', 0),
('Rage', 0),
('Rainbow', 0),
('Rainfall', 0),
('Rainstorm', 0),
('Ramble', 0),
('Rampage', 0),
('Ransack', 0),
('Ransom', 0),
('Ravage', 0),
('Rebel', 0),
('Reform', 0),
('Relic', 0),
('Renegade', 0),
('Revelry', 0),
('Reverence', 0),
('Revolt', 0),
('Rhapsody', 0),
('Riot', 0),
('Ripple', 0),
('Romantic', 0),
('Ruin', 0),
('Rumor', 0),
('Rush', 0),
('Saber', 0),
('Sable', 0),
('Sacrifice', 0),
('Safari', 0),
('Saffron', 0),
('Sage', 0),
('Sailor', 0),
('Saint', 0),
('Salute', 0),
('Salvation', 0),
('Sanction', 0),
('Sandstorm', 0),
('Sanity', 0),
('Satire', 0),
('Savior', 0),
('Scandal', 0),
('Scarlet', 0),
('Schoolboy', 0),
('Scoundrel', 0),
('Scuffle', 0),
('Seclusion', 0),
('Secret', 0),
('Senora', 0),
('Sequel', 0),
('Serendipity', 0),
('Serenity', 0),
('Serpent', 0),
('Servant', 0),
('Setback', 0),
('Shade', 0),
('Shadow', 0),
('Shamrock', 0),
('Shanty', 0),
('Sheath', 0),
('Shelter', 0),
('Shepherd', 0),
('Sheriff', 0),
('Showpiece', 0),
('Shriek', 0),
('Shrine', 0),
('Silence', 0),
('Silhouette', 0),
('Silo', 0),
('Siren', 0),
('Skepticism', 0),
('Skirmish', 0),
('Skylark', 0),
('Slingshot', 0),
('Snowstorm', 0),
('Soloist', 0),
('Sonata', 0),
('Soulmate', 0),
('Souvenir', 0),
('Spasm', 0),
('Specimen', 0),
('Spectacle', 0),
('Spectator', 0),
('Splendor', 0),
('Spoil', 0),
('Sportsman', 0),
('Squadron', 0),
('Squirrel', 0),
('Stalemate', 0),
('Stallion', 0),
('Stamina', 0),
('Stampede', 0),
('Stigma', 0),
('Stiletto', 0),
('Storyteller', 0),
('Streak', 0),
('Successor', 0),
('Superstition', 0),
('Surrender', 0),
('Survivor', 0),
('Suspense', 0),
('Swoop', 0),
('Sword', 0),
('Symbol', 0),
('Taboo', 0),
('Tactic', 0),
('Taffy', 0),
('Tailor', 0),
('Tallyho', 0),
('Tamale', 0),
('Tamper', 0),
('Tandem', 0),
('Tango', 0),
('Tantrum', 0),
('Tarpon', 0),
('Tattoo', 0),
('Taunt', 0),
('Teardrop', 0),
('Tempest', 0),
('Temple', 0),
('Tempo', 0),
('Tenor', 0),
('Tension', 0),
('Tentacle', 0),
('Terrier', 0),
('Testament', 0),
('Theory', 0),
('Therapy', 0),
('Thief', 0),
('Thinker', 0),
('Thirst', 0),
('Thrash', 0),
('Tick', 0),
('Tidewater', 0),
('Tinder', 1),
('Toboggan', 0),
('Tombstone', 0),
('Torch', 0),
('Torrent', 0),
('Tortoise', 0),
('Tradition', 0),
('Tragedy', 0),
('Trailblazer', 0),
('Tranquility', 1),
('Transcend', 0),
('Transform', 0),
('Traveler', 0),
('Treason', 0),
('Trek', 0),
('Tremor', 0),
('Trespass', 0),
('Tribe', 0),
('Trilogy', 0),
('Trinket', 0),
('Triumph', 0),
('Trophy', 0),
('Trouble', 0),
('Truce', 0),
('Turmoil', 0),
('Tutor', 0),
('Tycoon', 0),
('Tyranny', 0),
('Ultimatum', 0),
('Underscore', 0),
('Underworld', 0),
('Unearth', 0),
('Unfortunate', 0),
('Unity', 0),
('Upheaval', 0),
('Uphold', 0),
('Utopia', 0),
('Vagabond', 0),
('Valet', 0),
('Valiant', 0),
('Valor', 0),
('Vanquish', 0),
('Vapor', 0),
('Velocity', 0),
('Vengeance', 0),
('Verge', 0),
('Vibrato', 0),
('Victim', 0),
('Victory', 0),
('Vigor', 0),
('Villain', 0),
('Vintage', 0),
('Virtue', 0),
('Vista', 0),
('Voodoo', 0),
('Vortex', 0),
('Voyager', 0),
('Wage', 0),
('Waken', 0),
('Walker', 0),
('Wander', 0),
('Warp', 0),
('Wasp', 0),
('Watchmen', 0),
('Waterfall', 0),
('Weasel', 0),
('Whiplash', 0),
('Wicket', 0),
('Wisp', 0),
('Witness', 0),
('Wizard', 0),
('Wolf', 0),
('Wonder', 0),
('Wordsmith', 0),
('Worship', 0),
('Wrath', 0),
('Yachtman', 0),
('Yankee', 0),
('Yardstick', 0),
('Yearn', 0),
('Yoga', 0),
('Zodiac', 0);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` bigint(20) NOT NULL,
  `item_type_id` int(11) NOT NULL,
  `proper_name` varchar(15) DEFAULT NULL,
  `parent_item_id` bigint(20) DEFAULT NULL,
  `sector_id` int(11) DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_type_id`, `proper_name`, `parent_item_id`, `sector_id`, `is_visible`) VALUES
(1, 1, 'Station-14', NULL, 1, 1),
(2, 2, 'Curator', NULL, 1, 0),
(3, 2, 'Pamphlet', NULL, 1, 0),
(4, 2, 'Tinder', NULL, 1, 0),
(5, 2, 'Bestow', NULL, 1, 0),
(6, 2, 'Fringe', NULL, 1, 0),
(7, 2, 'Passion', NULL, 1, 0),
(8, 2, 'Cobra', NULL, 1, 0),
(9, 2, 'Delinquent', NULL, 1, 0),
(10, 2, 'Foreigner', NULL, 1, 0),
(11, 2, 'Bloodshed', NULL, 1, 0),
(12, 2, 'Controversy', NULL, 1, 0),
(13, 2, 'Cabaret', NULL, 1, 0),
(14, 2, 'Devotion', NULL, 1, 0),
(15, 2, 'Existence', NULL, 1, 0),
(16, 2, 'Pawn', NULL, 1, 0),
(17, 2, 'Foreshadow', NULL, 1, 0),
(18, 2, 'Madrigal', NULL, 1, 0),
(19, 2, 'Petition', NULL, 1, 0),
(20, 2, 'Tranquility', NULL, 1, 0),
(21, 2, 'Motto', NULL, 1, 0),
(22, 2, 'Prowl', NULL, 1, 0),
(23, 2, 'Blasphemy', NULL, 1, 0),
(24, 2, 'Hairpin', NULL, 1, 0),
(25, 2, 'Myth', NULL, 1, 0),
(26, 2, 'Buckshot', NULL, 1, 0),
(27, 16, NULL, 2, NULL, 1),
(28, 16, NULL, 2, NULL, 1),
(29, 16, NULL, 2, NULL, 1),
(30, 16, NULL, 2, NULL, 1),
(31, 16, NULL, 2, NULL, 1),
(32, 16, NULL, 2, NULL, 1),
(33, 16, NULL, 2, NULL, 1),
(34, 16, NULL, 2, NULL, 1),
(35, 16, NULL, 2, NULL, 1),
(36, 16, NULL, 2, NULL, 1),
(37, 16, NULL, 2, NULL, 1),
(38, 16, NULL, 2, NULL, 1),
(39, 16, NULL, 2, NULL, 1),
(40, 16, NULL, 2, NULL, 1),
(41, 16, NULL, 2, NULL, 1),
(42, 16, NULL, 2, NULL, 1),
(43, 16, NULL, 2, NULL, 1),
(44, 16, NULL, 2, NULL, 1),
(45, 16, NULL, 2, NULL, 1),
(46, 16, NULL, 2, NULL, 1),
(47, 16, NULL, 2, NULL, 1),
(48, 16, NULL, 2, NULL, 1),
(49, 16, NULL, 2, NULL, 1),
(50, 16, NULL, 2, NULL, 1),
(51, 16, NULL, 2, NULL, 1),
(52, 16, NULL, 2, NULL, 1),
(53, 16, NULL, 2, NULL, 1),
(54, 16, NULL, 2, NULL, 1),
(55, 16, NULL, 2, NULL, 1),
(56, 16, NULL, 2, NULL, 1),
(57, 16, NULL, 2, NULL, 1),
(58, 16, NULL, 2, NULL, 1),
(59, 16, NULL, 2, NULL, 1),
(60, 16, NULL, 2, NULL, 1),
(61, 16, NULL, 2, NULL, 1),
(62, 16, NULL, 2, NULL, 1),
(63, 16, NULL, 2, NULL, 1),
(64, 16, NULL, 2, NULL, 1),
(65, 16, NULL, 2, NULL, 1),
(66, 16, NULL, 2, NULL, 1),
(67, 17, NULL, 2, NULL, 1),
(68, 17, NULL, 2, NULL, 1),
(69, 17, NULL, 2, NULL, 1),
(70, 17, NULL, 2, NULL, 1),
(71, 17, NULL, 2, NULL, 1),
(72, 16, NULL, 3, NULL, 1),
(73, 16, NULL, 3, NULL, 1),
(74, 16, NULL, 3, NULL, 1),
(75, 16, NULL, 3, NULL, 1),
(76, 16, NULL, 3, NULL, 1),
(77, 16, NULL, 3, NULL, 1),
(78, 16, NULL, 3, NULL, 1),
(79, 16, NULL, 3, NULL, 1),
(80, 16, NULL, 3, NULL, 1),
(81, 16, NULL, 3, NULL, 1),
(82, 16, NULL, 3, NULL, 1),
(83, 16, NULL, 3, NULL, 1),
(84, 16, NULL, 3, NULL, 1),
(85, 16, NULL, 3, NULL, 1),
(86, 16, NULL, 3, NULL, 1),
(87, 16, NULL, 3, NULL, 1),
(88, 16, NULL, 3, NULL, 1),
(89, 16, NULL, 3, NULL, 1),
(90, 16, NULL, 3, NULL, 1),
(91, 16, NULL, 3, NULL, 1),
(92, 16, NULL, 3, NULL, 1),
(93, 16, NULL, 3, NULL, 1),
(94, 16, NULL, 3, NULL, 1),
(95, 16, NULL, 3, NULL, 1),
(96, 16, NULL, 3, NULL, 1),
(97, 16, NULL, 3, NULL, 1),
(98, 16, NULL, 3, NULL, 1),
(99, 16, NULL, 3, NULL, 1),
(100, 16, NULL, 3, NULL, 1),
(101, 16, NULL, 3, NULL, 1),
(102, 16, NULL, 3, NULL, 1),
(103, 16, NULL, 3, NULL, 1),
(104, 16, NULL, 3, NULL, 1),
(105, 16, NULL, 3, NULL, 1),
(106, 16, NULL, 3, NULL, 1),
(107, 16, NULL, 3, NULL, 1),
(108, 16, NULL, 3, NULL, 1),
(109, 16, NULL, 3, NULL, 1),
(110, 16, NULL, 3, NULL, 1),
(111, 16, NULL, 3, NULL, 1),
(112, 17, NULL, 3, NULL, 1),
(113, 17, NULL, 3, NULL, 1),
(114, 17, NULL, 3, NULL, 1),
(115, 17, NULL, 3, NULL, 1),
(116, 17, NULL, 3, NULL, 1),
(117, 16, NULL, 4, NULL, 1),
(118, 16, NULL, 4, NULL, 1),
(119, 16, NULL, 4, NULL, 1),
(120, 16, NULL, 4, NULL, 1),
(121, 16, NULL, 4, NULL, 1),
(122, 16, NULL, 4, NULL, 1),
(123, 16, NULL, 4, NULL, 1),
(124, 16, NULL, 4, NULL, 1),
(125, 16, NULL, 4, NULL, 1),
(126, 16, NULL, 4, NULL, 1),
(127, 16, NULL, 4, NULL, 1),
(128, 16, NULL, 4, NULL, 1),
(129, 16, NULL, 4, NULL, 1),
(130, 16, NULL, 4, NULL, 1),
(131, 16, NULL, 4, NULL, 1),
(132, 16, NULL, 4, NULL, 1),
(133, 16, NULL, 4, NULL, 1),
(134, 16, NULL, 4, NULL, 1),
(135, 16, NULL, 4, NULL, 1),
(136, 16, NULL, 4, NULL, 1),
(137, 16, NULL, 4, NULL, 1),
(138, 16, NULL, 4, NULL, 1),
(139, 16, NULL, 4, NULL, 1),
(140, 16, NULL, 4, NULL, 1),
(141, 16, NULL, 4, NULL, 1),
(142, 16, NULL, 4, NULL, 1),
(143, 16, NULL, 4, NULL, 1),
(144, 16, NULL, 4, NULL, 1),
(145, 16, NULL, 4, NULL, 1),
(146, 16, NULL, 4, NULL, 1),
(147, 16, NULL, 4, NULL, 1),
(148, 16, NULL, 4, NULL, 1),
(149, 16, NULL, 4, NULL, 1),
(150, 16, NULL, 4, NULL, 1),
(151, 16, NULL, 4, NULL, 1),
(152, 16, NULL, 4, NULL, 1),
(153, 16, NULL, 4, NULL, 1),
(154, 16, NULL, 4, NULL, 1),
(155, 16, NULL, 4, NULL, 1),
(156, 16, NULL, 4, NULL, 1),
(157, 17, NULL, 4, NULL, 1),
(158, 17, NULL, 4, NULL, 1),
(159, 17, NULL, 4, NULL, 1),
(160, 17, NULL, 4, NULL, 1),
(161, 17, NULL, 4, NULL, 1),
(162, 16, NULL, 5, NULL, 1),
(163, 16, NULL, 5, NULL, 1),
(164, 16, NULL, 5, NULL, 1),
(165, 16, NULL, 5, NULL, 1),
(166, 16, NULL, 5, NULL, 1),
(167, 16, NULL, 5, NULL, 1),
(168, 16, NULL, 5, NULL, 1),
(169, 16, NULL, 5, NULL, 1),
(170, 16, NULL, 5, NULL, 1),
(171, 16, NULL, 5, NULL, 1),
(172, 16, NULL, 5, NULL, 1),
(173, 16, NULL, 5, NULL, 1),
(174, 16, NULL, 5, NULL, 1),
(175, 16, NULL, 5, NULL, 1),
(176, 16, NULL, 5, NULL, 1),
(177, 16, NULL, 5, NULL, 1),
(178, 16, NULL, 5, NULL, 1),
(179, 16, NULL, 5, NULL, 1),
(180, 16, NULL, 5, NULL, 1),
(181, 16, NULL, 5, NULL, 1),
(182, 16, NULL, 5, NULL, 1),
(183, 16, NULL, 5, NULL, 1),
(184, 16, NULL, 5, NULL, 1),
(185, 16, NULL, 5, NULL, 1),
(186, 16, NULL, 5, NULL, 1),
(187, 16, NULL, 5, NULL, 1),
(188, 16, NULL, 5, NULL, 1),
(189, 16, NULL, 5, NULL, 1),
(190, 16, NULL, 5, NULL, 1),
(191, 16, NULL, 5, NULL, 1),
(192, 16, NULL, 5, NULL, 1),
(193, 16, NULL, 5, NULL, 1),
(194, 16, NULL, 5, NULL, 1),
(195, 16, NULL, 5, NULL, 1),
(196, 16, NULL, 5, NULL, 1),
(197, 16, NULL, 5, NULL, 1),
(198, 16, NULL, 5, NULL, 1),
(199, 16, NULL, 5, NULL, 1),
(200, 16, NULL, 5, NULL, 1),
(201, 16, NULL, 5, NULL, 1),
(202, 17, NULL, 5, NULL, 1),
(203, 17, NULL, 5, NULL, 1),
(204, 17, NULL, 5, NULL, 1),
(205, 17, NULL, 5, NULL, 1),
(206, 17, NULL, 5, NULL, 1),
(207, 16, NULL, 6, NULL, 1),
(208, 16, NULL, 6, NULL, 1),
(209, 16, NULL, 6, NULL, 1),
(210, 16, NULL, 6, NULL, 1),
(211, 16, NULL, 6, NULL, 1),
(212, 16, NULL, 6, NULL, 1),
(213, 16, NULL, 6, NULL, 1),
(214, 16, NULL, 6, NULL, 1),
(215, 16, NULL, 6, NULL, 1),
(216, 16, NULL, 6, NULL, 1),
(217, 16, NULL, 6, NULL, 1),
(218, 16, NULL, 6, NULL, 1),
(219, 16, NULL, 6, NULL, 1),
(220, 16, NULL, 6, NULL, 1),
(221, 16, NULL, 6, NULL, 1),
(222, 16, NULL, 6, NULL, 1),
(223, 16, NULL, 6, NULL, 1),
(224, 16, NULL, 6, NULL, 1),
(225, 16, NULL, 6, NULL, 1),
(226, 16, NULL, 6, NULL, 1),
(227, 16, NULL, 6, NULL, 1),
(228, 16, NULL, 6, NULL, 1),
(229, 16, NULL, 6, NULL, 1),
(230, 16, NULL, 6, NULL, 1),
(231, 16, NULL, 6, NULL, 1),
(232, 16, NULL, 6, NULL, 1),
(233, 16, NULL, 6, NULL, 1),
(234, 16, NULL, 6, NULL, 1),
(235, 16, NULL, 6, NULL, 1),
(236, 16, NULL, 6, NULL, 1),
(237, 16, NULL, 6, NULL, 1),
(238, 16, NULL, 6, NULL, 1),
(239, 16, NULL, 6, NULL, 1),
(240, 16, NULL, 6, NULL, 1),
(241, 16, NULL, 6, NULL, 1),
(242, 16, NULL, 6, NULL, 1),
(243, 16, NULL, 6, NULL, 1),
(244, 16, NULL, 6, NULL, 1),
(245, 16, NULL, 6, NULL, 1),
(246, 16, NULL, 6, NULL, 1),
(247, 17, NULL, 6, NULL, 1),
(248, 17, NULL, 6, NULL, 1),
(249, 17, NULL, 6, NULL, 1),
(250, 17, NULL, 6, NULL, 1),
(251, 17, NULL, 6, NULL, 1),
(252, 16, NULL, 7, NULL, 1),
(253, 16, NULL, 7, NULL, 1),
(254, 16, NULL, 7, NULL, 1),
(255, 16, NULL, 7, NULL, 1),
(256, 16, NULL, 7, NULL, 1),
(257, 16, NULL, 7, NULL, 1),
(258, 16, NULL, 7, NULL, 1),
(259, 16, NULL, 7, NULL, 1),
(260, 16, NULL, 7, NULL, 1),
(261, 16, NULL, 7, NULL, 1),
(262, 16, NULL, 7, NULL, 1),
(263, 16, NULL, 7, NULL, 1),
(264, 16, NULL, 7, NULL, 1),
(265, 16, NULL, 7, NULL, 1),
(266, 16, NULL, 7, NULL, 1),
(267, 16, NULL, 7, NULL, 1),
(268, 16, NULL, 7, NULL, 1),
(269, 16, NULL, 7, NULL, 1),
(270, 16, NULL, 7, NULL, 1),
(271, 16, NULL, 7, NULL, 1),
(272, 16, NULL, 7, NULL, 1),
(273, 16, NULL, 7, NULL, 1),
(274, 16, NULL, 7, NULL, 1),
(275, 16, NULL, 7, NULL, 1),
(276, 16, NULL, 7, NULL, 1),
(277, 16, NULL, 7, NULL, 1),
(278, 16, NULL, 7, NULL, 1),
(279, 16, NULL, 7, NULL, 1),
(280, 16, NULL, 7, NULL, 1),
(281, 16, NULL, 7, NULL, 1),
(282, 16, NULL, 7, NULL, 1),
(283, 16, NULL, 7, NULL, 1),
(284, 16, NULL, 7, NULL, 1),
(285, 16, NULL, 7, NULL, 1),
(286, 16, NULL, 7, NULL, 1),
(287, 16, NULL, 7, NULL, 1),
(288, 16, NULL, 7, NULL, 1),
(289, 16, NULL, 7, NULL, 1),
(290, 16, NULL, 7, NULL, 1),
(291, 16, NULL, 7, NULL, 1),
(292, 17, NULL, 7, NULL, 1),
(293, 17, NULL, 7, NULL, 1),
(294, 17, NULL, 7, NULL, 1),
(295, 17, NULL, 7, NULL, 1),
(296, 17, NULL, 7, NULL, 1),
(297, 16, NULL, 8, NULL, 1),
(298, 16, NULL, 8, NULL, 1),
(299, 16, NULL, 8, NULL, 1),
(300, 16, NULL, 8, NULL, 1),
(301, 16, NULL, 8, NULL, 1),
(302, 16, NULL, 8, NULL, 1),
(303, 16, NULL, 8, NULL, 1),
(304, 16, NULL, 8, NULL, 1),
(305, 16, NULL, 8, NULL, 1),
(306, 16, NULL, 8, NULL, 1),
(307, 16, NULL, 8, NULL, 1),
(308, 16, NULL, 8, NULL, 1),
(309, 16, NULL, 8, NULL, 1),
(310, 16, NULL, 8, NULL, 1),
(311, 16, NULL, 8, NULL, 1),
(312, 16, NULL, 8, NULL, 1),
(313, 16, NULL, 8, NULL, 1),
(314, 16, NULL, 8, NULL, 1),
(315, 16, NULL, 8, NULL, 1),
(316, 16, NULL, 8, NULL, 1),
(317, 16, NULL, 8, NULL, 1),
(318, 16, NULL, 8, NULL, 1),
(319, 16, NULL, 8, NULL, 1),
(320, 16, NULL, 8, NULL, 1),
(321, 16, NULL, 8, NULL, 1),
(322, 16, NULL, 8, NULL, 1),
(323, 16, NULL, 8, NULL, 1),
(324, 16, NULL, 8, NULL, 1),
(325, 16, NULL, 8, NULL, 1),
(326, 16, NULL, 8, NULL, 1),
(327, 16, NULL, 8, NULL, 1),
(328, 16, NULL, 8, NULL, 1),
(329, 16, NULL, 8, NULL, 1),
(330, 16, NULL, 8, NULL, 1),
(331, 16, NULL, 8, NULL, 1),
(332, 16, NULL, 8, NULL, 1),
(333, 16, NULL, 8, NULL, 1),
(334, 16, NULL, 8, NULL, 1),
(335, 16, NULL, 8, NULL, 1),
(336, 16, NULL, 8, NULL, 1),
(337, 17, NULL, 8, NULL, 1),
(338, 17, NULL, 8, NULL, 1),
(339, 17, NULL, 8, NULL, 1),
(340, 17, NULL, 8, NULL, 1),
(341, 17, NULL, 8, NULL, 1),
(342, 16, NULL, 9, NULL, 1),
(343, 16, NULL, 9, NULL, 1),
(344, 16, NULL, 9, NULL, 1),
(345, 16, NULL, 9, NULL, 1),
(346, 16, NULL, 9, NULL, 1),
(347, 16, NULL, 9, NULL, 1),
(348, 16, NULL, 9, NULL, 1),
(349, 16, NULL, 9, NULL, 1),
(350, 16, NULL, 9, NULL, 1),
(351, 16, NULL, 9, NULL, 1),
(352, 16, NULL, 9, NULL, 1),
(353, 16, NULL, 9, NULL, 1),
(354, 16, NULL, 9, NULL, 1),
(355, 16, NULL, 9, NULL, 1),
(356, 16, NULL, 9, NULL, 1),
(357, 16, NULL, 9, NULL, 1),
(358, 16, NULL, 9, NULL, 1),
(359, 16, NULL, 9, NULL, 1),
(360, 16, NULL, 9, NULL, 1),
(361, 16, NULL, 9, NULL, 1),
(362, 16, NULL, 9, NULL, 1),
(363, 16, NULL, 9, NULL, 1),
(364, 16, NULL, 9, NULL, 1),
(365, 16, NULL, 9, NULL, 1),
(366, 16, NULL, 9, NULL, 1),
(367, 16, NULL, 9, NULL, 1),
(368, 16, NULL, 9, NULL, 1),
(369, 16, NULL, 9, NULL, 1),
(370, 16, NULL, 9, NULL, 1),
(371, 16, NULL, 9, NULL, 1),
(372, 16, NULL, 9, NULL, 1),
(373, 16, NULL, 9, NULL, 1),
(374, 16, NULL, 9, NULL, 1),
(375, 16, NULL, 9, NULL, 1),
(376, 16, NULL, 9, NULL, 1),
(377, 16, NULL, 9, NULL, 1),
(378, 16, NULL, 9, NULL, 1),
(379, 16, NULL, 9, NULL, 1),
(380, 16, NULL, 9, NULL, 1),
(381, 16, NULL, 9, NULL, 1),
(382, 17, NULL, 9, NULL, 1),
(383, 17, NULL, 9, NULL, 1),
(384, 17, NULL, 9, NULL, 1),
(385, 17, NULL, 9, NULL, 1),
(386, 17, NULL, 9, NULL, 1),
(387, 16, NULL, 10, NULL, 1),
(388, 16, NULL, 10, NULL, 1),
(389, 16, NULL, 10, NULL, 1),
(390, 16, NULL, 10, NULL, 1),
(391, 16, NULL, 10, NULL, 1),
(392, 16, NULL, 10, NULL, 1),
(393, 16, NULL, 10, NULL, 1),
(394, 16, NULL, 10, NULL, 1),
(395, 16, NULL, 10, NULL, 1),
(396, 16, NULL, 10, NULL, 1),
(397, 16, NULL, 10, NULL, 1),
(398, 16, NULL, 10, NULL, 1),
(399, 16, NULL, 10, NULL, 1),
(400, 16, NULL, 10, NULL, 1),
(401, 16, NULL, 10, NULL, 1),
(402, 16, NULL, 10, NULL, 1),
(403, 16, NULL, 10, NULL, 1),
(404, 16, NULL, 10, NULL, 1),
(405, 16, NULL, 10, NULL, 1),
(406, 16, NULL, 10, NULL, 1),
(407, 16, NULL, 10, NULL, 1),
(408, 16, NULL, 10, NULL, 1),
(409, 16, NULL, 10, NULL, 1),
(410, 16, NULL, 10, NULL, 1),
(411, 16, NULL, 10, NULL, 1),
(412, 16, NULL, 10, NULL, 1),
(413, 16, NULL, 10, NULL, 1),
(414, 16, NULL, 10, NULL, 1),
(415, 16, NULL, 10, NULL, 1),
(416, 16, NULL, 10, NULL, 1),
(417, 16, NULL, 10, NULL, 1),
(418, 16, NULL, 10, NULL, 1),
(419, 16, NULL, 10, NULL, 1),
(420, 16, NULL, 10, NULL, 1),
(421, 16, NULL, 10, NULL, 1),
(422, 16, NULL, 10, NULL, 1),
(423, 16, NULL, 10, NULL, 1),
(424, 16, NULL, 10, NULL, 1),
(425, 16, NULL, 10, NULL, 1),
(426, 16, NULL, 10, NULL, 1),
(427, 17, NULL, 10, NULL, 1),
(428, 17, NULL, 10, NULL, 1),
(429, 17, NULL, 10, NULL, 1),
(430, 17, NULL, 10, NULL, 1),
(431, 17, NULL, 10, NULL, 1),
(432, 16, NULL, 11, NULL, 1),
(433, 16, NULL, 11, NULL, 1),
(434, 16, NULL, 11, NULL, 1),
(435, 16, NULL, 11, NULL, 1),
(436, 16, NULL, 11, NULL, 1),
(437, 16, NULL, 11, NULL, 1),
(438, 16, NULL, 11, NULL, 1),
(439, 16, NULL, 11, NULL, 1),
(440, 16, NULL, 11, NULL, 1),
(441, 16, NULL, 11, NULL, 1),
(442, 16, NULL, 11, NULL, 1),
(443, 16, NULL, 11, NULL, 1),
(444, 16, NULL, 11, NULL, 1),
(445, 16, NULL, 11, NULL, 1),
(446, 16, NULL, 11, NULL, 1),
(447, 16, NULL, 11, NULL, 1),
(448, 16, NULL, 11, NULL, 1),
(449, 16, NULL, 11, NULL, 1),
(450, 16, NULL, 11, NULL, 1),
(451, 16, NULL, 11, NULL, 1),
(452, 16, NULL, 11, NULL, 1),
(453, 16, NULL, 11, NULL, 1),
(454, 16, NULL, 11, NULL, 1),
(455, 16, NULL, 11, NULL, 1),
(456, 16, NULL, 11, NULL, 1),
(457, 16, NULL, 11, NULL, 1),
(458, 16, NULL, 11, NULL, 1),
(459, 16, NULL, 11, NULL, 1),
(460, 16, NULL, 11, NULL, 1),
(461, 16, NULL, 11, NULL, 1),
(462, 16, NULL, 11, NULL, 1),
(463, 16, NULL, 11, NULL, 1),
(464, 16, NULL, 11, NULL, 1),
(465, 16, NULL, 11, NULL, 1),
(466, 16, NULL, 11, NULL, 1),
(467, 16, NULL, 11, NULL, 1),
(468, 16, NULL, 11, NULL, 1),
(469, 16, NULL, 11, NULL, 1),
(470, 16, NULL, 11, NULL, 1),
(471, 16, NULL, 11, NULL, 1),
(472, 17, NULL, 11, NULL, 1),
(473, 17, NULL, 11, NULL, 1),
(474, 17, NULL, 11, NULL, 1),
(475, 17, NULL, 11, NULL, 1),
(476, 17, NULL, 11, NULL, 1),
(477, 16, NULL, 12, NULL, 1),
(478, 16, NULL, 12, NULL, 1),
(479, 16, NULL, 12, NULL, 1),
(480, 16, NULL, 12, NULL, 1),
(481, 16, NULL, 12, NULL, 1),
(482, 16, NULL, 12, NULL, 1),
(483, 16, NULL, 12, NULL, 1),
(484, 16, NULL, 12, NULL, 1),
(485, 16, NULL, 12, NULL, 1),
(486, 16, NULL, 12, NULL, 1),
(487, 16, NULL, 12, NULL, 1),
(488, 16, NULL, 12, NULL, 1),
(489, 16, NULL, 12, NULL, 1),
(490, 16, NULL, 12, NULL, 1),
(491, 16, NULL, 12, NULL, 1),
(492, 16, NULL, 12, NULL, 1),
(493, 16, NULL, 12, NULL, 1),
(494, 16, NULL, 12, NULL, 1),
(495, 16, NULL, 12, NULL, 1),
(496, 16, NULL, 12, NULL, 1),
(497, 16, NULL, 12, NULL, 1),
(498, 16, NULL, 12, NULL, 1),
(499, 16, NULL, 12, NULL, 1),
(500, 16, NULL, 12, NULL, 1),
(501, 16, NULL, 12, NULL, 1),
(502, 16, NULL, 12, NULL, 1),
(503, 16, NULL, 12, NULL, 1),
(504, 16, NULL, 12, NULL, 1),
(505, 16, NULL, 12, NULL, 1),
(506, 16, NULL, 12, NULL, 1),
(507, 16, NULL, 12, NULL, 1),
(508, 16, NULL, 12, NULL, 1),
(509, 16, NULL, 12, NULL, 1),
(510, 16, NULL, 12, NULL, 1),
(511, 16, NULL, 12, NULL, 1),
(512, 16, NULL, 12, NULL, 1),
(513, 16, NULL, 12, NULL, 1),
(514, 16, NULL, 12, NULL, 1),
(515, 16, NULL, 12, NULL, 1),
(516, 16, NULL, 12, NULL, 1),
(517, 17, NULL, 12, NULL, 1),
(518, 17, NULL, 12, NULL, 1),
(519, 17, NULL, 12, NULL, 1),
(520, 17, NULL, 12, NULL, 1),
(521, 17, NULL, 12, NULL, 1),
(522, 16, NULL, 13, NULL, 1),
(523, 16, NULL, 13, NULL, 1),
(524, 16, NULL, 13, NULL, 1),
(525, 16, NULL, 13, NULL, 1),
(526, 16, NULL, 13, NULL, 1),
(527, 16, NULL, 13, NULL, 1),
(528, 16, NULL, 13, NULL, 1),
(529, 16, NULL, 13, NULL, 1),
(530, 16, NULL, 13, NULL, 1),
(531, 16, NULL, 13, NULL, 1),
(532, 16, NULL, 13, NULL, 1),
(533, 16, NULL, 13, NULL, 1),
(534, 16, NULL, 13, NULL, 1),
(535, 16, NULL, 13, NULL, 1),
(536, 16, NULL, 13, NULL, 1),
(537, 16, NULL, 13, NULL, 1),
(538, 16, NULL, 13, NULL, 1),
(539, 16, NULL, 13, NULL, 1),
(540, 16, NULL, 13, NULL, 1),
(541, 16, NULL, 13, NULL, 1),
(542, 16, NULL, 13, NULL, 1),
(543, 16, NULL, 13, NULL, 1),
(544, 16, NULL, 13, NULL, 1),
(545, 16, NULL, 13, NULL, 1),
(546, 16, NULL, 13, NULL, 1),
(547, 16, NULL, 13, NULL, 1),
(548, 16, NULL, 13, NULL, 1),
(549, 16, NULL, 13, NULL, 1),
(550, 16, NULL, 13, NULL, 1),
(551, 16, NULL, 13, NULL, 1),
(552, 16, NULL, 13, NULL, 1),
(553, 16, NULL, 13, NULL, 1),
(554, 16, NULL, 13, NULL, 1),
(555, 16, NULL, 13, NULL, 1),
(556, 16, NULL, 13, NULL, 1),
(557, 16, NULL, 13, NULL, 1),
(558, 16, NULL, 13, NULL, 1),
(559, 16, NULL, 13, NULL, 1),
(560, 16, NULL, 13, NULL, 1),
(561, 16, NULL, 13, NULL, 1),
(562, 17, NULL, 13, NULL, 1),
(563, 17, NULL, 13, NULL, 1),
(564, 17, NULL, 13, NULL, 1),
(565, 17, NULL, 13, NULL, 1),
(566, 17, NULL, 13, NULL, 1),
(567, 16, NULL, 14, NULL, 1),
(568, 16, NULL, 14, NULL, 1),
(569, 16, NULL, 14, NULL, 1),
(570, 16, NULL, 14, NULL, 1),
(571, 16, NULL, 14, NULL, 1),
(572, 16, NULL, 14, NULL, 1),
(573, 16, NULL, 14, NULL, 1),
(574, 16, NULL, 14, NULL, 1),
(575, 16, NULL, 14, NULL, 1),
(576, 16, NULL, 14, NULL, 1),
(577, 16, NULL, 14, NULL, 1),
(578, 16, NULL, 14, NULL, 1),
(579, 16, NULL, 14, NULL, 1),
(580, 16, NULL, 14, NULL, 1),
(581, 16, NULL, 14, NULL, 1),
(582, 16, NULL, 14, NULL, 1),
(583, 16, NULL, 14, NULL, 1),
(584, 16, NULL, 14, NULL, 1),
(585, 16, NULL, 14, NULL, 1),
(586, 16, NULL, 14, NULL, 1),
(587, 16, NULL, 14, NULL, 1),
(588, 16, NULL, 14, NULL, 1),
(589, 16, NULL, 14, NULL, 1),
(590, 16, NULL, 14, NULL, 1),
(591, 16, NULL, 14, NULL, 1),
(592, 16, NULL, 14, NULL, 1),
(593, 16, NULL, 14, NULL, 1),
(594, 16, NULL, 14, NULL, 1),
(595, 16, NULL, 14, NULL, 1),
(596, 16, NULL, 14, NULL, 1),
(597, 16, NULL, 14, NULL, 1),
(598, 16, NULL, 14, NULL, 1),
(599, 16, NULL, 14, NULL, 1),
(600, 16, NULL, 14, NULL, 1),
(601, 16, NULL, 14, NULL, 1),
(602, 16, NULL, 14, NULL, 1),
(603, 16, NULL, 14, NULL, 1),
(604, 16, NULL, 14, NULL, 1),
(605, 16, NULL, 14, NULL, 1),
(606, 16, NULL, 14, NULL, 1),
(607, 17, NULL, 14, NULL, 1),
(608, 17, NULL, 14, NULL, 1),
(609, 17, NULL, 14, NULL, 1),
(610, 17, NULL, 14, NULL, 1),
(611, 17, NULL, 14, NULL, 1),
(612, 16, NULL, 15, NULL, 1),
(613, 16, NULL, 15, NULL, 1),
(614, 16, NULL, 15, NULL, 1),
(615, 16, NULL, 15, NULL, 1),
(616, 16, NULL, 15, NULL, 1),
(617, 16, NULL, 15, NULL, 1),
(618, 16, NULL, 15, NULL, 1),
(619, 16, NULL, 15, NULL, 1),
(620, 16, NULL, 15, NULL, 1),
(621, 16, NULL, 15, NULL, 1),
(622, 16, NULL, 15, NULL, 1),
(623, 16, NULL, 15, NULL, 1),
(624, 16, NULL, 15, NULL, 1),
(625, 16, NULL, 15, NULL, 1),
(626, 16, NULL, 15, NULL, 1),
(627, 16, NULL, 15, NULL, 1),
(628, 16, NULL, 15, NULL, 1),
(629, 16, NULL, 15, NULL, 1),
(630, 16, NULL, 15, NULL, 1),
(631, 16, NULL, 15, NULL, 1),
(632, 16, NULL, 15, NULL, 1),
(633, 16, NULL, 15, NULL, 1),
(634, 16, NULL, 15, NULL, 1),
(635, 16, NULL, 15, NULL, 1),
(636, 16, NULL, 15, NULL, 1),
(637, 16, NULL, 15, NULL, 1),
(638, 16, NULL, 15, NULL, 1),
(639, 16, NULL, 15, NULL, 1),
(640, 16, NULL, 15, NULL, 1),
(641, 16, NULL, 15, NULL, 1),
(642, 16, NULL, 15, NULL, 1),
(643, 16, NULL, 15, NULL, 1),
(644, 16, NULL, 15, NULL, 1),
(645, 16, NULL, 15, NULL, 1),
(646, 16, NULL, 15, NULL, 1),
(647, 16, NULL, 15, NULL, 1),
(648, 16, NULL, 15, NULL, 1),
(649, 16, NULL, 15, NULL, 1),
(650, 16, NULL, 15, NULL, 1),
(651, 16, NULL, 15, NULL, 1),
(652, 17, NULL, 15, NULL, 1),
(653, 17, NULL, 15, NULL, 1),
(654, 17, NULL, 15, NULL, 1),
(655, 17, NULL, 15, NULL, 1),
(656, 17, NULL, 15, NULL, 1),
(657, 16, NULL, 16, NULL, 1),
(658, 16, NULL, 16, NULL, 1),
(659, 16, NULL, 16, NULL, 1),
(660, 16, NULL, 16, NULL, 1),
(661, 16, NULL, 16, NULL, 1),
(662, 16, NULL, 16, NULL, 1),
(663, 16, NULL, 16, NULL, 1),
(664, 16, NULL, 16, NULL, 1),
(665, 16, NULL, 16, NULL, 1),
(666, 16, NULL, 16, NULL, 1),
(667, 16, NULL, 16, NULL, 1),
(668, 16, NULL, 16, NULL, 1),
(669, 16, NULL, 16, NULL, 1),
(670, 16, NULL, 16, NULL, 1),
(671, 16, NULL, 16, NULL, 1),
(672, 16, NULL, 16, NULL, 1),
(673, 16, NULL, 16, NULL, 1),
(674, 16, NULL, 16, NULL, 1),
(675, 16, NULL, 16, NULL, 1),
(676, 16, NULL, 16, NULL, 1),
(677, 16, NULL, 16, NULL, 1),
(678, 16, NULL, 16, NULL, 1),
(679, 16, NULL, 16, NULL, 1),
(680, 16, NULL, 16, NULL, 1),
(681, 16, NULL, 16, NULL, 1),
(682, 16, NULL, 16, NULL, 1),
(683, 16, NULL, 16, NULL, 1),
(684, 16, NULL, 16, NULL, 1),
(685, 16, NULL, 16, NULL, 1),
(686, 16, NULL, 16, NULL, 1),
(687, 16, NULL, 16, NULL, 1),
(688, 16, NULL, 16, NULL, 1),
(689, 16, NULL, 16, NULL, 1),
(690, 16, NULL, 16, NULL, 1),
(691, 16, NULL, 16, NULL, 1),
(692, 16, NULL, 16, NULL, 1),
(693, 16, NULL, 16, NULL, 1),
(694, 16, NULL, 16, NULL, 1),
(695, 16, NULL, 16, NULL, 1),
(696, 16, NULL, 16, NULL, 1),
(697, 17, NULL, 16, NULL, 1),
(698, 17, NULL, 16, NULL, 1),
(699, 17, NULL, 16, NULL, 1),
(700, 17, NULL, 16, NULL, 1),
(701, 17, NULL, 16, NULL, 1),
(702, 16, NULL, 17, NULL, 1),
(703, 16, NULL, 17, NULL, 1),
(704, 16, NULL, 17, NULL, 1),
(705, 16, NULL, 17, NULL, 1),
(706, 16, NULL, 17, NULL, 1),
(707, 16, NULL, 17, NULL, 1),
(708, 16, NULL, 17, NULL, 1),
(709, 16, NULL, 17, NULL, 1),
(710, 16, NULL, 17, NULL, 1),
(711, 16, NULL, 17, NULL, 1),
(712, 16, NULL, 17, NULL, 1),
(713, 16, NULL, 17, NULL, 1),
(714, 16, NULL, 17, NULL, 1),
(715, 16, NULL, 17, NULL, 1),
(716, 16, NULL, 17, NULL, 1),
(717, 16, NULL, 17, NULL, 1),
(718, 16, NULL, 17, NULL, 1),
(719, 16, NULL, 17, NULL, 1),
(720, 16, NULL, 17, NULL, 1),
(721, 16, NULL, 17, NULL, 1),
(722, 16, NULL, 17, NULL, 1),
(723, 16, NULL, 17, NULL, 1),
(724, 16, NULL, 17, NULL, 1),
(725, 16, NULL, 17, NULL, 1),
(726, 16, NULL, 17, NULL, 1),
(727, 16, NULL, 17, NULL, 1),
(728, 16, NULL, 17, NULL, 1),
(729, 16, NULL, 17, NULL, 1),
(730, 16, NULL, 17, NULL, 1),
(731, 16, NULL, 17, NULL, 1),
(732, 16, NULL, 17, NULL, 1),
(733, 16, NULL, 17, NULL, 1),
(734, 16, NULL, 17, NULL, 1),
(735, 16, NULL, 17, NULL, 1),
(736, 16, NULL, 17, NULL, 1),
(737, 16, NULL, 17, NULL, 1),
(738, 16, NULL, 17, NULL, 1),
(739, 16, NULL, 17, NULL, 1),
(740, 16, NULL, 17, NULL, 1),
(741, 16, NULL, 17, NULL, 1),
(742, 17, NULL, 17, NULL, 1),
(743, 17, NULL, 17, NULL, 1),
(744, 17, NULL, 17, NULL, 1),
(745, 17, NULL, 17, NULL, 1),
(746, 17, NULL, 17, NULL, 1),
(747, 16, NULL, 18, NULL, 1),
(748, 16, NULL, 18, NULL, 1),
(749, 16, NULL, 18, NULL, 1),
(750, 16, NULL, 18, NULL, 1),
(751, 16, NULL, 18, NULL, 1),
(752, 16, NULL, 18, NULL, 1),
(753, 16, NULL, 18, NULL, 1),
(754, 16, NULL, 18, NULL, 1),
(755, 16, NULL, 18, NULL, 1),
(756, 16, NULL, 18, NULL, 1),
(757, 16, NULL, 18, NULL, 1),
(758, 16, NULL, 18, NULL, 1),
(759, 16, NULL, 18, NULL, 1),
(760, 16, NULL, 18, NULL, 1),
(761, 16, NULL, 18, NULL, 1),
(762, 16, NULL, 18, NULL, 1),
(763, 16, NULL, 18, NULL, 1),
(764, 16, NULL, 18, NULL, 1),
(765, 16, NULL, 18, NULL, 1),
(766, 16, NULL, 18, NULL, 1),
(767, 16, NULL, 18, NULL, 1),
(768, 16, NULL, 18, NULL, 1),
(769, 16, NULL, 18, NULL, 1),
(770, 16, NULL, 18, NULL, 1),
(771, 16, NULL, 18, NULL, 1),
(772, 16, NULL, 18, NULL, 1),
(773, 16, NULL, 18, NULL, 1),
(774, 16, NULL, 18, NULL, 1),
(775, 16, NULL, 18, NULL, 1),
(776, 16, NULL, 18, NULL, 1),
(777, 16, NULL, 18, NULL, 1),
(778, 16, NULL, 18, NULL, 1),
(779, 16, NULL, 18, NULL, 1),
(780, 16, NULL, 18, NULL, 1),
(781, 16, NULL, 18, NULL, 1),
(782, 16, NULL, 18, NULL, 1),
(783, 16, NULL, 18, NULL, 1),
(784, 16, NULL, 18, NULL, 1),
(785, 16, NULL, 18, NULL, 1),
(786, 16, NULL, 18, NULL, 1),
(787, 17, NULL, 18, NULL, 1),
(788, 17, NULL, 18, NULL, 1),
(789, 17, NULL, 18, NULL, 1),
(790, 17, NULL, 18, NULL, 1),
(791, 17, NULL, 18, NULL, 1),
(792, 16, NULL, 19, NULL, 1),
(793, 16, NULL, 19, NULL, 1),
(794, 16, NULL, 19, NULL, 1),
(795, 16, NULL, 19, NULL, 1),
(796, 16, NULL, 19, NULL, 1),
(797, 16, NULL, 19, NULL, 1),
(798, 16, NULL, 19, NULL, 1),
(799, 16, NULL, 19, NULL, 1),
(800, 16, NULL, 19, NULL, 1),
(801, 16, NULL, 19, NULL, 1),
(802, 16, NULL, 19, NULL, 1),
(803, 16, NULL, 19, NULL, 1),
(804, 16, NULL, 19, NULL, 1),
(805, 16, NULL, 19, NULL, 1),
(806, 16, NULL, 19, NULL, 1),
(807, 16, NULL, 19, NULL, 1),
(808, 16, NULL, 19, NULL, 1),
(809, 16, NULL, 19, NULL, 1),
(810, 16, NULL, 19, NULL, 1),
(811, 16, NULL, 19, NULL, 1),
(812, 16, NULL, 19, NULL, 1),
(813, 16, NULL, 19, NULL, 1),
(814, 16, NULL, 19, NULL, 1),
(815, 16, NULL, 19, NULL, 1),
(816, 16, NULL, 19, NULL, 1),
(817, 16, NULL, 19, NULL, 1),
(818, 16, NULL, 19, NULL, 1),
(819, 16, NULL, 19, NULL, 1),
(820, 16, NULL, 19, NULL, 1),
(821, 16, NULL, 19, NULL, 1),
(822, 16, NULL, 19, NULL, 1),
(823, 16, NULL, 19, NULL, 1),
(824, 16, NULL, 19, NULL, 1),
(825, 16, NULL, 19, NULL, 1),
(826, 16, NULL, 19, NULL, 1),
(827, 16, NULL, 19, NULL, 1),
(828, 16, NULL, 19, NULL, 1),
(829, 16, NULL, 19, NULL, 1),
(830, 16, NULL, 19, NULL, 1),
(831, 16, NULL, 19, NULL, 1),
(832, 17, NULL, 19, NULL, 1),
(833, 17, NULL, 19, NULL, 1),
(834, 17, NULL, 19, NULL, 1),
(835, 17, NULL, 19, NULL, 1),
(836, 17, NULL, 19, NULL, 1),
(837, 16, NULL, 20, NULL, 1),
(838, 16, NULL, 20, NULL, 1),
(839, 16, NULL, 20, NULL, 1),
(840, 16, NULL, 20, NULL, 1),
(841, 16, NULL, 20, NULL, 1),
(842, 16, NULL, 20, NULL, 1),
(843, 16, NULL, 20, NULL, 1),
(844, 16, NULL, 20, NULL, 1),
(845, 16, NULL, 20, NULL, 1),
(846, 16, NULL, 20, NULL, 1),
(847, 16, NULL, 20, NULL, 1),
(848, 16, NULL, 20, NULL, 1),
(849, 16, NULL, 20, NULL, 1),
(850, 16, NULL, 20, NULL, 1),
(851, 16, NULL, 20, NULL, 1),
(852, 16, NULL, 20, NULL, 1),
(853, 16, NULL, 20, NULL, 1),
(854, 16, NULL, 20, NULL, 1),
(855, 16, NULL, 20, NULL, 1),
(856, 16, NULL, 20, NULL, 1),
(857, 16, NULL, 20, NULL, 1),
(858, 16, NULL, 20, NULL, 1),
(859, 16, NULL, 20, NULL, 1),
(860, 16, NULL, 20, NULL, 1),
(861, 16, NULL, 20, NULL, 1),
(862, 16, NULL, 20, NULL, 1),
(863, 16, NULL, 20, NULL, 1),
(864, 16, NULL, 20, NULL, 1),
(865, 16, NULL, 20, NULL, 1),
(866, 16, NULL, 20, NULL, 1),
(867, 16, NULL, 20, NULL, 1),
(868, 16, NULL, 20, NULL, 1),
(869, 16, NULL, 20, NULL, 1),
(870, 16, NULL, 20, NULL, 1),
(871, 16, NULL, 20, NULL, 1),
(872, 16, NULL, 20, NULL, 1),
(873, 16, NULL, 20, NULL, 1),
(874, 16, NULL, 20, NULL, 1),
(875, 16, NULL, 20, NULL, 1),
(876, 16, NULL, 20, NULL, 1),
(877, 17, NULL, 20, NULL, 1),
(878, 17, NULL, 20, NULL, 1),
(879, 17, NULL, 20, NULL, 1),
(880, 17, NULL, 20, NULL, 1),
(881, 17, NULL, 20, NULL, 1),
(882, 16, NULL, 21, NULL, 1),
(883, 16, NULL, 21, NULL, 1),
(884, 16, NULL, 21, NULL, 1),
(885, 16, NULL, 21, NULL, 1),
(886, 16, NULL, 21, NULL, 1),
(887, 16, NULL, 21, NULL, 1),
(888, 16, NULL, 21, NULL, 1),
(889, 16, NULL, 21, NULL, 1),
(890, 16, NULL, 21, NULL, 1),
(891, 16, NULL, 21, NULL, 1),
(892, 16, NULL, 21, NULL, 1),
(893, 16, NULL, 21, NULL, 1),
(894, 16, NULL, 21, NULL, 1),
(895, 16, NULL, 21, NULL, 1),
(896, 16, NULL, 21, NULL, 1),
(897, 16, NULL, 21, NULL, 1),
(898, 16, NULL, 21, NULL, 1),
(899, 16, NULL, 21, NULL, 1),
(900, 16, NULL, 21, NULL, 1),
(901, 16, NULL, 21, NULL, 1),
(902, 16, NULL, 21, NULL, 1),
(903, 16, NULL, 21, NULL, 1),
(904, 16, NULL, 21, NULL, 1),
(905, 16, NULL, 21, NULL, 1),
(906, 16, NULL, 21, NULL, 1),
(907, 16, NULL, 21, NULL, 1),
(908, 16, NULL, 21, NULL, 1),
(909, 16, NULL, 21, NULL, 1),
(910, 16, NULL, 21, NULL, 1),
(911, 16, NULL, 21, NULL, 1),
(912, 16, NULL, 21, NULL, 1),
(913, 16, NULL, 21, NULL, 1),
(914, 16, NULL, 21, NULL, 1),
(915, 16, NULL, 21, NULL, 1),
(916, 16, NULL, 21, NULL, 1),
(917, 16, NULL, 21, NULL, 1),
(918, 16, NULL, 21, NULL, 1),
(919, 16, NULL, 21, NULL, 1),
(920, 16, NULL, 21, NULL, 1),
(921, 16, NULL, 21, NULL, 1),
(922, 17, NULL, 21, NULL, 1),
(923, 17, NULL, 21, NULL, 1),
(924, 17, NULL, 21, NULL, 1),
(925, 17, NULL, 21, NULL, 1),
(926, 17, NULL, 21, NULL, 1),
(927, 16, NULL, 22, NULL, 1),
(928, 16, NULL, 22, NULL, 1),
(929, 16, NULL, 22, NULL, 1),
(930, 16, NULL, 22, NULL, 1),
(931, 16, NULL, 22, NULL, 1),
(932, 16, NULL, 22, NULL, 1),
(933, 16, NULL, 22, NULL, 1),
(934, 16, NULL, 22, NULL, 1),
(935, 16, NULL, 22, NULL, 1),
(936, 16, NULL, 22, NULL, 1),
(937, 16, NULL, 22, NULL, 1),
(938, 16, NULL, 22, NULL, 1),
(939, 16, NULL, 22, NULL, 1),
(940, 16, NULL, 22, NULL, 1),
(941, 16, NULL, 22, NULL, 1),
(942, 16, NULL, 22, NULL, 1),
(943, 16, NULL, 22, NULL, 1),
(944, 16, NULL, 22, NULL, 1),
(945, 16, NULL, 22, NULL, 1),
(946, 16, NULL, 22, NULL, 1),
(947, 16, NULL, 22, NULL, 1),
(948, 16, NULL, 22, NULL, 1),
(949, 16, NULL, 22, NULL, 1),
(950, 16, NULL, 22, NULL, 1),
(951, 16, NULL, 22, NULL, 1),
(952, 16, NULL, 22, NULL, 1),
(953, 16, NULL, 22, NULL, 1),
(954, 16, NULL, 22, NULL, 1),
(955, 16, NULL, 22, NULL, 1),
(956, 16, NULL, 22, NULL, 1),
(957, 16, NULL, 22, NULL, 1),
(958, 16, NULL, 22, NULL, 1),
(959, 16, NULL, 22, NULL, 1),
(960, 16, NULL, 22, NULL, 1),
(961, 16, NULL, 22, NULL, 1),
(962, 16, NULL, 22, NULL, 1),
(963, 16, NULL, 22, NULL, 1),
(964, 16, NULL, 22, NULL, 1),
(965, 16, NULL, 22, NULL, 1),
(966, 16, NULL, 22, NULL, 1),
(967, 17, NULL, 22, NULL, 1),
(968, 17, NULL, 22, NULL, 1),
(969, 17, NULL, 22, NULL, 1),
(970, 17, NULL, 22, NULL, 1),
(971, 17, NULL, 22, NULL, 1),
(972, 16, NULL, 23, NULL, 1),
(973, 16, NULL, 23, NULL, 1),
(974, 16, NULL, 23, NULL, 1),
(975, 16, NULL, 23, NULL, 1),
(976, 16, NULL, 23, NULL, 1),
(977, 16, NULL, 23, NULL, 1),
(978, 16, NULL, 23, NULL, 1),
(979, 16, NULL, 23, NULL, 1),
(980, 16, NULL, 23, NULL, 1),
(981, 16, NULL, 23, NULL, 1),
(982, 16, NULL, 23, NULL, 1),
(983, 16, NULL, 23, NULL, 1),
(984, 16, NULL, 23, NULL, 1),
(985, 16, NULL, 23, NULL, 1),
(986, 16, NULL, 23, NULL, 1),
(987, 16, NULL, 23, NULL, 1),
(988, 16, NULL, 23, NULL, 1),
(989, 16, NULL, 23, NULL, 1),
(990, 16, NULL, 23, NULL, 1),
(991, 16, NULL, 23, NULL, 1),
(992, 16, NULL, 23, NULL, 1),
(993, 16, NULL, 23, NULL, 1),
(994, 16, NULL, 23, NULL, 1),
(995, 16, NULL, 23, NULL, 1),
(996, 16, NULL, 23, NULL, 1),
(997, 16, NULL, 23, NULL, 1),
(998, 16, NULL, 23, NULL, 1),
(999, 16, NULL, 23, NULL, 1),
(1000, 16, NULL, 23, NULL, 1),
(1001, 16, NULL, 23, NULL, 1),
(1002, 16, NULL, 23, NULL, 1),
(1003, 16, NULL, 23, NULL, 1),
(1004, 16, NULL, 23, NULL, 1),
(1005, 16, NULL, 23, NULL, 1),
(1006, 16, NULL, 23, NULL, 1),
(1007, 16, NULL, 23, NULL, 1),
(1008, 16, NULL, 23, NULL, 1),
(1009, 16, NULL, 23, NULL, 1),
(1010, 16, NULL, 23, NULL, 1),
(1011, 16, NULL, 23, NULL, 1),
(1012, 17, NULL, 23, NULL, 1),
(1013, 17, NULL, 23, NULL, 1),
(1014, 17, NULL, 23, NULL, 1),
(1015, 17, NULL, 23, NULL, 1),
(1016, 17, NULL, 23, NULL, 1),
(1017, 16, NULL, 24, NULL, 1),
(1018, 16, NULL, 24, NULL, 1),
(1019, 16, NULL, 24, NULL, 1),
(1020, 16, NULL, 24, NULL, 1),
(1021, 16, NULL, 24, NULL, 1),
(1022, 16, NULL, 24, NULL, 1),
(1023, 16, NULL, 24, NULL, 1),
(1024, 16, NULL, 24, NULL, 1),
(1025, 16, NULL, 24, NULL, 1),
(1026, 16, NULL, 24, NULL, 1),
(1027, 16, NULL, 24, NULL, 1),
(1028, 16, NULL, 24, NULL, 1),
(1029, 16, NULL, 24, NULL, 1),
(1030, 16, NULL, 24, NULL, 1),
(1031, 16, NULL, 24, NULL, 1),
(1032, 16, NULL, 24, NULL, 1),
(1033, 16, NULL, 24, NULL, 1),
(1034, 16, NULL, 24, NULL, 1),
(1035, 16, NULL, 24, NULL, 1),
(1036, 16, NULL, 24, NULL, 1),
(1037, 16, NULL, 24, NULL, 1),
(1038, 16, NULL, 24, NULL, 1),
(1039, 16, NULL, 24, NULL, 1),
(1040, 16, NULL, 24, NULL, 1),
(1041, 16, NULL, 24, NULL, 1),
(1042, 16, NULL, 24, NULL, 1),
(1043, 16, NULL, 24, NULL, 1),
(1044, 16, NULL, 24, NULL, 1),
(1045, 16, NULL, 24, NULL, 1),
(1046, 16, NULL, 24, NULL, 1),
(1047, 16, NULL, 24, NULL, 1),
(1048, 16, NULL, 24, NULL, 1),
(1049, 16, NULL, 24, NULL, 1),
(1050, 16, NULL, 24, NULL, 1),
(1051, 16, NULL, 24, NULL, 1),
(1052, 16, NULL, 24, NULL, 1),
(1053, 16, NULL, 24, NULL, 1),
(1054, 16, NULL, 24, NULL, 1),
(1055, 16, NULL, 24, NULL, 1),
(1056, 16, NULL, 24, NULL, 1),
(1057, 17, NULL, 24, NULL, 1),
(1058, 17, NULL, 24, NULL, 1),
(1059, 17, NULL, 24, NULL, 1),
(1060, 17, NULL, 24, NULL, 1),
(1061, 17, NULL, 24, NULL, 1),
(1062, 16, NULL, 25, NULL, 1),
(1063, 16, NULL, 25, NULL, 1),
(1064, 16, NULL, 25, NULL, 1),
(1065, 16, NULL, 25, NULL, 1),
(1066, 16, NULL, 25, NULL, 1),
(1067, 16, NULL, 25, NULL, 1),
(1068, 16, NULL, 25, NULL, 1),
(1069, 16, NULL, 25, NULL, 1),
(1070, 16, NULL, 25, NULL, 1),
(1071, 16, NULL, 25, NULL, 1),
(1072, 16, NULL, 25, NULL, 1),
(1073, 16, NULL, 25, NULL, 1),
(1074, 16, NULL, 25, NULL, 1),
(1075, 16, NULL, 25, NULL, 1),
(1076, 16, NULL, 25, NULL, 1),
(1077, 16, NULL, 25, NULL, 1),
(1078, 16, NULL, 25, NULL, 1),
(1079, 16, NULL, 25, NULL, 1),
(1080, 16, NULL, 25, NULL, 1),
(1081, 16, NULL, 25, NULL, 1),
(1082, 16, NULL, 25, NULL, 1),
(1083, 16, NULL, 25, NULL, 1),
(1084, 16, NULL, 25, NULL, 1),
(1085, 16, NULL, 25, NULL, 1),
(1086, 16, NULL, 25, NULL, 1),
(1087, 16, NULL, 25, NULL, 1),
(1088, 16, NULL, 25, NULL, 1),
(1089, 16, NULL, 25, NULL, 1),
(1090, 16, NULL, 25, NULL, 1),
(1091, 16, NULL, 25, NULL, 1),
(1092, 16, NULL, 25, NULL, 1),
(1093, 16, NULL, 25, NULL, 1),
(1094, 16, NULL, 25, NULL, 1),
(1095, 16, NULL, 25, NULL, 1),
(1096, 16, NULL, 25, NULL, 1),
(1097, 16, NULL, 25, NULL, 1),
(1098, 16, NULL, 25, NULL, 1),
(1099, 16, NULL, 25, NULL, 1),
(1100, 16, NULL, 25, NULL, 1),
(1101, 16, NULL, 25, NULL, 1),
(1102, 17, NULL, 25, NULL, 1),
(1103, 17, NULL, 25, NULL, 1),
(1104, 17, NULL, 25, NULL, 1),
(1105, 17, NULL, 25, NULL, 1),
(1106, 17, NULL, 25, NULL, 1),
(1107, 16, NULL, 26, NULL, 1),
(1108, 16, NULL, 26, NULL, 1),
(1109, 16, NULL, 26, NULL, 1),
(1110, 16, NULL, 26, NULL, 1),
(1111, 16, NULL, 26, NULL, 1),
(1112, 16, NULL, 26, NULL, 1),
(1113, 16, NULL, 26, NULL, 1),
(1114, 16, NULL, 26, NULL, 1),
(1115, 16, NULL, 26, NULL, 1),
(1116, 16, NULL, 26, NULL, 1),
(1117, 16, NULL, 26, NULL, 1),
(1118, 16, NULL, 26, NULL, 1),
(1119, 16, NULL, 26, NULL, 1),
(1120, 16, NULL, 26, NULL, 1),
(1121, 16, NULL, 26, NULL, 1),
(1122, 16, NULL, 26, NULL, 1),
(1123, 16, NULL, 26, NULL, 1),
(1124, 16, NULL, 26, NULL, 1),
(1125, 16, NULL, 26, NULL, 1),
(1126, 16, NULL, 26, NULL, 1),
(1127, 16, NULL, 26, NULL, 1),
(1128, 16, NULL, 26, NULL, 1),
(1129, 16, NULL, 26, NULL, 1),
(1130, 16, NULL, 26, NULL, 1),
(1131, 16, NULL, 26, NULL, 1),
(1132, 16, NULL, 26, NULL, 1),
(1133, 16, NULL, 26, NULL, 1),
(1134, 16, NULL, 26, NULL, 1),
(1135, 16, NULL, 26, NULL, 1),
(1136, 16, NULL, 26, NULL, 1),
(1137, 16, NULL, 26, NULL, 1),
(1138, 16, NULL, 26, NULL, 1),
(1139, 16, NULL, 26, NULL, 1),
(1140, 16, NULL, 26, NULL, 1),
(1141, 16, NULL, 26, NULL, 1),
(1142, 16, NULL, 26, NULL, 1),
(1143, 16, NULL, 26, NULL, 1),
(1144, 16, NULL, 26, NULL, 1),
(1145, 16, NULL, 26, NULL, 1),
(1146, 16, NULL, 26, NULL, 1),
(1147, 17, NULL, 26, NULL, 1),
(1148, 17, NULL, 26, NULL, 1),
(1149, 17, NULL, 26, NULL, 1),
(1150, 17, NULL, 26, NULL, 1),
(1151, 17, NULL, 26, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_asteroids`
--

CREATE TABLE `item_asteroids` (
  `item_asteroid_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `type` char(1) NOT NULL DEFAULT 'C',
  `size_cubic_meters` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_barges`
--

CREATE TABLE `item_barges` (
  `item_barge_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `series` char(1) NOT NULL,
  `age_years` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_beacons`
--

CREATE TABLE `item_beacons` (
  `item_beacon_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `series` char(1) NOT NULL,
  `age_years` int(11) NOT NULL,
  `last_activated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_beacon_activations`
--

CREATE TABLE `item_beacon_activations` (
  `item_beacon_activation_id` int(11) NOT NULL,
  `details` varchar(255) NOT NULL,
  `xloc` bigint(20) NOT NULL,
  `yloc` bigint(20) NOT NULL,
  `zloc` bigint(20) NOT NULL,
  `ship_id` bigint(20) NOT NULL,
  `datetimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_beacon_debris`
--

CREATE TABLE `item_beacon_debris` (
  `beacon_debris_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `series` char(1) NOT NULL,
  `age_years` int(11) NOT NULL,
  `destroyed_years` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_comets`
--

CREATE TABLE `item_comets` (
  `item_comet_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `size_diameter_meters` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_composites`
--

CREATE TABLE `item_composites` (
  `item_composite_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `type` char(1) NOT NULL,
  `size_cubic_meters` int(11) NOT NULL,
  `clay_cubic_meters` int(11) NOT NULL,
  `silicate_cubic_meters` int(11) NOT NULL,
  `nickel_iron_cubic_meters` int(11) NOT NULL,
  `iridium_cubic_meters` int(11) NOT NULL,
  `palladium_cubic_meters` int(11) NOT NULL,
  `osmium_cubic_meters` int(11) NOT NULL,
  `ruthenium_cubic_meters` int(11) NOT NULL,
  `rhodium_cubic_meters` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_cosmic_dusts`
--

CREATE TABLE `item_cosmic_dusts` (
  `item_cosmic-dust_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `size_diameter_meters` int(11) NOT NULL,
  `composite` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_fuel_rods`
--

CREATE TABLE `item_fuel_rods` (
  `item_fuelrod_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `length_centimeters` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_fuel_rods`
--

INSERT INTO `item_fuel_rods` (`item_fuelrod_id`, `item_id`, `length_centimeters`) VALUES
(1, 67, '20.00'),
(2, 68, '20.00'),
(3, 69, '20.00'),
(4, 70, '20.00'),
(5, 71, '20.00'),
(6, 112, '20.00'),
(7, 113, '20.00'),
(8, 114, '20.00'),
(9, 115, '20.00'),
(10, 116, '20.00'),
(11, 157, '20.00'),
(12, 158, '20.00'),
(13, 159, '20.00'),
(14, 160, '20.00'),
(15, 161, '20.00'),
(16, 202, '20.00'),
(17, 203, '20.00'),
(18, 204, '20.00'),
(19, 205, '20.00'),
(20, 206, '20.00'),
(21, 247, '20.00'),
(22, 248, '20.00'),
(23, 249, '20.00'),
(24, 250, '20.00'),
(25, 251, '20.00'),
(26, 292, '20.00'),
(27, 293, '20.00'),
(28, 294, '20.00'),
(29, 295, '20.00'),
(30, 296, '20.00'),
(31, 337, '20.00'),
(32, 338, '20.00'),
(33, 339, '20.00'),
(34, 340, '20.00'),
(35, 341, '20.00'),
(36, 382, '20.00'),
(37, 383, '20.00'),
(38, 384, '20.00'),
(39, 385, '20.00'),
(40, 386, '20.00'),
(41, 427, '20.00'),
(42, 428, '20.00'),
(43, 429, '20.00'),
(44, 430, '20.00'),
(45, 431, '20.00'),
(46, 472, '20.00'),
(47, 473, '20.00'),
(48, 474, '20.00'),
(49, 475, '20.00'),
(50, 476, '20.00'),
(51, 517, '20.00'),
(52, 518, '20.00'),
(53, 519, '20.00'),
(54, 520, '20.00'),
(55, 521, '20.00'),
(56, 562, '20.00'),
(57, 563, '20.00'),
(58, 564, '20.00'),
(59, 565, '20.00'),
(60, 566, '20.00'),
(61, 607, '20.00'),
(62, 608, '20.00'),
(63, 609, '20.00'),
(64, 610, '20.00'),
(65, 611, '20.00'),
(66, 652, '20.00'),
(67, 653, '20.00'),
(68, 654, '20.00'),
(69, 655, '20.00'),
(70, 656, '20.00'),
(71, 697, '20.00'),
(72, 698, '20.00'),
(73, 699, '20.00'),
(74, 700, '20.00'),
(75, 701, '20.00'),
(76, 742, '20.00'),
(77, 743, '20.00'),
(78, 744, '20.00'),
(79, 745, '20.00'),
(80, 746, '20.00'),
(81, 787, '20.00'),
(82, 788, '20.00'),
(83, 789, '20.00'),
(84, 790, '20.00'),
(85, 791, '20.00'),
(86, 832, '20.00'),
(87, 833, '20.00'),
(88, 834, '20.00'),
(89, 835, '20.00'),
(90, 836, '20.00'),
(91, 877, '20.00'),
(92, 878, '20.00'),
(93, 879, '20.00'),
(94, 880, '20.00'),
(95, 881, '20.00'),
(96, 922, '20.00'),
(97, 923, '20.00'),
(98, 924, '20.00'),
(99, 925, '20.00'),
(100, 926, '20.00'),
(101, 967, '20.00'),
(102, 968, '20.00'),
(103, 969, '20.00'),
(104, 970, '20.00'),
(105, 971, '20.00'),
(106, 1012, '20.00'),
(107, 1013, '20.00'),
(108, 1014, '20.00'),
(109, 1015, '20.00'),
(110, 1016, '20.00'),
(111, 1057, '20.00'),
(112, 1058, '20.00'),
(113, 1059, '20.00'),
(114, 1060, '20.00'),
(115, 1061, '20.00'),
(116, 1102, '20.00'),
(117, 1103, '20.00'),
(118, 1104, '20.00'),
(119, 1105, '20.00'),
(120, 1106, '20.00'),
(121, 1147, '20.00'),
(122, 1148, '20.00'),
(123, 1149, '20.00'),
(124, 1150, '20.00'),
(125, 1151, '20.00');

-- --------------------------------------------------------

--
-- Table structure for table `item_magnetic_fields`
--

CREATE TABLE `item_magnetic_fields` (
  `item_magnetic-field_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `polarity` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_ships`
--

CREATE TABLE `item_ships` (
  `item_ship_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `type` varchar(30) NOT NULL,
  `series` char(1) NOT NULL,
  `age_years` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_ships`
--

INSERT INTO `item_ships` (`item_ship_id`, `item_id`, `type`, `series`, `age_years`) VALUES
(17, 18, 'mining', 'V', 767),
(18, 17, 'mining', 'V', 631),
(19, 26, 'mining', 'V', 601),
(20, 2, 'mining', 'V', 753),
(21, 7, 'mining', 'V', 774),
(22, 15, 'mining', 'V', 614),
(23, 10, 'mining', 'V', 728);

-- --------------------------------------------------------

--
-- Table structure for table `item_ship_debris`
--

CREATE TABLE `item_ship_debris` (
  `ship_debris_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `type` varchar(30) NOT NULL,
  `destroyed_years` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_types`
--

CREATE TABLE `item_types` (
  `item_type_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `is_container` int(11) NOT NULL DEFAULT '0',
  `is_manmade` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_types`
--

INSERT INTO `item_types` (`item_type_id`, `name`, `is_container`, `is_manmade`) VALUES
(1, 'station', 1, 1),
(2, 'ship', 1, 1),
(3, 'barge', 0, 1),
(4, 'asteroid', 0, 0),
(5, 'comet', 0, 0),
(7, 'wormhole', 0, 0),
(8, 'magnetic-field', 0, 0),
(12, 'cosmic-dust', 0, 0),
(14, 'beacon', 0, 1),
(15, 'ship-debris', 0, 1),
(16, 'torpedo', 0, 1),
(17, 'fuel-rod', 0, 1),
(18, 'composite', 0, 0),
(19, 'debris', 0, 1),
(20, '(open)', 0, 0),
(21, '(open)', 0, 0),
(22, '(open)', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_wormholes`
--

CREATE TABLE `item_wormholes` (
  `item_wormhole_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `type` varchar(1) NOT NULL,
  `xloc` int(11) DEFAULT NULL,
  `yloc` int(11) DEFAULT NULL,
  `zloc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `player_id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(32) NOT NULL,
  `alias` varchar(15) NOT NULL,
  `turns` int(11) NOT NULL DEFAULT '500',
  `item_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`player_id`, `email`, `password`, `alias`, `turns`, `item_id`) VALUES
(2, 'npc1@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Misterbig', 500, 2),
(3, 'npc2@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Vanillasky', 500, 3),
(4, 'npc3@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Arpeggio', 500, 4),
(5, 'npc4@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Scooter', 500, 5),
(6, 'npc5@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Mystery', 500, 6),
(7, 'npc6@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Disneyfan', 500, 7),
(8, 'npc7@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Hottubbob', 500, 8),
(9, 'npc8@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Bubba', 500, 9),
(10, 'npc9@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Mollysox', 500, 10),
(11, 'npc10@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Shorty', 500, 11),
(12, 'npc11@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Bigdudeten', 500, 12),
(13, 'npc12@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Mike', 500, 13),
(14, 'npc13@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Yanksfan', 500, 14),
(15, 'npc14@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Bigleo', 500, 15),
(16, 'npc15@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Thenph', 500, 16),
(17, 'npc16@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Ultraman', 500, 17),
(18, 'npc17@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Hamradioforall', 500, 18),
(19, 'npc18@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Jeanluc', 500, 19),
(20, 'npc19@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Thetmm', 500, 20),
(21, 'npc20@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Pony', 500, 21),
(22, 'npc21@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Yacketysax', 500, 22),
(23, 'npc22@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Twentytwo', 500, 23),
(24, 'npc23@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Pinhead', 500, 24),
(25, 'npc24@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Sonata', 500, 25),
(26, 'npc25@series-v.com', 'e61578c78dd7dfa1b2938688da1ed3a3', 'Fifi', 500, 26);

-- --------------------------------------------------------

--
-- Table structure for table `player_logins`
--

CREATE TABLE `player_logins` (
  `login_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `location` varchar(128) COLLATE latin1_general_ci NOT NULL,
  `datetimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `player_points`
--

CREATE TABLE `player_points` (
  `player_points_id` bigint(20) NOT NULL,
  `player_id` int(11) NOT NULL,
  `app_pointtype_id` int(11) NOT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sector`
--

CREATE TABLE `sector` (
  `sector_id` int(11) NOT NULL,
  `xloc` int(11) NOT NULL,
  `yloc` int(11) NOT NULL,
  `zloc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sector`
--

INSERT INTO `sector` (`sector_id`, `xloc`, `yloc`, `zloc`) VALUES
(1, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_emails`
--
ALTER TABLE `app_emails`
  ADD PRIMARY KEY (`app_email_id`);

--
-- Indexes for table `app_game`
--
ALTER TABLE `app_game`
  ADD PRIMARY KEY (`app_game_id`);

--
-- Indexes for table `app_help`
--
ALTER TABLE `app_help`
  ADD PRIMARY KEY (`app_help_id`);

--
-- Indexes for table `app_pointtype`
--
ALTER TABLE `app_pointtype`
  ADD PRIMARY KEY (`app_pointtype_id`);

--
-- Indexes for table `app_ship_names`
--
ALTER TABLE `app_ship_names`
  ADD PRIMARY KEY (`ship_name`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `itemtypeid` (`item_type_id`),
  ADD KEY `sector_id` (`sector_id`);

--
-- Indexes for table `item_asteroids`
--
ALTER TABLE `item_asteroids`
  ADD PRIMARY KEY (`item_asteroid_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `item_barges`
--
ALTER TABLE `item_barges`
  ADD PRIMARY KEY (`item_barge_id`),
  ADD KEY `item_barges_ibfk_1` (`item_id`);

--
-- Indexes for table `item_beacons`
--
ALTER TABLE `item_beacons`
  ADD PRIMARY KEY (`item_beacon_id`),
  ADD KEY `item_beacons_ibfk_1` (`item_id`);

--
-- Indexes for table `item_beacon_activations`
--
ALTER TABLE `item_beacon_activations`
  ADD PRIMARY KEY (`item_beacon_activation_id`);

--
-- Indexes for table `item_beacon_debris`
--
ALTER TABLE `item_beacon_debris`
  ADD PRIMARY KEY (`beacon_debris_id`),
  ADD KEY `item_beacon_debris_ibfk_1` (`item_id`);

--
-- Indexes for table `item_comets`
--
ALTER TABLE `item_comets`
  ADD PRIMARY KEY (`item_comet_id`),
  ADD KEY `item_comets_ibfk_1` (`item_id`);

--
-- Indexes for table `item_composites`
--
ALTER TABLE `item_composites`
  ADD PRIMARY KEY (`item_composite_id`),
  ADD KEY `item_composites_ibfk_1` (`item_id`);

--
-- Indexes for table `item_cosmic_dusts`
--
ALTER TABLE `item_cosmic_dusts`
  ADD PRIMARY KEY (`item_cosmic-dust_id`),
  ADD KEY `item_cosmic_dusts_ibfk_1` (`item_id`);

--
-- Indexes for table `item_fuel_rods`
--
ALTER TABLE `item_fuel_rods`
  ADD PRIMARY KEY (`item_fuelrod_id`),
  ADD KEY `item_fuel_rods_ibfk_1` (`item_id`);

--
-- Indexes for table `item_magnetic_fields`
--
ALTER TABLE `item_magnetic_fields`
  ADD PRIMARY KEY (`item_magnetic-field_id`),
  ADD KEY `item_magnetic_fields_ibfk_1` (`item_id`);

--
-- Indexes for table `item_ships`
--
ALTER TABLE `item_ships`
  ADD PRIMARY KEY (`item_ship_id`),
  ADD KEY `item_ships_ibfk_1` (`item_id`);

--
-- Indexes for table `item_ship_debris`
--
ALTER TABLE `item_ship_debris`
  ADD PRIMARY KEY (`ship_debris_id`),
  ADD KEY `item_ship_debris_ibfk_1` (`item_id`);

--
-- Indexes for table `item_types`
--
ALTER TABLE `item_types`
  ADD PRIMARY KEY (`item_type_id`);

--
-- Indexes for table `item_wormholes`
--
ALTER TABLE `item_wormholes`
  ADD PRIMARY KEY (`item_wormhole_id`),
  ADD KEY `item_wormholes_ibfk_1` (`item_id`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`player_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `alias` (`alias`),
  ADD KEY `player_ibfk_1` (`item_id`);

--
-- Indexes for table `player_logins`
--
ALTER TABLE `player_logins`
  ADD PRIMARY KEY (`login_id`),
  ADD KEY `player_logins_ibfk_1` (`player_id`);

--
-- Indexes for table `player_points`
--
ALTER TABLE `player_points`
  ADD PRIMARY KEY (`player_points_id`),
  ADD KEY `player_points_ibfk_1` (`player_id`);

--
-- Indexes for table `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`sector_id`),
  ADD UNIQUE KEY `xloc` (`xloc`,`yloc`,`zloc`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_help`
--
ALTER TABLE `app_help`
  MODIFY `app_help_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `app_pointtype`
--
ALTER TABLE `app_pointtype`
  MODIFY `app_pointtype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1152;

--
-- AUTO_INCREMENT for table `item_asteroids`
--
ALTER TABLE `item_asteroids`
  MODIFY `item_asteroid_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_barges`
--
ALTER TABLE `item_barges`
  MODIFY `item_barge_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_beacons`
--
ALTER TABLE `item_beacons`
  MODIFY `item_beacon_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_beacon_activations`
--
ALTER TABLE `item_beacon_activations`
  MODIFY `item_beacon_activation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_beacon_debris`
--
ALTER TABLE `item_beacon_debris`
  MODIFY `beacon_debris_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_comets`
--
ALTER TABLE `item_comets`
  MODIFY `item_comet_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_composites`
--
ALTER TABLE `item_composites`
  MODIFY `item_composite_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_cosmic_dusts`
--
ALTER TABLE `item_cosmic_dusts`
  MODIFY `item_cosmic-dust_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_fuel_rods`
--
ALTER TABLE `item_fuel_rods`
  MODIFY `item_fuelrod_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `item_magnetic_fields`
--
ALTER TABLE `item_magnetic_fields`
  MODIFY `item_magnetic-field_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_ships`
--
ALTER TABLE `item_ships`
  MODIFY `item_ship_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `item_ship_debris`
--
ALTER TABLE `item_ship_debris`
  MODIFY `ship_debris_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_types`
--
ALTER TABLE `item_types`
  MODIFY `item_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `item_wormholes`
--
ALTER TABLE `item_wormholes`
  MODIFY `item_wormhole_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `player_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `player_logins`
--
ALTER TABLE `player_logins`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player_points`
--
ALTER TABLE `player_points`
  MODIFY `player_points_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sector`
--
ALTER TABLE `sector`
  MODIFY `sector_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`item_type_id`) REFERENCES `item_types` (`item_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`sector_id`) REFERENCES `sector` (`sector_id`);

--
-- Constraints for table `item_asteroids`
--
ALTER TABLE `item_asteroids`
  ADD CONSTRAINT `item_asteroids_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `item_barges`
--
ALTER TABLE `item_barges`
  ADD CONSTRAINT `item_barges_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `item_beacons`
--
ALTER TABLE `item_beacons`
  ADD CONSTRAINT `item_beacons_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `item_beacon_debris`
--
ALTER TABLE `item_beacon_debris`
  ADD CONSTRAINT `item_beacon_debris_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `item_comets`
--
ALTER TABLE `item_comets`
  ADD CONSTRAINT `item_comets_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `item_composites`
--
ALTER TABLE `item_composites`
  ADD CONSTRAINT `item_composites_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `item_cosmic_dusts`
--
ALTER TABLE `item_cosmic_dusts`
  ADD CONSTRAINT `item_cosmic_dusts_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `item_fuel_rods`
--
ALTER TABLE `item_fuel_rods`
  ADD CONSTRAINT `item_fuel_rods_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `item_magnetic_fields`
--
ALTER TABLE `item_magnetic_fields`
  ADD CONSTRAINT `item_magnetic_fields_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `item_ships`
--
ALTER TABLE `item_ships`
  ADD CONSTRAINT `item_ships_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_ship_debris`
--
ALTER TABLE `item_ship_debris`
  ADD CONSTRAINT `item_ship_debris_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `item_wormholes`
--
ALTER TABLE `item_wormholes`
  ADD CONSTRAINT `item_wormholes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `player_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON UPDATE CASCADE;

--
-- Constraints for table `player_logins`
--
ALTER TABLE `player_logins`
  ADD CONSTRAINT `player_logins_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `player` (`player_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `player_points`
--
ALTER TABLE `player_points`
  ADD CONSTRAINT `player_points_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `player` (`player_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
