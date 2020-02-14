<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');


$db = new SQLite3("sol.db");
$output_data = [];
$sql= "SELECT * FROM  solutions WHERE 1";
$res = $db->query($sql);

$solutions_arr=[];

while($row = $res->fetchArray(SQLITE3_ASSOC)){
   array_push($solutions_arr, $row);
 }

echo  json_encode(['solutions' => $solutions_arr]); 
$db->close();

?>