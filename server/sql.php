<?php
   $db = new SQLite3("sol.db");
   $output_data = [];
   $sql= "SELECT * FROM  group_tags WHERE 1";
   $res = $db->query($sql);

   while($row = $res->fetchArray(SQLITE3_ASSOC)){
      $sql_tags= "SELECT * FROM  tags WHERE group_id='".$row['id']."'";
      $res_tags = $db->query($sql_tags);

      $tags=[];
      while($row_tags = $res_tags->fetchArray(SQLITE3_ASSOC)){
         array_push($tags, $row_tags);
      }
      //array_push($row, $tags);
      $row['tags'] = $tags;
      echo "<pre>";
      print_r($row);
      echo "</pre>";
      array_push($output_data, $row);
    }

   echo  json_encode(['data' => $output_data]); 
   $db->close();
?>