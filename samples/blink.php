#!/usr/bin/php
<?php

/* Load Composer's Autoloader */
use Hue\Hue;

$composerAutoload = [
    __DIR__ . '/../vendor/autoload.php', // in repo
    __DIR__ . '/../../autoload.php', // as composer binary
];

foreach ($composerAutoload as $autoload) {
    if (file_exists( $autoload )) {
        require_once( $autoload );
        break;
    }
}

$bridge = '192.168.0.162';
$key = "replace_this_with_a_real_key";
$hue = new Hue( $bridge, $key );
$light = 1;

$hue->lights()[$light]->setAlert( "lselect" );
sleep( 2 );
$hue->lights()[$light]->setAlert( "none" );

?>
