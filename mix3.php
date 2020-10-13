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
	 $dats[$x]=$tm;
	}
     else
	{
	 $date1=$today["year"].$today["mon"].$tm.'000000';
	 $dats[$x]=$tm;
	}     

     $query = 'SELECT * FROM data WHERE type=2 AND prm=13 AND source=2 AND flat=0 AND date='.$date1;
     //echo $query.'<br>';
     $a = mysql_query ($query,$i);
     if ($a) $uy = mysql_fetch_row ($a);
     if ($uy) $datas0[$x]=$uy[3];
     if ($datas0[$x]<1) $datas0[$x]=$datas0[$x-1];
     //echo  $data0[$x].'<br>';

     $query = 'SELECT SUM(value),COUNT(id),AVG(value) FROM prdata WHERE value>20 AND (prm=13 OR prm=11) AND type=2 AND date='.$date1;
     //echo $query.'<br>';    
     $a = mysql_query ($query,$i);
     if ($a) $uy = mysql_fetch_row ($a);
     if ($uy) $datas1[$x]=$uy[0]/4190;

     $datas1[$x]+=(42-$uy[1])*($uy[2]/4190);

     if ($datas0[$x]>$datas1[$x]) $datas0[$x]=($datas0[$x]-$datas1[$x])*100/$datas0[$x];  

     $query = 'SELECT * FROM data WHERE type=2 AND prm=4 AND source=10 AND flat=0 AND date='.$date1;
     //echo $query.'<br>';
     $a = mysql_query ($query,$i);
     if ($a) $uy = mysql_fetch_row ($a);
     if ($uy) $datas2[$x]=$uy[3];

     if ($datas0[$x]<45) $x++; 

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