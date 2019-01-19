-- migrate:up
CREATE TABLE users(
	id int PRIMARY KEY AUTO_INCREMENT,
	username varchar(60) UNIQUE NOT NULL,
	password varchar(60) NOT NULL,
	created_at timestamp DEFAULT current_timestamp,
	updated_at timestamp
);

-- migrate:down
DROP TABLE users;

