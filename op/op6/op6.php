<?php
header("Content-type: image/png");

$assets_path = "../../assets";

// Отримуємо параметри запиту 't'
if (isset($_GET['t'])) {
    $t = $_GET['t'];
} else {
    $t = '[]';
}
$t = json_decode($_GET['t']);

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
$plus_img = imagecreatefrompng($assets_path."/images/flat96/signs/plus_big.png");
$eq_img = imagecreatefrompng($assets_path."/images/flat96/signs/eq.png");
$word_img = imagecreatefrompng($assets_path."/images/flat96/signs/word.png");

// Шрифт для тексту
$font_file = $assets_path."/fonts/Inter.ttf";
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
$text_box = imagettfbbox($font_size, 0, $font_file, $t[0]);
$text_x = $first_square_x + ($square_size - ($text_box[2] - $text_box[0])) / 2;
$text_y = $center_y + ($square_size + ($text_box[1] - $text_box[7])) / 2;
imagettftext($back, $font_size, 0, (int)$text_x, (int)$text_y, $black, $font_file, $t[0]);

// Малюємо знак плюс
$plus_x = $first_square_x + $square_size + $gap;
list($plus_width, $plus_height) = resize_image_by_width($plus_img, 30);
$plus_y = ($height_first - $plus_height) / 2; // Центруємо по вертикалі
imagecopyresampled($back, $plus_img, $plus_x, $plus_y, 0, 0, $plus_width, $plus_height, imagesx($plus_img), imagesy($plus_img));

// Малюємо другий білий квадрат
$second_square_x = $plus_x + $plus_width + $gap;
draw_rounded_rectangle($back, $second_square_x, $center_y, $second_square_x + $square_size, $center_y + $square_size, $corner_radius, $white, $border_color, $border_thickness);

// Відображаємо другий аргумент в центрі другого квадрата
$text_box = imagettfbbox($font_size, 0, $font_file, $t[1]);
$text_x = $second_square_x + ($square_size - ($text_box[2] - $text_box[0])) / 2;
$text_y = $center_y + ($square_size + ($text_box[1] - $text_box[7])) / 2;
imagettftext($back, $font_size, 0, (int)$text_x, (int)$text_y, $black, $font_file, $t[1]);

// Малюємо знак дорівнює
$eq_x = $second_square_x + $square_size + $gap;
list($eq_width, $eq_height) = resize_image_by_width($eq_img, 30);
$eq_y = ($height_first - $eq_height) / 2; // Центруємо по вертикалі
imagecopyresampled($back, $eq_img, (int)$eq_x, (int)$eq_y, 0, 0, (int)$eq_width, (int)$eq_height, imagesx($eq_img), imagesy($eq_img));

// Малюємо третій білий квадрат
$third_square_x = $eq_x + $eq_width + $gap;
draw_rounded_rectangle($back, $third_square_x, $center_y, $third_square_x + $square_size, $center_y + $square_size, $corner_radius, $white, $border_color, $border_thickness);

// Відображаємо малюнок у третьому квадраті
$word_x = $third_square_x + ($square_size - 48) / 2;
$word_y = 96;
imagecopyresampled($back, $word_img, $word_x, $word_y, 0, 0, 45, 4, 45, 4);



// Виводимо зображення
imagepng($back);
imagedestroy($back);
?>
