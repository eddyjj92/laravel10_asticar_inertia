-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-08-2023 a las 10:26:13
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asticar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configs`
--

CREATE TABLE `configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`config`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configs`
--

INSERT INTO `configs` (`id`, `descripcion`, `config`, `created_at`, `updated_at`) VALUES
(1, 'Datos Generales de la Empresa', '{\"nombre\":\"Empresa Astilleros del Caribe (ASTICAR)\",\"descripcion\":\"Construcci\\u00f3n y reparaci\\u00f3n naval, certificaci\\u00f3n y avituallamiento de balsas salvavidas, reparaci\\u00f3n y soldadura de estructuras met\\u00e1licas (acero), enrollado de motores el\\u00e9ctricos y trabajos de electricidad en embarcaciones y en la industria, conservaci\\u00f3n de superficie y trabajos de pintura, ensayos no destructivos, ultrasonido.\"}', '2023-06-08 00:42:25', '2023-06-08 16:33:03'),
(2, 'Servicios Generales', '{\"titulo\":\"Nuestros Servicios Disponibles\",\"descripcion\":\"Astillero de reparaci\\u00f3n de embarcaciones de acero y aluminio de peque\\u00f1o hasta gran porte. Cuenta con un dique flotante con capacidad para buques de hasta 100 m de eslora, 19 m de manga y 4 500 ton. Muelles apropiados y seguros para buques de hasta 60 000 dwt, Laboratorio metalogr\\u00e1fico.\",\"imagen\":\"1687213521.jpg\"}', '2023-06-08 16:46:43', '2023-06-19 22:25:21'),
(3, 'Contactos', '{\"telefonos\":\"(+53) 7214 4340, (+53) 7214 4341\",\"correos\":\"procubainfo@mincex.gob.cu\",\"direccion\":\"Calle 10 No. 512 e\\/ 5ta y 31, Playa, La Habana, Cuba\",\"redes\":{\"facebook\":\"https:\\/\\/www.facebook.com\\/www.calidad.cu\\/\",\"instagram\":null,\"twitter\":\"https:\\/\\/twitter.com\\/asticar?lang=es\"}}', '2023-06-08 19:57:30', '2023-06-20 02:01:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagens`
--

