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


        /**
         * Set the value of nombre
         *
         * @return  self
         */ 
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;

                return $this;
        }

        /**
         * Set the value of precio
         *
         * @return  self
         */ 
        public function setPrecio($precio)
        {
                $this->precio = $precio;

                return $this;
        }

        /**
         * Set the value of descripcion
         *
         * @return  self
         */ 
        public function setDescripcion($descripcion)
        {
                $this->descripcion = $descripcion;

                return $this;
        }

        /**
         * Set the value of categoria
         *
         * @return  self
         */ 
        public function setCategoria($categoria)
        {
                $this->categoria = $categoria;

                return $this;
        }

        /**
         * Set the value of IVA
         *
         * @return  self
         */ 
        public function setIVA($IVA)
        {
                $this->IVA = $IVA;

                return $this;
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
                if ($query->execute([$this->nombre, $this->precio, $this->descripcion, $this->categoria, self::$IVA])) {
                        // Si la inserción es exitosa, mostramos un mensaje y redirigimos a la página de login
                        echo("Datos guardados correctamente, dulce creado satisfactoriamente <br>");
                } else {
                        // Si ocurre un error al insertar, mostramos un mensaje y redirigimos a la página de registro
                        echo("Datos no guardados, dulce no creado <br>");
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
                        echo("Los datos de todos los dulces se han leído correctamente <br>");
                        
                        // Obtenemos el resultado de la consulta
                        $resultado = $query->fetchAll(PDO::FETCH_ASSOC); // Usamos "PDO::FETCH_ASSOC" para que nos devuelva un array clave valor
                        if ($resultado) {
                                echo("Los datos de todos los dulces se han leído correctamente <br>");
                                return $resultado;
                        } else {
                                echo("Los datos de todos los dulces no se han leído <br>");
                                return [];
                        }
                } else {
                        // Si ocurre un error al insertar, mostramos un mensaje y redirigimos a la página de registro
                        echo("Fallo en la consulta de los datos de todos los dulces <br>");
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
                        // Obtenemos el resultado de la consulta
                        $resultado = $query->fetch(PDO::FETCH_ASSOC);
                        if ($resultado) {
                                echo("Los datos de el dulce de id " . $id . " se han leído correctamente <br>");
                                return $resultado;
                        } else {
                                echo("Los datos de el dulce de id " . $id . " no se han leído <br>");
                                return [];
                        }
                } else {
                        // Si ocurre un error al insertar, mostramos un mensaje y redirigimos a la página de registro
                        echo("Fallo en la consulta de los datos de el dulce de id " . $id . "<br>");
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
                if ($query->execute([$this->nombre, $this->precio, $this->descripcion, $this->categoria, self::$IVA, $id])) {
                        // Si la inserción es exitosa, mostramos un mensaje y redirigimos a la página de login
                        echo("El dulce con id " . $id . " se ha actualizado <br>");
                } else {
                        // Si ocurre un error al insertar, mostramos un mensaje y redirigimos a la página de registro
                        echo("El dulce con id " . $id . " no se ha actualizado <br>");
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
                        echo("El dulce con id " . $id . " se ha eliminado correctamente <br>");
                } else {
                        // Si ocurre un error al insertar, mostramos un mensaje y redirigimos a la página de registro
                        echo("El dulce con id " . $id . " no se ha eliminado <br>");
                }
        }
    }
?>