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
$cm=1;
$id="d".$cm;
while (!$_GET[$id])
{
 $cm++; $id="d".$cm;
}

$start=$cm;
$id="d".$cm;
while ($_GET[$id])
{
 $id=$cm;
 if ($_GET[$id] || $_GET[$id]==0) $dat[$cm-$start]=$id;
 $id="s".$cm;
 if ($_GET[$id] || $_GET[$id]==0) $data1[$cm-$start]=$_GET[$id]*1;
 $id="d".$cm;
 if ($_GET[$id] || $_GET[$id]==0) $data2[$cm-$start]=$_GET[$id]*1;
 $id="n".$cm;
 if ($_GET[$id] || $_GET[$id]==0) $data3[$cm-$start]=$_GET[$id]*1;
 $cm++;
 $id="d".$cm;
}

for ($y=0;$y<$cm;$y++)
{
 //echo $y.' '.$dat[$y].' '.$data2[$y].' '.$data1[$y].'<br>';
}

$graph = new Graph(1200,350,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$barplot=new BarPlot($data1);
$barplot->SetFillColor("red");
//$barplot2=new BarPlot($data2);
//$barplot2->SetFillColor("blue");
$barplot3=new BarPlot($data3);
$barplot3->SetColor("black");

//$graph->SetScale("textlin",0,0.045);
$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();

$barplot->value->SetFont(FF_ARIAL,FS_NORMAL,10); 
//$barplot2->value->SetFont(FF_ARIAL,FS_NORMAL,10); 
$barplot3->value->SetFont(FF_ARIAL,FS_NORMAL,10); 

$graph->title->Set("Индивидуальное потребление тепловой энергии (ГКал)");

// Add the plot to the graph
$graph->img->SetMargin(3,8,20,25);
//----------- title --------------------
//$barplot->value->Show();
//$barplot2->value->Show();
$name='Теплопотребление квартиры по площади       ';
//$name2='Теплопотребление квартиры по стоякам        ';
$name3='Индивидуальное теплопотребление        ';

//$barplot3->value->Show();
//$barplot->value->SetFormat('%.2f');
//$barplot2->value->SetFormat('%.2f');
$barplot->SetLegend($name);
//$barplot2->SetLegend($name2);
$barplot3->SetLegend($name3);

$gbplot  = new GroupBarPlot (array($barplot,$barplot3)); 
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