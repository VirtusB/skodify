USE `virtusbc_skodify`;

DROP TABLE IF EXISTS `Users`;
DROP TABLE IF EXISTS `Songs`;
DROP TABLE IF EXISTS `Genres`;
DROP TABLE IF EXISTS `Artists`;
DROP TABLE IF EXISTS `Albums`;

CREATE TABLE Users (
    id int(11) AUTO_INCREMENT PRIMARY KEY,
    username nvarchar(25),
    firstName nvarchar(50),
    lastName nvarchar(50),
    email varchar(320),
    userpassword nvarchar(255),
    joined datetime,
    profilePic varchar(500)
);

CREATE TABLE Songs (
    id int(11) AUTO_INCREMENT PRIMARY KEY,
    title nvarchar(250),
    artist int(11),
    album int(11),
    genre int(11),
    duration varchar(8),
    path varchar(500),
    albumOrder int(11),
    plays int(11)
);

CREATE TABLE Genres (
    id int(11) AUTO_INCREMENT PRIMARY KEY,
    name varchar(50)
);

CREATE TABLE Artists (
    id int(11) AUTO_INCREMENT PRIMARY KEY,
    name varchar(50)
);

CREATE TABLE Albums (
    id int(11) AUTO_INCREMENT PRIMARY KEY,
    title varchar(250),
    artist int(11),
    genre int(11),
    artworkPath varchar(500)
);

CREATE TABLE Playlists (
    id int(11) AUTO_INCREMENT PRIMARY KEY,
    name varchar(50),
    owner varchar(50),
    dateCreated datetime
);

CREATE TABLE playlistSongs (
    id int(11) AUTO_INCREMENT PRIMARY KEY,
    songId int(11),
    playlistId int(11),
    playlistOrder int(11)
);

INSERT INTO Artists VALUES (NULL, 'Mickey Mouse');
INSERT INTO Artists VALUES (NULL, 'Goofy');
INSERT INTO Artists VALUES (NULL, 'Bart Simpson');
INSERT INTO Artists VALUES (NULL, 'Homer');
INSERT INTO Artists VALUES (NULL, 'Bruce Lee');
INSERT INTO Artists VALUES (NULL, '2Pac');

INSERT INTO Genres VALUES (NULL, 'Rock');
INSERT INTO Genres VALUES (NULL, 'Pop');
INSERT INTO Genres VALUES (NULL, 'Hip-Hop');
INSERT INTO Genres VALUES (NULL, 'Rap');
INSERT INTO Genres VALUES (NULL, 'R&B');
INSERT INTO Genres VALUES (NULL, 'Classical');
INSERT INTO Genres VALUES (NULL, 'Techno');
INSERT INTO Genres VALUES (NULL, 'Indie');
INSERT INTO Genres VALUES (NULL, 'Romance');
INSERT INTO Genres VALUES (NULL, 'Country');

INSERT INTO Albums VALUES (NULL, 'Bacon & Eggs', 2, 4, 'assets/images/artwork/goinghigher.jpg');
INSERT INTO Albums VALUES (NULL, 'Pizza head', 5, 10, 'assets/images/artwork/energy.jpg');
INSERT INTO Albums VALUES (NULL, 'Me Against The World', 6, 3, 'assets/images/artwork/meagainsttheworld.jpg');
INSERT INTO Albums VALUES (NULL, 'New Day', 1, 7, 'assets/images/artwork/clearday.jpg');
INSERT INTO Albums VALUES (NULL, 'Are you sure?', 5, 10, 'assets/images/artwork/popdance.jpg');
INSERT INTO Albums VALUES (NULL, 'Burger music', 2, 8, 'assets/images/artwork/ukulele.jpg');
INSERT INTO Albums VALUES (NULL, 'Trump Mixtape', 3, 2, 'assets/images/artwork/funkyelement.jpg');
INSERT INTO Albums VALUES (NULL, 'Happy Morning', 4, 5, 'assets/images/artwork/sweet.jpg');


