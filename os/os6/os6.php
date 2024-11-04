<?php
header("Content-type: image/png");

$assets_path = "../../assets";

if (isset($_GET['t'])){$t = $_GET['t'];}else{$t='[]';}
$t = json_decode($_GET['t']);



$number = $t[0];
$object_name = $t[1];
$type_line = $t[2];

$type_lines = ["Horisontal line","Vertical line","Main diagonal","Secondary diagonal"];


$n_type = 0;
if (in_array($type_line,$type_lines)){
    for ($i=0;$i<count($type_lines);$i+=1){
        if ($type_lines[$i] == $type_line ){
            $n_type = $i; 
            break;
        }
    }
}

$n_type = random_int(0,3);

$canvas_width = 560;
$canvas_height = 280;
$back = imagecreatetruecolor($canvas_width, $canvas_height);

// Заливаємо фон сірого квадрата кольором #F4F7F8 (RGB: 244, 247, 248)
$background_color = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $background_color);


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

$object_group = find_object_group($object_name, $names);

// require("../lib/objects.php");


$black = imagecolorallocate($back, 0, 0, 0);

$circle_color = imagecolorallocate($back, 229, 236, 240); // Колір #E5ECF0
$font_file = $assets_path.'/fonts/Inter.ttf';

imageline($back,300,0,300,300,$circle_color );


// imagefttext($back, 48, 0, 150-24, 300-1, $black, $font_file, 'A');
// imagefttext($back, 48, 0, 450-24, 300-1, $black, $font_file, 'B');

imageline($back,300,0,300,600, $circle_color);
// imageline($back,0,250,600,250, $black);

$x_start = 5;
$y_start = 5;

$values = [6,12,0,3];
$col = 9;

    // $value = $t[0];

    // $object = $objects[$t[1]];

    $object = imagecreatefrompng($assets_path ."/images/flat96/{$object_group}/{$object_name}.png");

    for($m=0;$m<2;$m+=1){
    $jj = $m%2;
    $ii = intdiv($m,2);
    $value = $number;
   
    for ($k=0;$k<$value;$k+=1){

            $j = $k%$col;
            $i = intdiv($k,$col);
            imagecopyresampled($back , $object,$x_start+30*$j+300+((7-$number)/2*35)+30, $y_start+60*$i+105, 0, 0, 35, 35, 96, 96);

        if ($n_type==0){
            $j = $k%$col;
            $i = intdiv($k,$col);
            imagecopyresampled($back , $object,$x_start+30*$j, $y_start+60*$i, 0, 0, 35, 35, 96, 96);
        }
        if ($n_type==1){
            $i = $k%$col;
            $j = intdiv($k,$col);
            imagecopyresampled($back , $object,$x_start+30*$j+125, $y_start+35*$i, 0, 0, 35, 35, 96, 96);
        }        
        if ($n_type==2){
            $i = $k;
            $j = $k;
            imagecopyresampled($back , $object,$x_start+35*$j+20+((7-$number)/2*35), $y_start+35*$i+((7-$number)/2*35), 0, 0, 35, 35, 96, 96);
        }
        if ($n_type==3){
            $i = $k;
            $j = $number-$k+1;
            imagecopyresampled($back , $object,$x_start+35*$j-50+((7-$number)/2*35), $y_start+35*$i+((7-$number)/2*35), 0, 0, 35, 35, 96, 96);
        }
    }

 
    }


imagepng($back);
imagedestroy($back);

?>