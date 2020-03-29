CREATE DATABASE IF NOT EXISTS news_and_fun CHARACTER SET utf8 COLLATE utf8_general_ci;
USE news_and_fun;

CREATE TABLE IF NOT EXISTS users(
id            int(255) auto_increment not null,
role          varchar(50),
name          varchar(100),
surname       varchar(200),
email         varchar(255),
password      varchar(255),
created_at    datetime,
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE InnoDB;

CREATE TABLE IF NOT EXISTS tasks(
id            int(255) auto_increment not null,
user_id          int(255) not null,
rss_service          varchar(500),
description         varchar(520),
created_at    datetime,
CONSTRAINT pk_tasks PRIMARY KEY(id),
CONSTRAINT fk_task_user FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE InnoDB;

INSERT INTO users VALUES(NULL, 'ROLE_USER', 'Javier', 'Estrada', 'user1@user1.com', '$2y$12$/KpQiMmVlvKXFTCZOQxtX.rilC7/bAONlGKtJ7vZJWv/KrM9EwSbu', CURTIME());
INSERT INTO users VALUES(NULL, 'ROLE_USER', 'Miguel', 'Ruiz', 'user2@user2.com', '$2y$12$/KpQiMmVlvKXFTCZOQxtX.rilC7/bAONlGKtJ7vZJWv/KrM9EwSbu', CURTIME());
INSERT INTO users VALUES(NULL, 'ROLE_USER', 'Alvaro', 'Miranda', 'user3@user3.com', '$2y$12$/KpQiMmVlvKXFTCZOQxtX.rilC7/bAONlGKtJ7vZJWv/KrM9EwSbu', CURTIME());

INSERT INTO tasks VALUES(NULL, 1, 'Tarea 1', 'url del sitio', 'descripción del sitio', CURTIME() );
INSERT INTO tasks VALUES(NULL, 2, 'Tarea 2', 'url del sitio', 'descripción del sitio', CURTIME() );
INSERT INTO tasks VALUES(NULL, 3, 'Tarea 3', 'url del sitio', 'descripción del sitio', CURTIME() );
INSERT INTO tasks VALUES(NULL, 1, 'Tarea 4', 'url del sitio', 'descripción del sitio', CURTIME() );
