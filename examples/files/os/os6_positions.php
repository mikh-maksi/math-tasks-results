<?php
declare(strict_types = 1);

include '../config.php';

$assets_path = getAssetsPath();
$names = getNames();

$font_file = $assets_path."/Inter.ttf";

if (isset($_GET['t'])){$t = $_GET['t'];}else{$t='[]';} // Перевіряємо, чи передано параметр 't' у запиті
$t = json_decode($_GET['t']); // Декодуємо JSON-строку в масив

$number = $t[0]; // Кількість об'єктів
$object_name1 = $t[1]; // Назва об'єкта
$object_name2 = $t[2]; // Тип лінії

$type_lines = ["Horisontal line","Vertical line","Main diagonal","Secondary diagonal"]; // Можливі типи ліній

$n_type_left = random_int(0, 3); // Призначаємо випадкове значення типу лінії для лівого зображення
// $n_type_left = 3;
do {
    $n_type_right = random_int(0, 3); // Призначаємо випадкове значення типу лінії для правого зображення
} while ($n_type_right === $n_type_left); // Поки типи однакові, повторюємо

// $n_type_right = 3;
// !!! Винести до функції
$canvas_width = 560; // Ширина полотна
$canvas_height = 280; // Висота полотна

$back = imagecreatetruecolor($canvas_width, $canvas_height); // Створюємо ресурс зображення
$black = imagecolorallocate($back, 0, 0, 0);

// Заливаємо фон сірого квадрата кольором #F4F7F8 (RGB: 244, 247, 248)
$background_color = imagecolorallocate($back, 244, 247, 248); // Визначаємо колір фону
imagefill($back, 0, 0, $background_color); // Заповнюємо фон

// !!! Винести до функції

// Функція для пошуку групи об'єктів
function find_object_group($obj, $names) {
    foreach ($names as $group => $objects) { // Ітеруємо по групах об'єктів
        if (in_array($obj, $objects)) { // Якщо об'єкт знайдено в групі
            return $group; // Повертаємо назву групи
        }
    }
    return null; // Повертаємо null, якщо об'єкт не знайдено
}

$object_group1 = findGroupName($object_name1); // Знаходимо групу об'єкта
$object_group2 = findGroupName($object_name2); // Знаходимо групу об'єкта

$black = imagecolorallocate($back, 0, 0, 0); // Визначаємо чорний колір для тексту та ліній

$circle_color = imagecolorallocate($back, 229, 236, 240); // Колір для ліній
$font_file = $assets_path.'/Inter.ttf'; // Шлях до шрифту

// Малюємо вертикальні лінії на полотні
imageline($back, 280, 0, 280, 280, $circle_color );
imageline($back, 0, 140, 560, 140, $circle_color );
imageline($back, 420, 0, 420, 280, $circle_color );



// Ініціалізація координат для малювання об'єктів
$x_start = 5;
$y_start = 5;


$col = 7; // Кількість колонок для розташування об'єктів

$object1 = imagecreatefrompng($assets_path ."/images/flat96/{$object_group1}/{$object_name1}.png"); 
$object2 = imagecreatefrompng($assets_path ."/images/flat96/{$object_group2}/{$object_name2}.png"); 





for($m=0;$m<2;$m+=1){ // Цикл для можливого повторення
    $jj = $m%2; // Індекс для чергування
    $ii = intdiv($m,2); // Індекс для ряду
    $value = $number; // Кількість об'єктів
   
    $font_size = 10;

    $col = 8;
    $line_value = $value;
    $objects_length = 16 * ($line_value-1);
    $correction = $objects_length;
    $text_out = "n = {$value}, length = {$objects_length}, correction = {$correction}";
    // imagettftext($back, $font_size, 0, 300, 200, $black, $font_file, $text_out);


    for ($k=0;$k<$value;$k+=1){ // Цикл для розташування об'єктів

    // Копіюємо зображення об'єкта на полотно
    $j = $k%$col; // Стовпець
    $i = intdiv($k,$col); // Ряд
    if ($n_type_left==0){ // Для горизонтальної лінії
        imagecopyresampled($back , $object1,123+32*$j-$correction, 123, 0, 0, 32, 32, 96, 96);
    }
    if ($n_type_left==1){ // Для вертикальної лінії
        imagecopyresampled($back ,$object1, 123, 140-17+32*$j-$correction, 0, 0, 32, 32, 96, 96);
    }        
    if ($n_type_left==2){ // Для головної діагоналі
        imagecopyresampled($back , $object1,123+32*$j-$correction, 140-17+32*$j-$correction, 0, 0, 32, 32, 96, 96);
    }
    if ($n_type_left==3){ // Для вторинної діагоналі
        imagecopyresampled($back , $object1,123+32*($value-$j-1)-$correction, 140-17+32*$j-$correction, 0, 0, 32, 32, 96, 96);
    }
    }
}
$font_size = 10;

$col = 8;
$line_value = $value;
$objects_length = 16 * ($line_value-1);
$correction = $objects_length;
$text_out = "n = {$value}, length = {$objects_length}, correction = {$correction}";
// imagettftext($back, $font_size, 0, 300, 200, $black, $font_file, $text_out);

// Вибираємо позицію залежно від типу лінії для правого зображення
for ($k=0; $k<$value; $k+=1) {
    // Копіюємо зображення об'єкта на полотно
    $j = $k%$col; // Стовпець
    $i = intdiv($k,$col); // Ряд
    if ($n_type_right==0){ // Для горизонтальної лінії
        imagecopyresampled($back , $object2,403+32*$j-$correction, 123, 0, 0, 32, 32, 96, 96);
    }
    if ($n_type_right==1){ // Для вертикальної лінії
        imagecopyresampled($back ,$object2, 420-17, 140-17+32*$j-$correction, 0, 0, 32, 32, 96, 96);
    }        
    if ($n_type_right==2){ // Для головної діагоналі
        imagecopyresampled($back , $object2,403+32*$j-$correction, 140-17+32*$j-$correction, 0, 0, 32, 32, 96, 96);
    }
    if ($n_type_right==3){ // Для вторинної діагоналі
        imagecopyresampled($back , $object2,403+32*($value-$j-1)-$correction, 140-17+32*$j-$correction, 0, 0, 32, 32, 96, 96);
    }
}

header("Content-type: image/png"); // Встановлюємо тип контенту на PNG
// Виводимо зображення
imagepng($back); // Виводимо PNG-формат
imagedestroy($back); // Знищуємо ресурс зображення
?>
