<?php


declare(strict_types = 1);

include '../config.php';

$assets_path = getAssetsPath();
$names = getNames();




// Отримуємо параметри запиту 't'
if (isset($_GET['t'])) {
    $t = urldecode($_GET['t']); // Декодуємо URL
    $t = json_decode($t, true); // Декодуємо JSON у асоціативний масив
} else {
    $t = []; // Якщо параметри не передані, створюємо порожній масив
}

// Перевіряємо, щоб аргументи були в межах від 0 до 10
foreach ($t as $value) {
    if ($value < 0) {
        $value = 0;
    } elseif ($value > 10) {
        $value = 10;
    }
}

// Розміри зображення
$width = 560;
$height = 240;
$height_first = 160;


// Створюємо зображення
$back = imagecreatetruecolor($width, $height);

// Колір фону (сірий)
$gray = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $gray);

// Чорний колір для тексту та елементів
$black = imagecolorallocate($back, 0, 0, 0);

// Білий колір для квадратів
$white = imagecolorallocate($back, 255, 255, 255);

// Колір бордера (RGB)
$border_color = imagecolorallocate($back, 229, 236, 240);

// Параметри елементів
$square_size = 96; // Розмір квадрата
$border_thickness = 2; // Товщина бордера
$corner_radius = 8; // Заокруглені кути
$gap = 16; // Відстань між елементами

// Параметри зображень
$sign_img = isset($t[2]) ? ($t[2] == 'plus' ? imagecreatefrompng($assets_path.'images/flat96/signs/plus.png') : ($t[2] == 'minus' ? imagecreatefrompng($assets_path.'images/flat96/signs/minus.png') : imagecreatefrompng($assets_path.'images/flat96/signs/plus.png'))) : imagecreatefrompng($assets_path.'images/flat96/signs/plus.png');

$eq_img = imagecreatefrompng($assets_path."images/flat96/signs/equal.png");
$word_img = imagecreatefrompng($assets_path."images/flat96/signs/word.png");

// Шрифт для тексту
$font_file = $assets_path."/Inter.ttf";
$font_size = 30;

// Функція для збереження пропорцій зображення при зміні ширини
function resize_image_by_width($image, $new_width) {
    $orig_width = imagesx($image);
    $orig_height = imagesy($image);
    $new_height = ($orig_height / $orig_width) * $new_width;
    return [$new_width, $new_height];
}

// Визначаємо початкові координати для центрування
$element_total_width = 3 * ($square_size + $gap) + 33 + $gap + 33; // ширина всіх елементів + проміжки
$start_x = ($width - $element_total_width) / 2;
$center_y = ($height_first - $square_size) / 2;

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

// Малюємо перший білий квадрат
$first_square_x = $start_x;
draw_rounded_rectangle($back, $first_square_x, $center_y, $first_square_x + $square_size, $center_y + $square_size, $corner_radius, $white, $border_color, $border_thickness);

// Відображаємо перший аргумент в центрі першого квадрата
$word_x = $first_square_x + ($square_size - 48) / 2;
$word_y = 96;
imagecopyresampled($back, $word_img, $word_x, $word_y, 0, 0, 45, 4, 45, 4);



// Малюємо знак плюс
$plus_x = $first_square_x + $square_size + $gap;
list($plus_width, $plus_height) = resize_image_by_width($sign_img, 30);
$plus_y = ($height_first - $plus_height) / 2; // Центруємо по вертикалі
imagecopyresampled($back, $sign_img, (int)($plus_x), (int)($plus_y), 0, 0, (int)($plus_width), (int)($plus_height), imagesx($sign_img), imagesy($sign_img));

// Малюємо другий білий квадрат
$second_square_x = $plus_x + $plus_width + $gap;
draw_rounded_rectangle($back, $second_square_x, $center_y, $second_square_x + $square_size, $center_y + $square_size, $corner_radius, $white, $border_color, $border_thickness);

// Відображаємо другий аргумент в центрі другого квадрата
$text_box = imagettfbbox($font_size, 0, $font_file, (string)$t[0]);
$text_x = $second_square_x + ($square_size - ($text_box[2] - $text_box[0])) / 2;
$text_y = $center_y + ($square_size + ($text_box[1] - $text_box[7])) / 2;
imagettftext($back, $font_size, 0, (int)$text_x, (int)$text_y, $black, $font_file, (string)$t[0]);

// Малюємо знак дорівнює
$eq_x = $second_square_x + $square_size + $gap;
list($eq_width, $eq_height) = resize_image_by_width($eq_img, 30);
$eq_y = ($height_first - $eq_height) / 2; // Центруємо по вертикалі
imagecopyresampled($back, $eq_img, (int)$eq_x, (int)$eq_y, 0, 0, (int)$eq_width, (int)$eq_height, imagesx($eq_img), imagesy($eq_img));

// Малюємо третій білий квадрат
$third_square_x = $eq_x + $eq_width + $gap;
draw_rounded_rectangle($back, $third_square_x, $center_y, $third_square_x + $square_size, $center_y + $square_size, $corner_radius, $white, $border_color, $border_thickness);

