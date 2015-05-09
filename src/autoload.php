<?php

/**
 * Auto-loads required classes.
 *
 * @param $class
 */
function loadClass($class)
{
    $nameSpaceParts = explode('\\', $class);
    $classFile = dirname(__DIR__) . '/src/lib/' . end($nameSpaceParts) . '.php';
    include $classFile;
}
spl_autoload_register('loadClass');