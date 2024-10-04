<?php
header("Content-type: image/png");

$assets_path = "../../assets";

// Массиви з групами
$names['activities'] = ['football', 'going-to-school', 'walking-with-dog'];
$names['animals'] = ['bird', 'cat', 'dino', 'dog', 'duck', 'fish'];
$names['balls'] = ['ball-blue', 'ball-green', 'ball-red', 'ball-yellow'];
$names['fruits-vegetables'] = ['apple', 'apricot', 'banana', 'broccoli', 'carrot', 'grape', 'kiwi', 'lemon', 'orange', 'pear', 'strawberry', 'tomato'];
$names['items'] = ['ball-beach', 'baloon', 'block', 'book', 'box', 'clay', 'dumbell', 'feather', 'flat', 'flower', 'house', 'mountain', 'paper', 'pencil', 'rubber', 'ruler', 'smartphone', 'star', 'string'];
$names['sweets'] = ['cake', 'candy', 'cookie'];
$names['vehicles'] = ['car-front', 'racing-car-blue', 'racing-car-green', 'racing-car-purple', 'racing-car-red', 'racing-car-yellow', 'simple-car-blue', 'simple-car-green', 'simple-car-purple', 'simple-car-red', 'simple-car-yellow'];
$names['shapes'] = ['circle', 'hexagon', 'octagon', 'parallelogram', 'pentagon', 'rectangle', 'rhombus', 'square', 'trapezoid', 'triangle'];

// Отримання параметра t
$t = isset($_GET['t']) ? json_decode($_GET['t']) : [];

// Витягуємо параметри з перевіркою
$diff = isset($t[0]) ? (int)$t[0] : 0; // Кількість об'єктів без хрестиків
$sub = isset($t[1]) ? (int)$t[1] : 1;  // Загальна кількість об'єктів
$image_name = isset($t[2]) ? $t[2] : 'orange'; // Назва зображення, за замовчуванням 'orange'

// Функція для пошуку групи за назвою зображення
function find_group_name($image_name, $names) {
    foreach ($names as $group => $items) {
        if (in_array($image_name, $items)) {
            return $group; // Повертаємо назву групи, якщо зображення знайдено
        }
    }
    return null; // Повертаємо null, якщо зображення не знайдено
}

// Визначаємо групу на основі назви зображення
$group_name = find_group_name($image_name, $names);

// Перевірка, чи знайдено групу
if (!$group_name) {
    die("Зображення не знайдено в жодній групі: $image_name");
}

// Обмеження значень
$diff = max(0, min($diff, 9)); // обмежуємо від 0 до 9
$sub = max(1, min($sub, 9)); // мінімум 1 об'єкт, максимум 9

// Переконуємося, що $diff не більше ніж $sub
$diff = min($diff, $sub);

// Створюємо зображення розміром 600x100
$width = 560;
$height = 112;
$back = imagecreatetruecolor($width, $height);

// Встановлюємо кольори
$white = imagecolorallocate($back, 255, 255, 255); // Білий
$light_gray = imagecolorallocate($back, 244, 247, 248); // Світло-сірий

// Заповнюємо фон світло-сірим кольором
imagefill($back, 0, 0, $light_gray);

// Функція для завантаження зображення об'єкта або дефолтного 'orange'
function load_item_image($group_name, $image_name) {
    global $assets_path;
    $item_image_path = $assets_path."/images/flat96/{$group_name}/{$image_name}.png"; // Шлях до зображення
    if (file_exists($item_image_path)) {
        return imagecreatefrompng($item_image_path); // Завантажуємо зображення об'єкта
    } else {
        // Якщо зображення не знайдено, завантажуємо дефолтне зображення 'orange' з групи 'fruits'
        $default_image_path = $assets_path."/images/flat96/fruits-vegetables/orange.png";
        if (file_exists($default_image_path)) {
            return imagecreatefrompng($default_image_path); // Завантажуємо дефолтне зображення
        } else {
            die("Дефолтне зображення не знайдено: $default_image_path");
        }
    }
}

// Завантажуємо зображення об'єкта
$item = load_item_image($group_name, $image_name);
$delete_img = imagecreatefrompng($assets_path."/images/flat96/delete/delete.png"); // Завантажуємо зображення хрестика

// Визначаємо гап (відстань) між об'єктами
$gap = 11.5; 

// Отримуємо оригінальні розміри об'єкта
$original_item_width = imagesx($item);
$original_item_height = imagesy($item);

// $original_item_width = 48;
// $original_item_height = 48;



// Обчислюємо доступну ширину для об'єктів
$available_width = $width - 2 * 35;

// Обчислюємо масштаб для збереження пропорцій
$scale = min($available_width / $sub / $original_item_width, $height / 2 / $original_item_height);

// Обчислюємо нові розміри зображення об'єкта
// $object_width = $original_item_width;
// $object_height = $original_item_height;

$object_width = 48;
$object_height = 48;

// Позиції для кожного об'єкта
$x_offset = ($width - ($sub * $object_width + ($sub - 1) * $gap)) / 2; // Центруємо по горизонталі
$y_offset = ($height - $object_height) / 2; // Центруємо по вертикалі

// Малюємо об'єкти з перекресленими та без
for ($i = 0; $i < $sub; $i++) {
    // Вибір: об'єкт з хрестиком або без
    $has_delete = ($i >= $diff); // Якщо індекс >= diff, тоді об'єкт з хрестиком

    // Позиція для кожного об'єкта
    $x = $x_offset + $i * ($object_width + $gap); // Визначаємо X-позицію
    $y = $y_offset; // Центруємо по вертикалі

    // Малюємо об'єкт
    imagecopyresampled($back, $item, $x, $y, 0, 0, $object_width, $object_height, $original_item_width, $original_item_height);

    // Якщо є хрестик, малюємо його поверх об'єкта
    if ($has_delete) {
        imagecopyresampled($back, $delete_img, $x, $y, 0, 0, $object_width, $object_height, imagesx($delete_img), imagesy($delete_img));
    }
}

// Виводимо зображення
imagepng($back);

// Звільняємо пам'ять
imagedestroy($back);
imagedestroy($item);
imagedestroy($delete_img);
?>
