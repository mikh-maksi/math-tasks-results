<?php
declare(strict_types = 1);

include '../config.php';

$assets_path = getAssetsPath();
$names = getNames();



if (isset($_GET['t'])){$t = $_GET['t'];}else{$t='[]';}
$t = json_decode($_GET['t']);


$tens = intdiv($t,10);

$ones = $t%10;

$num = (int)$t;


// Розміри зображення
$width = 560;
$height = 240;
// $height_first = 160;


// Створюємо зображення
$back = imagecreatetruecolor($width, $height);

// Колір фону (сірий)
$gray = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $gray);

// $back = imagecreatefromjpeg ('../../images/canvas300_600.jpg');
$black = imagecolorallocate($back, 0, 0, 0);
$blue = imagecolorallocate($back, 100, 100, 255);
$yellow = imagecolorallocate($back, 255, 255, 100);


$font_file = '../../Inter.ttf';

$n = 10;
$start_x = 100;
$start_y = 10;


// imagefilledellipse($back,10,10,10,10, $black);
$k = 0;
for($j=0;$j<$tens;$j+=1){
    for($i=0;$i<10;$i+=1){
        rect($back,$black,$start_x+$j*40,$start_y+$i*20,$blue);
        imageline($back,$start_x+$j*40,$start_y+$i*20,$start_x+20+$j*40,$start_y+$i*20, $black);
        if ($k<$num){
        // imagefilledellipse($back,$start_x+$j*40+10,$start_y+$i*20+10,10,10, $black);
        $k+=1;
        }
    }
    $i = 10;

    imageline($back,$start_x+$j*40,$start_y+$i*20,$start_x+20+$j*40,$start_y+$i*20, $black);
    imageline($back,$start_x+$j*40,$start_y+0,$start_x+$j*40,$start_y+$n*20, $black);
    imageline($back,$start_x+$j*40+20,$start_y+0,$start_x+$j*40+20,$start_y+$n*20, $black);
}

$start_x = 100+$tens*40+20;
$start_y = 50;

for ($i=0;$i<$ones;$i+=1){
    rect($back,$black,$start_x+($i%2)*30,$start_y+$i*20,$yellow);
}

// imagefilledrectangle($back, $start_x, $start_y, $start_x+20, $start_y+20, $blue);
// imagefilledrectangle($back, $start_x, $start_y+40, $start_x+20, $start_y+60, $yellow);

// rect($back,$black,$start_x,$start_y);
// rect($back,$black,$start_x+30,$start_y+20);
// rect($back,$black,$start_x,$start_y+40);


function rect($back,$black,$start_x,$start_y,$color){
    imagefilledrectangle($back, $start_x, $start_y, $start_x+20, $start_y+20, $color);
    imageline($back,$start_x,$start_y,$start_x+20,$start_y,$black);
    imageline($back,$start_x+20,$start_y,$start_x+20,$start_y+20,$black);
    imageline($back,$start_x+20,$start_y+20,$start_x,$start_y+20,$black);
    imageline($back,$start_x,$start_y+20,$start_x,$start_y,$black);
}

imageline($back,$start_x,$start_y,$start_x+20,$start_y,$black);
imageline($back,$start_x+20,$start_y,$start_x+20,$start_y+20,$black);
imageline($back,$start_x+20,$start_y+20,$start_x,$start_y+20,$black);
imageline($back,$start_x,$start_y+20,$start_x,$start_y,$black);


imageline($back,$start_x,$start_y,$start_x+20,$start_y,$black);



// imageline($back,0,0,0,$n*20, $black);
// imageline($back,20,0,20,$n*20, $black);
// imageline($back,0,0,40,0, $black);
// imageline($back,0,20,40,20, $black);
// imageline($back,0,40,40,40, $black);
// imageline($back,0,60,40,60, $black);


// imageline($back,0,0,0,100, $black);
// imageline($back,20,0,20,100, $black);
// imageline($back,40,0,40,100, $black);
// imageline($back,0,0,0,100, $black);


// imageline($back,300,300,300,270, $black);
// imagefilledellipse($back,300,270,10,10, $black);

header("Content-type: image/png");
imagepng($back);
imagedestroy($back);

?>