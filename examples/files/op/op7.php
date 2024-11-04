<?php


declare(strict_types = 1);

include '../config.php';

$assets_path = getAssetsPath();

// Отримуємо параметри запиту 't'
if (isset($_GET['t'])) {
    $t = json_decode($_GET['t']);
} else {
    $t = [];
}

// Перевіряємо третій аргумент - "plus" або "minus"
$third_arg = isset($t[2]) ? $t[2] : 'plus';  // Якщо аргумент не заданий, за замовчуванням використовуємо "plus"

if ($third_arg === "minus") {
   
   // Перевіряємо, щоб перший аргумент був в межах від 1 до 5
if (isset($t[0])) {
    if ($t[0] < 1) {
        $t[0] = 1;
    } elseif ($t[0] > 5) {
        $t[0] = 5;
    }
}

// Обмежуємо другий аргумент
// Обмежуємо другий аргумент
if (isset($t[1])) {
    // Максимальне значення для другого аргументу
    $max_value_for_second_arg = $t[0]; // Можемо віднімати до t[0], включно, щоб отримати 0
    if ($t[1] < 0) {
        $t[1] = 0;
    } elseif ($t[1] > $max_value_for_second_arg) {
        $t[1] = $max_value_for_second_arg;
    }
}

// Розміри зображення
$width = 560;
$height = 280;

$back = imagecreatetruecolor($width, $height);

$gray = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $gray);

$black = imagecolorallocate($back, 0, 0, 0);
$white = imagecolorallocate($back, 255, 255, 255);
$divide_line_color = imagecolorallocate($back, 161, 175, 185);

$border_color = imagecolorallocate($back, 229, 236, 240);
$dot_color = imagecolorallocate($back, 55, 163, 238);

$minus_img = imagecreatefrompng($assets_path . "images/flat96/signs/minus.png");

// Отримуємо розміри зображення "плюса"
$minus_img_width = imagesx($minus_img);
$minus_img_height = imagesy($minus_img);

// Змінюємо розмір шрифту
$font_file = $assets_path . "Inter.ttf";
$font_size = 28;

// Повертаємо товщину ліній до 1 для відділяючої лінії
imagesetthickness($back, 1);

// Відділяюча лінія між половинами (залишаємо товщину 1)
imageline($back, 280, 0, 280, 280, $border_color); 

// Встановлюємо товщину ліній для розгалужень
imagesetthickness($back, 3);

// Центр лівої половини
$left_center_x = 140;
$left_center_y = 140;

// Ліве розгалуження
imageline($back, $left_center_x - 49, $left_center_y + 16, $left_center_x, $left_center_y - 16, $divide_line_color); 
imageline($back, $left_center_x, $left_center_y - 16, $left_center_x + 49, $left_center_y + 16, $divide_line_color); 

// Центр правої половини
$right_center_x = 420;
$right_center_y = 140;

// Праве розгалуження
imageline($back, $right_center_x - 49, $right_center_y + 16, $right_center_x, $right_center_y - 16, $divide_line_color); 
imageline($back, $right_center_x, $right_center_y - 16, $right_center_x + 49, $right_center_y + 16, $divide_line_color);

// Відступи та розмір кіл
$circle_diameter = 64;
$circle_radius = $circle_diameter / 2;
$circle_offset = 8;

// Функція для малювання кола
function drawCircle($image, $x, $y, $diameter, $border_color, $fill_color, $thickness) {
    imagesetthickness($image, $thickness);
    imagearc($image, $x, $y, $diameter, $diameter, 0, 360, $border_color);
    imagefilledellipse($image, $x, $y, $diameter - $thickness, $diameter - $thickness, $fill_color);
}

