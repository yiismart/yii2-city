create table if not exists `city`
(
    `id` int(10) not null auto_increment,
    `lft` int(10) not null,
    `rgt` int(10) not null,
    `depth` int(10) not null,
    `type` int(10) not null,
    `active` tinyint(1) default 1,
    `name` varchar(100) not null,
    `url` varchar(100) default null,
    primary key (`id`)
) engine InnoDB;
