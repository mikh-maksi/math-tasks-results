<?php

// header("Content-type: image/png");
if (isset($_GET['t'])){$t = $_GET['t'];}else{$t='[]';}
$t = json_decode($_GET['t']);

// $back = imagecreatefrompng ("images/canvas.png");
$back = imagecreatefromjpeg ("../../images/canvas_1280_720.jpg");
$font_file = '../../Inter.ttf';
require("../lib/objects_flat_groups.php");

// print_r($objects_name);

// imagecopyresampled($back , $objects[0],100, 50, 0, 0, 50, 50, 48, 48);

$i = 0;
$j=0;
        $path = '../../images/flat48/fruits/apple.png';
        $path = '../../images/flat48/activities/football.png';
        // $elem = imagecreatefrompng($path);
        // imagecopyresampled($back , $elem,0+250*$i, 50*$j, 0, 0, 50, 50, 48, 48);

$col = 12;
$i = 0;
$n = 0;
$range_i = [0,1,2,3,4];
$range_j = [];
for($j=0;$j<5;$j+=1){
    array_push($range_j,$j);
}
print_r($names);
foreach ($names as $key_group => $value_group){
    $j=0;
    imagefttext($back, 16, 0, 7 +125*$i, 72+35*($j-1), $black, $font_file, $key_group);
    
    foreach ($value_group as $key_img => $value_img){
        $path = "../../images/flat48/".$key_group."/".$value_img.".png";
        $elem = imagecreatefrompng($path);
        imagefttext($back, 8, 0, 37 +125*$i, 72+35*$j, $black, $font_file, $value_img);
        try {
            imagecopyresampled($back , $elem,0+125*$i, 50+35*$j, 0, 0, 35, 35, 48, 48);
        } catch (Exception $e) {
            $n+=1;
        }

        $j+=1;
    }
    $i+=1;
}


// imagepng($back);
// imagedestroy($back);

?>