CREATE TABLE Users (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  email           VARCHAR(255) NOT NULL UNIQUE,
  name            VARCHAR(255) NOT NULL,
  hashed_password VARCHAR(255) NOT NULL
);


CREATE TABLE Tweet (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  content varchar(140) NOT NULL,
  creation_date DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES Users(id)
);


CREATE TABLE Messages (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  recipient_id INT,
  title varchar (100) NOT NULL,
  content varchar(255) NOT NULL,
  creation_date DATETIME NOT NULL,
  is_read INT,
  FOREIGN KEY (user_id) REFERENCES Users(id),
  FOREIGN KEY (recipient_id) REFERENCES Users(id)
);