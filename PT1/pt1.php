<?php
function deg_rad($deg){
    return $deg * pi() / 180;
}

if (isset($_GET['t'])) {
    $t = $_GET['t'];
} else {
    $t = '[]';
}

$t = json_decode($t);
$right_number = $t[0];

$elements = [];
$n1 = rand(0, 5);
do {
    $n2 = rand(0, 5);
} while ($n1 == $n2);
array_push($elements, $n1);
array_push($elements, $n2);

$type_color = [];
for ($i = 0; $i < 16; $i++) {
    $color = rand(0, 5);
    $type = rand(0, 3);
    array_push($type_color, array("t" => $type, "c" => $color));
}

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
$font = '../../Inter.ttf';
$size = 16;
$letters = ['A', 'B', 'C', 'D'];
$positions = [40, 120, 200, 280];

// Оформлення літер та кругів
// foreach ($positions as $index => $position) {
//     // Draw a gray circle first
//     $draw->setFillColor(new ImagickPixel('rgb(229, 236, 240)')); // Сірий колір
//     $draw->circle(280, $position, 280 + 16, $position); // Коло
// }

// Додаємо лінії та круги до зображення
$image->drawImage($draw);

// 3. Малювання літер поверх кругів
$draw = new ImagickDraw();
$draw->setFontSize($size);
$draw->setFont($font);
$draw->setFillColor(new ImagickPixel('rgb(0, 0, 0)')); // Колір тексту - чорний

foreach ($positions as $index => $position) {
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
    $y = $position - 8 - 8; // Центрування тексту по вертикалі

    // Композитування літери поверх основного зображення
    $image->compositeImage($imagickText, Imagick::COMPOSITE_OVER, $x, $y);
}


// 4. Малювання об'єктів
for ($i = 0; $i < count($elements) * 2; $i += 1) {
    $draw->setFillColor(get_color($elements[$i % 2]));
    $fig = new square($draw, 60 + 50 * $i, 160);
    $draw = $fig->out_print();
}

for ($j = 0; $j < 4; $j += 1) {
    do {
        $wrong_elements = [];
        $n1 = rand(0, 5);
        do {
            $n2 = rand(0, 5);
        } while ($n1 == $n2);
        array_push($wrong_elements, $n1);
        array_push($wrong_elements, $n2);
    } while (($wrong_elements[0] == $elements[0]) && ($wrong_elements[1] == $elements[1]));

    for ($i = 0; $i < count($elements); $i += 1) {
        if ($j == $right_number) {
            $draw->setFillColor(get_color($elements[$i % 2]));
            $fig = new square($draw, 345 + 50 * $i, 50 + $j * 75);
            $draw = $fig->out_print();
        } else {
            $draw->setFillColor(get_color($wrong_elements[$i % 2]));
            $fig = new square($draw, 345 + 50 * $i, 50 + $j * 75);
            $draw = $fig->out_print();
        }
    }
}

// Виводимо остаточне зображення
$image->drawImage($draw);
header('Content-type: image/png');
echo $image;

// Функція для отримання кольору
function get_color($color) {
    $colors = [
        'rgb(300, 32, 32)',    // 0
        'rgb(300, 300, 32)',    // 1
        'rgb(32, 300, 32)',     // 2
        'rgb(32, 300, 300)',    // 3
        'rgb(32, 32, 300)',     // 4
        'rgb(300, 32, 300)'     // 5
    ];
    return $colors[$color];
}

// Клас квадрат
class square {
    public $draw;
    
    function __construct($draw, $x, $y) {
        $this->draw = $draw;
        $scale = 48;
        $points = [
            ['x' => $x - $scale / 2 + 2, 'y' => $y - $scale / 2 + 2],
            ['x' => $x + $scale / 2 - 2, 'y' => $y - $scale / 2 + 2],
            ['x' => $x + $scale / 2 - 2, 'y' => $y + $scale / 2 - 2],
            ['x' => $x - $scale / 2 + 2, 'y' => $y + $scale / 2 - 2],
        ];
        $draw->polygon($points);
    }
    
    function out_print() {
        return $this->draw;
    }
}
?>
