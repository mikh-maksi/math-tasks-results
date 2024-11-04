<?php

declare(strict_types = 1);

include '../config.php';

$assets_path = getAssetsPath();
$names = getNames();

$width = 560;
$height = 840;
$background = '#F4F7F8';

function getMainObjectPath(int $size = 440): string
{
    $params = json_decode($_GET['t'] ?? '["tree", "circle"]');
    $name = $params[0] ?? 'tree';
    $group = findGroupName($name);
    return getImagePath($group . '/' . $name, $size);
}

function getSecondaryObjectPath(int $size = 96): string
{
    $params = json_decode($_GET['t'] ?? '["tree", "circle"]');
    return getImagePath('shapes-filled/' . $params[1] ?? 'circle', $size);
}

$image  = imagecreatetruecolor($width, $height);

$bg = imagecolorallocate($image, 244, 247, 248);
imagefill($image, 0, 0, $bg);

$line = imagecolorallocate($image, 229, 236, 240);
// first vertical line
imageline($image, 278, 0, 278, 840, $line);
imageline($image, 279, 0, 279, 840, $line);
imageline($image, 280, 0, 280, 840, $line);
imageline($image, 281, 0, 281, 840, $line);

// first horizontal line
imageline($image, 0, 278, 560, 278, $line);
imageline($image, 0, 279, 560, 279, $line);
imageline($image, 0, 280, 560, 280, $line);
imageline($image, 0, 281, 560, 281, $line);

// second horizontal line
imageline($image, 0, 558, 560, 558, $line);
imageline($image, 0, 559, 560, 559, $line);
imageline($image, 0, 560, 560, 560, $line);
imageline($image, 0, 561, 560, 561, $line);

// line 1, section left
$x = 60;
$y = 88;
$w = 160;
$h = 160;
$object = imagecreatefrompng(getMainObjectPath());
$object = resizeImage($object, $w, $h, true);
imagecopyresampled($image, $object, $x, $y, 0, 0, $w, $h, $w, $h);

$x = 118;
$y = 34;
$w = 44;
$h = 44;
$object = imagecreatefrompng(getSecondaryObjectPath());
$object = resizeImage($object, $w, $h, true);
imagecopyresampled($image, $object, $x, $y, 0, 0, $w, $h, $w, $h);

// line 1, section right
$x = 60 + 280;
$y = 32;
$w = 160;
$h = 160;
$object = imagecreatefrompng(getMainObjectPath());
$object = resizeImage($object, $w, $h, true);
imagecopyresampled($image, $object, $x, $y, 0, 0, $w, $h, $w, $h);

$x = 118 + 280;
$y = 202;
$w = 44;
$h = 44;
$object = imagecreatefrompng(getSecondaryObjectPath());
$object = resizeImage($object, $w, $h, true);
imagecopyresampled($image, $object, $x, $y, 0, 0, $w, $h, $w, $h);

// line 2, section left
$x = 88;
$y = 60 + 280;
$w = 160;
$h = 160;
$object = imagecreatefrompng(getMainObjectPath());
$object = resizeImage($object, $w, $h, true);
imagecopyresampled($image, $object, $x, $y, 0, 0, $w, $h, $w, $h);

$x = 34;
$y = 118 + 280;
$w = 44;
$h = 44;
$object = imagecreatefrompng(getSecondaryObjectPath());
$object = resizeImage($object, $w, $h, true);
imagecopyresampled($image, $object, $x, $y, 0, 0, $w, $h, $w, $h);

// line 2, section right
$x = 32 + 280;
$y = 60 + 280;
$w = 160;
$h = 160;
$object = imagecreatefrompng(getMainObjectPath());
$object = resizeImage($object, $w, $h, true);
imagecopyresampled($image, $object, $x, $y, 0, 0, $w, $h, $w, $h);

$x = 202 + 280;
$y = 118 + 280;
$w = 44;
$h = 44;
$object = imagecreatefrompng(getSecondaryObjectPath());
$object = resizeImage($object, $w, $h, true);
imagecopyresampled($image, $object, $x, $y, 0, 0, $w, $h, $w, $h);

// line 3, section left
$x = 60;
$y = 60 + 280 * 2;
$w = 160;
$h = 160;
$object = imagecreatefrompng(getMainObjectPath());
$object = resizeImage($object, $w, $h, true);
imagecopyresampled($image, $object, $x, $y, 0, 0, $w, $h, $w, $h);

$x = 118;
$y = 118 + 280 * 2;
$w = 44;
$h = 44;
$object = imagecreatefrompng(getSecondaryObjectPath());
$object = resizeImage($object, $w, $h, true);
imagecopyresampled($image, $object, $x, $y, 0, 0, $w, $h, $w, $h);

// line 3, section right
$x = 26 + 280;
$y = 26 + 280 * 2;
$w = 228;
$h = 228;
$object = imagecreatefrompng(getSecondaryObjectPath(440));
$object = resizeImage($object, $w, $h, true);
imagecopyresampled($image, $object, $x, $y, 0, 0, $w, $h, $w, $h);

$x = 60 + 280;
$y = 60 + 280 * 2;
$w = 160;
$h = 160;
$object = imagecreatefrompng(getMainObjectPath());
$object = resizeImage($object, $w, $h, true);
imagecopyresampled($image, $object, $x, $y, 0, 0, $w, $h, $w, $h);


imagesavealpha($object, true);
showImage($image);
