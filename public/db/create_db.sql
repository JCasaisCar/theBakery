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
    precio DECIMAL(10, 2) NOT NULL,
    descripcion VARCHAR(1000) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    iva FLOAT NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Usamos "TIMESTAMP" para almacenar una fecha y una hora, y usamos "CURRENT_TIMESTAMP" para que almacene la fecha y la hora actuales
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Usamos "ON UPDATE CURRENT_TIMESTAMP" para que cada vez que actualizamos el registro, se actualice esta columna automáticamente con la fecha y hora de la última modificación
);

-- Creamos una tabla para usuarios (clientes y administradores)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(50) NOT NULL,
    rol ENUM('admin', 'cliente') DEFAULT 'cliente', -- Para determinar si es admin o cliente
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Creamos una tabla para pedidos
CREATE TABLE pedidos (
    idPedido INT AUTO_INCREMENT PRIMARY KEY,  -- Identificador único del pedido
    idCliente INT NOT NULL,                   -- Relación con usuarios
    fechaPedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha del pedido
    total DECIMAL(10, 2) DEFAULT 0.00,        -- Total del pedido
    FOREIGN KEY (idCliente) REFERENCES usuarios(id) ON DELETE CASCADE -- Relación con usuarios
);-- "ON DELETE CASCADE" para que cuando elimine un usuario se elimine el pedido

-- Tabla de detalles de pedidos
CREATE TABLE detalles_pedido (
    idDetalle INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único del detalle
    idPedido INT NOT NULL,                    -- Relación con pedidos
    nombreProducto VARCHAR(150) NOT NULL,     -- Nombre del producto
    cantidad INT NOT NULL,                    -- Cantidad comprada
    precioUnitario DECIMAL(10, 2) NOT NULL,   -- Precio por unidad
    subtotal DECIMAL(10, 2) NOT NULL,         -- Subtotal (cantidad * precioUnitario)
    FOREIGN KEY (idPedido) REFERENCES pedidos(idPedido) ON DELETE CASCADE -- Relación con pedidos
);-- "ON DELETE CASCADE" para que cuando elimine un pedido se elimine los detalles del pedido


-- Insertamos los usuarios de prueba
INSERT INTO usuarios (name, username, password, email, rol)
VALUES
("Administrador", "admin", "$2y$10$5Po6LH4.6Nrv1fAnVXeS3e.UVCE8pEuorKEhquhkdNmcITWWdex.O", "admin@ilerna.com", "admin"), -- Usamos "SHA2("admin", 256)" para generar un hash SHA-256 de la cadena "admin"
("UsuarioCliente", "usuario", "$2y$10$l.xuOnbMVdN4SyaR1cVs5eGXr692ZgtMEtHsSR2FkUxvYeN6gnXkC", "cliente@ilerna.com", "cliente");