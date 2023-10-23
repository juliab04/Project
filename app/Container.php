<?php

class Container
{
    private static array $createServices;
    private static array $dependencies = [];

    public function __construct(array $services)
    {
        self::$dependencies = $services;
    }

    public static function get(string $className): object
    {
        if (isset(self::$createServices[$className])) {
            return self::$createServices[$className];
        }

        if (!isset(self::$dependencies[$className])) {
            return new $className();
        }

        $callback = self::$dependencies[$className];

        $obj = $callback();
        self::$createServices[$className] = $obj;

        return $obj;
    }
}