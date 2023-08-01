DROP DATABASE IF EXISTS test;

CREATE DATABASE test;

USE test;

CREATE TABLE users(
    id INT auto_increment,
    username varchar(30),
    password varchar(255),
    email varchar(50),
    image_url varchar(50) default 'images/default_user.jpg',
    primary key(id),
    unique(email)
);

DESC users;
