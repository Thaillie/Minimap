<?php

require_once '../minimap.lib.php';

$xml = simplexml_load_file('test.tmx');

$minimap = new Minimap();
$minimap->setTilesUrl('/Minimap/tests/tiles/');
$minimap->setHeight(100);
$minimap->setWidth(100);

$location1 = $minimap->addLocation(5, 5);
$location1->setName("Lavender town");
$location1->setTileName(5 . '.png');
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
        $tile->setTileName($id_tile . '.png');
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
    </head>
    <body>
        <div style="width: 700px; height: 700px;">
            <?php echo $minimap->generateMinimap(); ?>
        </div>
    </body>
</html>