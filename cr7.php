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
 $query = 'SELECT * FROM dev_mee';	
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     $query = 'UPDATE field SET id2=\''.$ui[1].'\' WHERE type=2 AND flat='.$ui[8];
     echo $query.'<br>';
     $r = mysql_query ($query,$i);  
     $ui = mysql_fetch_row ($e);
    }
 $query = 'SELECT * FROM dev_2ip';	
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     $query = 'UPDATE field SET id1=\''.$ui[1].'\' WHERE type=2 AND flat='.$ui[6];
     echo $query.'<br>';
     $r = mysql_query ($query,$i);  
     $ui = mysql_fetch_row ($e);
    }

?>
</td></tr>
</table>
</body>
</html>
