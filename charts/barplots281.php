<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_line.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_bar.php");
include("config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
//------------------------------------------------------------------------
$cm=1;  $id="dat".$cm;
while ($_GET[$id])
{
 $id="dat".$cm;
 if ($_GET[$id] || $_GET[$id]==0) $dats[$cm-1]=$_GET[$id];
 $id="da".$cm;
 if ($_GET[$id] || $_GET[$id]==0) $datas2[$cm-1]=$_GET[$id]*1;
 $id="db".$cm;
 if ($_GET[$id] || $_GET[$id]==0) $datas1[$cm-1]=$_GET[$id]*1;
 $id="dc".$cm;
 if ($_GET[$id] || $_GET[$id]==0) $datas0[$cm-1]=$_GET[$id]*1;
 $cm++;
 $id="dat".$cm;
}
$cm--;
for ($rr=0; $rr<$cm; $rr++) 
	{ 
	 $data2[$cm-$rr-1]=$datas2[$rr]; 
	 $data0[$cm-$rr-1]=$datas0[$rr]; 
	 $data1[$cm-$rr-1]=$datas1[$rr]; 
	 $dat[$cm-$rr-1]=$dats[$rr]; 
//	 echo $data2[$cm-$rr-1].' '.$data0[$cm-$rr-1].' '.$data1[$cm-$rr-1].' '.$dat[$cm-$rr-1].'<br>';
	}

if ($_GET["size"]=='') $graph = new Graph(700,250,"auto");
else $graph = new Graph($_GET["size"],250,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data2);
$lineplot->SetFillColor("red");
$lineplot2=new BarPlot($data1);
$lineplot2->SetFillColor("blue");

$lineplot->SetWidth(0.8);
$lineplot2->SetWidth(0.8);

$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');

$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,8); 
if ($_GET["n1"]==1) $graph->title->Set("Заказы");
if ($_GET["n1"]==2) $graph->title->Set("Доход");

// Add the plot to the graph
$graph->img->SetMargin(38,8,33,25);
//----------- title --------------------
$lineplot2->value->Show();
$lineplot->value->Show();

if ($_GET["n1"]==1)
   {
    $name='Всего заказов     ';
    $name2='Доставленных     ';
   }
if ($_GET["n1"]==2)
   {
    $name='Сумма заказов     ';
    $name2='Доход             ';
   }

$graph ->legend->Pos( 0.03,0.01,"right" ,"top");
$lineplot->SetLegend($name);
$lineplot2->SetLegend($name2);

$lineplot->value->Show();     $lineplot->value->SetFormat('%d');
$lineplot2->value->Show();    $lineplot2->value->SetFormat('%d');
$gbplot  = new GroupBarPlot (array($lineplot, $lineplot2)); 
$graph->Add($gbplot);
$gbplot->SetWidth(0.8);

//----------- legend -------------------
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 
// Display the graph
$graph->Stroke();
?>