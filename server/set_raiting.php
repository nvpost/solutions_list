<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');

$input_data=json_decode(file_get_contents("php://input"), true);

$db = new SQLite3("sol.db");

$sql = "SELECT rating FROM solutions WHERE `id`= '".$input_data['n']."'";
$res = $db->query($sql)->fetchArray(SQLITE3_ASSOC);

$r = '';
if($res['rating']=='null'||$res['rating']==''){
    $r = $input_data['w']=='plus'? '1/0': '0/1';
}
else{
    $rating_arr=explode('/', $res['rating']);
    $input_data['w']=='plus'?$rating_arr[0]=$rating_arr[0]+1 : $rating_arr[1]=$rating_arr[1]+1;

    $r=implode('/', $rating_arr);

}




$sql = "UPDATE solutions SET `rating` =  '".$r."' WHERE `id`= '".$input_data['n']."'";
$sql_add = $db->exec($sql);

$db->close();

echo json_encode(['data' => $input_data, 'res'=>$res, 'r'=>$r,'rating_arr' => $rating_arr]);

?>