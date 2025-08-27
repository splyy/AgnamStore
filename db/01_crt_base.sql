create database if not exists agnamstore character set utf8 collate utf8_unicode_ci;
use agnamstore;

grant all privileges on agnamstore.* to 'agnamstore_user'@'localhost' identified by 'secret';