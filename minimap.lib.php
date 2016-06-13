<?php

$minimap = new Minimap();

$location1 = $minimap->addLocation();
$location1->setName("Lavender town");
$location1->setTileName("town");
$location1->setVisitable(true);

var_dump($minimap);

class Minimap {
    private $_locations = array();

    function __construct() {

    }

    public function addLocation() {
        return $this->_locations[] = new MinimapLocation();
    }
}

class MinimapLocation extends Minimap {
    private $_name = '';
    private $_tile_name = '';
    private $_location = array();

    private $_visitable = false;
    private $_visited = false;

    private $_classes = array();

    public function setName($name) { return $this->_name = (string)$name; }
    public function setTileName($tile_name) { return $this->_tile_name = (string)$tile_name; }
    public function setVisitable($bool) { return $this->_visitable = (bool)$bool; }
    public function setVisited($bool) { return $this->_visited = (bool)$bool; }
    public function setLocation($x, $y) { return $this->_location = (array)array((int)$x, (int)$y); }

    public function addClass($class) { return $this->_classes[] = (string)$class; }

    public function getName() { return (string)$this->_name; }
    public function getTileName() { return (string)$this->_tile_name; }
    public function getVisitable() { return (bool)$this->_visitable; }
    public function getVisited() { return (bool)$this->_visited; }
    public function getClasses() { return (array)$this->_classes; }
    public function getLocation() { return $this->_location; }

    function __construct() {

    }
}

?>