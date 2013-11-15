#!/usr/bin/php
<?php

require( '../hue.php' );

$bridge = '192.168.0.162';
$key = "replace_this_with_a_real_key";
$hue = new Hue( $bridge, $key );
$light = 1;

$hue->lights()[$light]->setAlert( "lselect" );
sleep( 2 );
$hue->lights()[$light]->setAlert( "none" );

?>
