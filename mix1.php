<?php
include ("jpgraph/jpgraph.php");
include ("jpgraph/jpgraph_line.php");
include ("jpgraph/jpgraph_log.php");
include ("jpgraph/jpgraph_bar.php");
include("config/local.php");

$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$today=getdate();
$ye=$today["year"];
$mm=$today["mon"]=4;
$today["mday"]=$mx=29;
$mn=1; $nx=3; $nn=1;

$x=0;
$month=''.$month;
if ($today["mon"]<10) $today["mon"]='0'.$today["mon"];
if ($today["mday"]<10) $today["mday"]='0'.$today["mday"];

for ($tn=$nx; $tn>=$nn; $tn--)
for ($tm=$mx; $tm>=$mn; $tm--)
    {
     $data0[$x]=0; $data1[$x]=0; $data2[$x]=0; 
     if ($tm<10) 
	{
	 $date1=$today["year"].$today["mon"].'0'.$tm.'000000';
	 $dats[$x]=$tm.'/'.$today["mon"];
	}
     else
	{
	 $date1=$today["year"].$today["mon"].$tm.'000000';
	 $dats[$x]=$tm.'/'.$today["mon"];
	}     

     $query = 'SELECT * FROM data WHERE type=2 AND prm=13 AND source=2 AND flat=0 AND date='.$date1;
     //echo $query.'<br>';
     $a = mysql_query ($query,$i);
     if ($a) $uy = mysql_fetch_row ($a);
     if ($uy) $datas0[$x]=$uy[3];
     //echo  $data0[$x].'<br>';
     if ($datas0[$x]<1) $datas0[$x]=$datas0[$x-1];

     //$query = 'SELECT SUM(value) FROM prdata WHERE value>20 AND (prm=13 OR prm=11) AND type=2 AND date='.$date1;
     $query = 'SELECT SUM(value),COUNT(id),AVG(value) FROM prdata WHERE value>20 AND (prm=13 OR prm=11) AND type=2 AND date='.$date1;

     //echo $query.'<br>';    
     $a = mysql_query ($query,$i);
     if ($a) $uy = mysql_fetch_row ($a);
     if ($uy) $datas1[$x]=$uy[0]/4184;
     $datas1[$x]+=(42-$uy[1])*($uy[2]/4184);
     if ($datas0[$x]>$datas1[$x]) $datas4[$x]=($datas0[$x]-$datas1[$x])*100/$datas0[$x];

     $query = 'SELECT * FROM data WHERE type=2 AND prm=4 AND source=10 AND flat=0 AND date='.$date1;
     //echo $query.'<br>';
     $a = mysql_query ($query,$i);
     if ($a) $uy = mysql_fetch_row ($a);
     if ($uy) $datas2[$x]=-$uy[3];
     if ($tn==1) $mn=1;
     if ($datas4[$x]<40 && $datas4[$x]>4) $x++; 
     if ($tn<5 && $tm==1)
	{
	 if ($today["mon"]>1) $today["mon"]--;
	 if (!checkdate ($today["mon"],31,$today["year"])) { $today["mday"]=30; }
	 if (!checkdate ($today["mon"],30,$today["year"])) { $today["mday"]=29; }
	 if (!checkdate ($today["mon"],29,$today["year"])) { $today["mday"]=28; }
	     
	 if ($today["mon"]<10) $today["mon"]='0'.$today["mon"];
	}
    }
$x--;
//for ($i=0; $i<$x; $i++) print $dat[$i].' '.$data0[$i].' '.$data1[$i].' '.$data2[$i].'<br>';
for ($i=0; $i<=$x; $i++) { $data3[$i]=30; $dat[$i]=$dats[$x-$i]; $data0[$i]=$datas4[$x-$i]; $data1[$i]=$datas1[$x-$i]; $data2[$i]=$datas2[$x-$i];}

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

$graph->xaxis->SetTickLabels($dat);
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