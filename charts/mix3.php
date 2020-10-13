<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_line.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_bar.php");
include("../config/local.php");

$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = 'SELECT COUNT(id) FROM device WHERE type=5';
$a = mysql_query ($query,$i); $uy = mysql_fetch_row ($a); 
if ($uy[0]) $numm=$uy[0];

$today=getdate();
$ye=$today["year"];
$mn=$today["mon"];
$x=0; $tm=$dy=$today["mday"];
for ($tn=1; $tn<=250; $tn++)
	{		
	 $date1=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
	 $dat[$x]=sprintf ("%02d-%02d-%d",$mn,$tm,$ye);
	 $data0[$x]=0; $data1[$x]=0; $data2[$x]=0; 
	 $dats[$x]=$tm; $tm--;
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
	
	 $query = 'SELECT * FROM data WHERE type=2 AND prm=13 AND source=2 AND flat=0 AND date='.$date1;
//echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 if ($a) $uy = mysql_fetch_row ($a);
	 if ($uy) $datas0[$x]=$uy[3];
//echo $datas0[$x].' ';
	 if ($datas0[$x]<1) continue;

	 $query = 'SELECT SUM(value),COUNT(id),AVG(value) FROM prdata WHERE value>20 AND (prm=13 OR prm=11) AND type=2 AND date='.$date1;
//echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 if ($a) $uy = mysql_fetch_row ($a);
	 if ($uy) $datas1[$x]=$uy[0]/4190;
	 $datas1[$x]+=($numm-$uy[1])*($uy[2]/4190);
//echo $datas1[$x].' ';

	 if ($datas0[$x]>$datas1[$x]) $datas0[$x]=($datas0[$x]-$datas1[$x])*100/$datas0[$x];  
	 $query = 'SELECT * FROM data WHERE type=2 AND prm=4 AND source=10 AND flat=0 AND date='.$date1;
	 $a = mysql_query ($query,$i);
	 if ($a) $uy = mysql_fetch_row ($a);
	 if ($uy) $datas2[$x]=$uy[3];
//echo $datas2[$x].'<br>';

	 if ($datas0[$x]<45) $x++; 
   	 
	}
$x--;
//for ($i=0; $i<$x; $i++) print $dats[$i].' '.$datas0[$i].' '.$datas1[$i].' '.$datas2[$i].'<br>';
//for ($i=0; $i<=$x; $i++) { $dat[$i]=$dats[$x-$i]; $data0[$i]=$datas0[$x-$i]; $data1[$i]=$datas1[$x-$i]; $data2[$i]=$datas2[$x-$i];}
$cn=0;
for ($t=-20; $t<=12; $t=$t+2)
{
 $data[$cn]=0; $n=0;
 for ($i=0; $i<=$x; $i++)
    {
     if ($datas2[$i]>=$t && $datas2[$i]<($t+3)) { $data[$cn]+=$datas0[$i]; $n++; }
    }
 if ($n>0) $data[$cn]=$data[$cn]/$n;
 $data10[$cn]=30;
 $dat[$cn]=$t;
 $cn++;
}
$graph = new Graph(800,300,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data);
$lineplot2=new LinePlot($data10);
$lineplot->SetFillColor("blue");
$lineplot2->SetWeight(2);
$lineplot2->SetColor("red");

$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();
$lineplot->value->Show();
$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 

// Add the plot to the graph
$graph->img->SetMargin(5,10,10,25);
//----------- title --------------------
$graph->Add($lineplot);
$graph->Add($lineplot2);
//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>