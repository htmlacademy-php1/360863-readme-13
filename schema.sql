CREATE DATABASE IF NOT EXISTS readme
CHARACTER SET utf8
COLLATE utf8_general_ci;

USE readme;

CREATE TABLE IF NOT EXISTS `user` (
  id INT PRIMARY KEY AUTO_INCREMENT,
  created_at DATETIME NOT NULL DEFAULT NOW(),
  updated_at DATETIME NOT NULL DEFAULT NOW(),
  login VARCHAR(255) NOT NULL UNIQUE, /*в задании стоит поле логин, хотя было бы логично что имя тоже нужно*/
  email VARCHAR(255) NOT NULL UNIQUE,
  password CHAR(32) NOT NULL, /*в задании написано что нужен хэшированный пароль.*/
  avatar VARCHAR(255) NOT NULL UNIQUE,
  INDEX idx_user_username (login) /*я так понимаю что мы полю username добавили какой то индекс для быстрого поиска, а какой и где его посмотреть в самой таблице?*/
);

CREATE TABLE IF NOT EXISTS `hashtag` (
  id INT PRIMARY KEY AUTO_INCREMENT, /*тут сомневаюсь не нужно было ставить id?*/
  hashtag CHAR(32) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS `content_type` (
  id INT PRIMARY KEY AUTO_INCREMENT,
  `name` CHAR(32) NOT NULL UNIQUE,
  class CHAR(32) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS `post` (
  id INT PRIMARY KEY AUTO_INCREMENT,
  created_at DATETIME NOT NULL DEFAULT NOW(),
  updated_at DATETIME NOT NULL DEFAULT NOW(),
  title VARCHAR (90) NOT NULL,
  text MEDIUMTEXT, /*ставить ли ограничение размера если просто текстовое поле, если да, так сколько символов?*/
  quote_author VARCHAR (90),
  image VARCHAR (255) UNIQUE,
  youtube VARCHAR (255),
  website VARCHAR (255),
  views INT,
  login VARCHAR(255),
  FOREIGN KEY (login) REFERENCES `user`(login) ON DELETE CASCADE,
  content_type_name CHAR(32),
  FOREIGN KEY (content_type_name) REFERENCES content_type(`name`) ON DELETE CASCADE,
  hashtag CHAR(32),
  FOREIGN KEY (hashtag) REFERENCES hashtag(hashtag) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `comment` (
  id INT PRIMARY KEY AUTO_INCREMENT,
  created_at DATETIME NOT NULL DEFAULT NOW(),
  updated_at DATETIME NOT NULL DEFAULT NOW(),
  comment TEXT (90) NOT NULL, /* тоже не понятно какое ограничение ставить*/
  login VARCHAR(255),
  FOREIGN KEY (login) REFERENCES `user`(login) ON DELETE CASCADE,
  post_id INT,
  FOREIGN KEY (post_id) REFERENCES post(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `like` (
  id INT PRIMARY KEY AUTO_INCREMENT,
  login VARCHAR(255),
  FOREIGN KEY (login) REFERENCES `user`(login) ON DELETE CASCADE,
  post_id INT,
  FOREIGN KEY (post_id) REFERENCES post(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `subscription` (
  id INT PRIMARY KEY AUTO_INCREMENT,
  author VARCHAR(255),
  FOREIGN KEY (author) REFERENCES `user`(login) ON DELETE CASCADE,
  person_subscripted VARCHAR(255),
  FOREIGN KEY (person_subscripted) REFERENCES `user`(login) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `message` (
  id INT PRIMARY KEY AUTO_INCREMENT,
  created_at DATETIME NOT NULL DEFAULT NOW(),
  updated_at DATETIME NOT NULL DEFAULT NOW(),
  text MEDIUMTEXT NOT NULL,
  author VARCHAR(255),
  FOREIGN KEY (author) REFERENCES `user`(login) ON DELETE CASCADE,
  person_recived VARCHAR(255),
  FOREIGN KEY (person_recived) REFERENCES `user`(login) ON DELETE CASCADE
);











