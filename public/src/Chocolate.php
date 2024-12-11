<?php
    // Configuramos el namespace
    namespace theBakery\public\src;

    // Usamos "require_once("archivo.extensión")" para incluir un archivo
    require_once("Dulce.php");

    // Usamos "extends" para cojer de padre a una clase
    class Chocolate extends Dulce {
        private float $porcentajeCacao;
        private float $peso;

        public function __construct(string $nombre, float $precio, string $descripcion, string $categoria, float $porcentajeCacao, float $peso) {
            // Para rellenar el constructor del padre pasando los atributos por el hijo usamos "parent::__construct(atributos)"
            parent::__construct($nombre, $precio, $descripcion, $categoria);
            $this->porcentajeCacao = $porcentajeCacao;
            $this->peso = $peso;
        }

        // Usamos "parent::muestraResumen()" para usar el método del padre
        public function muestraResumen(): string {
            return parent::muestraResumen() . ", Porcentaje de Cacao: " . $this->porcentajeCacao . "%, Peso: " . $this->peso . "<br>";
        }
    }
?>