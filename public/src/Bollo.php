<?php
    // Usamos "require_once("archivo.extensión")" para incluir un archivo
    require_once("Dulce.php");

    class Bollo extends Dulce {
        private string $relleno;

        public function __construct(string $nombre, float $precio, string $descripcion, string $categoria, string $relleno) {
            parent::__construct($nombre, $precio, $descripcion, $categoria);
            $this->relleno = $relleno;
        }

        public function muestraResumen(): string {
            return parent::muestraResumen() . ", Relleno: " . $this->relleno;
        }
    }
?>