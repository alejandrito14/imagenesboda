SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `invitation_settings` (
  `id` tinyint unsigned NOT NULL DEFAULT 1,
  `bride_name` varchar(100) NOT NULL,
  `groom_name` varchar(100) NOT NULL,
  `couple_name` varchar(220) NOT NULL,
  `event_type` varchar(30) NOT NULL DEFAULT 'wedding',
  `event_label` varchar(100) NOT NULL DEFAULT 'Nuestra boda',
  `story_label` varchar(100) NOT NULL DEFAULT 'Nuestra historia',
  `story_title` varchar(180) NOT NULL DEFAULT 'Todo comenzó con un encuentro',
  `public_url` varchar(500) NOT NULL DEFAULT '',
  `preview_url` varchar(500) NOT NULL DEFAULT '',
  `event_date` date NOT NULL,
  `ceremony_time` time NOT NULL,
  `reception_time` time NOT NULL,
  `venue` varchar(180) NOT NULL,
  `address` varchar(255) NOT NULL,
  `maps_url` varchar(500) NOT NULL,
  `hero_image` varchar(500) NOT NULL,
  `venue_image` varchar(500) NOT NULL,
  `romantic_phrase` varchar(500) NOT NULL,
  `story_intro` varchar(500) NOT NULL,
  `dress_code` varchar(255) NOT NULL,
  `gift_intro` varchar(500) NOT NULL,
  `gift_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `gallery_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `upload_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `invitation_settings`
(`id`, `bride_name`, `groom_name`, `couple_name`, `event_date`, `ceremony_time`, `reception_time`, `venue`, `address`, `maps_url`, `hero_image`, `venue_image`, `romantic_phrase`, `story_intro`, `dress_code`, `gift_intro`)
VALUES
(1, 'María', 'Juan', 'Juan & María', '2026-11-15', '18:00:00', '20:00:00', 'Hacienda Los Olivos', 'Camino de los Olivos 150, México', 'https://www.google.com/maps/search/?api=1&query=Hacienda+Los+Olivos', 'imagenes/boda2.jpg', 'imagenes/boda4.jpg', 'Hay momentos que son para siempre. Queremos compartir el nuestro contigo.', 'Dos caminos, una historia y toda una vida por escribir.', 'Formal · Evita vestir de blanco', 'El mejor regalo es compartir este día contigo.')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`);

CREATE TABLE IF NOT EXISTS `invitation_story_items` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(20) NOT NULL,
  `title` varchar(180) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(500) NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `invitation_story_items` (`year`, `title`, `description`, `image`, `sort_order`)
SELECT '2019', 'Nuestro primer encuentro', 'Una coincidencia sencilla se convirtió en el inicio de nuestra historia.', 'imagenes/boda1.jpg', 1
WHERE NOT EXISTS (SELECT 1 FROM `invitation_story_items`);
INSERT INTO `invitation_story_items` (`year`, `title`, `description`, `image`, `sort_order`)
SELECT '2022', 'Nuestra primera aventura', 'Descubrimos que cualquier lugar se siente como hogar si estamos juntos.', 'imagenes/boda3.jpg', 2
WHERE (SELECT COUNT(*) FROM `invitation_story_items`) = 1;
INSERT INTO `invitation_story_items` (`year`, `title`, `description`, `image`, `sort_order`)
SELECT '2026', 'Nuestro para siempre', 'Elegimos celebrar el amor y comenzar esta nueva etapa rodeados de ustedes.', 'imagenes/boda4.jpg', 3
WHERE (SELECT COUNT(*) FROM `invitation_story_items`) = 2;

CREATE TABLE IF NOT EXISTS `invitation_gifts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(150) NOT NULL,
  `url` varchar(500) NOT NULL,
  `details` varchar(500) NOT NULL DEFAULT '',
  `sort_order` int NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `invitation_gifts` (`label`, `url`, `details`, `sort_order`)
SELECT 'Ver mesa de regalos', '#', 'Configura aquí la liga de tu mesa de regalos.', 1
WHERE NOT EXISTS (SELECT 1 FROM `invitation_gifts`);

CREATE TABLE IF NOT EXISTS `invitation_guests` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `invitation_id` tinyint unsigned NOT NULL DEFAULT 1,
  `invitation_code` varchar(50) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `guest_name` varchar(200) NOT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `guest_count` smallint unsigned NOT NULL DEFAULT 1,
  `pass_information` varchar(500) NOT NULL DEFAULT '',
  `attendance` enum('pending','yes','no') NOT NULL DEFAULT 'pending',
  `responded_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitation_code` (`invitation_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `invitation_guests` (`invitation_code`, `last_name`, `guest_name`, `guest_count`, `pass_information`)
SELECT 'BODA2026', 'Pérez', 'Familia Pérez', 2, 'Pase válido para dos personas.'
WHERE NOT EXISTS (SELECT 1 FROM `invitation_guests`);

UPDATE `modulos_menu`
SET `menu` = 'Invitación digital', `archivo` = 'vi_invitaciones.php', `ubicacion_archivo` = 'catalogos/invitaciones/', `nivel` = 1, `estatus` = 1
WHERE `idmodulos_menu` = 153;

INSERT INTO `perfiles_permisos` (`idperfiles`, `idmodulos_menu`, `insertar`, `borrar`, `modificar`)
SELECT 1, 153, 1, 1, 1
WHERE NOT EXISTS (
  SELECT 1 FROM `perfiles_permisos` WHERE `idperfiles` = 1 AND `idmodulos_menu` = 153
);
