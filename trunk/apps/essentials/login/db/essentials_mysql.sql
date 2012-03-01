CREATE TABLE IF NOT EXISTS `ess_bit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

#bloq

CREATE TABLE IF NOT EXISTS `ess_master_tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Table name',
  `description` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Table description',
  `user_id` int(11) NOT NULL COMMENT 'User id',
  `datetime` datetime NOT NULL COMMENT 'Date of registration or update',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Maestro de tablas' AUTO_INCREMENT=1 ;

#bloq

CREATE TABLE IF NOT EXISTS `ess_master_tables_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `master_tables_id` int(11) NOT NULL COMMENT 'FK',
  `item_cod` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Code',
  `item_desc` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Description',
  `user_id` int(11) NOT NULL COMMENT 'User id',
  `datetime` datetime NOT NULL COMMENT 'Date of registration or update',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `master_tables_id` (`master_tables_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Detalle de las tablas' AUTO_INCREMENT=1 ;

#bloq

CREATE TABLE IF NOT EXISTS `ess_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `menu_id` int(11) DEFAULT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `ord` tinyint(4) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

#bloq

INSERT INTO `ess_menu` (`id`, `menu_id`, `description`, `icon`, `url`, `ord`, `usuario_id`, `datetime`) VALUES
(1, NULL, 'Administración', 'img/globe.gif', '', 5, 1, '2011-10-01 01:33:24'),
(2, 1, 'Tablas sitema', 'img/page.gif', '../admtablas/', 1, 1, '2011-08-31 15:34:12'),
(3, 1, 'Usuarios', 'img/page.gif', '../admusr/', 2, 1, '2011-08-31 15:34:54'),
(4, 1, 'Menu', 'img/page.gif', '../menu/', 3, 1, '2011-08-31 15:35:17'),
(5, 1, 'Perfiles', 'img/page.gif', '../profiles/', 4, 1, '2011-08-31 15:35:49'),
(6, NULL, 'Salir', 'img/page.gif', '../logout/', 100, 1, '2011-10-01 01:33:02'),
(7, NULL, 'Cambiar clave', 'img/page.gif', '../passwd/', 99, 1, '2011-08-31 19:01:33'),
(8, 1, 'Log de sucesos', 'img/page.gif', '../bit/', 5, 1, '2011-09-01 12:05:29'),
(9, 1, 'Usuarios Online', 'img/page.gif', '../useronline/', 6, 1, '2011-09-21 23:26:53'),
(10, NULL, 'Documentación', 'img/cd.gif', 'http://www.osezno-framework.org/doc/', 2, 1, '2011-10-01 01:33:51'),
(11, NULL, 'Demos', 'img/base.gif', 'http://www.osezno-framework.org/demos/forms1/', 3, 1, '2011-10-01 01:21:31'),
(12, NULL, 'Website', 'img/globe.gif', 'http://www.osezno-framework.org/', 1, 1, '2011-10-01 01:33:43'),
(13, NULL, 'Foro', 'img/question.gif', 'http://www.osezno-framework.org/forum/', 4, 1, '2011-10-01 01:25:41'),
(14, 1, 'Andamiaje', 'img/page.gif', '../scaffold/', 7, 1, '2012-02-02 12:00:00');

#bloq

CREATE TABLE IF NOT EXISTS `ess_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Profile name',
  `description` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Profile description',
  `user_id` int(11) NOT NULL COMMENT 'User',
  `datetime` datetime NOT NULL COMMENT 'Fecha modificacion',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Perfiles' AUTO_INCREMENT=2 ;

#bloq

INSERT INTO `ess_profiles` (`id`, `name`, `description`, `user_id`, `datetime`) VALUES
(1, 'Admin', 'Admin', 1, '2011-09-21 23:27:40');

#bloq

CREATE TABLE IF NOT EXISTS `ess_profiles_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profiles_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `profiles_id` (`profiles_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

#bloq

INSERT INTO `ess_profiles_detail` (`id`, `profiles_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14);

#bloq

CREATE TABLE IF NOT EXISTS `ess_system_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `user_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User name',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name',
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Lastname',
  `passwd` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Passwd',
  `status` enum('1','2') COLLATE utf8_unicode_ci NOT NULL COMMENT 'Status',
  `profile_id` int(11) NOT NULL COMMENT 'Proflie',
  `datetime` datetime NOT NULL COMMENT 'Date of registration or update',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `profile_id` (`profile_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Users' AUTO_INCREMENT=4 ;

#bloq

INSERT INTO `ess_system_users` (`id`, `user_name`, `name`, `lastname`, `passwd`, `status`, `profile_id`, `datetime`) VALUES
(1, 'root', 'Root', 'Root', 'b4b8daf4b8ea9d39568719e1e320076f', '1', 1, '2011-09-21 23:22:35');

#bloq

CREATE TABLE IF NOT EXISTS `ess_usronline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sesname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `filectime` time NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

#bloq

ALTER TABLE `ess_bit`
  ADD CONSTRAINT `ess_bit_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `ess_system_users` (`id`);

#bloq

ALTER TABLE `ess_master_tables`
  ADD CONSTRAINT `ess_master_tables_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ess_system_users` (`id`);

#bloq

ALTER TABLE `ess_master_tables_detail`
  ADD CONSTRAINT `ess_master_tables_detail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ess_system_users` (`id`),
  ADD CONSTRAINT `ess_master_tables_detail_ibfk_2` FOREIGN KEY (`master_tables_id`) REFERENCES `ess_master_tables` (`id`);

#bloq

ALTER TABLE `ess_menu`
  ADD CONSTRAINT `ess_menu_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `ess_system_users` (`id`),
  ADD CONSTRAINT `ess_menu_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `ess_menu` (`id`);

#bloq

ALTER TABLE `ess_profiles`
  ADD CONSTRAINT `ess_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ess_system_users` (`id`);

#bloq

ALTER TABLE `ess_profiles_detail`
  ADD CONSTRAINT `ess_profiles_detail_ibfk_1` FOREIGN KEY (`profiles_id`) REFERENCES `ess_profiles` (`id`),
  ADD CONSTRAINT `ess_profiles_detail_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `ess_menu` (`id`);

#bloq

ALTER TABLE `ess_system_users`
  ADD CONSTRAINT `ess_system_users_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `ess_profiles` (`id`);
