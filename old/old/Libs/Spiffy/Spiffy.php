<?php
class Spiffy {
    /**
     * Array of all the loaded models and the path to each one for autoloading
     *
     * @var array
     */
    private static $_loadedControllerFiles = array();

    /**
     * simple autoload function
     * returns true if the class was loaded, otherwise false
     *
     * @param string $classname
     * @return boolean
     */
    public static function autoload($className)
    {
        if (class_exists($className, false) || interface_exists($className, false)) {
            return false;
        }

        $class = self::getPath() . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if (file_exists($class)) {
            require $class;

            return true;
        }

        $loadedControllers = self::$_loadedControllerFiles;

        if (isset($loadedControllers[$className]) && file_exists($loadedControllers[$className])) {
            require $loadedControllers[$className];

            return true;
        }

        return false;
    }

    /**
     * Get the root path to Spiffy
     *
     * @return string
     */
    public static function getPath()
    {
        if ( ! self::$_path) {
            self::$_path = dirname(__FILE__);
        }

        return self::$_path;
    }

}