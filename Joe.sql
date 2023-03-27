CREATE TABLE Users (
    id BIGINT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    mod_status ENUM('NON-MOD','MOD') NOT NULL DEFAULT 'NON-MOD',
    PRIMARY KEY(id)
);

CREATE TABLE Runs (
    id BIGINT NOT NULL AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    console ENUM('Xbox One', 'Xbox Series X/S', 'PC') NOT NULL,
    run_time INT NOT NULL,
    date_completed DATE NOT NULL,
    approved ENUM('NO', 'WAITING', 'YES') NOT NULL DEFAULT 'MAYBE',
    link VARCHAR(2083) NOT NULL,
    run_type ENUM('One Lap', 'Three Laps') NOT NULL,
    FOREIGN KEY(user_id) REFERENCES Users(id),
    PRIMARY KEY(id)
);

CREATE TABLE Tokens (
	token VARCHAR(255) NOT NULL,
    user_id BIGINT NOT NULL
);