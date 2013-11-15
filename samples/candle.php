#!/usr/bin/php
<?php

require( '../hue.php' );

$bridge = '192.168.0.162';
$key = "replace_this_with_a_real_key";
$hue = new Hue( $bridge, $key );
$lightRange = [ 1, 3 ];

while ( true )
{
    $target = rand( $lightRange[0], $lightRange[1] );
    $command = array( 'ct' => rand( 350, 500 ),
                      'bri' => rand( 25, 75 ) );
    $hue->lights()[$target]->setLight( $command );

    usleep( 100000 );
}
