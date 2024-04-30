CREATE DATABASE rps_tournament;

USE rps_tournament;

DROP table game_rounds;
CREATE TABLE game_rounds
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    player     VARCHAR(255)                       NOT NULL,
    symbol     ENUM ('rock', 'paper', 'scissors') NOT NULL,
    player2    VARCHAR(255)                       NOT NULL,
    symbol2    ENUM ('rock', 'paper', 'scissors') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO game_rounds (id, player, symbol, player2, symbol2)
VALUES (1,'John Doe', 'rock', 'Jane Smith', 'paper'),
       (2,'Mike Johnson', 'scissors', 'Sarah Lee', 'rock'),
       (3,'William Brown', 'paper', 'William Browsn', 'paper'),
       (4,'Sarah Lee', 'rock', 'William Brown', 'paper'),
       (5,'William Brown', 'paper', 'Sarah Lee', 'rock');
