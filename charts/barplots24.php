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
$today=getdate();
for ($cn=0;$cn<25;$cn++)
{
 $nn='dat'.$cn;
 $nn1='data1'.$cn;
 $nn2='data2'.$cn;
 $nn3='data3'.$cn;
 $dat[$cn]=$_GET[$nn];
 $data11[$cn]=$_GET[$nn1];
 $data12[$cn]=$_GET[$nn2];
 $data13[$cn]=$_GET[$nn3];
}

$graph = new Graph(600,250,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
if ($_GET["type"]==1 || $_GET["type"]==3)
{
$lineplot1=new BarPlot($data11);
$lineplot1->SetFillColor("blue");
$lineplot2=new BarPlot($data12);
$lineplot2->SetFillColor("indianred");
$lineplot3=new BarPlot($data13);
$lineplot3->SetFillColor("green");
}
else
{
$lineplot1=new BarPlot($data11);
$lineplot1->SetFillColor("blue");
$lineplot2=new BarPlot($data12);
$lineplot2->SetFillColor("indianred");
}

$graph ->legend->Pos( 0.02,0.07,"right" ,"top");
if ($_GET["type"]==1)
{
 $lineplot1->SetLegend("dH1");
 $lineplot2->SetLegend("dH2");
 $lineplot3->SetLegend("dH3");
}
if ($_GET["type"]==2)
{
 $lineplot1->SetLegend("dH1");
 $lineplot2->SetLegend("dH2");
}
if ($_GET["type"]==3)
{
 $lineplot1->SetLegend("dQ1");
 $lineplot2->SetLegend("dQ2");
 $lineplot3->SetLegend("dQ3");
}

$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
if ($_GET["type"]==1) $graph->title->Set("Анализ разницы энтальпий по этажам (кДж)");
if ($_GET["type"]==2) $graph->title->Set("Анализ разницы тепловых энергий КМ-ИРП и КМ-БИТ");
if ($_GET["type"]==3) $graph->title->Set("Анализ разницы тепловых энергий по этажам");

// Add the plot to the graph
$graph->img->SetMargin(25,28,33,25);

//----------- title --------------------
if ($_GET["type"]==1 || $_GET["type"]==3)$gbplot  = new GroupBarPlot (array($lineplot1,$lineplot2,$lineplot3)); 
if ($_GET["type"]==2) $gbplot  = new GroupBarPlot (array($lineplot1,$lineplot2)); 
$graph->Add($gbplot);
if ($_GET["type"]==1 || $_GET["type"]==3)
//----------- legend -------------------
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 
// Display the graph
$graph->Stroke();
?>