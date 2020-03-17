-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-07-2018 a las 01:30:12
-- Versión del servidor: 10.1.24-MariaDB
-- Versión de PHP: 7.1.6
create database sigpe_test;
use sigpe_test;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sigpe_test`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulaciones`
--

CREATE TABLE `titulaciones` (
  `id` int NOT NULL auto_increment primary key,
  `nombre` varchar(250) NOT NULL COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `plan_cd` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `planId` int NOT NULL,
  `planAct` varchar(1) NOT NULL DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `titulaciones` (`id`,`nombre`,`tipo`,`plan_cd`,`planId`,`planAct`) VALUES (1,'Bachillerato en Gestión en Recreación y Turismo',NULL,'.2019-10-03-18-53-37',4,'S');
INSERT INTO `titulaciones` (`id`,`nombre`,`tipo`,`plan_cd`,`planId`,`planAct`) VALUES (2,'Diplomado en Promoción y Guía de Recreación y Turismo',NULL,'15010102002019-10-03-18-41-19',3,'S');
INSERT INTO `titulaciones` (`id`,`nombre`,`tipo`,`plan_cd`,`planId`,`planAct`) VALUES (3,'Especialidad Profesional en Medicina, Cirugía y Reproducción de Equinos',NULL,'8010806002019-10-03-17-36-56',1,'S');
INSERT INTO `titulaciones` (`id`,`nombre`,`tipo`,`plan_cd`,`planId`,`planAct`) VALUES (4,'Mágister en Epidemiología',NULL,'8010907002019-10-03-18-18-31',2,'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acreditaciones`
--

CREATE TABLE `acreditaciones` (
  `AcredCod` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `FechaFin` date NOT NULL,
  `Detalle` varchar(100) DEFAULT NULL,
  `planId` int(255) NOT NULL,
  `planCd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `planAct` varchar(1) NOT NULL DEFAULT 'Y',
  `tipo` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `VERSIONES PDF`
--

CREATE TABLE `versiones_pdf` (
  `id` int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `plancd` int(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE versiones_pdf AUTO_INCREMENT=1;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campus`
--

CREATE TABLE `campus` (
  `Id` int(20) NOT NULL,
  `Campus` varchar(30) NOT NULL,
  `Notas` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `campus`
--

INSERT INTO `campus` (`Id`, `Campus`, `Notas`) VALUES
(1, 'Omar Dengo', 'Campun Central Heredia'),
(2, 'Campus Liberia', NULL),
(3, 'Campus Nicoya', NULL),
(4, 'Campus Pérez Zeledón', NULL),
(5, 'Campus Coto', NULL),
(6, 'Campus Benjamín Núñez', NULL),
(7, 'Sección Regional Sarapiquí', NULL),
(8, 'Interuniversitaria de Alajuela', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `definicionplan`
--

CREATE TABLE `definicionplan` (
  `DefinicionPlanId` varchar(255) NOT NULL,
  `PlanNombre` varchar(200) NOT NULL,
  `Ind` varchar(10) NOT NULL,
  `FechaCreacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `definicionplan`
--

INSERT INTO `definicionplan` (`DefinicionPlanId`,`PlanNombre`,`Ind`,`FechaCreacion`) VALUES ('.2019-10-03-18-53-37','Gestión en Recreación y Turismo','Y',NULL);
INSERT INTO `definicionplan` (`DefinicionPlanId`,`PlanNombre`,`Ind`,`FechaCreacion`) VALUES ('15010102002019-10-03-18-41-19','Promoción y Guía de Recreación y Turismo','Y',NULL);
INSERT INTO `definicionplan` (`DefinicionPlanId`,`PlanNombre`,`Ind`,`FechaCreacion`) VALUES ('8010806002019-10-03-17-36-56','Medicina, Cirugía y Reproducción de Equinos','Y',NULL);
INSERT INTO `definicionplan` (`DefinicionPlanId`,`PlanNombre`,`Ind`,`FechaCreacion`) VALUES ('8010907002019-10-03-18-18-31','Epidemiología','Y',NULL);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `codigoDoc` int(100) NOT NULL,
  `nombre` varchar(500) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fecha` date NOT NULL,
  `detalle` varchar(90) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `archivoFisico` varchar(300) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `tipoDoc` varchar(500) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `plan_cd` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `planId` int(255) NOT NULL,
  `planAct` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `documento`
--
INSERT INTO `documento` (`codigoDoc`,`nombre`,`fecha`,`detalle`,`archivoFisico`,`tipoDoc`,`plan_cd`,`planId`,`planAct`) VALUES (1,'CNR-310-98EspecialidadProfesionalenMedicinaVeterinariadeEquinos.pdf','2019-10-03','CNR-310-98EspecialidadProfesionalenMedicinaVeterinariadeEquinos.pdf','public/uploads/1/CNR/CNR-310-98EspecialidadProfesionalenMedicinaVeterinariadeEquinos.pdf','CNR','8010806002019-10-03-17-36-56',1,'Y');
INSERT INTO `documento` (`codigoDoc`,`nombre`,`fecha`,`detalle`,`archivoFisico`,`tipoDoc`,`plan_cd`,`planId`,`planAct`) VALUES (2,'OPES-12-2000MaestriaenEpidemiologia.pdf.pdf','2019-10-03','OPES-12-2000MaestriaenEpidemiologia.pdf.pdf','public/uploads/2/OPES/OPES-12-2000MaestriaenEpidemiologia.pdf.pdf','OPES','8010907002019-10-03-18-18-31',2,'Y');
INSERT INTO `documento` (`codigoDoc`,`nombre`,`fecha`,`detalle`,`archivoFisico`,`tipoDoc`,`plan_cd`,`planId`,`planAct`) VALUES (3,'OPES-04-2009Diplomadoenrecreacionturistica.pdf.pdf','2019-10-03','OPES-04-2009Diplomadoenrecreacionturistica.pdf.pdf','public/uploads/3/OPES/OPES-04-2009Diplomadoenrecreacionturistica.pdf.pdf','OPES','15010102002019-10-03-18-41-19',3,'Y');
INSERT INTO `documento` (`codigoDoc`,`nombre`,`fecha`,`detalle`,`archivoFisico`,`tipoDoc`,`plan_cd`,`planId`,`planAct`) VALUES (4,'CNR-065-09DiplomadoenRecreacionTuristica.PDF','2019-10-03','CNR-065-09DiplomadoenRecreacionTuristica.PDF','public/uploads/3/CNR/CNR-065-09DiplomadoenRecreacionTuristica.PDF','CNR','15010102002019-10-03-18-41-19',3,'Y');
INSERT INTO `documento` (`codigoDoc`,`nombre`,`fecha`,`detalle`,`archivoFisico`,`tipoDoc`,`plan_cd`,`planId`,`planAct`) VALUES (5,'CNR-392-10.pdf','2019-10-03','CNR-392-10.pdf','public/uploads/2/CNR/CNR-392-10.pdf','CNR','8010907002019-10-03-18-18-31',2,'Y');
INSERT INTO `documento` (`codigoDoc`,`nombre`,`fecha`,`detalle`,`archivoFisico`,`tipoDoc`,`plan_cd`,`planId`,`planAct`) VALUES (6,'CNR-328-06.pdf','2019-10-03','CNR-328-06.pdf','public/uploads/2/CNR/CNR-328-06.pdf','CNR','8010907002019-10-03-18-18-31',2,'Y');
INSERT INTO `documento` (`codigoDoc`,`nombre`,`fecha`,`detalle`,`archivoFisico`,`tipoDoc`,`plan_cd`,`planId`,`planAct`) VALUES (7,'CNR-329-06.pdf','2019-10-03','CNR-329-06.pdf','public/uploads/2/CNR/CNR-329-06.pdf','CNR','8010907002019-10-03-18-18-31',2,'Y');
INSERT INTO `documento` (`codigoDoc`,`nombre`,`fecha`,`detalle`,`archivoFisico`,`tipoDoc`,`plan_cd`,`planId`,`planAct`) VALUES (8,'CNR-199-02MaestriaenEpidemiologia.pdf','2019-10-03','CNR-199-02MaestriaenEpidemiologia.pdf','public/uploads/2/CNR/CNR-199-02MaestriaenEpidemiologia.pdf','CNR','8010907002019-10-03-18-18-31',2,'Y');
INSERT INTO `documento` (`codigoDoc`,`nombre`,`fecha`,`detalle`,`archivoFisico`,`tipoDoc`,`plan_cd`,`planId`,`planAct`) VALUES (9,'OPES-17-2015.pdf.pdf','2019-10-03','OPES-17-2015.pdf.pdf','public/uploads/4/OPES/OPES-17-2015.pdf.pdf','OPES','.2019-10-03-18-53-37',4,'Y');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfasis`
--

CREATE TABLE `enfasis` (
  `codigoE` int(30) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `plan_cd` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `planId` int(255) NOT NULL,
  `planAct` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

INSERT INTO `enfasis` (`codigoE`,`descripcion`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (1,'Epidemiología de campo y laboratorio diagnóstico','Epidemiología de campo y laboratorio diagnóstico','8010907002019-10-03-18-18-31',2,'Y');
INSERT INTO `enfasis` (`codigoE`,`descripcion`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (2,'Gestión en salud animal','Gestión en salud animal','8010907002019-10-03-18-18-31',2,'Y');
INSERT INTO `enfasis` (`codigoE`,`descripcion`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (3,'Epidemiología aplicada a los sistemas de salud','Epidemiología aplicada a los sistemas de salud','8010907002019-10-03-18-18-31',2,'Y');


--
-- Estructura de tabla para la tabla `estructuracurricular`
--

CREATE TABLE `estructuracurricular` (
  `estructura_id` int(11) NOT NULL primary KEY auto_increment,
  `estructura_excel` varchar(255) NOT NULL,
  `estructura_pdf` varchar(255) NOT NULL,
  `plan_pdf` varchar(255) NOT NULL  DEFAULT '-',
  `activo_ind` varchar(1) NOT NULL DEFAULT 'S',
  `plan_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE estructuracurricular AUTO_INCREMENT=1;

INSERT INTO `estructuracurricular` (`estructura_id`,`estructura_excel`,`estructura_pdf`,`plan_pdf`,`activo_ind`,`plan_id`) VALUES (2,'uploads/estructuras/03-10-2019-10-18ECMaEpidemiologia2018.docx','uploads/estructuras/03-10-2019-10-18ECMaEpidemiologia2018.pdf','uploads/pdfs/ListadocursosMaEpidemiologia2018.pdf','S','2');
INSERT INTO `estructuracurricular` (`estructura_id`,`estructura_excel`,`estructura_pdf`,`plan_pdf`,`activo_ind`,`plan_id`) VALUES (3,'uploads/estructuras/03-10-2019-10-41DiplInstypromsalfis2014.docx','uploads/estructuras/03-10-2019-10-41DiplInstypromsalfis2014.pdf','uploads/pdfs/ListadocursosDiplInstypromsalfis2014.pdf','S','3');
INSERT INTO `estructuracurricular` (`estructura_id`,`estructura_excel`,`estructura_pdf`,`plan_pdf`,`activo_ind`,`plan_id`) VALUES (4,'uploads/estructuras/03-10-2019-10-53BachenPromSaludFisica2015.docx','uploads/estructuras/03-10-2019-10-53BachenPromSaludFisica2015.pdf','uploads/pdfs/ListadoBachenPromSaludFisica2015.pdf','S','4');
--
-- Estructura de tabla para la tabla `etiqueta`
--
CREATE TABLE `etiqueta` (
`id` int NOT NULL auto_increment primary key,
`nombre` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
`plan_cd` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
`planId` int NOT NULL,
`planAct` varchar(1) NOT NULL DEFAULT 'S'
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

INSERT INTO `etiqueta` (`id`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (1,'Equinos','8010806002019-10-03-17-36-56',1,'S');
INSERT INTO `etiqueta` (`id`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (2,'Medicina','8010806002019-10-03-17-36-56',1,'S');
INSERT INTO `etiqueta` (`id`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (3,'Cirugía','8010806002019-10-03-17-36-56',1,'S');
INSERT INTO `etiqueta` (`id`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (4,'Epidemiología','8010907002019-10-03-18-18-31',2,'S');
INSERT INTO `etiqueta` (`id`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (5,'Recreación Turística','15010102002019-10-03-18-41-19',3,'S');
INSERT INTO `etiqueta` (`id`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (6,'Turismo','15010102002019-10-03-18-41-19',3,'S');
INSERT INTO `etiqueta` (`id`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (7,'Recreación','15010102002019-10-03-18-41-19',3,'S');
INSERT INTO `etiqueta` (`id`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (8,'Promoción','15010102002019-10-03-18-41-19',3,'S');
INSERT INTO `etiqueta` (`id`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (9,'Guía','15010102002019-10-03-18-41-19',3,'S');
INSERT INTO `etiqueta` (`id`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (10,'Gestión','.2019-10-03-18-53-37',4,'S');
INSERT INTO `etiqueta` (`id`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (11,'Recreación','.2019-10-03-18-53-37',4,'S');
INSERT INTO `etiqueta` (`id`,`nombre`,`plan_cd`,`planId`,`planAct`) VALUES (12,'Turismo','.2019-10-03-18-53-37',4,'S');



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fcs`
--

CREATE TABLE `fcs` (
  `id` int primary key auto_increment NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `DetalleExtra` varchar(300) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `codigo` varchar(6) COLLATE utf8mb4_unicode_520_ci NOT NULL unique key
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `fcs`
INSERT INTO `fcs` (`codigo`, `nombre`) VALUES
('CEG', 'Centro de Estudios Generales'),
('FFL', 'Facultad de Filosofía y Letras'),
('FCS', 'Facultad de Ciencias Sociales'),
('FCEN', 'Facultad de Ciencias Exactas y Naturales'),
('FCTM', 'Facultad de Ciencias de la Tierra y el Mar'),
('FCSA', 'Facultad de Ciencias de la Salud'),
('CIDE', 'Centro de Investigación y la Docencia en Educación'),
('CIDEA', 'Centro de Investigación, Docencia y Extensión Artística');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan`
--

CREATE TABLE `plan` (
  `RowID_Plan` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `PlanCd` int NOT NULL,
  `DefinicionPlanId` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `codigoRegistro` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `codigoBanner` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL, 
  `codigoBanner2` varchar(50) COLLATE utf8mb4_unicode_520_ci NULL,
  `nombrePlan` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `gradoAcademico` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `unidad_Academica` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `otras_universidades` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `tipo_carrera` varchar(8) NOT NULL,
  `tipoPlan` varchar(12) NOT NULL,
  `oferta` varchar(14) NOT NULL,
  `ComentarioOferta` text COLLATE utf8mb4_unicode_520_ci,
  `aprobacion` date NOT NULL,
  `redisenno` date NOT NULL,
  `ComentariosGenerales` text COLLATE utf8mb4_unicode_520_ci,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL default 'uploads/planesdeEstudio/curso2.jpg',
  `Usuario` varchar(30) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `FechaCreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `HistoricoInd` varchar(1) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'N',
  `fecha_historico` date NULL,
  `declaracion_planTerminal` varchar(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `plan`
--
-- --------------------------------------------------------
INSERT INTO `plan` (`RowID_Plan`,`PlanCd`,`DefinicionPlanId`,`codigoRegistro`,`codigoBanner`,`codigoBanner2`,`nombrePlan`,`gradoAcademico`,`unidad_Academica`,`otras_universidades`,`tipo_carrera`,`tipoPlan`,`oferta`,`ComentarioOferta`,`aprobacion`,`redisenno`,`ComentariosGenerales`,`logo`,`Usuario`,`FechaCreacion`,`HistoricoInd`,`fecha_historico`,`declaracion_planTerminal`) VALUES ('.2019-10-03-18-53-37',4,'.2019-10-03-18-53-37','.','BA-GERETUR 2016-10',NULL,'Gestión en Recreación y Turismo','Bachillerato en','Escuela de Ciencias del Deporte y el Movimiento Humano y Calidad de Vida','','CONARE','Grado','Se oferta','','2015-07-01','1970-01-01','CNR-197-15 Creación','uploads/planesdeEstudio/curso2.jpg','117000387','2019-10-03 10:53:37','N',NULL,'N');
INSERT INTO `plan` (`RowID_Plan`,`PlanCd`,`DefinicionPlanId`,`codigoRegistro`,`codigoBanner`,`codigoBanner2`,`nombrePlan`,`gradoAcademico`,`unidad_Academica`,`otras_universidades`,`tipo_carrera`,`tipoPlan`,`oferta`,`ComentarioOferta`,`aprobacion`,`redisenno`,`ComentariosGenerales`,`logo`,`Usuario`,`FechaCreacion`,`HistoricoInd`,`fecha_historico`,`declaracion_planTerminal`) VALUES ('15010102002019-10-03-18-41-19',3,'15010102002019-10-03-18-41-19','1501010200','DI-PRGURT 2016-10',NULL,'Promoción y Guía de Recreación y Turismo','Diplomado en','Escuela de Ciencias del Deporte y el Movimiento Humano y Calidad de Vida','','CONARE','Grado','Se oferta','','2009-03-10','1970-01-01','Antes se llamaba Recreación Turística con código Banner DI-RETURIST','uploads/planesdeEstudio/curso2.jpg','117000387','2019-10-03 10:41:19','N',NULL,'N');
INSERT INTO `plan` (`RowID_Plan`,`PlanCd`,`DefinicionPlanId`,`codigoRegistro`,`codigoBanner`,`codigoBanner2`,`nombrePlan`,`gradoAcademico`,`unidad_Academica`,`otras_universidades`,`tipo_carrera`,`tipoPlan`,`oferta`,`ComentarioOferta`,`aprobacion`,`redisenno`,`ComentariosGenerales`,`logo`,`Usuario`,`FechaCreacion`,`HistoricoInd`,`fecha_historico`,`declaracion_planTerminal`) VALUES ('8010806002019-10-03-17-36-56',1,'8010806002019-10-03-17-36-56','801080600','ES-MEDREQ',NULL,'Medicina, Cirugía y Reproducción de Equinos','Especialidad en','Programa Regional de Posgrado en Ciencias Veterinarias Tropicales','','CONARE','PosGrado','Inactiva','Aprobado en 1998','1998-11-26','1970-01-01','Inactivo desde 2013','uploads/planesdeEstudio/curso2.jpg','117000387','2019-10-03 09:36:56','N',NULL,'N');
INSERT INTO `plan` (`RowID_Plan`,`PlanCd`,`DefinicionPlanId`,`codigoRegistro`,`codigoBanner`,`codigoBanner2`,`nombrePlan`,`gradoAcademico`,`unidad_Academica`,`otras_universidades`,`tipo_carrera`,`tipoPlan`,`oferta`,`ComentarioOferta`,`aprobacion`,`redisenno`,`ComentariosGenerales`,`logo`,`Usuario`,`FechaCreacion`,`HistoricoInd`,`fecha_historico`,`declaracion_planTerminal`) VALUES ('8010907002019-10-03-18-18-31',2,'8010907002019-10-03-18-18-31','801090700','MA-EPIDEA 2007-05','MA-EPIDEP 2018-05','Epidemiología','Maestria en','Programa Regional de Posgrado en Ciencias Veterinarias Tropicales','','CONARE','PosGrado','Se oferta','Solo se oferta la maestría profesional con énfasis en sistemas de salud.','2000-04-01','2010-11-12','En el 2006 se abre el énfasis en campo y laboratorio diagnóstico. En el 2006 se abre el énfasis en gestión animal. En el 2010 se abre énfasis aplicado a los sistemas de salud. En el 2017 se modifica el tronco común de la modalidad profesional.','uploads/planesdeEstudio/curso2.jpg','117000387','2019-10-03 10:18:31','N',NULL,'N');

--
-- Estructura de tabla para la tabla `plan_campus`
--

CREATE TABLE `plan_campus` (
  `Id` int(11) NOT NULL,
  `plan_cd` varchar(50) NOT NULL,
  `campus_cd` int(20) NOT NULL,
  `EstadoPlan` varchar(10) DEFAULT NULL,
  `planId` int(255) NOT NULL,
  `planAct` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `plan_campus`
--
INSERT INTO `plan_campus` (`Id`,`plan_cd`,`campus_cd`,`EstadoPlan`,`planId`,`planAct`) VALUES (1,'8010806002019-10-03-17-36-56',6,'Presencial',1,'Y');
INSERT INTO `plan_campus` (`Id`,`plan_cd`,`campus_cd`,`EstadoPlan`,`planId`,`planAct`) VALUES (2,'8010907002019-10-03-18-18-31',6,'Presencial',2,'Y');
INSERT INTO `plan_campus` (`Id`,`plan_cd`,`campus_cd`,`EstadoPlan`,`planId`,`planAct`) VALUES (3,'15010102002019-10-03-18-41-19',7,'Presencial',3,'Y');
INSERT INTO `plan_campus` (`Id`,`plan_cd`,`campus_cd`,`EstadoPlan`,`planId`,`planAct`) VALUES (4,'.2019-10-03-18-53-37',7,'Presencial',4,'Y');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas_disciplinarias`
CREATE TABLE `areas_disciplinarias` (
  `Id` int NOT NULL primary key AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `plan_cd` varchar(50) NOT NULL,
  `planId` int NOT NULL,
  `planAct` varchar(1) NOT NULL DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Estructura de tabla para la tabla `salidas`
--

CREATE TABLE `salidas` (
  `Id` int(11) NOT NULL,
  `SalidaLateral` varchar(100) NOT NULL,
  `comentario` text,
  `plan_cd` varchar(50) NOT NULL,
  `planId` int(255) NOT NULL,
  `planAct` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `salidas`
--
INSERT INTO `salidas` (`Id`,`SalidaLateral`,`comentario`,`plan_cd`,`planId`,`planAct`) VALUES (1,'Diplomado en Promoción y Guía de Recreación y Turismo','','.2019-10-03-18-53-37',4,'Y');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidadacademica`
--

CREATE TABLE `unidadacademica` (
  `id_unidad` int primary key auto_increment NOT NULL,
  `codigoU` varchar(12) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `nombre` varchar(90) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `subunidad` varchar(90) COLLATE utf8mb4_unicode_520_ci NULL,
  `fcs_codigo` int NOT NULL,
  `telefono1` varchar(8) NOT NULL default '-',
  `telefono2` varchar(8) NULL,
  `pag_web` varchar(150) COLLATE utf8mb4_unicode_520_ci NOT NULL default '-',
  `email` varchar(90) COLLATE utf8mb4_unicode_520_ci NOT NULL default '-',
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL default '-',
  `imagen` varchar(255) NOT NULL default'uploads/unidadesAcademicas/curso2.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `unidadacademica`
--
INSERT INTO `unidadacademica` (`codigoU`,`nombre`,`fcs_codigo`) VALUES
('ELCL','Escuela de Literatura y Ciencias del Lenguaje',2),
('AESP',' Área de Español',2),
('AFR','Área de Francés',2),
('AING','Área de Inglés',2),
('EECR','Escuela de Ecuménicas y Ciencias de la Religión',2),
('IDELA','Instituto de Estudios Latinoamericanos',2),
('EF','Escuela de Filosofía',2),
('EBDI','Escuela de Bibliotecología, Documentación e Información',2),
('IEM','Instituto de Estudios de la Mujer',2),
('EH','Escuela de Historia',3),
('ES',' Escuela de Sociología',3),
('EPPS','Escuela de Planificación y Promoción Social',3),
('EDA','Escuela de Administración',3),
('ESP','Escuela de Secretariado Profesional',3),
('ERI','Escuela de Relaciones Internacionales',3),
('EE','Escuela de Economía',3),
('CINPE','Centro Internacional de Política Económica para el Desarrollo Sostenible',3),
('EPS','Escuela de Psicología',3),
('EM','Escuela de Matemática',4),
('ECB','Escuela de Ciencias Biológicas',4),
('EQ','Escuela de Química',4),
('ETCG','Escuela de Topografía, Catastro y Geodesia',4),
('EI','Escuela de Informática',4),
('PROCMAR','Programa de Maestría en Ciencias Marinas y Costeras',4),
('DF','Departamento de Física',4),
('ProGesTic','Posgrado en Gestión de la Tecnología de Información y Comunicación',4),
('ECG','Escuela de Ciencias Geográficas',5),
('ECA','Escuela de Ciencias Agrarias',5),
('ICOMVIS','Instituto de Conservación y Vida Silvestre',5),
('EDECA','Escuela de Ciencias Ambientales',5),
('CINAT','Centro de Investigaciones Apícolas Tropicales',5),
('IRET',' Instituto Regional de Estudios en Sustancias Tóxicas',5),
('INISEFOR','Instituto de Investigación y Servicios Forestales',5),
('EMV','Escuela de Medicina Veterinaria',6),
('PCVET','Programa Regional de Posgrado en Ciencias Veterinarias Tropicales',6),
('CIEMHCAVI','Escuela de Ciencias del Deporte y el Movimiento Humano y Calidad de Vida',6),
('DEB','División de Educación Básica',7),
('DET',' División de Educación para el trabajo',7),
('DER','División de Educación Rural',7),
('DED','División de Educología',7),
('EAE','Escuela de Arte Escénico',8),
('EACV','Escuela de Arte y Comunicación Visual',8),
('ED','Escuela de Danza',8),
('EMU','Escuela de Música',8);

UPDATE unidadacademica set subunidad='Escuela de Medicina Veterinaria' where id_unidad=35;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int primary key auto_increment NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
 -- `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`,`name`,`username`,`password`,`user_level`,`image`,`last_login`,`expiration`) VALUES (1,'Admin Users','admin','d033e22ae348aeb5660fc2140aec35850c4da997',1,'p1x5kuvc1.png','2018-05-06 07:50:59',NULL);
INSERT INTO `users` (`id`,`name`,`username`,`password`,`user_level`,`image`,`last_login`,`expiration`) VALUES (2,'Estefanía Murillo Romero','117000387','ada40a5c42a9c9b151921dd38d1557917931189d',1,'g923umim4.jpg','2019-11-01 06:31:42',NULL);
INSERT INTO `users` (`id`,`name`,`username`,`password`,`user_level`,`image`,`last_login`,`expiration`) VALUES (3,'Carolina Ramirez Herrera ','401780699','4cd3677e5f005658864de9f78234e8eb31b1013b',1,'yzqgv6t3.png','2018-05-18 17:26:39','1970-01-01 00:00:00');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_groups`
--

create table `permisos`(
`id` int auto_increment primary key not null,
`permiso` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci unique key not null,
`nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci unique key not null);
ALTER TABLE permisos AUTO_INCREMENT = 1 ;

CREATE TABLE `user_groups` (
  `id` int auto_increment primary key NOT NULL,
  `group_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL ,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table `grupo_permisos`(
`id` int auto_increment primary key not null,
`id_grupo` int not null,
`id_permiso` int not null);
alter table grupo_permisos add unique (id_grupo,id_permiso);
alter table grupo_permisos add foreign key (id_grupo) references user_groups(id);
alter table grupo_permisos add foreign key(id_permiso) references permisos(id);
--
-- Volcado de datos para la tabla `user_groups`
--
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (1,'agregar_plan','Agregar plan');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (2,'modificar_plan','Modificar plan');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (3,'crear_historico','Agregar plan a partir de uno existente');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (4,'ver_documentos','Ver documentos');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (5,'ver_usuarios','Ver usuarios');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (6,'editar_usuarios','Editar usuarios');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (7,'eliminar_usuarios','Eliminar usuarios');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (8,'agregar_grupo','Agregar grupo');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (9,'editar_grupo','Editar grupos');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (10,'eliminar_grupo','Eliminar grupo');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (11,'agregar_unidad','Agregar Unidad Académica');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (12,'editar_unidad','Editar Unidad Académica');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (13,'eliminar_unidad','Eliminar Unidad Académica');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (14,'agregar_fcs','Agregar Facultad/Centro/Sede/Recinto');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (15,'editar_fcs','Editar Facultad/Centro/Sede/Recinto');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (16,'eliminar_fcs','Eliminar Facultad/Centro/Sede/Recinto');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (17,'ofertar_plan','Ofertar planes ');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (18,'ver_versiones','Ver versiones anteriores de estructuras curriculares');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (19,'crear_reportes','Crear Reportes');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (20,'ver_grupo','Ver grupos');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (21,'agregar_usuario','Agregar usuarios');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (22,'ver_fcs','Ver Facultad/Centro/Sede/Recinto');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (23,'ver_uc','Ver Unidad Académica');
INSERT INTO `permisos` (`id`,`permiso`,`nombre`) VALUES (24,'cambiar_contrasena','Cambiar contraseñas a usuarios');

INSERT INTO `user_groups` (`group_name`,`group_status`) VALUES ('Administradores',1);
INSERT INTO `user_groups` (`group_name`,`group_status`) VALUES ('Asistentes',1);
INSERT INTO `user_groups` (`group_name`,`group_status`) VALUES ('Decanos',1);

INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (1,1,1);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (2,1,2);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (3,1,3);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (4,1,4);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (5,1,5);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (6,1,6);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (7,1,7);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (8,1,8);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (9,1,9);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (10,1,10);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (11,1,11);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (12,1,12);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (13,1,13);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (14,1,14);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (15,1,15);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (16,1,16);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (17,1,17);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (18,1,18);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (19,1,19);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (20,1,20);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (21,1,21);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (22,1,22);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (23,1,23);
INSERT INTO `grupo_permisos` (`id`,`id_grupo`,`id_permiso`) VALUES (24,1,24);
--
-- Indices de la tabla `acreditaciones`
--
ALTER TABLE `acreditaciones`
  ADD PRIMARY KEY (`AcredCod`),
  ADD KEY `acreditaciones_cdfk_2` (`planId`),
  ADD KEY `acreditaciones_cdfk_1` (`planCd`);
--
-- Indices de la tabla `campus`
--
ALTER TABLE `campus`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `definicionplan`
--
ALTER TABLE `definicionplan`
  ADD PRIMARY KEY (`DefinicionPlanId`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`codigoDoc`),
  ADD UNIQUE KEY `documento_codigodoc_unique` (`codigoDoc`),
  ADD KEY `plan_cd` (`plan_cd`),
  ADD KEY `doc_cdfk_2` (`planId`);

--
-- Indices de la tabla `enfasis`
--
ALTER TABLE `enfasis`
  ADD PRIMARY KEY (`codigoE`),
  ADD UNIQUE KEY `enfasis_codigoe_unique` (`codigoE`),
  ADD KEY `enfasis_cdfk_2` (`planId`),
  ADD KEY `enfasis_plan_cod_foreign` (`plan_cd`);

--
-- Indices de la tabla `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`RowID_Plan`,`PlanCd`,`codigoRegistro`) USING BTREE,
  ADD UNIQUE KEY `PlanCd` (`PlanCd`),
  ADD KEY `plan_unidadAcademica_codigo_foreign` (`unidad_Academica`),
  ADD KEY `DefinicionPlanId` (`DefinicionPlanId`);

--
-- Indices de la tabla `plan_campus`
--
ALTER TABLE `plan_campus`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `campus_cdfk_2` (`planId`);

--
-- Indices de la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `salidas_cdfk_2` (`planId`);

--
-- Indices de la tabla `unidadacademica`
--
ALTER TABLE `unidadacademica`
  ADD KEY `unidadacademica_fcs_codigo_foreign` (`fcs_codigo`);
--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `user_level` (`user_level`);

--
-- AUTO_INCREMENT de la tabla `acreditaciones`
--
ALTER TABLE `acreditaciones`
  MODIFY `AcredCod` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `codigoDoc` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `enfasis`
--
ALTER TABLE `enfasis`
  MODIFY `codigoE` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `estructuracurricular`
--
-- AUTO_INCREMENT de la tabla `plan`
--
ALTER TABLE `plan`
  MODIFY `PlanCd` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `plan_campus`
--
ALTER TABLE `plan_campus`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `salidas`
--
ALTER TABLE `salidas`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `unidad_fcs`
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `plan`
--
/*ALTER TABLE `plan`
  ADD CONSTRAINT `plan_unidadAcademica_codigo_fk` FOREIGN KEY (`unidad_Academica`) REFERENCES `unidadacademica` (`nombre`);*/

--
-- Filtros para la tabla `unidadacademica`
--
ALTER TABLE `unidadacademica`
  ADD CONSTRAINT `unidadacademica_fcs_codigo_foreign` FOREIGN KEY (`fcs_codigo`) REFERENCES `fcs` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
