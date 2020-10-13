<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_bar.php");
include("../config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
//------------------------------------------------------------------------

$today=getdate();
if ($_GET["year"]=='') $ye=$today["year"];
else $ye=$_GET["year"];

if ($_GET["month"]=='') { $today["mon"]--; $mn=$today["mon"]; }
else { $mn=$_GET["month"]; $today["mday"]=29; }
$sum1=$sum2=0;
$x=0;

$dy=31;
if (!checkdate ($mn,31,$ye)) { $dy=30; }
if (!checkdate ($mn,30,$ye)) { $dy=29; }
if (!checkdate ($mn,29,$ye)) { $dy=28; }

if ($today["mon"]<10) $today["mon"]='0'.$today["mon"];
if ($mn<10) $mn='0'.$mn;
//$mn=$today["mon"];

$cn=0;

for ($tm=1; $tm<=$dy; $tm++)
    {
     $data1[$cn]=$data2[$cn]=$count=$avg=0;
     if ($tm<10) $tm='0'.$tm;
     $date1=$ye.$mn.$tm.'000000';
     $dat[$cn]=$tm.'-'.$mn;
     $query='';
     if ($_GET["n1"]==1) $query = 'SELECT SUM(value) FROM data WHERE prm=11 AND source=6 AND type=2 AND date='.$date1;

     if ($_GET["n1"]==2) $query = 'SELECT SUM(value) FROM data WHERE prm=11 AND source=5 AND type=2 AND date='.$date1;

     if ($_GET["n1"]==3) $query = 'SELECT SUM(value) FROM data WHERE prm=2 AND flat>0 AND type=2 AND date='.$date1;

     if ($_GET["n1"]==4) $query = 'SELECT SUM(value),AVG(value),COUNT(id) FROM prdata WHERE (prm=13 OR prm=11) AND value>10 AND type=2 AND date='.$date1;
	//echo $query;

     $e = mysql_query ($query,$i);
     $ui = mysql_fetch_row ($e);
     if ($ui) { $data1[$cn]=$ui[0]; $avg=$ui[1]; $count=$ui[2]; } 
   
     if ($_GET["n1"]<4) $data1[$cn]=$data1[$cn];
     else $data1[$cn]=$data1[$cn]/4184;
	//echo $avg.' '.$count.'<br>';

     if ($_GET["n1"]==4) if ($count>0) $data1[$cn]+=(42-$count)*($avg/4184);

     $sum1+=$data1[$cn];

     if ($_GET["n1"]==1) 
	{
	 $query = 'SELECT value FROM data WHERE prm=12 AND source=5 AND flat=0 AND type=2 AND date='.$date1;
	 $e = mysql_query ($query,$i);
	 $ui = mysql_fetch_row ($e);     
	 if ($ui) $qgvs[$cn]=$ui[0];
	}

     if ($_GET["n1"]==1) $query = 'SELECT value FROM data WHERE prm=12 AND source=6 AND flat=0 AND type=2 AND date='.$date1;
     if ($_GET["n1"]==2) $query = 'SELECT value FROM data WHERE prm=12 AND source=5 AND flat=0 AND type=2 AND date='.$date1;
     if ($_GET["n1"]==3) $query = 'SELECT value/1000 FROM data WHERE prm=14 AND flat=0 AND type=2 AND date='.$date1;
     if ($_GET["n1"]==4) $query = 'SELECT value FROM data WHERE prm=13 AND source=2 AND flat=0 AND type=2 AND date='.$date1;

     $e = mysql_query ($query,$i);
     $ui = mysql_fetch_row ($e);     
     if ($ui) $data2[$cn]=$ui[0];
     if ($_GET["n1"]==1) 
	if ($data2[$cn]-$qgvs[$cn]>0) $data2[$cn]=$data2[$cn]-$qgvs[$cn];
	else $data2[$cn]=0;
	$sum2+=$data2[$cn];
     $cn++;
    }

$graph = new Graph(1200,200,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data1);
$lineplot2=new BarPlot($data2);
$lineplot->SetFillColor("blue");
$lineplot2->SetFillColor("red");

$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();
$lineplot->value->Show();
$lineplot2->value->Show();

$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 
$lineplot2->value->SetFont(FF_ARIAL,FS_NORMAL,7);                 

if ($_GET["n1"]<4)
{
 $name='Индивидуальное потребление '.number_format($sum1,2).' ';
 if ($sum2>0) $pr=number_format(($sum2-$sum1)*100/($sum2),2);
 $name2='Расход по коммерческому узлу учета '.number_format($sum2,2).' '.' ('.$pr.' %)    ';
}

if ($_GET["n1"]==4)
{
 if ($sum1+$sum2>0) $pr=number_format($sum1*100/($sum1+$sum2),2);
 else $pr='н/д';
 if ($sum2>0) $pr2=number_format(($sum2-$sum1)*100/($sum2),2);
 else $pr2=0;
 $name='Теплопотребление тепла СО '.number_format($sum1,2).' ('.$pr.' %)';
 $name2='Потребление тепла всем домом '.number_format($sum2,2).' '.' ('.$pr2.' %)          ';
}

$graph ->legend->Pos( 0.03,0.01,"right" ,"top");
$lineplot->SetLegend($name);
$lineplot2->SetLegend($name2);
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8);
if ($_GET["n1"]==1) $graph->title->Set("Холодная вода, только показания без нормативного потребления (м3)");
if ($_GET["n1"]==2) $graph->title->Set("Горячая вода, только показания без нормативного потребления (м3)");
if ($_GET["n1"]==3) $graph->title->Set("Электроэнергия (кВт/ч)");
if ($_GET["n1"]==4) $graph->title->Set("Баланс по стоякам и входу (ГКал)");

// Add the plot to the graph
$graph->img->SetMargin(5,10,5,23);
//----------- title --------------------
$gbplot  = new GroupBarPlot (array($lineplot ,$lineplot2)); 
$graph->Add($gbplot);
//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>