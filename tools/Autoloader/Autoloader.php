<?php declare(strict_types=1);
/**
 * @author Vitaliy Viznyuk <vitaliyviznyuk@gmail.com>
 * @copyright Copyright (c) 2020 Vitaliy Viznyuk
 */

use Tools\Autoloader\ClassLoader;
use Tools\Autoloader\ClassMap;

require_once __DIR__ . '/ClassMap.php';

class Autoloader
{
    /**
     * @var null|ClassLoader
     */
    private static ?ClassLoader $loader = null;

    /**
     * @param string $class
     */
    public static function loadClassLoader(string $class): void
    {
        if ('Tools\Autoloader\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return ClassLoader
     */
    public static function getLoader(): ClassLoader
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(['Autoloader', 'loadClassLoader'], true, true);
        self::$loader = $loader = new ClassLoader();
        spl_autoload_unregister(['Autoloader', 'loadClassLoader']);

        call_user_func(ClassMap::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
