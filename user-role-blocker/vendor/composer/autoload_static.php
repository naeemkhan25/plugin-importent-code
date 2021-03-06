<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6aa1a553acccf10dc93aff1b1e158a49
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'HasinHayder\\D\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'HasinHayder\\D\\' => 
        array (
            0 => __DIR__ . '/..' . '/hasinhayder/d/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6aa1a553acccf10dc93aff1b1e158a49::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6aa1a553acccf10dc93aff1b1e158a49::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6aa1a553acccf10dc93aff1b1e158a49::$classMap;

        }, null, ClassLoader::class);
    }
}