function drawSquareWithDots($image, $x, $y, $numDots, $dotColor, $borderColor) {
    $squareSize = 36;
    $dotSize = 12;
    $padding = 8;

    // Малюємо квадрат
    imagerectangle($image, $x, $y, $x + $squareSize, $y + $squareSize, $borderColor);

    // Визначаємо позиції кіл
    switch ($numDots) {
        case 1:
            $dotX = $x + ($squareSize - $dotSize) / 2;
            $dotY = $y + ($squareSize - $dotSize) / 2;
            drawCircle($image, $dotX + $dotSize / 2, $dotY + $dotSize / 2, $dotSize, $borderColor, $dotColor, 2);
            break;
       case 2:
            for ($i = 0; $i < 2; $i++) {
                $dotX = $x + ($squareSize - 2 * $dotSize - $padding) / 2 + $i * ($dotSize + $padding);
                $dotY = $y + ($squareSize - $dotSize) / 2;
                drawCircle($image, $dotX + $dotSize / 2, $dotY + $dotSize / 2, $dotSize, $borderColor, $dotColor, 2);
            }
            break;
        case 3:
            for ($i = 0; $i < 3; $i++) {
        $dotX = $x + $i * ($squareSize - $dotSize) / 2; // Перший круг має координату X рівну 0
        $dotY = $y + ($squareSize / 3) - ($dotSize / 2); // Підняття групи на 1/3 квадрата

        // Опускаємо середній круг на 15 вниз
        if ($i === 1) {
            $dotY += 15;
        }

        drawCircle($image, $dotX + $dotSize / 2, $dotY + $dotSize / 2, $dotSize, $borderColor, $dotColor, 2);
    }
    break;
        case 4:
            for ($i = 0; $i < 2; $i++) {
                for ($j = 0; $j < 2; $j++) {
                    $dotX = $x + ($squareSize - 2 * $dotSize - $padding) / 2 + $j * ($dotSize + $padding);
                    $dotY = $y + ($squareSize - 2 * $dotSize - $padding) / 2 + $i * ($dotSize + $padding);
                    drawCircle($image, $dotX + $dotSize / 2, $dotY + $dotSize / 2, $dotSize, $borderColor, $dotColor, 2);
                }
            }
            break;
        case 5:
            for ($i = 0; $i < 5; $i++) {
        if ($i < 4) { // Перші 4 круга по кутах
            $dotX = $x + ($i % 2) * ($squareSize - $dotSize); // Лівий/правий кут
            $dotY = $y + floor($i / 2) * ($squareSize - $dotSize); // Верхній/нижній кут
        } else { // 5-й круг у центрі
            $dotX = $x + ($squareSize - $dotSize) / 2;
            $dotY = $y + ($squareSize - $dotSize) / 2;
        }

        drawCircle($image, $dotX + $dotSize / 2, $dotY + $dotSize / 2, $dotSize, $borderColor, $dotColor, 2);
    }
    break;
    }
}



// Малюємо кола в лівій частині
drawCircle($back, $left_center_x - 49, $left_center_y + 16 + $circle_radius + $circle_offset, $circle_diameter, $border_color, $white, 2);
drawCircle($back, $left_center_x, $left_center_y - 16 - $circle_radius - $circle_offset, $circle_diameter, $border_color, $white, 2);
drawCircle($back, $left_center_x + 49, $left_center_y + 16 + $circle_radius + $circle_offset, $circle_diameter, $border_color, $white, 2);

// Малюємо кола в правій частині
drawCircle($back, $right_center_x - 49, $right_center_y + 16 + $circle_radius + $circle_offset, $circle_diameter, $border_color, $white, 2);
// imagettftext($back, $font_size, 0, $right_center_x - 60, $right_center_y + 70, $black, $font_file, $t[0]);
imagettftext($back, $font_size, 0, $right_center_x - 60, $right_center_y + 70, $black, $font_file, strval($t[0]));

drawCircle($back, $right_center_x, $right_center_y - 16 - $circle_radius - $circle_offset, $circle_diameter, $border_color, $white, 2);
// imagettftext($back, $font_size, 0, $right_center_x - 10, $right_center_y - 40, $black, $font_file, $t[0] - $t[1]);
imagettftext($back, $font_size, 0, $right_center_x - 10, $right_center_y - 40, $black, $font_file, strval($t[0] - $t[1]));

drawCircle($back, $right_center_x + 49, $right_center_y + 16 + $circle_radius + $circle_offset, $circle_diameter, $border_color, $white, 2);
imagettftext($back, $font_size, 0, $right_center_x + 38, $right_center_y + 70, $black, $font_file, strval($t[1]));

drawSquareWithDots($back, 73, 178, $t[0], $dot_color, $white);
drawSquareWithDots($back, 171, 178, $t[1], $dot_color, $white);
drawSquareWithDots($back, 122, 65, $t[0] - $t[1], $dot_color, $white);

// Визначаємо координати для розміщення двох $minus_img
$left_lower_circle_x1 = $left_center_x - 49;
$left_lower_circle_x2 = $left_center_x + 49;
$left_mid_x = ($left_lower_circle_x1 + $left_lower_circle_x2) / 2;
$left_mid_y = $left_center_y + 16 + $circle_radius + $circle_offset;

$right_lower_circle_x1 = $right_center_x - 49;
$right_lower_circle_x2 = $right_center_x + 49;
$right_mid_x = ($right_lower_circle_x1 + $right_lower_circle_x2) / 2;
$right_mid_y = $right_center_y + 16 + $circle_radius + $circle_offset;

// Вираховуємо позиції для малювання $minus_img
$minus_img_left_x = $left_mid_x - $minus_img_width / 2;
$minus_img_left_y = $left_mid_y - $minus_img_height / 2;

$minus_img_right_x = $right_mid_x - $minus_img_width / 2;
$minus_img_right_y = $right_mid_y - $minus_img_height / 2;

