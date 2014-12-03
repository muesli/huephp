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
$key    = "replace_this_with_a_real_key";
$hue    = new Hue( $bridge, $key );
$light  = 1;

$hue->lights()[$light]->setLight( $hue->predefinedColors( 'green' ) );
sleep( 1 );
$hue->lights()[$light]->setLight( $hue->predefinedColors( 'red' ) );
sleep( 1 );
$hue->lights()[$light]->setLight( $hue->predefinedColors( 'blue' ) );
sleep( 1 );
$hue->lights()[$light]->setLight( $hue->predefinedColors( 'purple' ) );
sleep( 1 );
$hue->lights()[$light]->setLight( $hue->predefinedColors( 'pink' ) );
sleep( 1 );
$hue->lights()[$light]->setLight( $hue->predefinedColors( 'yellow' ) );
sleep( 1 );
$hue->lights()[$light]->setLight( $hue->predefinedColors( 'orange' ) );
sleep( 1 );
$hue->lights()[$light]->setLight( $hue->predefinedColors( 'coolwhite' ) );
sleep( 1 );
$hue->lights()[$light]->setLight( $hue->predefinedColors( 'warmwhite' ) );
sleep( 1 );
