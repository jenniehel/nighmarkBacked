<?php
 
$sql="SELECT * FROM custom WHERE custom_id=50";
$result = $conn->query($sql); 
 //查詢結果
 if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
   $img=$row["bookImage"];
   $logodata = $img;
   echo '<img src="data:'.$row['imgType'].';base64,' . $logodata . '" />';
  }
 }
 else{

 }
 echo $img;


?>
