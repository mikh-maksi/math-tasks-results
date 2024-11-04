<?php
declare(strict_types = 1);

include '../config.php';

// !!! Service elements
// !!! Add to the list!
$assets_path = getAssetsPath() . "images/flat96/shapes-elements";

// Отримуємо параметри запиту 't'
if (isset($_GET['t'])) {
    // Декодуємо JSON, отримуємо масив
    $t = json_decode($_GET['t']);
    // Перевіряємо, чи це масив і чи він містить значення
    if (is_array($t) && count($t) > 0) {
        $t = $t[0]; // Отримуємо перший елемент масиву
    } else {
        $t = 'square'; // Значення за замовчуванням
    }
} else {
    $t = 'square'; // Значення за замовчуванням
}



if ($t == 'square') {

$width = 560;
$height = 480;
// Створюємо зображення
$back = imagecreatetruecolor($width, $height);
//Колір
$gray = imagecolorallocate($back, 244, 247, 248);
$border_color = imagecolorallocate($back, 229, 236, 240);
imagefill($back, 0, 0, $gray); // Створюємо фон першочергово
// Малюємо лінії після створення основи
imageline($back, 0, 320, 560, 320, $border_color);  // Верхня горизонтальна лінія
imageline($back, 0, 160, 560, 160, $border_color);  // Нижня горизонтальна лінія
imageline($back, 280, 160, 280, 320, $border_color);  // Вертикальна лінія


    // Завантажуємо малюнки
    $img_square_top = imagecreatefrompng($assets_path . "/triangle-filled-el-square-down.png");
    $img_square_left = imagecreatefrompng($assets_path . "/triangle-filled-el-square-left.png");
    $img_square_right = imagecreatefrompng($assets_path . "/triangle-filled-el-square-right.png");
    $img_square_down = imagecreatefrompng($assets_path . "/triangle-filled-el-square-up.png");

    // Фіксований розмір малюнків
    $img_width = 96;
    $img_height = 96;

    // Центри частин
    $center_top = ['x' => 280, 'y' => 400];
    $center_left = ['x' => 140, 'y' => 240];
    $center_right = ['x' => 420, 'y' => 240];
    $center_down = ['x' => 280, 'y' => 80];

    // Відмалюємо зображення поверх фону та ліній
    imagecopy($back, $img_square_top, $center_top['x'] - $img_width / 2, $center_top['y'] - $img_height / 2, 0, 0, $img_width, $img_height);
    imagecopy($back, $img_square_left, $center_left['x'] - $img_width / 2, $center_left['y'] - $img_height / 2, 0, 0, $img_width, $img_height);
    imagecopy($back, $img_square_right, $center_right['x'] - $img_width / 2, $center_right['y'] - $img_height / 2, 0, 0, $img_width, $img_height);
    imagecopy($back, $img_square_down, $center_down['x'] - $img_width / 2, $center_down['y'] - $img_height / 2, 0, 0, $img_width, $img_height);

    // Знищуємо малюнки
    imagedestroy($img_square_top);
    imagedestroy($img_square_left);
    imagedestroy($img_square_right);
    imagedestroy($img_square_down);
}

if ($t == 'triangle') {

$width = 560;
$height = 160;
// Створюємо зображення
$back = imagecreatetruecolor($width, $height);
//Колір
$gray = imagecolorallocate($back, 244, 247, 248);
$border_color = imagecolorallocate($back, 229, 236, 240);
imagefill($back, 0, 0, $gray); // Створюємо фон першочергово
// Малюємо лінії після створення основи
imageline($back, 280, 0, 280, 160, $border_color);  // Вертикальна лінія


    // Завантажуємо малюнки
    $img_triangle_left = imagecreatefrompng($assets_path . "/triangle-filled-el-triangle-left.png");
    $img_triangle_right = imagecreatefrompng($assets_path . "/triangle-filled-el-triangle-right.png");


    // Фіксований розмір малюнків
    $img_width = 96;
    $img_height = 96;

    // Центри частин
    $center_left = ['x' => 140, 'y' => 80];
    $center_right = ['x' => 420, 'y' => 80];


    // Відмалюємо зображення поверх фону та ліній
    imagecopy($back, $img_triangle_left, $center_left['x'] - $img_width / 2, $center_left['y'] - $img_height / 2, 0, 0, $img_width, $img_height);
    imagecopy($back, $img_triangle_right, $center_right['x'] - $img_width / 2, $center_right['y'] - $img_height / 2, 0, 0, $img_width, $img_height);


    // Знищуємо малюнки

    imagedestroy($img_triangle_left);
    imagedestroy($img_triangle_right);

}

