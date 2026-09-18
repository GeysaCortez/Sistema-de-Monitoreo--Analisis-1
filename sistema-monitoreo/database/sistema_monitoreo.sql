CREATE DATABASE IF NOT EXISTS sistema_monitoreo;
USE sistema_monitoreo;

-- ======================
-- TABLA ROLES
-- ======================
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL
);

-- ======================
-- TABLA USUARIOS
-- ======================
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    cargo VARCHAR(100),
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
    id_rol INT NOT NULL,

    FOREIGN KEY (id_rol)
    REFERENCES roles(id_rol)
);

-- ======================
-- TABLA ZONAS
-- ======================
CREATE TABLE zonas (
    id_zona INT AUTO_INCREMENT PRIMARY KEY,
    nombre_zona VARCHAR(100) NOT NULL,
    descripcion TEXT,
    nivel_riesgo ENUM('Bajo','Medio','Alto') DEFAULT 'Medio'
);

-- ======================
-- TABLA CAMARAS
-- ======================
CREATE TABLE camaras (
    id_camara INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ubicacion VARCHAR(255) NOT NULL,
    estado ENUM('Activa','Inactiva') DEFAULT 'Activa',

    direccion_ip VARCHAR(100),

    -- NUEVO CAMPO STREAM
    url_stream VARCHAR(255),

    fecha_instalacion DATE,

    id_zona INT NOT NULL,

    FOREIGN KEY (id_zona)
    REFERENCES zonas(id_zona)
);

-- ======================
-- TABLA INCIDENTES
-- ======================
CREATE TABLE incidentes (
    id_incidente INT AUTO_INCREMENT PRIMARY KEY,
    tipo_incidente VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    descripcion TEXT,

    estado ENUM(
        'Pendiente',
        'En atención',
        'Resuelto',
        'Cerrado'
    ) DEFAULT 'Pendiente',

    evidencia VARCHAR(255),

    id_camara INT,
    id_usuario INT,

    FOREIGN KEY (id_camara)
    REFERENCES camaras(id_camara),

    FOREIGN KEY (id_usuario)
    REFERENCES usuarios(id_usuario)
);

-- ======================
-- TABLA ALERTAS
-- ======================
CREATE TABLE alertas (
    id_alerta INT AUTO_INCREMENT PRIMARY KEY,

    tipo_alerta VARCHAR(100) NOT NULL,

    nivel_prioridad ENUM(
        'Baja',
        'Media',
        'Alta'
    ) DEFAULT 'Media',

    fecha_generacion DATETIME
    DEFAULT CURRENT_TIMESTAMP,

    estado ENUM(
        'Pendiente',
        'Enviada',
        'Atendida'
    ) DEFAULT 'Pendiente',

    id_incidente INT NOT NULL,

    FOREIGN KEY (id_incidente)
    REFERENCES incidentes(id_incidente)
);

-- ======================
-- TABLA REPORTES
-- ======================
CREATE TABLE reportes (
    id_reporte INT AUTO_INCREMENT PRIMARY KEY,

    tipo VARCHAR(100),

    fecha_generacion DATETIME
    DEFAULT CURRENT_TIMESTAMP,

    descripcion TEXT,

    id_usuario INT,

    FOREIGN KEY (id_usuario)
    REFERENCES usuarios(id_usuario)
);

-- ======================
-- BITACORA / AUDITORIA
-- ======================
CREATE TABLE bitacora (
    id_bitacora INT AUTO_INCREMENT PRIMARY KEY,

    accion VARCHAR(255),

    fecha DATETIME
    DEFAULT CURRENT_TIMESTAMP,

    id_usuario INT,

    FOREIGN KEY (id_usuario)
    REFERENCES usuarios(id_usuario)
);

-- ======================
-- DATOS INICIALES
-- ======================

INSERT INTO roles (nombre_rol)
VALUES
('Administrador'),
('Operador');

-- PASSWORD:
-- 123456
-- HASH GENERADO CON password_hash()

INSERT INTO usuarios (
    nombre,
    apellido,
    cargo,
    usuario,
    password,
    estado,
    id_rol
)
VALUES (
    'Fabian',
    'Admin',
    'Administrador General',
    'admin',

    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9l8sJ6Qz1vQ6vZk0N8mG2a',

    'Activo',
    1
);

INSERT INTO zonas (
    nombre_zona,
    descripcion,
    nivel_riesgo
)
VALUES
(
    'Centro',
    'Zona central de La Paz',
    'Alto'
),
(
    'Sopocachi',
    'Zona residencial',
    'Medio'
);

INSERT INTO camaras (
    nombre,
    ubicacion,
    estado,
    direccion_ip,
    url_stream,
    fecha_instalacion,
    id_zona
)
VALUES
(
    'Camara Plaza Murillo',
    'Plaza Murillo',
    'Activa',
    '192.168.100.6',

    'http://192.168.100.6:8080/video',

    '2026-01-10',
    1
),
(
    'Camara Sopocachi',
    'Av. Sanchez Lima',
    'Activa',
    '192.168.100.7',

    'http://192.168.100.7:8080/video',

    '2026-01-15',
    2
);