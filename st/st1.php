<?php
header("Content-type: image/png");
if (isset($_GET['t'])){$t = $_GET['t'];}else{$t='[]';}
$t = json_decode($_GET['t']);


$assets_path = "../../assets";
require("../../lib/objects_names.php");

$width = 560;
$height = 560;


// Створюємо зображення
$back = imagecreatetruecolor($width, $height);

$background_color = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $background_color);


$col = 2;
for($k=0;$k<count($t);$k+=1){
    $j = $k%$col;
    $i = intdiv($k,$col);
    $object_name = $t[$k];
    $object_group = find_object_group($object_name , $names);
    $str = $assets_path."/images/flat440/{$object_group}/{$object_name}.png";
    $object = imagecreatefrompng($str);
    imagecopyresampled($back,$object  ,     280*$j+23, 280*$i+23 ,0  , 0, 160, 160, 440, 440);
}

// imageline($back,300,0,300,600, $black);
// imageline($back,0,300,600,300, $black);

imagepng($back);
imagedestroy($back);

?>