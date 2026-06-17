-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-06-2026 a las 08:29:41
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `porcly`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentos`
--

CREATE TABLE `alimentos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cerda_id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `tipo_alimento` varchar(255) NOT NULL,
  `cantidad_kg` decimal(8,2) NOT NULL,
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alimentos`
--

INSERT INTO `alimentos` (`id`, `cerda_id`, `fecha`, `tipo_alimento`, `cantidad_kg`, `notas`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-06-06', 'Mantenimiento', 2.70, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(2, 1, '2026-06-07', 'Mantenimiento', 2.20, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(3, 2, '2026-06-06', 'Gestación', 2.50, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(4, 2, '2026-06-07', 'Gestación', 3.00, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(5, 3, '2026-06-06', 'Gestación', 3.00, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(6, 3, '2026-06-07', 'Gestación', 3.20, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(7, 4, '2026-06-06', 'Lactancia', 5.00, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(8, 4, '2026-06-07', 'Lactancia', 5.60, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(9, 6, '2026-06-06', 'Gestación', 2.60, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(10, 6, '2026-06-07', 'Gestación', 3.00, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(11, 7, '2026-06-06', 'Mantenimiento', 2.80, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(12, 7, '2026-06-07', 'Mantenimiento', 2.40, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(13, 9, '2026-06-06', 'Gestación', 2.90, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(14, 9, '2026-06-07', 'Gestación', 2.90, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(15, 10, '2026-06-06', 'Lactancia', 5.60, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(16, 10, '2026-06-07', 'Lactancia', 5.50, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(17, 11, '2026-06-06', 'Mantenimiento', 2.70, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(18, 11, '2026-06-07', 'Mantenimiento', 2.40, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(19, 12, '2026-06-06', 'Mantenimiento', 2.30, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(20, 12, '2026-06-07', 'Mantenimiento', 2.80, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(21, 13, '2026-06-06', 'Gestación', 2.70, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(22, 13, '2026-06-07', 'Gestación', 3.10, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(23, 14, '2026-06-06', 'Mantenimiento', 2.40, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(24, 14, '2026-06-07', 'Mantenimiento', 2.20, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(25, 15, '2026-06-06', 'Lactancia', 5.00, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(26, 15, '2026-06-07', 'Lactancia', 5.50, 'Consumo normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(27, 6, '2026-06-12', 'Gestación', 3.50, 'Alimentada correctamente', '2026-06-12 10:26:09', '2026-06-12 10:26:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cerdas`
--

CREATE TABLE `cerdas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `raza` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `peso_actual` decimal(8,2) DEFAULT NULL,
  `estado` enum('activa','gestante','lactante','en_celo','descarte') NOT NULL DEFAULT 'activa',
  `numero_partos` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cerdas`
--

