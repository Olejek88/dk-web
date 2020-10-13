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
for ($cn=11;$cn>=0;$cn--)
{
 $id="dat".$cn;
 if ($_GET[$id] || $_GET[$id]==0) $dat[$cm]=$_GET[$id];
 $id="datas".$cn;
 if ($_GET[$id] || $_GET[$id]==0) $data1[$cm]=$_GET[$id]*1;
 $id="datad".$cn;
 if ($_GET[$id] || $_GET[$id]==0) $data2[$cm]=$_GET[$id]*1;
 $data0[$cm]=0.0322;
 $cm++;
}

for ($y=0;$y<7;$y++)
{
 //echo $y.' '.$dat[$y].' '.$data2[$y].' '.$data1[$y].'<br>';
}

$graph = new Graph(800,350,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$barplot=new BarPlot($data1);
$barplot->SetFillColor("red");
$barplot2=new BarPlot($data2);
$barplot2->SetFillColor("blue");
$barplot3=new LinePlot($data0);
$barplot3->SetColor("green");
$barplot3->SetWeight(3);

$graph->SetScale("textlin",0,0.045);
$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();

$barplot->value->SetFont(FF_ARIAL,FS_NORMAL,10); 
$barplot2->value->SetFont(FF_ARIAL,FS_NORMAL,10); 
$barplot3->value->SetFont(FF_ARIAL,FS_NORMAL,10); 
if ($_GET["type"]==4) $graph->title->Set("Потребление электроэнергии (кВт)");
if ($_GET["type"]==2) $graph->title->Set("Потребление холодной воды (м3)");
if ($_GET["type"]==3) $graph->title->Set("Потребление горячей воды (м3)");
if ($_GET["type"]==1) $graph->title->Set("Удельное потребление тепловой энергии (ГКал)");

// Add the plot to the graph
$graph->img->SetMargin(3,8,20,25);
//----------- title --------------------
$barplot->value->Show();
$barplot2->value->Show();
$name='Удельное теплопотребление квартиры        ';
$name2='Среднее удельное теплопотребление по дому        ';
$name3='Нормативное теплопотребление        ';

//$barplot3->value->Show();
$barplot->value->SetFormat('%.4f');
$barplot2->value->SetFormat('%.4f');
$barplot->SetLegend($name);
$barplot2->SetLegend($name2);
$barplot3->SetLegend($name3);

$gbplot  = new GroupBarPlot (array($barplot,$barplot2)); 
$graph ->legend->Pos( 0.03,0.06,"right" ,"top");

$graph->Add($gbplot);
$graph->Add($barplot3);
$gbplot->SetWidth(0.65);

//----------- legend -------------------
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,12);
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 
// Display the graph
$graph->Stroke();
?>                           