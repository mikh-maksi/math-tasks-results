<?php

// $background_color = imagecolorallocate($back, 244, 247, 248); // Визначаємо колір фону
// $front_color = imagecolorallocate($back, 0, 247, 248); // Визначаємо колір фону
// $stroke_color = imagecolorallocate($back, 0, 0, 248); // Визначаємо колір фону
$startX=0;
$startY=0; 
$endX=100; 
$endY=100;
$roundX=10;
$roundY=10;

$strokeColor = new \ImagickPixel('green');
$fillColor= new \ImagickPixel('blue');
$backgroundColor = new \ImagickPixel('white');
    $draw = new \ImagickDraw();

    $draw->setStrokeColor($strokeColor);
    $draw->setFillColor($fillColor);
    $draw->setStrokeOpacity(1);
    $draw->setStrokeWidth(2);

    $draw->roundRectangle($startX, $startY, $endX, $endY, $roundX, $roundY);

    $imagick = new \Imagick();
    $imagick->newImage(500, 500, $backgroundColor);
    $imagick->setImageFormat("png");

    $imagick->drawImage($draw);

    header("Content-Type: image/png");
    echo $imagick->getImageBlob();



?>