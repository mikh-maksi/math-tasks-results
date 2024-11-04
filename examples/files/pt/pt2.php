<?php

declare(strict_types=1);

include '../config.php';

$assets_path = getAssetsPath();

if (isset($_GET['t'])) {
    $t = $_GET['t'];
} else {
    $t = '[]';
}

$t = json_decode($t);

// Перемішуємо масив для випадкового порядку
shuffle($t);

$image = new Imagick();
$image->newImage(560, 320, new ImagickPixel('rgb(244, 247, 248)')); // Сірий фон
$image->setImageFormat('png');

// 1. Малювання ліній
$draw = new ImagickDraw();
$draw->setStrokeColor(new ImagickPixel('rgb(229, 236, 240)')); // Колір лінії
$draw->line(280, 0, 280, 320); // Центральна вертикальна лінія
$draw->line(280, 240, 560, 240); // Лінія 1
$draw->line(280, 160, 560, 160); // Лінія 2
$draw->line(280, 80, 560, 80);   // Лінія 3

// 2. Малювання кругів
$font = '../assets/Inter.ttf';
$size = 16;
$letters = ['A', 'B', 'C', 'D'];
$position_vs = [40, 120, 200, 280];

// Додаємо лінії та круги до зображення
$image->drawImage($draw);

// 3. Малювання літер поверх кругів
$draw = new ImagickDraw();
$draw->setFontSize($size);
$draw->setFont($font);
$draw->setFillColor(new ImagickPixel('rgb(0, 0, 0)')); // Колір тексту - чорний

foreach ($position_vs as $index => $position_v) {
    // Створення GD-зображення для кожної літери з прозорим фоном
    $gdImage = imagecreatetruecolor(32, 32); // Створення зображення
    imagesavealpha($gdImage, true);
    $transparentColor = imagecolorallocatealpha($gdImage, 0, 0, 0, 127); // Прозорий фон
    imagefill($gdImage, 0, 0, $transparentColor);

    // Сірий колір для фону круга
    $circleColor = imagecolorallocate($gdImage, 229, 236, 240);

    // Малюємо круг
    imagefilledellipse($gdImage, 16, 16, 32, 32, $circleColor);

    // Чорний колір для тексту
    $textColor = imagecolorallocate($gdImage, 0, 0, 0);

    // Малювання літери
    imagettftext($gdImage, $size, 0, 8, 24, $textColor, $font, $letters[$index]);

    // Буферизація даних зображення
    ob_start(); // Старт буферизації
    imagepng($gdImage); // Вивід зображення як PNG
    $imageData = ob_get_contents(); // Отримання даних з буферу
    ob_end_clean(); // Очищення буферу

    // Звільнення ресурсу GD-зображення
    imagedestroy($gdImage);

    // Конвертування GD-зображення в Imagick
    $imagickText = new Imagick();
    $imagickText->readImageBlob($imageData); // Читання з буферу

    // Композитування літери на основне зображення
    $x = 280 - 16; // Центрування тексту по горизонталі
    $y = $position_v - 8 - 8; // Центрування тексту по вертикалі

    // Композитування літери поверх основного зображення
    $image->compositeImage($imagickText, Imagick::COMPOSITE_OVER, $x, $y);
}

// 4. Малювання квадратів з бордерами
$squareCount = 4; // Кількість квадратів
$squarePositions = [];
$squareSize = 40; // Розмір квадрата
$centerY = 160; // Вертикальний центр квадрата
$distance = 5; // Відстань між квадратами

// Обчислюємо позиції квадратів з урахуванням відстані
for ($i = 0; $i < $squareCount; $i++) {
    $squarePositions[] = ($i * ($squareSize + $distance)) + 40 + 35; // Відстань між квадратами
}

$draw->setFillColor(new ImagickPixel('rgb(255, 255, 255)')); // Білий фон для квадратів
$draw->setStrokeColor(new ImagickPixel('rgb(229, 236, 240)')); // Сірий бордер
$draw->setStrokeWidth(2); // Товщина бордеру

// Створюємо копії t для випадкового порядку
$horizontalValues = array_slice($t, 0, 4);
$verticalValues = array_slice($t, 4, 4);

// Перемішуємо значення для квадратів
shuffle($horizontalValues);
shuffle($verticalValues);

// Малюємо горизонтальні квадрати
foreach ($squarePositions as $position_v) {
    // Малюємо квадрат з закругленими кутами
    $draw->roundRectangle($position_v - $squareSize / 2, $centerY - $squareSize / 2, $position_v + $squareSize / 2, $centerY + $squareSize / 2, 8, 8);
}

// Додаємо квадрати до зображення
$image->drawImage($draw);

