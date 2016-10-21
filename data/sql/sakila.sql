CREATE TABLE actor
(
    actor_id SMALLINT(5) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(45) NOT NULL,
    last_name VARCHAR(45) NOT NULL,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);
CREATE INDEX idx_actor_last_name ON actor (last_name);
CREATE TABLE address
(
    address_id SMALLINT(5) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    address VARCHAR(50) NOT NULL,
    address2 VARCHAR(50),
    district VARCHAR(20) NOT NULL,
    city_id SMALLINT(5) unsigned NOT NULL,
    postal_code VARCHAR(10),
    phone VARCHAR(20) NOT NULL,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT fk_address_city FOREIGN KEY (city_id) REFERENCES city (city_id) ON UPDATE CASCADE
);
CREATE INDEX idx_fk_city_id ON address (city_id);
CREATE TABLE category
(
    category_id TINYINT(3) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(25) NOT NULL,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);
CREATE TABLE city
(
    city_id SMALLINT(5) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    city VARCHAR(50) NOT NULL,
    country_id SMALLINT(5) unsigned NOT NULL,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT fk_city_country FOREIGN KEY (country_id) REFERENCES country (country_id) ON UPDATE CASCADE
);
CREATE INDEX idx_fk_country_id ON city (country_id);
CREATE TABLE country
(
    country_id SMALLINT(5) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    country VARCHAR(50) NOT NULL,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);
CREATE TABLE customer
(
    customer_id SMALLINT(5) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    store_id TINYINT(3) unsigned NOT NULL,
    first_name VARCHAR(45) NOT NULL,
    last_name VARCHAR(45) NOT NULL,
    email VARCHAR(50),
    address_id SMALLINT(5) unsigned NOT NULL,
    active TINYINT(1) DEFAULT '1' NOT NULL,
    create_date DATETIME NOT NULL,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT fk_customer_store FOREIGN KEY (store_id) REFERENCES store (store_id) ON UPDATE CASCADE,
    CONSTRAINT fk_customer_address FOREIGN KEY (address_id) REFERENCES address (address_id) ON UPDATE CASCADE
);
CREATE INDEX idx_fk_address_id ON customer (address_id);
CREATE INDEX idx_fk_store_id ON customer (store_id);
CREATE INDEX idx_last_name ON customer (last_name);
CREATE TABLE film
(
    film_id SMALLINT(5) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    release_year YEAR(4),
    language_id TINYINT(3) unsigned NOT NULL,
    original_language_id TINYINT(3) unsigned,
    rental_duration TINYINT(3) unsigned DEFAULT '3' NOT NULL,
    rental_rate DECIMAL(4,2) DEFAULT '4.99' NOT NULL,
    length SMALLINT(5) unsigned,
    replacement_cost DECIMAL(5,2) DEFAULT '19.99' NOT NULL,
    rating ENUM('G', 'PG', 'PG-13', 'R', 'NC-17') DEFAULT 'G',
    special_features SET('Trailers', 'Commentaries', 'Deleted Scenes', 'Behind the Scenes'),
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT fk_film_language FOREIGN KEY (language_id) REFERENCES language (language_id) ON UPDATE CASCADE,
    CONSTRAINT fk_film_language_original FOREIGN KEY (original_language_id) REFERENCES language (language_id) ON UPDATE CASCADE
);
CREATE INDEX idx_fk_language_id ON film (language_id);
CREATE INDEX idx_fk_original_language_id ON film (original_language_id);
CREATE INDEX idx_title ON film (title);
CREATE TABLE film_actor
(
    actor_id SMALLINT(5) unsigned NOT NULL,
    film_id SMALLINT(5) unsigned NOT NULL,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT `PRIMARY` PRIMARY KEY (actor_id, film_id),
    CONSTRAINT fk_film_actor_actor FOREIGN KEY (actor_id) REFERENCES actor (actor_id) ON UPDATE CASCADE,
    CONSTRAINT fk_film_actor_film FOREIGN KEY (film_id) REFERENCES film (film_id) ON UPDATE CASCADE
);
CREATE INDEX idx_fk_film_id ON film_actor (film_id);
CREATE TABLE film_category
(
    film_id SMALLINT(5) unsigned NOT NULL,
    category_id TINYINT(3) unsigned NOT NULL,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT `PRIMARY` PRIMARY KEY (film_id, category_id),
    CONSTRAINT fk_film_category_film FOREIGN KEY (film_id) REFERENCES film (film_id) ON UPDATE CASCADE,
    CONSTRAINT fk_film_category_category FOREIGN KEY (category_id) REFERENCES category (category_id) ON UPDATE CASCADE
);
CREATE INDEX fk_film_category_category ON film_category (category_id);
CREATE TABLE film_text
(
    film_id SMALLINT(6) PRIMARY KEY NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT
);
CREATE INDEX idx_title_description ON film_text (title, description);
CREATE TABLE inventory
(
    inventory_id MEDIUMINT(8) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    film_id SMALLINT(5) unsigned NOT NULL,
    store_id TINYINT(3) unsigned NOT NULL,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT fk_inventory_film FOREIGN KEY (film_id) REFERENCES film (film_id) ON UPDATE CASCADE,
    CONSTRAINT fk_inventory_store FOREIGN KEY (store_id) REFERENCES store (store_id) ON UPDATE CASCADE
);
CREATE INDEX idx_fk_film_id ON inventory (film_id);
CREATE INDEX idx_store_id_film_id ON inventory (store_id, film_id);
CREATE TABLE language
(
    language_id TINYINT(3) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name CHAR(20) NOT NULL,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);
