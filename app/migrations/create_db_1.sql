CREATE DATABASE handballnow CHARACTER SET=utf8mb4;

CREATE USER 'alexhornet1'@'localhost' IDENTIFIED BY 'parolamea123';
GRANT ALL PRIVILEGES ON handballnow.* TO 'alexhornet1'@'localhost';

CREATE USER 'alexhornet1'@'127.0.0.1' IDENTIFIED BY 'parolamea123';
GRANT ALL PRIVILEGES ON handballnow.* TO 'alexhornet1'@'127.0.0.1';

USE handballnow;

CREATE TABLE user_roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
)ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    last_name VARCHAR(255),
    first_name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    role_id INT NOT NULL,
    FOREIGN KEY (role_id) REFERENCES user_roles(id) ON DELETE RESTRICT
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE migrations (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(128) NOT NULL UNIQUE,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE teams(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    coach VARCHAR(255) NOT NULL,
    arena VARCHAR(255) NOT NULL,
    photo BLOB NOT NULL
)ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE players(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    age INTEGER NOT NULL,
    position VARCHAR(255) NOT NULL,
    nationality VARCHAR(255) NOT NULL,
    team_id INT NOT NULL,
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE RESTRICT
)ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE league(
    team_id INT NOT NULL PRIMARY KEY,
    ranking_position INT NOT NULL,
    points INT NOT NULL DEFAULT 0,
    goals_scored INT NOT NULL DEFAULT 0,
    goals_conceded INT NOT NULL DEFAULT 0,
    matches_played INT NOT NULL DEFAULT 0,
    wins INT NOT NULL DEFAULT 0,
    draws INT NOT NULL DEFAULT 0,
    losses INT NOT NULL DEFAULT 0,
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE RESTRICT
)ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE matches(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    date_played DATE NOT NULL,
    home_team_id INT NOT NULL,
    away_team_id INT NOT NULL,
    home_team_goals INT NOT NULL DEFAULT 0,
    away_team_goals INT NOT NULL DEFAULT 0,
    FOREIGN KEY (home_team_id) REFERENCES teams(id) ON DELETE RESTRICT,
    FOREIGN KEY (away_team_id) REFERENCES teams(id) ON DELETE RESTRICT
)ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE player_statistics(
    player_id INT NOT NULL,
    match_id INT NOT NULL,
    goals INT NOT NULL DEFAULT 0,
    assists INT NOT NULL DEFAULT 0,
    PRIMARY KEY (player_id, match_id),
    FOREIGN KEY (player_id) REFERENCES players(id) ON DELETE RESTRICT,
    FOREIGN KEY (match_id) REFERENCES matches(id) ON DELETE CASCADE
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO user_roles (name) VALUES ('admin');
INSERT INTO user_roles (name) VALUES ('user');
INSERT INTO user_roles (name) VALUES ('guest');

INSERT INTO users (username, password, last_name, first_name, email, role_id) VALUES ('adminuser', 'adminpass', 'Admin', 'Admin', 'admin@admin.com', 1);
INSERT INTO users (username, password, last_name, first_name, email, role_id) VALUES ('useruser', 'userpass', 'User', 'User', 'user@user.com', 2);

INSERT INTO teams (name, coach, arena, photo) VALUES 
('THW Kiel', 'Filip Jícha', 'Sparkassen-Arena', 'app/migrations/LOGOS/kiel.png'),
('SG Flensburg-Handewitt', 'Maik Machulla', 'Flens-Arena', 'app/migrations/LOGOS/flensburg.png'),
('Rhein-Neckar Löwen', 'Sebastian Hinze', 'SAP Arena', 'app/migrations/LOGOS/lowen.png'),
('Füchse Berlin', 'Jaron Siewert', 'Max-Schmeling-Halle', 'app/migrations/LOGOS/fuchse.png'),
('SC Magdeburg', 'Bennet Wiegert', 'GETEC Arena', 'app/migrations/LOGOS/magdeburg.png'),
('HSV Hamburg', 'Torge Greve', 'Barclays Arena', 'app/migrations/LOGOS/hamburg.png'),
('MT Melsungen', 'Roberto García Parrondo', 'Rothenbach-Halle', 'app/migrations/LOGOS/melsungen.png'),
('TBV Lemgo Lippe', 'Florian Kehrmann', 'Phoenix Contact Arena', 'app/migrations/LOGOS/lemgo.png'),
('HC Erlangen', 'Raúl Alonso', 'Arena Nürnberger Versicherung', 'app/migrations/LOGOS/erlangen.png'),
('HSG Wetzlar', 'Hrvoje Horvat', 'Rittal Arena', 'app/migrations/LOGOS/wetzlar.png'),
('Bietigheim', 'Hartmut Mayerhoffer', 'EgeTrans Arena', 'app/migrations/LOGOS/bieti.png'),
('Frisch Auf Göppingen', 'Markus Baur', 'EWS Arena', 'app/migrations/LOGOS/goppingen.png'),
('TVB 1898 Stuttgart', 'Michael Schweikardt', 'Porsche Arena', 'app/migrations/LOGOS/stuttgart.png'),
('VfL Gummersbach', 'Goran Suton', 'Schwalbe Arena', 'app/migrations/LOGOS/gummer.png'),
('TSV Hannover-Burgdorf', 'Antonio Carlos Ortega', 'Swiss Life Hall', 'app/migrations/LOGOS/hannover.png'),
('ThSV Eisenach', 'Misha Kaufmann', 'Werner-Aßmann-Halle', 'app/migrations/LOGOS/eisenach.png'),
('Leipzig', 'André Haber', 'Arena Leipzig', 'app/migrations/LOGOS/leipzig.png'),
('Potsdam', 'Daniel Deutsch', 'MBS Arena', 'app/migrations/LOGOS/potsdam.png');


INSERT INTO league (team_id) VALUES (1), (2), (3), (4), (5), (6), (7), (8), (9), (10), (11), (12), (13), (14), (15), (16), (17), (18);


DELIMITER //

CREATE TRIGGER update_league_after_insert
AFTER INSERT ON matches
FOR EACH ROW
BEGIN
    DECLARE home_team_points INT;
    DECLARE away_team_points INT;

    IF NEW.home_team_goals > NEW.away_team_goals THEN
        SET home_team_points = 3;
        SET away_team_points = 0;
    ELSEIF NEW.home_team_goals < NEW.away_team_goals THEN
        SET home_team_points = 0;
        SET away_team_points = 3;
    ELSE
        SET home_team_points = 1;
        SET away_team_points = 1;
    END IF;

    -- Actualizarea echipei gazdă
    UPDATE league
    SET 
        points = points + home_team_points,
        goals_scored = goals_scored + NEW.home_team_goals,
        goals_conceded = goals_conceded + NEW.away_team_goals,
        matches_played = matches_played + 1,
        wins = wins + IF(NEW.home_team_goals > NEW.away_team_goals, 1, 0),
        draws = draws + IF(NEW.home_team_goals = NEW.away_team_goals, 1, 0),
        losses = losses + IF(NEW.home_team_goals < NEW.away_team_goals, 1, 0)
    WHERE team_id = NEW.home_team_id;

    -- Actualizarea echipei oaspete
    UPDATE league
    SET 
        points = points + away_team_points,
        goals_scored = goals_scored + NEW.away_team_goals,
        goals_conceded = goals_conceded + NEW.home_team_goals,
        matches_played = matches_played + 1,
        wins = wins + IF(NEW.away_team_goals > NEW.home_team_goals, 1, 0),
        draws = draws + IF(NEW.away_team_goals = NEW.home_team_goals, 1, 0),
        losses = losses + IF(NEW.away_team_goals < NEW.home_team_goals, 1, 0)
    WHERE team_id = NEW.away_team_id;

    SET @rank := 0;
    UPDATE league
    SET ranking_position = (@rank := @rank + 1)
    ORDER BY points DESC, matches_played, goals_scored - goals_conceded DESC, goals_scored DESC;

END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER update_league_after_delete
AFTER DELETE ON matches
FOR EACH ROW
BEGIN
    DECLARE home_team_points INT;
    DECLARE away_team_points INT;

    -- Calcularea punctelor pentru echipa gazdă
    IF OLD.home_team_goals > OLD.away_team_goals THEN
        SET home_team_points = 3;
        SET away_team_points = 0;
    ELSEIF OLD.home_team_goals < OLD.away_team_goals THEN
        SET home_team_points = 0;
        SET away_team_points = 3;
    ELSE
        SET home_team_points = 1;
        SET away_team_points = 1;
    END IF;

    -- Actualizarea echipei gazdă
    UPDATE league
    SET 
        points = points - home_team_points,
        goals_scored = goals_scored - OLD.home_team_goals,
        goals_conceded = goals_conceded - OLD.away_team_goals,
        matches_played = matches_played - 1,
        wins = wins - IF(OLD.home_team_goals > OLD.away_team_goals, 1, 0),
        draws = draws - IF(OLD.home_team_goals = OLD.away_team_goals, 1, 0),
        losses = losses - IF(OLD.home_team_goals < OLD.away_team_goals, 1, 0)
    WHERE team_id = OLD.home_team_id;

    -- Actualizarea echipei oaspete
    UPDATE league
    SET 
        points = points - away_team_points,
        goals_scored = goals_scored - OLD.away_team_goals,
        goals_conceded = goals_conceded - OLD.home_team_goals,
        matches_played = matches_played - 1,
        wins = wins - IF(OLD.away_team_goals > OLD.home_team_goals, 1, 0),
        draws = draws - IF(OLD.away_team_goals = OLD.home_team_goals, 1, 0),
        losses = losses - IF(OLD.away_team_goals < OLD.home_team_goals, 1, 0)
    WHERE team_id = OLD.away_team_id;

    -- Actualizarea pozițiilor în clasament
    SET @rank := 0;
    UPDATE league
    SET ranking_position = (@rank := @rank + 1)
    ORDER BY points DESC, matches_played, goals_scored - goals_conceded DESC, goals_scored DESC;

END //

DELIMITER ;