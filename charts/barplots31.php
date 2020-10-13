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
$id="tm".$cm;
while ($_GET[$id])
{
 if ($_GET[$id] || $_GET[$id]==0) $dat[$cm]=$_GET[$id];
 $id="x".$cm.'n';
 if ($_GET[$id] || $_GET[$id]==0) $data1[$cm]=$_GET[$id]*1;
 $cm++;
// echo $cm.' '.$dat[$cm].' '.$data1[$cm].'<br>';
 $id="tm".$cm;
}

for ($y=0;$y<18;$y++)
{
 //echo $y.' '.$dat[$y].' '.$data1[$y].'<br>';
}

$graph = new Graph(890,300,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$barplot=new BarPlot($data1);
$barplot->SetFillColor("blue");

//$graph->SetScale("textlin",0,0.045);
$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();

$barplot->value->SetFont(FF_ARIAL,FS_NORMAL,10); 

if ($_GET["type"]==1) $graph->title->Set("Индивидуальное потребление тепловой энергии (ГКал)");
if ($_GET["type"]==2) $graph->title->Set("Индивидуальное потребление холодной воды (ГКал)");
if ($_GET["type"]==3) $graph->title->Set("Индивидуальное потребление горячей воды (ГКал)");
if ($_GET["type"]==4) $graph->title->Set("Индивидуальное потребление электроэнергии (ГКал)");

// Add the plot to the graph
$graph->img->SetMargin(3,8,20,25);
//----------- title --------------------
//$barplot->value->Show();
//$barplot2->value->Show();
$name='Теплопотребление квартиры по площади       ';
$name2='Теплопотребление квартиры по стоякам        ';
$name3='Индивидуальное теплопотребление        ';
$graph->Add($barplot);
$barplot->value->Show();
//----------- legend -------------------
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,12);
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 
// Display the graph
$graph->Stroke();
?>                           