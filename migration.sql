CREATE TABLE IF NOT EXISTS contacts (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(60) NOT NULL,
    last_name VARCHAR(60) NOT NULL
    ) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contact_phone_numbers (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    contact_id INT(6),
    phone_number VARCHAR(60),
    INDEX con_ind (contact_id),
    FOREIGN KEY (contact_id) REFERENCES contacts(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;