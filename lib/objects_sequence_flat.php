<?php

header("Content-type: image/png");
if (isset($_GET['t'])){$t = $_GET['t'];}else{$t='[]';}
$t = json_decode($_GET['t']);

// $back = imagecreatefrompng ("images/canvas.png");
$back = imagecreatefromjpeg ("../../images/canvas.jpg");
$font_file = '../../Inter.ttf';
require("../lib/objects_flat.php");

// print_r($objects_name);

// imagecopyresampled($back , $objects[0],100, 50, 0, 0, 50, 50, 48, 48);


$col = 12;
for ($k=0;$k<count($objects);$k+=1){
    $j = $k%$col;
    $i = intdiv($k,$col);
    imagefttext($back, 30, 0, 50 +250*$i, 50+50*$j, $black, $font_file, $k);
    imagefttext($back, 20, 0, 100 +250*$i, 50+50*$j, $black, $font_file, $names[$k]);
    imagecopyresampled($back , $objects[$k],0+250*$i, 50*$j, 0, 0, 50, 50, 48, 48);
}
imagepng($back);
imagedestroy($back);

?>