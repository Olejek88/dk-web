<meta http-equiv="Pragma" content="no-cache">
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=koi8r">
<link rel="stylesheet" href="shablon.css" type="text/css">
<link href="files/rcom-main.css" rel="stylesheet">
<link href="files/rcom-tabs.css" rel="stylesheet">

<title>Интерфейс доступа к данным и редактирования конфигурации</title>
<script language="JavaScript" type="text/javascript" src="view.js"></script>
</head>
<body onLoad="startShow()" leftmargin=0 topmargin=1 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table cellpadding="0" cellspacing="1" border="0" style="width:1200px" align=center>
<tr><td bgcolor=#617a94 width=100% height=15><div id="top"></div></td></tr>
<tr>
	<td width="1200px" valign=top>
	<table cellpadding="0" cellspacing="1" border="0" style="width:1200px">
    	    <tr><td width="1200px" valign=top>
		<table cellpadding="0" cellspacing="0" border="0" style="width:1200px">
		<tr>
		    <td style="width:750px">
		    <table cellpadding="0" cellspacing="0" border="0" style="width:750px">
		    <tr><td><img width=370 height=140 src="charts/xyplot.php?gr=1"></td><td><img width=370 height=140 src="charts/xyplot.php?gr=2"></td></tr>
		    <tr><td><img width=370 height=140 src="charts/xyplot.php?gr=3"></td><td><img width=370 height=140 src="charts/xyplot.php?gr=4"></td></tr>
		    </table>
		    </td>
		    <td style="width:450px" valign=top><div id="hour_report">
		    </div></td>
		</tr>
		</table>
	    </td></tr>
    	    <tr><td width="1200px">
		<table cellpadding="0" cellspacing="1" border="0" style="width:1200px">
		<tr>
		    <td width="200px" valign=top>
			<table cellpadding="0" cellspacing="1" border="0" style="width:200px">
			<tr>
			    <td style="width:200px" valign=top>
			    <div id="current">
			    </div></td>	    
			</tr>
			</table>
		    </td>
		    <td width="100px" valign=top>
			<table cellpadding="0" cellspacing="1" border="0" style="width:100px">
			<tr>
			    <td style="width:100px" valign=top>
                            <table cellpadding="0" cellspacing="1" border="0" style="width:100px">
			    <tr><td><img width=100 height=100 src="pieplot1.php?type=1"></td></tr>
			    <tr><td><img width=100 height=100 src="pieplot1.php?type=2"></td></tr>
			    <tr><td><img width=100 height=100 src="pieplot1.php?type=4"></td></tr>
			    <tr><td><img width=100 height=100 src="pieplot1.php?type=5"></td></tr>
			    <tr><td><img width=100 height=100 src="pieplot1.php?type=6"></td></tr>
			    <tr><td><img width=100 height=100 src="pieplot1.php?type=11"></td></tr>
			    </table>
			    </td>	    
			</tr>
			</table>
		    </td>
		    <td width="300px" valign=top>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 print '<td width=300 valign=top><table width=300 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1><tr><td bgcolor=#ffcf68 align=center><font class=tablz>N</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Hpod</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>1</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>2</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>3</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>4</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>5</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>6</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>7</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>8</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>9</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Hobr</font></td></tr>';
 
 $query = 'SELECT * FROM dev_irp ORDER BY strut';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=1;
 while ($uy)
	 {
	  $query = 'SELECT * FROM prdata WHERE type=0 AND device='.$uy[1].' ORDER BY prm,pipe';
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  while ($ui)
         	{
		  $query = 'SELECT * FROM prdata WHERE type=1 AND device='.$uy[1].' AND prm='.$ui[2].' AND pipe='.$ui[7].' AND value>0 ORDER BY date DESC';
		  $r = mysql_query ($query,$i);
		  $ur = mysql_fetch_row ($r);
		  if (!$ui[5]) $ui[5]=$ur[5];
			else $prev=$ui[5];
		  $irp[$cn][$ui[2]][$ui[7]]=number_format($ui[5],2);
		  $ui = mysql_fetch_row ($e);
		}
	  $cn++;
	  $uy = mysql_fetch_row ($a);
	 }

 for ($str=1;$str<43;$str++)
	{
	  print '<tr><td bgcolor=#eeedd8 align=center><font class=tablz>'.$str.'</font></td>';
  	  if ($irp[$str][12][0]>0) $data[0]=$irp[$str][1][0];
	 
	  $query = 'SELECT COUNT(id) FROM dev_bit WHERE strut_number='.$str;
	  $a = mysql_query ($query,$i);
	  $uy = mysql_fetch_row ($a);
	  //if ($uy[0]==8) print '<td bgcolor=#e8e8e8 align=center><font class=tablz>n/y</font></td>';
	  $w=1;

	  $query = 'SELECT * FROM dev_bit WHERE strut_number='.$str.' ORDER BY flat_number';
	  $a = mysql_query ($query,$i);
	  $uy = mysql_fetch_row ($a);
	  while ($uy)
		{
		  $query = 'SELECT * FROM prdata WHERE prm=1 AND type=0 AND device='.$uy[1];
		  $e = mysql_query ($query,$i);
		  $ui = mysql_fetch_row ($e);
		  if ($ui)
		  while ($ui)
         		{
			  //$query = 'SELECT * FROM prdata WHERE type=1 AND device='.$uy[1].' AND prm='.$ui[2].' AND pipe='.$ui[7].' AND value>0 ORDER BY date DESC';
			  //$r = mysql_query ($query,$i);
			  //$ur = mysql_fetch_row ($r);
			  //if (!$ui[5]) $ui[5]=2*$ur[5]; else $prev=$ui[5];
			  $data[$w]=$ui[5];
			  //print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($ui[5],2).'</font></td>';
			  $ui = mysql_fetch_row ($e);
			}
		  else $data[$w]=0;
		  $w++;
		  $uy = mysql_fetch_row ($a);
        	 }
	  if ($irp[$str][12][0]>0) $data[10]=$irp[$str][1][1];
	  for ($w=0;$w<11;$w++)
		{
		 //if ($data[$w]>100) 
		 if ($data[$w]) print '<td bgcolor=#e8e8e8 align=center><font class=top5>'.number_format($data[$w],1).'</font></td>';
		 else print '<td bgcolor=#e8e8e8 align=center><font class=top5>-</font></td>';
		 //else if ($w>0 && $w<10) { $pr=($data[$w-1]+$data[$w+1])/2; print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($pr,2).'</font></td>'; }
		}
	  print '</tr>';
	}
