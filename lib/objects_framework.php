<?php
require("../lib/objects_names.php");

print_r($names);

echo("<br>");
echo(find_object_group("banana",$names));


// Шукаємо категорію елемента
echo("<br>");
echo(find_object_group("banana",$names));

// Видаємо перелік елементів
echo("<br>");
$list = category_list("fruits", $names);
print_r($list);

// Існування файлу

echo("<br>");
$path = '../../images/flat48/fruits/apple.png';
echo(file_exists($path));
if (file_exists($path)){echo "Yes";} else {echo "No";}
echo("<br>-->");
$path = '../../images/flat48/fruits/apple1.png';
if (file_exists($path)){echo "Yes";} else {echo "No";}
?>