<?php
     // Usamos "require_once("archivo.extensión")" para incluir un archivo
     require_once("Dulce.php");

     class Tarta extends Dulce {
         private array $rellenos;
         private int $numPisos;
         private int $minNumComensales = 2;
         private int $maxNumComensales;
 
         public function __construct(string $nombre, float $precio, string $descripcion, string $categoria, array $rellenos, int $numPisos, int $minNumComensales, int $maxNumComensales) {
             // Para rellenar el constructor del padre pasando los atributos por el hijo usamos "parent::__construct(atributos)"
             parent::__construct($nombre, $precio, $descripcion, $categoria);
             $this->rellenos = $rellenos;
             $this->numPisos = $numPisos;
             $this->minNumComensales = $minNumComensales;
             $this->maxNumComensales = $maxNumComensales;
         }

         public function muestraComensalesPosibles(): string {
            if ($this->minNumComensales === $this->maxNumComensales) {
                return "Para " . $this->minNumComensales . " comensales";
            } else {
                return "De " . $this->minNumComensales . " a " . $this->maxNumComensales . " comensales";
            }
         }
 
         public function muestraResumen(): string {
            // Usamos "implode("separador", array)" para crear un "string" de un array con los valores separados por el separador que hemos elegido
            $rellenosString = implode(", ", $this->rellenos); 
            return parent::muestraResumen() . ", Rellenos: " . $rellenosString . ", Número Pisos: " . $this->numPisos . ", Comensales Mínimos: " . $this->minNumComensales . ", Comensales Máximos: " . $this->maxNumComensales;
         }
     }
?>