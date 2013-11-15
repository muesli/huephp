<?php

require( 'pest-master/PestJSON.php' );

class Light
{
    private $parent;
    private $id = 0;
    private $name = "";
    private $type = "";
    private $modelid = "";
    private $swversion = "";
    private $state = false;
    private $reachable = false;
    private $bri = 0; // 0 to 255
    private $hue = 0; // 0 to 65535
    private $sat = 0; // 0 to 255
    private $ct = 0; // 0 to 500
    private $alert = "none"; // "none", "select" or "lselect"
    private $effect = "none"; // "none" or "colorloop"
    private $colormode = "none"; // "hs", "xy" or "ct"


    public function __construct( $parent, $lightid, $json )
    {
        $this->parent = $parent;
        $data = json_decode( $json, true );

        if ( isset( $data["state"] ) )
        {
            $this->id = $lightid;
            $this->name = $data["name"];
            $this->type = $data["type"];
            $this->modelid = $data["modelid"];
            $this->swversion = $data["swversion"];
            $this->state = $data["state"]["on"];
            $this->reachable = $data["state"]["reachable"];
            $this->bri = @$data["state"]["bri"];
            $this->hue = @$data["state"]["hue"];
            $this->sat = @$data["state"]["sat"];
            $this->ct = @$data["state"]["ct"];
            $this->alert = $data["state"]["alert"];
            $this->effect = $data["state"]["effect"];
            $this->colormode = $data["state"]["colormode"];
        }
    }


    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function type()
    {
        return $this->type;
    }

    public function modelid()
    {
        return $this->modelid;
    }

    public function swversion()
    {
        return $this->swversion;
    }

    public function state()
    {
        return $this->state;
    }

    public function reachable()
    {
        return $this->reachable;
    }

    public function bri()
    {
        return $this->bri;
    }

    public function hue()
    {
        return $this->hue;
    }

    public function sat()
    {
        return $this->sat;
    }

    public function ct()
    {
        return $this->ct;
    }

    public function alert()
    {
        return $this->alert;
    }

    public function effect()
    {
        return $this->effect;
    }

    public function colormode()
    {
        return $this->colormode;
    }


    // Sets the alert state. 'select' blinks once, 'lselect' blinks repeatedly, 'none' turns off blinking
    public function setAlert( $type = 'select' )
    {
        $data = json_encode(array( "alert" => $type ) );
        $pest = $this->parent->makePest();
        $pest->put( "lights/" .$this->id. "/state", $data );

        $this->parent->update( $this->id );
    }


    // Sets the state property
    public function setLight( $input )
    {
        $data = json_encode( $input );
        $pest = $this->parent->makePest();
        $pest->put( "lights/" .$this->id. "/state", $data );

        $this->parent->update( $this->id );
    }
}


class Hue
{
    private $bridge;
    private $key;
    private $lights;


    public function __construct( $bridge, $key )
    {
        $this->bridge = $bridge;
        $this->key = $key;

        $this->update();
    }


    public function makePest()
    {
        return new Pest( "http://" .$this->bridge. "/api/" .$this->key. "/" );
    }


    private function makeLightArray( $lightid = false )
    {
        $targets = array();

        if ( $lightid === false )
        {
            $targets = $this->lightIds();
        }
        else
        {
            if ( !is_array( $lightid ) )
            {
                $targets[] = $lightid;
            }
            else
            {
                $targets = $lightid;
            }
        }

        return $targets;
    }


    // Registers with a Hue hub
    public function register()
    {
        $pest = new Pest( "http://" .$this->bridge. "/api" );
        $data = json_encode( array( 'devicetype' => 'phpHue' ) );
        $result = $pest->post( '', $data );

        return $result;
    }


    public function update( $lightid = false )
    {
        $lights = $this->makeLightArray( $lightid );
        foreach ( $lights as $id )
        {
            $pest = $this->makePest();
            $data = $pest->get( "lights/$id" );

            $this->lights[ $id ] = new Light( $this, $id, $data );
        }
    }


    public function lights()
    {
        return $this->lights;
    }


    // Returns an array of the light numbers in the system
    public function lightIds()
    {
        $pest = $this->makePest();
        $result = json_decode( $pest->get( 'lights' ), true );
        $targets = array_keys( $result );

        return $targets;
    }


    // Gets the full state of the bridge
    public function state()
    {
        $pest = $this->makePest();
        return $pest->get( "" );
    }


    // Gets an array of currently configured schedules
    public function schedules()
    {
        $pest = $this->makePest();
        $result = json_decode( $pest->get( "schedules" ), true );

        return $result;
    }


    // Gin up a random color
    public function randomColor()
    {
        $return = array();

        $return['hue'] = rand( 0, 65535 );
        $return['sat'] = rand( 0, 254 );
        $return['bri'] = rand( 0, 254 );

        return $return;
    }


    // Gin up a random temp-based white setting
    public function randomWhite()
    {
        $return = array();
        $return['ct'] = rand( 150, 500 );
        $return['bri'] = rand( 0, 255 );

        return $return;
    }


    // Build a few color commands based on color names
    public function predefinedColors( $colorname )
    {
        $command = array();
        switch ( $colorname )
        {
            case "green":
                $command['hue'] = 182 * 140;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "red":
                $command['hue'] = 0;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "blue":
                $command['hue'] = 182 * 250;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "coolwhite":
                $command['ct']  = 150;
                $command['bri'] = 254;
                break;

            case "warmwhite":
                $command['ct']  = 500;
                $command['bri'] = 254;
                break;

            case "orange":
                $command['hue'] = 182 * 25;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "yellow":
                $command['hue'] = 182 * 85;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "pink":
                $command['hue'] = 182 * 300;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "purple":
                $command['hue'] = 182 * 270;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;
        }

        return $command;
    }
}

?>
