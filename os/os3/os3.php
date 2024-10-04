<?php
$assets_path = "../../assets";


header("Content-type: image/png");

if (isset($_GET['t'])) {
    $t = $_GET['t'];
} else {
    $t = '[]';
}
$t = json_decode($_GET['t']);

// Створюємо зображення 560x560 (сірий квадрат)
$inner_size = 560;
$back = imagecreatetruecolor($inner_size, $inner_size);

// Заливаємо фон сірого квадрата кольором #F4F7F8 (RGB: 244, 247, 248)
$background_color = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $background_color);

// Кольори
$black = imagecolorallocate($back, 0, 0, 0);
$grey_line = imagecolorallocate($back, 229, 236, 240);

// Лінії, які ділять зображення навпіл по горизонталі та вертикалі
imageline($back, 280, 0, 280, 560, $grey_line); // вертикальна лінія
imageline($back, 0, 280, 560, 280, $grey_line); // горизонтальна лінія

// Додаємо бордер (сірий) навколо сірого квадрата
imagerectangle($back, 0, 0, $inner_size - 1, $inner_size - 1, $grey_line);

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
            return $group; // Повертаємо назву групи, якщо об'єкт знайдено
        }
    }
    return null; // Повертаємо null, якщо об'єкт не знайдено
}

// Стартові координати і налаштування
$x_start = 10;
$y_start = 5;
$col = 4;

// Додавання об'єктів на сірий квадрат
for ($m = 0; $m < count($t); $m++) {
    $jj = $m % 2;
    $ii = intdiv($m, 2);
    $value = $t[$m][0];
    $object_name = $t[$m][1];
    
    // Знайдемо групу для переданого об'єкта
    $object_group = find_object_group($object_name, $names);

    if ($object_group !== null) {
        // Якщо групу знайдено, формуємо шлях до зображення
        $object_image_path = $assets_path ."/images/flat96/" . $object_group . "/" . $object_name . ".png";
        if (file_exists($object_image_path)) {
            $object_image = imagecreatefrompng($object_image_path);

            for ($k = 0; $k < $value; $k++) {
                $j = $k % $col;
                $i = intdiv($k, $col);
                // Додаємо об'єкт на зображення з розміром 48x48
                imagecopyresampled($back, $object_image, $x_start + 24 + (48 + 8) * $j + 280 * $jj, $y_start + 24 + (48 + 8) * $i + 280 * $ii, 0, 0, 48, 48, 96, 96);
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

// Виводимо зображення
imagepng($back);
imagedestroy($back);

?>
