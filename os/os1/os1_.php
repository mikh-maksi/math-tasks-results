<?php

$assets_path = "../../assets";

header("Content-type: image/png");
if (isset($_GET['t'])){$t = $_GET['t'];}else{$t='[]';}
$t = json_decode($_GET['t']);


require("../../lib/objects_flat.php");

if (($t[0]>=0) && ($t[0]<=12) ){
    $number = $t[0];
}else{
    $number = 0;
}

if (in_array($t[1],$names) ){
    $type = $t[1];
}else{
    $type = 'apple';
}


if ($number<=4){
    $height = 200;
    // $back = imagecreatefromjpeg ($assets_path."/images/canvases/canvas_560_200.jpg");
}

if (($number>=5) && ($number<=8) ){
    $height = 320;
    // $back = imagecreatefromjpeg ($assets_path."/images/canvases/canvas_560_320.jpg");
}

if (($number>=9) && ($number<=12) ){
    $height = 440;
    // $back = imagecreatefromjpeg ($assets_path."/images/canvases/canvas_560_440.jpg");
}

// Розміри зображення
$width = 560;


// Створюємо зображення
$back = imagecreatetruecolor($width, $height);

// Колір фону (сірий)
$gray = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $gray);


$black = imagecolorallocate($back, 0, 0, 0);


$font_file = '../../Inter.ttf';


$x_start = 44;
$y_start = 44;

$values = [6,12,0,3];
$col = 4;

    $value = $number;
    $object = $objects_name[$type];

    for ($k=0;$k<$value;$k+=1){
            $j = $k%$col;
            $i = intdiv($k,$col);
            imagecopyresampled($back , $object,$x_start+120*$j, $y_start+120*$i, 0, 0, 112, 112, 128, 128);
    }



imagepng($back);
imagedestroy($back);

?>