INSERT INTO `Songs` (`id`, `title`, `artist`, `album`, `genre`, `duration`, `path`, `albumOrder`, `plays`) VALUES
(1, 'Acoustic Breeze', 1, 5, 8, '2:37', 'assets/music/bensound-acousticbreeze.mp3', 1, 0),
(2, 'A new beginning', 1, 5, 1, '2:35', 'assets/music/bensound-anewbeginning.mp3', 2, 0),
(3, 'Better Days', 1, 5, 2, '2:33', 'assets/music/bensound-betterdays.mp3', 3, 0),
(4, 'Buddy', 1, 5, 3, '2:02', 'assets/music/bensound-buddy.mp3', 4, 0),
(5, 'Clear Day', 1, 5, 4, '1:29', 'assets/music/bensound-clearday.mp3', 5, 0),
(6, 'Going Higher', 2, 1, 1, '4:04', 'assets/music/bensound-goinghigher.mp3', 1, 0),
(7, 'Funny Song', 2, 4, 2, '3:07', 'assets/music/bensound-funnysong.mp3', 2, 0),
(8, 'Funky Element', 2, 1, 3, '3:08', 'assets/music/bensound-funkyelement.mp3', 2, 0),
(9, 'Extreme Action', 2, 1, 2, '8:03', 'assets/music/bensound-extremeaction.mp3', 3, 0),
(10, 'Epic', 2, 4, 5, '2:58', 'assets/music/bensound-epic.mp3', 3, 0),
(11, 'Energy', 2, 1, 6, '2:59', 'assets/music/bensound-energy.mp3', 4, 0),
(12, 'Dubstep', 2, 1, 7, '2:03', 'assets/music/bensound-dubstep.mp3', 5, 0),
(13, 'Happiness', 3, 6, 8, '4:21', 'assets/music/bensound-happiness.mp3', 5, 0),
(14, 'Happy Rock', 3, 6, 9, '1:45', 'assets/music/bensound-happyrock.mp3', 4, 0),
(15, 'Jazzy Frenchy', 3, 6, 10, '1:44', 'assets/music/bensound-jazzyfrenchy.mp3', 3, 0),
(16, 'Little Idea', 3, 6, 1, '2:49', 'assets/music/bensound-littleidea.mp3', 2, 0),
(17, 'Memories', 3, 6, 2, '3:50', 'assets/music/bensound-memories.mp3', 1, 0),
(18, 'Moose', 4, 7, 1, '2:43', 'assets/music/bensound-moose.mp3', 5, 0),
(19, 'November', 4, 7, 2, '3:32', 'assets/music/bensound-november.mp3', 4, 0),
(20, 'Of Elias Dream', 4, 7, 3, '4:58', 'assets/music/bensound-ofeliasdream.mp3', 3, 0),
(21, 'Pop Dance', 4, 7, 2, '2:42', 'assets/music/bensound-popdance.mp3', 2, 0),
(22, 'Retro Soul', 4, 7, 5, '3:36', 'assets/music/bensound-retrosoul.mp3', 1, 0),
(23, 'Sad Day', 5, 2, 1, '2:28', 'assets/music/bensound-sadday.mp3', 1, 0),
(24, 'Sci-fi', 5, 2, 2, '4:44', 'assets/music/bensound-scifi.mp3', 2, 0),
(25, 'Slow Motion', 5, 2, 3, '3:26', 'assets/music/bensound-slowmotion.mp3', 3, 0),
(26, 'Sunny', 5, 2, 2, '2:20', 'assets/music/bensound-sunny.mp3', 4, 0),
(27, 'Sweet', 5, 2, 5, '5:07', 'assets/music/bensound-sweet.mp3', 5, 0),
(28, 'Tenderness ', 3, 2, 7, '2:03', 'assets/music/bensound-tenderness.mp3', 4, 0),
(29, 'The Lounge', 3, 2, 8, '4:16', 'assets/music/bensound-thelounge.mp3 ', 3, 0),
(30, 'Ukulele', 3, 2, 9, '2:26', 'assets/music/bensound-ukulele.mp3 ', 2, 0),
(31, 'Tomorrow', 3, 2, 1, '4:54', 'assets/music/bensound-tomorrow.mp3 ', 1, 0),
(32, 'Me Against The World', 6, 3, 4, '4:38', 'assets/music/tupac-me-against-the-world.mp3 ', 1, 0);


