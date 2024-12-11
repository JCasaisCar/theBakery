<?php
    // Configuramos el namespace
    namespace theBakery\public\util;

    // Excepción para el caso de que un cliente no se haya encontrado
    // Usamos "extends" para cojer de padre a una clase
    class ClienteNoEncontradoException extends PasteleriaException {}
?>