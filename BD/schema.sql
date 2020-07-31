-- ELIMINA LA BASE DE DATOS SI EXISTE
DROP DATABASE IF EXISTS inventario_francisco;

-- CREA LA BASE DE DATOS SI NO EXISTE;
CREATE DATABASE IF NOT EXISTS inventario_francisco CHARACTER SET = utf8;

-- SE USA LA BASE DE DATOS PARA PODER MANIPULAR LA BASE DE DATOS
USE inventario_francisco;

-- TABLAS NO DEPENDIENTES

DROP TABLE IF EXISTS users_system;
CREATE TABLE IF NOT EXISTS users_system (
	id_user INT UNSIGNED AUTO_INCREMENT,
    identification VARCHAR(20) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    username VARCHAR(20) NOT NULL,
    user_pass VARCHAR(100) NOT NULL,
    role ENUM('ADMIN','VENDOR') DEFAULT 'VENDOR',
    state BOOLEAN DEFAULT TRUE,
    date_created TIMESTAMP DEFAULT current_timestamp,
    
    CONSTRAINT pk_users PRIMARY KEY (id_user),
    CONSTRAINT uq_users UNIQUE INDEX (identification)
);
-- ----------------------------------------------------------------------

DROP TABLE IF EXISTS clients;
CREATE TABLE IF NOT EXISTS clients (
	id_client INT UNSIGNED AUTO_INCREMENT,
    id_user INT UNSIGNED NOT NULL,
    identification VARCHAR(20) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) DEFAULT 'NO ESPECIFICADO',
    phone_number VARCHAR(20) DEFAULT 'NO ESPECIFICADO',
    address VARCHAR(100) DEFAULT 'NO ESPECIFICADO',
    state BOOLEAN DEFAULT TRUE,
	date_created TIMESTAMP DEFAULT current_timestamp,
    last_date_update TIMESTAMP DEFAULT current_timestamp,
    
    CONSTRAINT pk_clients PRIMARY KEY (id_client),
    CONSTRAINT uq_clients UNIQUE INDEX (identification)
);

ALTER TABLE clients ADD CONSTRAINT fk_clients_users FOREIGN KEY (id_user) 
	REFERENCES users_system (id_user) 
    ON DELETE RESTRICT 
    ON UPDATE RESTRICT;
-- ----------------------------------------------------------------------

DROP TABLE IF EXISTS providers;
CREATE TABLE IF NOT EXISTS providers (
	id_provider INT UNSIGNED AUTO_INCREMENT,
    id_user INT UNSIGNED NOT NULL,
    identification VARCHAR(20) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) DEFAULT 'NO ESPECIFICADO',
    phone_number VARCHAR(20) DEFAULT 'NO ESPECIFICADO',
    address VARCHAR(100) DEFAULT 'NO ESPECIFICADO',
    state BOOLEAN DEFAULT TRUE,
	date_created TIMESTAMP DEFAULT current_timestamp,
    last_date_update TIMESTAMP DEFAULT current_timestamp,
    
    CONSTRAINT pk_providers PRIMARY KEY (id_provider),
    CONSTRAINT uq_providers UNIQUE INDEX (identification)
);

ALTER TABLE providers ADD CONSTRAINT fk_providers_users FOREIGN KEY (id_user) 
	REFERENCES users_system (id_user) 
    ON DELETE RESTRICT 
    ON UPDATE RESTRICT;
-- ----------------------------------------------------------------------

DROP TABLE IF EXISTS categories;
CREATE TABLE IF NOT EXISTS categories(
	id_category INT UNSIGNED AUTO_INCREMENT,
    id_user INT UNSIGNED NOT NULL,
    name_category VARCHAR(20) NOT NULL,
    state BOOLEAN DEFAULT TRUE,
    date_created TIMESTAMP DEFAULT current_timestamp,
    last_date_update TIMESTAMP DEFAULT current_timestamp,
    
    CONSTRAINT pk_categories PRIMARY KEY(id_category)
);

ALTER TABLE categories ADD CONSTRAINT fk_categories_users FOREIGN KEY (id_user) 
	REFERENCES users_system (id_user) 
    ON DELETE RESTRICT 
    ON UPDATE RESTRICT;
-- ----------------------------------------------------------------------

DROP TABLE IF EXISTS products;
CREATE TABLE IF NOT EXISTS products (
	id_product INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_user INT UNSIGNED NOT NULL,
    id_provider INT  UNSIGNED NOT NULL,
    id_category INT  UNSIGNED NOT NULL,
    product_name VARCHAR(50) NOT NULL,
    count INT NOT NULL,
    shop_price DECIMAL(7,2) NOT NULL,
    sale_price DECIMAL(7,2) NOT NULL,
    state BOOLEAN DEFAULT TRUE,
    date_created TIMESTAMP DEFAULT current_timestamp,
    last_date_update TIMESTAMP DEFAULT current_timestamp,
    
    CONSTRAINT pk_products PRIMARY KEY (id_product),
    CONSTRAINT uq_products UNIQUE INDEX (product_name)
);

ALTER TABLE products ADD CONSTRAINT fk_products_users FOREIGN KEY (id_user) 
	REFERENCES users_system (id_user) 
    ON DELETE RESTRICT 
    ON UPDATE RESTRICT;
ALTER TABLE products ADD CONSTRAINT fk_products_categories FOREIGN KEY (id_category) 
	REFERENCES categories (id_category) 
    ON DELETE RESTRICT 
    ON UPDATE RESTRICT;
    
ALTER TABLE products ADD CONSTRAINT fk_products_providers FOREIGN KEY (id_provider) 
	REFERENCES providers (id_provider) 
    ON DELETE RESTRICT 
    ON UPDATE RESTRICT;
-- ----------------------------------------------------------------------

DROP TABLE IF EXISTS sales;
CREATE TABLE IF NOT EXISTS sales(
	id_sale INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_user INT UNSIGNED NOT NULL,
    id_client INT UNSIGNED NOT NULL,
    price_sale INT UNSIGNED NOT NULL,
    mount_sale DECIMAL(7,2) NOT NULL,
    date_created TIMESTAMP DEFAULT current_timestamp,
    last_date_update TIMESTAMP DEFAULT current_timestamp,
    CONSTRAINT pk_sales PRIMARY KEY(id_sale)
);

ALTER TABLE sales ADD CONSTRAINT fk_sales_users FOREIGN KEY (id_user) 
	REFERENCES users_system (id_user) 
    ON DELETE RESTRICT 
    ON UPDATE RESTRICT;
    
ALTER TABLE sales ADD CONSTRAINT fk_sales_clients FOREIGN KEY (id_client) 
	REFERENCES clients (id_client) 
    ON DELETE RESTRICT 
    ON UPDATE RESTRICT;
-- ----------------------------------------------------------------------








