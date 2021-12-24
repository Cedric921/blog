CREATE TABLE post (
    id INT UNSIGNED NOT NULL AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    content TEXT(65000) NOT NULL,
    created_at DATETIME NOT NULL,
    PRIMARY KEY(id)
)

CREATE TABLE category(
    id INT UNSIGNED NOT NULL AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
)

CREATE TABLE post_category(
    post_id INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (post_id, category_id),
    CONSTRAINT fk_post
        FOREIGN KEY (post_id)
        REFERENCES post(id) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT,
    CONSTRAINT fk_categroy
        FOREIGN KEY (category_id)
        REFERENCES category(id) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT
)

CREATE TABLE user(
    id INT UNSIGNED NOT NULL AUTOINCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
)