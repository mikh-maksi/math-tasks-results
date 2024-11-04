<?php
declare(strict_types = 1);

include '../config.php';



// Отримуємо параметр 't' із запиту
if (isset($_GET['t'])) {
    // Декодуємо параметр t
    $t = json_decode($_GET['t'], true);
    if (!is_array($t) || count($t) == 0) {
        $t = 1; // За замовчуванням малюємо один квадрат, якщо параметр відсутній
    } else {
        $t = (int)$t[0]; // Використовуємо перший елемент масиву як кількість квадратів
    }
} else {
    $t = 1; // За замовчуванням один квадрат
}

// Обмежуємо загальну кількість квадратів до 20
$t = min($t, 20);

// Встановлюємо розміри зображення
$imageWidth = 560;
$imageHeight = 304;

// Розміри квадрата
$rectWidth = 24;
$rectHeight = 24;

// Відступи
$bottomOffset = 16; // Відступ знизу
$gap = 10; // Проміжок між квадратами
$rightOffset = 10; // Відступ праворуч для другого стовпчика

// Розрахунок координат для початку малювання
$startX = ($imageWidth - $rectWidth) / 2; // Центруємо по горизонталі
$startY = $imageHeight - $bottomOffset - $rectHeight; // Починаємо знизу

// Колір бордюру і заливки
$strokeColor = new \ImagickPixel('black'); // Чорний колір для бордюру
$fillColorOrange = new \ImagickPixel('#FF7F00'); // Помаранчевий колір для заливки
$fillColorYellow = new \ImagickPixel('#FFDA19'); // Жовтий колір для заливки
$backgroundColor = new \ImagickPixel('white'); // Білий колір для фону

// Створюємо нове зображення
$imagick = new \Imagick();
$imagick->newImage($imageWidth, $imageHeight, $backgroundColor); // Зображення 560x304
$imagick->setImageFormat("png");

// Створюємо об'єкт для малювання
$draw = new \ImagickDraw();
$draw->setStrokeColor($strokeColor);
$draw->setStrokeOpacity(1);
$draw->setStrokeWidth(1); // Товщина бордюру

