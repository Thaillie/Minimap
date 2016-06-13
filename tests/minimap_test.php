<html>
    <head>
        <script type="text/javascript" src="/Minimap/js/jquery.min.js"></script>
        <script type="text/javascript" src="/Minimap/js/main.js"></script>
        <link rel="stylesheet" type="text/css" href="/Minimap/css/style.css" />
        <link rel="stylesheet" type="text/css" href="/Minimap/tests/tests.css" />
    </head>
    <body>
        <div style="width: 180px; height: 180px;">
            <?php

            require_once '../minimap.lib.php';

            $minimap = new Minimap();

            $location1 = $minimap->addLocation(5, 5);
            $location1->setName("Lavender town");
            $location1->setTileName("town.png");
            $location1->setVisitable(true);

            for ($y = 1; $y < 11; $y++) {
                for ($x = 1; $x < 11; $x++) {
                    $minimap->addTile($y, $x);
                }
            }

            echo $minimap->generateMinimap();

            ?>
        </div>
    </body>
</html>