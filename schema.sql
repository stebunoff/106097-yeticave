CREATE DATABASE yeticave
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;
USE yeticave;
CREATE TABLE categories (
	id INT AUTO_INCREMENT PRIMARY KEY,
	category CHAR(128)
);
CREATE TABLE lots (
	id INT AUTO_INCREMENT PRIMARY KEY,
	creation_date DATE,
	title CHAR(128),
	description CHAR(255),
	image CHAR(255),
	start_price INT,
	expire_date DATE,
	price_increment INT,
	author CHAR(128),
	winner CHAR(128),
	category CHAR(128)
);
CREATE UNIQUE INDEX image on lots(image);
CREATE INDEX category on lots(category);
CREATE INDEX title on lots(title);
CREATE INDEX description on lots(description);
CREATE TABLE bids (
	id INT AUTO_INCREMENT PRIMARY KEY,
	date DATETIME,
	bid INT,
	author CHAR(128),
	lot INT
);
CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	reg_date DATETIME,
	email CHAR(150),
	password CHAR(128),
	name CHAR(128),
	contacts TEXT
);
CREATE UNIQUE INDEX email on users(email);