?>
</td></tr></table></td>

		    </td>
		    <td width="400px" valign=top>
			<table cellpadding="0" cellspacing="1" border="0" style="width:100px">
			<tr><td colspan=2><img width=400 height=170 src="charts/barplots.php?type=1"></td></tr>
			<tr><td colspan=2><img width=400 height=170 src="charts/barplots.php?type=2"></td></tr>
			<tr><td><img width=195 height=150 src="charts/polar.php?type=0"></td><td><img width=195 height=150 src="charts/polar.php?type=1"></td></tr>
			<tr><td><img width=195 height=150 src="charts/polar.php?type=2"></td><td><img width=195 height=150 src="charts/polar.php?type=3"></td></tr>
			</table>
		    </td>
		    <td width="200px" valign=top>
			<table cellpadding="0" cellspacing="0" border="0" style="width:200px">
			<tr><td align=center bgcolor=#617a94 height=15><font class="menu">Вход</font></td></tr>
			<tr><td>
			<div id="login">
			</div>
		        </td></tr>
			<tr><td align=center bgcolor=#617a94 height=15><font class="menu">Меню</font></td></tr>
			<tr><td>
			<div id="menu">
			</div>
		        </td></tr>
			<tr><td align=center bgcolor=#617a94 height=15><font class="menu">Статистика</font></td></tr>
			<tr><td>
			    <div id="stats">
			    </div>
			</td></tr>			
			</table>
		    </td>
		</tr>
		</table>
	</td>
	
    </tr>
    </table>
</td></tr>
<tr><td bgcolor=#617a94 width=100% height=15><div id="down"></div></td></tr>
</table>

</body>
</html>
