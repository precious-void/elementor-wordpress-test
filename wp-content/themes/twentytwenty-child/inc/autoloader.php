<?php

namespace TwentyTwentyChild;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Autoloader
{
    private static $classes_map;

    private static $default_path;

    private static $default_namespace;

    public static function run($default_path = '', $default_namespace = '')
    {
        if ('' === $default_path) {
            $default_path = THEME_PATH;
        }

        if ('' === $default_namespace) {
            $default_namespace = __NAMESPACE__;
        }

        self::$default_path = $default_path;
        self::$default_namespace = $default_namespace;

        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function get_classes_map()
    {
        if (!self::$classes_map) {
            self::init_classes_map();
        }

        return self::$classes_map;
    }

    private static function init_classes_map()
    {
        self::$classes_map = [];
    }

    private static function load_class($relative_class_name)
    {
        $classes_map = self::get_classes_map();

        if (isset($classes_map[$relative_class_name])) {
            $filename = self::$default_path . '/' . $classes_map[$relative_class_name];
        } else {
            $filename = strtolower(
                preg_replace(
                    ['/([a-z])([A-Z])/', '/_/', '/\\\/'],
                    ['$1-$2', '-', DIRECTORY_SEPARATOR],
                    $relative_class_name
                )
            );

            $filename = self::$default_path . $filename . '.php';
        }

        if (is_readable($filename)) {
            require $filename;
        }
    }

    private static function autoload($class)
    {
        if (0 !== strpos($class, self::$default_namespace . '\\')) {
            return;
        }

        $relative_class_name = preg_replace('/^' . self::$default_namespace . '\\\/', '', $class);

        $final_class_name = self::$default_namespace . '\\' . $relative_class_name;

        if (!class_exists($final_class_name)) {
            self::load_class($relative_class_name);
        }
    }
}
