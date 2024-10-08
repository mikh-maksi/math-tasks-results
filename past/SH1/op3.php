<?php
header("Content-type: image/png");

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
$names = [];
$names['activities'] = ['football','going-to-school','walking-with-dog'];
$names['animals'] = ['bird','cat','dino','dog','duck','fish'];
$names['balls'] = ['ball-blue','ball-green','ball-red','ball-yellow'];
$names['fruits'] = ['apple','apricot','banana','broccoli','carrot','grape','kiwi','lemon','orange','pear','strawberry','tomato'];
$names['items'] = ['ball-beach','baloon','block','book','box','clay','dumbell','feather','flat','flower','house','mountain','paper','pencil','rubber','ruler','smartphone','star','string'];
$names['sweets'] = ['cake','candy','cookie'];
$names['vehicles'] = ['car-front','racing-car-blue','racing-car-green','racing-car-purple','racing-car-red','racing-car-yellow','simple-car-blue','simple-car-green','simple-car-purple','simple-car-red','simple-car-yellow'];
$names['shapes'] = ['circle','hexagon','octagon','parallelogram','pentagon','rectangle','rhombus','square','trapezoid','triangle'];

// Функція для пошуку групи по об'єкту
function find_object_group($obj, $names) {
    foreach ($names as $group => $objects) {
        if (in_array($obj, $objects)) {
            return $group; // Повертаємо назву групи, якщо об'єкт знайдений
        }
    }
    return null; // Повертаємо null, якщо об'єкт не знайдено
}

// Знайдемо групу для переданого об'єкта
$object_group = find_object_group($obj, $names);

if ($object_group !== null) {
    // Якщо групу знайдено, формуємо шлях до зображення
    $object_image_path = "../../images/flat48/".$object_group."/".$obj.".png";
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

$plus = imagecreatefrompng("../../images/flat48/signs/plus.png");

// Обчислюємо загальну ширину без відступів навколо плюса
$totalWidth = $diff * $objectWidth + $sub * $objectWidth + 9 * $spacing + $plusWidth;

// Початкова координата для центрування блоку по горизонталі
$start_x = ($width - $totalWidth) / 2;

// Відображаємо об'єкти зліва від плюса
$currentX = $start_x;
for ($i = 0; $i < $diff; $i++) {
    $objectX = $currentX;
    $objectY = ($height - $objectHeight) / 2; // Центрування по вертикалі

    imagecopy($back, $object_image, $objectX, $objectY, 0, 0, $objectWidth, $objectHeight);

    $currentX += $objectWidth + $spacing;
}

// Відображаємо плюсик
$plusX = $currentX; 
$plusY = ($height - 17) / 2;

imagecopyresampled($back, $plus, $plusX, $plusY, 0, 0, $plusWidth, $plusHeight, $plusWidth, $plusHeight);

// Переміщуємо координату після плюса
$currentX += 13 + $spacing;

// Відображаємо об'єкти справа від плюса
for ($i = 0; $i < $sub; $i++) {
    $objectX = $currentX;
    $objectY = ($height - $objectHeight) / 2; // Центрування по вертикалі

    imagecopy($back, $object_image, $objectX, $objectY, 0, 0, $objectWidth, $objectHeight);

    $currentX += $objectWidth + $spacing;
}

// Виводимо зображення
imagepng($back);
imagedestroy($back);

?>
