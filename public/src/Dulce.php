<?php
    class Dulce {
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

        public function muestraResumen(): string {
            return "Nombre: " . $this->getNombre() . ", Precio: " . $this->getPrecio() . "€, Descripción: " . $this->getDescripcion() . ", Categoria: " . $this->getCategoria() . ", IVA: " . self::$IVA . "%";
        }
    }

    // Para crear un objeto de la clase "Dulce"
    $dulce = new Dulce("Tarta de Fresa", 18.50, "Deliciosa tarta de fresas del campo", "Tarta");

    // Usamos "$objeto->getpropiedad()" para sacar el valor mediente "get" de una propiedad de un objeto
    echo("El nombre es: " . $dulce->getNombre() . "<br>");
    echo("El precio es: " . $dulce->getPrecio() . "€<br>");
    echo("El descripcion es: " . $dulce->getDescripcion() . "<br>");
    echo("El categoria es: " . $dulce->getCategoria() . "<br>");
    echo("El IVA es: " . Dulce::getIVA() . "%"); // Para acceder a un método "static" usamos "Clase::getAtributo()"
?>