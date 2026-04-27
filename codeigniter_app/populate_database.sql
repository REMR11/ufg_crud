-- Script SQL para poblar tablas del CRUD Académico
-- Base de datos: PostgreSQL
-- ============================================

-- 1. CARRERAS (5 carreras)
INSERT INTO carreras (codigo_carrera, nombre_carrera) VALUES
('ING-SFT', 'Ingeniería en Software'),
('ING-CIVIL', 'Ingeniería Civil'),
('ADM', 'Administración de Empresas'),
('DERECHO', 'Derecho'),
('PSIC', 'Psicología');

-- 2. DOCENTES (15 docentes)
INSERT INTO docentes (nombre, apellido, email, telefono) VALUES
('Juan', 'García', 'juan.garcia@university.com', '502-1234-5678'),
('María', 'López', 'maria.lopez@university.com', '502-2345-6789'),
('Carlos', 'Rodríguez', 'carlos.rodriguez@university.com', '502-3456-7890'),
('Ana', 'Martínez', 'ana.martinez@university.com', '502-4567-8901'),
('Pedro', 'Hernández', 'pedro.hernandez@university.com', '502-5678-9012'),
('Sofía', 'Pérez', 'sofia.perez@university.com', '502-6789-0123'),
('Luís', 'González', 'luis.gonzalez@university.com', '502-7890-1234'),
('Elena', 'Díaz', 'elena.diaz@university.com', '502-8901-2345'),
('Marco', 'Ruiz', 'marco.ruiz@university.com', '502-9012-3456'),
('Patricia', 'Sánchez', 'patricia.sanchez@university.com', '502-0123-4567'),
('Roberto', 'Flores', 'roberto.flores@university.com', '502-1111-2222'),
('Valentina', 'Castro', 'valentina.castro@university.com', '502-3333-4444'),
('Andrés', 'Morales', 'andres.morales@university.com', '502-5555-6666'),
('Lucía', 'Vega', 'lucia.vega@university.com', '502-7777-8888'),
('Fernando', 'Torres', 'fernando.torres@university.com', '502-9999-0000');

-- 3. MATERIAS (30 materias - distribuidas por carrera)
INSERT INTO materias (nombre_materia) VALUES
-- Ingeniería en Software
('Programación I'),
('Programación II'),
('Estructuras de Datos'),
('Algoritmos'),
('Bases de Datos'),
('Desarrollo Web'),
('Ingeniería de Software'),
('Seguridad Informática'),
-- Ingeniería Civil
('Cálculo I'),
('Cálculo II'),
('Física I'),
('Física II'),
('Resistencia de Materiales'),
('Estructuras'),
('Topografía'),
('Geotecnia'),
-- Administración
('Contabilidad I'),
('Contabilidad II'),
('Economía'),
('Administración General'),
('Gestión Empresarial'),
('Marketing'),
('Finanzas'),
('Recursos Humanos'),
-- Derecho
('Derecho Civil I'),
('Derecho Penal'),
('Derecho Constitucional'),
('Derecho Laboral'),
-- Psicología
('Psicología General'),
('Psicología del Desarrollo');

-- 4. HORARIOS (30 registros - 1 por materia)
INSERT INTO horarios (id_materia, dia, hora_inicio, hora_fin) VALUES
-- Materias 1-8 (Software)
(1, 'Lunes', '08:00', '09:30'),
(2, 'Martes', '09:30', '11:00'),
(3, 'Miércoles', '11:00', '12:30'),
(4, 'Jueves', '13:00', '14:30'),
(5, 'Viernes', '14:30', '16:00'),
(6, 'Lunes', '16:00', '17:30'),
(7, 'Martes', '08:00', '09:30'),
(8, 'Miércoles', '09:30', '11:00'),
-- Materias 9-16 (Civil)
(9, 'Jueves', '11:00', '12:30'),
(10, 'Viernes', '08:00', '09:30'),
(11, 'Lunes', '09:30', '11:00'),
(12, 'Martes', '11:00', '12:30'),
(13, 'Miércoles', '13:00', '14:30'),
(14, 'Jueves', '14:30', '16:00'),
(15, 'Viernes', '09:30', '11:00'),
(16, 'Lunes', '13:00', '14:30'),
-- Materias 17-24 (Administración)
(17, 'Martes', '13:00', '14:30'),
(18, 'Miércoles', '14:30', '16:00'),
(19, 'Jueves', '08:00', '09:30'),
(20, 'Viernes', '11:00', '12:30'),
(21, 'Lunes', '10:30', '12:00'),
(22, 'Martes', '14:30', '16:00'),
(23, 'Miércoles', '08:00', '09:30'),
(24, 'Jueves', '09:30', '11:00'),
-- Materias 25-28 (Derecho)
(25, 'Viernes', '13:00', '14:30'),
(26, 'Lunes', '11:00', '12:30'),
(27, 'Martes', '10:30', '12:00'),
(28, 'Miércoles', '10:30', '12:00'),
-- Materias 29-30 (Psicología)
(29, 'Jueves', '10:30', '12:00'),
(30, 'Viernes', '10:30', '12:00');