// Малюємо перший "плюс" у лівій частині
imagecopy($back, $minus_img, $minus_img_left_x, $minus_img_left_y, 0, 0, $minus_img_width, $minus_img_height);

// Малюємо другий "плюс" у правій частині
imagecopy($back, $minus_img, $minus_img_right_x, $minus_img_right_y, 0, 0, $minus_img_width, $minus_img_height);

} else {
// Перевіряємо, щоб аргументи були в межах від 0 до 5
if (isset($t[0]) && $t[0] < 0) {
    $t[0] = 0;
} elseif (isset($t[0]) && $t[0] > 5) {
    $t[0] = 5;
}


// Обмежуємо другий аргумент
if (isset($t[1])) {
    // Максимальне значення для другого аргументу
    $max_value_for_second_arg = 5 - $t[0];
    
    if ($t[1] < 0) {
        $t[1] = 0;
    } elseif ($t[1] > $max_value_for_second_arg) {
        $t[1] = $max_value_for_second_arg;
    }
}

// Розміри зображення
$width = 560;
$height = 280;

$back = imagecreatetruecolor($width, $height);

$gray = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $gray);

$black = imagecolorallocate($back, 0, 0, 0);
$white = imagecolorallocate($back, 255, 255, 255);
$divide_line_color = imagecolorallocate($back, 161, 175, 185);

$border_color = imagecolorallocate($back, 229, 236, 240);
$dot_color = imagecolorallocate($back, 55, 163, 238);

$plus_img = imagecreatefrompng($assets_path . "images/flat96/signs/plus.png");

// Отримуємо розміри зображення "плюса"
$plus_img_width = imagesx($plus_img);
$plus_img_height = imagesy($plus_img);

// Змінюємо розмір шрифту
$font_file = $assets_path . "Inter.ttf";
$font_size = 28;

// Повертаємо товщину ліній до 1 для відділяючої лінії
imagesetthickness($back, 1);

// Відділяюча лінія між половинами (залишаємо товщину 1)
imageline($back, 280, 0, 280, 280, $border_color); 

// Встановлюємо товщину ліній для розгалужень
imagesetthickness($back, 3);

// Центр лівої половини
$left_center_x = 140;
$left_center_y = 140;

// Ліве розгалуження
imageline($back, $left_center_x - 49, $left_center_y + 16, $left_center_x, $left_center_y - 16, $divide_line_color); 
imageline($back, $left_center_x, $left_center_y - 16, $left_center_x + 49, $left_center_y + 16, $divide_line_color); 

// Центр правої половини
$right_center_x = 420;
$right_center_y = 140;

// Праве розгалуження
imageline($back, $right_center_x - 49, $right_center_y + 16, $right_center_x, $right_center_y - 16, $divide_line_color); 
imageline($back, $right_center_x, $right_center_y - 16, $right_center_x + 49, $right_center_y + 16, $divide_line_color);

// Відступи та розмір кіл
$circle_diameter = 64;
$circle_radius = $circle_diameter / 2;
$circle_offset = 8;

// Функція для малювання кола
function drawCircle($image, $x, $y, $diameter, $border_color, $fill_color, $thickness) {
    imagesetthickness($image, $thickness);
    imagearc($image, (int)($x), (int)($y), (int)($diameter), (int)($diameter), 0, 360, $border_color);
    imagefilledellipse($image, (int)($x), (int)($y), $diameter - $thickness, $diameter - $thickness, $fill_color);
}

