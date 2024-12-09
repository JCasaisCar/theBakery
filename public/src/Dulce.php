<?php
    namespace theBakery;

    // No, los hijos no necesitan implementar el interfaz "Resumible" porque lo heredan de "Dulce", pero deben definir el método "muestraResumen()" al ser "Dulce" una clase abstracta
    require_once("Resumible.php");

    // Usamos "require_once" para incluir el archivo de conexión a la base de datos
    require_once("ConexionDB.php");

    use PDO;
    // Al hacer la clase "Dulce" abstracta evita instancias directas, obligamos a las hijas a implementar métodos clave y mejoramos la claridad del diseño
    abstract class Dulce implements Resumible {
        private string $nombre;
        private float $precio;
        private string $descripcion;
        private string $categoria;
        private static float $IVA = 21.0;

        public function __construct(string $nombre, float $precio, string $descripcion, string $categoria) {
            $this->nombre = $nombre;
            $this->precio = $precio;
            $this->descripcion = $descripcion;
            $this->categoria = $categoria;  
        }

        /**
         * Get the value of nombre
         */ 
        public function getNombre(): string 
        {
                return $this->nombre;
        }

        /**
         * Get the value of precio
         */ 
        public function getPrecio(): float
        {
                return $this->precio;
        }

        /**
         * Get the value of descripcion
         */ 
        public function getDescripcion(): string
        {
                return $this->descripcion;
        }

        /**
         * Get the value of categoria
         */ 
        public function getCategoria(): string
        {
                return $this->categoria;
        }

        /**
         * Get the value of IVA
         */ 
        public static function getIVA(): float
        {
                return self::$IVA; // Como la propiedad es "static" hay que llamarla con "self::$IVA" en vez de con "$this->IVA" y poner "static" en el método
        }

        public function muestraResumen(): string {
            return "Nombre: " . $this->getNombre() . ", Precio: " . $this->getPrecio() . "€, Descripción: " . $this->getDescripcion() . ", Categoria: " . $this->getCategoria() . ", IVA: " . self::$IVA . "% <br>";
        }
    

        // Operaciones CRUD

        // Create
        public function createDulce(): void {
                // Creamos una instancia de la conexión a la base de datos usando el patrón Singleton
                $conexionDB = ConexionDB::obtenerInstancia();
                $conexion = $conexionDB->obtenerConexion();

                // Preparamos la consulta SQL para insertar un nuevo usuario en la base de datos
                $query = $conexion->prepare("INSERT INTO dulces (nombre, precio, descripcion, categoria, iva) VALUES
                (?, ?, ?, ?, ?);"); // Ponemos "?" para evitar la inyección SQL

                // Ejecutamos la consulta para insertar los datos en la base de datos
                if ($query->execute([$this->nombre, $this->precio, $this->descripcion, $this->categoria, $this->IVA])) {
                        // Si la inserción es exitosa, mostramos un mensaje y redirigimos a la página de login
                        echo("Datos guardados correctamente, dulce creado satisfactoriamente");
                } else {
                        // Si ocurre un error al insertar, mostramos un mensaje y redirigimos a la página de registro
                        echo("Datos no guardados, dulce no creado");
                }
        }


        // Read
        public function readAllDulce(): array {
                // Creamos una instancia de la conexión a la base de datos usando el patrón Singleton
                $conexionDB = ConexionDB::obtenerInstancia();
                $conexion = $conexionDB->obtenerConexion();

                // Preparamos la consulta SQL para insertar un nuevo usuario en la base de datos
                $query = $conexion->prepare("SELECT * FROM dulces;");

                // Ejecutamos la consulta para insertar los datos en la base de datos
                if ($query->execute()) {
                        // Si la inserción es exitosa, mostramos un mensaje y redirigimos a la página de login
                        echo("Los datos de todos los dulces se han leído correctamente");
                        
                        // Obtenemos el resultado de la consulta
                        $resultado = $query->fetchAll(PDO::FETCH_ASSOC); // Usamos "PDO::FETCH_ASSOC" para que nos devuelva un array clave valor
                        return $resultado;
                } else {
                        // Si ocurre un error al insertar, mostramos un mensaje y redirigimos a la página de registro
                        echo("Los datos de todos los dulces no se han leído");
                        return [];
                }
        }

        public function readDulce(int $id): array {
                // Creamos una instancia de la conexión a la base de datos usando el patrón Singleton
                $conexionDB = ConexionDB::obtenerInstancia();
                $conexion = $conexionDB->obtenerConexion();

                // Preparamos la consulta SQL para insertar un nuevo usuario en la base de datos
                $query = $conexion->prepare("SELECT * FROM dulces WHERE id=?;"); // Ponemos "?" para evitar la inyección SQL

                // Ejecutamos la consulta para insertar los datos en la base de datos
                if ($query->execute([$id])) {
                        // Si la inserción es exitosa, mostramos un mensaje y redirigimos a la página de login
                        echo("Los datos de el dulce de id " . $id . " se han leído correctamente");
                        
                        // Obtenemos el resultado de la consulta
                        $resultado = $query->fetch(PDO::FETCH_ASSOC);
                        return $resultado;
                } else {
                        // Si ocurre un error al insertar, mostramos un mensaje y redirigimos a la página de registro
                        echo("Los datos de el dulce de id " . $id . " no se han leído");
                        return [];
                }
        } 


        // Update
        public function updateDulce(int $id): void {
                // Creamos una instancia de la conexión a la base de datos usando el patrón Singleton
                $conexionDB = ConexionDB::obtenerInstancia();
                $conexion = $conexionDB->obtenerConexion();

                // Preparamos la consulta SQL para insertar un nuevo usuario en la base de datos
                $query = $conexion->prepare("UPDATE dulces SET nombre=?, precio=?, descripcion=?, categoria=?, iva=? WHERE id = ?;"); // Ponemos "?" para evitar la inyección SQL

                // Ejecutamos la consulta para insertar los datos en la base de datos
                if ($query->execute([$this->nombre, $this->precio, $this->descripcion, $this->categoria, $this->IVA, $id])) {
                        // Si la inserción es exitosa, mostramos un mensaje y redirigimos a la página de login
                        echo("El dulce con id " . $id . " se ha actualizado");
                } else {
                        // Si ocurre un error al insertar, mostramos un mensaje y redirigimos a la página de registro
                        echo("El dulce con id " . $id . " no se ha actualizado");
                }
        }
        
        
        // Delete
        public function deleteDulce(int $id): void {
                // Creamos una instancia de la conexión a la base de datos usando el patrón Singleton
                $conexionDB = ConexionDB::obtenerInstancia();
                $conexion = $conexionDB->obtenerConexion();

                // Preparamos la consulta SQL para insertar un nuevo usuario en la base de datos
                $query = $conexion->prepare("DELETE FROM dulces WHERE id = ?;"); // Ponemos "?" para evitar la inyección SQL

                // Ejecutamos la consulta para insertar los datos en la base de datos
                if ($query->execute([$id])) {
                        // Si la inserción es exitosa, mostramos un mensaje y redirigimos a la página de login
                        echo("El dulce con id " . $id . " se ha eliminado correctamente");
                } else {
                        // Si ocurre un error al insertar, mostramos un mensaje y redirigimos a la página de registro
                        echo("El dulce con id " . $id . " no se ha eliminado");
                }
        }
    }
?>