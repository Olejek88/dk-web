<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_line.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_bar.php");
include("../config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
//------------------------------------------------------------------------
$cm=0;
$id="d".$cm;
while ($_GET[$id])
{
 $cm++; $id="d".$cm;
}

$start=$cm-1; $cm=0;
$id="d".$cm;
while ($_GET[$id])
{
 if ($_GET[$id] || $_GET[$id]==0) $dat[$start-$cm]=$_GET[$id]*1;
 $id="e".$cm;
 if ($_GET[$id] || $_GET[$id]==0) $data1[$start-$cm]=$_GET[$id]*1;
 $id="o".$cm;
 if ($_GET[$id] || $_GET[$id]==0) $data2[$start-$cm]=$_GET[$id]*1;
 $cm++;
 $id="d".$cm;
} 

for ($y=0;$y<$cm;$y++)
{
 //echo $y.' '.$dat[$y].' '.$data1[$y].' '.$data2[$y].'<br>';
}

$graph = new Graph(800,250,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$barplot=new BarPlot($data1);
$barplot->SetFillColor("red");
$barplot2=new BarPlot($data2);
$barplot2->SetFillColor("blue");

//$graph->SetScale("textlin",0,0.045);
$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();

$barplot->value->SetFont(FF_ARIAL,FS_NORMAL,10); 
$barplot2->value->SetFont(FF_ARIAL,FS_NORMAL,10); 

if ($_GET["type"]==1) $graph->title->Set("Индивидуальное потребление тепловой энергии (ККал)");
if ($_GET["type"]==2) $graph->title->Set("Индивидуальное потребление холодной воды (м3)");
if ($_GET["type"]==3) $graph->title->Set("Индивидуальное потребление горячей воды (м3)");
if ($_GET["type"]==4) $graph->title->Set("Индивидуальное потребление электроэнергии (кВт)");

$name='Индивидуальное потребление';
$name2='Общедомовое распределение';
// Add the plot to the graph
$graph->img->SetMargin(30,8,20,25);
//----------- title --------------------
$barplot->SetLegend($name);
$barplot2->SetLegend($name2);

$gbplot  = new AccBarPlot (array($barplot,$barplot2)); 
$graph ->legend->Pos( 0.03,0.06,"right" ,"top");

$graph->Add($gbplot);
$gbplot->SetWidth(0.8);

//----------- legend -------------------
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,12);
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 
// Display the graph
$graph->Stroke();
?>                           