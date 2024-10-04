<?php
header("Content-type: image/png");

require("../lib/objects_names.php");


$width = 560;
$height = 112;

$back = imagecreatetruecolor($width, $height);
$gray = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $gray);
$black = imagecolorallocate($back, 0, 0, 0);

$object_image_path = '../../images/flat48/fruits/apple.png';
$objectX = 0;
$objectY = 0;

$objectWidth = 48;
$objectHeight = 48;

$object_image = imagecreatefrompng($object_image_path);
imagecopy($back, $object_image, $objectX, $objectY, 0, 0, $objectWidth, $objectHeight);




// print_r($names);

// echo("<br>");
// echo(find_object_group("banana",$names));

// echo("<br>");
// echo(find_object_group("banana",$names));
// echo("<br>");
// $list = category_list("fruits", $names);
// print_r($list);
// echo("<br>");
// $path = '../../images/flat48/fruits/apple.png';
// echo(file_exists($path));
// if (file_exists($path)){echo "Yes";} else {echo "No";}
// echo("<br>-->");
// $path = '../../images/flat48/fruits/apple1.png';
// if (file_exists($path)){echo "Yes";} else {echo "No";}


imagepng($back);
imagedestroy($back);
?>