function drawSquareWithDots($image, $x, $y, $numDots, $dotColor, $borderColor) {
    $squareSize = 36;
    $dotSize = 12;
    $padding = 8;

    // Малюємо квадрат
    imagerectangle($image, $x, $y, $x + $squareSize, $y + $squareSize, $borderColor);

    // Визначаємо позиції кіл
    switch ($numDots) {
        case 1:
            $dotX = $x + ($squareSize - $dotSize) / 2;
            $dotY = $y + ($squareSize - $dotSize) / 2;
            drawCircle($image, $dotX + $dotSize / 2, $dotY + $dotSize / 2, $dotSize, $borderColor, $dotColor, 2);
            break;
       case 2:
            for ($i = 0; $i < 2; $i++) {
                $dotX = $x + ($squareSize - 2 * $dotSize - $padding) / 2 + $i * ($dotSize + $padding);
                $dotY = $y + ($squareSize - $dotSize) / 2;
                drawCircle($image, $dotX + $dotSize / 2, $dotY + $dotSize / 2, $dotSize, $borderColor, $dotColor, 2);
            }
            break;
        case 3:
            for ($i = 0; $i < 3; $i++) {
        $dotX = $x + $i * ($squareSize - $dotSize) / 2; // Перший круг має координату X рівну 0
        $dotY = $y + ($squareSize / 3) - ($dotSize / 2); // Підняття групи на 1/3 квадрата

        // Опускаємо середній круг на 15 вниз
        if ($i === 1) {
            $dotY += 15;
        }

        drawCircle($image, $dotX + $dotSize / 2, $dotY + $dotSize / 2, $dotSize, $borderColor, $dotColor, 2);
    }
    break;
        case 4:
            for ($i = 0; $i < 2; $i++) {
                for ($j = 0; $j < 2; $j++) {
                    $dotX = $x + ($squareSize - 2 * $dotSize - $padding) / 2 + $j * ($dotSize + $padding);
                    $dotY = $y + ($squareSize - 2 * $dotSize - $padding) / 2 + $i * ($dotSize + $padding);
                    drawCircle($image, $dotX + $dotSize / 2, $dotY + $dotSize / 2, $dotSize, $borderColor, $dotColor, 2);
                }
            }
            break;
        case 5:
            for ($i = 0; $i < 5; $i++) {
        if ($i < 4) { // Перші 4 круга по кутах
            $dotX = $x + ($i % 2) * ($squareSize - $dotSize); // Лівий/правий кут
            $dotY = $y + floor($i / 2) * ($squareSize - $dotSize); // Верхній/нижній кут
        } else { // 5-й круг у центрі
            $dotX = $x + ($squareSize - $dotSize) / 2;
            $dotY = $y + ($squareSize - $dotSize) / 2;
        }

        drawCircle($image, $dotX + $dotSize / 2, $dotY + $dotSize / 2, $dotSize, $borderColor, $dotColor, 2);
    }
    break;
    }
}



// Малюємо кола в лівій частині
drawCircle($back, $left_center_x - 49, $left_center_y + 16 + $circle_radius + $circle_offset, $circle_diameter, $border_color, $white, 2);
drawCircle($back, $left_center_x, $left_center_y - 16 - $circle_radius - $circle_offset, $circle_diameter, $border_color, $white, 2);
drawCircle($back, $left_center_x + 49, $left_center_y + 16 + $circle_radius + $circle_offset, $circle_diameter, $border_color, $white, 2);

// Малюємо кола в правій частині
drawCircle($back, $right_center_x - 49, $right_center_y + 16 + $circle_radius + $circle_offset, $circle_diameter, $border_color, $white, 2);
imagettftext($back, $font_size, 0, $right_center_x - 60, $right_center_y + 70, $black, $font_file, strval($t[0]));
drawCircle($back, $right_center_x, $right_center_y - 16 - $circle_radius - $circle_offset, $circle_diameter, $border_color, $white, 2);
imagettftext($back, $font_size, 0, $right_center_x - 12, $right_center_y - 40, $black, $font_file, strval($t[0] + $t[1]));
drawCircle($back, $right_center_x + 49, $right_center_y + 16 + $circle_radius + $circle_offset, $circle_diameter, $border_color, $white, 2);
imagettftext($back, $font_size, 0, $right_center_x + 38, $right_center_y + 70, $black, $font_file, strval($t[1]));

drawSquareWithDots($back, 73, 178, $t[0], $dot_color, $white);
drawSquareWithDots($back, 171, 178, $t[1], $dot_color, $white);
drawSquareWithDots($back, 122, 65, $t[0] + $t[1], $dot_color, $white);

// Визначаємо координати для розміщення двох $plus_img
$left_lower_circle_x1 = $left_center_x - 49;
$left_lower_circle_x2 = $left_center_x + 49;
$left_mid_x = ($left_lower_circle_x1 + $left_lower_circle_x2) / 2;
$left_mid_y = $left_center_y + 16 + $circle_radius + $circle_offset;

$right_lower_circle_x1 = $right_center_x - 49;
$right_lower_circle_x2 = $right_center_x + 49;
$right_mid_x = ($right_lower_circle_x1 + $right_lower_circle_x2) / 2;
$right_mid_y = $right_center_y + 16 + $circle_radius + $circle_offset;

// Вираховуємо позиції для малювання $plus_img
$plus_img_left_x = $left_mid_x - $plus_img_width / 2;
$plus_img_left_y = $left_mid_y - $plus_img_height / 2;

$plus_img_right_x = $right_mid_x - $plus_img_width / 2;
$plus_img_right_y = $right_mid_y - $plus_img_height / 2;

// Малюємо перший "плюс" у лівій частині
imagecopy($back, $plus_img, $plus_img_left_x, $plus_img_left_y, 0, 0, $plus_img_width, $plus_img_height);

// Малюємо другий "плюс" у правій частині
imagecopy($back, $plus_img, $plus_img_right_x, $plus_img_right_y, 0, 0, $plus_img_width, $plus_img_height);


}

header("Content-type: image/png");
imagepng($back);
imagedestroy($back);
?>
