<?php

declare(strict_types = 1);

include '../config.php';

$assets_path = getAssetsPath();
$names = getNames();


// Встановлюємо значення за замовчуванням для параметра t
$default_objects = ["circle-phisical", "rectangle-phisical", "square-phisical", "triangle-phisical"];

if (isset($_GET['t'])) {
    $t = json_decode($_GET['t']);
} else {
    $t = $default_objects;
}

$count = count($t); // Кількість аргументів
// Заміна порожніх значень на значення за замовчуванням
foreach ($t as $key => $value) {
    if (empty($value)) {
        $t[$key] = $default_objects[$key]; // Замінюємо порожній рядок на значення за замовчуванням
    }
}

// $assets_path = "../../assets";
// require("../../lib/objects_names.php");

$width = 560;
$height = 560;

if ($count == 1) {
    $width = 280;
    $height = 280;
} elseif ($count == 2) {
    $width = 560;
    $height = 280;
} else {
    $width = 560;
    $height = 560;
}

// Створюємо зображення
$back = imagecreatetruecolor($width, $height);

$background_color = imagecolorallocate($back, 244, 247, 248);
$line_color = imagecolorallocate($back, 229, 236, 240); // Колір для ліній
imagefill($back, 0, 0, $background_color);

// Малюємо центральні лінії
imageline($back, 280, 0, 280, 560, $line_color);
imageline($back, 0, 280, 560, 280, $line_color);

$col = 2; // Кількість стовпців
$image_size = 160; // Розмір об'єкта
$center_offset = $image_size / 2; // Зсув для центрованого розташування

// Центри кожної з чотирьох частин
$centers = [
    [140, 140], // Верхній лівий
    [420, 140], // Верхній правий
    [140, 420], // Нижній лівий
    [420, 420], // Нижній правий
];

for ($k = 0; $k < count($t); $k += 1) {
    $object_name = $t[$k];
    $object_group = findGroupName($object_name);
    $str = $assets_path . "images/flat440/{$object_group}/{$object_name}.png";


    // Перевіряємо, чи існує зображення перед його використанням
    if (file_exists($str)) {
        $object = imagecreatefrompng($str);

        // Визначаємо центр для поточного об'єкта
        $center_x = $centers[$k][0];
        $center_y = $centers[$k][1];

        // Малюємо об'єкт по центру відповідної частини
        imagecopyresampled($back, $object, $center_x - $center_offset, $center_y - $center_offset, 0, 0, $image_size, $image_size, 440, 440);
    } else {
        // Виводимо повідомлення про відсутність зображення, якщо його не знайдено
        error_log("Image not found: $str");
    }
}


header("Content-type: image/png");

imagepng($back);
imagedestroy($back);
?>
