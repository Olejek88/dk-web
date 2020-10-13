<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>abonet report for day/month</title>
	<?php
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 
	 $query = 'SELECT * FROM tmp_temp';
	 $a = mysql_query ($query,$i);  
	 if ($a) $uy = mysql_fetch_row ($a);
	 while ($uy) 
		 { 
	          //$query = 'INSERT INTO data (type, date, value, flat, source, prm) VALUE (\'2\',\''.$uy[0][0].$uy[0][1].$uy[0][2].$uy[0][3].$uy[0][5].$uy[0][6].$uy[0][8].$uy[0][9].'000000\',\''.$uy[1].'\',\'0\',\'10\',\'4\')';
		  $uy[0][12]='0'; 
		  $query = 'INSERT INTO data (type, date, value, flat, source, prm) VALUE (\'2\',\''.$uy[0].'\',\''.$uy[1].'\',\'0\',\'10\',\'4\')';
		  echo $query.'<br>';
		  $r = mysql_query ($query,$i);  
		  $uy = mysql_fetch_row ($a);
	         }
	 ?>

</td></tr>
</table>
</body>
</html>