-- 5. ALUMNOS (35 alumnos - distribuidos por carrera)
INSERT INTO alumnos (nombre, apellido, email, telefono, codigo, codigo_carrera) VALUES
-- Software (7 alumnos)
('Jorge', 'Mendoza', 'jorge.mendoza@student.com', '502-2001-1111', 'ALU001', 'ING-SFT'),
('Diana', 'Cabrera', 'diana.cabrera@student.com', '502-2002-2222', 'ALU002', 'ING-SFT'),
('Xavier', 'Salinas', 'xavier.salinas@student.com', '502-2003-3333', 'ALU003', 'ING-SFT'),
('Ivonne', 'Benítez', 'ivonne.benitez@student.com', '502-2004-4444', 'ALU004', 'ING-SFT'),
('Raúl', 'Contreras', 'raul.contreras@student.com', '502-2005-5555', 'ALU005', 'ING-SFT'),
('Gabriela', 'Acuña', 'gabriela.acuna@student.com', '502-2006-6666', 'ALU006', 'ING-SFT'),
('Daniel', 'Campos', 'daniel.campos@student.com', '502-2007-7777', 'ALU007', 'ING-SFT'),
-- Civil (7 alumnos)
('Sergio', 'Mena', 'sergio.mena@student.com', '502-2008-8888', 'ALU008', 'ING-CIVIL'),
('Andrea', 'León', 'andrea.leon@student.com', '502-2009-9999', 'ALU009', 'ING-CIVIL'),
('Gustavo', 'Vargas', 'gustavo.vargas@student.com', '502-2010-1010', 'ALU010', 'ING-CIVIL'),
('Mariana', 'Reyes', 'mariana.reyes@student.com', '502-2011-1111', 'ALU011', 'ING-CIVIL'),
('Eduardo', 'Ortiz', 'eduardo.ortiz@student.com', '502-2012-1212', 'ALU012', 'ING-CIVIL'),
('Claudia', 'Ramos', 'claudia.ramos@student.com', '502-2013-1313', 'ALU013', 'ING-CIVIL'),
('Arturo', 'Silva', 'arturo.silva@student.com', '502-2014-1414', 'ALU014', 'ING-CIVIL'),
-- Administración (8 alumnos)
('Isabel', 'Miranda', 'isabel.miranda@student.com', '502-2015-1515', 'ALU015', 'ADM'),
('Javier', 'Pacheco', 'javier.pacheco@student.com', '502-2016-1616', 'ALU016', 'ADM'),
('Rosa', 'Moreno', 'rosa.moreno@student.com', '502-2017-1717', 'ALU017', 'ADM'),
('Víctor', 'Navarro', 'victor.navarro@student.com', '502-2018-1818', 'ALU018', 'ADM'),
('Alejandra', 'Romero', 'alejandra.romero@student.com', '502-2019-1919', 'ALU019', 'ADM'),
('Mauricio', 'Soto', 'mauricio.soto@student.com', '502-2020-2020', 'ALU020', 'ADM'),
('Teresa', 'Varela', 'teresa.varela@student.com', '502-2021-2121', 'ALU021', 'ADM'),
('Ricardo', 'Valencia', 'ricardo.valencia@student.com', '502-2022-2222', 'ALU022', 'ADM'),
-- Derecho (7 alumnos)
('Natalia', 'Vera', 'natalia.vera@student.com', '502-2023-2323', 'ALU023', 'DERECHO'),
('Esteban', 'Vidal', 'esteban.vidal@student.com', '502-2024-2424', 'ALU024', 'DERECHO'),
('Carmen', 'Villar', 'carmen.villar@student.com', '502-2025-2525', 'ALU025', 'DERECHO'),
('Manuel', 'Villanueva', 'manuel.villanueva@student.com', '502-2026-2626', 'ALU026', 'DERECHO'),
('Cecilia', 'Yanguas', 'cecilia.yanguas@student.com', '502-2027-2727', 'ALU027', 'DERECHO'),
('Héctor', 'Yépez', 'hector.yepez@student.com', '502-2028-2828', 'ALU028', 'DERECHO'),
('Silvia', 'Zambrano', 'silvia.zambrano@student.com', '502-2029-2929', 'ALU029', 'DERECHO'),
-- Psicología (6 alumnos)
('Omar', 'Zamora', 'omar.zamora@student.com', '502-2030-3030', 'ALU030', 'PSIC'),
('Beatriz', 'Zapata', 'beatriz.zapata@student.com', '502-2031-3131', 'ALU031', 'PSIC'),
('Guillermo', 'Zepeda', 'guillermo.zepeda@student.com', '502-2032-3232', 'ALU032', 'PSIC'),
('Marcela', 'Zurita', 'marcela.zurita@student.com', '502-2033-3333', 'ALU033', 'PSIC'),
('Alfonso', 'Zúñiga', 'alfonso.zuniga@student.com', '502-2034-3434', 'ALU034', 'PSIC'),
('Dolores', 'Zúñiga', 'dolores.zuniga@student.com', '502-2035-3535', 'ALU035', 'PSIC');

