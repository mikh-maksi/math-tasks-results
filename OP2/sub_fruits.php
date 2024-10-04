<?php
header("Content-type: image/png");

// Отримання параметра t
$t = isset($_GET['t']) ? $_GET['t'] : '[]';
$t = json_decode($t);

// Перевірка та корекція значень $diff і $sub
$diff = isset($t[0]) ? $t[0] : 0; // Кількість собак без хрестиків
$sub = isset($t[1]) ? $t[1] : 1;  // Загальна кількість собак


// Якщо значення менше 0, встановлюємо 0, якщо більше 9, встановлюємо 9
$diff = max(0, min($diff, 9));
$sub = max(1, min($sub, 9));

// Переконуємося, що $diff не більше ніж $sub
$diff = min($diff, $sub);

// Створюємо зображення розміром 600x100
$width = 560;
$height = 112;
$back = imagecreatetruecolor($width, $height);

// Встановлюємо кольори
$light_gray = imagecolorallocate($back, 244, 247, 248); // Світло-сірий

// Заповнюємо фон світло-сірим кольором
imagefill($back, 0, 0, $light_gray);

// Завантажуємо зображення собаки і хрестика
$dog = imagecreatefrompng("../../images/flat48/fruits/apple.png");
$delete_img = imagecreatefrompng("../../images/flat48/delete/delete.png");

// Визначаємо гап
$gap = 11.5; // Стандартний гап між собаками

// Обчислюємо доступну ширину для собак
$available_width = $width - 2 * 35; // Відступи по 35px з обох сторін

// Отримуємо оригінальні розміри собаки
$original_dog_width = imagesx($dog);
$original_dog_height = imagesy($dog);

// Обчислюємо масштаб для збереження пропорцій
$scale = min(($available_width - ($gap * ($sub - 1))) / $sub / $original_dog_width, ($height) / 2 / $original_dog_height);

// Обчислюємо нові розміри зображення собаки
$object_width = $original_dog_width; // Зменшена ширина об'єкта
$object_height = $original_dog_height; // Зменшена висота об'єкта

// Позиції для кожної собаки
$x_offset = ($width - ($sub * $object_width + ($gap * ($sub - 1)))) / 2; // Центруємо по горизонталі
$y_offset = ($height - $object_height) / 2; // Центруємо по вертикалі

// Малюємо собак з перекресленими та без
for ($i = 0; $i < $sub; $i++) {
    // Вибір: собака з хрестиком або без
    $has_delete = ($i >= $diff); // Якщо індекс >= diff, тоді собака з хрестиком

    // Позиція для кожної собаки
    $x = $x_offset + $i * ($object_width + $gap); // З урахуванням відстані між собаками
    $y = $y_offset; // Центруємо по вертикалі

    // Малюємо собаку
    imagecopyresampled($back, $dog, $x, $y, 0, 0, $object_width, $object_height, $original_dog_width, $original_dog_height);

    // Якщо є хрестик, малюємо його поверх собаки
    if ($has_delete) {
        imagecopyresampled($back, $delete_img, $x, $y, 0, 0, $object_width, $object_height, imagesx($delete_img), imagesy($delete_img));
    }
}

// Виводимо зображення
imagepng($back);

// Звільняємо пам'ять
imagedestroy($back);
imagedestroy($dog);
imagedestroy($delete_img);
?>
