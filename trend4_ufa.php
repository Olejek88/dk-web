<title>������� �����  :: ��������� ��������� �. ������ (�������� �� �������)</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr><td width="100%" bgcolor=#ffcf68 align=center><font class=tablz3>��������� ���� ����� ��������� �. ������ (�������� �� �������)</font></td></tr>
<tr><td style="width:100%" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr>
<td style="width:100%" valign=top>
    <table width="100%" cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
	<tr><td bgcolor=#ffcf68 colspan=1></td><td bgcolor=#ffcf68 colspan=12 align="center">�����</td>
	<td bgcolor=#ffcf68 colspan=2 align="center">����</td>
	<td bgcolor=#ffcf68 colspan=5 align="center">���</td></tr>

	<tr><td bgcolor=#ffcf68 align=center width=120px><font class=tablz>����</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>T�,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>T�,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>G���,�.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>G���,�.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>G��,�.</font></td>

	<td bgcolor=#ffcf68 align=center><font class=tablz>Q�,����</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Q�,����</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Q��,����</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Q���,��</font></td>

	<td bgcolor=#ffcf68 align=center><font class=tablz>�Q�,����</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>�Q�,����</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>�Q,����</font></td>

	<td bgcolor=#ffcf68 align=center><font class=tablz>T��,�</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>V,�3</font></td>

	<td bgcolor=#ffcf68 align=center><font class=tablz>T�,�</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>G���,�3</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>G���,�3</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>G���+,�3</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>G���+,�3</font></td></tr>
	<?php
		include("config/local4.php");
		$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

                $today=getdate();
		if ($_GET["year"]=='') $ye=$today["year"];
		else $ye=$_GET["year"];
		if ($_GET["month"]=='') $mn=$today["mon"];
		else $mn=$_GET["month"];
		$x=0;
		if ($today["mday"]>2) $tm=$dy=$today["mday"];
		else $tm=$dy=$today["mday"];
		for ($tn=0; $tn<12; $tn++)
			{
			 $dates1=sprintf ("%d%02d01000000",$ye,$mn);
			 $dat[$tn]=sprintf ("01-%02d-%d",$mn,$ye);
			 $query = 'SELECT * FROM prdata WHERE type=4 AND date='.$dates1;
			 $a = mysql_query ($query,$i);
			 if ($a) $uy = mysql_fetch_row ($a);
			 while ($uy)
			      {
			       	 if ($uy[8]==837 && $uy[5]<110 && $uy[5]>=0) $data0[$x]=$uy[5];
			       	 if ($uy[8]==838 && $uy[5]<110 && $uy[5]>=0) $data1[$x]=$uy[5];

			       	 if ($uy[8]==869 && $uy[5]<110 && $uy[5]>=0) $data2[$x]=number_format($uy[5],4);
			       	 if ($uy[8]==870 && $uy[5]<110 && $uy[5]>=0) $data3[$x]=number_format($uy[5],4);
			       	 if ($uy[8]==839 && $uy[5]>=0) $data4[$x]=$uy[5];
			       	 if ($uy[8]==841 && $uy[5]>=0) $data5[$x]=$uy[5];


			       	 if ($uy[8]==843 && $uy[5]>=0) $data7[$x]=$uy[5];
			       	 if ($uy[8]==844 && $uy[5]>=0) $data8[$x]=$uy[5];
			       	 if ($uy[8]==871 && $uy[5]>=0) $data9[$x]=$uy[5];
			       	 if ($uy[8]==872 && $uy[5]>=0) $data10[$x]=$uy[5];

			       	 if ($uy[8]==842 && $uy[5]>=0) $data6[$x]=number_format($uy[5],2);
			       	 if ($uy[8]==873 && $uy[5]>=0) $data11[$x]=number_format($uy[5],2);
			       	 if ($uy[8]==893 && $uy[5]>=0) $data29[$x]=number_format($uy[5],2);
			       	 if ($uy[8]==894 && $uy[5]>=0) $data30[$x]=number_format($uy[5],2);

			       	 if ($uy[8]==845 && $uy[5]>=0 && $uy[5]<100) $data12[$x]=number_format($uy[5],3); // 1
			       	 if ($uy[8]==846 && $uy[5]>=0 && $uy[5]<100) $data13[$x]=number_format($uy[5],3);

			       	 if ($uy[8]==875 && $uy[5]>=0 && $uy[5]<100) $data14[$x]=number_format($uy[5],3);
			       	 if ($uy[8]==847 && $uy[5]>=0) $data15[$x]=number_format($uy[5],2);
			       	 if ($uy[8]==849 && $uy[5]>=0) $data16[$x]=number_format($uy[5],2);
			       	 if ($uy[8]==850 && $uy[5]>=0) $data17[$x]=number_format($uy[5],2);
			       	 if ($uy[8]==851 && $uy[5]>=0) $data18[$x]=number_format($uy[5],2);
			       	 if ($uy[8]==852 && $uy[5]>=0) $data19[$x]=number_format($uy[5],2);


			       	 if ($uy[8]==853 && $uy[5]>=0) $data20[$x]=number_format($uy[5],3);
			       	 if ($uy[8]==854 && $uy[5]>=0) $data21[$x]=number_format($uy[5],4);
			       	 if ($uy[8]==855 && $uy[5]>=0) $data22[$x]=number_format($uy[5],3);

			       	 if ($uy[8]==860 && $uy[5]>=0) $data23[$x]=number_format($uy[5],3);
			       	 if ($uy[8]==861 && $uy[5]>=0) $data24[$x]=number_format($uy[5],5);
			       	 if ($uy[8]==862 && $uy[5]>=0) $data25[$x]=$uy[5];
			       	 if ($uy[8]==863 && $uy[5]>=0) $data26[$x]=number_format($uy[5],2);
			       	 if ($uy[8]==864 && $uy[5]>=0) $data27[$x]=number_format($uy[5],2);
			       	 if ($uy[8]==866 && $uy[5]>=0) $data28[$x]=number_format($uy[5],2);			       	 
		       		$uy = mysql_fetch_row ($a);	     
    		       	    }
    		       	    
    			if (1)
				{
		        	 print '<tr><td align=center bgcolor=#ffcf68 style="width:100px"><font class=top2>'.$dat[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data0[$x],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data1[$x],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data4[$x],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data5[$x],2).'</font></td>';

				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data7[$x],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data8[$x],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data30[$x],2).'</font></td>';

				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data9[$x],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data10[$x],2).'</font></td>';

				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data6[$x].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data11[$x].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data29[$x].'</font></td>';

				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data20[$x].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data22[$x].'</font></td>';
				 
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data23[$x].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data25[$x],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data26[$x].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data28[$x].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data27[$x].'</font></td>';
				 print '</tr>';
				}
   		         $x++; $mn--; $tn++;

		         if ($mn==0)
				{
				$mn=12; $ye--;
				$tm=$mn;
			    }
		}
	?>
	</table>
    </td>
</tr>
<tr>
<td valign=top>
<?php
$cnt=12; $id=0; $name='�������� ������� Q��� (����)';
for ($rr=0;$rr<$cnt;$rr++)	{ $date2[$rr]=substr($dat[$rr],0,5);  $data2[$rr]=$data10[$rr]; }
include ("highcharts/bar.php");
$cnt=12; $id=1; $name='������ ��������� (�.)';
for ($rr=0;$rr<$cnt;$rr++)	{ $date2[$rr]=substr($dat[$rr],0,5);  $data2[$rr]=$data4[$rr]; }
include ("highcharts/bar.php");
$cnt=12; $id=2; $name='������ ��������� (�.)';
for ($rr=0;$rr<$cnt;$rr++)	{ $date2[$rr]=substr($dat[$rr],0,5);  $data2[$rr]=$data5[$rr]; }
include ("highcharts/bar.php");
$cnt=12; $id=3; $name='������ ���� �.�. (�3)';
for ($rr=0;$rr<$cnt;$rr++)	{ $date2[$rr]=substr($dat[$rr],0,5);  $data2[$rr]=$data25[$rr]; }
include ("highcharts/bar.php");
?>
</td></tr>
</table>
</td></tr></table>

