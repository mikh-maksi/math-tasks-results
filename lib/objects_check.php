<?php
$categories=['activities','animals','cars','coins','fruits-vegetables','heavy','items','light','shapes-filled','shapes-oulined','shapes-phisical','short','sweets','tall'];
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


$categories=['activities','animals','cars','coins','fruits-vegetables','heavy','items','light','shapes-filled','shapes-oulined','shapes-phisical','short','sweets','tall'];
$names1['activities']=['football','going-to-school','sleep','walking-with-dog'];
$names1['animals']=['bird','cat','dino','dog','duck','fish'];
$names1['cars']=['car-front','racing-car-blue','racing-car-green','racing-car-purple','racing-car-red','racing-car-yellow','simple-car-blue','simple-car-green','simple-car-purple','simple-car-red','simple-car-yellow'];
$names1['coins']=['dime-back','dime-front','half-back','half-front','nickel-back','nickel-front','penny-back','penny-front','quarter-back','quarter-front'];
$names1['fruits-vegetables']=['apple','apricot','banana','broccoli','carrot','grape','kiwi','lemon','orange','pear','strawberry','tomato'];
$names1['heavy']=['anchor','barrel','dumbbell','luggage','safe','toolbox','truck-front','weight'];
$names1['items']=['ball-beach','ball-blue','ball-green','ball-red','ball-yellow','balloon','block','book','box','clay','desk','dumbbell','evergreen-tree','feather','flat','flower','house','mountain','palmtree','paper','pencil','rubber','ruler','scale','smartphone','star','string','tree'];
$names1['light']=['balloon','clip','feather','flower','leaf','needle','paper','snowflake'];
$names1['shapes-filled']=['circle-background','circle','hexagon','octagon','parallelogram','pentagon','quadrilateral','rectangle','rhombus','right-triangle','short-isosceles-triangle','square','trapezoid','triangle'];
$names1['shapes-oulined']=['circle','hexagon','octagon','parallelogram','pentagon','quadrilateral','rectangle','rhombus','right-triangle','short-isosceles-triangle','square','trapezoid','triangle'];
$names1['shapes-phisical']=['circle','rectangle','square','triangle'];
$names1['short']=['book','bucket','bush','cup','grass','rubber','stem-flower','toy'];
$names1['sweets']=['cake','candy','cookie'];
$names1['tall']=['crane','giraffe','lighthouse','mountain','roller-coaster','skyscrapers','tree','water-tower'];


for($i=0;$i<count($categories);$i+=1){
    $category = $categories[$i];
    for($j=0;$j<count($names[$category]);$j+=1){
        if ($names[$category][$j] != $names1[$category][$j]){
            echo( $category ."<br>");
            echo ($names[$category][$j]." ");
            echo ($names1[$category][$j]);
            echo("<br>");
        }

    }
}
?>