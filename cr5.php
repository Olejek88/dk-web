<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = 'SELECT * FROM dev_bit';	
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     $idd=$ui[1]; $adr=$ui[4]; $st=$ui[9]; $fl=$ui[8]; 

	 $query = 'SELECT * FROM device WHERE idd='.$idd;	
	 $r = mysql_query ($query,$i);
	 echo $query.'<br>';
	 if ($r) $uy = mysql_fetch_row ($r);
	 if (!$uy)
	    { 
	     $query = 'INSERT INTO device(idd,interface,protocol,port,speed,adr,type,flat,source,name) 
	     VALUES ('.$idd.',3,2,0,0,'.$adr.',1,'.$fl.',1,\'BIT (flat='.$fl.',str='.$st.')\')';
	     echo $query.'<br>';
     	     $r = mysql_query ($query,$i);  
	     //$query = 'UPDATE dev_bit SET device=device+16777216 WHERE id='.$ui[0];
	     //echo $query.'<br>';
     	     //$r = mysql_query ($query,$i);  
	    }
     $ui = mysql_fetch_row ($e);
    }
?>
</td></tr>
</table>
</body>
</html>
