CREATE DATABASE IF NOT EXISTS readme
  CHARACTER SET utf8
  COLLATE utf8_general_ci;

USE readme;

CREATE TABLE IF NOT EXISTS `user` (
                                    id INT PRIMARY KEY AUTO_INCREMENT,
                                    created_at DATETIME NOT NULL DEFAULT NOW(),
                                    updated_at DATETIME NOT NULL DEFAULT NOW(),
                                    login VARCHAR(255) NOT NULL UNIQUE,
                                    user_name VARCHAR(255),
                                    email VARCHAR(255) NOT NULL UNIQUE,
                                    password CHAR(32) NOT NULL,
                                    avatar VARCHAR(255) UNIQUE,
                                    INDEX idx_user_username (login)
);

CREATE TABLE IF NOT EXISTS `hashtag` (
                                       id INT PRIMARY KEY AUTO_INCREMENT,
                                       hashtag VARCHAR(127) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS `content_type` (
                                            id INT PRIMARY KEY AUTO_INCREMENT,
                                            `name` VARCHAR(127) NOT NULL UNIQUE,
                                            class VARCHAR(127) NOT NULL
);

CREATE TABLE IF NOT EXISTS `posts` (
                                     id INT PRIMARY KEY AUTO_INCREMENT,
                                     title VARCHAR(90) NOT NULL,
                                     text TEXT,
                                     quote_author VARCHAR(90),
                                     image VARCHAR(255) UNIQUE,
                                     youtube VARCHAR(255),
                                     website_title VARCHAR(255),
                                     website VARCHAR(255),
                                     views INT,
                                     created_at DATETIME NOT NULL DEFAULT NOW(),
                                     updated_at DATETIME NOT NULL DEFAULT NOW(),
                                     user_id INT NOT NULL,
                                     content_type_id INT NOT NULL,
                                     FOREIGN KEY fk_post_user_id_user_id (user_id) REFERENCES `user`(id) ON DELETE CASCADE,
                                     FOREIGN KEY fk_post_content_type_id_content_type_id (content_type_id) REFERENCES content_type(id) ON DELETE CASCADE,
                                     INDEX idx_post_content_type_id (content_type_id),
                                     INDEX idx_post_content_type_id_user_id (user_id, content_type_id)
);

CREATE TABLE IF NOT EXISTS `post_hashtags` (
                                             id INT PRIMARY KEY AUTO_INCREMENT,
                                             post_id INT NOT NULL,
                                             hashtag_id INT NOT NULL,
                                             FOREIGN KEY fk_post_hashtags_post_id_post_id (post_id) REFERENCES posts(id) ON DELETE CASCADE,
                                             FOREIGN KEY fk_post_hashtags_hashtag_id_hashtag_id (hashtag_id) REFERENCES hashtag(id) ON DELETE CASCADE,
                                             INDEX idx_post_hashtags_post_id (post_id),
                                             INDEX idx_post_hashtags_hashtag_id (hashtag_id)
);

CREATE TABLE IF NOT EXISTS `comment` (
                                       id INT PRIMARY KEY AUTO_INCREMENT,
                                       created_at DATETIME NOT NULL DEFAULT NOW(),
                                       updated_at DATETIME NOT NULL DEFAULT NOW(),
                                       comment TEXT NOT NULL,
                                       user_id INT NOT NULL,
                                       post_id INT NOT NULL,
                                       FOREIGN KEY fk_comment_user_id_user_id (user_id) REFERENCES `user`(id) ON DELETE CASCADE,
                                       FOREIGN KEY fk_comment_post_id_post_id (post_id) REFERENCES posts(id) ON DELETE CASCADE,
                                       INDEX idx_comment_user_id (user_id),
                                       INDEX idx_comment_post_id (post_id)
);

CREATE TABLE IF NOT EXISTS `like` (
                                    id INT PRIMARY KEY AUTO_INCREMENT,
                                    user_id INT NOT NULL,
                                    post_id INT NOT NULL,
                                    FOREIGN KEY fk_like_user_id_user_id (user_id) REFERENCES `user`(id) ON DELETE CASCADE,
                                    FOREIGN KEY fk_like_post_id_post_id (post_id) REFERENCES posts(id) ON DELETE CASCADE,
                                    INDEX idx_like_user_id (user_id),
                                    INDEX idx_like_post_id (post_id)
);

CREATE TABLE IF NOT EXISTS `subscription` (
                                            id INT PRIMARY KEY AUTO_INCREMENT,
                                            author_id INT NOT NULL,
                                            person_subscripted_id INT NOT NULL,
                                            FOREIGN KEY fk_subscription_author_id_user_id (author_id) REFERENCES `user`(id) ON DELETE CASCADE,
                                            FOREIGN KEY fk_subscription_person_subscripted_id_user_id (person_subscripted_id) REFERENCES `user`(id) ON DELETE CASCADE,
                                            INDEX idx_subscription_author_id (author_id),
                                            INDEX idx_subscription_person_subscripted_id (person_subscripted_id)
);

CREATE TABLE IF NOT EXISTS `repost` (
                                      id INT PRIMARY KEY AUTO_INCREMENT,
                                      user_id INT NOT NULL,
                                      post_id INT NOT NULL,
                                      FOREIGN KEY fk_repost_user_id_user_id (user_id) REFERENCES `user`(id) ON DELETE CASCADE,
                                      FOREIGN KEY fk_repost_post_id_post_id (post_id) REFERENCES `posts`(id) ON DELETE CASCADE,
                                      INDEX idx_repost_user_id (user_id),
                                      INDEX idx_repost_post_id (post_id)
);

CREATE TABLE IF NOT EXISTS `message` (
                                       id INT PRIMARY KEY AUTO_INCREMENT,
                                       created_at DATETIME NOT NULL DEFAULT NOW(),
                                       updated_at DATETIME NOT NULL DEFAULT NOW(),
                                       text MEDIUMTEXT NOT NULL,
                                       author_id INT NOT NULL,
                                       person_recived_id INT NOT NULL,
                                       FOREIGN KEY fk_message_author_id_user_id (author_id) REFERENCES `user`(id) ON DELETE CASCADE,
                                       FOREIGN KEY fk_message_person_recived_id_user_id (person_recived_id) REFERENCES `user`(id) ON DELETE CASCADE,
                                       INDEX idx_message_author_id (author_id),
                                       INDEX idx_message_person_person_recived_id (person_recived_id)
);




CREATE FULLTEXT INDEX posts_ft_search ON posts(title, text);