INSERT INTO `cerdas` (`id`, `user_id`, `codigo`, `nombre`, `raza`, `fecha_nacimiento`, `peso_actual`, `estado`, `numero_partos`, `notas`, `created_at`, `updated_at`) VALUES
(1, 1, 'C-001', 'Margarita', 'Landrace', '2024-03-15', 185.50, 'activa', 2, 'Buena madre, dócil.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(2, 1, 'C-002', 'Clara', 'Large White', '2024-01-10', 192.00, 'gestante', 3, 'Inseminada con verraco Duroc.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(3, 1, 'C-003', 'Bella', 'Duroc', '2024-05-22', 178.00, 'gestante', 1, 'Primer parto esperado.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(4, 1, 'C-004', 'Lola', 'Landrace', '2023-11-05', 205.00, 'lactante', 4, 'Camada actual de 10 lechones.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(5, 1, 'C-005', 'Fiona', 'Pietrain', '2024-06-01', 165.00, 'en_celo', 0, 'Lista para primera inseminación.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(6, 1, 'C-006', 'Rosa', 'Yorkshire', '2024-02-18', 188.00, 'gestante', 2, 'Gestación en curso normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(7, 1, 'C-007', 'Diana', 'Landrace', '2024-04-02', 190.50, 'activa', 2, 'En recuperación post-destete.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(8, 1, 'C-008', 'Gorda', 'Duroc', '2023-08-12', 215.00, 'descarte', 6, 'Baja productividad en última camada.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(9, 1, 'C-009', 'Nieve', 'Large White', '2024-02-28', 197.00, 'gestante', 2, 'Parto inminente.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(10, 1, 'C-010', 'Princesa', 'Pietrain', '2023-12-14', 182.00, 'lactante', 3, 'Camada muy uniforme.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(11, 1, 'C-011', 'Luna', 'Landrace', '2024-07-01', 160.00, 'activa', 0, 'Reemplazo joven.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(12, 1, 'C-012', 'Estrella', 'Yorkshire', '2024-01-25', 195.00, 'en_celo', 3, 'Celo detectado hoy por la mañana.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(13, 1, 'C-013', 'Perla', 'Duroc', '2024-04-10', 184.00, 'gestante', 1, 'Inseminación confirmada por ecografía.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(14, 1, 'C-014', 'Daisy', 'Large White', '2024-03-30', 180.00, 'activa', 1, 'Ciclando normal.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(15, 1, 'C-015', 'Rita', 'Landrace', '2023-10-20', 208.00, 'lactante', 5, 'Próxima a destete.', '2026-06-08 01:58:05', '2026-06-08 01:58:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destetes`
--

CREATE TABLE `destetes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parto_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_destete` date NOT NULL,
  `lechones_destetados` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `peso_promedio` decimal(6,2) DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `destetes`
--

INSERT INTO `destetes` (`id`, `parto_id`, `fecha_destete`, `lechones_destetados`, `peso_promedio`, `notas`, `created_at`, `updated_at`) VALUES
(1, 3, '2026-06-05', 11, 6.20, 'Destete a los 23 días de nacidos.', '2026-06-08 01:58:05', '2026-06-08 01:58:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inseminaciones`
--

CREATE TABLE `inseminaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cerda_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_inseminacion` date NOT NULL,
  `tipo` enum('natural','artificial') NOT NULL DEFAULT 'artificial',
  `verraco` varchar(255) DEFAULT NULL,
  `fecha_parto_estimada` date NOT NULL,
  `fecha_proximo_celo` date DEFAULT NULL,
  `exitosa` tinyint(1) DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inseminaciones`
--

INSERT INTO `inseminaciones` (`id`, `cerda_id`, `fecha_inseminacion`, `tipo`, `verraco`, `fecha_parto_estimada`, `fecha_proximo_celo`, `exitosa`, `notas`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-02-17', 'artificial', 'DUROC-99', '2026-06-12', NULL, 1, 'Confirmada por ultrasonido día 30.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(2, 3, '2026-02-14', 'artificial', 'LAND-44', '2026-06-09', NULL, 1, 'Primeriza.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(3, 6, '2026-04-18', 'artificial', 'PIET-05', '2026-08-11', NULL, 1, 'Confirmada por ecografía.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(4, 9, '2026-02-13', 'artificial', 'YORK-88', '2026-06-08', NULL, 1, 'Presenta ubres inflamadas y leche.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(5, 13, '2026-03-09', 'natural', 'DUROC-VERR-1', '2026-07-02', NULL, 1, NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(6, 12, '2026-05-16', 'artificial', 'DUROC-99', '2026-09-08', '2026-06-06', 0, 'Retornó a celo.', '2026-06-08 01:58:05', '2026-06-08 01:58:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lechones`
--

CREATE TABLE `lechones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parto_id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  `sexo` enum('macho','hembra') DEFAULT NULL,
  `peso_nacimiento` decimal(6,2) DEFAULT NULL,
  `peso_destete` decimal(6,2) DEFAULT NULL,
  `fecha_destete` date DEFAULT NULL,
  `estado` enum('vivo','muerto','vendido','descarte') NOT NULL DEFAULT 'vivo',
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `lechones`
--

INSERT INTO `lechones` (`id`, `parto_id`, `codigo`, `sexo`, `peso_nacimiento`, `peso_destete`, `fecha_destete`, `estado`, `notas`, `created_at`, `updated_at`) VALUES
(1, 1, 'L-C004-01', 'hembra', 1.45, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(2, 1, 'L-C004-02', 'macho', 1.45, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(3, 1, 'L-C004-03', 'hembra', 1.45, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(4, 1, 'L-C004-04', 'macho', 1.45, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(5, 1, 'L-C004-05', 'hembra', 1.45, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(6, 1, 'L-C004-06', 'macho', 1.45, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(7, 1, 'L-C004-07', 'hembra', 1.45, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(8, 1, 'L-C004-08', 'macho', 1.45, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(9, 1, 'L-C004-09', 'hembra', 1.45, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(10, 1, 'L-C004-10', 'macho', 1.45, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(11, 2, 'L-C010-01', 'hembra', 1.40, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(12, 2, 'L-C010-02', 'hembra', 1.40, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(13, 2, 'L-C010-03', 'macho', 1.40, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(14, 2, 'L-C010-04', 'hembra', 1.40, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(15, 2, 'L-C010-05', 'hembra', 1.40, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(16, 2, 'L-C010-06', 'macho', 1.40, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(17, 2, 'L-C010-07', 'hembra', 1.40, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(18, 2, 'L-C010-08', 'hembra', 1.40, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(19, 2, 'L-C010-09', 'macho', 1.40, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(20, 2, 'L-C010-10', 'hembra', 1.40, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(21, 2, 'L-C010-11', 'hembra', 1.40, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(22, 2, 'L-C010-12', 'macho', 1.40, NULL, NULL, 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(23, 3, 'L-C015-01', 'hembra', 1.36, 6.20, '2026-06-05', 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(24, 3, 'L-C015-02', 'macho', 1.36, 6.20, '2026-06-05', 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(25, 3, 'L-C015-03', 'hembra', 1.36, 6.20, '2026-06-05', 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(26, 3, 'L-C015-04', 'macho', 1.36, 6.20, '2026-06-05', 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(27, 3, 'L-C015-05', 'hembra', 1.36, 6.20, '2026-06-05', 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(28, 3, 'L-C015-06', 'macho', 1.36, 6.20, '2026-06-05', 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(29, 3, 'L-C015-07', 'hembra', 1.36, 6.20, '2026-06-05', 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(30, 3, 'L-C015-08', 'macho', 1.36, 6.20, '2026-06-05', 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(31, 3, 'L-C015-09', 'hembra', 1.36, 6.20, '2026-06-05', 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(32, 3, 'L-C015-10', 'macho', 1.36, 6.20, '2026-06-05', 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(33, 3, 'L-C015-11', 'hembra', 1.36, 6.20, '2026-06-05', 'vivo', NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_11_160938_create_permission_tables', 1),
(5, '2026_06_07_100001_create_cerdas_table', 1),
(6, '2026_06_07_100002_create_inseminaciones_table', 1),
(7, '2026_06_07_100003_create_partos_table', 1),
(8, '2026_06_07_100004_create_lechones_table', 1),
(9, '2026_06_07_100005_create_alimentos_table', 1),
(10, '2026_06_07_100006_create_vacunaciones_table', 1),
(11, '2026_06_07_100007_create_tratamientos_table', 1),
(12, '2026_06_07_100008_create_destetes_table', 1),
(13, '2026_06_12_000001_create_sent_alerts_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partos`
--

CREATE TABLE `partos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cerda_id` bigint(20) UNSIGNED NOT NULL,
  `inseminacion_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_parto` date NOT NULL,
  `lechones_vivos` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `lechones_muertos` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `lechones_momificados` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `peso_camada` decimal(8,2) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `partos`
--

INSERT INTO `partos` (`id`, `cerda_id`, `inseminacion_id`, `fecha_parto`, `lechones_vivos`, `lechones_muertos`, `lechones_momificados`, `peso_camada`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, '2026-05-28', 10, 1, 0, 14.50, 'Parto normal y rápido.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(2, 10, NULL, '2026-05-18', 12, 0, 1, 16.80, 'Excelente camada.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(3, 15, NULL, '2026-05-13', 11, 2, 0, 15.00, 'Dos nacidos muertos por parto distócico.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(4, 1, NULL, '2026-05-08', 11, 0, 0, 15.20, NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(5, 7, NULL, '2026-04-08', 12, 1, 0, 16.00, NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(6, 14, NULL, '2026-03-09', 9, 0, 0, 12.80, NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(7, 1, NULL, '2026-02-07', 13, 1, 0, 18.20, NULL, '2026-06-08 01:58:05', '2026-06-08 01:58:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sent_alerts`
--

CREATE TABLE `sent_alerts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `alert_type` varchar(255) NOT NULL,
  `source_id` bigint(20) UNSIGNED NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sent_alerts`
--

INSERT INTO `sent_alerts` (`id`, `user_id`, `alert_type`, `source_id`, `sent_at`) VALUES
(1, 1, 'parto', 1, '2026-06-12 11:10:25'),
(2, 1, 'vacuna', 3, '2026-06-12 11:10:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('kJzMS1rWI779887rw7YpiXGyHAIHEedoS4GwSn4E', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJDd1lDYkdSNzRZRWRMcHp5a3UwdkFBWHNnNmxRZTZjWGtQMTJIT3ZEIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2Rhc2hib2FyZCIsInJvdXRlIjoiZGFzaGJvYXJkIn0sInVybCI6W10sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1781245738);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamientos`
--

CREATE TABLE `tratamientos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cerda_id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `diagnostico` varchar(255) NOT NULL,
  `tratamiento` varchar(255) NOT NULL,
  `medicamento` varchar(255) DEFAULT NULL,
  `dosis` varchar(255) DEFAULT NULL,
  `duracion_dias` int(10) UNSIGNED DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tratamientos`
--

INSERT INTO `tratamientos` (`id`, `cerda_id`, `fecha`, `diagnostico`, `tratamiento`, `medicamento`, `dosis`, `duracion_dias`, `notas`, `created_at`, `updated_at`) VALUES
(1, 4, '2026-06-05', 'Mastitis leve', 'Antibiótico + antiinflamatorio', 'Mastilac + Flunixin', '5 ml / 10 ml', 3, 'Monitorear consumo de alimento y fiebre en la ubre.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(2, 7, '2026-05-23', 'Cojera (traumatismo leve)', 'Reposo y analgésico', 'Ketoprofeno', '6 ml', 3, 'Recuperada por completo.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(3, 9, '2026-06-13', 'Fiebre', 'Terapia Analgesica', 'Flunixin', NULL, 5, NULL, '2026-06-12 10:23:40', '2026-06-12 10:23:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Productor Porcly', 'diegofernandoaponteaponte@gmail.com', NULL, '$2y$12$S26Q.WVWJzMGe2YvkQS.KOhLb/pwrBh5oSg3DBRdFet9PSdYwaC8.', 'M8GsTG2sHybPm1IYWZjgS9UotA1CYsbti9w3S5KIY5V4tmAeHiu8iANILI9U', '2026-06-08 01:58:05', '2026-06-12 11:28:28'),
(2, 'Diego Aponte', 'diego@gmail.com', NULL, '$2y$12$GIwiQeWUp5xxWDszXCo/aOisoIcaE2rrwI28Ru8Lmad5HEwGUNgIq', NULL, '2026-06-12 11:26:11', '2026-06-12 11:26:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacunaciones`
--

CREATE TABLE `vacunaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cerda_id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `vacuna` varchar(255) NOT NULL,
  `dosis` varchar(255) DEFAULT NULL,
  `proxima_dosis` date DEFAULT NULL,
  `veterinario` varchar(255) DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `vacunaciones`
--

INSERT INTO `vacunaciones` (`id`, `cerda_id`, `fecha`, `vacuna`, `dosis`, `proxima_dosis`, `veterinario`, `notas`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-06-02', 'Parvovirus + Leptospira (Gilt)', '2 ml', NULL, 'Dr. Carlos Mendoza', 'Refuerzo anual.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(2, 2, '2026-05-18', 'Colibacilosis (NeoColipor)', '2 ml', '2026-06-10', 'Dr. Carlos Mendoza', 'Segunda dosis pre-parto.', '2026-06-08 01:58:05', '2026-06-08 01:58:05'),
(3, 9, '2026-05-17', 'Colibacilosis (NeoColipor)', '2 ml', '2026-06-13', 'Dr. Carlos Mendoza', 'Segunda dosis pre-parto.', '2026-06-08 01:58:05', '2026-06-08 01:58:05');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alimentos_cerda_id_foreign` (`cerda_id`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `cerdas`
--
ALTER TABLE `cerdas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cerdas_codigo_unique` (`codigo`),
  ADD KEY `cerdas_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `destetes`
--
ALTER TABLE `destetes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destetes_parto_id_foreign` (`parto_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `inseminaciones`
--
ALTER TABLE `inseminaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inseminaciones_cerda_id_foreign` (`cerda_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lechones`
--
ALTER TABLE `lechones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lechones_parto_id_foreign` (`parto_id`);

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
-- Indices de la tabla `partos`
--
ALTER TABLE `partos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partos_cerda_id_foreign` (`cerda_id`),
  ADD KEY `partos_inseminacion_id_foreign` (`inseminacion_id`);

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
-- Indices de la tabla `sent_alerts`
--
ALTER TABLE `sent_alerts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_alert_unique` (`user_id`,`alert_type`,`source_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tratamientos_cerda_id_foreign` (`cerda_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `vacunaciones`
--
ALTER TABLE `vacunaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vacunaciones_cerda_id_foreign` (`cerda_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `cerdas`
--
ALTER TABLE `cerdas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `destetes`
--
ALTER TABLE `destetes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inseminaciones`
--
ALTER TABLE `inseminaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lechones`
--
ALTER TABLE `lechones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `partos`
--
ALTER TABLE `partos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sent_alerts`
--
ALTER TABLE `sent_alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `vacunaciones`
--
ALTER TABLE `vacunaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alimentos`
--
ALTER TABLE `alimentos`
  ADD CONSTRAINT `alimentos_cerda_id_foreign` FOREIGN KEY (`cerda_id`) REFERENCES `cerdas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cerdas`
--
ALTER TABLE `cerdas`
  ADD CONSTRAINT `cerdas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `destetes`
--
ALTER TABLE `destetes`
  ADD CONSTRAINT `destetes_parto_id_foreign` FOREIGN KEY (`parto_id`) REFERENCES `partos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inseminaciones`
--
ALTER TABLE `inseminaciones`
  ADD CONSTRAINT `inseminaciones_cerda_id_foreign` FOREIGN KEY (`cerda_id`) REFERENCES `cerdas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `lechones`
--
ALTER TABLE `lechones`
  ADD CONSTRAINT `lechones_parto_id_foreign` FOREIGN KEY (`parto_id`) REFERENCES `partos` (`id`) ON DELETE CASCADE;

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
-- Filtros para la tabla `partos`
--
ALTER TABLE `partos`
  ADD CONSTRAINT `partos_cerda_id_foreign` FOREIGN KEY (`cerda_id`) REFERENCES `cerdas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `partos_inseminacion_id_foreign` FOREIGN KEY (`inseminacion_id`) REFERENCES `inseminaciones` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sent_alerts`
--
ALTER TABLE `sent_alerts`
  ADD CONSTRAINT `sent_alerts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD CONSTRAINT `tratamientos_cerda_id_foreign` FOREIGN KEY (`cerda_id`) REFERENCES `cerdas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vacunaciones`
--
ALTER TABLE `vacunaciones`
  ADD CONSTRAINT `vacunaciones_cerda_id_foreign` FOREIGN KEY (`cerda_id`) REFERENCES `cerdas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
