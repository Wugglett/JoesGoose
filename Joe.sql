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
    run_type ENUM('One Lap', 'Three Lap') NOT NULL,
    FOREIGN KEY(user_id) REFERENCES Users(id),
    PRIMARY KEY(id)
);

CREATE TABLE Comments (
    id BIGINT NOT NULL AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    run_id BIGINT,
    comment_id BIGINT,
    content VARCHAR(255) NOT NULL,
    FOREIGN KEY(user_id) REFERENCES Users(id),
    FOREIGN KEY(run_id) REFERENCES Runs(id),
    PRIMARY KEY(id),
    CONSTRAINT require_parent_id CHECK((run_id IS NULL OR comment_id IS NULL) AND NOT (run_id IS NULL AND comment_id IS NULL)) -- Did not work need to implement later
);

CREATE TABLE Tokens (
	token VARCHAR(255) NOT NULL,
    user_id BIGINT NOT NULL
);