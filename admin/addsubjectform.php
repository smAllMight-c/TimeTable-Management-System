<?php

include 'connection.php';
if (isset($_POST['SC']) && isset($_POST['SN']) && isset($_POST['SEM']) && isset($_POST['TDP'])) {
    $sname = $_POST['SN'];
    $subcode = $_POST['SC'];
    $sem = $_POST['SEM'];
    $department = $_POST['TDP'];
  
} else {

    die();
}


  
$sql="select did from department where name='$department'"; 


$ret = pg_query($db, $sql);
if(!$ret) {
   echo pg_last_error($db);
} else {
    $id =pg_fetch_row($ret);
  
}


$sql="insert into subjects values  ('$subcode','$sname','$sem',$id[0])";



$ret = pg_query($db, $sql);
if(!$ret) {
   echo pg_last_error($db);
} else {
    
       
        header("Location:course.php");
    
  
}


pg_close($db);

?>