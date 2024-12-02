<?php
    class Pasteleria {
        private array $clientes;
        private array $productos;

        public function __construct() {
            $this->clientes = [];
            $this->productos = [];
        }


        public function incluirDulce(Dulce $dulce): void {
            $this->incluirProducto($dulce);
            echo "Dulce incluido: " . $dulce->muestraResumen() . "<br>";
        }

        // Creamos este método público para usar el método privado "incluirCliente(Cliente $cliente)" para incluir un producto
        private function incluirProducto(Dulce $dulce): void {
            $this->productos[] = $dulce; // Añadir el dulce al array de productos
        }

        public function incluirCliente(Cliente $cliente): void {
            $this->clientes[] = $cliente; // Añadir el cliente al array de clientes
            echo "Cliente incluido: " . $cliente->getNombre() . "<br>";
        }

        public function listarProductos(): void {
            echo "Lista de productos disponibles en la pastelería:" . "<br>";
            
            foreach ($this->productos as $producto) {
                echo "- " . $producto->muestraResumen() . "<br>";
            }
        }

        public function listarClientes(): void {
            echo "Lista de clientes registrados en la pastelería:" . "<br>";

            foreach ($this->clientes as $cliente) {
                echo "- " . $cliente->getNombre() . "<br>";
            }
        }
    }
?>