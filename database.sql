CREATE DATABASE IF NOT EXISTS task_manager CHARACTER SET utf8 COLLATE utf8_general_ci;
USE task_manager;

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
title          varchar(255),
content       text,
priority         varchar(20),
hours      int(100),
created_at    datetime,
CONSTRAINT pk_tasks PRIMARY KEY(id),
CONSTRAINT fk_task_user FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE InnoDB;

INSERT INTO users VALUES(NULL, 'ROLE_USER', 'Javier', 'Estrada', 'user1@user1.com', 'pass', CURTIME());
INSERT INTO users VALUES(NULL, 'ROLE_USER', 'Miguel', 'Ruiz', 'user2@user2.com', 'pass', CURTIME());
INSERT INTO users VALUES(NULL, 'ROLE_USER', 'Alvaro', 'Miranda', 'user3@user3.com', 'pass', CURTIME());

INSERT INTO tasks VALUES(NULL, 1, 'Tarea 1', 'Contenido de prueba 1', 'high', 10, CURTIME() );
INSERT INTO tasks VALUES(NULL, 2, 'Tarea 2', 'Contenido de prueba 2', 'high', 20, CURTIME() );
INSERT INTO tasks VALUES(NULL, 3, 'Tarea 3', 'Contenido de prueba 3', 'high', 30, CURTIME() );
INSERT INTO tasks VALUES(NULL, 1, 'Tarea 4', 'Contenido de prueba 4', 'high', 40, CURTIME() );
