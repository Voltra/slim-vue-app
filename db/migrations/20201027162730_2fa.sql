-- migrate:up
CREATE TABLE 2fa(
    id int PRIMARY KEY AUTO_INCREMENT,
    user_id int UNIQUE NOT NULL,
    discriminant varchar(255) UNIQUE NOT NULL,
    latest_code varchar(255),
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
    created_at timestamp DEFAULT current_timestamp,
    updated_at timestamp
);

-- migrate:down
DROP TABLE 2fa;

