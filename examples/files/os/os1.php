<?php

declare(strict_types = 1);

include '../config.php';

$assets_path = getAssetsPath();
$names = getNames();


if (isset($_GET['t'])){$t = $_GET['t'];}else{$t='[]';}
$t = json_decode($_GET['t']);


// require($assets_path."lib/objects_flat.php");

if (($t[0]>=0) && ($t[0]<=12) ){
    $number = $t[0];
}else{
    $number = 0;
}



$object_name = $t[1];
// if (in_array($t[1],$names) ){
//     $type = $t[1];
// }else{
//     $type = 'apple';
// }


if ($number<=4){
    $height = 200;
}

if (($number>=5) && ($number<=8) ){
    $height = 320;
}

if (($number>=9) && ($number<=12) ){
    $height = 440;
}

// Розміри зображення
$width = 560;


// Створюємо зображення
$back = imagecreatetruecolor($width, $height);

// Колір фону (сірий)
$gray = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $gray);


$black = imagecolorallocate($back, 0, 0, 0);


$font_file = $assets_path .'/Inter.ttf';


$x_start = 44;
$y_start = 44;

$values = [6,12,0,3];
$col = 4;

    $value = $number;
    // $object = $objects_name[$type];
    $object_group = findGroupName($object_name); // знаходимо його групу
    $str = $assets_path . "/images/flat440/{$object_group}/{$object_name}.png"; 
    $object= imagecreatefrompng($str);

    for ($k=0;$k<$value;$k+=1){
            $j = $k%$col;
            $i = intdiv($k,$col);
            imagecopyresampled($back , $object,$x_start+120*$j, $y_start+120*$i, 0, 0, 112, 112, 440, 440);
    }

    header("Content-type: image/png");

imagepng($back);
imagedestroy($back);

?>