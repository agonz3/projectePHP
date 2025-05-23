<?php
include('connection.php');

// Script para crear tablas e insertar datos iniciales
$sql = "
CREATE TABLE IF NOT EXISTS `modificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `tipo` enum('Motor','Suspensión','Frenos','Transmisión','Turbo','Neumáticos','Carrocería','Pintura','Ventanas','Adornos','Luces','Placa','Escape','Capó','Parachoques','Alerón','Volante','Radio','Hidráulica','Nitrógeno','Blindaje','Tinte','Neón') NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `nivel_mejora` int(11) NOT NULL COMMENT '1-5',
  `requisitos` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `servicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `duracion_estimada` varchar(50) NOT NULL COMMENT 'En horas o días',
  `tipo` enum('Mantenimiento','Reparación','Personalización','Limpieza','Seguridad','Otros') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `modificaciones` (`nombre`, `tipo`, `descripcion`, `precio`, `nivel_mejora`, `requisitos`) VALUES
('Turbo Nivel 3', 'Turbo', 'Aumenta significativamente la potencia del motor', 15000.00, 3, 'Nivel 3 de motor requerido'),
('Pintura Metálica Roja', 'Pintura', 'Pintura metálica de color rojo intenso', 5000.00, 1, NULL),
('Neón Azul', 'Neón', 'Luces de neón azul para el chasis', 7500.00, 1, NULL),
('Frenos Deportivos', 'Frenos', 'Frenos de alto rendimiento para mejor control', 12000.00, 2, NULL),
('Blindaje Nivel 4', 'Blindaje', 'Protección contra balas y explosiones', 50000.00, 4, 'Garaje propiedad requerido');

INSERT INTO `servicios` (`nombre`, `descripcion`, `precio`, `duracion_estimada`, `tipo`) VALUES
('Lavado Premium', 'Lavado exterior e interior completo con cerámica', 2500.00, '1 hora', 'Limpieza'),
('Cambio de Aceite', 'Cambio de aceite y filtro con productos premium', 8000.00, '30 minutos', 'Mantenimiento'),
('Tuning Completo', 'Personalización completa del vehículo', 35000.00, '3 horas', 'Personalización'),
('Reparación de Motor', 'Diagnóstico y reparación de problemas de motor', 20000.00, '1 día', 'Reparación'),
('Instalación de Blindaje', 'Instalación profesional de blindaje para vehículo', 60000.00, '2 días', 'Seguridad');
";

if ($conn->multi_query($sql)) {
    echo "Base de datos inicializada correctamente";
} else {
    echo "Error al inicializar: " . $conn->error;
}

$conn->close();