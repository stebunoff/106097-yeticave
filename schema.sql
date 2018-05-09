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
	author_id INT,
	winner_id INT,
	category_id INT,
	UNIQUE KEY image (image),
	FULLTEXT KEY title_and_description (title, description),
	KEY category (category_id)
);
CREATE TABLE bids (
	id INT AUTO_INCREMENT PRIMARY KEY,
	date DATETIME,
	bid INT,
	author_id INT,
	lot_id INT,
	KEY author (author_id)
);
CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	reg_date DATETIME,
	email CHAR(150),
	password CHAR(255),
	name CHAR(128),
	contacts VARCHAR(2500),
	avatar CHAR(255),
	UNIQUE KEY email (email)
);