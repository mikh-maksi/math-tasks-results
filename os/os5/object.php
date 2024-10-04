<?php
header("Content-type: image/png");
if (isset($_GET['t'])){$t = $_GET['t'];}else{$t='[]';}
$t = json_decode($_GET['t']);


if (count($t)>=3){$back = imagecreatefromjpeg ("../../images/canvas.jpg");}
// 2
if (count($t)==2){$back = imagecreatefromjpeg ("../../images/canvas300_600.jpg");}
// 1
if (count($t)==1){$back = imagecreatefromjpeg ("../../images/canvas300.jpg");}



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
    $str = "../../images/img256/".$t[$k].".png";
    $object = imagecreatefrompng($str);
    imagecopyresampled($back,$object  ,     300*$j+23, 300*$i+23 ,0  , 0, 256, 256, 256, 256);
}

imageline($back,300,0,300,600, $black);
imageline($back,0,300,600,300, $black);

imagepng($back);
imagedestroy($back);

?>