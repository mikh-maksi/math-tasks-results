<?php
header("Content-type: image/png");

require("../lib/objects_names.php");

$categories=['activities','animals','cars','coins','fruits-vegetables','heavy','items','light','shapes-colored','shapes-oulined','shapes-phisical','short','sweets','tall'];
$names['activities']=['football','going-to-school','sleep','walking-with-dog'];
$names['animals']=['bird','cat','dino','dog','duck','fish'];
$names['cars']=['car-front','racing-car-blue','racing-car-green','racing-car-purple','racing-car-red','racing-car-yellow','simple-car-blue','simple-car-green','simple-car-purple','simple-car-red','simple-car-yellow'];
$names['coins']=['dime-back','dime-front','half-back','half-front','nickel-back','nickel-front','penny-back','penny-front','quarter-back','quarter-front'];
$names['fruits-vegetables']=['apple','apricot','banana','broccoli','carrot','grape','kiwi','lemon','orange','pear','strawberry','tomato'];
$names['heavy']=['anchor','barrel','dumbbell','luggage','safe','toolbox','truck-front','weight'];
$names['items']=['ball-beach','ball-blue','ball-green','ball-red','ball-yellow','balloon','block','book','box','clay','desk','dumbbell','evergreen-tree','feather','flat','flower','house','mountain','palmtree','paper','pencil','rubber','ruler','scale','smartphone','star','string','tree'];
$names['light']=['balloon','clip','feather','flower','leaf','needle','paper','snowflake'];
$names['shapes-colored']=['circle-background','circle','hexagon','octagon','parallelogram','pentagon','quadrilateral','rectangle','rhombus','right-triangle','short-isosceles-triangle','square','trapezoid','triangle'];
$names['shapes-oulined']=['circle','hexagon','octagon','parallelogram','pentagon','quadrilateral','rectangle','rhombus','right-triangle','short-isosceles-triangle','square','trapezoid','triangle'];
$names['shapes-phisical']=['circle','rectangle','square','triangle'];
$names['short']=['book','bucket','bush','cup','grass','rubber','stem-flower','toy'];
$names['sweets']=['cake','candy','cookie'];
$names['tall']=['crane','giraffe','lighthouse','mountain','roller-coaster','skyscrapers','tree','water-tower'];



$font_file = '../../Inter.ttf';

$width = 1600;
$height = 900;

$back = imagecreatetruecolor($width, $height);
$gray = imagecolorallocate($back, 244, 247, 248);
imagefill($back, 0, 0, $gray);
$black = imagecolorallocate($back, 0, 0, 0);


$objectX = 0;
$objectY = 0;

$object_image_path = '../../images/flat440/coins/dime-back.png';
$objectX = 0;
$objectY = 0;

$objectWidth = 440;
$objectHeight = 440;

$newwidth = 48;
$newheight = 48;
$object_image = imagecreatefrompng($object_image_path);



// imagecopyresized($back, $object_image, $objectX, $objectY, 0, 0, $newwidth, $newheight, $objectWidth, $objectHeight);
// imagecopyresized($back, $object_image, $objectX+50, $objectY, 0, 0, $newwidth, $newheight, $objectWidth, $objectHeight);


// $object_image = imagecreatefrompng($object_image_path);
// imagecopy($back, $object_image, $objectX, $objectY, 0, 0, $objectWidth, $objectHeight);
$i = 0;
$j = 0;
$value_img = 'text';
// imagefttext($back, 8, 0, 37 +125*$i, 72+35*$j, $black, $font_file, $value_img);

// $categories=['activities','animals','cars','coins','fruits-vegetables','heavy','items','light','shapes','short','sweets','tall'];
for($j=0;$j<count($categories);$j+=1){
    // echo($categories[$j]);
}

for($j=0;$j<count($categories);$j+=1){
    $category = $categories[$j];
    imagefttext($back, 12, 0, 10, 30+70*$j, $black, $font_file, $category);
for($i=0;$i<count($names[$category]);$i+=1){

    $object_image_path = '../../images/flat440/'.$category.'/'.$names[$category][$i].'.png';
    // echo($object_image_path);
    // echo("<br>");

    $value_img = $names[$category][$i];
    // $object_image_path = '../../images/flat440/coins/dime-back.png';
  
    $object_image = imagecreatefrompng($object_image_path);
    imagecopyresized($back, $object_image, 150+$objectX+50*$i, $objectY+70*$j, 0, 0, $newwidth, $newheight, $objectWidth, $objectHeight);
    imagefttext($back, 6, 0, 150 +50*$i, 60+70*$j, $black, $font_file, $value_img);
  
  
    // echo($object_image_path."<br>" );
    // $object_image = imagecreatefrompng($object_image_path);
    // imagecopy($back, $object_image, $objectX+48*$j, $objectY, 0, 0, $objectWidth, $objectHeight); 
}
}

imagepng($back);
imagedestroy($back);
?>