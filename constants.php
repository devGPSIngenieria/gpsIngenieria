<?php

class DataConfig {
    // Definir una constante para el valor del servidor
    const SERVER = "http://192.168.1.157";
    
    // Método para obtener el valor del servidor (opcional)
    public static function getServer() {
        return self::SERVER;
    }
}
?>