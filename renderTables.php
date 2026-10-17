<?php
// renders ultranova/mininova wavetables
$xml = simplexml_load_file('nun.xml');

$img = imagecreate(55*10, 37*17);
$x = 0;
$y = 0;
$white = imagecolorallocate($img, 255, 255, 255);
$black = imagecolorallocate($img, 0, 0, 0);
imagefill($img, 0, 0, $white);

// draw labels of partials
for ($i = 0; $i < 10; $i++) {
    if ($i > 0) {
        imagestring($img, 5, $x+28, $y, $i, $black);
    }
    $x = $x + 55;
}
$x = 0;
$y = $y + 17;

$wtNum = 1;
foreach ($xml->menu_element as $menu_element) {
    foreach ($menu_element->wavetable as $wavetable) {
        imagestring($img, 5, $x+5, $y, sprintf('WT%02d', $wtNum), $black);
        $x = $x + 55;
        foreach ($wavetable->index as $index) {
            // echo $index['partials'] . PHP_EOL;
            $partials = explode(',',$index['partials']);
            foreach ($partials as $partial) {
                // echo round(floatval($partial))."\n";
                imageline($img, $x, $y+17, $x, $y + 17 - round(floatval($partial)), $black);
                $x = $x + 1;
            }
        }
        echo 'y = ' . $y . "\n";
        $y = $y+17;
        $x = 0;
        $wtNum++;
    }
    echo '---' . PHP_EOL;
}

imagepng($img, 'tables.png');