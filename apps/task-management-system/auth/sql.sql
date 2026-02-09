create TABLE users
(
    id int(6) unsigned AUTO_INCREMENT PRIMARY KEY,
    username varchar(500) not null,
    password varchar(500) not null
)

INSERT INTO users (username,password) values ('admin','password')