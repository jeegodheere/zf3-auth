CREATE TABLE album
(
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    artist VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
    updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL
);
CREATE UNIQUE INDEX album_artist_title_uindex ON album (artist, title);
CREATE TABLE category
(
    id INT(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL,
    created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
    updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL
);
CREATE TABLE friend
(
    user_id INT(10) unsigned NOT NULL,
    friend_id INT(10) unsigned NOT NULL,
    created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
    updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL
);
CREATE TABLE post
(
    id INT(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    body TEXT NOT NULL,
    author INT(10) unsigned DEFAULT '1' NOT NULL,
    created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
    updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
    CONSTRAINT posts_users_id_fk FOREIGN KEY (author) REFERENCES user (id) ON UPDATE CASCADE
);
CREATE INDEX posts_users_id_fk ON post (author);
CREATE UNIQUE INDEX post_title_uindex ON post (title);
CREATE TABLE post_category
(
    post_id INT(10) unsigned NOT NULL,
    category_id INT(10) unsigned NOT NULL,
    created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
    updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
    CONSTRAINT post_categories_posts_id_fk FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT post_categories_categories_id_fk FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE INDEX post_categories_categories_id_fk ON post_category (category_id);
CREATE UNIQUE INDEX post_categories_post_id_category_id_uindex ON post_category (post_id, category_id);
CREATE TABLE user
(
    id INT(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(80) NOT NULL,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(255),
    photo VARCHAR(255),
    role VARCHAR(50) DEFAULT 'member' NOT NULL,
    cdate TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
    mdate DATETIME
);
CREATE UNIQUE INDEX email ON user (email);