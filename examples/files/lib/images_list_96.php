<?php
declare(strict_types = 1);

include '../config.php';

// !!! Service elements
// !!! Add to the list!
// $assets_path = getAssetsPath()."images/flat96/shapes-elements";


// $dir    = '../../images/flat96/fruits-vegetables/';
// $files1 = scandir($dir);
// $files2 = scandir($dir, SCANDIR_SORT_DESCENDING);

$dir    = getAssetsPath().'/images/flat96/';
$files1 = scandir($dir);
$files2 = scandir($dir, SCANDIR_SORT_DESCENDING);

echo("\$categories=[");
for($i=2;$i<count($files1);$i+=1){
    if ($i<count($files1)-1){
        echo("'".$files1[$i]."',");
    }else{
        echo("'".$files1[$i]."'");
    }
}
echo("];<br>");

for($i=2;$i<count($files1);$i+=1){
    echo("'".$files1[$i]."'=>["); 

    $dir    = getAssetsPath().'/images/flat96/'.$files1[$i].'/';
    $files_dir = scandir($dir);
    for($j=2;$j<count($files_dir);$j+=1){
        $name = explode(".", $files_dir[$j]);
        if ($j<(count($files_dir)-1)){
            echo("'".$name[0]."',");
        } else {
            echo("'".$name[0]."'");
        }

    }
    echo("],");
    echo("<br>");
}





?>