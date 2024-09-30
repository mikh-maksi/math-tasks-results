<?php
$names = ['apple','apricot','banana','broccoli','carrot','grape','kiwi','lemon','orange','pear','strawberry','tomato'];


$objects = [];
$objects_name = [];

for($i=0;$i<count($names);$i+=1){
    $elemet = imagecreatefrompng("../../images/flat128/".$names[$i].".png");
    array_push($objects,$elemet);
    $objects_name[$names[$i]]=$elemet;
}

