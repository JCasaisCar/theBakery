<?php
    // Configuramos el namespace
    namespace theBakery\public\src;

    // Usamos el "PDO" y el "PDOException"
    use PDO;
    use PDOException;

    class ConexionDB {
        // Propiedad estática para mantener la única instancia de la clase
        private static $instancia = null;
        private $conexion;

        // Configuración de conexión
        private $host = 'localhost';
        private $usuario = 'root';
        private $password = '';
        private $baseDatos = 'theBakery';

        // Constructor privado para evitar la creación de múltiples instancias
        private function __construct() {
            try {
                $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->baseDatos;charset=utf8", $this->usuario, $this->password);
                // Configura el modo de error de PDO a excepciones
                $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }

        // Método estático para obtener la instancia única
        public static function obtenerInstancia() {
            if (self::$instancia == null) {
                self::$instancia = new ConexionDB();
            }
            return self::$instancia;
        }

        // Método para obtener la conexión PDO
        public function obtenerConexion() {
            return $this->conexion;
        }

        // Evita la clonación de la instancia
        private function __clone() {}

        // Evita la deserialización de la instancia
        public function __wakeup() {}
    }
?>