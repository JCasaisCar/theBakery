<?php
    // Configuramos el namespace
    namespace theBakery\public\util;

    // Usamos "\" antes de "Exception", debido a que la clase "Exception" se encuentra en el espacio de nombres "global" y no en un namespace específico
    // Usamos "extends" para cojer de padre a una clase
    class PasteleriaException extends \Exception {
        public function __construct($msj, $codigo = 0, \Exception $previa = null) {
            parent::__construct($msj, $codigo, $previa);
        }

        public function __toString(): string {
            // Devolvemos la clase con el código y el mensaje
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
        }
    }
?>