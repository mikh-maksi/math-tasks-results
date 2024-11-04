<?php

declare(strict_types = 1);

include '../config.php';

$assets_path = getAssetsPath();
$names =  getNames();

if (isset($_GET['t'])) {
    $t = $_GET['t'];
} else {
    $t = '["apple","banana","banana","apple","orange","pear"]';
}

$t = json_decode($t);

$object1 = $t[0];
$object2 = $t[1];


$object_group = findGroupName($object1);

// print_r($names[$object_group]);

// echo(count($names[$object_group]));
$array = $names[$object_group];

// echo ("-----<br>");
// echo(n_element($object1,$array));

$object1_n = n_element($object1,$array);
$object2_n = n_element($object2,$array);


// echo ("-----<br>");
// print_r($array);

// echo()

$answers_list = [];
array_push($answers_list,$object1_n);
// array_push($answers_list,$object2_n);
for($i=0;$i<3;$i+=1){
do{
    $el = rand(0,count($array)-1);

}while (in_array($el,$answers_list));
array_push($answers_list,$el);
}


// echo ("-----answers_list<br>");
// print_r($answers_list);
// echo ("-----<br>");

$numbers_list = [];
for($i=0;$i<=3;$i+=1){
    do{
        $el = rand(0,3);
    
    }while (in_array($el,$numbers_list));
    array_push($numbers_list,$el);
    }
    // echo ("-----numbers_list<br>");
    // print_r($numbers_list);
    // echo ("-----<br>");  

$answers_list_place_random = [];
for($i=0;$i<=3;$i+=1){
    $n_el = $numbers_list[$i];
    $answ = $answers_list[$n_el];
    array_push($answers_list_place_random,$answ );
    }
    // echo ("-----<br>");
    // print_r($answers_list_place_random);
    // echo ("-----<br>"); 

// echo $el;


$obj1 = $array[$answers_list_place_random[0]];
$obj2 = $array[$answers_list_place_random[1]];
$obj3 = $array[$answers_list_place_random[2]];
$obj4 = $array[$answers_list_place_random[3]];


// Створення нового зображення
$width = 560; // Ширина зображення
$height = 320; // Висота зображення
$back = imagecreatetruecolor($width, $height); 

$light_gray = imagecolorallocate($back, 244, 247, 248);
$black = imagecolorallocate($back, 0, 0, 0);
$circle_color = imagecolorallocate($back, 229, 236, 240); // Колір #E5ECF0
$font_file = $assets_path.'/Inter.ttf'; // Шрифт для тексту

// Заливка фону світло-сірим кольором
imagefilledrectangle($back, 0, 0, $width, $height, $light_gray);


// Центральна лінія
imageline($back, $width / 2, 0, $width / 2, $height, $circle_color);

// 80 160 240
imageline($back, $width / 2, 80, $width , 80, $circle_color);
imageline($back, $width / 2, 160, $width , 160, $circle_color);
imageline($back, $width / 2, 240, $width , 240, $circle_color);


function letter_circle ($back,$x,$y,$text){
    $width = 560; // Ширина зображення
    $height = 320; // Висота зображення
    $circle_color = imagecolorallocate($back, 229, 236, 240); // Колір #E5ECF0
    $black = imagecolorallocate($back, 0, 0, 0);

    $assets_path = getAssetsPath();

    $font_file = $assets_path.'/Inter.ttf'; // Шрифт для тексту

    $font_size = 16;
    $circle_radius = 32;
        
    $circle_x_right = $width - $x - $circle_radius / 2; // Відступ 7 пікселів справа
    $circle_y_right = $y + $circle_radius / 2; // Відступ 7 пікселів зверху
    
    // 40 120 200 280
    
    // Кола
    imagefilledellipse($back, $circle_x_right, $circle_y_right, $circle_radius, $circle_radius, $circle_color);
    // Додавання кола з літерою В у правому верхньому куті
    
    // Відображення літери В
    // $text_B = $text;
    imagettftext($back, $font_size, 0, $circle_x_right - 7, $circle_y_right + 7, $black, $font_file, $text);

}


letter_circle($back,264,24,"A");
letter_circle($back,264,104,"B");
letter_circle($back,264,184,"C");
letter_circle($back,264,264,"D");


imagecopyresampled($back, get_image($object1), 32,160-24, 0, 0, 48, 48, 96, 96);
imagecopyresampled($back, get_image($object2), 84,160-24, 0, 0, 48, 48, 96, 96);
imagecopyresampled($back, get_image($object1), 136,160-24, 0, 0, 48, 48, 96, 96);
imagecopyresampled($back, get_image($object2), 188,160-24, 0, 0, 48, 48, 96, 96);


imagecopyresampled($back, get_image($obj1), 320,16, 0, 0, 48, 48, 96, 96);
imagecopyresampled($back, get_image($obj2), 320,96, 0, 0, 48, 48, 96, 96);
imagecopyresampled($back, get_image($obj3), 320,176, 0, 0, 48, 48, 96, 96);
imagecopyresampled($back, get_image($obj4), 320,256, 0, 0, 48, 48, 96, 96);


function n_element($object,$array){
    $object_n = -1;
    for($i=0;$i<count($array);$i+=1){
        if ($object == $array[$i]){
            $object_n = $i;
        }
    }
    return $object_n;
}


function get_image($object){
    $assets_path = getAssetsPath();
    $object_group = findGroupName($object); 
    $object_name = $object;
    $object_image_path = $assets_path."images/flat96/" . $object_group . "/" . $object_name . ".png";
    $object_image = imagecreatefrompng($object_image_path);
    return $object_image;
}


header("Content-type: image/png");

// Виведення зображення
imagepng($back);
imagedestroy($back);

?>
