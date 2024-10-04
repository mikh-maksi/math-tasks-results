<?php
header("Content-type: image/png");
if (isset($_GET['t'])){$t = $_GET['t'];}else{$t='[]';}
$t = json_decode($_GET['t']);



$diff = $t[0];
$sub = $t[1];

$back = imagecreatefromjpeg ("../../images/canvas600_100.jpg");


$apple_alfa = imagecreatefrompng ("../../images/apple_red_alfa.png");
$apple = imagecreatefrompng ("../../images/apple_red.png");



for($i = 0; $i<$sub+$diff;$i+=1){
    if ($i<$diff){
        $object = $apple;
    }else{
        $object = $apple_alfa;
    }
    imagecopyresampled($back,$object,50*$i, 20, 0, 0, 50, 50, 128, 128);
}



imagepng($back);
imagedestroy($back);
?>