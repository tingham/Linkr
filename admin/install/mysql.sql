CREATE TABLE redirect_list(
	id int NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(id), 
	date varchar(30) NOT NULL,
	redir_link varchar(1000), 
	notes varchar(1000) NOT NULL,
	user varchar(30) NOT NULL
);

DESCRIBE redirect_list;

CREATE TABLE user_list(
	uid int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(uid),
	first_name varchar(30),
	last_name varchar(30) NOT NULL,
	password varchar(50) NOT NULL,
	email varchar(100) NOT NULL
);

DESCRIBE user_list;