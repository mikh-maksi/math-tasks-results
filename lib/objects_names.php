<?php
$names = [];
$names['activities'] = ['football','going-to-school','walking-with-dog'];
$names['animals'] = ['bird','cat','dino','dog','duck','fish'];
$names['balls'] = ['ball-blue','ball-green','ball-red','ball-yellow'];
$names['fruits'] = ['apple','apricot','banana','broccoli','carrot','grape','kiwi','lemon','orange','pear','strawberry','tomato'];
$names['items'] = ['ball-beach','baloon','block','book','box','clay','dumbell','feather','flat','flower','house','mountain','paper','pencil','rubber','ruler','smartphone','star','string'];
$names['sweets'] = ['cake','candy','cookie'];
$names['vehicles'] = ['car-front','racing-car-blue','racing-car-green','racing-car-purple','racing-car-red','racing-car-yellow','simple-car-blue','simple-car-green','simple-car-purple','simple-car-red','simple-car-yellow'];
$names['shapes'] = ['circle','hexagon','octagon','parallelogram','pentagon','rectangle','rhombus','square','trapezoid','triangle'];
$names['light'] = ["baloon", "clip", "feather", "flower", "leaf", "needle", "paper", "snowflake"];
$names['heavy'] = ["anchor", "barrel", "dumbell", "luggage", "safe", "toolbox", "truck-front", "weight"];
$names['tall'] = ["crane", "giraffe", "lighthouse", "mountain", "roller-coaster", "skyscrapers", "tree", "water-tower"];
$names['short'] = ["book", "bucket", "bush", "cup", "grass", "rubber", "stem-flower", "toy"];
$names['coins'] = ["dime-back", "dime-front", "half-back", "half-front", "nickel-back", "nickel-front", "penny-back", "penny-front", "quarter-back", "quarter-front"];

// Функція для пошуку групи по об'єкту
function find_object_group($obj, $names) {
    foreach ($names as $group => $objects) {
        if (in_array($obj, $objects)) {
            return $group; // Повертаємо назву групи, якщо об'єкт знайдений
        }
    }
    return null; // Повертаємо null, якщо об'єкт не знайдено
}


function category_list($category, $names){
    $fruitsArrayObject = new ArrayObject($names[$category]);
    $list_out = $fruitsArrayObject->getArrayCopy();    
    return $list_out;
}


?>