<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbadc9f52800e058881b451c69aabd0ab
{
    public static $prefixLengthsPsr4 = array (
        'y' => 
        array (
            'yidas\\queue\\worker\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'yidas\\queue\\worker\\' => 
        array (
            0 => __DIR__ . '/..' . '/yidas/codeigniter-queue-worker/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'o' => 
        array (
            'org\\bovigo\\vfs' => 
            array (
                0 => __DIR__ . '/..' . '/mikey179/vfsstream/src/main/php',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbadc9f52800e058881b451c69aabd0ab::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbadc9f52800e058881b451c69aabd0ab::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitbadc9f52800e058881b451c69aabd0ab::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
