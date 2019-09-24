-- ------------------------------------
-- -------- DELETE TABLES
-- ------------------------------------
DROP TABLE IF EXISTS `libraries`;
DROP TABLE IF EXISTS `shelves`;
DROP TABLE IF EXISTS `books`;
DROP TABLE IF EXISTS `chapters`;
DROP TABLE IF EXISTS `papers`;

-- ------------------------------------
-- -------- LIBRARY
-- ------------------------------------

CREATE TABLE `libraries` (
	`libraryid` int(11) NOT NULL AUTO_INCREMENT,
	`libraryname` varchar(255) UNIQUE   NOT NULL,
	`username` varchar(255)  NOT NULL,
	`password` varchar(255)  NOT NULL,
	`email` varchar(255)  NOT NULL,
	PRIMARY KEY(libraryid)
);

-- add index on the username to speedup the search when a user try to login
ALTER TABLE  `libraries` ADD INDEX ( `username`);


-- ------------------------------------
-- -------- SHELFS
-- ------------------------------------

CREATE TABLE `shelves` (
	`shelfid` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`shelfname` varchar(255)  NOT NULL,
	`libraryid` int(11) NOT NULL REFERENCES libraries(libraryid) 
);

-- add index on the forgien key
ALTER TABLE  `shelves` ADD INDEX ( `libraryid`);

-- ------------------------------------
-- -------- BOOKS
-- ------------------------------------

CREATE TABLE `books` (
	`bookid` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`bookname` varchar(255)  NOT NULL,
	`shelfid` int(11) NOT NULL REFERENCES shelfs(`shelfid`) 
);

-- add index on the forgien key
ALTER TABLE  `books` ADD INDEX (`shelfid`);

-- ------------------------------------
-- -------- CHAPTERS
-- ------------------------------------
CREATE TABLE `chapters` (
	`chapterid` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`chaptername` varchar(255)  NOT NULL,
	`chaptercontent` text,
	`bookid` int(11) NOT NULL REFERENCES books(`bookid`) 
);

-- add index on the forgien key
ALTER TABLE  `chapters` ADD INDEX (`bookid`);

-- ------------------------------------
-- -------- PAPERS
-- ------------------------------------
-- CREATE TABLE `papers` (
--	`paperid` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
--	`chapterid` int(11) NOT NULL REFERENCES chapters(`chapterid`) 
-- );

-- add index on the forgien key
-- ALTER TABLE  `papers` ADD INDEX (`chapterid`);