// 5. Додавання тексту до горизонтальних квадратів
foreach ($squarePositions as $index => $position_v) {
    if (isset($horizontalValues[$index])) {
        // Перетворення значення на рядок
        $textValue = (string)$horizontalValues[$index];

        // Створення GD-зображення для кожної цифри з прозорим фоном
        $gdImage = imagecreatetruecolor(32, 32); // Створення зображення
        imagesavealpha($gdImage, true);
        $transparentColor = imagecolorallocatealpha($gdImage, 0, 0, 0, 127); // Прозорий фон
        imagefill($gdImage, 0, 0, $transparentColor);

        // Чорний колір для тексту
        $textColor = imagecolorallocate($gdImage, 0, 0, 0);

        // Малювання цифри
        imagettftext($gdImage, $size, 0, 1, 24, $textColor, $font, $textValue); // Використання $textValue

        // Буферизація даних зображення
        ob_start(); // Старт буферизації
        imagepng($gdImage); // Вивід зображення як PNG
        $imageData = ob_get_contents(); // Отримання даних з буферу
        ob_end_clean(); // Очищення буферу

        // Звільнення ресурсу GD-зображення
        imagedestroy($gdImage);

        // Конвертування GD-зображення в Imagick
        $imagickText = new Imagick();
        $imagickText->readImageBlob($imageData); // Читання з буферу

        // Композитування цифри на основне зображення
        $x = $position_v - (strlen($textValue) * 8); // Центрування тексту по горизонталі
        $y = $centerY - 15; // Центрування тексту по вертикалі

        // Композитування цифри поверх основного зображення
        $image->compositeImage($imagickText, Imagick::COMPOSITE_OVER, $x, $y);
    }
}

// 6. Малювання вертикальних квадратів
$verticalSquareCount = 4; // Кількість вертикальних квадратів
$verticalSquarePositions = [];
$verticalSquareSize = 40; // Розмір вертикального квадрата
$verticalSquareWidth = 80; // Ширина вертикального квадрата
$centerX = 350; // Горизонтальний центр квадрата
$distance_v = 40;

// Обчислюємо позиції вертикальних квадратів з урахуванням відстані
for ($i = 0; $i < $verticalSquareCount; $i++) {
    $verticalSquarePositions[] = ($i * ($verticalSquareSize + $distance_v)) + 40; // Відстань між квадратами
}

// Малюємо вертикальні квадрати
foreach ($verticalSquarePositions as $position_v) {
    $draw->setFillColor(new ImagickPixel('rgb(255, 255, 255)')); // Білий фон для квадратів
    $draw->setStrokeColor(new ImagickPixel('rgb(229, 236, 240)')); // Сірий бордер
    $draw->setStrokeWidth(2); // Товщина бордеру

    // Малюємо квадрат з закругленими кутами
    $draw->roundRectangle($centerX - $verticalSquareWidth / 2, $position_v - $verticalSquareSize / 2, $centerX + $verticalSquareWidth / 2, $position_v + $verticalSquareSize / 2, 8, 8);
}

// Додаємо вертикальні квадрати до зображення
$image->drawImage($draw);

// 7. Додавання тексту до вертикальних квадратів
foreach ($verticalSquarePositions as $index => $position_v) {
    if (isset($verticalValues[$index])) {
        // Перетворення значення на рядок
        $textValue = (string)$verticalValues[$index];

        // Створення GD-зображення для кожної цифри з прозорим фоном
        $gdImage = imagecreatetruecolor(32, 32); // Створення зображення
        imagesavealpha($gdImage, true);
        $transparentColor = imagecolorallocatealpha($gdImage, 0, 0, 0, 127); // Прозорий фон
        imagefill($gdImage, 0, 0, $transparentColor);

        // Чорний колір для тексту
        $textColor = imagecolorallocate($gdImage, 0, 0, 0);

        // Малювання цифри
        imagettftext($gdImage, $size, 0, 1, 24, $textColor, $font, $textValue); // Використання $textValue

        // Буферизація даних зображення
        ob_start(); // Старт буферизації
        imagepng($gdImage); // Вивід зображення як PNG
        $imageData = ob_get_contents(); // Отримання даних з буферу
        ob_end_clean(); // Очищення буферу

        // Звільнення ресурсу GD-зображення
        imagedestroy($gdImage);

        // Конвертування GD-зображення в Imagick
        $imagickText = new Imagick();
        $imagickText->readImageBlob($imageData); // Читання з буферу

        // Композитування цифри на основне зображення
        $x = $centerX - 10; // Центрування тексту по горизонталі
        $y = $position_v - 15; // Центрування тексту по вертикалі

        // Композитування цифри поверх основного зображення
        $image->compositeImage($imagickText, Imagick::COMPOSITE_OVER, $x, $y);
    }
}

// Виводимо фінальне зображення
header("Content-Type: image/png");
echo $image;

// Звільнення ресурсу
$image->destroy();
