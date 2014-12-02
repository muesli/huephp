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
$lightRange = [ 1, 2 ];

while ( true )
{
    $target = rand( $lightRange[0], $lightRange[1] );
    $hue->lights()[$target]->setLight( $hue->randomColor() );
    usleep( 100000 );
}
?>
