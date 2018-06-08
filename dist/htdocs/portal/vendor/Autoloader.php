<?php

class Autoloader
{
    /**
     * @param $className
     * @throws Exception
     */
    public static function autoload($className)
    {
        $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $classFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . $classPath . '.php';

        include $classFile;

        if (!class_exists($className, false) && !interface_exists($className, false) && !trait_exists($className, false)) {
            throw new Exception("Unable to find '$className' in file: $classFile. Namespace missing?");
        }
    }
}