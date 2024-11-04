<?php

declare(strict_types = 1);

include '../config.php';

$assets_path = getAssetsPath();
$names = getNames();

// Отримуємо параметр 't' з запиту
if (isset($_GET['t'])) {
    $t = $_GET['t'];
} else {
    $t = '["apple"]';
}
$t = json_decode($t);

// Присвоюємо змінні з розпакованого масиву
$diff = $t[0]; // Кількість об'єктів зліва від плюса
$sub = $t[1];  // Кількість об'єктів справа від плюса

if (count($t)==3){
    $obj = $t[2];  // Об'єкт
}else{
    $obj= "apple";
}
// Можливі групи об'єктів і їх значення
$names = getNames();

// Знайдемо групу для переданого об'єкта
$object_group = find_group_name($obj, $names);

if ($object_group !== null) {
    // Якщо групу знайдено, формуємо шлях до зображення
    $object_image_path = $assets_path."/images/flat96/".$object_group."/".$obj.".png";

    if (file_exists($object_image_path)) {
        $object_image = imagecreatefrompng($object_image_path);
    } else {
        echo "Помилка: Зображення для об'єкта '{$obj}' не знайдено.";
        exit;
    }
} else {
    echo "Помилка: Об'єкт '{$obj}' не знайдено в жодній групі.";
    exit;
}

// Корекція першого і другого аргументів
if ($diff < 1) {
    $diff = 1;
    $sub = max(1, min($sub, 8)); // Другий аргумент має бути від 1 до 8
} elseif ($diff > 8) {
    $diff = 8;
    $sub = 1;
} else {
    $sub = min($sub, 9 - $diff);
    $sub = max(1, min($sub, 8)); // Переконуємось, що другий аргумент в межах 1-8
}

// Розмір зображення
$width = 560;
$height = 112;

// Параметри об'єктів
$objectWidth = 48;
$objectHeight = 48;

$padding = 32;
$spacing = 8;
$plusWidth = 14;
$plusHeight = 14;

// Створюємо зображення
$back = imagecreatetruecolor($width, $height);
$gray = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $gray);
$black = imagecolorallocate($back, 0, 0, 0);

$plus = imagecreatefrompng($assets_path."/images/flat96/signs/plus-small.png");

// Обчислюємо загальну ширину без відступів навколо плюса
$totalWidth = $diff * $objectWidth + $sub * $objectWidth + 9 * $spacing + $plusWidth;

// Початкова координата для центрування блоку по горизонталі
$start_x = ($width - $totalWidth) / 2;

// Відображаємо об'єкти зліва від плюса
$currentX = $start_x;
for ($i = 0; $i < $diff; $i++) {
    $objectX = $currentX;
    $objectY = ($height - $objectHeight) / 2; // Центрування по вертикалі

    imagecopyresampled($back, $object_image, $objectX, $objectY, 0, 0, $objectWidth, $objectHeight, imagesx($object_image),  imagesy($object_image));

    $currentX += $objectWidth + $spacing;
}

// Відображаємо плюсик
$plusX = $currentX;
$plusY = (int)(($height - 17) / 2);

imagecopyresampled($back, $plus, $plusX, $plusY, 0, 0, $plusWidth, $plusHeight, $plusWidth, $plusHeight);

// Переміщуємо координату після плюса
$currentX += 13 + $spacing;

// Відображаємо об'єкти справа від плюса
for ($i = 0; $i < $sub; $i++) {
    $objectX = $currentX;
    $objectY = ($height - $objectHeight) / 2; // Центрування по вертикалі

    // imagecopy($back, $object_image, $objectX, $objectY, 0, 0, $objectWidth, $objectHeight);
    imagecopyresampled($back, $object_image, $objectX, $objectY, 0, 0, $objectWidth, $objectHeight, imagesx($object_image),  imagesy($object_image));

    $currentX += $objectWidth + $spacing;
}

header("Content-type: image/png");

// Виводимо зображення
imagepng($back);
imagedestroy($back);

?>
