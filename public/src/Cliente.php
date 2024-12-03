<?php
    class Cliente {
        private string $nombre;
        private string $usuario;
        private string $password;
        private int $numPedidosEfectuados;
        private array $dulcesComprados;
        private array $comentarios;

        // Arreglar lo de los atributos que esta liado
        public function __construct(string $nombre, string $usuario, string $password, int $numPedidosEfectuados = 0) {
            $this->nombre = $nombre;
            $this->usuario = $usuario;
            $this->password = $password;
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
    }
?>