CREATE TABLE `imagens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `imagens`
--

INSERT INTO `imagens` (`id`, `imagen`, `descripcion`, `created_at`, `updated_at`) VALUES
(7, 'img6490d5e40dd83.webp', 'img6490d5e40dd83.webp', '2023-06-19 22:25:40', '2023-06-19 22:25:40'),
(8, 'img6490d5e414414.webp', 'img6490d5e414414.webp', '2023-06-19 22:25:40', '2023-06-19 22:25:40'),
(10, 'img6490d5e424a56.jpg', 'img6490d5e424a56.jpg', '2023-06-19 22:25:40', '2023-06-19 22:25:40'),
(11, 'img6490d5e4306f0.jpg', 'img6490d5e4306f0.jpg', '2023-06-19 22:25:40', '2023-06-19 22:25:40'),
(12, 'img6490d5e438e44.jpg', 'img6490d5e438e44.jpg', '2023-06-19 22:25:40', '2023-06-19 22:25:40'),
(13, 'img6490d5e45940d.png', 'img6490d5e45940d.png', '2023-06-19 22:25:40', '2023-06-19 22:25:40'),
(14, 'img6490d5e45f892.png', 'img6490d5e45f892.png', '2023-06-19 22:25:40', '2023-06-19 22:25:40'),
(15, 'img6490d5e467af7.webp', 'img6490d5e467af7.webp', '2023-06-19 22:25:40', '2023-06-19 22:25:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `persona` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asunto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensaje` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `persona`, `correo`, `asunto`, `mensaje`, `estado`, `created_at`, `updated_at`) VALUES
(6, 'dsfsdfsd', 'eddyjj92@gmail.com', 'sdfsdfsdfds', 'dfsdfsd', 1, '2023-06-22 01:26:08', '2023-06-22 01:26:41'),
(7, 'wwer', 'sdfsd@dgdf.fgf', 'sdfsdf', 'sdfsdf', 1, '2023-06-22 12:41:00', '2023-06-22 12:41:11'),
(8, 'dksfksdj', 'abash@ejfjkdf.cu', 'sdfsdfsdf', 'sdfsdf', 1, '2023-06-22 14:50:15', '2023-06-22 14:50:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2023_05_24_173142_create_images_table', 1),
(8, '2023_06_07_190631_create_configs_table', 1),
(9, '2023_06_08_215647_create_noticias_table', 1),
(11, '2023_06_13_003359_create_mensajes_table', 1),
(12, '2014_10_12_000000_create_users_table', 2),
(13, '2023_04_25_045020_create_servicios_table', 3),
(14, '2023_06_09_191223_create_permission_tables', 3),
(15, '2023_04_30_130654_create_solicitudes_table', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `noticia` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `publicado_por` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `noticia`, `publicado_por`, `imagen`, `created_at`, `updated_at`) VALUES
(4, 'Irán y Rusia implementan alianza de construcción naval', 'Teherán, 20 may (Prensa Latina) Los gobiernos de Irán y Rusia acordaron ampliar su alianza al sector de la construcción naval al crear una empresa conjunta dedicada a la adquisición y la construcción de buques mercantes, informa hoy la prensa local.\r\nEl acuerdo se enfoca en la compra y construcción de 20 embarcaciones entre las partes, lo que reafirma el compromiso con la ampliación de las relaciones comerciales y la cooperación económica entre los dos países, según reseña un despacho de la agencia iraní de noticias Fars.\r\nLa empresa conjunta de construcción naval en la región del mar Caspio, responde al cumplimiento de un acuerdo preliminar con tales fines rubricado por las partes en junio de 2022.', 'Eddy Javier Jorge Herrera', '1687217025.jpg', '2023-06-09 06:23:40', '2023-06-19 23:23:45'),
(7, 'LA CONSTRUCCIÓN NAVAL EN LA HABANA', 'Cuba ha estado ligada a la #navegación desde sus propias raíces, fue cuna de excelentes constructores y armadores de barcos.\n\nTuvo su primer florecimiento económico gracias a su ubicación geográfica y al tráfico de las flotas.\n\nLa construcción naval es la primera gran industria desarrollada en #Cuba, y puso en movimiento grandes sumas de dinero hacia La Habana durante la colonia.\n\nA mediados del siglo XVI comienza a producir #Galeones, #Galeoncetes y #Fragatas.\n\nEl puerto de La Habana y sus astilleros le dieron fama a la ciudad y a la isla.\n\nSe acarrearon materiales de toda #América para la construcción naval, y esto dio origen al primer gremio organizado de la colonia: la Sociedad de Armadores de La Habana en el siglo XVII.\n\nLa ciudad ocupó un lugar cimero solo comparable en el número de construcciones con los arsenales españoles de Cartagena, Guarnizo y El Ferrol.\n\nEstos textos pertenecen al libro “El Real Arsenal de la Habana. La construcción naval en La Habana bajo la dominación colonial española”, ensayo escrito por el historiador y arqueólogo cubano Ovidio Ortega Pereyra.', 'Eddy Javier Jorge Herrera', '1686277791.jpeg', '2023-06-09 06:29:51', '2023-06-09 06:29:51'),
(8, 'Afirman que Cuba tiene capacidad para incrementar fabricación de barcos', 'La Habana, 13 nov (ACN) Cuba podría incrementar sustancialmente la construcción de embarcaciones para el sector de la pesca, el transporte y el turismo, aseveró en esta capital Amado Galiano Ortiz, especialista de producción de la Empresa de Proyectos y Construcción Naval CEPRONA.\n\nEn la reciente Feria Internacional de La Habana,  FIHAV 2016, la entidad estuvo presente en aras de exponer sus producciones y servicios, así como contactar con empresarios locales o extranjeros en aras de fomentar alianzas que contribuyan a incrementar sus potencialidades.\n\nSegún Galiano Ortiz, especialista de Producción en CEPRONA, entre los años 2008 y 2016 solo construyeron 37 embarcaciones para la flota pesquera, de 150 previstas, para un exiguo aprovechamiento del 25 por ciento de sus capacidades.', 'Eddy Javier Jorge Herrera', '1686277834.jpeg', '2023-06-09 06:30:34', '2023-06-09 06:30:34'),
(11, 'sdfsdfsdfsdf', 'sdfsdfsdfsdf', 'Super Admin', 'publicacion.png', '2023-06-22 01:36:35', '2023-06-22 01:36:35'),
(12, 'ksjf,jsdf', 'ksdjfhjksdf', 'Super Admin', 'publicacion.png', '2023-06-22 14:48:13', '2023-06-22 14:48:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'ver-config', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(2, 'editar-config', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(3, 'ver-rol', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(4, 'crear-rol', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(5, 'editar-rol', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(6, 'eliminar-rol', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(7, 'ver-usuario', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(8, 'crear-usuario', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(9, 'editar-usuario', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(10, 'editar-usuario(perfil)', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(11, 'eliminar-usuario', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(12, 'banear-usuario', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(13, 'ver-servicio', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(14, 'crear-servicio', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(15, 'editar-servicio', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(16, 'eliminar-servicio', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(17, 'habilitar-servicio', 'web', '2023-06-20 02:07:01', '2023-06-20 02:07:01'),
(18, 'ver-solicitud(todas)', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02'),
(19, 'ver-solicitud(usuario)', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02'),
(20, 'crear-solicitud', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02'),
(21, 'editar-solicitud', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02'),
(22, 'eliminar-solicitud', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02'),
(23, 'ver-noticia', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02'),
(24, 'crear-noticia', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02'),
(25, 'editar-noticia', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02'),
(26, 'eliminar-noticia', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02'),
(27, 'ver-imagen', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02'),
(28, 'crear-imagen', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02'),
(29, 'eliminar-imagen', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02'),
(30, 'ver-mensaje', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02'),
(31, 'crear-mensaje', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02'),
(32, 'eliminar-mensaje', 'web', '2023-06-20 02:07:02', '2023-06-20 02:07:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2023-06-20 02:08:24', '2023-06-20 02:08:24'),
(2, 'Cliente', 'web', '2023-06-20 02:22:47', '2023-06-20 02:22:47'),
(3, 'dgdfgdfg', 'web', '2023-06-22 12:36:02', '2023-06-22 12:36:02'),
(4, 'werer', 'web', '2023-07-04 01:19:16', '2023-07-04 01:19:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(7, 4),
(8, 1),
(8, 4),
(9, 1),
(10, 1),
(10, 2),
(10, 4),
(11, 1),
(11, 4),
(12, 1),
(13, 1),
(13, 2),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(19, 2),
(20, 1),
(20, 2),
(21, 1),
(22, 1),
(23, 1),
(23, 2),
(23, 3),
(24, 1),
(24, 3),
(25, 1),
(26, 1),
(27, 1),
(27, 2),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `descripcion`, `habilitado`, `created_at`, `updated_at`) VALUES
(4, 'ELECTRICIDAD', 'ELECTRICIDAD', 1, '2023-06-20 12:53:47', '2023-06-20 13:30:31'),
(5, 'CARPINTERÍA', 'CARPINTERÍA', 1, '2023-06-20 12:53:57', '2023-06-20 12:53:57'),
(6, 'PAILERÍA Y SOLDADURA', 'PAILERÍA Y SOLDADURA', 1, '2023-06-20 12:54:08', '2023-06-20 12:54:08'),
(7, 'ALBAÑILERÍA', 'ALBAÑILERÍA', 1, '2023-06-20 12:54:17', '2023-06-20 12:54:17'),
(8, 'MECÁNICA Y MAQUINADO', 'MECÁNICA Y MAQUINADO', 1, '2023-06-20 12:54:26', '2023-06-20 12:58:48'),
(9, 'CONSERVACIÓN DEL CASCO ( Pintura)', 'CONSERVACIÓN DEL CASCO ( Pintura)', 1, '2023-06-20 12:54:41', '2023-06-20 12:58:50'),
(10, 'BUCEO', 'BUCEO', 1, '2023-06-20 12:54:51', '2023-06-20 12:58:51'),
(11, 'ALQUILER DE REMOLCADOR 300 HP DE 1 MOTOR', 'ALQUILER DE REMOLCADOR 300 HP DE 1 MOTOR', 1, '2023-06-20 12:54:59', '2023-06-20 12:58:52'),
(12, 'ALQUILER DE LA PATANA TALLER x hora equipo', 'ALQUILER DE LA PATANA TALLER x hora equipo', 1, '2023-06-20 12:55:09', '2023-06-20 12:58:54'),
(13, 'ESTADÍA EN VARADERO', 'ESTADÍA EN VARADERO', 1, '2023-06-20 12:55:18', '2023-06-20 12:58:55'),
(14, 'MUELLAJE', 'MUELLAJE', 1, '2023-06-20 12:55:26', '2023-06-20 12:59:01'),
(15, 'VARADA Y LARGADA', 'VARADA Y LARGADA', 1, '2023-06-20 12:55:34', '2023-06-20 12:58:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicituds`
--

CREATE TABLE `solicituds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `servicio_id` bigint(20) UNSIGNED NOT NULL,
  `entidad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `solicitado_por` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo_solicita` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recibido_por` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo_recibe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objeto_obra` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trabajos_realizar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `adicional` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_solicitud` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicituds`
--

INSERT INTO `solicituds` (`id`, `servicio_id`, `entidad`, `correo`, `telefono`, `solicitado_por`, `cargo_solicita`, `recibido_por`, `cargo_recibe`, `objeto_obra`, `trabajos_realizar`, `adicional`, `estado_solicitud`, `created_at`, `updated_at`) VALUES
(4, 6, 'Empresa de Astilleros', 'pedro@pedro.cu', '56840677', 'Pedro Perez', 'Comercial', 'Super Admin', 'Administrador de Sistemas', 'werwerwe', 'werwerwe', 'werwer', 'aprobada', '2023-06-22 01:27:54', '2023-06-22 01:29:15'),
(5, 4, 'ASTICAR', 'admin@asticar.cu', '12345678', 'Super Admin', 'Administrador de Sistemas', 'Super Admin', 'Administrador de Sistemas', 'sdfsdfsd', 'fsdfsdfsdsdf', 'sdfsdfsdfsd', 'aprobada', '2023-06-22 01:37:46', '2023-06-22 01:38:02'),
(6, 8, 'Empresa de Astilleros', 'pedro@pedro.cu', '56840677', 'Pedro Perez', 'Comercial', 'Super Admin', 'Administrador de Sistemas', 'sdf', 'sdfsd', 'sdfsd', 'denegada', '2023-06-22 01:39:24', '2023-06-22 12:31:44'),
(7, 4, 'ASTICAR', 'admin@asticar.cu', '12345678', 'Super Admin', 'Administrador de Sistemas', 'Super Admin', 'Administrador de Sistemas', 'sdfdsf', 'sdfsdf', 'sdfsdf', 'aprobada', '2023-06-22 12:29:24', '2023-06-22 12:29:48'),
(8, 7, 'ASTICAR', 'admin@asticar.cu', '12345678', 'Super Admin', 'Administrador de Sistemas', 'Super Admin', 'Administrador de Sistemas', 'dfgdfg', 'dfgdf', 'dfgdfg', 'aprobada', '2023-06-22 13:34:43', '2023-06-22 13:34:55'),
(9, 7, 'ASTICAR', 'admin@asticar.cu', '12345678', 'Super Admin', 'Administrador de Sistemas', 'Super Admin', 'Administrador de Sistemas', 'difhsdkf', 'ekjajk', 'ksdjsd', 'aprobada', '2023-06-22 14:47:02', '2023-06-22 14:47:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entidad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ocupacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `imagen` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conexion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`conexion`)),
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `telefono`, `entidad`, `ocupacion`, `habilitado`, `imagen`, `email_verified_at`, `password`, `conexion`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@asticar.cu', '12345678', 'ASTICAR', 'Administrador de Sistemas', 1, '1687268132.jpg', NULL, '$2y$10$JlnD5dC2TSUJuo7j3704f.G2ULS7TBCsVbPP4SrjnWkk0e9d14PaS', '{\"fecha\":1688435241,\"ip\":\"::1\"}', 'duHrGtfceuNI97stAOqClAMk82Y02gX3CYV0zA1FUafFNHMlb6YXJXWKFXPP', '2023-06-20 02:08:24', '2023-07-04 01:47:21'),
(2, 'Pedro Perez ertertert', 'pedro@pedro.cu', '56840677', 'Empresa de Astilleros', 'Comercial', 1, '1687227886.jpg', NULL, '$2y$10$H0huApiWvH2SnPmSVSbypuFbewTv9EEW91TYcfqU/RjL/vAPtZ1xS', '{\"fecha\":1687445524,\"ip\":\"::1\"}', NULL, '2023-06-20 02:23:02', '2023-06-22 14:52:04'),
(7, 'sdfsdf', 'sdff@uysfgjhs.dfdf', '343434', 'sfsfsd', 'sdfsdf', 1, 'user.png', NULL, '$2y$10$ModW5nq3S/uH/ssvhMK8N.Sh9nrBRIHXPX9qABCPHPSj2icKzWRhu', '\"{}\"', NULL, '2023-06-22 12:33:47', '2023-06-22 12:33:47');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `imagens`
--
ALTER TABLE `imagens`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `servicios_nombre_unique` (`nombre`);

--
-- Indices de la tabla `solicituds`
--
ALTER TABLE `solicituds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solicituds_servicio_id_foreign` (`servicio_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `configs`
--
ALTER TABLE `configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagens`
--
ALTER TABLE `imagens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `solicituds`
--
ALTER TABLE `solicituds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `solicituds`
--
ALTER TABLE `solicituds`
  ADD CONSTRAINT `solicituds_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
