drop database if exists Nekoffe;
create database Nekoffe;

create table users (
	id int unsigned not null auto_increment primary key,
	username varchar(10) not null,
	password varchar(60) not null
);

