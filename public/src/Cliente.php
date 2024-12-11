<?php
    namespace theBakery\public\src;

    use theBakery\public\util\PasteleriaException;
    use theBakery\public\util\DulceNoCompradoException;
    use theBakery\public\util\DulceNoEncontradoException;
    use theBakery\public\util\ClienteNoEncontradoException;
    use PDO;

    // Para incluir las excepciones
    require_once("../util/PasteleriaException.php");
    require_once("../util/DulceNoCompradoException.php");
    require_once("../util/DulceNoEncontradoException.php");
    require_once("../util/ClienteNoEncontradoException.php");

    class Cliente {
        private string $nombre;
        private string $usuario;
        private string $password;
        private string $email;
        private int $numPedidosEfectuados;
        private array $dulcesComprados;
        private array $comentarios;

        // Arreglar lo de los atributos que esta liado
        public function __construct(string $nombre, string $usuario, string $password, string $email, int $numPedidosEfectuados = 0) {
            $this->nombre = $nombre;
            $this->usuario = $usuario;
            $this->password = $password;
            $this->email = $email;
            $this->numPedidosEfectuados = $numPedidosEfectuados;
            $this->dulcesComprados = [];
            $this->comentarios = [];
        }

        


        /**
         * Get the value of nombre
         */ 
        public function getNombre()
        {
                return $this->nombre;
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
         * Get the value of usuario
         */ 
        public function getUsuario()
        {
                return $this->usuario;
        }

        /**
         * Set the value of usuario
         *
         * @return  self
         */ 
        public function setUsuario($usuario)
        {
                $this->usuario = $usuario;

                return $this;
        }

        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        /**
         * Get the value of numPedidosEfectuados
         */ 
        public function getNumPedidosEfectuados()
        {
                return $this->numPedidosEfectuados;
        }

        /**
         * Set the value of numPedidosEfectuados
         *
         * @return  self
         */ 
        public function setNumPedidosEfectuados($numPedidosEfectuados)
        {
                $this->numPedidosEfectuados = $numPedidosEfectuados;

                return $this;
        }



        public function muestraResumen(): string {
            return "Nombre: " . $this->nombre . ", Cantidad de pedidos: " . $this->numPedidosEfectuados . "<br>";
        }

 
        public function listaDeDulces(Dulce $d): bool {
            foreach ($this->dulcesComprados as $dulceComprado) {
                if ($dulceComprado === $d) {
                    return true;
                }
            }
            return false;
        }

        // Pasamos directamente como parámetro el objeto "Dulce" para coger el "array" de la lista de "dulces"
        public function comprar(Dulce $d): self {
            // Verificamos si el "dulce" ya fue comprado
            if ($this->listaDeDulces($d)) {
                // Lanzamos una excepción si el dulce ya fue comprado
                throw new DulceNoCompradoException("Ya has comprado este dulce anteriormente.");
            } else {
                // Agregamos el "dulce" al "array" de "dulcesComprados"
                $this->dulcesComprados[] = $d;
                // Incrementamos el contador de pedidos
                $this->numPedidosEfectuados++;
                echo "Dulce " . $d->muestraResumen() . " comprado" . "<br>";
            }
            return $this; // Ponemos "return $this" para poder encadenar los métodos
        }

        public function valorar(Dulce $d, string $comentario): void {
            if ($this->listaDeDulces($d)) {
                // Almacena el comentario usando el hash del objeto Dulce
                $this->comentarios[spl_object_hash($d)] = $comentario;
                echo "Comentario agregado al dulce" . $comentario . "<br>";
            } else {
                // Lanzamos una excepción si el dulce no ha sido comprado
                throw new DulceNoCompradoException("El dulce no ha sido comprado, no se puede valorar.");
            }
        }

        public function listarPedidos(): void {
            if (empty($this->dulcesComprados)) {
                echo "No se han realizado pedidos aún." . "<br>";
            } else {
                echo ("Pedidos realizados por " . $this->nombre . "<br>");
                foreach ($this->dulcesComprados as $dulce) {
                    echo "- " . $dulce->muestraResumen() . "<br>";
                }
            }
        }




        // Operaciones CRUD

        // Create
        public function createCliente(): void {
            // Creamos una instancia de la conexión a la base de datos usando el patrón Singleton
            $conexionDB = ConexionDB::obtenerInstancia();
            $conexion = $conexionDB->obtenerConexion();

            // Preparamos la consulta SQL para insertar un nuevo dulce en la base de datos
            $query = $conexion->prepare("INSERT INTO usuarios (name, username, password, email) VALUES
            (?, ?, ?, ?, ?);"); // Ponemos "?" para evitar la inyección SQL

            // Ejecutamos la consulta para insertar los datos en la base de datos
            if ($query->execute([$this->nombre, $this->usuario, $this->password, $this->email])) {
                    echo("<script>console.log('Datos guardados correctamente, cliente creado satisfactoriamente');</script> <br>");
            } else {
                    echo("<script>console.log('Datos no guardados, cliente no creado');</script> <br>");
            }
        }


        // Read
        public function readAllCliente(): array {
                // Creamos una instancia de la conexión a la base de datos usando el patrón Singleton
                $conexionDB = ConexionDB::obtenerInstancia();
                $conexion = $conexionDB->obtenerConexion();

                // Preparamos la consulta SQL para seleccionar los dulces en la base de datos
                $query = $conexion->prepare("SELECT * FROM usuarios WHERE rol='cliente';");

                // Ejecutamos la consulta para insertar los datos en la base de datos
                if ($query->execute()) {
                        echo("<script>console.log('Los datos de todos los clientes se han leído correctamente')</script> <br>");
                        
                        // Obtenemos el resultado de la consulta
                        $resultado = $query->fetchAll(PDO::FETCH_ASSOC); // Usamos "PDO::FETCH_ASSOC" para que nos devuelva un array clave valor
                        if ($resultado) {
                                echo("<script>console.log('Los datos de todos los clientes se han leído correctamente')</scrip> <br>");
                                return $resultado;
                        } else {
                                echo("<script>console.log('Los datos de todos los clientes no se han leído')</script> <br>");
                                return [];
                        }
                } else {
                        echo("<script>console.log('Fallo en la consulta de los datos de todos los clientes')</script> <br>");
                        return [];
                }
        }

        public function readCliente(int $id): array {
                // Creamos una instancia de la conexión a la base de datos usando el patrón Singleton
                $conexionDB = ConexionDB::obtenerInstancia();
                $conexion = $conexionDB->obtenerConexion();

                // Preparamos la consulta SQL para seleccionar un dulce por su id en la base de datos
                $query = $conexion->prepare("SELECT * FROM usuarios WHERE id=? and rol='cliente';"); // Ponemos "?" para evitar la inyección SQL

                // Ejecutamos la consulta para insertar los datos en la base de datos
                if ($query->execute([$id])) {
                        // Obtenemos el resultado de la consulta
                        $resultado = $query->fetch(PDO::FETCH_ASSOC); // Usamos "PDO::FETCH_ASSOC" para que nos devuelva un array clave valor
                        if ($resultado) {
                                echo("<script>console.log('Los datos de el cliente de id $id se han leído correctamente')</script> <br>");
                                return $resultado;
                        } else {
                                echo("<script>console.log('Los datos de el cliente de id $id no se han leído')</script> <br>");
                                return [];
                        }
                } else {
                        echo("<script>console.log('Fallo en la consulta de los datos de el cliente de id $id')</script><br>");
                        return [];
                }
        } 


        // Update
        public function updateCliente(int $id): void {
                // Creamos una instancia de la conexión a la base de datos usando el patrón Singleton
                $conexionDB = ConexionDB::obtenerInstancia();
                $conexion = $conexionDB->obtenerConexion();

                // Preparamos la consulta SQL para actualizar un dulce en la base de datos
                $query = $conexion->prepare("UPDATE usuarios SET name=?, username=?, password=?, email=? WHERE id = ? and rol='cliente';"); // Ponemos "?" para evitar la inyección SQL

                // Ejecutamos la consulta para insertar los datos en la base de datos
                if ($query->execute([$this->nombre, $this->usuario, $this->password, $this->email, $id])) {
                        echo("<script>console.log('El cliente con id $id se ha actualizado')</script> <br>");
                } else {
                        echo("<script>console.log('El cliente con id $id no se ha actualizado')</script> <br>");
                }
        }
        
        
        // Delete
        public function deleteCliente(int $id): void {
                // Creamos una instancia de la conexión a la base de datos usando el patrón Singleton
                $conexionDB = ConexionDB::obtenerInstancia();
                $conexion = $conexionDB->obtenerConexion();

                // Preparamos la consulta SQL para eliminar un dulce en la base de datos
                $query = $conexion->prepare("DELETE FROM usuarios WHERE id = ? and rol='cliente';"); // Ponemos "?" para evitar la inyección SQL

                // Ejecutamos la consulta para insertar los datos en la base de datos
                if ($query->execute([$id])) {
                        echo("<script>console.log('El cliente con id $id se ha eliminado correctamente')</script> <br>");
                } else {
                        echo("<script>console.log('El cliente con id $id no se ha eliminado')</script> <br>");
                }
        }
    }
?>