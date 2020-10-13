<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_line.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_bar.php");
include("../config/local.php");

$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$today=getdate();
$ye=$today["year"];
$mn=$today["mon"];
$x=0; $tm=$dy=$today["mday"];
$max=200;
while (1)
	{		
	 $date1[$x]=sprintf ("%d-%02d-%02d 00:00:00",$ye,$mn,$tm);
	 //echo $date1[$x].'<br>';
	 $dat[$x]=sprintf ("%02d-%02d",$mn,$tm);
	 $datas0[$x]=$datas1[$x]=$datas2[$x]=0;
         $x++; if ($x>$max) break;
	 $tm--;
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
$query = 'SELECT COUNT(id) FROM dev_irp';
$a = mysql_query ($query,$i);
if ($a) $uy = mysql_fetch_row ($a);
$countirp=$uy[0];

$query = 'SELECT * FROM data WHERE type=2 AND prm=13 AND source=2 AND flat=0';
$a = mysql_query ($query,$i);
if ($a) $uy = mysql_fetch_row ($a);
while ($uy)
{
 for ($x=0;$x<$max;$x++)
 if ($date1[$x]==$uy[2]) $datas0[$x]=$uy[3];
//echo $uy[2].' '.$date1[2].' '.$datas0[2].' '.$uy[3].'<br>';
 $uy = mysql_fetch_row ($a);
}

$query = 'SELECT * FROM prdata WHERE prm=13 AND type=2';
$a = mysql_query ($query,$i);
if ($a) $uy = mysql_fetch_row ($a);
while ($uy)
{
 for ($x=0;$x<$max;$x++)
 if ($date1[$x]==$uy[4]) { $datas1[$x]+=$uy[5]/4086; $cnt[$x]++; $sum[$x]+=$uy[5]/4086; }
 $uy = mysql_fetch_row ($a);
}

$query = 'SELECT * FROM data WHERE type=2 AND prm=4 AND source=10 AND flat=0';
$a = mysql_query ($query,$i);
if ($a) $uy = mysql_fetch_row ($a);
if ($uy) $datas2[$x]=-$uy[3];
while ($uy)
{
 for ($x=0;$x<$max;$x++)
 if ($date1[$x]==$uy[2]) $datas2[$x]=-$uy[3];
 $uy = mysql_fetch_row ($a);
}

$cm=0;
for ($i=0; $i<=$max; $i++) 
    {
     if ($cnt[$max-$i]>0) $sss=($countirp-$cnt[$max-$i])*$sum[$max-$i]/$cnt[$max-$i];
     //print $dat[$max-$i].' '.$datas0[$max-$i].' '.$datas1[$max-$i].' '.$datas2[$max-$i].'<br>';
     if ($datas0[$max-$i]>0) if ($datas0[$max-$i]>$datas1[$max-$i]) $datas4[$max-$i]=($datas0[$max-$i]-$datas1[$max-$i]-$sss)*100/$datas0[$max-$i];     
     $data3[$cm]=30; $dats[$cm]=$dat[$max-$i]; $data0[$cm]=$datas4[$max-$i]; $data1[$cm]=$datas1[$max-$i]; $data2[$cm]=$datas2[$max-$i];
     //print $dat[$max-$i].' '.$data0[$cm].'<br>';
	if ($data0[$cm]>0 && $data0[$cm]<40) $cm++;
    }

//for ($i=0; $i<$x; $i++) print $dat[$i].' '.$data0[$i].' '.$data1[$i].' '.$data2[$i].'<br>';

$graph = new Graph(1000,300,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data0);
$lineplot->SetFillColor("green");
$graph->SetY2Scale("lin");
//$lineplot2=new BarPlot($data1);
//$lineplot2->SetFillColor("green");

$l1plot=new LinePlot($data2);
$l1plot->SetColor("red");
$l1plot->SetWeight(2);

$lineplot3=new LinePlot($data3);
$lineplot3->SetColor("orange");
$lineplot3->SetWeight(2);

$graph->xaxis->SetTickLabels($dats);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();
//$lineplot->value->Show();

$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8);
$l1plot->SetLegend("температура наружного воздуха     ");
$lineplot->SetLegend("% общедомовых потерь");
$graph->legend->SetAbsPos(70,10,'right','top');


$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 
$graph->xaxis->SetTextTickInterval(5,0);
// Add the plot to the graph
$graph->img->SetMargin(35,35,5,23);
//----------- title --------------------
//$gbplot = new AccBarPlot(array($lineplot2,$lineplot));
//$gbplot->value->Show();
//$graph->Add($gbplot);
$graph->AddY2($l1plot);
$graph->Add($lineplot);
$graph->Add($lineplot3);
//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>