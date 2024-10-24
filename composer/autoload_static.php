<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6c02daffb3c492de271a4fafd6a4fdb9
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Midtrans\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Midtrans\\' => 
        array (
            0 => __DIR__ . '/..' . '/midtrans/midtrans-php/Midtrans',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6c02daffb3c492de271a4fafd6a4fdb9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6c02daffb3c492de271a4fafd6a4fdb9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6c02daffb3c492de271a4fafd6a4fdb9::$classMap;

        }, null, ClassLoader::class);
    }
}
