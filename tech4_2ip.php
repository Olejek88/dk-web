<tr><td colspan=2 bgcolor=#ffcf68 align=center><font class=tablz3>������ �������������� 2��</font></td></tr>
<tr><td width=600 valign=top>
<table width=600 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr>
<td bgcolor=#ffcf68 align=center><font class=tablz>id</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>��.</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>����� ��</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>���</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>�����</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>���.</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>��</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>��</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dB</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>�������</font></td>
</tr>

<?php
 $query = 'SELECT * FROM device WHERE type=2 AND ust=0 ORDER BY flat';
 $e = mysql_query ($query,$i); $cn=0;
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui) 
	{
	 $query = 'SELECT * FROM dev_2ip WHERE device='.$ui[1];
	 $f = mysql_query ($query,$i);
	 if ($f) $uo = mysql_fetch_row ($f);
	 if ($uo) { $ids[$cn]=$uo[3]; $adr[$cn]=$uo[4]; $flat[$cn]=$uo[6]; }

	 $device[$cn]=$ui[1]; 
	 $cn++;
	 $ui = mysql_fetch_row ($e);
	}
 $max=$cn-1; $cn=0; 
 for ($w=0;$w<=$max;$w++) $data11[$w]=$data12[$w]=$data13[$w]=$data01[$w]=$data02[$w]=0;

 $query = 'SELECT * FROM prdata WHERE (type=2 OR type=0) AND (prm=6 OR prm=8 OR prm=32) ORDER BY date DESC LIMIT '.($max*10);	
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     for ($w=0;$w<=$max;$w++) 
	if ($device[$w]==$ui[1])
		{
		 if ($ui[2]==6) if ($data11[$w]==0)  $data11[$w]=$ui[5]; else $data01[$w]=$ui[5];
		 if ($ui[2]==8) if ($data12[$w]==0)  $data12[$w]=$ui[5]; else $data02[$w]=$ui[5];
		 if ($ui[2]==32)if ($data13[$w]==0)  $data13[$w]=$ui[5]; else $data03[$w]=$ui[5];
		 break;
		}
     $ui = mysql_fetch_row ($e);    
    }                                                
 $sos[0]=$sos[1]=$sos[2]=$sos[3]=$sos[4]=$sos[5]=$sos[6]=$sos[7]=0;
 $query = 'SELECT * FROM device WHERE type=2 AND ust=0 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
	 {
	  $sos[0]++;
	  $sost=0;	  
	  if ((time()-strtotime($uy[16])) > 5000000)  $sost=1;
//	  if ($data13[$cn]==0) $sost=1;
	  if ($uy[21]) $sost=2;
	  if ($data13[$cn]<-90) $sost=3;
          if ($data11[$cn]==$data01[$cn]) $sost=4;
	  if ($data12[$cn]==$data02[$cn]) $sost=5;
	  if ($data12[$cn]-$data02[$cn]<0.1 && $data11[$cn]-$data01[$cn]>1) $sost=5;
	  if ($data11[$cn]==0 && $sost==0) $sost=6;
	  if ($data12[$cn]==0 && $sost==0) $sost=7;
	  if ($data11[$cn]-$data01[$cn]<0.1 && $data12[$cn]-$data02[$cn]>1) $sost=4;

          if ($sost)
		{
		  if ($sost==1) $sos[1]++;
		  if ($sost==2) $sos[2]++;
		  if ($sost==3) $sos[3]++;
		  if ($sost==4) $sos[4]++;
		  if ($sost==5) $sos[5]++;
		  if ($sost==6) $sos[6]++;
		  if ($sost==7) $sos[7]++;

		  print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>';
		  printf ("%d",$uy[1]); print '</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.$flat[$cn].'</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.$ids[$cn].'</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.$adr[$cn].'</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.$uy[16].'</font></td>';
		  if ($uy[21]==0) print '<td bgcolor=#e8e8e8 align=center><font class=top2>���.</font></td>';
		  if ($uy[21]==1) print '<td bgcolor=#ff9999 align=center><font class=top2>�� ���.</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($data12[$cn],2).'</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($data11[$cn],2).'</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.$data13[$cn].'</font></td>';
		  if ($sost==1)  print '<td bgcolor=#ee5544 align=center><font class=top2>����� �� ��������</font></td>';
		  if ($sost==2)  print '<td bgcolor=#eeee33 align=center><font class=top2>�� ����������</font></td>';
		  if ($sost==3)  print '<td bgcolor=#ee80ee align=center><font class=top2>������ ������� �������</font></td>';
		  if ($sost==4)  print '<td bgcolor=#775577 align=center><font class=top2>��� �� ������ ('.number_format($data01[$cn]).'|'.number_format($data11[$cn]).')</font></td>';
		  if ($sost==5)  print '<td bgcolor=#775577 align=center><font class=top2>��� �� ������ ('.number_format($data02[$cn]).'|'.number_format($data12[$cn]).')</font></td>';
		  if ($sost==6)  print '<td bgcolor=#999999 align=center><font class=top2>��� �� �����</font></td>';
		  if ($sost==7)  print '<td bgcolor=#999999 align=center><font class=top2>��� �� �����</font></td>';
		  print '</tr>';
		}
	  $uy = mysql_fetch_row ($a); $cn++;
	 } 
 print '</table></td>';
 print '<td align="center" valign="top">';
 print '<img src="charts/pieplot15.php?obj='.$_GET["obj"].'&n1='.$sos[0].'&n2='.$sos[1].'&n3='.$sos[2].'&n4='.$sos[3].'&n5='.$sos[4].'&n6='.$sos[5].'&n7='.$sos[6].'&n8='.$sos[7].'">';
 print '<table width=290 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1><tr>
	<td bgcolor=#ffcf68 align=center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>�������</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>����������</font></td>
 	<td bgcolor=#ffcf68 align=center><font class=tablz>%</font></td></tr>';
 print '<tr><td bgcolor="green"></td><td bgcolor=#e8e8e8 align=center><font class=top2>�������� ��� �������</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($sos[0]-($sos[1]+$sos[2]+$sos[3]+$sos[4]+$sos[5]+$sos[6]+$sos[7]),0).'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*($sos[0]-($sos[1]+$sos[2]+$sos[3]+$sos[4]+$sos[5]+$sos[6]+$sos[7]))/$sos[0],2).'%</font></td></tr>';
 print '<tr><td bgcolor="#ee5544"></td><td bgcolor=#e8e8e8 align=center><font class=top2>����� �� ��������</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.$sos[1].'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*$sos[1]/$sos[0],2).'%</font></td></tr>';
 print '<tr><td bgcolor="#eeee33"></td><td bgcolor=#e8e8e8 align=center><font class=top2>�� ����������</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.$sos[2].'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*$sos[2]/$sos[0],2).'%</font></td></tr>';
 print '<tr><td bgcolor="#ee80ee"></td><td bgcolor=#e8e8e8 align=center><font class=top2>������ ������� �������</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.$sos[3].'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*$sos[3]/$sos[0],2).'%</font></td></tr>';
 print '<tr><td bgcolor="#775577"></td><td bgcolor=#e8e8e8 align=center><font class=top2>�������� ��� �� ����������</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.$sos[4].'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*$sos[4]/$sos[0],2).'%</font></td></tr>';
 print '<tr><td bgcolor="#775577"></td><td bgcolor=#e8e8e8 align=center><font class=top2>�������� ��� �� ����������</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.$sos[5].'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*$sos[5]/$sos[0],2).'%</font></td></tr>';
 print '<tr><td bgcolor="#999999"></td><td bgcolor=#e8e8e8 align=center><font class=top2>��� �� �����</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.$sos[6].'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*$sos[6]/$sos[0],2).'%</font></td></tr>';
 print '<tr><td bgcolor="#999999"></td><td bgcolor=#e8e8e8 align=center><font class=top2>��� �� �����</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.$sos[7].'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*$sos[7]/$sos[0],2).'%</font></td></tr>';
 print '<tr><td bgcolor="#999999"></td><td bgcolor=#e8e8e8 align=center><font class=top2>� ����� �������</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($sos[0]-($sos[2]+$sos[3]),0).'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*($sos[0]-$sos[2]-$sos[3])/$sos[0],2).'%</font></td></tr>';
 print '</table></td></tr>';
// print '</table></td></tr>';
?>             
