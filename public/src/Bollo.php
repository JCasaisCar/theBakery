<?php
    // Configuramos el namespace
    namespace theBakery\public\src;

    // Usamos "require_once("archivo.extensión")" para incluir un archivo
    require_once("Dulce.php");

    // Usamos "extends" para cojer de padre a una clase
    class Bollo extends Dulce {
        private string $relleno;

        public function __construct(string $nombre, float $precio, string $descripcion, string $categoria, string $relleno) {
            // Para rellenar el constructor del padre pasando los atributos por el hijo usamos "parent::__construct(atributos)"
            parent::__construct($nombre, $precio, $descripcion, $categoria);
            $this->relleno = $relleno;
        }

        // Usamos "parent::muestraResumen()" para usar el método del padre
        public function muestraResumen(): string {
            return parent::muestraResumen() . ", Relleno: " . $this->relleno . "<br>";
        }
    }
?>