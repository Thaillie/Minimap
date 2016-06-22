<?php

require_once '../minimap.lib.php';

$xml = simplexml_load_file('test.tmx');

$minimap = new Minimap();
$minimap->setHeight(100);
$minimap->setWidth(100);

foreach ($xml->tileset as $tile_set) {
    $minimap->addTileset($tile_set['name'], 'test.png', $tile_set['tilecount'], $tile_set['columns']);
}

$location1 = $minimap->addLocation(5, 5);
$location1->setName("Lavender town");
$location1->setTileName("town.png");
$location1->setVisitable(true);

preg_match_all('/(\S+\R)/', $xml->layer->data, $columns);
$columns = reset($columns);

$y = 1;
foreach ($columns as $column) {
    $tiles = explode(',', $column);

    $x = 1;
    foreach ($tiles as $id_tile) {
        if (empty((int)$id_tile)) {
            continue;
        }

        $tile = $minimap->addTile($y, $x++);
        $tile->addClass('tiles1-' . $id_tile);
    }

    $y++;
}

?>

<html>
    <head>
        <script type="text/javascript" src="/Minimap/js/jquery.min.js"></script>
        <script type="text/javascript" src="/Minimap/js/main.js"></script>
        <link rel="stylesheet" type="text/css" href="/Minimap/css/style.css" />
        <link rel="stylesheet" type="text/css" href="/Minimap/tests/tests.css" />
        <style type="text/css">
            <?php echo $minimap->getTileCss(); ?>
        </style>
    </head>
    <body>
        <div style="width: 700px; height: 700px;">
            <?php echo $minimap->generateMinimap(); ?>
        </div>
    </body>
</html>