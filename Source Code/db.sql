SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE IF NOT EXISTS `Person` (
	`person_id` INT NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(45) NOT NULL,
	`fullname` VARCHAR(45),
	`password` VARCHAR(45) NOT NULL,
	`email` VARCHAR(128) NOT NULL,
	PRIMARY KEY(`person_id`),
	UNIQUE(`username`),
	UNIQUE(`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `Admin` (
	`admin_id` INT NOT NULL,
	PRIMARY KEY(`admin_id`),
	FOREIGN KEY(`admin_id`) REFERENCES `Person`(`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `Person` (`username`, `fullname`, `password`, `email`) VALUES
('admin_reis', 'Admin Reis', 'admin12345', 'admin1@musicholics.com'),
('admin_reyiz', 'Admin Reyiz', 'admin54321', 'admin2@musicholics.com');
INSERT INTO `Admin` (`admin_id`) VALUES
(1),
(2);


CREATE TABLE IF NOT EXISTS `User` (
	`user_id` INT NOT NULL,
	`country` VARCHAR(45),
	`language` VARCHAR(45),
	`picture` VARCHAR(1024),
	`date_of_registration` DATE,
	`membership_type` VARCHAR(30),
	`birthday` DATE,
	`gender` VARCHAR(10),
	`budget` FLOAT(8, 3),
	PRIMARY KEY(`user_id`),
	FOREIGN KEY(`user_id`) REFERENCES `Person`(`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `Person` (`username`, `fullname`, `password`, `email`) VALUES
('m', 'Metehan Kaya', 'm', 'm.kaya@ug.bilkent.edu.tr'),
('mvbasaran', 'Mirac Vuslat Basaran', 'mvbasaran12345', 'mv.basaran@ug.bilkent.edu.tr'),
('ecakir', 'Ezgi Cakir', 'ecakir12345', 'e.cakir@ug.bilkent.edu.tr'),
('eayaz', 'Esra Ayaz', 'eayaz12345', 'e.ayaz@ug.bilkent.edu.tr'),
('okarakas', 'Omer Karakas', 'okarakas12345', 'o.karakas@ug.bilkent.edu.tr');
INSERT INTO `User` (`user_id`, `country`, `language`, `picture`, `date_of_registration`, `membership_type`, `birthday`, `gender`, `budget`) VALUES
(3, 'Turkey', 'Turkish', NULL, '2018-05-01', 'normal', '1996-01-02', 'male', '10.000'),
(4, 'Turkey', 'Turkish', NULL, '2018-05-02', 'premium', '1996-01-03', 'male', '20.000'),
(5, 'Turkey', 'Turkish', NULL, '2018-05-03', 'artist', '1996-01-04', 'female', '30.000'),
(6, 'Turkey', 'Turkish', NULL, '2018-05-04', 'premium-artist', '1996-01-05', 'female', '40.000'),
(7, 'Germany', 'German', NULL, '2018-05-05', 'premium', '1996-01-06', 'male', '50.000');


CREATE TABLE IF NOT EXISTS `publisher` (
`publisher_id` INT NOT NULL AUTO_INCREMENT,
`publisher_name` VARCHAR(45) NOT NULL UNIQUE,
`country` VARCHAR(45) NULL,
`city` VARCHAR(45) NULL,
PRIMARY KEY(`publisher_id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `publisher`(`publisher_name`, `country`, `city`) VALUES 
('pubAnka', 'Turkey', 'Ankara'),
('pubIst', 'Turkey', 'Istanbul'),
('pubLon', 'England', 'London'),
('pubBer', 'Germany', 'Berlin'),
('pubDub', 'Ireland', 'Dublin');


CREATE TABLE IF NOT EXISTS `album` (
`album_id` INT NOT NULL AUTO_INCREMENT,
`album_name` VARCHAR(45) NOT NULL,
`picture` VARCHAR(1024),
`album_type` VARCHAR(40) ,
`published_date` DATE NOT NULL,
`publisher_id` INT NOT NULL,
PRIMARY KEY(`album_id`),
FOREIGN KEY(`publisher_id`) REFERENCES `publisher`(`publisher_id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `album`(`album_name`, `picture`, `album_type`, `published_date`, `publisher_id`) VALUES 
('Ahde Vefa', NULL, 'album', '2015-10-03', 2),
('Musaadenizle Cocuklar', NULL, 'album', '1995-10-03', 1),
('Takatalvi', NULL, 'album', '2010-12-23', 5),
('Deluxe', NULL, 'album', '2017-02-14', 3),
('Evolve', NULL, 'album', '2017-10-03', 4),
('Kainat Sustu', NULL, 'album', '2016-08-06', 1),
('Best Of', NULL, 'album', '2017-10-03', 3),
('So Real', NULL, 'single', '1994-05-21', 4),
('25', NULL, 'single', '1945-10-03', 5),
('Haziranda Olmek Zor', NULL, 'album', '1994-10-03', 1),
('Shape Of You', NULL, 'single', '2014-03-01', 2);


CREATE TABLE IF NOT EXISTS `artist` (
`artist_id` INT NOT NULL AUTO_INCREMENT,
`artist_name` VARCHAR(45) NOT NULL,
`description` VARCHAR(2048),
`picture` VARCHAR(1024),
PRIMARY KEY(`artist_id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `artist`(`artist_name`, `description`, `picture`) VALUES
('Tarkan', 'Megastar', NULL),
('Baris Manco', 'Incredible Musician', NULL),
('Sonata Artica', 'Lovely Singer', NULL),
('Julia Stone', 'Great Voice', NULL),
('Imagine Dragons', 'Nice Group', NULL),
('Can Bonomo', 'Pariticipated in Eurovision', NULL),
('Beatles', 'Old but Gold', NULL),
('Oscar and The Wolf', 'Different', NULL),
('Adele', 'Strong voice', NULL),
('Group Yorum', 'Listen carefully', NULL),
('Ed Sheeran', 'Orange boy', NULL);


CREATE TABLE IF NOT EXISTS `track` (
`track_id` INT NOT NULL AUTO_INCREMENT,
`track_name` VARCHAR(45) NOT NULL,
`recording_type` VARCHAR(30),
`duration` TIME NOT NULL,
`danceability` FLOAT(4,3),
`acousticness` FLOAT(4,3),
`instrumentalness` FLOAT(4,3),
`speechness` FLOAT(4,3),
`balance` FLOAT(4,3),
`loudness` FLOAT(4,3),
`language` VARCHAR(45),
`price` FLOAT (6,3) NOT NULL,
`date_of_addition` DATE NOT NULL,
`album_id` INT NOT NULL,
PRIMARY KEY(`track_id`),
FOREIGN KEY(`album_id`) REFERENCES `album`(`album_id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `track`(`track_name`, `recording_type`, `duration`, `danceability`, `acousticness`, `instrumentalness`, 
`speechness`, `balance`, `loudness`, `language`, `price`, `date_of_addition`, `album_id`) VALUES
('Veda Busesi', 'studio', "00:02:34", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'Turkish', '001.15'
, '2012-12-03', 1),
('Kadehinde Zehir Olsa', 'studio', "00:03:21", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'Turkish', '001.15'
, '2012-12-03', 1),
('Alla Beni Pulla Beni', 'studio', "00:03:23", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'Turkish', '001.15'
, '1991-12-03', 2),
('Hal Hal', 'studio', "00:03:25", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'Turkish', '001.15'
, '1991-12-03', 2),
('Shy', 'live', "00:03:12", '0001.200' , '0001.100','0001.100','0001.100','0001.100','0001.100', 'English', '003.45'
, '2005-12-03', 3),
('Grizzly Bear', 'studio', "00:04:32", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'English', '001.15'
, '2015-12-03', 4),
('Just A Boy', 'studio', "00:03:14", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'English', '001.15'
, '2015-12-03', 4),
('Its Time', 'studio', "00:04:13", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'English', '001.15'
, '2013-12-03', 5),
('Thunder', 'studio', "00:03:42", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'English', '001.15'
, '2013-12-03', 5),
('Demons', 'studio', "00:03:30", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'English', '001.15'
, '2013-12-03', 5),
('Iyi ki Dogdun', 'studio', "00:02:34", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'Turkish', '001.15'
, '1973-12-03', 6),
('Yan', 'studio', "00:03:34", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'Turkish', '001.15'
, '1973-12-03', 6),
('Tastamam', 'studio', "00:04:31", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'Turkish', '001.15'
, '1973-12-03', 6),
('Let It Be', 'studio', "00:03:37", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'English', '001.15'
, '1982-12-03', 7),
('Yesterday', 'studio', "00:02:42", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'English', '001.15'
, '1982-12-03', 7),
('Breathing', 'studio', "00:02:53", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'English', '001.15'
, '2014-12-03', 8),
('Hello', 'live', "00:03:41", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'English', '001.15'
, '2012-12-03', 9),
('Rolling in the Deep', 'studio', "00:04:21", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'English', '001.15'
, '2012-12-03', 9),
('Berivan', 'studio', "00:03:12", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'Turkish', '001.15'
, '2007-12-03', 10),
('Filistin Gunlugu', 'studio', "00:03:52", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'Turkish', '001.15'
, '2007-12-03', 10),
('Shape Of You', 'studio', "00:03:43", '0001.100', '0001.100','0001.100','0001.100','0001.100','0001.100', 'Englis', '001.15'
, '2016-12-03', 10);


CREATE TABLE IF NOT EXISTS `album_belongs_to_artist` (
`artist_id` INT NOT NULL,
`album_id` INT NOT NULL,
PRIMARY KEY(`artist_id`, `album_id`),
FOREIGN KEY(`artist_id`) REFERENCES `artist`(`artist_id`),
FOREIGN KEY(`album_id`) REFERENCES `album`(`album_id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `album_belongs_to_artist`(`artist_id`,`album_id`) VALUES
(1,1),
(2,2),
(3,3),
(4,4),
(5,5),
(6,6),
(7,7),
(8,8),
(9,9),
(10,10),
(11,11);


CREATE TABLE IF NOT EXISTS `playlist` (
`playlist_id` INT NOT NULL AUTO_INCREMENT,
`playlist_name` VARCHAR(45) NOT NULL,
`description` VARCHAR(2048),
`picture` VARCHAR(1024),
`creator_id` INT NOT NULL,
`date` DATE NOT NULL,
PRIMARY KEY(`playlist_id`),
FOREIGN KEY(`creator_id`) REFERENCES user(`user_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `playlist`(`playlist_name`, `description`,`picture`,  `creator_id`, `date`) VALUES
('golibiciler', 'mixed list', NULL, 3, '2015-02-19'),
('siccak', '', NULL, 3, '2014-12-19'),
('songs for lovers', 'only lovers', NULL, 4 , '2015-08-19'),
('patlamalique', 'halaystep gibi anadolulu', NULL, 5 , '2017-06-23'),
('study with piano tunes', 'relaxing tracks', NULL, 6 , '2011-03-04');


CREATE TABLE IF NOT EXISTS `added` (
`playlist_id` INT NOT NULL,
`track_id` INT NOT NULL,
`date` DATE NOT NULL,
PRIMARY KEY(`playlist_id`, `track_id`),
FOREIGN KEY(`track_id`) REFERENCES `track`(`track_id`),
FOREIGN KEY(`playlist_id`) REFERENCES `playlist`(`playlist_id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `added`(`playlist_id`, `track_id`, `date`) VALUES 
(1,1,'2018-01-23'),
(1,4,'2018-01-23'),
(1,7,'2018-01-23'),
(1,10,'2018-01-23'),
(2,2,'2018-01-23'),
(2,3,'2018-01-23'),
(2,4,'2014-04-23'),
(3,19,'2018-01-23'),
(3,18,'2014-05-23'),
(5,14,'2011-01-23'),
(5,16,'2012-01-23'),
(5,3,'2018-01-23'),
(5,20,'2018-01-23');


CREATE TABLE IF NOT EXISTS `Buys` (
	`user_id` INT NOT NULL,
	`track_id` INT NOT NULL,
	PRIMARY KEY(`user_id`, `track_id`),
	FOREIGN KEY(`user_id`) REFERENCES `User`(`user_id`),
	FOREIGN KEY(`track_id`) REFERENCES `Track`(`track_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `Buys` (`user_id`, `track_id`) VALUES
(3,  1),
(3,  2),
(3,  3),
(3,  4),
(3,  7),
(3, 11),
(3, 14),
(3, 19),
(4,  3),
(4,  8),
(4,  9),
(4, 12),
(4, 15),
(4, 20),
(5,  2),
(5,  7),
(5, 10),
(5, 11),
(5, 14),
(5, 19),
(5, 20),
(6,  1),
(6,  6),
(6, 10),
(6, 14),
(6, 18),
(6, 19),
(7,  1),
(7,  8),
(7, 14),
(7, 16);


CREATE TABLE IF NOT EXISTS `Gift` (
	`giver_id` INT NOT NULL,
	`receiver_id` INT NOT NULL,
	`track_id` INT NOT NULL,
	PRIMARY KEY(`giver_id`, `receiver_id`, `track_id`),
	FOREIGN KEY(`giver_id`) REFERENCES `User`(`user_id`),
	FOREIGN KEY(`receiver_id`) REFERENCES `User`(`user_id`),
	FOREIGN KEY(`track_id`) REFERENCES `Track`(`track_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `Gift` (`giver_id`, `receiver_id`, `track_id`) VALUES
(3, 4, 14),
(4, 3, 12),
(4, 7, 13),
(5, 3, 20),
(6, 4, 18),
(7, 5, 16);


CREATE TABLE IF NOT EXISTS `Listens` (
	`user_id` INT NOT NULL,
	`track_id` INT NOT NULL,
	`date` TIMESTAMP NOT NULL,
	PRIMARY KEY(`user_id`, `track_id`, `date`),
	FOREIGN KEY(`user_id`) REFERENCES `User`(`user_id`),
	FOREIGN KEY(`track_id`) REFERENCES `Track`(`track_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `Listens` (`user_id`, `track_id`, `date`) VALUES
(4,  1, '2018-05-01 20:05:25'),
(4,  2, '2018-05-02 20:05:25'),
(4,  3, '2018-05-03 20:05:25'),
(4,  4, '2018-05-04 20:05:25'),
(4,  4, '2018-05-05 20:05:25'),
(4,  3, '2018-05-06 20:05:25'),
(4,  1, '2018-05-07 20:07:14'),
(4,  12, '2018-05-07 20:07:14'),
(4,  13, '2018-05-07 20:07:14'),
(3,  4, '2018-05-10 20:10:37'),
(3,  7, '2018-05-10 20:14:42'),
(3, 11, '2018-05-10 20:18:14'),
(3, 14, '2018-05-10 20:21:45'),
(3, 19, '2018-05-10 20:29:30'),
(3, 19, '2018-05-10 20:35:14'),
(4,  3, '2018-05-10 21:03:27'),
(4,  8, '2018-05-10 21:06:39'),
(4, 12, '2018-05-10 21:10:42'),
(4, 15, '2018-05-10 21:14:17'),
(4, 20, '2018-05-10 21:18:42'),
(4, 15, '2018-05-10 21:22:14'),
(5,  2, '2018-05-11 18:05:42'),
(5,  7, '2018-05-11 18:11:30'),
(5, 10, '2018-05-11 18:14:42'),
(5, 14, '2018-05-11 18:19:21'),
(5, 19, '2018-05-11 18:26:13'),
(5, 11, '2018-05-11 18:32:40'),
(6,  1, '2018-05-11 19:04:30'),
(6,  6, '2018-05-11 19:11:42'),
(6, 10, '2018-05-11 19:13:14'),
(6, 14, '2018-05-11 19:20:40'),
(6, 18, '2018-05-11 19:24:05'),
(7,  1, '2018-05-12 17:04:40'),
(7,  8, '2018-05-12 17:10:02'),
(7, 16, '2018-05-12 17:14:30');


CREATE TABLE IF NOT EXISTS `Bans` (
	`user_id` INT NOT NULL,
	`admin_id` INT NOT NULL,
	PRIMARY KEY(`user_id`),
	FOREIGN KEY(`user_id`) REFERENCES `User`(`user_id`),
	FOREIGN KEY(`admin_id`) REFERENCES `Admin`(`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `Bans` (`user_id`, `admin_id`) VALUES
(7, 1);


CREATE TABLE IF NOT EXISTS `Follows` (
	`user_id` INT NOT NULL,
	`playlist_id` INT NOT NULL,
	PRIMARY KEY(`user_id`, `playlist_id`) ,
	FOREIGN KEY(`user_id`) REFERENCES `User`(`user_id`),
	FOREIGN KEY(`playlist_id`) REFERENCES `Playlist`(`playlist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `Follows` (`user_id`, `playlist_id`) VALUES
(3, 3),
(3, 5),
(4, 1),
(4, 2),
(6, 2),
(7, 3),
(7, 4);

CREATE TABLE IF NOT EXISTS `Collaborates` (
	`user_id` INT NOT NULL,
	`playlist_id` INT NOT NULL,
	PRIMARY KEY(`user_id`, `playlist_id`) ,
	FOREIGN KEY(`user_id`) REFERENCES `User`(`user_id`),
	FOREIGN KEY(`playlist_id`) REFERENCES `Playlist`(`playlist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `Collaborates` (`user_id`, `playlist_id`) VALUES
(4, 2),
(3, 3),
(5, 3);


CREATE TABLE IF NOT EXISTS `rates` (
`user_id` INT NOT NULL,
`playlist_id` INT NOT NULL,
`rate` INT NOT NULL,
PRIMARY KEY(`user_id`, `playlist_id`),
FOREIGN KEY(`user_id`) REFERENCES `user`(`user_id`),
FOREIGN KEY(`playlist_id`) REFERENCES `playlist`(`playlist_id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `rates`(`user_id`, `playlist_id`, `rate`) VALUES
(4,1,3),
(5,1,1),
(3,2,1),
(6,3,4);


CREATE TABLE IF NOT EXISTS `comments` (
`comment_id` INT NOT NULL AUTO_INCREMENT,
`user_id` INT NOT NULL,
`playlist_id` INT NOT NULL,
`comment` VARCHAR(2048) NOT NULL,
`date` TIMESTAMP NOT NULL,
PRIMARY KEY(`comment_id`) ,
FOREIGN KEY(`user_id`) REFERENCES `user`(`user_id`),
FOREIGN KEY(`playlist_id`) REFERENCES `playlist`(`playlist_id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `comments`(`user_id`, `playlist_id`, `comment`, `date`) VALUES
(3,3,'I REALLY LIKED.' , '2018-04-21 21:11:01'),
(5,1,'I DONT LIKED.' , '2017-04-21 12:00:01'),
(3,4,'I want to colleborate.' , '2016-04-21 02:00:01'),
(6,1,'Thanks for this list.' , '2018-04-21 13:45:01');


CREATE TABLE IF NOT EXISTS `friendship` (
`user1_id` INT NOT NULL,
`user2_id` INT NOT NULL,
PRIMARY KEY(`user1_id`, `user2_id`) ,
FOREIGN KEY(`user1_id`) REFERENCES `user`(`user_id`),
FOREIGN KEY(`user2_id`) REFERENCES `user`(`user_id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `friendship` VALUES 
(3,4),
(5,4);


CREATE TABLE IF NOT EXISTS `blocks` (
`blocker_id` INT NOT NULL,
`blocked_id` INT NOT NULL,
PRIMARY KEY(`blocker_id`, `blocked_id`) ,
FOREIGN KEY(`blocker_id`) REFERENCES `user`(`user_id`),
FOREIGN KEY(`blocked_id`) REFERENCES `user`(`user_id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `blocks` VALUES 
(6,3);


CREATE TABLE IF NOT EXISTS `sends_message` (
`message_id` INT NOT NULL AUTO_INCREMENT,
`sender_id` INT NOT NULL,
`receiver_id` INT NOT NULL,
`date` TIMESTAMP NOT NULL,
`message` VARCHAR(2048) NOT NULL,
PRIMARY KEY(`message_id`) ,
FOREIGN KEY(`sender_id`) REFERENCES `user`(`user_id`),
FOREIGN KEY(`receiver_id`) REFERENCES `user`(`user_id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `sends_message`(`sender_id`, `receiver_id`, `date`, `message`) VALUES 
(3,4, '2017-03-14 12:11:01', 'Hi, how are you?'),
(4,3, '2017-03-15 01:11:01', 'It is not you business.'),
(5,4, '2015-03-15 01:22:01', 'Follow my lists.'),
(4,5 , '2015-04-15 11:03:01', 'No you follow.');


CREATE TABLE IF NOT EXISTS `posts` (
`post_id` INT NOT NULL AUTO_INCREMENT,
`writer_id` INT NOT NULL,
`receiver_id` INT NOT NULL,
`date` TIMESTAMP NOT NULL,
`post` VARCHAR(2048) NOT NULL,
PRIMARY KEY(`post_id`) ,
FOREIGN KEY(`writer_id`) REFERENCES `user`(`user_id`),
FOREIGN KEY(`receiver_id`) REFERENCES `user`(`user_id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `posts`(`writer_id`, `receiver_id`, `date`, `post`) VALUES 
(3,4, '2017-03-14 12:11:01', 'I like your photograph.'),
(4,5, '2012-03-10 22:00:01' , 'Please add you songs.');



DELIMITER $$
CREATE PROCEDURE DeleteTrack(IN trackId INT)
BEGIN
	DELETE FROM Added WHERE track_id = trackId;
	DELETE FROM Buys WHERE track_id = trackId;
	DELETE FROM Gift WHERE track_id = trackId;
	DELETE FROM Listens WHERE track_id = trackId;
	DELETE FROM Track WHERE track_id = trackId;
END
$$

CREATE PROCEDURE DeleteAlbum(IN albumId INT)
BEGIN
	DECLARE done INT DEFAULT FALSE;
	DECLARE i INT;
	DECLARE cur_tracks CURSOR FOR SELECT track_id FROM TRACK WHERE album_id = albumId;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	DELETE FROM Album_Belongs_To_Artist WHERE album_id = albumId;
	OPEN cur_tracks;
	track_loop: LOOP
		FETCH cur_tracks INTO i;
		IF done THEN
			LEAVE track_loop;
		END IF;
		CALL DeleteTrack(i);
	END LOOP;
	CLOSE cur_tracks;
	DELETE FROM Album WHERE album_id = albumId;

END
$$

CREATE PROCEDURE DeleteAlbumFromArtist(IN albumId INT, IN artistId INT)
BEGIN
	DECLARE numElements INT;
	DELETE FROM Album_Belongs_To_Artist WHERE album_id = albumId AND artist_id = artistId;
	SET numElements =( SELECT COUNT(*) FROM Album_Belongs_To_Artist WHERE album_id = albumId);
	IF numElements = 0 THEN CALL DeleteAlbum(albumId);
	END IF;
END
$$

CREATE PROCEDURE DeleteArtist(IN artistId INT)
BEGIN
	DECLARE done INT DEFAULT FALSE;
	DECLARE i INT;
	DECLARE cur_albums CURSOR FOR SELECT album_id FROM Album_Belongs_To_Artist WHERE artist_id = artistId;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	OPEN cur_albums;
	album_loop: LOOP
		FETCH cur_albums INTO i;
		IF done THEN
			LEAVE album_loop;
		END IF;
		CALL DeleteAlbumFromArtist(i, artistId);
	END LOOP;
	CLOSE cur_albums;

	DELETE FROM Artist WHERE artist_id = artistId;
END
$$

CREATE PROCEDURE DeletePublisher(IN publisherId INT)
BEGIN
	DECLARE done INT DEFAULT FALSE;
	DECLARE i INT;
	DECLARE cur_albums CURSOR FOR SELECT album_id FROM Album WHERE publisher_id = publisherId;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	OPEN cur_albums;
	album_loop: LOOP
		FETCH cur_albums INTO i;
		IF done THEN
			LEAVE album_loop;
		END IF;
		CALL DeleteAlbum(i);
	END LOOP;
	CLOSE cur_albums;

	DELETE FROM Publisher WHERE publisher_id = publisherId;
END
$$

DELIMITER ;


COMMIT;