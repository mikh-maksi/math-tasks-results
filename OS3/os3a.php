<?php

header("Content-type: image/png");

if (isset($_GET['t'])) {
    $t = $_GET['t'];
} else {
    $t = '[]';
}
$t = json_decode($_GET['t']);

// Створюємо зображення 624x688 (зовнішній прямокутник)
$outer_width = 624;
$outer_height = 688;
$outer_back = imagecreatetruecolor($outer_width, $outer_height);

// Заливаємо фон зовнішнього прямокутника білим кольором
$outer_background_color = imagecolorallocate($outer_back, 255, 255, 255);
imagefill($outer_back, 0, 0, $outer_background_color);

// Встановлюємо паддінг
$padding = 32;

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
$names['fruits'] = ['apple', 'apricot', 'banana', 'broccoli', 'carrot', 'grape', 'kiwi', 'lemon', 'orange', 'pear', 'strawberry', 'tomato'];
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
        $object_image_path = "../../images/flat48/" . $object_group . "/" . $object_name . ".png";
        if (file_exists($object_image_path)) {
            $object_image = imagecreatefrompng($object_image_path);

            for ($k = 0; $k < $value; $k++) {
                $j = $k % $col;
                $i = intdiv($k, $col);
                // Додаємо об'єкт на зображення з розміром 48x48
                imagecopyresampled($back, $object_image, $x_start + 24 + (48 + 8) * $j + 280 * $jj, $y_start + 24 + (48 + 8) * $i + 280 * $ii, 0, 0, 48, 48, 48, 48);
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

// Розміщуємо сірий квадрат всередині зовнішнього прямокутника з урахуванням паддінгів
$inner_x = ($outer_width - $inner_size) / 2; // Позиція по x для центрування
$inner_y = $padding; // Позиція по y з урахуванням паддінгу

// Копіюємо сірий квадрат на зовнішнє зображення
imagecopy($outer_back, $back, $inner_x, $inner_y, 0, 0, $inner_size, $inner_size);

// Додаємо чотири квадрати під сірим квадратом
$square_size = 48; // Розмір квадратів
$square_y_offset = $inner_y + $inner_size + 16; // Відступ вниз
$square_x_start = ($outer_width - (4 * $square_size + 3 * 16)) / 2; // Центрування квадратів

// Вибираємо випадкове число з аргументу
$chosen_value = $t[array_rand($t)][0];

// Генерація випадкових чисел для квадратів
$square_values = array_fill(0, 4, null); // Ініціалізуємо масив значень квадратів

// Отримання аргументів
$arguments = json_decode($_GET['t'], true); // Припускаємо, що 't' передається у форматі JSON
$correct_values = []; // Масив правильних значень

// Перевірка аргументів
foreach ($arguments as $arg) {
    if (isset($arg[0])) {
        $correct_values[] = $arg[0]; // Додаємо правильні значення в масив
    }
}

// Випадковий індекс для правильного значення
$correct_index = rand(0, 3); 
$square_values[$correct_index] = $correct_values[array_rand($correct_values)]; // Вибираємо випадкове правильне значення для одного квадрата

// Заповнюємо інші квадрати випадковими унікальними значеннями, які не є правильними
$used_values = [$square_values[$correct_index]]; // Масив, що містить вже використані значення

for ($i = 0; $i < 4; $i++) {
    if ($square_values[$i] === null) {
        do {
            $rand_value = rand(1, 20); // Генерація випадкового числа від 1 до 20
        } while (in_array($rand_value, $used_values) || in_array($rand_value, $correct_values)); // Перевірка на унікальність та невідповідність аргументам

        $square_values[$i] = $rand_value; // Додаємо тільки унікальні значення
        $used_values[] = $rand_value; // Додаємо значення до масиву використаних
    }
}

// Вказуємо файл шрифту
$font_file = '../../Inter.ttf'; // Шрифт для тексту
$font_size = 20; // Розмір шрифту

for ($i = 0; $i < 4; $i++) {
    $square_x = $square_x_start + ($square_size + 16) * $i; // Визначаємо позицію x для кожного квадрата

    // Заливаємо квадрат білим кольором
    $square_color = imagecolorallocate($outer_back, 255, 255, 255);
    imagefilledrectangle($outer_back, $square_x, $square_y_offset, $square_x + $square_size, $square_y_offset + $square_size, $square_color);

    // Малюємо сірий бордер
    imagerectangle($outer_back, $square_x, $square_y_offset, $square_x + $square_size, $square_y_offset + $square_size, $grey_line);

    // Центруємо текст у квадраті
    $text = (string)$square_values[$i]; // Текст квадрата

    // Розрахунок позиції для центрування тексту
    $bbox = imagettfbbox($font_size, 0, $font_file, $text); // Отримуємо межі тексту
    $text_x = $square_x + ($square_size - ($bbox[2] - $bbox[0])) / 2; // Центрування тексту по x
    $text_y = $square_y_offset + ($square_size + ($bbox[1] - $bbox[7])) / 2; // Центрування тексту по y

    // Малюємо текст з використанням TrueType шрифту
    imagettftext($outer_back, $font_size, 0, $text_x, $text_y, $black, $font_file, $text);
}



// Виводимо зображення
imagepng($outer_back);
imagedestroy($outer_back);
imagedestroy($back);

?>
