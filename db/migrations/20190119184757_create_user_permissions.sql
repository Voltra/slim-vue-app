-- migrate:up
CREATE TABLE permissions(
	id int PRIMARY KEY AUTO_INCREMENT,
	name varchar(255) UNIQUE,
	created_at timestamp DEFAULT current_timestamp,
	updated_at timestamp
);

CREATE TABLE roles(
	id int PRIMARY KEY AUTO_INCREMENT,
	name varchar(255) UNIQUE,
	created_at timestamp DEFAULT current_timestamp,
	updated_at timestamp
);

CREATE TABLE role_permissions(
	id int PRIMARY KEY AUTO_INCREMENT,
	role_id int NOT NULL,
	permission_id int NOT NULL,
	created_at timestamp DEFAULT current_timestamp,
	updated_at timestamp,
	FOREIGN KEY(role_id) REFERENCES roles(id) ON DELETE CASCADE,
	FOREIGN KEY(permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);

CREATE TABLE user_roles(
	id int PRIMARY KEY AUTO_INCREMENT,
	user_id int NOT NULL,
	role_id int NOT NULL,
	created_at timestamp DEFAULT current_timestamp,
	updated_at timestamp,
	FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY(role_id) REFERENCES roles(id) ON DELETE CASCADE
);

CREATE TABLE admins(
	id int PRIMARY KEY AUTO_INCREMENT,
	user_id int NOT NULL,
	created_at timestamp DEFAULT current_timestamp,
	updated_at timestamp,
	FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- migrate:down
DROP TABLE admins;
DROP TABLE user_roles;
DROP TABLE role_permissions;
DROP TABLE roles;
DROP TABLE permissions;

