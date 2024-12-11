<?php
    // Configuramos el namespace
    namespace theBakery\public\util;

    // Excepción para el caso de que un dulce no haya sido comprado
    // Usamos "extends" para cojer de padre a una clase
    class DulceNoCompradoException extends PasteleriaException {}
?>