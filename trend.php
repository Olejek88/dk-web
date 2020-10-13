<meta http-equiv="Pragma" content="no-cache">
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<link href="files/rcom-main.css" rel="stylesheet">
<link href="files/rcom-tabs.css" rel="stylesheet">

<title>Отчет по данным коммерческого узла учета</title>
<script language="JavaScript" type="text/javascript" src="view3.js"></script>
</head>
<body onLoad="startShow()" leftmargin=0 topmargin=1 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table cellpadding="0" cellspacing="1" border="0" style="width:800px" align=center>
<tr>
	<td width="800px" valign=top>
	<table cellpadding="0" cellspacing="1" border="0" style="width:800px">
    	    <tr><td width="800px" valign=top>
		<table cellpadding="0" cellspacing="0" border="0" style="width:800px">
		<tr>
		    <td style="width:800px" valign=top>
		    <table width=800px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
			<tr><td bgcolor=#ffcf68 align=center width=100px><font class=tablz>дата</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>T1,C</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>T2,C</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>V1,m3</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>V2,m3</font></td>
			<td bgcolor=#ffcf68 align=center><font class=tablz>G1,m3</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>G2,m3</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Q1,GKl</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Q2,GKl</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Q3,GKl</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Q4,GKl</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Ghv,t</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Ggv,t</font></td></tr>
			<?php  
			include("config/local.php");
			$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

			$today=getdate();
			if ($_GET["year"]=='') $ye=$today["year"];
			else $ye=$_GET["year"];
			if ($_GET["month"]=='') $mn=$today["mon"];
			else $mn=$_GET["month"];

			$x=0;
			$dy=$today["mday"]-1;

			for ($tn=$mn; $tn>=1; $tn--)
			for ($tm=$dy; $tm>=1; $tm--)
			    {
			     if ($tm<10) 
				{
				 $date1=$ye.'0'.$mn.'0'.$tm.'000000';
				 $dat[$x]='0'.$tm.'-0'.$mn.'-'.$ye;
				}                   
			     else
				{
				 $date1=$ye.'0'.$mn.$tm.'000000';
				 $dat[$x]=$tm.'-0'.$mn.'-'.$ye;
				}
		        print '<tr><td align=center bgcolor=#ffcf68><font class=top2>'.$dat[$x].'</font></td>';
			$query = 'SELECT * FROM data WHERE type=2 AND flat=0 AND date='.$date1;
			//echo $query;
			$a = mysql_query ($query,$i);
			if ($a) $uy = mysql_fetch_row ($a);
			$data0=$data1=$data2=$data3=$data4=$data5=$data6=$data7=$data8=$data9=$data10=$data11=$data12='-';
			while ($uy)
			      {          
			       if ($uy[8]==4 && $uy[6]==0) $data0=$uy[3];
			       if ($uy[8]==4 && $uy[6]==1) $data1=$uy[3];
			       if ($uy[8]==11 && $uy[6]==0) $data2=$uy[3];
			       if ($uy[8]==11 && $uy[6]==1) $data3=$uy[3];
			       if ($uy[8]==12 && $uy[6]==0) $data4=$uy[3];
			       if ($uy[8]==12 && $uy[6]==1) $data5=$uy[3];
			       if ($uy[8]==13 && $uy[6]==0) $data6=$uy[3];
			       if ($uy[8]==13 && $uy[6]==1) $data7=$uy[3];
			       if ($uy[8]==13 && $uy[6]==2) $data8=$uy[3];
			       if ($uy[8]==13 && $uy[6]==3) $data9=$uy[3];
			       if ($uy[8]==12 && $uy[6]==5) $data10=$uy[3];
			       if ($uy[8]==12 && $uy[6]==6) $data11=$uy[3];
			       $uy = mysql_fetch_row ($a);	     
			      }
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data0.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data1.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data2.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data3.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data4.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data5.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data6.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data7.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data8.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data9.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data10.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data11.'</font></td></tr>';

   		        $x++; 
		        if ($tm==1)
				{
				$mn--;
				$dy=31;
				if (!checkdate ($mn,31,$ye)) { $dy=30; }
				if (!checkdate ($mn,30,$ye)) { $dy=29; }
				if (!checkdate ($mn,29,$ye)) { $dy=28; }
			    }
		       }
			?>
			</table>
		    </td>
		</tr>		
		<tr>
		    <td style="width:800px" valign=top><br><br><br>
		    <table width=800px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
			<tr><td bgcolor=#ffcf68 align=center width=100px><font class=tablz>дата</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>T1,C</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>T2,C</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>V1,m3</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>V2,m3</font></td>
			<td bgcolor=#ffcf68 align=center><font class=tablz>G1,m3</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>G2,m3</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Q1,GKl</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Q2,GKl</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Q3,GKl</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Ghv,t</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Ggv,t</font></td></tr>
			<?php  
			include("config/local.php");
			$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

		       $today=getdate ();
			if ($today["mon"]>1) $today["mon"]=$today["mon"]-1;
			else { $today["mon"]=12; $today["year"]=$today["year"]-1; }
			
		       $cn=12; $tep=$tep1=$gvs=$gvs1=$hvs=$hvs1=$ee=$ee1=$sum1=0;
		       if ($_GET["id"]=='') $_GET["id"]=1;
	  	       while ($cn)
		           {
			    if ($today["mon"]<10)  $today["mon"]='0'.$today["mon"];
		  	    $sum=0; $month=$today["mon"];
			    include ("time.inc");
			    $tim=$today["year"].$today["mon"].'01000000';
	 	            
			    print '<tr><td align=center bgcolor=#ffcf68><font class=top2>'.$month.','.$today["year"].'</font></td>';
			$query = 'SELECT * FROM data WHERE type=4 AND flat=0 AND date='.$tim;
			//echo $query;
			$a = mysql_query ($query,$i);
			if ($a) $uy = mysql_fetch_row ($a);
			$data0=$data1=$data2=$data3=$data4=$data5=$data6=$data7=$data8=$data9=$data10=$data11=$data12='-';
			while ($uy)
			      {          
			       if ($uy[8]==4 && $uy[6]==0) $data0=$uy[3];
			       if ($uy[8]==4 && $uy[6]==1) $data1=$uy[3];
			       if ($uy[8]==11 && $uy[6]==0) $data2=$uy[3];
			       if ($uy[8]==11 && $uy[6]==1) $data3=$uy[3];
			       if ($uy[8]==12 && $uy[6]==0) $data4=$uy[3];
			       if ($uy[8]==12 && $uy[6]==1) $data5=$uy[3];
			       if ($uy[8]==13 && $uy[6]==1) $data6=$uy[3];
			       if ($uy[8]==13 && $uy[6]==2) $data7=$uy[3];
			       if ($uy[8]==13 && $uy[6]==3) $data8=$uy[3];
			       if ($uy[8]==12 && $uy[6]==5) $data9=$uy[3];
			       if ($uy[8]==12 && $uy[6]==6) $data10=$uy[3];
			       $uy = mysql_fetch_row ($a);	     
			      }
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data0.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data1.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data2.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data3.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data4.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data5.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data6.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data7.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data8.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data9.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data10.'</font></td></tr>';
			    if ($today[mon]>1) $today[mon]--;
			    else { $today[year]--; $today[mon]=12; }

   		        $cn--; 
		       }
			?>
			</table>
		    </td>
		</tr>

		</table>
	    </td></tr>
	</table>
</td></tr>
</table>

</body>
</html>