-- 6. ALUMNO_CARRERA (35 registros - relación 1 alumno por carrera)
INSERT INTO alumno_carrera (id_alumno, id_carrera) VALUES
(1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1), (7, 1),
(8, 2), (9, 2), (10, 2), (11, 2), (12, 2), (13, 2), (14, 2),
(15, 3), (16, 3), (17, 3), (18, 3), (19, 3), (20, 3), (21, 3), (22, 3),
(23, 4), (24, 4), (25, 4), (26, 4), (27, 4), (28, 4), (29, 4),
(30, 5), (31, 5), (32, 5), (33, 5), (34, 5), (35, 5);

-- 7. INSCRIPCIONS (80+ registros - múltiples inscripciones por alumno)
-- Software: Alumnos 1-7 en materias 1-8
INSERT INTO inscripcions (id_alumno, id_materia, fecha_inscripcion) VALUES
(1, 1, NOW() - INTERVAL '150 days'), (1, 2, NOW() - INTERVAL '150 days'), (1, 3, NOW() - INTERVAL '150 days'),
(2, 1, NOW() - INTERVAL '150 days'), (2, 4, NOW() - INTERVAL '150 days'), (2, 5, NOW() - INTERVAL '150 days'),
(3, 2, NOW() - INTERVAL '150 days'), (3, 3, NOW() - INTERVAL '150 days'), (3, 6, NOW() - INTERVAL '150 days'),
(4, 1, NOW() - INTERVAL '150 days'), (4, 5, NOW() - INTERVAL '150 days'), (4, 7, NOW() - INTERVAL '150 days'),
(5, 2, NOW() - INTERVAL '145 days'), (5, 4, NOW() - INTERVAL '145 days'), (5, 8, NOW() - INTERVAL '145 days'),
(6, 3, NOW() - INTERVAL '140 days'), (6, 5, NOW() - INTERVAL '140 days'), (6, 6, NOW() - INTERVAL '140 days'),
(7, 1, NOW() - INTERVAL '135 days'), (7, 7, NOW() - INTERVAL '135 days'), (7, 8, NOW() - INTERVAL '135 days'),

