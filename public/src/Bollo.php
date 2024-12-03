<?php
    namespace theBakery;

    // Usamos "require_once("archivo.extensión")" para incluir un archivo
    require_once("Dulce.php");

    class Bollo extends Dulce {
        private string $relleno;

        public function __construct(string $nombre, float $precio, string $descripcion, string $categoria, string $relleno) {
            // Para rellenar el constructor del padre pasando los atributos por el hijo usamos "parent::__construct(atributos)"
            parent::__construct($nombre, $precio, $descripcion, $categoria);
            $this->relleno = $relleno;
        }

        public function muestraResumen(): string {
            return parent::muestraResumen() . ", Relleno: " . $this->relleno . "<br>";
        }
    }
?>