// Логіка для малювання квадратів
if ($t < 10) {
    // Малюємо жовті квадрати у двох колонках
    if ($t > 5) {
        // Перший стовпчик (до 5 квадратів)
        $firstColumnCount = 5;
        $secondColumnCount = $t - $firstColumnCount;

        // Малюємо перший стовпчик
        for ($i = 0; $i < $firstColumnCount; $i++) {
            // Розраховуємо координати для кожного квадрата
            $currentY = $startY - ($rectHeight + $gap) * $i;

            // Встановлюємо колір заливки
            $draw->setFillColor($fillColorYellow);

            // Малюємо прямокутник із закругленими кутами
            $draw->roundRectangle(
                $startX, // Початок по X
                $currentY, // Початок по Y
                $startX + $rectWidth, // Кінець по X
                $currentY + $rectHeight, // Кінець по Y
                4, // Заокруглення по X
                4 // Заокруглення по Y
            );
        }

        // Розрахунок початкової позиції для другого стовпчика
        $startX += $rectWidth + $rightOffset; // Відступ праворуч для другого стовпчика

        // Малюємо другий стовпчик
        for ($i = 0; $i < $secondColumnCount; $i++) {
            // Розраховуємо координати для кожного квадрата
            $currentY = $startY - ($rectHeight + $gap) * $i;

            // Встановлюємо колір заливки
            $draw->setFillColor($fillColorYellow);

            // Малюємо прямокутник із закругленими кутами
            $draw->roundRectangle(
                $startX, // Початок по X
                $currentY, // Початок по Y
                $startX + $rectWidth, // Кінець по X
                $currentY + $rectHeight, // Кінець по Y
                4, // Заокруглення по X
                4 // Заокруглення по Y
            );
        }
    } else {
        // Якщо t <= 5, малюємо всі квадрати в одному стовпчику
        for ($i = 0; $i < $t; $i++) {
            // Розраховуємо координати для кожного квадрата
            $currentY = $startY - ($rectHeight + $gap) * $i;

            // Встановлюємо колір заливки
            $draw->setFillColor($fillColorYellow);

            // Малюємо прямокутник із закругленими кутами
            $draw->roundRectangle(
                $startX, // Початок по X
                $currentY, // Початок по Y
                $startX + $rectWidth, // Кінець по X
                $currentY + $rectHeight, // Кінець по Y
                4, // Заокруглення по X
                4 // Заокруглення по Y
            );
        }
    }
} elseif ($t == 10) {
    // Малюємо 10 помаранчевих квадратів
    $slotWidth = 24;
$slotHeight = 24;
$totalHeight = 240;

// Встановлюємо колір заливки
$draw->setFillColor($fillColorOrange);

// Малюємо великий прямокутник з заокругленими кутами
$draw->roundRectangle(
    $startX, // Початок по X
    $startY - $totalHeight + 24, // Початок по Y
    $startX + $slotWidth, // Кінець по X
    $startY + 24, // Кінець по Y
    4, // Заокруглення по X
    4  // Заокруглення по Y
);

// Малюємо горизонтальні лінії, щоб розділити на слоти
for ($i = 0; $i < 9; $i++) {
    $currentY = $startY - ($slotHeight * $i); // Розраховуємо координати для кожної лінії
    $draw->line(
        $startX, // Початок по X
        $currentY, // Початок по Y
        $startX + $slotWidth, // Кінець по X
        $currentY // Кінець по Y
    );
}
} else { // t > 10
    // Спочатку малюємо жовті квадрати (t - 10)
    $yellowCount = $t - 10; // Кількість жовтих квадратів (t - 10)
    
    if ($yellowCount > 5) {
        // Перший стовпчик (до 5 квадратів)
        $firstColumnCount = 5;
        $secondColumnCount = $yellowCount - $firstColumnCount;

        // Малюємо перший стовпчик
        for ($i = 0; $i < $firstColumnCount; $i++) {
            // Розраховуємо координати для кожного квадрата
            $currentY = $startY - ($rectHeight + $gap) * $i;

            // Встановлюємо колір заливки
            $draw->setFillColor($fillColorYellow);

            // Малюємо прямокутник із закругленими кутами
            $draw->roundRectangle(
                $startX, // Початок по X
                $currentY, // Початок по Y
                $startX + $rectWidth, // Кінець по X
                $currentY + $rectHeight, // Кінець по Y
                4, // Заокруглення по X
                4 // Заокруглення по Y
            );
        }

        // Розрахунок початкової позиції для другого стовпчика
        $startX += $rectWidth + $rightOffset; // Відступ праворуч для другого стовпчика

        // Малюємо другий стовпчик
        for ($i = 0; $i < $secondColumnCount; $i++) {
            // Розраховуємо координати для кожного квадрата
            $currentY = $startY - ($rectHeight + $gap) * $i;

            // Встановлюємо колір заливки
            $draw->setFillColor($fillColorYellow);

            // Малюємо прямокутник із закругленими кутами
            $draw->roundRectangle(
                $startX, // Початок по X
                $currentY, // Початок по Y
                $startX + $rectWidth, // Кінець по X
                $currentY + $rectHeight, // Кінець по Y
                4, // Заокруглення по X
                4 // Заокруглення по Y
            );
        }
    } else {
        // Якщо жовтих квадратів <= 5, малюємо всі в одному стовпчику
        for ($i = 0; $i < $yellowCount; $i++) {
            // Розраховуємо координати для кожного квадрата
            $currentY = $startY - ($rectHeight + $gap) * $i;

            // Встановлюємо колір заливки
            $draw->setFillColor($fillColorYellow);

            // Малюємо прямокутник із закругленими кутами
            $draw->roundRectangle(
                $startX, // Початок по X
                $currentY, // Початок по Y
                $startX + $rectWidth, // Кінець по X
                $currentY + $rectHeight, // Кінець по Y
                4, // Заокруглення по X
                4 // Заокруглення по Y
            );
        }
    }

    // Тепер малюємо 10 помаранчевих квадратів
    // Задаємо параметри
$slotWidth = 24;
$slotHeight = 24;
$totalHeight = 240;

// Встановлюємо колір заливки
$draw->setFillColor($fillColorOrange);

// Малюємо великий прямокутник з заокругленими кутами
$draw->roundRectangle(
    $startX - 70, // Початок по X
    $startY - $totalHeight + 24, // Початок по Y
    $startX + $slotWidth - 70, // Кінець по X
    $startY + 24, // Кінець по Y
    4, // Заокруглення по X
    4  // Заокруглення по Y
);

// Малюємо горизонтальні лінії, щоб розділити на слоти
for ($i = 0; $i < 9; $i++) {
    $currentY = $startY - ($slotHeight * $i); // Розраховуємо координати для кожної лінії
    $draw->line(
        $startX - 70, // Початок по X
        $currentY, // Початок по Y
        $startX + $slotWidth - 70, // Кінець по X
        $currentY // Кінець по Y
    );
}
}

// Додаємо малюнок до зображення
$imagick->drawImage($draw);

// Завершуємо
$imagick->setImageFormat('png');

// Виводимо зображення
header("Content-Type: image/png");
echo $imagick;
?>
