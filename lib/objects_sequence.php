<?php

header("Content-type: image/png");
if (isset($_GET['t'])){$t = $_GET['t'];}else{$t='[]';}
$t = json_decode($_GET['t']);

// $back = imagecreatefrompng ("images/canvas.png");
$back = imagecreatefromjpeg ("../../images/canvas.jpg");
$font_file = '../../Inter.ttf';
require("../lib/objects.php");

$col = 10;
for ($k=0;$k<count($objects);$k+=1){
    $j = $k%$col;
    $i = intdiv($k,$col);
    imagefttext($back, 30, 0, 50 +150*$i, 50+50*$j, $black, $font_file, $k);
    imagecopyresampled($back , $objects[$k],100+150*$i, 50*$j, 0, 0, 50, 50, 64, 64);
}
imagepng($back);
imagedestroy($back);

?>