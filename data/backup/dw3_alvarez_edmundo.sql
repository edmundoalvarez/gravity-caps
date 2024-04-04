-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 26-06-2023 a las 15:58:02
-- Versión del servidor: 5.7.39
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dw3_alvarez_edmundo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `categoria_id` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(60) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`categoria_id`, `nombre`) VALUES
(1, 'Gorras'),
(2, 'Remeras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `color_id` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`color_id`, `nombre`) VALUES
(1, 'Blanco'),
(2, 'Negro'),
(3, 'Gris'),
(4, 'Rojo'),
(5, 'Verde'),
(6, 'Azul'),
(7, 'Violeta'),
(8, 'Amarillo'),
(9, 'Naranja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `compra_id` int(10) UNSIGNED NOT NULL,
  `usuario_fk` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`compra_id`, `usuario_fk`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `direccion_id` tinyint(3) UNSIGNED NOT NULL,
  `calle` varchar(120) NOT NULL,
  `altura` int(11) NOT NULL,
  `barrio` varchar(120) NOT NULL,
  `cp` varchar(30) NOT NULL,
  `ciudad` varchar(120) NOT NULL,
  `provincia` varchar(120) NOT NULL,
  `pais` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`direccion_id`, `calle`, `altura`, `barrio`, `cp`, `ciudad`, `provincia`, `pais`) VALUES
(1, 'Calle falsa', 123, 'Urquiza', '1234', 'Springfield', 'Massachusetts', 'Argentina'),
(2, 'Calle otra', 456, 'Ameghino', '5678', 'Daireaux', 'Buenos Aires', 'Argentina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_publicacion`
--

CREATE TABLE `estados_publicacion` (
  `estado_publicacion_id` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estados_publicacion`
--

INSERT INTO `estados_publicacion` (`estado_publicacion_id`, `nombre`) VALUES
(1, 'Draft'),
(2, 'Publicada'),
(3, 'Deshabilitada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `producto_id` int(10) UNSIGNED NOT NULL,
  `categoria_fk` tinyint(3) UNSIGNED NOT NULL,
  `subcategoria_fk` tinyint(3) UNSIGNED NOT NULL,
  `talle_fk` tinyint(3) UNSIGNED NOT NULL,
  `estado_publicacion_fk` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `precio` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen_miniatura` varchar(120) NOT NULL,
  `imagen_grande_01` varchar(120) NOT NULL,
  `imagen_chica_01` varchar(120) NOT NULL,
  `imagen_descripcion` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`producto_id`, `categoria_fk`, `subcategoria_fk`, `talle_fk`, `estado_publicacion_fk`, `nombre`, `precio`, `descripcion`, `imagen_miniatura`, `imagen_grande_01`, `imagen_chica_01`, `imagen_descripcion`, `stock`) VALUES
(1, 1, 4, 7, 2, 'Gabardina Nº 1', 2999, 'Las gorras de gabardina son ideales para cualquier tipo de clima. Este modelo, en especial, es de una gabardina gruesa por lo que te protejerá de un clima frío.', 'img-miniatura-producto-1.jpg', 'img-grande1-producto-1.jpg', 'img-min1-producto-1.jpg', 'Gorra de gabardina color verde irlandés con bordado blanco', 10),
(2, 1, 4, 7, 2, 'Gabardina Nº 2', 2999, 'Las gorras de gabardina son ideales para cualquier tipo de clima. Este modelo, en especial, es de una gabardina gruesa por lo que te protejerá de un clima frío.', 'img-miniatura-producto-2.jpg', 'img-grande1-producto-2.jpg', 'img-min1-producto-2.jpg', 'Gorra de gabardina color azul marino con bordado de pino blanco.', 10),
(3, 1, 4, 7, 2, 'Gabardina Nº 3', 2999, 'Las gorras de gabardina son ideales para cualquier tipo de clima. Este modelo, en especial, es de una gabardina gruesa por lo que te protejerá de un clima frío.', 'img-miniatura-producto-3.jpg', 'img-grande1-producto-3.jpg', 'img-min1-producto-3.jpg', 'Gorra de gabardina color rojo con bordado de la palabra en inglés \'wild\' en blanco.', 10),
(4, 1, 3, 7, 2, 'Snapback Nº 1', 4999, 'Las gorras snapback tienen un estilo urbano que las hacen únicas. Son de tamaño amplio lo que las convierte en uno de los modelos mas confortables de gorras.', 'img-miniatura-producto-4.jpg', 'img-grande1-producto-4.jpg', 'img-min1-producto-4.jpg', 'Gorra snapback color negra con bordado en blanco.', 10),
(5, 1, 3, 7, 2, 'Snapback Nº 2', 4999, 'Las gorras snapback tienen un estilo urbano que las hacen únicas. Son de tamaño amplio lo que las convierte en uno de los modelos mas confortables de gorras.', 'img-miniatura-producto-5.jpg', 'img-grande1-producto-5.jpg', 'img-min1-producto-5.jpg', 'Gorra snapback color bordó con bordado en crudo.', 10),
(6, 1, 2, 7, 2, 'Trucker Nº 1', 4499, 'Las gorras trucker son unas gorras clasicas que en la parte trasera están cubiertas por una red plásica que las convierten en el modelo de gorras ideal para verano.', '20230613163707_img-miniatura-producto-6.jpg', 'img-grande1-producto-6.jpg', 'img-min1-producto-6.jpg', 'Gorra trucker color beige y verde oliva con parche bordado beige y naranja.', 10),
(7, 1, 2, 7, 2, 'Trucker Nº 2', 4499, 'Las gorras trucker son unas gorras clasicas que en la parte trasera están cubiertas por una red plásica que las convierten en el modelo de gorras ideal para verano.', 'img-miniatura-producto-7.jpg', 'img-grande1-producto-7.jpg', 'img-min1-producto-7.jpg', 'Gorra trucker color beige, terracota y naranja con parche bordado negro y naranja.', 10),
(8, 1, 2, 7, 2, 'Trucker Nº 3', 4499, 'Las gorras trucker son unas gorras clasicas que en la parte trasera están cubiertas por una red plásica que las convierten en el modelo de gorras ideal para verano.', 'img-miniatura-producto-8.jpg', 'img-grande1-producto-8.jpg', 'img-min1-producto-8.jpg', 'Gorra trucker color blanca y verde irlandés con parche bordado rojo y blanco.', 10),
(24, 1, 1, 7, 2, 'PRODUCTO CREADO', 8000, 'Descripcion de producto creado nuevo', '20230531161559_img-miniatura-producto-1.jpg', '20230531163859_img-grande1-producto-4.jpg', '20230531163143_img-min1-producto-5.jpg', 'Gorra snapback 3', 20),
(25, 1, 3, 7, 2, 'Pruducto ultimo', 123, 'eadesade', '20230611215244_20230611214316_img-miniatura-producto-3.jpg', '20230617190652_img-grande1-producto-3.jpg', '20230611215244_20230611214316_img-min1-producto-3.jpg', 'sadeasdaes', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_tienen_colores`
--

CREATE TABLE `productos_tienen_colores` (
  `producto_fk` int(10) UNSIGNED NOT NULL,
  `color_fk` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos_tienen_colores`
--

INSERT INTO `productos_tienen_colores` (`producto_fk`, `color_fk`) VALUES
(6, 1),
(7, 1),
(8, 1),
(4, 2),
(1, 4),
(3, 4),
(5, 4),
(1, 5),
(6, 5),
(8, 5),
(1, 6),
(2, 6),
(7, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_tienen_compras`
--

CREATE TABLE `productos_tienen_compras` (
  `producto_fk` int(10) UNSIGNED NOT NULL,
  `compra_fk` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos_tienen_compras`
--

INSERT INTO `productos_tienen_compras` (`producto_fk`, `compra_fk`, `cantidad`) VALUES
(1, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `roles_id` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`roles_id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Visitante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE `subcategorias` (
  `subcategoria_id` tinyint(3) UNSIGNED NOT NULL,
  `categoria_fk` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`subcategoria_id`, `categoria_fk`, `nombre`) VALUES
(1, 1, 'Trucker'),
(2, 1, 'Trucker Premium'),
(3, 1, 'Snapback'),
(4, 1, 'Gabardina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talles`
--

CREATE TABLE `talles` (
  `talle_id` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `talles`
--

INSERT INTO `talles` (`talle_id`, `nombre`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL'),
(5, '2XL'),
(6, '3XL'),
(7, 'Único');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `rol_fk` tinyint(3) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `empresa` varchar(150) DEFAULT NULL,
  `cuit_cuil` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `rol_fk`, `email`, `password`, `telefono`, `username`, `empresa`, `cuit_cuil`) VALUES
(1, 1, 'edmundoalvarezok@gmail.com', '$2y$10$ZRTDJjjdDX2GDVQAVCi8T.h8Ka3NZMb.EIBlsKA5.o4KlG88Ycfku', 12345, 'edmundoalvarez', 'Mi empresa', '302432419'),
(2, 2, 'visitante@gmail.com', '$2y$10$ZRTDJjjdDX2GDVQAVCi8T.h8Ka3NZMb.EIBlsKA5.o4KlG88Ycfku', 12345, 'pedroperez', 'Otra empresa', '30243242319'),
(3, 2, 'visitante2@hotmail.com', '$2y$10$ZRTDJjjdDX2GDVQAVCi8T.h8Ka3NZMb.EIBlsKA5.o4KlG88Ycfku', 12345, 'visitante2', NULL, '230342309');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_tienen_direcciones`
--

CREATE TABLE `usuarios_tienen_direcciones` (
  `usuario_fk` int(10) UNSIGNED NOT NULL,
  `direccion_fk` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios_tienen_direcciones`
--

INSERT INTO `usuarios_tienen_direcciones` (`usuario_fk`, `direccion_fk`) VALUES
(2, 1),
(3, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`color_id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`compra_id`),
  ADD KEY `fk_compras_usuarios1_idx` (`usuario_fk`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`direccion_id`);

--
-- Indices de la tabla `estados_publicacion`
--
ALTER TABLE `estados_publicacion`
  ADD PRIMARY KEY (`estado_publicacion_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`producto_id`),
  ADD KEY `fk_productos_categorias1_idx` (`categoria_fk`),
  ADD KEY `fk_productos_talles1_idx` (`talle_fk`),
  ADD KEY `fk_productos_subcategorias1_idx` (`subcategoria_fk`),
  ADD KEY `fk_productos_estados_publicacion1_idx` (`estado_publicacion_fk`);

--
-- Indices de la tabla `productos_tienen_colores`
--
ALTER TABLE `productos_tienen_colores`
  ADD PRIMARY KEY (`producto_fk`,`color_fk`),
  ADD KEY `fk_productos_has_colores_colores1_idx` (`color_fk`),
  ADD KEY `fk_productos_has_colores_productos1_idx` (`producto_fk`);

--
-- Indices de la tabla `productos_tienen_compras`
--
ALTER TABLE `productos_tienen_compras`
  ADD PRIMARY KEY (`producto_fk`,`compra_fk`),
  ADD KEY `fk_productos_has_compras_compras1_idx` (`compra_fk`),
  ADD KEY `fk_productos_has_compras_productos1_idx` (`producto_fk`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roles_id`);

--
-- Indices de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`subcategoria_id`),
  ADD KEY `fk_subcategorias_categorias1_idx` (`categoria_fk`);

--
-- Indices de la tabla `talles`
--
ALTER TABLE `talles`
  ADD PRIMARY KEY (`talle_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `cuit_empresa_UNIQUE` (`cuit_cuil`),
  ADD KEY `fk_usuarios_roles_idx` (`rol_fk`);

--
-- Indices de la tabla `usuarios_tienen_direcciones`
--
ALTER TABLE `usuarios_tienen_direcciones`
  ADD PRIMARY KEY (`usuario_fk`,`direccion_fk`),
  ADD KEY `fk_usuarios_has_direcciones_direcciones1_idx` (`direccion_fk`),
  ADD KEY `fk_usuarios_has_direcciones_usuarios1_idx` (`usuario_fk`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `categoria_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `colores`
--
ALTER TABLE `colores`
  MODIFY `color_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `compra_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `direccion_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estados_publicacion`
--
ALTER TABLE `estados_publicacion`
  MODIFY `estado_publicacion_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `producto_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `roles_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `subcategoria_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `talles`
--
ALTER TABLE `talles`
  MODIFY `talle_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_compras_usuarios1` FOREIGN KEY (`usuario_fk`) REFERENCES `usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categorias1` FOREIGN KEY (`categoria_fk`) REFERENCES `categorias` (`categoria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productos_estados_publicacion1` FOREIGN KEY (`estado_publicacion_fk`) REFERENCES `estados_publicacion` (`estado_publicacion_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productos_subcategorias1` FOREIGN KEY (`subcategoria_fk`) REFERENCES `subcategorias` (`subcategoria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productos_talles1` FOREIGN KEY (`talle_fk`) REFERENCES `talles` (`talle_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos_tienen_colores`
--
ALTER TABLE `productos_tienen_colores`
  ADD CONSTRAINT `fk_productos_has_colores_colores1` FOREIGN KEY (`color_fk`) REFERENCES `colores` (`color_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productos_has_colores_productos1` FOREIGN KEY (`producto_fk`) REFERENCES `productos` (`producto_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos_tienen_compras`
--
ALTER TABLE `productos_tienen_compras`
  ADD CONSTRAINT `fk_productos_has_compras_compras1` FOREIGN KEY (`compra_fk`) REFERENCES `compras` (`compra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productos_has_compras_productos1` FOREIGN KEY (`producto_fk`) REFERENCES `productos` (`producto_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD CONSTRAINT `fk_subcategorias_categorias1` FOREIGN KEY (`categoria_fk`) REFERENCES `categorias` (`categoria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_fk`) REFERENCES `roles` (`roles_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios_tienen_direcciones`
--
ALTER TABLE `usuarios_tienen_direcciones`
  ADD CONSTRAINT `fk_usuarios_has_direcciones_direcciones1` FOREIGN KEY (`direccion_fk`) REFERENCES `direcciones` (`direccion_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuarios_has_direcciones_usuarios1` FOREIGN KEY (`usuario_fk`) REFERENCES `usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
