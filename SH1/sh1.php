<?php

header("Content-type: image/png");

// Отримання параметра t
if (isset($_GET['t'])) {
    $t_raw = $_GET['t'];
    
    // Декодування JSON
    $t = json_decode($t_raw, true); // true перетворює у асоціативний масив
    
    // Перевірка на помилки JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Помилка JSON: " . json_last_error_msg();
        exit;
    }
    
    $count = count($t); // Кількість аргументів
} else {
    echo "Параметр t не встановлений.";
    exit;
}

// Можливі об'єкти та їх зображення
$names['shapes'] = ['circle', 'hexagon', 'octagon', 'parallelogram', 'pentagon', 'rectangle', 'rhombus', 'square', 'trapezoid', 'triangle'];

// Створення нового зображення залежно від кількості аргументів
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

$back = imagecreatetruecolor($width, $height); // Створення зображення

// Визначення кольорів
$light_gray = imagecolorallocate($back, 244, 247, 248);
$black = imagecolorallocate($back, 0, 0, 0);
$circle_color = imagecolorallocate($back, 229, 236, 240); // Колір для кругів та ліній

// Заливка фону світло-сірим кольором
imagefilledrectangle($back, 0, 0, $width, $height, $light_gray);

// Малювання подільних ліній
if ($width == 560 && $height == 560) {
    imageline($back, $width / 2, 0, $width / 2, $height, $circle_color); // Вертикальна лінія
    imageline($back, 0, $height / 2, $width, $height / 2, $circle_color); // Горизонтальна лінія
} elseif ($width == 560 && $height == 280) {
    imageline($back, $width / 2, 0, $width / 2, $height, $circle_color); // Вертикальна лінія для 560x280
}

// Шлях до шрифта для тексту
$font_file = '../../Inter.ttf';

// Додавання літер залежно від кількості аргументів
$font_size = 16;
if ($count >= 1) {
    // Літера A в лівому верхньому куті
    imagefilledellipse($back, 7 + 32 / 2, 7 + 32 / 2, 32, 32, $circle_color);
    imagettftext($back, $font_size, 0, 7 + 32 / 2 - 7, 7 + 32 / 2 + 7, $black, $font_file, "A");
}
if ($count >= 2) {
    // Літера B в правому верхньому куті
    imagefilledellipse($back, $width - 7 - 32 / 2, 7 + 32 / 2, 32, 32, $circle_color);
    imagettftext($back, $font_size, 0, $width - 7 - 32 / 2 - 7, 7 + 32 / 2 + 7, $black, $font_file, "B");
}
if ($count >= 3) {
    // Літера C в лівому нижньому куті
    imagefilledellipse($back, 7 + 32 / 2, $height - 7 - 32 / 2, 32, 32, $circle_color);
    imagettftext($back, $font_size, 0, 7 + 32 / 2 - 7, $height - 7 - 32 / 2 + 7, $black, $font_file, "C");
}
if ($count == 4) {
    // Літера D в правому нижньому куті
    imagefilledellipse($back, $width - 7 - 32 / 2, $height - 7 - 32 / 2, 32, 32, $circle_color);
    imagettftext($back, $font_size, 0, $width - 7 - 32 / 2 - 7, $height - 7 - 32 / 2 + 7, $black, $font_file, "D");
}

// Логіка для рендеру об'єктів у чвертях
$object_size = 160;
$shape_path = "../../images/flat160/shapes/";

for ($i = 0; $i < $count; $i++) {
    $shape_key = $t[$i]; // Отримуємо код форми
    $shape_name = '';

    // Пошук назви зображення за кодом
    switch ($shape_key) {
        case "s":
            $shape_name = "square";
            break;
        case "r":
            $shape_name = "rectangle";
            break;
        case "c":
            $shape_name = "circle";
            break;
        case "t":
            $shape_name = "triangle";
            break;
        case "p":
            $shape_name = "parallelogram";
            break;
        case "trp":
            $shape_name = "trapezoid";
            break;
        case "h":
            $shape_name = "hexagon";
            break;
        case "rh":
            $shape_name = "rhombus";
            break;
        case "pt":
            $shape_name = "pentagon";
            break;
        case "oct":
            $shape_name = "octagon";
            break;
        default:
            echo "Невідомий об'єкт: {$shape_key}";
            exit;
    }

    // Підготовка координат для рендерингу залежно від чверті
    switch ($count) {
        case 1: // Один аргумент - центрування в квадраті 280x280
            $x_pos = ($width - $object_size) / 2; // В центрі по X
            $y_pos = ($height - $object_size) / 2; // В центрі по Y
            break;
        case 2: // Два аргументи - центрування по горизонталі
            if ($i == 0) {
                $x_pos = ($width / 2 - $object_size) / 2; // Ліва половина
                $y_pos = ($height - $object_size) / 2; // Центр по Y
            } else {
                $x_pos = ($width / 2) + ($width / 2 - $object_size) / 2; // Права половина
                $y_pos = ($height - $object_size) / 2; // Центр по Y
            }
            break;
        case 3: // Три аргументи
            switch ($i) {
                case 0: // A
                    $x_pos = ($width / 2 - $object_size) / 2;
                    $y_pos = ($height / 2 - $object_size) / 2;
                    break;
                case 1: // B
                    $x_pos = ($width / 2) + ($width / 2 - $object_size) / 2;
                    $y_pos = ($height / 2 - $object_size) / 2;
                    break;
                case 2: // C
                    $x_pos = ($width / 2 - $object_size) / 2;
                    $y_pos = ($height / 2) + ($height / 2 - $object_size) / 2;
                    break;
            }
            break;
        case 4: // Чотири аргументи
            switch ($i) {
                case 0: // A
                    $x_pos = ($width / 2 - $object_size) / 2;
                    $y_pos = ($height / 2 - $object_size) / 2;
                    break;
                case 1: // B
                    $x_pos = ($width / 2) + ($width / 2 - $object_size) / 2;
                    $y_pos = ($height / 2 - $object_size) / 2;
                    break;
                case 2: // C
                    $x_pos = ($width / 2 - $object_size) / 2;
                    $y_pos = ($height / 2) + ($height / 2 - $object_size) / 2;
                    break;
                case 3: // D
                    $x_pos = ($width / 2) + ($width / 2 - $object_size) / 2;
                    $y_pos = ($height / 2) + ($height / 2 - $object_size) / 2;
                    break;
            }
            break;
    }

    // Завантаження зображення
    $shape_image = imagecreatefrompng($shape_path . $shape_name . ".png");
    
    // Вставка зображення на фон
    imagecopyresampled($back, $shape_image, $x_pos, $y_pos, 0, 0, $object_size, $object_size, imagesx($shape_image), imagesy($shape_image));
}

// Виведення зображення
imagepng($back);
imagedestroy($back);

?>
