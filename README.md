huephp
======

PHP library to control the Phillips Hue lighting system. Started out as a fork of the unmaintained phpHue class (https://github.com/danray0424/phpHue) and ended up as a complete rewrite.

Getting Started
---------------

hue.php contains the entire huephp class and all its functions for interacting with the Hue hub.

Check out the "samples" directory. You'll find a few demos, showing you how to interact with huephp. It uses the PEST php REST client for ease of communication, but as a user of huephp, you don't need to worry about the details.

hue command-line tool
---------------------

bin/hue is a command line lighting system controller.

    ./bin/hue
        -i [Hue bridge's ip]

      If you don't already have a valid registered key for this Hue bridge:
        -g [register a new key with the Hue bridge]

      Once have a registered key, you need to specify it with -k:
        -k [valid key that is registered with your Hue hub]

      Use it in combination with one of the following parameters:

        To get information from the bridge:
          -f [fetch full state from Hue hub]
          -c [check light states: returns 0 when a light is off, 1 when on]

        To control the bridge:
          If you don't specify a light number, bin/hue will target all bulbs:
            -l [light number]

          Turning a light on or off:
            -o [0 for turning the light off, 1 for turning it on]

          To set a new color, pick one of the following options:
            -n [color name (see below)]

            or
            -h [hue in degrees on the color circle 0-360]
            -s [saturation 0-254]
            -b [brightness 0-254]

            or
            -t [white color temp 150-500]

          Additionally options are:
            -r [transition time, in seconds. Decimals are legal (".1", for instance)]
            -e [command to execute before changing light setting]


You need to specify an ip (-i), a key (-k) and at least one of the following options: -h, -s, -b, -t, -o or -n. If you don't specify a light, it'll set the values you specify on all of them.

If you don't have a key yet, you can register one by calling bin/hue with -g.

You can turn lights on or off with the -o switch. Any other parameter implies '-o 1'. In other words, if you specify any other parameter when the lamp is off, we'll turn it on for you.

### Presets ###

The '-n' switch takes a one-word name for a color, and sets the selected lights to that color. It has a small list of predefined color names, and simply doesn't do anything if you give it a string it doesn't know. It currently knows red, blue, purple, green, coolwhite, and warmwhite. A '-n' parameter may be overridden in part by other parameters. For instance, "-n red -s 50" will give you a pastel red, and "-n blue -r 10" will produce a 10-second fade to blue. Note that "-n red -h 200" will override the redness of the red command with a hue of 200, which is purpleish, but it will inherit the full saturation and brightness of the "red" preset.
