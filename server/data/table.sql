BEGIN;

DROP TABLE IF EXISTS `group`, `role`, `page`, `rubric`, `promo`, `user`, `connect`, `post`, `publication`, `comment`, `member`, `role_page`, `private_message`, `group_message` CASCADE;

CREATE TABLE `group` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    status VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE `role` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE `page` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    banner VARCHAR(255) NOT NULL,
    picture VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE `rubric` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content VARCHAR(255) NOT NULL,
    picture VARCHAR(255) NOT NULL,
    banner VARCHAR(255) NOT NULL,
    page_id INT NOT NULL,
    FOREIGN KEY (page_id) REFERENCES `page`(id) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE `promo` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    promo_name VARCHAR(255) NOT NULL,
    page_id INT NOT NULL,   
    group_id INT NOT NULL,
    promo_description VARCHAR(255) NOT NULL,
    FOREIGN KEY (page_id) REFERENCES page(id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES `group`(id) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE `user` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(255) NOT NULL DEFAULT '',
    lastname VARCHAR(255) NOT NULL DEFAULT '',
    mail VARCHAR(255) NOT NULL DEFAULT '',
    password VARCHAR(255) NOT NULL DEFAULT '',
    username VARCHAR(255) NOT NULL DEFAULT '',
    picture VARCHAR(255) NOT NULL DEFAULT '',
    banner VARCHAR(255) NOT NULL DEFAULT '',
    active VARCHAR(255) NOT NULL DEFAULT TRUE,
    role_id INT NOT NULL DEFAULT 0,
    promo_id INT NOT NULL DEFAULT 0,
    description VARCHAR(255) NOT NULL DEFAULT '',
    FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE,
    FOREIGN KEY (promo_id) REFERENCES promo(id) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE `connect` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    friend_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (friend_id) REFERENCES user(id) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE `post` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content VARCHAR(255) NOT NULL,
    picture VARCHAR(255) NOT NULL DEFAULT '',
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE `publication` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content VARCHAR(255) NOT NULL,
    picture VARCHAR(255) NOT NULL DEFAULT '',
    author_id INT NOT NULL,
    group_id INT NOT NULL,
    FOREIGN KEY (group_id) REFERENCES `group`(id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES user(id) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE `comment` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    comment_content VARCHAR(255) NOT NULL,
    user_id INT NOT NULL,
    publication_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (publication_id) REFERENCES publication(id) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE `member` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    group_id INT NOT NULL,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    status INT NOT NULL DEFAULT 0,
    FOREIGN KEY (group_id) REFERENCES `group`(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);


CREATE TABLE `role_page` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE `private_message` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    message_content VARCHAR(255) NOT NULL DEFAULT '',
    transmitter_id INT NOT NULL,
    receiver_id INT NOT NULL,
    FOREIGN KEY (transmitter_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES user(id) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE `group_message` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    message_content VARCHAR(255) NOT NULL,
    transmitter_id INT NOT NULL,
    group_id INT NOT NULL,
    FOREIGN KEY (transmitter_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES `group`(id) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

COMMIT;