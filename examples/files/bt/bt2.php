<?php
declare(strict_types = 1);

include '../config.php';




$assets_path = getAssetsPath();
// $names = getNames();

// Отримуємо параметри запиту 't'
if (isset($_GET['t'])) {
    $t = $_GET['t'];
} else {
    $t = '[]';
}
$t = json_decode($_GET['t']);

// Перевіряємо, щоб аргументи були в межах від 0 до 10
foreach ($t as &$value) {
    if ($value < 0) {
        $value = 0;
    } elseif ($value > 10) {
        $value = 10;
    }
}

// Розміри зображення
$width = 560;
$height = $t[0] <= 5 ? 112 : 224; // Змінено висоту основного прямокутника на 224

// Створюємо зображення
$back = imagecreatetruecolor($width, $height);

// Колір фону (сірий)
$gray = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $gray);

// Білий колір для квадратів
$white = imagecolorallocate($back, 255, 255, 255);

// Колір бордера (RGB)
$border_color = imagecolorallocate($back, 229, 236, 240);

// Функція для малювання заокругленого прямокутника
function draw_rounded_rectangle($image, $x1, $y1, $x2, $y2, $radius, $color, $border_color, $border_thickness) {
    // Малюємо заокруглені кути
    imagefilledellipse($image, $x1 + $radius, $y1 + $radius, $radius * 2, $radius * 2, $color);
    imagefilledellipse($image, $x2 - $radius, $y1 + $radius, $radius * 2, $radius * 2, $color);
    imagefilledellipse($image, $x1 + $radius, $y2 - $radius, $radius * 2, $radius * 2, $color);
    imagefilledellipse($image, $x2 - $radius, $y2 - $radius, $radius * 2, $radius * 2, $color);
    
    // Малюємо внутрішні квадрати
    imagefilledrectangle($image, $x1 + $radius, $y1, $x2 - $radius, $y2, $color);
    imagefilledrectangle($image, $x1, $y1 + $radius, $x2, $y2 - $radius, $color);
    
    // Малюємо бордер
    imagerectangle($image, $x1, $y1, $x2, $y2, $border_color);
}

// Відступ вниз на 16
$y_offset = 16;

// Малюємо перший прямокутник з сіткою
$rect_width = 560; // Ширина основного прямокутника
$rect_height = 224; // Висота основного прямокутника
$rect_x = 0;
$rect_y = 0; // Змінено на 0, щоб прямокутник займав весь простір

draw_rounded_rectangle($back, $rect_x, $rect_y, $rect_x + $rect_width, $rect_y + $rect_height, 0, $gray, $border_color, 1);

// Малюємо сітку та кружки
$grid_cols = 5; // Кількість колонок
$grid_rows = 2; // Кількість рядків

$slot_width = 112; // Ширина однієї комірки
$slot_height = 112; // Висота однієї комірки

$circle_img = imagecreatefrompng($assets_path."/images/flat96/shapes-filled/circle.png");
$circle_size = 48; // Розмір круга

// Позиції сітки починаються з 0
$rect_x = 0;
$rect_y = 0; // Встановлено відступ зверху

$circle_count = $t[0]; // Кількість кіл дорівнює другому аргументу

for ($row = 0; $row < $grid_rows; $row++) {
    for ($col = 0; $col < $grid_cols; $col++) {
        $slot_x = $rect_x + $col * $slot_width;
        $slot_y = $rect_y + $row * $slot_height;
        
        // Малюємо прямокутник (комірку сітки)
        imagefilledrectangle($back, $slot_x, $slot_y, $slot_x + $slot_width, $slot_y + $slot_height, $gray);
        imagerectangle($back, $slot_x, $slot_y, $slot_x + $slot_width, $slot_y + $slot_height, $border_color);

        // Малюємо кружки, якщо є ще вільні
        if ($circle_count > 0) {
            $circle_x = $slot_x + ($slot_width - $circle_size) / 2;
            $circle_y = $slot_y + ($slot_height - $circle_size) / 2;
            imagecopyresampled($back, $circle_img, $circle_x, $circle_y, 0, 0, $circle_size, $circle_size, imagesx($circle_img), imagesy($circle_img));
            $circle_count--;
        }
    }
}

header("Content-type: image/png");

// Завершуємо роботу
imagedestroy($circle_img);
imagepng($back);
imagedestroy($back);
?>
