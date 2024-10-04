<?php
$names = ['apple','apricot','banana','broccoli','carrot','grape','kiwi','lemon','orange','pear','strawberry','tomato'];

$assets_path = "../../assets";

$objects = [];
$objects_name = [];

for($i=0;$i<count($names);$i+=1){
    $elemet = imagecreatefrompng($assets_path ."/images/flat440/fruits-vegetables/".$names[$i].".png");
    array_push($objects,$elemet);
    $objects_name[$names[$i]]=$elemet;
}

