<?php
   $host        = "host = localhost";
   $port        = "port = 5432";
   $dbname      = "dbname = timetable";
   $credentials = "user = postgres password=1221";

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db) {
      echo "Error : Unable to open database<br>";
   } 
?>