<?php

class Minimap {
    private $_locations = array();
    private $_tiles = array();

    private $_height = 10;
    private $_width = 10;

    protected $_tile_height = 32;
    protected $_tile_width = 32;

    private $_tiles_url = '/';

    public function setHeight($height) { return $this->_height = (int)$height; }
    public function setWidth($width) { return $this->_width = (int)$width; }

    public function setTileHeight($height) { return $this->_tile_height = (int)$height; }
    public function setTileWidth($width) { return $this->_tile_width = (int)$width; }

    public function setTilesUrl($tiles_url) { return $this->_tiles_url = (string)$tiles_url; }

    function __construct() {

    }

    public function addTile($y, $x, $tile_name = '') {
        if (((int)$x > $this->_width || (int)$x <= 0) || ((int)$y > $this->_height || (int)$y <= 0)) {
            throw new Exception("MinimapTile out of bounds.");
        }

        $this->_tiles[(int)$y][(int)$x] = new MinimapTile((int)$y, (int)$x);
        $this->_tiles[(int)$y][(int)$x]->setTileName($tile_name);

        return $this->_tiles[(int)$y][(int)$x];
    }

    public function addLocation($y, $x) {
        if (((int)$x > $this->_width || (int)$x <= 0) || ((int)$y > $this->_height || (int)$y <= 0)) {
            throw new Exception("MinimapLocation out of bounds.");
        }

        return $this->_locations[(int)$y][(int)$x] = new MinimapLocation((int)$y, (int)$x);
    }

    public function generateMinimap() {
        if ((empty($this->_tile_height) || empty($this->_tile_width)) || (($this->_tile_height <= 0) || ($this->_tile_width <= 0))) {
            throw new Exception("Tile width or height is an invalid value");
        }

        if ((empty($this->_height) || empty($this->_width)) || (($this->_height <= 0) || ($this->_width <= 0))) {
            throw new Exception("Minimap width or height is an invalid value");
        }

        $tile_height = ((100 / ($this->_tile_height * $this->_height)) * $this->_tile_height);
        $tile_width = ((100 / ($this->_tile_width * $this->_width)) * $this->_tile_width);

        $html = '<div id="Minimap"><div class="container">';
        for ($y = 1; $y < ($this->_height + 1); $y++) {
            $html .= '<div class="divider-' . $y . '" style="height: ' . $tile_height . '%;">';

            for ($x = 1; $x < ($this->_width + 1); $x++) {
                if (empty($this->_tiles[$y][$x])) {
                    $html .= '<div class="tile-' . $y . '-' . $x . '" style="height: ' . $tile_height . '%; width: ' . $tile_width . '%;"></div>';
                    continue;
                }

                if (!empty($this->_locations[$y][$x])) {
                    $html .= $this->_locations[$y][$x]->getLocationHtml($this->_tiles_url, $tile_height, $tile_width);
                    continue;
                }

                $html .= $this->_tiles[$y][$x]->getTileHtml($this->_tiles_url, $tile_height, $tile_width);
            }

            $html .= '</div>';
        }

        $html .= '</div></div>';

        return $html;
    }
}

class MinimapTile extends Minimap {
    private $_tile_name = '';
    private $_location = array();

    public function setTileName($tile_name) { return $this->_tile_name = (string)$tile_name; }

    function __construct($y, $x) {
        if (empty((int)$y) || empty((int)$x)) {
            throw new Exception("One or both coordinates missing");
        }

        $this->_location = array_merge($this->_location, array((int)$y, (int)$x));
    }

    public function getTileHtml($tiles_url, $tile_height, $tile_width) {
        $html = '
        <div class="tile-' . $this->_location[0] . '-' . $this->_location[1] . '" style="height: 100%; width: ' . $tile_width . '%; ' . (!empty($this->_tile_name) ? 'background-image: url(' . $tiles_url . $this->_tile_name . ')' : '') . '">
            
        </div>
        ';

        return $html;
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

    public function addClass($class) { return $this->_classes[] = (string)$class; }

    public function getName() { return (string)$this->_name; }
    public function getTileName() { return (string)$this->_tile_name; }
    public function getVisitable() { return (bool)$this->_visitable; }
    public function getVisited() { return (bool)$this->_visited; }
    public function getClasses() { return (array)$this->_classes; }

    function __construct($y, $x) {
        if (empty((int)$y) || empty((int)$x)) {
            throw new Exception("One or both coordinates missing");
        }

        $this->_location = array_merge($this->_location, array((int)$y, (int)$x));
    }

    public function getLocationHtml($tiles_url, $tile_height, $tile_width) {
        $html = '
        <div class="tile-' . $this->_location[0] . '-' . $this->_location[1] . ' location ' . $this->_generateClasses() . '" style="height: 100%; width: ' . $tile_width . '%; ' . (!empty($this->_tile_name) ? 'background-image: url(' . $tiles_url . $this->_tile_name . ')' : '') . '">
            
        </div>
        ';

        return $html;
    }

    private function _generateClasses() {
        if ($this->_visitable) { $this->addClass('visitable'); }
        if ($this->_visited) { $this->addClass('visited'); }

        $classes = implode(' ', $this->_classes);

        return $classes;
    }
}

?>