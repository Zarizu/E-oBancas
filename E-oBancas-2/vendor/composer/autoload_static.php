<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8cbb0a15b41b805b64be431be9c68e8e
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'CoffeeCode\\Router\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'CoffeeCode\\Router\\' => 
        array (
            0 => __DIR__ . '/..' . '/coffeecode/router/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'M' => 
        array (
            'Mustache' => 
            array (
                0 => __DIR__ . '/..' . '/mustache/mustache/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8cbb0a15b41b805b64be431be9c68e8e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8cbb0a15b41b805b64be431be9c68e8e::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit8cbb0a15b41b805b64be431be9c68e8e::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit8cbb0a15b41b805b64be431be9c68e8e::$classMap;

        }, null, ClassLoader::class);
    }
}
