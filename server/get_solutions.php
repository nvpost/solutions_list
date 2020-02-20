<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');

$input_data=json_decode(file_get_contents("php://input"), true);

$db = new SQLite3("sol.db");
$output_data = [];
$solutions_arr=[];



// $where="";
if($input_data['tags']){


$required_ids=[];    
    $i_tags = $input_data['tags'];
    $sql = "SELECT id, tags FROM solutions WHERE 1";
    $res = $db->query($sql);


    while($row = $res->fetchArray(SQLITE3_ASSOC)){
        $tags = explode(' ', $row['tags']);
        array_unshift($tags, 'aa');
        $overlap=0;
        //print_r($tags);
        foreach($i_tags as $n){
            // echo "<br>".$n."<br>";
            // echo array_search($n, $tags);
            if(array_search($n, $tags)>0){
                $overlap++;
            }
        }
        //echo "<br>".$overlap."<br>";
        if(count($i_tags) == $overlap){
            //echo "<hr>"."Показываем решение с ".$row['id']."<hr>";
            array_push($required_ids, $row['id']);
        }
     }
     //print_r(implode(',',$required_ids));

     $sql= "SELECT * FROM  solutions WHERE `id` in (".implode(',',$required_ids).") ";
     $res = $db->query($sql);
     
     while($row = $res->fetchArray(SQLITE3_ASSOC)){
        array_push($solutions_arr, $row);
     }


}



else{
    $sql= "SELECT * FROM  solutions WHERE 1";
    $res = $db->query($sql);
    
    while($row = $res->fetchArray(SQLITE3_ASSOC)){
       array_push($solutions_arr, $row);
    }
}


// function check_tags(){

// }


echo  json_encode(['solutions' => $solutions_arr, 'data'=>$input_data['tags']]); 
$db->close();

?>