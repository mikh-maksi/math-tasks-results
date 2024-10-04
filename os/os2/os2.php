<?php
$assets_path = "../../assets";

header("Content-type: image/png");

if (isset($_GET['t'])) {
    $t = $_GET['t'];
} else {
    $t = '[]';
}
$t = json_decode($_GET['t']);

// Можливі групи об'єктів і їх значення
$names = [];
$names['activities'] = ['football', 'going-to-school', 'walking-with-dog'];
$names['animals'] = ['bird', 'cat', 'dino', 'dog', 'duck', 'fish'];
$names['balls'] = ['ball-blue', 'ball-green', 'ball-red', 'ball-yellow'];
$names['fruits-vegetables'] = ['apple', 'apricot', 'banana', 'broccoli', 'carrot', 'grape', 'kiwi', 'lemon', 'orange', 'pear', 'strawberry', 'tomato'];
$names['items'] = ['ball-beach', 'baloon', 'block', 'book', 'box', 'clay', 'dumbell', 'feather', 'flat', 'flower', 'house', 'mountain', 'paper', 'pencil', 'rubber', 'ruler', 'smartphone', 'star', 'string'];
$names['sweets'] = ['cake', 'candy', 'cookie'];
$names['vehicles'] = ['car-front', 'racing-car-blue', 'racing-car-green', 'racing-car-purple', 'racing-car-red', 'racing-car-yellow', 'simple-car-blue', 'simple-car-green', 'simple-car-purple', 'simple-car-red', 'simple-car-yellow'];
$names['shapes'] = ['circle', 'hexagon', 'octagon', 'parallelogram', 'pentagon', 'rectangle', 'rhombus', 'square', 'trapezoid', 'triangle'];

// Функція для пошуку групи по об'єкту
function find_object_group($obj, $names) {
    foreach ($names as $group => $objects) {
        if (in_array($obj, $objects)) {
            return $group; // Повертаємо назву групи, якщо об'єкт знайдений
        }
    }
    return null; // Повертаємо null, якщо об'єкт не знайдено
}

// Створення нового зображення
$width = 560; // Ширина зображення
$height = 280; // Висота зображення
$back = imagecreatetruecolor($width, $height); // Створення нового зображення

// Визначення кольорів
$light_gray = imagecolorallocate($back, 244, 247, 248);
$black = imagecolorallocate($back, 0, 0, 0);
$circle_color = imagecolorallocate($back, 229, 236, 240); // Колір #E5ECF0
$font_file = $assets_path.'/fonts/Inter.ttf'; // Шрифт для тексту

// Заливка фону світло-сірим кольором
imagefilledrectangle($back, 0, 0, $width, $height, $light_gray);
imageline($back, $width / 2, 0, $width / 2, $height, $circle_color);
$x_start = 40;
$y_start = 40;

$col = 4; // Кількість колонок

// Додавання об'єктів на зображення
for ($m = 0; $m < count($t); $m++) {
    $jj = $m % 2;
    $ii = intdiv($m, 2);
    $value = $t[$m][0];
    $object_name = $t[$m][1];
    
    // Знайдемо групу для переданого об'єкта
    $object_group = find_object_group($object_name, $names);

    if ($object_group !== null) {
        // Якщо групу знайдено, формуємо шлях до зображення
        $object_image_path = $assets_path."/images/flat96/" . $object_group . "/" . $object_name . ".png";
        if (file_exists($object_image_path)) {
            
            $object_image = imagecreatefrompng($object_image_path);

            for ($k = 0; $k < $value; $k++) {
                $j = $k % $col;
                $i = intdiv($k, $col);
                // Змінено розмір об'єкта на 44x44
                imagecopyresampled($back, $object_image, $x_start + (48 + 8) * $j + 280 * $jj, $y_start + (48 + 8) * $i + 280 * $ii, 0, 0, 48, 48, 96, 96);
            }
        } else {
            echo "Помилка: Зображення для об'єкта '{$object_name}' не знайдено.";
            exit;
        }
    } else {
        echo "Помилка: Об'єкт '{$object_name}' не знайдено в жодній групі.";
        exit;
    }
}

// Додавання кола з літерою А в лівому верхньому куті
$circle_radius = 32;
$circle_x = 7 + $circle_radius / 2; // Відступ 7 пікселів зліва
$circle_y = 7 + $circle_radius / 2; // Відступ 7 пікселів зверху

// Малювання кола
imagefilledellipse($back, $circle_x, $circle_y, $circle_radius, $circle_radius, $circle_color);

// Відображення літери А
$font_size = 16;
$text_A = "A";
imagettftext($back, $font_size, 0, $circle_x - 7, $circle_y + 7, $black, $font_file, $text_A);

// Додавання кола з літерою В у правому верхньому куті
$circle_x_right = $width - 7 - $circle_radius / 2; // Відступ 7 пікселів справа
$circle_y_right = 7 + $circle_radius / 2; // Відступ 7 пікселів зверху

// Малювання кола
imagefilledellipse($back, $circle_x_right, $circle_y_right, $circle_radius, $circle_radius, $circle_color);

// Відображення літери В
$text_B = "B";
imagettftext($back, $font_size, 0, $circle_x_right - 7, $circle_y_right + 7, $black, $font_file, $text_B);

// Виведення зображення
imagepng($back);
imagedestroy($back);

?>