if ($t == 'rectangle') {

$width = 560;
$height = 320;
// Створюємо зображення
$back = imagecreatetruecolor($width, $height);
//Колір
$gray = imagecolorallocate($back, 244, 247, 248);
$border_color = imagecolorallocate($back, 229, 236, 240);
imagefill($back, 0, 0, $gray); // Створюємо фон першочергово
// Малюємо лінії після створення основи
imageline($back, 280, 0, 280, 560, $border_color);  // Вертикальна лінія
imageline($back, 0, 160, 560, 160, $border_color);  // Вертикальна лінія

    // Завантажуємо малюнки
    $img_rectangle = imagecreatefrompng($assets_path . "/rectangle-filled-el-rectangle.png");

    // Фіксований розмір малюнків
    $img_width = 96;
    $img_height = 96;

    // Центри частин
    $top_left = ['x' => 140, 'y' => 80];
    $top_right = ['x' => 420, 'y' => 80];
    $bottom_left = ['x' => 140, 'y' => 240];
    $bottom_right = ['x' => 420, 'y' => 240];


    // Відмалюємо зображення поверх фону та ліній
    imagecopy($back, $img_rectangle, $top_left['x'] - $img_width / 2, $top_left['y'] - $img_height / 2, 0, 0, $img_width, $img_height);
    imagecopy($back, $img_rectangle, $top_right['x'] - $img_width / 2, $top_right['y'] - $img_height / 2, 0, 0, $img_width, $img_height);
    imagecopy($back, $img_rectangle, $bottom_left['x'] - $img_width / 2, $bottom_left['y'] - $img_height / 2, 0, 0, $img_width, $img_height);
    imagecopy($back, $img_rectangle, $bottom_right['x'] - $img_width / 2, $bottom_right['y'] - $img_height / 2, 0, 0, $img_width, $img_height);


    // Знищуємо малюнки

    imagedestroy($img_rectangle);

}

if ($t == 'hexagon') {

$width = 558;
$height = 320;
// Створюємо зображення
$back = imagecreatetruecolor($width, $height);
//Колір
$gray = imagecolorallocate($back, 244, 247, 248);
$border_color = imagecolorallocate($back, 229, 236, 240);
imagefill($back, 0, 0, $gray); // Створюємо фон першочергово
// Малюємо лінії після створення основи
imageline($back, 0, 160, 558, 160, $border_color);  // Горизонтальна лінія
imageline($back, 186, 0, 186, 560, $border_color);  // Вертикальна лінія1
imageline($back, 372, 0, 372, 560, $border_color);  // Вертикальна лінія2

    // Завантажуємо малюнки
    $img_down = imagecreatefrompng($assets_path . "/triangle-filled-el-hexagon-topdown.png");
    $img_up = imagecreatefrompng($assets_path . "/triangle-filled-el-hexagon-topup.png");

    // Фіксований розмір малюнків
    $img_width = 96;
    $img_height = 96;

    // Центри частин
    $top_left = ['x' => 93, 'y' => 240];
    $top_middle = ['x' => 279, 'y' => 240];
    $top_right = ['x' => 465, 'y' => 240];
    $bottom_left = ['x' => 93, 'y' => 80];
    $bottom_middle = ['x' => 279, 'y' => 80];
    $bottom_right = ['x' => 465, 'y' => 80];


    // Відмалюємо зображення поверх фону та ліній
    imagecopy($back, $img_down, $top_left['x'] - $img_width / 2, $top_left['y'] - $img_height / 2, 0, 0, $img_width, $img_height);
    imagecopy($back, $img_up, $top_middle['x'] - $img_width / 2, $top_middle['y'] - $img_height / 2, 0, 0, $img_width, $img_height);
    imagecopy($back, $img_down, $top_right['x'] - $img_width / 2, $top_right['y'] - $img_height / 2, 0, 0, $img_width, $img_height);
    imagecopy($back, $img_up, $bottom_left['x'] - $img_width / 2, $bottom_left['y'] - $img_height / 2, 0, 0, $img_width, $img_height);
    imagecopy($back, $img_down, $bottom_middle['x'] - $img_width / 2, $bottom_middle['y'] - $img_height / 2, 0, 0, $img_width, $img_height);
    imagecopy($back, $img_up, $bottom_right['x'] - $img_width / 2, $bottom_right['y'] - $img_height / 2, 0, 0, $img_width, $img_height);


    // Знищуємо малюнки

    imagedestroy($img_down);
    imagedestroy($img_up);

}

header("Content-type: image/png");

// Виводимо зображення
imagepng($back);

// Знищуємо ресурс зображення
imagedestroy($back);
?>
