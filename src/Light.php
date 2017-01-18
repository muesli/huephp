<?php

namespace Hue;

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
        $data         = json_decode( $json, true );

        if (isset( $data["state"] )) {
            $this->id        = $lightid;
            $this->name      = $data["name"];
            $this->type      = $data["type"];
            $this->modelid   = $data["modelid"];
            $this->swversion = $data["swversion"];
            $this->state     = $data["state"]["on"];
            $this->reachable = $data["state"]["reachable"];
            $this->bri       = @$data["state"]["bri"];
            $this->hue       = @$data["state"]["hue"];
            $this->sat       = @$data["state"]["sat"];
            $this->ct        = @$data["state"]["ct"];
            $this->alert     = $data["state"]["alert"];
            $this->effect    = @$data["state"]["effect"];
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
        $data = json_encode( array( "alert" => $type ) );
        $this->parent->pest()->put( "lights/" . $this->id . "/state", $data );

        $this->parent->update( $this->id );
    }


    // Sets the state property
    public function setLight( $input )
    {
        $data = json_encode( $input );
        $this->parent->pest()->put( "lights/" . $this->id . "/state", $data );

        $this->parent->update( $this->id );
    }

}
