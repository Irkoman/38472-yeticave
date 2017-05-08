CREATE DATABASE yeticave;

USE yeticave;

CREATE TABLE category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(255)
);

CREATE TABLE lot (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT,
  user_id INT,
  winner_id INT,
  date_add DATETIME,
  date_close DATETIME,
  title CHAR(255),
  description TEXT,
  image CHAR(255),
  initial_rate INT,
  rate_step INT,
  fav_count INT
);

CREATE TABLE bet (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lot_id INT,
  user_id INT,
  date_add DATETIME,
  rate INT
);

CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_add DATETIME,
  email CHAR(128),
  password CHAR(64),
  name CHAR(255),
  avatar CHAR(255),
  contact TEXT
);

CREATE INDEX title ON lot(title);
CREATE UNIQUE INDEX lot_id ON lot(id);
CREATE UNIQUE INDEX email ON user(email);
