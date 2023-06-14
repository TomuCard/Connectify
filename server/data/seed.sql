BEGIN;

-- sudo mysql -u root
-- CREATE DATABASE connectify;
-- use connectify
-- SHOW tables;
-- SELECT * from `group`;

-- CREATE USER 'connectify' IDENTIFIED BY 'connectify';
-- GRANT ALL PRIVILEGES ON connectify.* TO 'connectify' WITH GRANT OPTION;
-- FLUSH PRIVILEGES;

-- exit

-- cd server

-- Linux :
-- mysql -u connectify  -p connectify  < ./data/table.sql
-- mysql -u connectify  -p connectify  < ./data/seed.sql

-- Windows :
-- type .\data\table.sql | mysql -u connectify -p connectify   
-- type .\data\seed.sql | mysql -u connectify -p connectify


INSERT INTO `group` (
`name`,
`description`,
`status`

) VALUES (
    'test group',
    'une déscription',
    'public'
), (
    'test group 2',
    'une déscription 2',
    'privés'
);

INSERT INTO `role` (`name`) 
VALUES ('élève'), ('prof'), ('admin'), ('membre');

INSERT INTO `page` (
`name`,
`banner`,
`picture`

) VALUES (
    'NEWS',
    'banner url',
    'picture url'
);

INSERT INTO `rubric` (
    `title`,
    `content`,
    `picture`,
    `banner`,
    `page_id`
) VALUES (
    'JOURNAL DE L''ECOLE',
    'Contenu du journal',
    'picture url',
    'banner url',
    1
), (
    'HETIC EN FORCE',
    'Description d''HETIC EN FORCE',
    'picture url',
    'banner url',
    1
);

INSERT INTO `promo` (
    `promo_name`,
    `page_id`,
    `group_id`,
    `promo_description`
) VALUES (
    'PROMO WEB1 P2025',
    1,
    1,
    'Description de la promo'
);

INSERT INTO `user` (
`firstname`,
`lastname`,
`mail`,
`password`,
`username`,
`picture`,
`banner`,
`active`,
`role_id`,
`promo_id`,
`description`

) VALUES (
    'VANDAL',
    'William',
    'williamvandal@gmail.com',
    'JELEPEMD',
    'vandal.william',
    'profile picture url',
    'banner url',
    TRUE,
    1,
    1,
    'Vandal William élève à Hétic âgé de 30 ans souhaitant se lancer..'
), (
    'YALMAN',
    'Lucas',
    'lucasylm@gmail.com',
    'mLDKe+30',
    'lucasylm',
    'profile picture url',
    'banner url',
    TRUE,
    1,
    1,
    'Yalman Lucas élève à Hétic âgé de 18 ans souhaitant se lancer..'
);

INSERT INTO `connect` (
    `user_id`,
    `friend_id`

) VALUES ( 
    1,
    2
);

INSERT INTO `post` (
    `user_id`,
    `title`,
    `content`,
    `picture`

) VALUES (
    1,
    "Carnaval du printemps !",
    "Nouvelle et dernière journée du carnaval d'Hetic !",
    "picture url"
);

INSERT INTO `publication` (
`title`,
`content`,
`picture`,
`author_id`,
`group_id`

) VALUES (
    'Photo de classe',
    'photo réalisée par : Jean Charles',
    'picture url',
    2,
    1
);

INSERT INTO `comment` (
`comment_content`,
`user_id`,
`publication_id`

) VALUES (
    'Superbe article rédigé par moi-même !',
    1,
    1
);

INSERT INTO `member` (
`group_id`,
`user_id`,
`role_id`

) VALUES (
    1,
    1,
    3
);

INSERT INTO `role_page` (
`user_id`,
`role_id`

) VALUES (
    1,
    3
);

INSERT INTO `private_message` (
`message_content`,
`transmitter_id`,
`receiver_id`

) VALUES (
    'contenu du message',
    2,
    1
);

INSERT INTO `group_message` (
`message_content`,
`transmitter_id`,
`group_id`

) VALUES (
    'contenu du message',
    1,
    1
);


COMMIT;