CREATE TABLE migrations
(
    migration VARCHAR(255) NOT NULL,
    batch INT(11) NOT NULL
);
CREATE TABLE password_resets
(
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL
);
CREATE INDEX password_resets_email_index ON password_resets (email);
CREATE INDEX password_resets_token_index ON password_resets (token);
CREATE TABLE payment
(
    payment_id SMALLINT(5) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    customer_id SMALLINT(5) unsigned NOT NULL,
    staff_id TINYINT(3) unsigned NOT NULL,
    rental_id INT(11),
    amount DECIMAL(5,2) NOT NULL,
    payment_date DATETIME NOT NULL,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT fk_payment_customer FOREIGN KEY (customer_id) REFERENCES customer (customer_id) ON UPDATE CASCADE,
    CONSTRAINT fk_payment_staff FOREIGN KEY (staff_id) REFERENCES staff (staff_id) ON UPDATE CASCADE,
    CONSTRAINT fk_payment_rental FOREIGN KEY (rental_id) REFERENCES rental (rental_id) ON DELETE SET NULL ON UPDATE CASCADE
);
CREATE INDEX fk_payment_rental ON payment (rental_id);
CREATE INDEX idx_fk_customer_id ON payment (customer_id);
CREATE INDEX idx_fk_staff_id ON payment (staff_id);
CREATE TABLE rental
(
    rental_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    rental_date DATETIME NOT NULL,
    inventory_id MEDIUMINT(8) unsigned NOT NULL,
    customer_id SMALLINT(5) unsigned NOT NULL,
    return_date DATETIME,
    staff_id TINYINT(3) unsigned NOT NULL,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT fk_rental_inventory FOREIGN KEY (inventory_id) REFERENCES inventory (inventory_id) ON UPDATE CASCADE,
    CONSTRAINT fk_rental_customer FOREIGN KEY (customer_id) REFERENCES customer (customer_id) ON UPDATE CASCADE,
    CONSTRAINT fk_rental_staff FOREIGN KEY (staff_id) REFERENCES staff (staff_id) ON UPDATE CASCADE
);
CREATE INDEX idx_fk_customer_id ON rental (customer_id);
CREATE INDEX idx_fk_inventory_id ON rental (inventory_id);
CREATE INDEX idx_fk_staff_id ON rental (staff_id);
CREATE UNIQUE INDEX rental_date ON rental (rental_date, inventory_id, customer_id);
CREATE TABLE staff
(
    staff_id TINYINT(3) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(45) NOT NULL,
    last_name VARCHAR(45) NOT NULL,
    address_id SMALLINT(5) unsigned NOT NULL,
    picture BLOB,
    email VARCHAR(50),
    store_id TINYINT(3) unsigned NOT NULL,
    active TINYINT(1) DEFAULT '1' NOT NULL,
    username VARCHAR(16) NOT NULL,
    password VARCHAR(40),
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT fk_staff_address FOREIGN KEY (address_id) REFERENCES address (address_id) ON UPDATE CASCADE,
    CONSTRAINT fk_staff_store FOREIGN KEY (store_id) REFERENCES store (store_id) ON UPDATE CASCADE
);
CREATE INDEX idx_fk_address_id ON staff (address_id);
CREATE INDEX idx_fk_store_id ON staff (store_id);
CREATE TABLE store
(
    store_id TINYINT(3) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    manager_staff_id TINYINT(3) unsigned NOT NULL,
    address_id SMALLINT(5) unsigned NOT NULL,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT fk_store_staff FOREIGN KEY (manager_staff_id) REFERENCES staff (staff_id) ON UPDATE CASCADE,
    CONSTRAINT fk_store_address FOREIGN KEY (address_id) REFERENCES address (address_id) ON UPDATE CASCADE
);
CREATE INDEX idx_fk_address_id ON store (address_id);
CREATE UNIQUE INDEX idx_unique_manager ON store (manager_staff_id);
CREATE TABLE users
(
    id INT(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(60) NOT NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
    updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL
);
CREATE UNIQUE INDEX users_email_unique ON users (email);
CREATE TABLE actor_info
(
    actor_id SMALLINT(5) unsigned DEFAULT '0' NOT NULL,
    first_name VARCHAR(45) NOT NULL,
    last_name VARCHAR(45) NOT NULL,
    film_info TEXT
);
CREATE TABLE customer_list
(
    ID SMALLINT(5) unsigned DEFAULT '0' NOT NULL,
    name VARCHAR(91),
    address VARCHAR(50) NOT NULL,
    `zip code` VARCHAR(10),
    phone VARCHAR(20) NOT NULL,
    city VARCHAR(50) NOT NULL,
    country VARCHAR(50) NOT NULL,
    notes VARCHAR(6) DEFAULT '' NOT NULL,
    SID TINYINT(3) unsigned NOT NULL
);
CREATE TABLE film_list
(
    FID SMALLINT(5) unsigned DEFAULT '0',
    title VARCHAR(255),
    description TEXT,
    category VARCHAR(25) NOT NULL,
    price DECIMAL(4,2) DEFAULT '4.99',
    length SMALLINT(5) unsigned,
    rating ENUM('G', 'PG', 'PG-13', 'R', 'NC-17') DEFAULT 'G',
    actors TEXT
);
CREATE TABLE nicer_but_slower_film_list
(
    FID SMALLINT(5) unsigned DEFAULT '0',
    title VARCHAR(255),
    description TEXT,
    category VARCHAR(25) NOT NULL,
    price DECIMAL(4,2) DEFAULT '4.99',
    length SMALLINT(5) unsigned,
    rating ENUM('G', 'PG', 'PG-13', 'R', 'NC-17') DEFAULT 'G',
    actors TEXT
);
CREATE TABLE sales_by_film_category
(
    category VARCHAR(25) NOT NULL,
    total_sales DECIMAL(27,2)
);
CREATE TABLE sales_by_store
(
    store VARCHAR(101),
    manager VARCHAR(91),
    total_sales DECIMAL(27,2)
);
CREATE TABLE staff_list
(
    ID TINYINT(3) unsigned DEFAULT '0' NOT NULL,
    name VARCHAR(91),
    address VARCHAR(50) NOT NULL,
    `zip code` VARCHAR(10),
    phone VARCHAR(20) NOT NULL,
    city VARCHAR(50) NOT NULL,
    country VARCHAR(50) NOT NULL,
    SID TINYINT(3) unsigned NOT NULL
);
CREATE PROCEDURE film_in_stock(p_film_id INT, p_store_id INT, p_film_count INT);
CREATE PROCEDURE film_not_in_stock(p_film_id INT, p_store_id INT, p_film_count INT);
CREATE FUNCTION get_customer_balance(p_customer_id INT, p_effective_date DATETIME) RETURNS DECIMAL;
CREATE FUNCTION inventory_held_by_customer(p_inventory_id INT) RETURNS INT;
CREATE FUNCTION inventory_in_stock(p_inventory_id INT) RETURNS TINYINT;
CREATE PROCEDURE rewards_report(min_monthly_purchases TINYINT, min_dollar_amount_purchased DECIMAL, count_rewardees INT);