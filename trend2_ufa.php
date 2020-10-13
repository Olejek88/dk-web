<title>Система учета  :: Показания котельной В. Уфалей (дневные значения)</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr><td width="100%" bgcolor=#ffcf68 align=center><font class=tablz3>Показания узла учета (дневные значения)</font>[ <a href="reps/report_ufa_days.xlsx">excel</a> ]</td></tr>
<tr><td style="width:100%" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr>
<td style="width:100%" valign=top>
    <table width="100%" cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
	<tr><td bgcolor=#ffcf68 colspan=1></td><td bgcolor=#ffcf68 colspan=14 align="center">тепло</td>
	<td bgcolor=#ffcf68 colspan=3 align="center">газ котлы</td>
	<td bgcolor=#ffcf68 colspan=3 align="center">вода</td>
	<td bgcolor=#ffcf68 colspan=6 align="center">газ</td></tr>

	<tr><td bgcolor=#ffcf68 align=center width=120px><font class=tablz>дата</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Tп,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Tо,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Pп,МПа</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Pо,МПа</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Gпод,т.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Gобр,т.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Gпп,т.</font></td>

	<td bgcolor=#ffcf68 align=center><font class=tablz>Qп,ГКал</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Qо,ГКал</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Qпп,ГКал</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Qотп,ГК</font></td>

	<td bgcolor=#ffcf68 align=center><font class=tablz>зQп,ГКал</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>зQо,ГКал</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>оQ,ГКал</font></td>

	<td bgcolor=#ffcf68 align=center><font class=tablz>T1,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>T2,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>T3,C</font></td>

	<td bgcolor=#ffcf68 align=center><font class=tablz>Tхв,С</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Pхв,МПа</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>V,м3</font></td>

	<td bgcolor=#ffcf68 align=center><font class=tablz>Tг,С</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Pг,МПа</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Gстд,м3</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Gраб,м3</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Gстд+,м3</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Gраб+,м3</font></td></tr>
	<?php
		include("config/local4.php");
		//ini_set('display_errors', 'On'); error_reporting(E_ALL);
		$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
		require_once 'phpexcel/Classes/PHPExcel.php';
		require_once 'phpexcel/Classes/PHPExcel/Cell/AdvancedValueBinder.php';
		PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
		$objPHPExcel = PHPExcel_IOFactory::load('reports/reportsh.xls');
		$objPHPExcel->getProperties()->setCreator("rpksu")
				 ->setLastModifiedBy("Olejek")
				 ->setTitle("Heat report")
				 ->setSubject("Heat report")
				 ->setDescription("Heat report")
				 ->setKeywords("office 2003 openxml php")
				 ->setCategory("Report");
		$objPHPExcel->setActiveSheetIndex(0);
                $today=getdate();
		if ($_GET["year"]=='') $ye=$today["year"];
		else $ye=$_GET["year"];
		if ($_GET["month"]=='') $mn=$today["mon"];
		else $mn=$_GET["month"];
		$x=0;
		if ($today["mday"]>2) $tm=$dy=$today["mday"];
		else $tm=$dy=$today["mday"];
		for ($tn=0; $tn<50; $tn++)
			{
			 $dates1=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
			 $dat[$x]=sprintf ("%02d-%02d-%d",$mn,$tm,$ye);
			 $query = 'SELECT * FROM prdata WHERE type=2 AND date='.$dates1;
			 $a = mysql_query ($query,$i);
			 if ($a) $uy = mysql_fetch_row ($a);
			 while ($uy)
			      {
			       	 if ($uy[8]==837 && $uy[5]<110 && $uy[5]>=0) $data0[$x]=$uy[5];
			       	 if ($uy[8]==838 && $uy[5]<110 && $uy[5]>=0) $data1[$x]=$uy[5];

			       	 if ($uy[8]==869 && $uy[5]<110 && $uy[5]>=0) $data2[$x]=number_format($uy[5],4);
			       	 if ($uy[8]==870 && $uy[5]<110 && $uy[5]>=0) $data3[$x]=number_format($uy[5],4);
			       	 if ($uy[8]==839 && $uy[5]>=0) $data4[$x]=number_format($uy[5],2);
			       	 if ($uy[8]==841 && $uy[5]>=0) $data5[$x]=number_format($uy[5],2);

			       	 if ($uy[8]==843 && $uy[5]>=0) $data7[$x]=number_format($uy[5],2);
			       	 if ($uy[8]==844 && $uy[5]>=0) $data8[$x]=number_format($uy[5],2);
			       	 if ($uy[8]==871 && $uy[5]>=0) $data9[$x]=number_format($uy[5],2);
			       	 if ($uy[8]==872 && $uy[5]>=0) $data10[$x]=number_format($uy[5],2);

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
		        	 $yach='A'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$dat[$tn]);
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data0[$tn],2).'</font></td>';
		        	 $yach='B'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data0[$tn]);
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data1[$tn],2).'</font></td>';
		        	 $yach='C'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data1[$tn]);
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data2[$tn].'</font></td>';
		        	 $yach='D'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data2[$tn]);				 
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data3[$tn].'</font></td>';
		        	 $yach='E'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data3[$tn]);				 
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data4[$tn].'</font></td>';
		        	 $yach='F'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data4[$tn]);				 
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data5[$tn].'</font></td>';
		        	 $yach='G'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data5[$tn]);				 
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data30[$tn].'</font></td>';
		        	 $yach='H'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data30[$tn]);

				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data7[$tn].'</font></td>';
		        	 $yach='I'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data7[$tn]);				 
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data8[$tn].'</font></td>';
		        	 $yach='J'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data8[$tn]);				 
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data9[$tn].'</font></td>';
		        	 $yach='K'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data9[$tn]);				 
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data10[$tn].'</font></td>';
		        	 $yach='L'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data10[$tn]);				 
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data6[$tn].'</font></td>';
				 $yach='M'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data6[$tn]);				 
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data11[$tn].'</font></td>';
		        	 $yach='N'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data11[$tn]);				 
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data29[$tn].'</font></td>';
		        	 $yach='O'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data29[$tn]);

				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data12[$tn].'</font></td>';
		        	 $yach='P'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data12[$tn]);
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data13[$tn].'</font></td>';
		        	 $yach='Q'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data13[$tn]);
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data14[$tn].'</font></td>';
		        	 $yach='R'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data14[$tn]);

				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data20[$tn].'</font></td>';
		        	 $yach='S'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data20[$tn]);
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data21[$tn].'</font></td>';
		        	 $yach='T'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data21[$tn]);
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data22[$tn].'</font></td>';
		        	 $yach='U'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data22[$tn]);
				 
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data23[$tn].'</font></td>';
		        	 $yach='V'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data23[$tn]);
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data24[$tn].'</font></td>';
		        	 $yach='W'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data24[$tn]);
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data25[$tn],2).'</font></td>';
		        	 $yach='X'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data25[$tn]);
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data26[$tn].'</font></td>';
		        	 $yach='Y'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data26[$tn]);
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data28[$tn].'</font></td>';
		        	 $yach='Z'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data28[$tn]);
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data27[$tn].'</font></td>';
		        	 $yach='AA'.number_format($x+3); $objPHPExcel->getActiveSheet()->setCellValue($yach,$data27[$tn]);
				 print '</tr>';
				}
   		         $x++; $tm--;
		         if ($tm==0)
				{
				$mn--;
				if ($mn==0) { $mn=12; $ye--; }
				$dy=31;
				if (!checkdate ($mn,31,$ye)) { $dy=30; }
				if (!checkdate ($mn,30,$ye)) { $dy=29; }
				if (!checkdate ($mn,29,$ye)) { $dy=28; }
				$tm=$dy;
			    }
		}
	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    	    $objWriter->setOffice2003Compatibility(true);
	    $filename='reps/report_ufa_days.xlsx';
	    $objWriter->save("reps/report_ufa_days.xlsx");
	?>
	</table>
    </td>
</tr>
<tr>
<td valign=top>
<?php

$cnt=120; $id=0; $title='Температура подающего (С)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],0,5);  $date1[$cnt-$rr-1]=$data0[$rr]; }
include ("highcharts/trend.php");
$cnt=120; $id=1; $title='Температура обратного (С)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],0,5);  $date1[$cnt-$rr-1]=$data1[$rr]; }
include ("highcharts/trend.php");
$cnt=120; $id=4; $title='Расход подающего (т.)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],0,5);  $date1[$cnt-$rr-1]=$data2[$rr]; }
include ("highcharts/trend.php");
$cnt=120; $id=5; $title='Расход обратного (т.)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],0,5);  $date1[$cnt-$rr-1]=$data3[$rr]; }
include ("highcharts/trend.php");
$cnt=120; $id=6; $title='Тепловая энергия (ГКал)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],0,5);  $date1[$cnt-$rr-1]=$data6[$rr]; }
include ("highcharts/trend.php");
$cnt=120; $id=7; $title='Расход газа с.у. (м3)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],0,5);  $date1[$cnt-$rr-1]=$data25[$rr]; }
include ("highcharts/trend.php");
?>
</td></tr>
</table>
</td></tr></table>

