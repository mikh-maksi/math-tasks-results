<?php
$categories=['activities','animals','cars','coins','fruits-vegetables','heavy','items','light','shapes-filled','shapes-oulined','shapes-phisical','short','sweets','tall'];

$names = [];
$names['activities']=['football','going-to-school','sleep','walking-with-dog'];
$names['animals']=['bird','cat','dino','dog','duck','fish'];
$names['cars']=['car-front','racing-car-blue','racing-car-green','racing-car-purple','racing-car-red','racing-car-yellow','simple-car-blue','simple-car-green','simple-car-purple','simple-car-red','simple-car-yellow'];
$names['coins']=['dime-back','dime-front','half-back','half-front','nickel-back','nickel-front','penny-back','penny-front','quarter-back','quarter-front'];
$names['fruits-vegetables']=['apple','apricot','banana','broccoli','carrot','grape','kiwi','lemon','orange','pear','strawberry','tomato'];
$names['heavy']=['anchor','barrel','dumbbell','luggage','safe','toolbox','truck-front','weight'];
$names['items']=['ball-beach','ball-blue','ball-green','ball-red','ball-yellow','balloon','block','book','box','clay','desk','dumbbell','evergreen-tree','feather','flat','flower','house','mountain','palmtree','paper','pencil','rubber','ruler','scale','smartphone','star','string','tree'];
$names['light']=['balloon','clip','feather','flower','leaf','needle','paper','snowflake'];
$names['shapes-filled']=['circle-background','circle','hexagon','octagon','parallelogram','pentagon','quadrilateral','rectangle','rhombus','right-triangle','short-isosceles-triangle','square','trapezoid','triangle'];
$names['shapes-oulined']=['circle','hexagon','octagon','parallelogram','pentagon','quadrilateral','rectangle','rhombus','right-triangle','short-isosceles-triangle','square','trapezoid','triangle'];
$names['shapes-phisical']=['circle','rectangle','square','triangle'];
$names['short']=['book','bucket','bush','cup','grass','rubber','stem-flower','toy'];
$names['sweets']=['cake','candy','cookie'];
$names['tall']=['crane','giraffe','lighthouse','mountain','roller-coaster','skyscrapers','tree','water-tower'];

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