// Відображаємо малюнок у третьому квадраті
$text_box = imagettfbbox($font_size, 0, $font_file,  (string)$t[1]);
$text_x = $third_square_x + ($square_size - ($text_box[2] - $text_box[0])) / 2;
$text_y = $center_y + ($square_size + ($text_box[1] - $text_box[7])) / 2;
imagettftext($back, $font_size, 0, (int)$text_x, (int)$text_y, $black, $font_file,  (string)$t[1]);



// Відступ вниз на 16
$y_offset = 16;

// Малюємо перший прямокутник з сіткою
$rect_width = 160;
$rect_height = 64;
$rect_x = 0;
$rect_y = $word_y + $y_offset + 35;

draw_rounded_rectangle($back, $rect_x, $rect_y, $rect_x + $rect_width, $rect_y + $rect_height, 0, $white, $border_color, 1);

// Малюємо сітку та кружки
// Малюємо сітку з 5 колонок і 2 рядків та кружки
$grid_cols = 5; // Кількість колонок
$grid_rows = 2; // Кількість рядків
$total_slots = $grid_cols * $grid_rows; // Загальна кількість комірок

$slot_width = $rect_width / $grid_cols; // Ширина однієї комірки
$slot_height = $rect_height / $grid_rows; // Висота однієї комірки

function find_object_group($obj, $names) {
    foreach ($names as $group => $objects) {
        if (in_array($obj, $objects)) {
            return $group; // Повертаємо назву групи, якщо об'єкт знайдений
        }
    }
    return null; // Повертаємо null, якщо об'єкт не знайдено
}
// Функція для завантаження зображення
function load_item_image($image_name) {
    global $assets_path;
    global $names;
    $object_group = find_object_group($image_name, $names);

    $image_path = $assets_path."/images/flat96/{$object_group}/{$image_name}.png"; // Шлях до зображення
    if (file_exists($image_path)) {
        return imagecreatefrompng($image_path); // Завантажуємо зображення
    } else {
        // Якщо зображення не знайдено, завантажуємо дефолтне зображення 'circle.png'
        $default_image_path = $assets_path."/images/flat96/shapes-filled/circle.png";
        if (file_exists($default_image_path)) {
            return imagecreatefrompng($default_image_path);
        } else {
            die("Зображення не знайдено: {$image_name}");
        }
    }
}
$image_name_1 = isset($t[3]) ? $t[3] : 'circle';
// Завантажуємо зображення для кожного аргументу
$circle_img = load_item_image($image_name_1);
$circle_size = 16; // Розмір круга


// Позиції сітки починаються з 0
$rect_x = 0;
$rect_y = $word_y + 4 + $y_offset + 32;

for ($row = 0; $row < $grid_rows; $row++) {
    for ($col = 0; $col < $grid_cols; $col++) {
        $slot_x = $rect_x + $col * $slot_width; // Починаємо з X = 0
        $slot_y = $rect_y + $row * $slot_height; // Починаємо з Y = 0
        
        // Малюємо бордер для кожної комірки
        imagerectangle($back, $slot_x, $slot_y, $slot_x + $slot_width, $slot_y + $slot_height, $border_color);


    }
}



// Відступ 12 і малювання зображення плюс
// Відступ 12 і малювання зображення плюс
$plus_x = $rect_x + $rect_width + 12; // розташовуємо знак плюс праворуч від першого прямокутника
imagecopyresampled($back, $sign_img, $plus_x, $rect_y + 5, 0, 0, 17, 48, imagesx($sign_img), imagesy($sign_img));


// Малюємо другий прямокутник з сіткою з 5 колонок і 2 рядків
// Малюємо другий прямокутник з сіткою
$rect_x = $plus_x + 17 + 12; // розташовуємо праворуч від знаку плюс з додатковим відступом
draw_rounded_rectangle($back, $rect_x, $rect_y, $rect_x + $rect_width, $rect_y + $rect_height, 0, $white, $border_color, 1);

$grid_cols = 5; // 5 колонок
$grid_rows = 2; // 2 рядки
$slot_width = $rect_width / $grid_cols;
$slot_height = $rect_height / $grid_rows;

$circle_count = $t[0]; // Кількість кіл дорівнює другому аргументу

for ($row = 0; $row < $grid_rows; $row++) {
    for ($col = 0; $col < $grid_cols; $col++) {
        $slot_x = $rect_x + $col * $slot_width;
        $slot_y = $rect_y + $row * $slot_height;
        
        // Малюємо прямокутник (комірку сітки)
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

// Відступ 12 і малювання зображення дорівнює
$eq_x = $rect_x + $rect_width + 12;
$eq_y = $rect_y;
imagecopyresampled($back, $eq_img, $eq_x, $eq_y + 5, 0, 0, 17, 48, imagesx($eq_img), imagesy($eq_img));
// Малюємо зображення дорівнює


// Малюємо пустий прямокутник з сіткою з 5 колонок і 2 рядків
$rect_x = $eq_x + 17 + 12;
$rect_y = $eq_y;

draw_rounded_rectangle($back, $rect_x, $rect_y, $rect_x + $rect_width, $rect_y + $rect_height, 0, $white, $border_color, 1);
$circle_count = $t[1];
for ($row = 0; $row < $grid_rows; $row++) {
    for ($col = 0; $col < $grid_cols; $col++) {
        $slot_x = $rect_x + $col * $slot_width;
        $slot_y = $rect_y + $row * $slot_height;

        // Малюємо сітку
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
