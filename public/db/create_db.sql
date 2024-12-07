-- Borramos la BBDD si existe
DROP DATABASE IF EXISTS theBakery;
-- Creamos la BBDD si no existe
CREATE DATABASE IF NOT EXISTS theBakery;

-- Para usar la base de datos
USE theBakery;

-- Creamos una tabla para los dulces
CREATE TABLE IF NOT EXISTS dulces (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    imagen VARCHAR(255),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Usamos "TIMESTAMP" para almacenar una fecha y una hora, y usamos "CURRENT_TIMESTAMP" para que almacene la fecha y la hora actuales
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Usamos "ON UPDATE CURRENT_TIMESTAMP" para que cada vez que actualizamos el registro, se actualice esta columna automáticamente con la fecha y hora de la última modificación
);

-- Creamos una tabla para usuarios (clientes y administradores)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    user VARCHAR(50) UNIQUE NOT NULL, -- Usamos "UNIQUE" para que sea único, es decir, que no se repitan valores en el registro
    password VARCHAR(255) NOT NULL, -- Guardaremos la contraseña hasheada
    rol ENUM('admin', 'cliente') DEFAULT 'cliente', -- Para determinar si es admin o cliente
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Creamos una tabla para clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(15),
    user VARCHAR(50), -- Usuario asociado al cliente
    password VARCHAR(255), -- Contraseña hasheada
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertamos los usuarios de prueba
INSERT INTO usuarios (nombre, user, password, rol)
VALUES
("Administrador", "admin", SHA2("admin", 256), "admin"), -- Usamos "SHA2("admin", 256)" para generar un hash SHA-256 de la cadena "admin"
("Usuario Cliente", "usuario", SHA2("usuario", 256), "cliente");

-- Insertamos los datos de prueba para clientes
INSERT INTO clientes (nombre, email, telefono, user, password)
VALUES
("Juan Pérez", "juan@ilerna.com", "123456789", "juan", SHA2("juanpass", 256));