CREATE DATABASE rps_tournament;

USE rps_tournament;

CREATE TABLE game_rounds (
                             id INT AUTO_INCREMENT PRIMARY KEY,
                             player VARCHAR(255) NOT NULL,
                             symbol ENUM('rock', 'paper', 'scissors') NOT NULL,
                             created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO game_rounds (player, symbol)
VALUES
    ('John Doe', 'rock'),
    ('Jane Smith', 'paper'),
    ('Mike Johnson', 'scissors'),
    ('Sarah Lee', 'rock'),
    ('William Brown', 'paper'),
    ('William Browsn', 'paper');