-- Civil: Alumnos 8-14 en materias 9-16
(8, 9, NOW() - INTERVAL '145 days'), (8, 10, NOW() - INTERVAL '145 days'), (8, 11, NOW() - INTERVAL '145 days'),
(9, 9, NOW() - INTERVAL '140 days'), (9, 12, NOW() - INTERVAL '140 days'), (9, 13, NOW() - INTERVAL '140 days'),
(10, 10, NOW() - INTERVAL '138 days'), (10, 14, NOW() - INTERVAL '138 days'), (10, 15, NOW() - INTERVAL '138 days'),
(11, 11, NOW() - INTERVAL '135 days'), (11, 12, NOW() - INTERVAL '135 days'), (11, 16, NOW() - INTERVAL '135 days'),
(12, 13, NOW() - INTERVAL '130 days'), (12, 14, NOW() - INTERVAL '130 days'), (12, 9, NOW() - INTERVAL '130 days'),
(13, 15, NOW() - INTERVAL '128 days'), (13, 16, NOW() - INTERVAL '128 days'), (13, 10, NOW() - INTERVAL '128 days'),
(14, 9, NOW() - INTERVAL '125 days'), (14, 11, NOW() - INTERVAL '125 days'), (14, 13, NOW() - INTERVAL '125 days'),

-- Administración: Alumnos 15-22 en materias 17-24
(15, 17, NOW() - INTERVAL '140 days'), (15, 18, NOW() - INTERVAL '140 days'), (15, 19, NOW() - INTERVAL '140 days'),
(16, 17, NOW() - INTERVAL '138 days'), (16, 20, NOW() - INTERVAL '138 days'), (16, 21, NOW() - INTERVAL '138 days'),
(17, 18, NOW() - INTERVAL '135 days'), (17, 22, NOW() - INTERVAL '135 days'), (17, 23, NOW() - INTERVAL '135 days'),
(18, 19, NOW() - INTERVAL '130 days'), (18, 24, NOW() - INTERVAL '130 days'), (18, 20, NOW() - INTERVAL '130 days'),
(19, 17, NOW() - INTERVAL '128 days'), (19, 21, NOW() - INTERVAL '128 days'), (19, 22, NOW() - INTERVAL '128 days'),
(20, 18, NOW() - INTERVAL '125 days'), (20, 23, NOW() - INTERVAL '125 days'), (20, 24, NOW() - INTERVAL '125 days'),
(21, 19, NOW() - INTERVAL '122 days'), (21, 20, NOW() - INTERVAL '122 days'), (21, 21, NOW() - INTERVAL '122 days'),
(22, 17, NOW() - INTERVAL '120 days'), (22, 22, NOW() - INTERVAL '120 days'), (22, 23, NOW() - INTERVAL '120 days'),

-- Derecho: Alumnos 23-29 en materias 25-28
(23, 25, NOW() - INTERVAL '135 days'), (23, 26, NOW() - INTERVAL '135 days'), (23, 27, NOW() - INTERVAL '135 days'),
(24, 25, NOW() - INTERVAL '130 days'), (24, 28, NOW() - INTERVAL '130 days'), (24, 26, NOW() - INTERVAL '130 days'),
(25, 26, NOW() - INTERVAL '128 days'), (25, 27, NOW() - INTERVAL '128 days'), (25, 28, NOW() - INTERVAL '128 days'),
(26, 25, NOW() - INTERVAL '125 days'), (26, 27, NOW() - INTERVAL '125 days'), (26, 26, NOW() - INTERVAL '125 days'),
(27, 28, NOW() - INTERVAL '120 days'), (27, 25, NOW() - INTERVAL '120 days'), (27, 27, NOW() - INTERVAL '120 days'),
(28, 26, NOW() - INTERVAL '118 days'), (28, 27, NOW() - INTERVAL '118 days'), (28, 28, NOW() - INTERVAL '118 days'),
(29, 25, NOW() - INTERVAL '115 days'), (29, 26, NOW() - INTERVAL '115 days'), (29, 28, NOW() - INTERVAL '115 days'),

-- Psicología: Alumnos 30-35 en materias 29-30
(30, 29, NOW() - INTERVAL '130 days'), (30, 30, NOW() - INTERVAL '130 days'),
(31, 29, NOW() - INTERVAL '125 days'), (31, 30, NOW() - INTERVAL '125 days'),
(32, 29, NOW() - INTERVAL '120 days'), (32, 30, NOW() - INTERVAL '120 days'),
(33, 29, NOW() - INTERVAL '115 days'), (33, 30, NOW() - INTERVAL '115 days'),
(34, 29, NOW() - INTERVAL '110 days'), (34, 30, NOW() - INTERVAL '110 days'),
(35, 29, NOW() - INTERVAL '105 days'), (35, 30, NOW() - INTERVAL '105 days');
