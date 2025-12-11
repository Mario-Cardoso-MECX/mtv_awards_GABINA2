-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 11-12-2025 a las 04:37:04
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mtv_awardsgaby`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albumes`
--

DROP TABLE IF EXISTS `albumes`;
CREATE TABLE IF NOT EXISTS `albumes` (
  `estatus_album` tinyint DEFAULT '0' COMMENT '0: Deshabilitado, 1: Habilitado',
  `fecha_lanzamiento_album` date NOT NULL,
  `id_album` int NOT NULL AUTO_INCREMENT,
  `titulo_album` varchar(50) NOT NULL,
  `descripcion_album` text COMMENT 'El artista aún no ha presentado su biografía',
  `imagen_album` varchar(200) DEFAULT NULL,
  `id_artista` int NOT NULL,
  `id_genero` int NOT NULL,
  PRIMARY KEY (`id_album`),
  KEY `id_artista` (`id_artista`),
  KEY `id_genero` (`id_genero`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `albumes`
--

INSERT INTO `albumes` (`estatus_album`, `fecha_lanzamiento_album`, `id_album`, `titulo_album`, `descripcion_album`, `imagen_album`, `id_artista`, `id_genero`) VALUES
(1, '2020-05-10', 1, 'Luz de Luna', 'Debut de Luna Pop', 'covers/luna_luz.jpg', 1, 1),
(1, '2018-09-20', 2, 'Drive Through', 'Álbum potente de Stone Drive', 'covers/stone_drive.jpg', 2, 2),
(1, '2021-03-01', 3, 'Rap City', 'Ritmos y rimas de MC Flow', 'covers/rap_city.jpg', 3, 3),
(1, '2019-07-15', 4, 'Ritmo y Calle', 'Éxitos de baile urbano', 'covers/ritmo_calle.jpg', 4, 4),
(1, '2017-02-14', 5, 'Amor & Acordes', 'Bachata para corazones', 'covers/amor_acordes.jpg', 5, 5),
(1, '2022-11-01', 6, 'Voces del Pueblo', 'Corridos contemporáneos', 'covers/voces_pueblo.jpg', 6, 6),
(1, '2023-06-30', 7, 'Trap Nights', 'Beats y melodías nocturnas', 'covers/trap_nights.jpg', 7, 7),
(1, '2016-08-05', 8, 'Wave', 'R&B íntimo y moderno', 'covers/wave.jpg', 8, 8),
(1, '2024-01-20', 9, 'Pulse', 'Pistas electrónicas para pista', 'covers/pulse.jpg', 9, 9),
(1, '2015-04-10', 10, 'Sunny Days', 'Melodías indie para el alma', 'covers/sunny_days.jpg', 10, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artistas`
--

DROP TABLE IF EXISTS `artistas`;
CREATE TABLE IF NOT EXISTS `artistas` (
  `estatus_artista` tinyint DEFAULT '0' COMMENT '0: Deshabilitado, 1: Habilitado',
  `id_artista` int NOT NULL AUTO_INCREMENT,
  `pseudonimo_artista` varchar(50) NOT NULL,
  `nacionalidad_artista` varchar(100) NOT NULL,
  `biografia_artista` text COMMENT 'El artista aún no ha presentado su biografía',
  `id_usuario` int NOT NULL,
  `id_genero` int NOT NULL,
  PRIMARY KEY (`id_artista`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_genero` (`id_genero`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `artistas`
--

INSERT INTO `artistas` (`estatus_artista`, `id_artista`, `pseudonimo_artista`, `nacionalidad_artista`, `biografia_artista`, `id_usuario`, `id_genero`) VALUES
(1, 1, 'Luna Pop', 'México', 'Pop juvenil con toques electrónicos', 2, 1),
(1, 2, 'Stone Drive', 'USA', 'Rock alternativo y energía en vivo', 3, 2),
(1, 3, 'MC Flow', 'Chile', 'Hip Hop con lírica urbana', 4, 3),
(1, 4, 'Ritmo Calle', 'Puerto Rico', 'Reguetón con baile y ritmo', 5, 4),
(1, 5, 'Corazón de Bachata', 'República Dominicana', 'Bachata romántica moderna', 6, 5),
(1, 6, 'Sierra Norte', 'México', 'Corridos con influencia regional', 7, 6),
(1, 7, 'TrapStar', 'Colombia', 'Trap melódico y beats modernos', 8, 7),
(1, 8, 'SoulWave', 'USA', 'R&B contemporáneo y vocales suaves', 9, 8),
(1, 9, 'ElectroPulse', 'Alemania', 'Electrónica bailable y experimental', 10, 9),
(1, 10, 'IndieSun', 'Reino Unido', 'Indie alternativo con guitarras claras', 11, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canciones`
--

DROP TABLE IF EXISTS `canciones`;
CREATE TABLE IF NOT EXISTS `canciones` (
  `estatus_cancion` tinyint DEFAULT '0' COMMENT '0: Deshabilitado, 1: Habilitado',
  `id_acancion` int NOT NULL AUTO_INCREMENT,
  `nombre_cancion` varchar(50) NOT NULL,
  `fecha_lanzamiento_cancion` date DEFAULT NULL,
  `duracion_cancion` time NOT NULL,
  `mp3_cancion` varchar(200) DEFAULT NULL,
  `url_cancion` varchar(200) DEFAULT NULL,
  `url_video_cancion` varchar(200) DEFAULT NULL,
  `id_artista` int NOT NULL,
  `id_genero` int NOT NULL,
  `id_album` int NOT NULL,
  PRIMARY KEY (`id_acancion`),
  KEY `id_artista` (`id_artista`),
  KEY `id_genero` (`id_genero`),
  KEY `id_album` (`id_album`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `canciones`
--

INSERT INTO `canciones` (`estatus_cancion`, `id_acancion`, `nombre_cancion`, `fecha_lanzamiento_cancion`, `duracion_cancion`, `mp3_cancion`, `url_cancion`, `url_video_cancion`, `id_artista`, `id_genero`, `id_album`) VALUES
(0, 1, 'Quiero Verte', '2020-05-10', '00:03:25', NULL, 'https://open.spotify.com/track/example_luna', 'https://www.youtube.com/watch?v=example_luna', 1, 1, 1),
(0, 2, 'Highway Roar', '2018-09-20', '00:04:02', NULL, 'https://open.spotify.com/track/example_stone', 'https://www.youtube.com/watch?v=example_stone', 2, 2, 2),
(0, 3, 'City Lights', '2021-03-01', '00:03:45', NULL, 'https://open.spotify.com/track/example_flow', 'https://www.youtube.com/watch?v=example_flow', 3, 3, 3),
(0, 4, 'Baila Conmigo', '2019-07-15', '00:02:58', NULL, 'https://open.spotify.com/track/example_ritmo', 'https://www.youtube.com/watch?v=example_ritmo', 4, 4, 4),
(0, 5, 'Corazón Sincero', '2017-02-14', '00:04:12', NULL, 'https://open.spotify.com/track/example_bachata', 'https://www.youtube.com/watch?v=example_bachata', 5, 5, 5),
(0, 6, 'Tierra y Voz', '2022-11-01', '00:03:55', NULL, 'https://open.spotify.com/track/example_corridos', 'https://www.youtube.com/watch?v=example_corridos', 6, 6, 6),
(0, 7, 'Noche de Oro', '2023-06-30', '00:03:30', NULL, 'https://open.spotify.com/track/example_trap', 'https://www.youtube.com/watch?v=example_trap', 7, 7, 7),
(0, 8, 'Sweet Whisper', '2016-08-05', '00:03:20', NULL, 'https://open.spotify.com/track/example_rnb', 'https://www.youtube.com/watch?v=example_rnb', 8, 8, 8),
(0, 9, 'Beat Instinct', '2024-01-20', '00:05:00', NULL, 'https://open.spotify.com/track/example_elec', 'https://www.youtube.com/watch?v=example_elec', 9, 9, 9),
(0, 10, 'Golden Afternoon', '2015-04-10', '00:03:10', NULL, 'https://open.spotify.com/track/example_indie', 'https://www.youtube.com/watch?v=example_indie', 10, 10, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_nominaciones`
--

DROP TABLE IF EXISTS `categorias_nominaciones`;
CREATE TABLE IF NOT EXISTS `categorias_nominaciones` (
  `id_categoria_nominacion` int NOT NULL AUTO_INCREMENT,
  `estatus_categoria_nominacion` tinyint(1) DEFAULT '1',
  `fecha_categoria_nominacion` date DEFAULT (curdate()),
  `nombre_categoria_nominacion` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion_categoria_nominacion` text COLLATE utf8mb4_general_ci NOT NULL,
  `contador_nominacion` int DEFAULT '0',
  PRIMARY KEY (`id_categoria_nominacion`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias_nominaciones`
--

INSERT INTO `categorias_nominaciones` (`id_categoria_nominacion`, `estatus_categoria_nominacion`, `fecha_categoria_nominacion`, `nombre_categoria_nominacion`, `descripcion_categoria_nominacion`, `contador_nominacion`) VALUES
(1, 1, '2025-12-10', 'Álbum del Año', 'Mejor álbum del año', 0),
(2, 1, '2025-12-10', 'Canción del Año', 'Mejor canción del año', 0),
(3, 1, '2025-12-10', 'Artista Revelación', 'Artista nuevo con mayor impacto', 0),
(4, 1, '2025-12-10', 'Mejor Colaboración', 'Mejor colaboración entre artistas', 0),
(5, 1, '2025-12-10', 'Video Musical del Año', 'Mejor video musical', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

DROP TABLE IF EXISTS `generos`;
CREATE TABLE IF NOT EXISTS `generos` (
  `estatus_genero` tinyint DEFAULT '0' COMMENT '0: Deshabilitado, 1: Habilitado',
  `id_genero` int NOT NULL AUTO_INCREMENT,
  `nombre_genero` varchar(50) NOT NULL,
  PRIMARY KEY (`id_genero`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`estatus_genero`, `id_genero`, `nombre_genero`) VALUES
(1, 1, 'Pop'),
(1, 2, 'Rock'),
(1, 3, 'Hip Hop'),
(1, 4, 'Reguetón'),
(1, 5, 'Bachata'),
(1, 6, 'Corridos'),
(1, 7, 'Trap'),
(1, 8, 'R&B'),
(1, 9, 'Electrónica'),
(1, 10, 'Indie');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nominaciones`
--

DROP TABLE IF EXISTS `nominaciones`;
CREATE TABLE IF NOT EXISTS `nominaciones` (
  `id_nominacion` int NOT NULL AUTO_INCREMENT,
  `fecha_nominacion` date DEFAULT (curdate()),
  `id_categoria_nominacion` int NOT NULL,
  `id_album` int NOT NULL,
  `id_artista` int NOT NULL,
  PRIMARY KEY (`id_nominacion`),
  KEY `fk_nominaciones_categorias` (`id_categoria_nominacion`),
  KEY `fk_nominaciones_albumes` (`id_album`),
  KEY `fk_nominaciones_artistas` (`id_artista`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nominaciones`
--

INSERT INTO `nominaciones` (`id_nominacion`, `fecha_nominacion`, `id_categoria_nominacion`, `id_album`, `id_artista`) VALUES
(1, '2025-12-10', 1, 1, 1),
(2, '2025-12-10', 2, 2, 2),
(3, '2025-12-10', 3, 3, 3),
(4, '2025-12-10', 4, 4, 4),
(5, '2025-12-10', 5, 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
CREATE TABLE IF NOT EXISTS `notificaciones` (
  `id_notificacion` int NOT NULL AUTO_INCREMENT,
  `id_artista` int NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `mensaje` text NOT NULL,
  `leido` tinyint(1) DEFAULT '0',
  `creado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_notificacion`),
  KEY `id_artista` (`id_artista`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id_rol` int NOT NULL AUTO_INCREMENT,
  `rol` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`) VALUES
(4, 'Audiencia'),
(8, 'Operador'),
(85, 'Artista'),
(128, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `estatus_usuario` tinyint DEFAULT '0' COMMENT '0: Deshabilitado, 1: Habilitado',
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(50) NOT NULL,
  `ap_usuario` varchar(50) NOT NULL,
  `am_usuario` varchar(50) DEFAULT NULL,
  `sexo_usuario` tinyint NOT NULL COMMENT '0: Femenino, 1: Masculino',
  `correo_usuario` varchar(50) DEFAULT NULL,
  `password_usuario` varchar(64) DEFAULT NULL,
  `imagen_usuario` varchar(200) DEFAULT NULL,
  `id_rol` int NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `id_rol` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`estatus_usuario`, `id_usuario`, `nombre_usuario`, `ap_usuario`, `am_usuario`, `sexo_usuario`, `correo_usuario`, `password_usuario`, `imagen_usuario`, `id_rol`) VALUES
(1, 1, 'Admin', 'Sistema', 'Root', 1, 'admin@mtvawards.local', '0bc01fae70b5e73eabb266178092ea42dfddd9657c903b22210913821ad86261', NULL, 128),
(1, 2, 'Artista1', 'Pérez', 'Gómez', 1, 'artista1@mtvawards.local', 'dc97e6870d52e05d21521a65b303aae923da568e1c7521bb632b155bbc311290', NULL, 85),
(1, 3, 'Artista2', 'López', 'Martínez', 0, 'artista2@mtvawards.local', 'f9dfb05e2b6cb005acac1d3fadb855b61a3e464f4797028c030549e5ebdcafe7', NULL, 85),
(1, 4, 'Artista3', 'García', 'Ruiz', 1, 'artista3@mtvawards.local', 'aefd76456bbbf50c99f9610b82bb115538bf5a5db7650a96ec2e2ee307e2e618', NULL, 85),
(1, 5, 'Artista4', 'Hernández', 'Soto', 0, 'artista4@mtvawards.local', '4caac0a99cd19e27e171ff8ed8b645a57678a4504b33250df65d678b4deadf27', NULL, 85),
(1, 6, 'Artista5', 'Ramírez', 'Ortega', 1, 'artista5@mtvawards.local', '2ea947226d5203ea32e6718b9a5af23009db0feaf4649d36869cf2ef2cd6c391', NULL, 85),
(1, 7, 'Artista6', 'Vargas', 'Cruz', 0, 'artista6@mtvawards.local', '67a0a0740e5b877de34c5fb53ace128a3b239253b9b1899ad38ac1d17695bf78', NULL, 85),
(1, 8, 'Artista7', 'Mendoza', 'Diaz', 1, 'artista7@mtvawards.local', 'fa996c706e2cc45f46e22ee18a2a80a73f40dc5a75cb761678364ed54c8d11c8', NULL, 85),
(1, 9, 'Artista8', 'Gil', 'Navarro', 0, 'artista8@mtvawards.local', '6ad1f67b05b2dbb7c4b457358adcd1ae214259f1fefaa527f05ba64e8eeb2b7c', NULL, 85),
(1, 10, 'Artista9', 'Soto', 'Castillo', 1, 'artista9@mtvawards.local', 'f438eae21054c360e0f9fcc3fed0b3c0bc71a312ea170ef74a4b851c0bb6dab1', NULL, 85),
(1, 11, 'Artista10', 'Ruiz', 'Pacheco', 0, 'artista10@mtvawards.local', 'd134ce02e49e605e879b753ed3d7dd8880eb488f1504c58f565fa20f9c735c49', NULL, 85),
(1, 12, 'Operador', 'Sistema', 'Op', 1, 'operador@mtvawards.local', 'e257b110509437aaceddbd342bc63d05e74221d6bac056ed279d752ff8d3afcb', NULL, 8),
(1, 13, 'Luis', 'Ramírez', 'González', 1, 'luis@mtvawards.local', '80fe84c1c77a84b29419f2320fa1bbb42a1ac08448511242379629f408a14d49', NULL, 4),
(1, 14, 'María', 'Fernández', 'López', 0, 'maria@mtvawards.local', '80fe84c1c77a84b29419f2320fa1bbb42a1ac08448511242379629f408a14d49', NULL, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votaciones`
--

DROP TABLE IF EXISTS `votaciones`;
CREATE TABLE IF NOT EXISTS `votaciones` (
  `fecha_creacion_votacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_votacion` int NOT NULL AUTO_INCREMENT,
  `id_artista` int NOT NULL,
  `id_album` int NOT NULL,
  `id_nominacion` int NOT NULL,
  `id_usuario` int NOT NULL,
  `ip_votante` varchar(45) DEFAULT NULL,
  `ua_votante` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_votacion`),
  KEY `id_artista` (`id_artista`),
  KEY `id_album` (`id_album`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `votaciones`
--

INSERT INTO `votaciones` (`fecha_creacion_votacion`, `id_votacion`, `id_artista`, `id_album`, `id_nominacion`, `id_usuario`, `ip_votante`, `ua_votante`) VALUES
('2025-12-11 04:00:18', 1, 1, 1, 1, 13, NULL, NULL),
('2025-12-11 04:00:18', 2, 1, 1, 1, 14, NULL, NULL),
('2025-12-11 04:00:18', 3, 1, 1, 1, 12, NULL, NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `albumes`
--
ALTER TABLE `albumes`
  ADD CONSTRAINT `albumes_ibfk_1` FOREIGN KEY (`id_artista`) REFERENCES `artistas` (`id_artista`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `albumes_ibfk_2` FOREIGN KEY (`id_genero`) REFERENCES `generos` (`id_genero`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `artistas`
--
ALTER TABLE `artistas`
  ADD CONSTRAINT `artistas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `artistas_ibfk_2` FOREIGN KEY (`id_genero`) REFERENCES `generos` (`id_genero`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `canciones`
--
ALTER TABLE `canciones`
  ADD CONSTRAINT `canciones_ibfk_1` FOREIGN KEY (`id_artista`) REFERENCES `artistas` (`id_artista`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `canciones_ibfk_2` FOREIGN KEY (`id_genero`) REFERENCES `generos` (`id_genero`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `canciones_ibfk_3` FOREIGN KEY (`id_album`) REFERENCES `albumes` (`id_album`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `nominaciones`
--
ALTER TABLE `nominaciones`
  ADD CONSTRAINT `fk_nominaciones_albumes` FOREIGN KEY (`id_album`) REFERENCES `albumes` (`id_album`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_nominaciones_artistas` FOREIGN KEY (`id_artista`) REFERENCES `artistas` (`id_artista`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_nominaciones_categorias` FOREIGN KEY (`id_categoria_nominacion`) REFERENCES `categorias_nominaciones` (`id_categoria_nominacion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_artista`) REFERENCES `artistas` (`id_artista`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `votaciones`
--
ALTER TABLE `votaciones`
  ADD CONSTRAINT `votaciones_ibfk_1` FOREIGN KEY (`id_artista`) REFERENCES `artistas` (`id_artista`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votaciones_ibfk_2` FOREIGN KEY (`id_album`) REFERENCES `albumes` (`id_album`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votaciones_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
