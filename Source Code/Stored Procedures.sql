DELIMITER $$
CREATE PROCEDURE DeleteTrack(IN trackId INT)
BEGIN
	DELETE FROM Track WHERE track_id = trackId;
	DELETE FROM Added WHERE track_id = trackId;
	DELETE FROM Buys WHERE track_id = trackId;
	DELETE FROM Gift WHERE track_id = trackId;
	DELETE FROM Listens WHERE track_id = trackId;

END
$$

CREATE PROCEDURE DeleteAlbum(IN albumId INT)
BEGIN
	DECLARE done INT DEFAULT FALSE;
	DECLARE i INT;
	DECLARE cur_tracks CURSOR FOR SELECT track_id FROM TRACK WHERE album_id = albumId;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	DELETE FROM Album_Belongs_To_Artist WHERE album_id = albumId;
	DELETE FROM Album WHERE album_id = albumId;
	OPEN cur_tracks;
	track_loop: LOOP
		FETCH cur_tracks INTO i;
		IF done THEN
			LEAVE track_loop;
		END IF;
		CALL DeleteTrack(i);
	END LOOP;
	CLOSE cur_tracks;

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
