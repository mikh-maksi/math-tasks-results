<?php
header("Content-type: image/png");
if (isset($_GET['t'])){$t = $_GET['t'];}else{$t='[]';}
$t = json_decode($_GET['t']);

$assets_path = "../../assets";

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

function find_object_group($obj, $names) {
    foreach ($names as $group => $objects) {
        if (in_array($obj, $objects)) {
            return $group; // Повертаємо назву групи, якщо об'єкт знайдений
        }
    }
    return null; // Повертаємо null, якщо об'єкт не знайдено
}


$inner_size = 560;
$back = imagecreatetruecolor($inner_size, $inner_size);

// Заливаємо фон сірого квадрата кольором #F4F7F8 (RGB: 244, 247, 248)
$background_color = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $background_color);



// if (count($t)>=3){$back = imagecreatefromjpeg ("../../images/canvas.jpg");}
// // 2
// if (count($t)==2){$back = imagecreatefromjpeg ("../../images/canvas300_600.jpg");}
// // 1
// if (count($t)==1){$back = imagecreatefromjpeg ("../../images/canvas300.jpg");}



// $paper     = imagecreatefrompng("../../images/paper.png");
// $clay     = imagecreatefrompng("../../images/clay.png");
// $string     = imagecreatefrompng("../../images/string.png");
// $rubber     = imagecreatefrompng("../../images/rubber.png");
// $scale     = imagecreatefrompng("../../images/scale.png");

// $book     = imagecreatefrompng("../../images/book.png");
// $smartphone     = imagecreatefrompng("../../images/smartphone.png");

// paper,clay,string,rubber,scale,book,smartphone,redball,blueball

$col = 2;
for($k=0;$k<count($t);$k+=1){
    $j = $k%$col;
    $i = intdiv($k,$col);
    $object_name = $t[$k];
    $object_group = find_object_group($object_name, $names);
    $str = $assets_path ."/images/flat440/{$object_group}/{$object_name}.png";
    $object = imagecreatefrompng($str);
    imagecopyresampled($back,$object  ,     300*$j+23, 300*$i+23 ,0  , 0, 256, 256, 440, 440);
}

// imageline($back,300,0,300,600, $black);
// imageline($back,0,300,600,300, $black);

imagepng($back);
imagedestroy($back);

?>