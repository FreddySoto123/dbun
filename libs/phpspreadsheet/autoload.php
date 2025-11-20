<?php
// royecto/libs/phpspreadsheet/autoload.php

spl_autoload_register(function ($class) {
    /**
     * Mapa de prefijos de namespace a directorios base.
     * Esto le dice al autoloader dónde buscar las clases de cada librería.
     */
    $libraries = [
        // Para PhpSpreadsheet
        'PhpOffice\\PhpSpreadsheet\\' => __DIR__ . '/src/',
        
        // Para la dependencia Psr\SimpleCache
        'Psr\\SimpleCache\\'        => __DIR__ . '/../psr/simple-cache/src/',

        // Para la dependencia Composer/Pcre
        'Composer\\Pcre\\'          => __DIR__ . '/../composer/pcre/src/',
        
        // NUEVO: Para la dependencia ZipStream-PHP
        'ZipStream\\'               => __DIR__ . '/../maennchen/zipstream-php/src/'
    ];

    // Recorremos nuestro mapa de librerías
    foreach ($libraries as $prefix => $base_dir) {
        
        // Comparamos si la clase que se busca empieza con el prefijo de la librería
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            // Si no coincide, pasamos a la siguiente librería en el mapa
            continue;
        }

        // Obtenemos el nombre relativo de la clase (sin el prefijo)
        $relative_class = substr($class, $len);

        // Reemplazamos los separadores de namespace (\) con los separadores de directorio (/)
        // y construimos la ruta completa al archivo.
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        // Si el archivo existe, lo incluimos y detenemos la búsqueda.
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});