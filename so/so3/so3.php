<?php
$assets_path = "../../assets";

header("Content-type: image/png");

// Перевірка наявності параметра t
if (isset($_GET['t'])) { 
    $t = $_GET['t'];
} else {
    $t = '[]'; // За замовчуванням порожній масив, якщо параметр не заданий
}

// Декодуємо параметр t
$t = json_decode($t);

// Перевірка наявності значень у масиві $t
$image_name_1 = isset($t[0]) ? $t[0] : 'circle'; // Перший аргумент, за замовчуванням 'circle'
$image_name_2 = isset($t[1]) ? $t[1] : 'circle'; // Другий аргумент, за замовчуванням 'circle'

// Створення зображення розміром 560x280
$width = 560;
$height = 280;
$back = imagecreatetruecolor($width, $height);

// Встановлення кольорів
$light_gray = imagecolorallocate($back, 244, 247, 248); // Фон (світло-сірий)
$black = imagecolorallocate($back, 0, 0, 0); // Чорний
$circle_color = imagecolorallocate($back, 229, 236, 240); // Колір для кола та лінії

// Заповнюємо фон світло-сірим кольором
imagefill($back, 0, 0, $light_gray);

// Малюємо вертикальну роздільну лінію по центру
imageline($back, $width / 2, 0, $width / 2, $height, $circle_color);

// Шлях до шрифту
$font_file = $assets_path.'/fonts/Inter.ttf';
// echo $font_file;
// imagettftext($back, $font_size, 0, 7 + 32 / 2 - 7, 7 + 32 / 2 + 7, $black, $font_file,$font_file);

// Додавання літер A і B у колах
$font_size = 16;

// Літера A в лівому верхньому куті
imagefilledellipse($back, 7 + 32 / 2, 7 + 32 / 2, 32, 32, $circle_color); // Коло
imagettftext($back, $font_size, 0, 7 + 32 / 2 - 7, 7 + 32 / 2 + 7, $black, $font_file, "A"); // Літера A

// Літера B в правому верхньому куті
imagefilledellipse($back, $width - 7 - 32 / 2, 7 + 32 / 2, 32, 32, $circle_color); // Коло
imagettftext($back, $font_size, 0, $width - 7 - 32 / 2 - 7, 7 + 32 / 2 + 7, $black, $font_file, "B"); // Літера B

// Функція для завантаження зображення
function load_item_image($image_name) {
    global $assets_path;
    $image_path = $assets_path."/images/flat160/compare/{$image_name}.png"; // Шлях до зображення
    if (file_exists($image_path)) {
        return imagecreatefrompng($image_path); // Завантажуємо зображення
    } else {
        // Якщо зображення не знайдено, завантажуємо дефолтне зображення 'circle.png'
        $default_image_path = $assets_path."/images/flat160/compare/circle.png";
        if (file_exists($default_image_path)) {
            return imagecreatefrompng($default_image_path);
        } else {
            die("Зображення не знайдено: {$image_name}");
        }
    }
}

// Завантажуємо зображення для кожного аргументу
$item_1 = load_item_image($image_name_1); // Перше зображення
$item_2 = load_item_image($image_name_2); // Друге зображення

// Розміри зображень
$image_width = 160;
$image_height = 160;

// Позиції для малювання зображень
$x_offset_1 = ($width / 4) - ($image_width / 2); // Для першого зображення (літера A)
$x_offset_2 = (3 * $width / 4) - ($image_width / 2); // Для другого зображення (літера B)
$y_offset = ($height / 2) - ($image_height / 2); // Центруємо по вертикалі

// Малюємо перше зображення (літера A)
imagecopyresampled($back, $item_1, $x_offset_1, $y_offset, 0, 0, $image_width, $image_height, imagesx($item_1), imagesy($item_1));

// Малюємо друге зображення (літера B)
imagecopyresampled($back, $item_2, $x_offset_2, $y_offset, 0, 0, $image_width, $image_height, imagesx($item_2), imagesy($item_2));

// Виводимо зображення
imagepng($back);

// Звільняємо пам'ять
imagedestroy($back);
imagedestroy($item_1);
imagedestroy($item_2);
?>
