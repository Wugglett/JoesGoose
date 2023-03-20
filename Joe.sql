CREATE TABLE Users {
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    mod_status ENUM('NON-MOD','MOD') NOT NULL DEFAULT 'NON-MOD',
    PRIMARY KEY(id)
};

CREATE TABLE Runs {
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    console ENUM('Xbox One', 'Xbox Series X/S', 'PC') NOT NULL,
    run_time TIME NOT NULL,
    date_completed DATE NOT NULL,
    approved ENUM('NO', 'YES') NOT NULL DEFAULT 'NO',
    FOREIGN KEY(user_id) REFERENCES(Users),
    PRIMARY KEY(id)
}