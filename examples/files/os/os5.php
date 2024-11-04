<?php
declare(strict_types = 1);

include '../config.php';

$assets_path = getAssetsPath();
$names = getNames();

// Отримуємо параметри через GET
if (isset($_GET['t'])) {
    $t = $_GET['t'];
} else {
    $t = '[]';
}
$t = json_decode($t);

// Групи об'єктів
// $names['activities'] = ['football', 'going-to-school', 'sleep', 'walking-with-dog'];
// $names['animals'] = ['bird', 'cat', 'dino', 'dog', 'duck', 'fish'];
// $names['cars'] = ['car-front', 'racing-car-blue', 'racing-car-green', 'racing-car-purple', 'racing-car-red', 'racing-car-yellow', 'simple-car-blue', 'simple-car-green', 'simple-car-purple', 'simple-car-red', 'simple-car-yellow'];
// $names['coins'] = ['dime-back', 'dime-front', 'half-back', 'half-front', 'nickel-back', 'nickel-front', 'penny-back', 'penny-front', 'quarter-back', 'quarter-front'];
// $names['fruits-vegetables'] = ['apple', 'apricot', 'banana', 'broccoli', 'carrot', 'grape', 'kiwi', 'lemon', 'orange', 'pear', 'strawberry', 'tomato'];
// $names['heavy'] = ['anchor', 'barrel', 'dumbbell', 'luggage', 'safe', 'toolbox', 'truck-front', 'weight'];
// $names['items'] = ['ball-beach', 'ball-blue', 'ball-green', 'ball-red', 'ball-yellow', 'balloon', 'block', 'book', 'box', 'clay', 'desk', 'dumbbell', 'evergreen-tree', 'feather', 'flat', 'flower', 'house', 'mountain', 'palmtree', 'paper', 'pencil', 'rubber', 'ruler', 'scale', 'smartphone', 'star', 'string', 'tree'];
// $names['light'] = ['balloon', 'clip', 'feather', 'flower', 'leaf', 'needle', 'paper', 'snowflake'];
// $names['shapes-filled'] = ['circle-background', 'circle', 'hexagon', 'octagon', 'parallelogram', 'pentagon', 'quadrilateral', 'rectangle', 'rhombus', 'right-triangle', 'short-isosceles-triangle', 'square', 'trapezoid', 'triangle'];
// $names['shapes-oulined'] = ['circle', 'hexagon', 'octagon', 'parallelogram', 'pentagon', 'quadrilateral', 'rectangle', 'rhombus', 'right-triangle', 'short-isosceles-triangle', 'square', 'trapezoid', 'triangle'];
// $names['shapes-phisical'] = ['circle', 'rectangle', 'square', 'triangle'];
// $names['short'] = ['book', 'bucket', 'bush', 'cup', 'grass', 'rubber', 'stem-flower', 'toy'];
// $names['sweets'] = ['cake', 'candy', 'cookie'];
// $names['tall'] = ['crane', 'giraffe', 'lighthouse', 'mountain', 'roller-coaster', 'skyscrapers', 'tree', 'water-tower'];

// Функція для знаходження групи об'єктів
function find_object_group($obj, $names) {
    foreach ($names as $group => $objects) {
        if (in_array($obj, $objects)) {
            return $group; // Повертаємо назву групи, якщо об'єкт знайдений
        }
    }
    return null; // Повертаємо null, якщо об'єкт не знайдено
}

// Розміри зображення
$inner_size = 560;
$back = imagecreatetruecolor($inner_size, $inner_size);

// Заливаємо фон кольором #F4F7F8 (RGB: 244, 247, 248)
$background_color = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $background_color);

// Якщо в нас є об'єкти
if (count($t) > 0) {
    $object_name = $t[0]; // беремо перший об'єкт
    $object_group = findGroupName($object_name); // знаходимо його групу
    $str = $assets_path . "/images/flat440/{$object_group}/{$object_name}.png"; // формуємо шлях до зображення
    
    // Завантажуємо зображення
    $object = imagecreatefrompng($str);
    
    // Отримуємо розміри зображення
    $object_width = imagesx($object);
    $object_height = imagesy($object);
    
    // Вираховуємо координати для центрування
    $x = ($inner_size - $object_width) / 2; // X координата
    $y = ($inner_size - $object_height) / 2; // Y координата

    // Копіюємо зображення по центру
    imagecopyresampled($back, $object, $x, $y, 0, 0, $object_width, $object_height, $object_width, $object_height);
}


header("Content-type: image/png");
// Виводимо зображення
imagepng($back);
imagedestroy($back);
?>
