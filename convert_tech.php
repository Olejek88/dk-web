<?php
 include("config/local5.php");
 $i = mysql_connect ($mysql_host_srv,$mysql_user_srv,$mysql_password_srv); $e=mysql_select_db ($mysql_db_name_srv);
 $query = "set character_set_client='utf8'"; mysql_query ($query,$i);
 $query = "set character_set_results='utf8'"; mysql_query ($query,$i);
 $query = "set collation_connection='utf8_general_ci'"; mysql_query ($query,$i);

// $i2 = mysql_connect ($mysql_host1,$mysql_user,$mysql_password); $e2=mysql_select_db ($mysql_db_name);
// $query = "set character_set_client='utf8'"; mysql_query ($query,$i2);
// $query = "set character_set_results='utf8'"; mysql_query ($query,$i2);
// $query = "set collation_connection='utf8_general_ci'"; mysql_query ($query,$i2);
?>
<title>Get data from Technikum</title>
<?php
 for ($obj=1; $obj<10; $obj++) {
     echo "attempt to connect to $mysql_host[$obj]".PHP_EOL;
     $i2 = mysql_connect ($mysql_host[$obj],$mysql_user,$mysql_password); 
     if (!$i2) {
          echo "\033[01;31m.failed to connect to host. \033[0m";
	  continue;
	 }
     
     $e2=mysql_select_db ("escada");
     echo $i2." ".$e2;
     //$query = "set character_set_client='utf8'"; mysql_query ($query,$i2);
     //$query = "set character_set_results='utf8'"; mysql_query ($query,$i2);
     //$query = "set collation_connection='utf8_general_ci'"; mysql_query ($query,$i2);

     $date_last_day="";
     $date_last="";
     $query = 'SELECT * FROM hours WHERE type=1 ORDER BY date DESC LIMIT 1';
     echo $query.PHP_EOL;
     if ($a = mysql_query ($query,$i2))
     if ($uy = mysql_fetch_row ($a)) {
	 $date_last=$uy[4];
	 $device=$uy[1];
	}
     echo $date_last.PHP_EOL;
     $query = 'SELECT * FROM prdata WHERE type=2 ORDER BY date DESC LIMIT 1';
     echo $query.PHP_EOL;
     if ($a = mysql_query ($query,$i2))
     if ($uy = mysql_fetch_row ($a)) 
	 $date_last_day=$uy[4];
     echo $date_last_day.PHP_EOL;

     $date=sprintf ("%s%s%s%s%s%s%s%s000000",$date_last[0],$date_last[1],$date_last[2],$date_last[3],$date_last[5],$date_last[6],$date_last[8],$date_last[9]);
     $date2=sprintf ("%s%s%s%s%s%s%s%s000000",$date_last_day[0],$date_last_day[1],$date_last_day[2],$date_last_day[3],$date_last_day[5],$date_last_day[6],$date_last_day[8],$date_last_day[9]);
     echo $date.' '.$date2.PHP_EOL;

     $query = 'SELECT * FROM hours WHERE type=1 AND date>=\''.$date_last.'\' ORDER BY date DESC LIMIT 200';
//     $query = 'SELECT * FROM hours WHERE type=1 AND date>'.$date_last.' ORDER BY date DESC LIMIT 100';
     echo $query.PHP_EOL;
     if ($a = mysql_query ($query,$i2))
     while ($uy = mysql_fetch_row ($a)) 
	{
	 $query = 'SELECT * FROM hours WHERE prm="'.$uy[2].'" AND pipe="'.$uy[7].'" AND date="'.$uy[4].'"  AND type="'.$uy[3].'" AND device="'.$device.'"';
         echo $query.PHP_EOL;
	 if ($a2 = mysql_query ($query,$i))
         if (!($uy2 = mysql_fetch_row ($a2))) 
	    {
             $query = 'INSERT INTO hours SET device="'.$uy[1].'",prm="'.$uy[2].'",type="'.$uy[3].'",date="'.$uy[4].'",value="'.$uy[5].'",status="'.$uy[6].'",pipe="'.$uy[7].'",channel="'.$uy[8].'"';
    	     echo $query.PHP_EOL;
	     mysql_query ($query,$i);
    	    }
	}

//    $query = 'SELECT * FROM prdata WHERE type>0 AND date>'.$date_last_day.' ORDER BY date DESC LIMIT 100';
    $query = 'SELECT * FROM prdata WHERE type>0 AND date>=\''.$date_last_day.'\' ORDER BY date DESC LIMIT 100';
    echo $query.'<br>';
    if ($a = mysql_query ($query,$i2))
    while ($uy = mysql_fetch_row ($a)) 
	{
         $query = 'SELECT * FROM prdata WHERE prm="'.$uy[2].'" AND pipe="'.$uy[7].'" AND date="'.$uy[4].'"  AND type="'.$uy[3].'" AND device="'.$device.'"';
         echo $query.PHP_EOL;
         if ($a2 = mysql_query ($query,$i))
         if (!($uy2 = mysql_fetch_row ($a2))) 
    	    {
             $query = 'INSERT INTO prdata SET device="'.$uy[1].'",prm="'.$uy[2].'",type="'.$uy[3].'",date="'.$uy[4].'",value="'.$uy[5].'",status="'.$uy[6].'",pipe="'.$uy[7].'",channel="'.$uy[8].'"';
             echo $query.PHP_EOL;
	     mysql_query ($query,$i);
	    }
	}

    $query = 'SELECT * FROM prdata WHERE type=0';
    echo $query.'<br>';
    if ($a = mysql_query ($query,$i2))
    while ($uy = mysql_fetch_row ($a)) 
	{
         $query = 'SELECT * FROM prdata WHERE prm="'.$uy[2].'" AND pipe="'.$uy[7].'" AND type=0 AND device="'.$device.'"';
         echo $query.PHP_EOL;
         if ($a2 = mysql_query ($query,$i))
         if (!($uy2 = mysql_fetch_row ($a2))) 
	    {
             $query = 'INSERT INTO prdata SET device="'.$uy[1].'",prm="'.$uy[2].'",type=0,value="'.$uy[5].'",status="'.$uy[6].'",pipe="'.$uy[7].'",channel="'.$uy[8].'"';
             echo $query.PHP_EOL;
	     mysql_query ($query,$i);
	    }
	else {
              $query = 'UPDATE prdata SET value="'.$uy[5].'" WHERE device="'.$uy[1].'" AND prm="'.$uy[2].'" AND type=0 AND pipe="'.$uy[7].'"';
              echo $query.PHP_EOL;
	      mysql_query ($query,$i);
	    }
	}
     mysql_close($i2);
    }
?>
