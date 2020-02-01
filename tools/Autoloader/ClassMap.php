<?php declare(strict_types=1);
/**
 * @author Vitaliy Viznyuk <vitaliyviznyuk@gmail.com>
 * @copyright Copyright (c) 2020 Vitaliy Viznyuk
 */

namespace Tools\Autoloader;

use Closure;

class ClassMap
{
    /**
     * @var array
     */
    public static array $classMap = [];

    /**
     * @param ClassLoader $loader
     * @return callable
     */
    public static function getInitializer(ClassLoader $loader): callable
    {
        return Closure::bind(static function () use ($loader) {
            $loader->classMap = ClassMap::$classMap;
        }, null, ClassLoader::class);
    }
}
