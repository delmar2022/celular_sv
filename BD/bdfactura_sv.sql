-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-02-2022 a las 16:01:04
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdfactura_sv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agentes`
--

CREATE TABLE `agentes` (
  `id_agente` int(11) NOT NULL,
  `nom_agente` varchar(100) NOT NULL,
  `tel1_agente` varchar(50) NOT NULL,
  `tel2_agente` varchar(50) NOT NULL,
  `email_agente` varchar(100) NOT NULL,
  `fiscal_agente` int(11) NOT NULL,
  `banco_agente` varchar(100) NOT NULL,
  `cuenta_agente` varchar(100) NOT NULL,
  `esp_agente` varchar(50) NOT NULL,
  `cal_agente` varchar(50) NOT NULL,
  `estado_agente` int(11) NOT NULL,
  `date_addeda` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id_caja` int(11) NOT NULL,
  `apertura_caja` double NOT NULL,
  `cierre_caja` double NOT NULL,
  `fecha_caja` date NOT NULL,
  `estado_caja` int(11) NOT NULL,
  `users_caja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_chica`
--

CREATE TABLE `caja_chica` (
  `id_caja` int(11) NOT NULL,
  `referencia_caja` varchar(255) NOT NULL,
  `fecha_caja` date NOT NULL,
  `hora_caja` time NOT NULL,
  `monto_caja` double NOT NULL,
  `descripcion_caja` varchar(255) NOT NULL,
  `tipo_caja` tinyint(4) NOT NULL,
  `users_caja` int(11) NOT NULL,
  `date_added_caja` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `caja_chica`
--

INSERT INTO `caja_chica` (`id_caja`, `referencia_caja`, `fecha_caja`, `hora_caja`, `monto_caja`, `descripcion_caja`, `tipo_caja`, `users_caja`, `date_added_caja`) VALUES
(1, 'Luz', '2021-09-08', '12:21:00', 1000, '', 1, 1, '2021-09-08 10:22:08'),
(2, 'Agua ', '2021-09-08', '12:22:00', 500, '', 2, 1, '2021-09-08 10:22:27'),
(3, 'LUZ', '2021-11-26', '16:11:00', 200, '', 1, 1, '2021-11-26 14:12:09'),
(4, 'LUZ', '2021-11-27', '16:13:00', 200, '', 2, 1, '2021-11-26 14:13:30'),
(6, 'luz', '2022-01-24', '17:06:00', 100, '', 1, 1, '2022-01-24 15:06:22'),
(7, 'agua', '2022-01-24', '17:06:00', 100, '', 2, 1, '2022-01-24 15:07:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL,
  `nombre_cargo` varchar(255) NOT NULL,
  `estado_cargo` varchar(11) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `fiscal_cliente` varchar(255) NOT NULL,
  `telefono_cliente` char(30) NOT NULL,
  `email_cliente` varchar(64) NOT NULL,
  `direccion_cliente` varchar(255) NOT NULL,
  `status_cliente` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `tipo_cliente` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `fiscal_cliente`, `telefono_cliente`, `email_cliente`, `direccion_cliente`, `status_cliente`, `date_added`, `tipo_cliente`) VALUES
(1, 'CLIENTE VARIOS', '00000', '00000', '', '', 1, '2022-02-10 12:10:39', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes`
--

CREATE TABLE `comprobantes` (
  `id_comp` int(11) NOT NULL,
  `nombre_comp` varchar(100) NOT NULL,
  `serie_comp` varchar(100) NOT NULL,
  `desde_comp` int(11) NOT NULL,
  `hasta_comp` int(11) NOT NULL,
  `long_comp` int(11) NOT NULL,
  `actual_comp` int(11) NOT NULL,
  `vencimiento_comp` date NOT NULL,
  `estado_comp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comprobantes`
--

INSERT INTO `comprobantes` (`id_comp`, `nombre_comp`, `serie_comp`, `desde_comp`, `hasta_comp`, `long_comp`, `actual_comp`, `vencimiento_comp`, `estado_comp`) VALUES
(1, 'TICKET UNO', 'A2018', 1, 55, 6, 3, '2020-04-22', 0),
(2, 'TICKET DOS', 'B2018', 1, 500, 6, 10, '2022-12-24', 1),
(3, 'RECIBO DE VENTA', 'R001', 1001, 1999, 1, 1005, '2020-01-31', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratistas`
--

CREATE TABLE `contratistas` (
  `id_contra` int(11) NOT NULL,
  `nom_contra` varchar(100) NOT NULL,
  `tel1_contra` varchar(50) NOT NULL,
  `tel2_contra` varchar(50) NOT NULL,
  `empresa_contra` varchar(100) NOT NULL,
  `fiscal_contra` int(11) NOT NULL,
  `banco_contra` varchar(100) NOT NULL,
  `cuenta_contra` varchar(100) NOT NULL,
  `esp_contra` varchar(50) NOT NULL,
  `cal_contra` varchar(50) NOT NULL,
  `estado_contra` int(11) NOT NULL,
  `date_addedc` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditos`
--

CREATE TABLE `creditos` (
  `id_credito` int(11) NOT NULL,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_credito` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `monto_credito` double NOT NULL,
  `saldo_credito` double NOT NULL,
  `estado_credito` tinyint(1) NOT NULL,
  `id_users_credito` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditos_abonos`
--

CREATE TABLE `creditos_abonos` (
  `id_abono` int(11) NOT NULL,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_abono` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `monto_abono` double NOT NULL,
  `abono` double NOT NULL,
  `saldo_abono` double NOT NULL,
  `id_users_abono` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `concepto_abono` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditos_abonos_prov`
--

CREATE TABLE `creditos_abonos_prov` (
  `id_abono` int(11) NOT NULL,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_abono` datetime NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `monto_abono` double NOT NULL,
  `abono` double NOT NULL,
  `saldo_abono` double NOT NULL,
  `id_users_abono` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `concepto_abono` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credito_proveedor`
--

CREATE TABLE `credito_proveedor` (
  `id_credito` int(11) NOT NULL,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_credito` datetime NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `monto_credito` double NOT NULL,
  `saldo_credito` double NOT NULL,
  `estado_credito` tinyint(1) NOT NULL,
  `id_users_credito` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `currencies`
--

CREATE TABLE `currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `precision` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `thousand_separator` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `decimal_separator` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `precision`, `thousand_separator`, `decimal_separator`, `code`) VALUES
(1, 'US Dollar', '$', '2', ',', '.', 'USD'),
(2, 'Libra Esterlina', '&pound;', '2', ',', '.', 'GBP'),
(3, 'Euro', 'â‚¬', '2', '.', ',', 'EUR'),
(4, 'South African Rand', 'R', '2', '.', ',', 'ZAR'),
(5, 'Danish Krone', 'kr ', '2', '.', ',', 'DKK'),
(6, 'Israeli Shekel', 'NIS ', '2', ',', '.', 'ILS'),
(7, 'Swedish Krona', 'kr ', '2', '.', ',', 'SEK'),
(8, 'Kenyan Shilling', 'KSh ', '2', ',', '.', 'KES'),
(9, 'Canadian Dollar', 'C$', '2', ',', '.', 'CAD'),
(10, 'Philippine Peso', 'P ', '2', ',', '.', 'PHP'),
(11, 'Indian Rupee', 'Rs. ', '2', ',', '.', 'INR'),
(12, 'Australian Dollar', '$', '2', ',', '.', 'AUD'),
(13, 'Singapore Dollar', 'SGD ', '2', ',', '.', 'SGD'),
(14, 'Norske Kroner', 'kr ', '2', '.', ',', 'NOK'),
(15, 'New Zealand Dollar', '$', '2', ',', '.', 'NZD'),
(16, 'Vietnamese Dong', 'VND ', '0', '.', ',', 'VND'),
(17, 'Swiss Franc', 'CHF ', '2', '\'', '.', 'CHF'),
(18, 'Quetzal Guatemalteco', 'Q', '2', ',', '.', 'GTQ'),
(19, 'Malaysian Ringgit', 'RM', '2', ',', '.', 'MYR'),
(20, 'Real Brasile&ntilde;o', 'R$', '2', '.', ',', 'BRL'),
(21, 'Thai Baht', 'THB ', '2', ',', '.', 'THB'),
(22, 'Nigerian Naira', 'NGN ', '2', ',', '.', 'NGN'),
(23, 'Peso Argentino', '$', '2', '.', ',', 'ARS'),
(24, 'Bangladeshi Taka', 'Tk', '2', ',', '.', 'BDT'),
(25, 'United Arab Emirates Dirham', 'DH ', '2', ',', '.', 'AED'),
(26, 'Hong Kong Dollar', '$', '2', ',', '.', 'HKD'),
(27, 'Indonesian Rupiah', 'Rp', '2', ',', '.', 'IDR'),
(28, 'Peso Mexicano', '$', '2', ',', '.', 'MXN'),
(29, 'Egyptian Pound', '&pound;', '2', ',', '.', 'EGP'),
(30, 'Peso Colombiano', '$', '2', '.', ',', 'COP'),
(31, 'West African Franc', 'CFA ', '2', ',', '.', 'XOF'),
(32, 'Chinese Renminbi', 'RMB ', '2', ',', '.', 'CNY');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_caja`
--

CREATE TABLE `detalle_caja` (
  `caja_id` int(11) NOT NULL,
  `num_caja` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `hora_ap` time NOT NULL,
  `s_inicial` double NOT NULL,
  `ing_efectivo` double NOT NULL,
  `ing_cheque` double NOT NULL,
  `ing_transf` double NOT NULL,
  `egresos` double NOT NULL,
  `h_cierre` time NOT NULL,
  `total_caja` double NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `estado_caja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_caja`
--

INSERT INTO `detalle_caja` (`caja_id`, `num_caja`, `fecha`, `hora_ap`, `s_inicial`, `ing_efectivo`, `ing_cheque`, `ing_transf`, `egresos`, `h_cierre`, `total_caja`, `empleado_id`, `estado_caja`) VALUES
(1, '', '2022-02-10', '12:10:00', 50, 0, 0, 0, 0, '00:00:00', 0, 1, 1),
(2, '', '2022-02-11', '11:53:00', 50, 0, 0, 0, 0, '00:00:00', 0, 1, 1),
(3, '', '2022-02-15', '08:33:00', 50, 0, 0, 0, 0, '00:00:00', 0, 1, 1),
(4, '', '2022-02-22', '08:51:00', 50, 0, 0, 0, 0, '00:00:00', 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_devolucion`
--

CREATE TABLE `detalle_devolucion` (
  `id_detalle` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `numero_factura` varchar(25) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `desc_venta` int(11) NOT NULL,
  `precio_venta` double NOT NULL,
  `importe_venta` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_fact_compra`
--

CREATE TABLE `detalle_fact_compra` (
  `id_detalle` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` double NOT NULL,
  `precio_costo` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_fact_cot`
--

CREATE TABLE `detalle_fact_cot` (
  `id_detalle` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `numero_factura` varchar(25) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `desc_venta` int(11) NOT NULL,
  `precio_venta` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_fact_ventas`
--

CREATE TABLE `detalle_fact_ventas` (
  `id_detalle` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `numero_factura` varchar(25) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `desc_venta` int(11) NOT NULL,
  `precio_venta` double NOT NULL,
  `importe_venta` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_traslado`
--

CREATE TABLE `detalle_traslado` (
  `id_detalle_traslado` int(11) NOT NULL,
  `id_traslado` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` double NOT NULL,
  `num_transaccion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos`
--

CREATE TABLE `egresos` (
  `id_egreso` int(11) NOT NULL,
  `referencia_egreso` varchar(100) CHARACTER SET latin1 NOT NULL,
  `monto` double NOT NULL,
  `descripcion_egreso` text CHARACTER SET latin1 NOT NULL,
  `fecha_added` datetime NOT NULL,
  `users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_compras`
--

CREATE TABLE `facturas_compras` (
  `id_factura` int(11) NOT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `condiciones` int(11) NOT NULL,
  `monto_factura` double NOT NULL,
  `estado_factura` tinyint(4) NOT NULL,
  `id_users_factura` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `ref_factura` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_cot`
--

CREATE TABLE `facturas_cot` (
  `id_factura` int(11) NOT NULL,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `condiciones` varchar(30) NOT NULL,
  `monto_factura` double NOT NULL,
  `estado_factura` tinyint(1) NOT NULL,
  `id_users_factura` int(11) NOT NULL,
  `validez` double NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `print_img` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_ventas`
--

CREATE TABLE `facturas_ventas` (
  `id_factura` int(11) NOT NULL,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `condiciones` varchar(30) NOT NULL,
  `monto_factura` double NOT NULL,
  `estado_factura` tinyint(1) NOT NULL,
  `id_users_factura` int(11) NOT NULL,
  `dinero_resibido_fac` double NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_comp_factura` int(11) NOT NULL,
  `num_trans_factura` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_productos`
--

CREATE TABLE `historial_productos` (
  `id_historial` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `fecha_historial` datetime NOT NULL,
  `nota_historial` varchar(255) NOT NULL,
  `referencia_historial` varchar(100) NOT NULL,
  `cantidad_historial` double NOT NULL,
  `tipo_historial` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuestos`
--

CREATE TABLE `impuestos` (
  `id_imp` int(11) NOT NULL,
  `nombre_imp` varchar(100) NOT NULL,
  `valor_imp` double NOT NULL,
  `estado_imp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `id_ingreso` int(11) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `monto` double NOT NULL,
  `fecha_added` datetime NOT NULL,
  `users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex`
--

CREATE TABLE `kardex` (
  `id_kardex` int(11) NOT NULL,
  `fecha_kardex` date NOT NULL,
  `producto_kardex` int(11) NOT NULL,
  `cant_entrada` double NOT NULL,
  `costo_entrada` double NOT NULL,
  `total_entrada` double NOT NULL,
  `cant_salida` double NOT NULL,
  `costo_salida` double NOT NULL,
  `total_salida` double NOT NULL,
  `cant_saldo` double NOT NULL,
  `costo_saldo` double NOT NULL,
  `total_saldo` double NOT NULL,
  `added_kardex` datetime NOT NULL,
  `users_kardex` int(11) NOT NULL,
  `tipo_movimiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

CREATE TABLE `lineas` (
  `id_linea` int(11) NOT NULL,
  `nombre_linea` varchar(255) NOT NULL,
  `descripcion_linea` text NOT NULL,
  `estado_linea` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `lineas`
--

INSERT INTO `lineas` (`id_linea`, `nombre_linea`, `descripcion_linea`, `estado_linea`, `date_added`) VALUES
(1, 'CATEGORIA 1', '', 1, '2021-06-18 11:23:38'),
(2, 'CATEGORIA 2', '', 1, '2021-06-18 11:23:45'),
(3, 'CATEGORIA 3', '', 1, '2021-06-18 11:23:52'),
(4, 'ELECTRICOS', '', 1, '2021-09-10 11:01:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` int(11) NOT NULL,
  `nombre_marca` varchar(255) NOT NULL,
  `estado_marca` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `nombre_marca`, `estado_marca`, `date_added`) VALUES
(1, 'MARCA 1', 1, '2021-06-18 11:24:37'),
(2, 'MARCA 2', 1, '2021-06-18 11:24:42'),
(3, 'MARCA 3', 1, '2021-06-18 11:24:51'),
(4, 'KIA', 1, '2021-09-10 11:02:40'),
(5, 'HUYDAI', 1, '2021-09-10 11:03:35'),
(6, 'FORD', 1, '2021-09-10 11:03:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medidas`
--

CREATE TABLE `medidas` (
  `id_medida` int(11) NOT NULL,
  `nombre_medida` varchar(255) NOT NULL,
  `estado_medida` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `medidas`
--

INSERT INTO `medidas` (`id_medida`, `nombre_medida`, `estado_medida`, `date_added`) VALUES
(1, 'LIBRAS', 1, '2021-06-18 11:25:15'),
(2, 'UNIDAD', 1, '2021-06-18 11:25:22'),
(3, 'GALONES', 1, '2021-06-18 11:25:28'),
(4, 'UND', 1, '2021-09-10 11:03:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL,
  `nombre_modulo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `nombre_modulo`) VALUES
(1, 'Inicio'),
(2, 'Productos'),
(3, 'Proveedores'),
(4, 'Clientes'),
(5, 'Reportes'),
(6, 'Configuracion'),
(7, 'Usuarios'),
(8, 'Permisos'),
(9, 'Categorias'),
(10, 'Ventas'),
(11, 'Compras'),
(12, 'Caja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL,
  `nombre_empresa` varchar(150) CHARACTER SET latin1 NOT NULL,
  `giro_empresa` text NOT NULL,
  `fiscal_empresa` varchar(25) NOT NULL,
  `direccion` varchar(255) CHARACTER SET latin1 NOT NULL,
  `ciudad` varchar(100) CHARACTER SET latin1 NOT NULL,
  `codigo_postal` varchar(100) CHARACTER SET latin1 NOT NULL,
  `estado` varchar(100) CHARACTER SET latin1 NOT NULL,
  `telefono` varchar(20) CHARACTER SET latin1 NOT NULL,
  `email` varchar(64) CHARACTER SET latin1 NOT NULL,
  `impuesto` int(2) NOT NULL,
  `nom_impuesto` varchar(50) NOT NULL,
  `moneda` varchar(6) CHARACTER SET latin1 NOT NULL,
  `logo_url` varchar(255) CHARACTER SET latin1 NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `doc_cliente` varchar(50) NOT NULL,
  `doc_proveedor` varchar(50) NOT NULL,
  `precio_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nombre_empresa`, `giro_empresa`, `fiscal_empresa`, `direccion`, `ciudad`, `codigo_postal`, `estado`, `telefono`, `email`, `impuesto`, `nom_impuesto`, `moneda`, `logo_url`, `cliente_id`, `comp_id`, `doc_cliente`, `doc_proveedor`, `precio_venta`) VALUES
(1, 'FANNY', 'VENTA DE EQUIPOS', '9-723-1331', 'LAS MAÑANITAS VÍA PANAMERICANA', '', '507', '', '+51765055240', 'info@softys.com', 18, 'IGV', '$', '../../img/1628004160_logo.png', 1, 1, 'DNI', 'RUC', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `codigo_producto` varchar(255) CHARACTER SET latin1 NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `descripcion_producto` text NOT NULL,
  `id_linea_producto` int(11) NOT NULL,
  `id_linea2_producto` int(11) NOT NULL,
  `id_marca_producto` int(11) NOT NULL,
  `id_med_producto` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `inv_producto` tinyint(4) NOT NULL,
  `iva_producto` tinyint(4) NOT NULL,
  `estado_producto` tinyint(4) NOT NULL,
  `costo_producto` double NOT NULL,
  `costo2_producto` double NOT NULL,
  `utilidad_producto` double NOT NULL,
  `moneda_producto` int(11) NOT NULL,
  `valor1_producto` double NOT NULL,
  `valor2_producto` double NOT NULL,
  `valor3_producto` double NOT NULL,
  `valor4_producto` double NOT NULL,
  `stock_producto` double NOT NULL,
  `stock_min_producto` double NOT NULL,
  `date_added` datetime NOT NULL,
  `image_path` varchar(300) NOT NULL,
  `id_imp_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(255) NOT NULL,
  `fiscal_proveedor` varchar(100) NOT NULL,
  `direccion_proveedor` text NOT NULL,
  `email_proveedor` varchar(255) NOT NULL,
  `telefono_proveedor` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL,
  `estado_proveedor` tinyint(4) NOT NULL,
  `tipo_proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre_proveedor`, `fiscal_proveedor`, `direccion_proveedor`, `email_proveedor`, `telefono_proveedor`, `date_added`, `estado_proveedor`, `tipo_proveedor`) VALUES
(1, 'VENTA DE BEBIDAS', '789456', 'CON. LAS COLINAS, SAN SALVADOR', 'juanperez@gmail.com', '7895', '2020-12-05 09:29:07', 1, 0),
(2, 'LA CIMA S.A. DE C.V.', '4548456-8', 'PRUEBA DE DIRECCION', 'fernandomart@gmail.com', '2556-5600', '2021-06-08 16:22:57', 1, 1),
(3, 'LA SULTANA S.A. DE C.V.', '7845002-7', 'PRUEBA DE DIRECCION', 'fernandomart@gmail.com', '2526-5600', '2021-06-08 16:32:54', 1, 1),
(4, 'Manuel', '1022121546', 'Lima', 'lima@peru.com', '5555555', '2021-08-15 09:52:22', 1, 0),
(5, 'PROVEEDOR DE PRUEBA ', '121001245-7', 'UNA DIRECCION DE PRUEBA', 'pruebaproveedor@gmail.comx', '78456232', '2022-02-10 11:57:57', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id_stock` int(11) NOT NULL,
  `id_producto_stock` int(11) NOT NULL,
  `id_sucursal_stock` int(11) NOT NULL,
  `cantidad_stock` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_lineas`
--

CREATE TABLE `sub_lineas` (
  `id_linea2` int(11) NOT NULL,
  `nombre_linea2` varchar(255) NOT NULL,
  `descripcion_linea2` text NOT NULL,
  `estado_linea2` int(11) NOT NULL,
  `date_added2` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sub_lineas`
--

INSERT INTO `sub_lineas` (`id_linea2`, `nombre_linea2`, `descripcion_linea2`, `estado_linea2`, `date_added2`) VALUES
(1, 'SUB CATEGORIA 1', '', 1, '2021-06-18 11:24:14'),
(2, 'SUB CATEGORIA 2', '', 1, '2021-06-18 11:24:20'),
(3, 'SUB CATEGORIA 3', '', 1, '2021-06-18 11:24:27'),
(4, 'FAROS', '', 1, '2021-09-10 11:02:22'),
(5, 'PRU', '', 1, '2021-10-19 16:41:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id_sucursal` int(11) NOT NULL,
  `codigo_sucursal` varchar(50) NOT NULL,
  `nombre_sucursal` varchar(255) NOT NULL,
  `direccion_sucursal` text NOT NULL,
  `limite_sucursal` double NOT NULL,
  `estado_sucursal` tinyint(4) NOT NULL,
  `fecha_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id_sucursal`, `codigo_sucursal`, `nombre_sucursal`, `direccion_sucursal`, `limite_sucursal`, `estado_sucursal`, `fecha_added`) VALUES
(1, 'CM001', 'SUCURSAL 1', 'SAN MIGUEL, EL SALVADOR', 100, 1, '2022-02-15 09:00:21'),
(2, 'CM002', 'SUCURSAL 2', 'USULUTAN, EL SALVADOR', 100, 1, '2022-02-15 09:01:03'),
(3, 'CM003', 'SUCURSAL 3', 'BARRIOS, USULUTAN', 100, 1, '2022-02-15 09:01:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_compra`
--

CREATE TABLE `tmp_compra` (
  `id_tmp` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_tmp` double NOT NULL,
  `costo_tmp` double(8,2) DEFAULT NULL,
  `session_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_cotizacion`
--

CREATE TABLE `tmp_cotizacion` (
  `id_tmp` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_tmp` double NOT NULL,
  `precio_tmp` double(8,3) DEFAULT NULL,
  `desc_tmp` int(11) NOT NULL,
  `session_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_ventas`
--

CREATE TABLE `tmp_ventas` (
  `id_tmp` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_tmp` double NOT NULL,
  `precio_tmp` double(8,2) DEFAULT NULL,
  `desc_tmp` int(11) NOT NULL,
  `session_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslados`
--

CREATE TABLE `traslados` (
  `id_traslado` int(11) NOT NULL,
  `referencia_traslado` varchar(50) NOT NULL,
  `origen_traslado` int(11) NOT NULL,
  `destino_traslado` int(11) NOT NULL,
  `monto_traslado` int(11) NOT NULL,
  `fecha_added` datetime NOT NULL,
  `id_users` int(11) NOT NULL,
  `num_transaccion` varchar(50) NOT NULL,
  `estado_traslado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `nombre_users` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `apellido_users` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_users` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `con_users` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `email_users` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `tipo_users` tinyint(4) NOT NULL,
  `cargo_users` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sucursal_users` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `comision_users` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_users`, `nombre_users`, `apellido_users`, `usuario_users`, `con_users`, `email_users`, `tipo_users`, `cargo_users`, `sucursal_users`, `date_added`, `comision_users`) VALUES
(1, 'SUPER', 'ADMINISTRADOR', 'admin', '$2y$10$MPVHzZ2ZPOWmtUUGCq3RXu31OTB.jo7M9LZ7PmPQYmgETSNn19ejO', 'root@admin.com', 0, '1', 1, '2016-05-21 15:06:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_group`
--

CREATE TABLE `user_group` (
  `user_group_id` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `permission` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_group`
--

INSERT INTO `user_group` (`user_group_id`, `name`, `permission`, `date_added`) VALUES
(1, 'Super Administrador', 'Inicio,1,1,1;Productos,1,1,1;Proveedores,1,1,1;Clientes,1,1,1;Reportes,1,1,1;Configuracion,1,1,1;Usuarios,1,1,1;Permisos,1,1,1;Categorias,1,1,1;Ventas,1,1,1;Compras,1,1,1;Caja,1,1,1;', '2017-08-09 10:22:15');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agentes`
--
ALTER TABLE `agentes`
  ADD PRIMARY KEY (`id_agente`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id_caja`);

--
-- Indices de la tabla `caja_chica`
--
ALTER TABLE `caja_chica`
  ADD PRIMARY KEY (`id_caja`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `codigo_producto` (`nombre_cliente`);

--
-- Indices de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD PRIMARY KEY (`id_comp`);

--
-- Indices de la tabla `contratistas`
--
ALTER TABLE `contratistas`
  ADD PRIMARY KEY (`id_contra`);

--
-- Indices de la tabla `creditos`
--
ALTER TABLE `creditos`
  ADD PRIMARY KEY (`id_credito`),
  ADD UNIQUE KEY `numero_cotizacion` (`numero_factura`);

--
-- Indices de la tabla `creditos_abonos`
--
ALTER TABLE `creditos_abonos`
  ADD PRIMARY KEY (`id_abono`);

--
-- Indices de la tabla `creditos_abonos_prov`
--
ALTER TABLE `creditos_abonos_prov`
  ADD PRIMARY KEY (`id_abono`);

--
-- Indices de la tabla `credito_proveedor`
--
ALTER TABLE `credito_proveedor`
  ADD PRIMARY KEY (`id_credito`),
  ADD UNIQUE KEY `numero_cotizacion` (`numero_factura`);

--
-- Indices de la tabla `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_caja`
--
ALTER TABLE `detalle_caja`
  ADD PRIMARY KEY (`caja_id`);

--
-- Indices de la tabla `detalle_devolucion`
--
ALTER TABLE `detalle_devolucion`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `numero_cotizacion` (`numero_factura`,`id_producto`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `numero_factura` (`numero_factura`);

--
-- Indices de la tabla `detalle_fact_compra`
--
ALTER TABLE `detalle_fact_compra`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `numero_cotizacion` (`numero_factura`,`id_producto`),
  ADD KEY `id_factura` (`id_factura`);

--
-- Indices de la tabla `detalle_fact_cot`
--
ALTER TABLE `detalle_fact_cot`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `numero_cotizacion` (`numero_factura`,`id_producto`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `numero_factura` (`numero_factura`);

--
-- Indices de la tabla `detalle_fact_ventas`
--
ALTER TABLE `detalle_fact_ventas`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `numero_cotizacion` (`numero_factura`,`id_producto`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `numero_factura` (`numero_factura`);

--
-- Indices de la tabla `detalle_traslado`
--
ALTER TABLE `detalle_traslado`
  ADD PRIMARY KEY (`id_detalle_traslado`),
  ADD KEY `id_traslado` (`id_traslado`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `egresos`
--
ALTER TABLE `egresos`
  ADD PRIMARY KEY (`id_egreso`),
  ADD KEY `users` (`users`);

--
-- Indices de la tabla `facturas_compras`
--
ALTER TABLE `facturas_compras`
  ADD PRIMARY KEY (`id_factura`),
  ADD UNIQUE KEY `numero_cotizacion` (`numero_factura`),
  ADD KEY `id_sucursal` (`id_sucursal`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_vendedor` (`id_vendedor`),
  ADD KEY `id_users_factura` (`id_users_factura`);

--
-- Indices de la tabla `facturas_cot`
--
ALTER TABLE `facturas_cot`
  ADD PRIMARY KEY (`id_factura`),
  ADD UNIQUE KEY `numero_cotizacion` (`numero_factura`);

--
-- Indices de la tabla `facturas_ventas`
--
ALTER TABLE `facturas_ventas`
  ADD PRIMARY KEY (`id_factura`),
  ADD UNIQUE KEY `numero_cotizacion` (`numero_factura`);

--
-- Indices de la tabla `historial_productos`
--
ALTER TABLE `historial_productos`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `impuestos`
--
ALTER TABLE `impuestos`
  ADD PRIMARY KEY (`id_imp`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id_ingreso`),
  ADD KEY `id_consulta` (`id_consulta`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `users` (`users`);

--
-- Indices de la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD PRIMARY KEY (`id_kardex`);

--
-- Indices de la tabla `lineas`
--
ALTER TABLE `lineas`
  ADD PRIMARY KEY (`id_linea`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `medidas`
--
ALTER TABLE `medidas`
  ADD PRIMARY KEY (`id_medida`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_cat_producto` (`id_linea_producto`),
  ADD KEY `id_med_producto` (`id_med_producto`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_stock`),
  ADD KEY `id_producto_stock` (`id_producto_stock`),
  ADD KEY `id_sucursal_stock` (`id_sucursal_stock`);

--
-- Indices de la tabla `sub_lineas`
--
ALTER TABLE `sub_lineas`
  ADD PRIMARY KEY (`id_linea2`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id_sucursal`);

--
-- Indices de la tabla `tmp_compra`
--
ALTER TABLE `tmp_compra`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indices de la tabla `tmp_cotizacion`
--
ALTER TABLE `tmp_cotizacion`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indices de la tabla `tmp_ventas`
--
ALTER TABLE `tmp_ventas`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indices de la tabla `traslados`
--
ALTER TABLE `traslados`
  ADD PRIMARY KEY (`id_traslado`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `user_name` (`usuario_users`),
  ADD UNIQUE KEY `user_email` (`email_users`);

--
-- Indices de la tabla `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`user_group_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agentes`
--
ALTER TABLE `agentes`
  MODIFY `id_agente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id_caja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caja_chica`
--
ALTER TABLE `caja_chica`
  MODIFY `id_caja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  MODIFY `id_comp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `contratistas`
--
ALTER TABLE `contratistas`
  MODIFY `id_contra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `creditos`
--
ALTER TABLE `creditos`
  MODIFY `id_credito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `creditos_abonos`
--
ALTER TABLE `creditos_abonos`
  MODIFY `id_abono` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `creditos_abonos_prov`
--
ALTER TABLE `creditos_abonos_prov`
  MODIFY `id_abono` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `credito_proveedor`
--
ALTER TABLE `credito_proveedor`
  MODIFY `id_credito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `detalle_caja`
--
ALTER TABLE `detalle_caja`
  MODIFY `caja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_devolucion`
--
ALTER TABLE `detalle_devolucion`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_fact_compra`
--
ALTER TABLE `detalle_fact_compra`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_fact_cot`
--
ALTER TABLE `detalle_fact_cot`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_fact_ventas`
--
ALTER TABLE `detalle_fact_ventas`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_traslado`
--
ALTER TABLE `detalle_traslado`
  MODIFY `id_detalle_traslado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `egresos`
--
ALTER TABLE `egresos`
  MODIFY `id_egreso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas_compras`
--
ALTER TABLE `facturas_compras`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas_cot`
--
ALTER TABLE `facturas_cot`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas_ventas`
--
ALTER TABLE `facturas_ventas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_productos`
--
ALTER TABLE `historial_productos`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `impuestos`
--
ALTER TABLE `impuestos`
  MODIFY `id_imp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `kardex`
--
ALTER TABLE `kardex`
  MODIFY `id_kardex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lineas`
--
ALTER TABLE `lineas`
  MODIFY `id_linea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `medidas`
--
ALTER TABLE `medidas`
  MODIFY `id_medida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sub_lineas`
--
ALTER TABLE `sub_lineas`
  MODIFY `id_linea2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tmp_compra`
--
ALTER TABLE `tmp_compra`
  MODIFY `id_tmp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tmp_cotizacion`
--
ALTER TABLE `tmp_cotizacion`
  MODIFY `id_tmp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tmp_ventas`
--
ALTER TABLE `tmp_ventas`
  MODIFY `id_tmp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `traslados`
--
ALTER TABLE `traslados`
  MODIFY `id_traslado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `user_group`
--
ALTER TABLE `user_group`
  MODIFY `user_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
