<?php declare(strict_types=1);
/**
 * @author Vitaliy Viznyuk <vitaliyviznyuk@gmail.com>
 * @copyright Copyright (c) 2020 Vitaliy Viznyuk
 */

namespace Tools\Autoloader;

class ClassLoader
{
    /**
     * @var array
     */
    private array $classMap = [];

    /**
     * @var array
     */
    private array $missingClasses = [];

    /**
     * Finds the path to the file where the class is defined.
     *
     * @param string $class The name of the class
     * @return string|false The path if found, false otherwise
     */
    public function findFile($class)
    {
        // class map lookup
        if (isset($this->classMap[$class])) {
            return $this->classMap[$class];
        }

        if (isset($this->missingClasses[$class])) {
            return false;
        }

        // Remember that this class does not exist.
        $this->missingClasses[$class] = true;

        return false;
    }

    /**
     * Loads the given class or interface.
     *
     * @param string $class The name of the class
     * @return bool|null True if loaded, null otherwise
     */
    public function loadClass($class): ?bool
    {
        if ($file = $this->findFile($class)) {
            includeFile($file);

            return true;
        }

        return null;
    }

    /**
     * Registers this instance as an Autoloader.
     *
     * @param bool $prepend Whether to prepend the Autoloader or not
     */
    public function register($prepend = false): void
    {
        spl_autoload_register([$this, 'loadClass'], true, $prepend);
    }
}

/**
 * Scope isolated include.
 *
 * Prevents access to $this/self from included files.
 *
 * @param string $file
 */
function includeFile(string $file)
{
    /** @noinspection PhpIncludeInspection */
    include $file;
}
