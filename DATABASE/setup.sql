
CREATE DATABASE db_dailygreen;
USE db_dailygreen;
--? users
CREATE TABLE participante (
    id INT PRIMARY KEY AUTOINCREMENT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(100) NOT NULL
)
CREATE TABLE 
